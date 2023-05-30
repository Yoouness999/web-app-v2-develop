<?php namespace App\Handlers\Events;

use App\Api;
use App\Events\AdyenNotificationEvent;

use App\Invoice;
use App\User;
use App\WebhookAdyenLogger;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class AdyenNotificationHandler
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
     * Handle the AdyenNotification
     *
     * @example :
     *
     *
     * {"originalReference":"","reason":"97079:3335:08/2018","additionalData_authCode":"97079","additionalData_expiryDate":"08/2018","additionalData_cardSummary":"3335","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"mc","currency":"EUR","pspReference":"8835185152538298","merchantReference":"recurring-144-1518515253","value":"1000","live":"false","eventDate":"2018-02-13T09:47:33.37Z"}
     *
     * {"originalReference":"","reason":"Refused","additionalData_expiryDate":"12/2019","additionalData_cardSummary":"3471","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"","success":"false","paymentMethod":"visa","currency":"EUR","pspReference":"8835222296683670","merchantReference":"card-2-1522229668","value":"0","live":"false","eventDate":"2018-03-28T09:34:28.44Z"}
     *
     * {"originalReference":"","reason":"Refused","additionalData_expiryDate":"10/2019","additionalData_cardSummary":"2214","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"","success":"false","paymentMethod":"mc","currency":"EUR","pspReference":"8825246703096418","merchantReference":"card-188-1524670280","value":"0","live":"false","eventDate":"2018-04-25T15:31:49.80Z"}
     *
     *
     * {"originalReference":"","reason":"","additionalData_sepadirectdebit_mandateId":"8815208504010610","additionalData_sepadirectdebit_dateOfSignature":"2018-03-12","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"sepadirectdebit","currency":"EUR","additionalData_sepadirectdebit_sequenceType":"First","pspReference":"8815208504010610","merchantReference":"sepa-173-1520850400","value":"1","live":"false","eventDate":"2018-03-12T12:15:34.95Z"}
     *
     *
     *
     * @param  AdyenNotificationEvent $event
     * @return bool
     */
    public function handle(AdyenNotificationEvent $event)
    {
        $data = $event->data;

        $webhookAdyenLogger = new WebhookAdyenLogger();
        $webhookAdyenLogger->data = json_encode($data);
        $webhookAdyenLogger->save();

        try {

            $ref = $data['merchantReference'];

            $refs = explode('-', $ref);

            if (isset($data['eventCode']) && $data['eventCode'] === 'REPORT_AVAILABLE') {
                return false;
            }

            if (count($refs) == 3) {
                list($type, $user_id, $id) = explode('-', $ref);
            } else {
                return false;
            }

            if ($type === 'invoice') {

                /**
                 * @var $invoice Invoice
                 */
                $invoice = Invoice::where('id', $id)->where('user_id', $user_id)->first();

                if ($invoice) {

                    if (
                        isset($data['eventCode']) && $data['eventCode'] == "CHARGEBACK"
                        ||
                        (isset($data['eventCode']) && (in_array($data['eventCode'], [
                                'AUTHORISATION'
                            ])) &&
                            isset($data['success']) && !$data['success'])
                        ||
                        (isset($data['eventCode']) && (in_array($data['eventCode'], [
                                'AUTHORISATION'
                            ])) &&
                            isset($data['success']) && $data['success'] == 'false')

                    ) {
                        if (!in_array($invoice->status, [Invoice::STATUS_REFUNDED, Invoice::STATUS_TO_REFUND])) {
							// Adyen send sometimes 2 times the same exact notification, we should only count the first. TODO : add an interval of date and not a check at the second.
                            
							if ($invoice->last_attempt_at != date('Y-m-d H:i:s')) {
                                if ($invoice->status == Invoice::STATUS_PAID) {
                                    //This is if customer chargback after te successful payment
                                    $invoice->last_attempt_at = $invoice->payment_date;
                                    $invoice->status = Invoice::STATUS_UNPAID;
                                    $invoice->incrementPaymentAttemptAndUpdateTotal();
                                    $invoice->save();
                                } else {
                                    $invoice->status = Invoice::STATUS_UNPAID;
                                    $invoice->last_attempt_at = date('Y-m-d H:i:s');
                                    $invoice->save();
                                }
								
                                //TODO-HM: commented out the attempt fee code. To be decided if this code needs to be here or not.
								/*$invoice->attempt++;

								if ($invoice->attempt == 3) {
									$fee = lg('fees.3_attempt_fee');
									$invoice->price += $fee['price'];
									$invoice->content .= "- " . $fee['description'] . "<br />";
								} elseif ($invoice->attempt == 4) {
									$fee = lg('fees.4_attempt_fee');
									$invoice->price += $fee['price'];
									$invoice->content .= "- " . $fee['description'] . "<br />";
								} elseif ($invoice->attempt == 5) {
									$fee = lg('fees.5_attempt_fee');
									$invoice->price += $fee['price'];
									$invoice->content .= "- " . $fee['description'] . "<br />";
								} elseif (!($invoice->attempt % 6)) {
									$fee = lg('fees.%6_attempt_fee');
									$invoice->price += $fee['price'];
									$invoice->content .= "- " . $fee['description'] . "<br />";
								}*/

								$invoice->save();
							} else {
								\Log::info('Adyen notification sent 2 times', $data);
							}
                        }

                    } elseif (
                        isset($data['eventCode']) && (in_array($data['eventCode'], [
                            'AUTHORISATION'
                        ])) &&
                        isset($data['success']) && $data['success']
                    ) {
                        $invoice->status = Invoice::STATUS_PAID;
                        $invoice->payment_date = date('Y-m-d H:i:s');
                        $invoice->validation_payment_date = date('Y-m-d H:i:s');
                        $invoice->save();
                        $invoice->generateNumber(true, true);
                    } elseif (
                        isset($data['eventCode']) && (in_array($data['eventCode'], [
                            'REFUND'
                        ])) &&
                        isset($data['success']) && $data['success']
                    ) {
                        $invoice->status = Invoice::STATUS_REFUNDED;
                        $invoice->payment_date = date('Y-m-d H:i:s');
                        $invoice->save();
                        $invoice->generateNumber(true, false);

                    } else {
                        Api::sendAdminNotification('UNKNOWN CODE for ref ' . $ref . ' invoice not found :<br />' . json_encode($data), 'product@boxify.be');
                        Api::sendAdminNotification('UNKNOWN CODE for ref ' . $ref . ' invoice not found :<br />' . json_encode($data));
                    }

                } else {
                    Api::sendAdminNotification('Payment success but ref ' . $ref . ' invoice not found :<br />' . json_encode($data));
                }

            } elseif ($type == 'test') {
                return true;
            } elseif ($type == 'card') {

                $user = User::find($user_id);

                if (!$user) {
                    Throw new Exception('User not found');
                }

                # Update user billing status
                if (isset($data['success'])) {
                    if ($data['success']) {
                        $user->billing_status = User::BILLING_STATUS_PAID;
                        $user->save();
                    } else {
                        $user->billing_status = User::BILLING_STATUS_UNPAID;
                        $user->save();
                    }
                }

            } elseif ($type == 'sepa') {

                $user = User::find($user_id);

                if (!$user) {
                    Throw new Exception('User not found');
                }

                # Update user billing status
                if (isset($data['success'])) {
                    if ($data['success']) {
                        $user->billing_status = User::BILLING_STATUS_PAID;
                        $user->save();
                    } else {
                        $user->billing_status = User::BILLING_STATUS_UNPAID;
                        $user->save();
                    }
                }

            } else {
                Api::sendAdminNotification('Payment ref type not recognized :<br />' . json_encode($data), 'product@boxify.be');
                Api::sendAdminNotification('Payment ref type not recognized :<br />' . json_encode($data));
                return false;
            }

        } catch (Exception $e) {
            \Log::error($e);
            Api::sendAdminNotification('Payment notification error exception : <br />' . json_encode($data));
        }
    }
}
