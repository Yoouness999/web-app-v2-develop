<?php namespace App\Handlers\Events;

use App\Adyen;
use App\Api;
use App\CouponUser;
use App\Events\MonthlyUserInvoiceEvent;

use App\Invoice;
use App\Item;
use App\OrderBooking;
use App\Pickup;
use App\User;
use Carbon\Carbon;
use Exception;
use Log;

class MonthlyUserInvoiceHandler
{

    const FAKE_STATUS_PAID = 'paid';
    const FAKE_STATUS_UNPAID = 'unpaid';


    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Handle the event.
     *
     * @param  MonthlyUserInvoiceEvent $event
     * @return array
     */
    public function handle(MonthlyUserInvoiceEvent $event)
    {
        global $cp_debug;

        $date = $event->date;
        $confirm = $event->confirm;

        /**
         * For testing mode
         *
         * @see \InvoiceProcessTest
         */
        $testmode = $event->testmode;
        $fakePayment = $event->fakePayment;

        $testdata = [];

        $logs = [];

        /**
         * Check all users that have an order_plan_id activated
         */
        $data = Api::usersToInvoice();

        if ($testmode) {
            $data = $data->where('email', 'product@boxify.be');
        }

        if ($date) {
            $now = strtotime($date);
        } else {
            $now = strtotime('now');
        }

        $first_day_of_this_month = strtotime('first day of this month', $now);
        $last_day_of_this_month = strtotime('last day of this month', $now);
        //$first_day_of_the_previous_month = date('Y-m-d', strtotime('first day of previous month', $now));

        $data = $data->get();

        $testdata['user_count'] = $data->count();
        $testdata['users'] = $data->toArray();

        $idsToInvoice = [];

        /**
         * @V2 => price is defined by order_plan_price_per_month in user
         *
         * @var $user User
         */
        foreach ($data as $user) {

            $shouldSkipInvoice = false;

            //les clients désactivés ne doivent pas être facturés
            if ($user->billing_env !== 'production') {
                $shouldSkipInvoice = true;
            }
            //This added to decide on old or new pricing model
            if ($user->end_commitment_period && $user->end_commitment_period < date('Y-m-d H:i:s', $first_day_of_this_month)) {
                $user->recalculateOrderPlanPrice($user->plan);
                $user->old_pricing = 0;
                $user->save();
            }

            // Filter user that doesn't already stock
            $totalVolume = $user->items()
                            ->whereNull('deleted_at')
                            ->whereIn('status', [
                                Item::STATUS_STORED,
                                Item::STATUS_TO_INDEX,
                                Item::STATUS_PICKED_UP,
                                Item::STATUS_ORDERED,
                                Item::STATUS_LOADED,
                                Item::STATUS_TRANSIT,
                                Item::STATUS_INDEXED,
                                Item::STATUS_DROPPED
                            ])
                            ->where('created_at', '<', date('Y-m-d H:i:s', $first_day_of_this_month))
                            ->sum('volume_m3');
            if (!$totalVolume || $totalVolume <= 0) {

                if ($user->end_commitment_period && $user->end_commitment_period > date('Y-m-d H:i:s', $first_day_of_this_month) && $user->pickups && $user->pickups()->where('pickup_date', '<', date('Y-m-d H:i:s', $first_day_of_this_month))->count()) {
                    // Should invoice !
                } else {
                    $shouldSkipInvoice = true;
                }
            }

            /**
             * Add a condition to skip invoice if the prorata = first day of this month OR last day of this month (handle both case)
             */
            if (!$shouldSkipInvoice && $user->invoices()->count()) {

                $invoices = $user->invoices()->get();

                foreach ($invoices as $invoice) {
                    if (preg_match('/prorata \((.*)\/(.*)\/(.*) - (.*)\/(.*)\/(.*)\)/i', $invoice->title, $matches)) {
                        if (count($matches) === 7) {
                            $invoiceDate = $matches[3] .'-'. $matches[2].'-' . $matches[1];
                            if (date('Y-m-d', $first_day_of_this_month) === $invoiceDate) {
                                $shouldSkipInvoice = true;
                            }

                            $invoiceDate = $matches[6] .'-'. $matches[5].'-' . $matches[4];

                            if (date('Y-m-d', $last_day_of_this_month) === $invoiceDate) {
                                $shouldSkipInvoice = true;
                            }
                        }
                    }
                }

                // avoid any bug about
                $invoices = null;
                $invoice = null;
            }

            if ($shouldSkipInvoice) {
                continue;
            }

            if ($user->lang !== app()->getLocale()) {
                \App::setLocale($user->lang ?: \App::getLocale());
                \Label::getAll('refresh');
            }

            $user_id = $user->id;

            /**
             * Generate a invoice
             */
            $invoice = new Invoice();
            $invoice->type = Invoice::TYPE_MONTHLY;
            if ($user->isIban()) {
                $invoice->billing_method = 'sepa';
            } else {
                $invoice->billing_method = 'creditcard';
            }

            $price = $user->getPricePerMonth();

            $priceDescriptions = $user->getPricePerMonthDescription('html');

            /**
             * Generate invoice
             */
            $title = shortcode(lg("invoice.monthly.title", null, [], $user['lang']), [
                'plan' => ($user->plan) ? $user->plan->name : '',
                'date' =>
                    [
                        'start' => date('d/m/Y', $first_day_of_this_month),
                        'end' => date('d/m/Y', $last_day_of_this_month)
                    ]
            ]);

            if ($user['billing_exempted']) {
                $title .= " (" . lg("VAT Excl", "common", [], $user['lang']) . ")";
                $invoice->billing_exempted = $user['billing_exempted'];
            }

            $invoice->title = $title;
            $invoice->user_id = $user_id;

            $content = "<strong>" . $title . "</strong><br />";

            $content .= $priceDescriptions;

            #Generate a ref to avoid duplicate invoice
            $ref = "monthly-" . date('Y-m', $first_day_of_this_month) . '-' . $user->id;

            // Check if user have promocode
            $coupons = CouponUser::where('user_id', $user_id)->where('touse', 1)->get();

            $promoCode = 0;

            foreach ($coupons as $couponUser) {

                $coupon = $couponUser->coupon;

                if ($coupon) {
                    if ($price && $price >= $coupon->promo_applied) {
                        $content .= "- Promocode '" . $coupon->code . "' -" . $coupon->promo_applied . '€' . "<br />";
                        $price = $price - $coupon->promo_applied;

                        $promoCode += $coupon->promo_applied;

                        $couponUser->used = 1;
                        $couponUser->touse = 0;

                        if ($confirm) {
                            $couponUser->save();
                        }

                    } elseif ($price) {
                        $content .= "- Promocode '" . $coupon->code . "' -" . $price . '€' . "<br />";

                        $promoCode += $coupon->promo_applied;

                        $coupon->promo_applied = $coupon->promo_applied - $price;
                        $price = 0;

                        if ($confirm) {
                            $coupon->save();
                        }
                    }
                }
            }

            $invoice->content = $content;

            $invoice->price = $price;
            $invoice->total = $invoice->price;
            $invoice->status = Invoice::STATUS_QUEUED;
            $invoice->payment_schedule = date('Y-m-d');
            $invoice->billing_ref = $ref;

            $alreadyInvoiced = Invoice::where('billing_ref', $ref)->first();

            $willInvoice = !$alreadyInvoiced && $invoice->price;

            $testdata['willinvoice'] = $willInvoice;

            if ($testmode && $willInvoice) {
                $testdata['invoice'] = $invoice->toArray();
            }

            if ($willInvoice && $user['billing_env'] == 'production') {
                $idsToInvoice[$user_id] = [
                    'id' => $user_id,
                    'name' => $user->last_name . ' ' . $user->first_name,
                    'price_per_month' => $invoice->total,
                ];
            }

            $logs[] = [
                'user' => $user->full_name,
                'user_id' => $user->id,
                'user_volume_plan' => str_replace('.', ',', $user->getVolumePlan()),
                'user_env' => $user->billing_env,
                'discount' => str_replace('.', ',', $promoCode),
                'price' => str_replace('.', ',', $invoice->total),
                'will_invoice' => $willInvoice,
                'invoice_title' => $invoice->title,
                'invoice_content' => $invoice->content,
                'email' => $user->email,
                'user_lang' => $user->lang
                //'invoice_id' => $invoice->id,
            ];

            if ($confirm && $invoice->price) {

                try {

                    if ($user['billing_env'] == 'production' || $testmode) {

                        # Make the payment with the registered card
                        if ($willInvoice) {

                            sleep(1);
	                        # Prevent an issue if there is already an invoice in the DB => we skip the doublon
                            $checkInvoice = Invoice::query()->where("billing_ref", $ref)->first();

                            if ($checkInvoice) {
                                continue;
                            }

                            # /!\ invoice is saved only for the production mode !!
                            $invoice->save();

                            /**
                             * Try to generate a payment
                             */
                            try {

                                $creditResponse = [];

                                if ($fakePayment) {
                                    if ($fakePayment == self::FAKE_STATUS_PAID) {
                                        $creditResponse = [];
                                    } else {
                                        Throw new Exception("Fake payment error");
                                    }
                                } else {
                                    $creditResponse = Api::makePayment($user, $invoice);

                                    if (isset($creditResponse->lwError)) {
                                        Throw new Exception('Payment error');
                                    }
                                }


                                // If success
                                $invoice->payment_date = date('Y-m-d H:i:s');
                                $invoice->save();
                                $invoice->generateNumber();

                                try {

                                    //Log::info('Invoice payment ' . $invoice->id . ' success', \Arr::toArray($creditResponse));
                                    $logs[] = "Invoice successfully paid " . $invoice->id;

                                    // Send a mail to user

                                    $data = \DM()->getBySlug('/mail/monthly-billing', ['format' => 'array'], $user->lang);

                                    $dataMail = [
                                        'user' => $user->toArray(),
                                        'invoice' => $invoice->toArray(),
                                        'billing_date' => date('d/m/Y', $first_day_of_this_month)
                                    ];

                                    $content = shortcode($data['content'], $dataMail);
                                    $subject = shortcode($data['title'], $dataMail);

                                    try {
                                        Api::sendUserNotification($content, $user, $subject);
                                    } catch (Exception $e) {
                                        //Log::error($e);
                                    }

                                    $content .= "<br />**Mail Copy for the admin**<br />";
                                    $content .= "<a href=\"" . url('arxmin/modules/boxifymanager/invoices/crud?download=' . $invoice->id . '&action=download') . "\">- Admin link to invoice</a>";

                                    try {
                                        Api::sendAdminNotification($content, 'backup@boxify.be', 'Invoice Success notification (admin Boxify)');
                                    } catch (Exception $e) {
                                        Log::error($e);
                                    }

                                } catch (Exception $e) {
                                    //Log::info('Error sending message payment');
                                   Log::error($e);
                                }

                            } catch (Exception $e) {

                                $invoice->attempt = $invoice->attempt + 1;
                                $invoice->last_attempt_at = date('Y-m-d H:i:s');
                                $days_before_next_attempt = $invoice->getNextAttemptDays();
                                $invoice->status = Invoice::STATUS_UNPAID;
                                $invoice->save();

                                $invoice->generateNumber();

                                # Send error billing message to user
                                $data = \DM()->getBySlug('/mail/error-billing', ['format' => 'array'], $user->lang);


                                $dataMail = [
                                    'user' => $user->toArray(),
                                    'invoice' => $invoice->toArray(),
                                    'billing_date' => date('d/m/Y', $first_day_of_this_month),
                                    'days_before_next_attempt' => $days_before_next_attempt
                                ];

                                $content = shortcode($data['content'], $dataMail);
                                $subject = shortcode($data['title'], $dataMail);

                                Api::sendUserNotification($content, $user, $subject);

                                $content .= "<br />**Mail Copy for the admin**<br />";
                                $content .= "<a href=\"" . url('arxmin/modules/boxifymanager/invoices/crud?download=' . $invoice->id . '&action=download') . "\">- Admin link to invoice</a>";

                                try {
                                    Api::sendAdminNotification($content, env('REDIRECT_EMAIL', "product@boxify.be"), 'Invoice Error notification for admin boxify');
                                } catch (Exception $e) {
                                    Log::error($e);
                                }

                                Log::error('Invoice payment ' . $invoice->id . ' error', \Arr::toArray($creditResponse));
                            }
                        } else {
	                        $invoice = new Invoice();
                        }
                    }

                } catch (Exception $e) {
                    Log::error($e);
                    try {
                        Api::sendUserNotification('Erreur paiement user ' . $e->getMessage(), 'product@boxify.be', 'Paiement error à checker !!');
                    } catch (Exception $e) {
                        Log::error($e);
                    }
                    $logs[] = "Error invoicing : " . $e->getMessage() . "<br />";
                }
            }
        } // endforeach items

        /**
         * If test mode return a json
         */
        if ($testmode) {
            return $testdata;
        }

        return $logs;
    }

}
