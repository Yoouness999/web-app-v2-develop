<?php namespace App\Handlers\Events;

use App\Api;
use App\Events\ItemPickupAskEvent;

use App\Exceptions\PaymentErrorException;
use App\Invoice;
use Exception;
use Mail;

class ItemPickupAskHandler
{


    /**
     * Handle the event.
     *
     * @param  ItemPickupAskEvent $event
     * @return void
     */
    public function handle(ItemPickupAskEvent $event)
    {
        $pickup = $event->pickup;
        $user = $event->user;

        /**
         * Generate an invoice
         *
         * @see https://docs.google.com/document/d/16TxOv75-HacjNkQX88jaooq93zoW1vjqyPa0gY0x26M/edit#heading=h.yhxa5xwiog0w
         */
        $invoice = new Invoice();
        $invoice->type = Invoice::TYPE_DELIVERY;
        $invoice->title = lg('invoice.description.delivery') . ' (' . $pickup->pickup_date->format('d/m/Y') . ')';
        $invoice->content = $pickup->getDeliveryPriceDescription();
        $invoice->price = $pickup->getDeliveryPrice();
        $invoice->user_id = $user->id;
        $invoice->pickup_id = $pickup->id;
        $invoice->status = Invoice::STATUS_QUEUED;
        if ($user->isIban()) {
            $invoice->billing_method = 'sepa';
        } else {
            $invoice->billing_method = 'creditcard';
        }
        $invoice->save();
        $invoice->total = $invoice->price + $invoice->no_vat_price;
        if ($invoice->total < 0) {
            $invoice->total = 0;
        }
        $invoice->save();
        $invoice->generateNumber(true, true);

        $items = $pickup->itemsRecords()->get();
        $dataToBind = [
            'first_name' => $user->first_name,
            'pickup_date' => date('d/m/Y', strtotime($pickup->pickup_date)),
            'pickup_time' => date('H', strtotime($pickup->pickup_date)) . ':00' . ' - ' . (date('H', strtotime($pickup->pickup_date)) + 2) . ':00',
            'pickup_address' => $pickup->address,
            'floor' => $pickup->floor,
            'parking' => ($pickup->parking == 1) ? lg('order.services.answers.yes') : lg('order.services.answers.no'),
            'url' => ROOT_URL,
            'items_size' => $items->count()
        ];

        $emailTitle = lg('email.template.delivery.create.title', null, [], $user->lang);
        $emailContent = shortcode(lg('email.template.delivery.create.content', null, [], $user->lang), $dataToBind, ['nl2br' => false]);

        try {
            Api::makePayment($user, $invoice);

            Api::sendUserNotification($emailContent, $user['email'], $emailTitle);
            Api::sendAdminNotification($emailContent, 'order@boxify.be', $emailTitle . ' [USER#'.$user->id.']');

        } catch (Exception $e) {
            \Log::error($e);

            if ($invoice && $invoice->id) {
                Api::sendAdminNotification(
                    "Error payment attempt #".$invoice->id,
                    env("DEV_EMAIL", "product@boxify.be"),
                    "Error payment attempt #".$invoice->id
                );
            } else {

                Api::sendAdminNotification(
                    "Error ItemPickupAskHandler",
                    env("DEV_EMAIL", "product@boxify.be"),
                    $e->getMessage()
                );
            }
            $pickup->cancel();
            throw new PaymentErrorException();
        }
    }

}
