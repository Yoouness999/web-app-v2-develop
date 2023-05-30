<?php namespace App\Handlers\Events;

use App\Events\PickupUpdateEvent;
use App\Api;

use App\Exceptions\PaymentErrorException;
use App\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PickupUpdateHandler
{

    /**
     * Create the event handler.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PickupUpdateEvent $event
     * @return void
     * @throws \Exception
     */
    public function handle(PickupUpdateEvent $event)
    {
        $pickup = $event->newPickup;
        $oldPickup = $event->oldPickup;
        $dateUpdated = $event->dateUpdated;
        $user = $oldPickup->user;

        $oldInvoices = Invoice::query()->where('pickup_id', '=', $oldPickup->id)
                        ->whereIn('status', [Invoice::STATUS_QUEUED, Invoice::STATUS_PAID, Invoice::STATUS_UNPAID])
                        ->where('type', Invoice::TYPE_DELIVERY)
                        ->orderBy('created_at')
                        ->get();
        $paidAmount = 0.0;
        $paidAmountDescription = '';
        $oldInvoiceToUpdate = null;
        foreach ($oldInvoices as $oldInvoice) {
            if ($oldInvoice->status == Invoice::STATUS_UNPAID) {
                $oldInvoice->status = Invoice::STATUS_CANCELLED;
                $oldInvoice->save();
            } else {
                $paidAmount += $oldInvoice->total;
                $paidAmountDescription .= lg("invoice.Order n°") . $oldInvoice->number .' REF#' . $oldInvoice->id . ' ('. number_format($oldInvoice->total, 2, ',', '.') . ' €)' . '<br />';
                $oldInvoiceToUpdate = $oldInvoice;
            }
        }
        
        $invoice = null;
        $toBePaid = false;
        $today = Carbon::today();
        $today->setTime(0, 0);
        if ($pickup) {
            $newPrice = $pickup->getDeliveryPrice();
            $rescheduleFee = 0;
            if ($dateUpdated) {
                $oldPickupDate = Carbon::createFromFormat('Y-m-d H:i:s', $oldPickup->pickup_date);
                $oldPickupDate->setTime(0, 0);
                

                $daysDiff = $today->diffInDays($oldPickupDate);
                $oldVolme = ($oldPickup->volume_m3) ? $oldPickup->volume_m3 : 0;
                $oldPrice = ($oldInvoiceToUpdate == null)? 0 : $oldInvoiceToUpdate->price;
                
                if (($oldVolme > 0 && $oldVolme <= 6 && $daysDiff <= 2) ||
                    ($oldVolme > 6 && $oldVolme <= 10 && $daysDiff <= 3) ||
                    ($oldVolme > 10 && $oldVolme <= 15 && $daysDiff <= 4) ||
                    ($oldVolme > 15 && $daysDiff <= 7)) {
                    $rescheduleFee = $oldPrice * 0.30;
                }
                $newPrice += $rescheduleFee;
            }

            //New Invoice if alread paid amount is less than the new amount
            if ($newPrice > $paidAmount || $oldInvoiceToUpdate == null) {
                $invoice = new Invoice();
                $invoice->type = Invoice::TYPE_DELIVERY;
                if ($oldInvoiceToUpdate) {
                    $invoice->ref_invoice_id = $oldInvoiceToUpdate->id;
                }
                
                $invoice->title = lg('invoice.description.delivery') . ' (' . $pickup->pickup_date->format('d/m/Y') . ')';
                $invoice->content = $pickup->getDeliveryPriceDescription();

                if ($dateUpdated) {
                    if ($rescheduleFee > 0) {
                        $invoice->content .= "Reshcedule - ". $today->format('d/m/Y') ." (". number_format(($rescheduleFee/1.21), 2, ',', '.') ."€)";
                    } else {
                        $invoice->content .= "Reshcedule - ". $today->format('d/m/Y') ." (free)";
                    }
                }
                $invoice->price = $newPrice;
                $invoice->user_id = $user->id;
                $invoice->pickup_id = $pickup->id;
                $invoice->status = Invoice::STATUS_QUEUED;

                if ($paidAmount > 0) {
                    $invoice->no_vat_price = ($paidAmount * -1);
                    $invoice->no_vat_content = $paidAmountDescription;
                }

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
                $toBePaid = true;
            } else {
                $oldInvoiceToUpdate->title = lg('invoice.description.delivery') . ' (' . $pickup->pickup_date->format('d/m/Y') . ')';
                $oldInvoiceToUpdate->content = $pickup->getDeliveryPriceDescription();

                if ($dateUpdated) {
                    $oldInvoiceToUpdate->content .= "Reshcedule - ". $today->format('d/m/Y') ." (free)";
                }

                $oldInvoiceToUpdate->user_id = $user->id;
                $oldInvoiceToUpdate->pickup_id = $pickup->id;

                if ($user->isIban()) {
                    $oldInvoiceToUpdate->billing_method = 'sepa';
                } else {
                    $oldInvoiceToUpdate->billing_method = 'creditcard';
                }
                $oldInvoiceToUpdate->save();
                $oldInvoiceToUpdate->total = $oldInvoiceToUpdate->price + $oldInvoiceToUpdate->no_vat_price;
                if ($oldInvoiceToUpdate->total < 0) {
                    $oldInvoiceToUpdate->total = 0;
                }
                $oldInvoiceToUpdate->save();
            }
        } else {
            $pickup = $oldPickup;
        }

        $dataToBind = [
            'first_name' => $user->first_name,
            'pickup_date' => date('d/m/Y', strtotime($pickup->pickup_date)),
            'pickup_time' => date('H', strtotime($pickup->pickup_date)) . ':00' . ' - ' . (date('H', strtotime($pickup->pickup_date)) + 2) . ':00',
            'pickup_address' => $pickup->address,
            'floor' => $pickup->floor,
            'parking' => ($pickup->parking == 1) ? lg('order.services.answers.yes') : lg('order.services.answers.no')
        ];

        $emailTitle = lg('email.template.delivery.update.title', null, [], $user->lang);
        $emailContent = shortcode(lg('email.template.delivery.update.content', null, [], $user->lang), $dataToBind, ['nl2br' => false]);
        
            /**
         * Make Payment attempt
         */
        try {
            if ($toBePaid) {
                Api::makePayment($user, $invoice);
            }
            
            Api::sendUserNotification($emailContent, $user['email'], $emailTitle);
            Api::sendAdminNotification($emailContent, 'order@boxify.be', $emailTitle . ' [USER#'.$user->id.']');
        } catch (\Exception $e) {
            \Log::error($e);
            //if ($pickup) {
            //    $pickup->cancel();
            //}

            if ($toBePaid) {
                Api::sendAdminNotification(
                    "Error payment attempt #".$invoice->id,
                    env("DEV_EMAIL", "product@boxify.be"),
                    "Error payment attempt #".$invoice->id
                );
            } else {
                Api::sendAdminNotification(
                    "Error PickupUpdateHandler",
                    env("DEV_EMAIL", "product@boxify.be"),
                    $e->getMessage()
                );
            }

            throw new PaymentErrorException();
        }
    }

}
