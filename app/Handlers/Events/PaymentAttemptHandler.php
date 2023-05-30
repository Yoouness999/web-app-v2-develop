<?php namespace App\Handlers\Events;

use App\Events\PaymentAttemptEvent;

use App;
use App\Api;
use App\Invoice;
use App\Item;
use \Input;
use \Log;
use App\User;
use Exception;

/**
 * Class PaymentAttemptHandler
 *
 * @deprecated Don't used anymore
 * @package App\Handlers\Events
 */
class PaymentAttemptHandler
{

    /**
     * Create the event handler.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentAttemptEvent $event
     * @return array
     * @throws Exception
     */
    public function handle(PaymentAttemptEvent $event)
    {
        $date = null;

        $confirm = $event->confirm;
        $user = $event->getUser();
        $testmode = $event->testmode;

        $logs = [
            'invoices' => [],
            'messages' => []
        ];

        if ($event->date) {
            $date = $event->date;
        }


        if ($date) {
            $now = strtotime($date);
        } else {
            $now = strtotime('now');
        }

        $first_day_of_this_month = new \DateTime(date('Y-m-d H:i:s', $now));
        $first_day_of_this_month->modify('first day of this month');
        $last_day_of_this_month = new \DateTime(date('Y-m-d H:i:s', $now));
        $last_day_of_this_month->modify('last day of this month');

        $invoices = Invoice::where('status', '=', Invoice::STATUS_UNPAID);


        #1. Check for unpaid invoices
        if ($user && !$event->all) {
            $invoices = $invoices->where('user_id', $user->id);
        }

        if (!$testmode) {
            $invoices = $invoices->whereHas('user', function ($query) {
                $query->where('billing_env', 'production');
            })->get();
        } else {
            $invoices = $invoices->get();
        }

        $logs['invoices'] = $invoices;
        $today = new \DateTime('today');
        foreach ($invoices as $key => $invoice) {

            $shouldAttempt = false;

            # Check if we need to make an invoice attempt for the month
            
            if ($invoice->last_attempt_at) {
                $lastAttempDate = new \DateTime($invoice->last_attempt_at);
                $diffDays = $today->diff($lastAttempDate)->days;
                if (($invoice->attempt < 5 && $diffDays >= 7) ||
                    ($invoice->attempt >= 5 && $invoice->attempt < 7 && $diffDays >= 30)) {
                    $shouldAttempt = true;
                }
            } else {
                $createDate = new \DateTime($invoice->created_at);
                $diffDays = $today->diff($createDate)->days;
                if (($invoice->attempt == 1 && $diffDays >= 7) ||
                    ($invoice->attempt == 2 && $diffDays >= 14) ||
                    ($invoice->attempt == 3 && $diffDays >= 21) ||
                    ($invoice->attempt == 4 && $diffDays >= 28) ||
                    ($invoice->attempt == 5 && $diffDays >= 60) ||
                    ($invoice->attempt == 5 && $diffDays >= 90) ||
                    ($invoice->attempt == 0)) {
                    $shouldAttempt = true;
                }
            }

            if ($shouldAttempt) {

                $user = User::find($invoice->user_id);

                if ($user->lang !== app()->getLocale()) {
                    \App::setLocale($user->lang ?: \App::getLocale());
                    \Label::getAll('refresh');
                }

                if ($confirm) {

                    try {

                        if ($testmode && isset($event->mockPayment->errors)) {
                            $invoice->attempt++;
                            $invoice->last_attempt_at = date('Y-m-d H:i:s');

                            Throw new App\Exceptions\PaymentErrorException();
                        } elseif ($testmode && isset($event->mockPayment->data)) {
                            $creditResponse = true;
                        } else {
                            $creditResponse = Api::makePayment($user, $invoice);
                        }

                        $invoices[$key] = $invoice;

                        if ($creditResponse) {

                            /**
                             * @var $invoice Invoice
                             */
                            $invoice->status = Invoice::STATUS_PAID;
                            $invoice->payment_date = date('Y-m-d H:i:s');
                            $invoice->save();

                            $invoice->generateNumber(true, false);

                            Log::info('Invoice payment ' . $invoice->id . ' success', \Arr::toArray($creditResponse));
                            //$logs[] = "Invoice successfully paid " . $invoice->id;

                            // Send a mail to user

                            $data = \DM()->getBySlug('/mail/monthly-billing', ['format' => 'array'], $user->lang);

                            $dataMail = [
                                'user' => $user->toArray(),
                                'invoice' => $invoice->toArray(),
                                'billing_date' => date('d/m/Y')
                            ];

                            $content = shortcode($data['content'], $dataMail);
                            $subject = shortcode($data['title'], $dataMail);

                            Api::sendUserNotification($content, $user, $subject);

                            $content .= "<br />**Mail Copy for the admin**<br />";
                            $content .= "<a href=\"" . url('download/pdf/' . $invoice->id) . "\">- Admin link to invoice</a>";

                            try {
                                Api::sendAdminNotification($content, null, 'Invoice Success notification (admin Boxify)');
                            } catch (Exception $e) {

                            }

                        } else {
                            Throw new Exception();
                        }

                    } catch (App\Exceptions\PaymentErrorException $e) {

                        /**
                         * Add fee if payment attempt has failed (should trigger explicitly PaymentErrorException instead of Exception !)
                         *
                         * @see
                         */
                        $invoice->last_attempt_at = date('Y-m-d H:i:s');
                        $invoice->incrementPaymentAttemptAndUpdateTotal();

                        # Send error billing message to user
                        $data = \DM()->getBySlug('/mail/error-billing', ['format' => 'array'], $user->lang);

                        $dataMail = [
                            'user' => $user->toArray(),
                            'invoice' => $invoice->toArray(),
                            'billing_date' => date('d/m/Y'),
                            'days_before_next_attempt' => $invoice->getNextAttemptDays()
                        ];

                        $content = shortcode($data['content'], $dataMail);
                        $subject = shortcode($data['title'], $dataMail);

                        Api::sendUserNotification($content, $user, $subject);

                        $content .= "<br />**Mail Copy for the admin**<br />";
                        $content .= "<a href=\"" . url('download/pdf/' . $invoice->id) . "\">- Admin link to invoice</a>";

                        try {
                            Api::sendAdminNotification($content, 'backup@boxify.be', 'Invoice Error notification for admin boxify');
                            Api::sendAdminNotification($content, 'product@boxify.be', 'Invoice Error notification for admin boxify');
                        } catch (Exception $e) {

                        }

                    } catch (Exception $e) { // End catch payment error
                        Log::info('Payment unknown error');
                        Log::error($e);
                        $invoice->last_attempt_at = date('Y-m-d H:i:s');
                        $invoice->save();
                        Api::sendAdminNotification($e->getMessage(), env('REDIRECT_EMAIL', 'backup@boxify.be'), 'Invoice Error notification for admin boxify');
                        Api::sendAdminNotification($e->getMessage(), env('REDIRECT_EMAIL', 'product@boxify.be'), 'Invoice Error notification for admin boxify');
                    }
                } else {
                    $logs['messages'][] = "Will invoice unpaid #{$invoice->id} {$invoice->total}€ to user #" . $invoice->user_id . "<br />";
                }
            } else { // End condition should invoice
                unset($logs['invoices'][$key]); // Remove invoice from the log
            }
        }

        return $logs;
    }
}
