<?php

namespace App;

use Adyen\AdyenException;
use App;
use App\Exceptions\PaymentErrorException;
use Arr;
use Carbon\Carbon;
use DateTime;
use Exception;
use Mail;
use Log;
use Response;
use StdClass;
use App\Exceptions\ChallengeException;


/**
 * Class Api
 *
 * @package App
 */
class Api
{
    private static $API_KEY = "";
    private static $API_SECRET = "";
    private static $API_BASE_URL = "";

    private static $_aInstances = array();

    public function __construct($param = array('key' => null, 'secret' => null))
    {

        if (!$param['key'] && !$param['secret']) {
            throw new \Exception('Api Key and Secret must be defined');
        }

        self::$API_SECRET = $param['secret'];
        self::$API_KEY = $param['key'];
    }

    /**
     * Calling method from Api
     *
     * @param $uri
     * @param array $param
     * @param null $method
     * @return array|mixed
     * @throws Exception
     */
    public function call($uri, $param = array(), $method = null)
    {
        $url = self::$API_BASE_URL . $uri;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');

        $signature = sha1(self::$API_SECRET . $date);

        $headers = array(
            'APIKEY: ' . self::$API_KEY,
            'DATE: ' . $date,
            'SIGNATURE: ' . $signature,
            'Content-Type: application/json',
            'Accept: application/json'
        );

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method == 'PUT') {
            curl_setopt($ch, CURLOPT_PUT, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        } elseif ($method == 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        } elseif (!$method && count($param) || $method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
        }

        $result = curl_exec($ch);

        if (!$result || curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        } else {

            $json = json_decode($result, true);

            if ($json) {
                $result = $json;
            }
        }

        return $result;
    }

    /**
     * Allow to configure Api Key and Secret
     *
     * @param array $param
     * @throws Exception
     */
    public static function configure($param = array('key' => null, 'secret' => null))
    {

        if (!$param['key'] && !$param['secret']) {
            throw new \Exception('Api Key and Secret must be defined');
        }

        self::$API_SECRET = $param['secret'];
        self::$API_KEY = $param['key'];
    }

    /**
     * Get a Textmaster instance already instanciated
     *
     * @return mixed
     * @example : Textmaster::getInstance()
     */
    public static function getInstance()
    {
        $sClass = get_called_class();

        if (!isset(self::$_aInstances[$sClass])) {
            self::$_aInstances[$sClass] = new $sClass();
        }

        return self::$_aInstances[$sClass];
    }

    public static $client = null;
    public static $plans = null;

    public static $lemonWayApi = null;

    /**
     * Apply an invitation code
     */
    public static function applyInvitationCode($user, $code)
    {
        if ($user->godfather) {
            return false;
        }

        /*
         * Find any invitation related to user and update the values
         */
        $claimed_email = Invite::where('email', $user->email)->where('token', $code)->first();

        $godfather = null;

        if ($claimed_email) {
            # We must check if the token hasn't expired
            if ($claimed_email->expiration_date > date('Y-m-d H:i:s')) {
                $claimed_email->status = Invite::STATUS_EXPIRED;
                $claimed_email->save();
                return false;
            }

            if ($claimed_email) {
                $claimed_email->used = 1;
                $claimed_email->expiration_date = date('Y-m-d H:i:s');
                $claimed_email->save();
            }

            $godfather = User::getByInviteCode($code);

            # Add the godfather_id reference in the DB
            $user->godfather_id = $godfather->id;

            $user->save();

            $invites_email = Invite::where('email', $user->email)->first();

            if ($invites_email) {
                $invites_email->update([
                    'used' => 1,
                    'status' => Invite::STATUS_ALREADY_CLAIMED,
                    'expiration_date' => date('Y-m-d H:i:s')
                ]);
            }
        } elseif ($godfather = User::where('invitation_code', $code)->first()) {
            $user->godfather_id = $godfather->id;
            $user->save();
        }

        if ($godfather) {

            $couponGodfather = Coupon::where('code', 'GOD-' . $user->id . '-' . $godfather->id)->first();

            if (!$couponGodfather) {

                $couponGodfather = new Coupon();
                $couponGodfather->code = 'GOD-' . $godfather->id . '-' . $user->id;
                $couponGodfather->promo_applied = config('project.godfather_coupon_discount');
                $couponGodfather->promo_type = "invitation";
                $couponGodfather->quantity = 1;
                $couponGodfather->save();

                // Generate a coupon to be used in the next order
                $couponUserGodfather = new CouponUser();
                $couponUserGodfather->user_id = $godfather->id;
                $couponGodfather->coupon_id = $couponGodfather->id;
                $couponGodfather->used = 0;
                $couponGodfather->touse = 1;
                $couponGodfather->save();

                // Send an email to the Godfather
                /*$data = \DM()->getBySlug('/mail/promo-code', ['format' => 'array'], $user->lang);

                $dataMail = [
                    'user' => $godfather->toArray(),
                    'action' => lg("common.sponsorship"),
                    'coupon' => $couponGodfather->toArray(),
                    'billing_date' => date('d/m/Y'),
                    'order_link' => url('order')
                ];

                $content = shortcode($data['content'], $dataMail);
                $subject = shortcode($data['title'], $dataMail);

                Api::sendUserNotification($content, $godfather, $subject);*/

                # Send coupon to user disabled !

                /*$couponUser = Coupon::where('code', 'SPONSORED-' . $user->id . '-' . $godfather->id)->first();

                if (!$couponUser) {
                    $couponUser = new Coupon();
                    $couponUser->code = 'SPONSORED-' . $user->id . '-' . $godfather->id;
                    $couponUser->promo_applied = config('project.godson_coupon_discount');
                    $couponUser->promo_type = "invitation";
                    $couponUser->quantity = 1;
                    $couponUser->save();
                }*/

                // Send an email to the user
                /*$data = \DM()->getBySlug('/mail/promo-code', ['format' => 'array'], $user->lang);

                $dataMail = [
                    'user' => $user->toArray(),
                    'action' => lg("common.sponsorship"),
                    'coupon' => $couponUser->toArray(),
                    'billing_date' => date('d/m/Y'),
                    'order_link' => url('order')
                ];

                $content = shortcode($data['content'], $dataMail);
                $subject = shortcode($data['title'], $dataMail);

                Api::sendUserNotification($content, $user, $subject);*/
            }
        }
    }

    public static function applyPromoCode($user, $code, $applyDirectly = false)
    {
        // 1. Check if coupon exist
        $coupon = Coupon::where('code', $code)->first();

        if ($coupon) {

            #1. Check quantity
            if ($coupon->quantity) {

                $couponUser = CouponUser::where('coupon_id', $coupon->id)->where('user_id', $user->id)->first();

                if (!$couponUser) {
                    $couponUser = new CouponUser();
                    $couponUser->user_id = $user->id;
                    $couponUser->coupon_id = $coupon->id;
                    $couponUser->touse = $applyDirectly ? 0 : 1;
                    $couponUser->used = $applyDirectly ? 1 : 0;
                    $couponUser->save();
                } elseif ($couponUser->used || $couponUser->touse) {
                    return null;
                }

                return $couponUser;
            }
        }

        return null;
    }

#A

    /**
     * Tranform an array to a valid Regex
     * @param $array
     * @return mixed
     */
    public static function arrayToRegex($array)
    {
        if (isset($array)) {
            foreach ($array as $k => $item) {
                if (is_string($item)) {
                    $array[$k] = $item;
                } else {
                    $array[$k] = "\"" . $item . "\"";
                }
            }
        }

        return implode('|', $array);
    }

    /**
     * Check coupon validity
     *
     * @param $code
     * @return bool
     */
    public static function checkCoupon($code, $param = ['as_object' => false])
    {
        /**
         * Check coupons interface
         */
        $coupon = Coupon::where('code', $code)->first();

        if ($coupon) {

            if ($coupon->quantity == 0) {
                return false;
            }

            // Check if there is no coupon code applied
            $user = auth()->user();

            if (!$user) {
                return false;
            }

            $couponUser = CouponUser::query()->where('coupon_id', $coupon->id)->where('user_id', $user->id)->first();

            if ($couponUser && $couponUser->used == 1) {
                return false;
            }

            // Check if coupon is valable and applicable
            if (!$coupon->expiry_date || $coupon->expiry_date >= date('Y-m-d H:i:s')) {
                $user = auth()->user();
                if (!$coupon->user_id || $coupon->user_id == $user->id) {
                    return $coupon->promo_applied;
                }
            }
        }

        return false;
    }
#B

#C

    /**
     * Items with a status with me should be outdated if > 2 semaines
     *
     * @see http://pm2.cherrypulp.com/projects/677?modal=Task-12629-677
     */
    public static function consolidateItemsWithMe()
    {

        $items = Item::where('status', Item::STATUS_DELIVERED)->get();

        foreach ($items as $item) {
            if ($item->ending_date < date('Y-m-d H:i:s', strtotime("2 weeks ago"))) {
                $item->status = Item::STATUS_OUTDATED;
                $item->save();
            }
        }

        return $items;
    }

#D

    public static function deleteOrphanedRecords()
    {
        $id = User::withTrashed()->pluck('id');

        $logs = [];

        \Eloquent::unguard();
        $logs['answer'] = Answer::where('answerable_type', User::class)->whereNotIn('answerable_id', $id)->forceDelete();
        $logs['coupon_user'] = CouponUser::whereNotIn('user_id', $id)->forceDelete();
        $logs['event_guest'] = EventGuest::whereNotIn('user_id', $id)->forceDelete();
        $logs['fee'] = Fee::whereNotIn('user_id', $id)->forceDelete();
        $logs['historical'] = Historical::whereNotIn('user_id', $id)->forceDelete();
        $logs['invite'] = Invite::whereNotIn('user_id', $id)->forceDelete();
        $logs['invite_godfather'] = Invite::whereNotIn('godfather_id', $id)->forceDelete();
        $logs['invoice'] = Invoice::withTrashed()->whereNotIn('user_id', $id)->forceDelete();
        $logs['item'] = Item::withTrashed()->whereNotIn('user_id', $id)->forceDelete();
        $logs["log"] = \App\Log::whereNotIn('user_id', $id)->forceDelete();
        $logs['notification'] = Notification::whereNotIn('user_id', $id)->forceDelete();
        /**
         * Delete all infos related to booking
         */
        $ids = OrderBooking::withTrashed()->whereNotIn('user_id', $id)->pluck('id');
        $logs['order_booking_answers'] = \DB::table('order_booking_answers')->whereIn('order_booking_id', $ids)->delete();
        $logs['order_booking_calculator_items'] = \DB::table('order_booking_calculator_items')->whereIn('order_booking_id', $ids)->delete();
        $logs['order_bookings'] = \DB::table('order_bookings')->whereIn('id', $ids)->delete();
        $logs['order_bookings_users'] = OrderBooking::withTrashed()->whereNotIn('user_id', $id)->forceDelete();
        $logs['pickup'] = Pickup::whereNotIn('user_id', $id)->forceDelete();
        $logs['api_token'] = App\Api\ApiToken::whereNotIn('user_id', $id)->forceDelete();

        return $logs;
    }

    /**
     * Force to delete an user id properly
     * @param $id
     * @return mixed|void
     */
    public static function deleteUser($id)
    {
        \Eloquent::unguard();
        Answer::where('answerable_type', User::class)->where('answerable_id', $id)->forceDelete();
        CouponUser::where('user_id', $id)->forceDelete();
        EventGuest::where('user_id', $id)->forceDelete();
        Fee::where('user_id', $id)->forceDelete();
        Historical::where('user_id', $id)->forceDelete();
        Invite::where('user_id', $id)->forceDelete();
        Invite::where('godfather_id', $id)->forceDelete();
        Invoice::withTrashed()->where('user_id', $id)->forceDelete();
        Item::withTrashed()->where('user_id', $id)->forceDelete();
        \App\Log::where('user_id', $id)->forceDelete();
        Notification::where('user_id', $id)->forceDelete();
        /**
         * Delete all infos related to booking
         */
        $ids = OrderBooking::withTrashed()->where('user_id', $id)->pluck('id');
        \DB::table('order_booking_answers')->whereIn('order_booking_id', $ids)->delete();
        \DB::table('order_booking_calculator_items')->whereIn('order_booking_id', $ids)->delete();
        \DB::table('order_bookings')->whereIn('id', $ids)->delete();
        OrderBooking::withTrashed()->where('user_id', $id)->forceDelete();
        Pickup::where('user_id', $id)->forceDelete();

        App\Api\ApiToken::where('user_id', $id)->forceDelete();

        return User::withTrashed()->where("id", $id)->forceDelete();
    }

#E

#F

#G

    /**
     * Return available cities
     *
     * @return array
     */
    public static function getCities()
    {
        return lg('cities');
    }

    public static function getClient($env = null, $force = false)
    {
        return self::getPaymentApi($env, $force);
    }

    /**
     * Get current env (sandbox or production)
     *
     * @return string
     */
    public static function getEnv($env = null)
    {
        if (!$env) {
            if (LEVEL_ENV <= 2) {
                $env = 'sandbox';
            } else {
                $env = 'production';
            }
        }

        return $env;
    }

    /**
     * Get the list of countries from countries and taxes table
     *
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getCountries()
    {
        $countries = Country::all();

        $countries = $countries->toArray();

        return $countries;
    }

    /**
     * Get the latitude from adress
     *
     * @param $address
     * @return array
     */
    public static function getLatLngFromAddress($address)
    {
        $prepAddr = str_replace(' ', '+', $address);
        $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false');
        $output = json_decode($geocode);

        $data = ['lat' => null, 'lng' => null];

        if ($output && isset($output->results[0], $output->results[0]->geometry, $output->results[0]->geometry->location)) {
            $latitude = $output->results[0]->geometry->location->lat;
            $longitude = $output->results[0]->geometry->location->lng;
            $data['lat'] = $latitude;
            $data['lng'] = $longitude;
        }

        return $data;
    }

    /**
     * Return the true/false based on date is busy or not.
     *
     * @param $date
     * @return boolean
     */
    public static function isBusyDay($date) {
        $busyDay = false;
        $dateTime = strtotime($date);
        $sub3Day = strtotime(Carbon::createFromTimeString($date)->endOfMonth()->subDays(3)->format('Y-m-d H:i:s'));
        $secondDay = strtotime(Carbon::createFromTimeString($date)->startOfMonth()->addDay(1)->format('Y-m-d H:i:s'));
        if ($dateTime >  $sub3Day || $dateTime < $secondDay) {
            $busyDay = true;
        }
        return $busyDay;
    }

    /**
     * Get Storage duration discount
     *
     * @used in the Order, Pickup Ajust and MonthlyInvoice
     * @param $price_per_month
     * @param OrderStoringDuration $storingDuration
     * @return float|int
     */
    public static function getStorageDurationDiscount($price_per_month, OrderStoringDuration $storingDuration)
    {
        return -$price_per_month * $storingDuration->discount_percentage / 100;
    }

#H

    /**
     * Get the list of available items types
     *
     * @return array
     */
    public static function getTypes()
    {
        return lg('types');
    }

#I

#J

#K

#L

#M

    public static function getUnavailableDates($fromDate = null, $floor=null, $volume=null)
    {
        if($fromDate == null) {
            $fromDate = new DateTime("now");
        }

        $dates = UnavailableDate::query()->where('date', '>=', $fromDate)->get()->toArray();

        //Add current date
        $dates[] = [
            "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
        ];
        //Is it friday?
        if($fromDate->format('N') == 5) {
            //Add Saturday
            $fromDate->modify('+1 day');
            $dates[] = [
                "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
            ];
            //Add Sunday
            $fromDate->modify('+1 day');
            $dates[] = [
                "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
            ];
        }

        //Add 24 hours/ 1days
        $fromDate->modify('+1 day');
        $dates[] = [
            "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
        ];

        //Add 48 hours/ 2days
        $fromDate->modify('+1 day');
        $dates[] = [
            "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
        ];

        //Decide if 5 more days needs to be added to match the 7 days advance rool
        $add5Days = false;
        if (!is_null($floor) && !is_null($volume)) {
            if ($floor < -1 || $floor > 1) {
                $add5Days = true;
            } elseif (($floor == -1 || $floor == 1) && $volume > 6) {
                $add5Days = true;
            } elseif ($floor == 0 && $volume > 15) {
                $add5Days = true;
            }
        }

        if($add5Days) {
            $fromDate->modify('+1 day');
            $dates[] = [
                "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
            ];
            $fromDate->modify('+1 day');
            $dates[] = [
                "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
            ];
            $fromDate->modify('+1 day');
            $dates[] = [
                "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
            ];
            $fromDate->modify('+1 day');
            $dates[] = [
                "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
            ];
            $fromDate->modify('+1 day');
            $dates[] = [
                "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
            ];
        }
        //IF after 12 noon THEN next day is unavailable. If It is friday then coming Monday is unavailable
        //if ( $fromDate->format('G') > 11) {
        //    $fromDate->modify('+1 day');
        //    $dates[] = [
        //        "date" => $fromDate->format("Y-m-d") . ' 00:00:00',
        //    ];
        //}
        return $dates;
    }

    /**
     * Handle Error => if Stagging BETA or PROD => Log error only
     * => if not throw error
     *
     * @param $e
     * @throws
     */
    public static function handleError($e)
    {
        if (!defined('LEVEL_ENV')) {
            define('LEVEL_ENV', 3);
        }

        if (is_array($e)) {
            $e = new Exception('Error with : ' . json_encode($e));
        }

        if (LEVEL_ENV < 2) {
            throw $e;
        }

        Log::error($e);
    }

#N

#O

#P

    /**
     * Make payment into Adyen
     *
     * @param $user
     * @param $invoice
     * @param $registerCard
     *
     * @return StdClass
     * @throws Exceptions\ChallengeException
     * @throws PaymentErrorException
     * @throws AdyenException
     */
    public static function makePayment($user, &$invoice, $registerCard = false): StdClass
    {
        $response = new StdClass();

        if ($invoice->getPrice()) {
            $amount = round($invoice->getPrice(), 2);

            if ($registerCard) {
                if ($registerCard['type'] === "sepa") {
                    $result = Adyen::createShopperSepaContract($user, $registerCard['iban'], $registerCard['iban_owner'], $invoice->getRef(), $amount);
                } else {
                    $result = Adyen::createShopperContract($user, $registerCard['adyen_card_encrypted_json'], $invoice->getRef(), $amount);
                }
            } else {
                $result = Adyen::makeRecurringPayment($user, $amount, $invoice->getRef());
            }

            Log::info("Payment Adyen Result", $result);

            if (!Adyen::isSuccess($result)) {

                // In case of error => invoice status = unpaid and type = proforma
                if ($invoice->status != Invoice::TYPE_INVOICED) {
                    $invoice->status = Invoice::STATUS_UNPAID;
                }

                $invoice->save();

                throw new PaymentErrorException('', $result);
            }

            $response->result = $result;

        }

        # In case of Sepa => we delay the invoice validation process => type = proforma && status = queued
        //Commented out for BXFY-512
        //if ($user->billing_method === User::BILLING_METHOD_SEPA) {
        //    $invoice->status = Invoice::STATUS_QUEUED;
        //}

        $invoice->save();

        return $response;
    }

#Q

#R

    /**
     * Get Payment API
     *
     * @param null $env
     * @param bool $force
     * @return LemonWayAPI|null
     * @deprecated => to keep until all users switch to Adyen !
     *
     */
    public static function getPaymentApi($env = null, $force = false)
    {
        if (self::$lemonWayApi && !$force) {
            return self::$lemonWayApi;
        }

        $api = new LemonWayAPI();

        if (!$env) {
            $env = self::getEnv();
        }

        if ($env == 'sandbox') {
            $api->config->dkUrl = 'https://sandbox-api.lemonway.fr/mb/boxify/dev/directkitxml/service.asmx';
            $api->config->wkUrl = 'https://sandbox-webkit.lemonway.fr/boxify/dev/';
            $api->config->wlLogin = 'Api';
            $api->config->wlPass = 'ApiBoxify123!';
            $api->config->lang = 'fr';
        } else {
            $api->config->dkUrl = 'https://ws.lemonway.fr/mb/boxify/prod/directkitxml/service.asmx';
            $api->config->wkUrl = 'https://webkit.lemonway.fr/mb/boxify/prod/';
            $api->config->wlLogin = 'Api';
            $api->config->wlPass = 'ApiBoxify123!';
            $api->config->lang = 'fr';
        }

        self::$lemonWayApi = $api;

        return $api;
    } // response

    /**
     * Calculate the prorata price regarding the pickup date
     *
     * @param $price
     * @param null $date_from
     * @return float|int
     */
    public static function proratePrice($price, $date_from = null)
    {

        if ($date_from) {

            if (!is_object($date_from)) {
                $date_from = new Datetime($date_from);
            }

            $pickupDateCarbon = new Carbon($date_from->format('c'));

            $currentDay = (int)$pickupDateCarbon->format('d') - 1;
            $lastDaysOfPickupMonth = (int)$pickupDateCarbon->lastOfMonth()->format('d');
            $diff_days = ($lastDaysOfPickupMonth - $currentDay);
            $numberOfDays = $pickupDateCarbon->daysInMonth;

            $price = ($price / $numberOfDays) * $diff_days;
        }

        return $price;
    }

    /**
     * Response Required
     *
     * It return 400 code status if no data
     *
     * @param array $mdata
     * @param bool $status
     * @param string $msg
     *
     * @return array
     */
    public static function responseErrors($mdata = array(), $status = null, $msg = '')
    {
        if (is_array($mdata) && isset($mdata['msg']) && isset($mdata['data']) && isset($mdata['status']) && !$status) {
            $status = $mdata['status'];
            $msg = $mdata['msg'];
            $mdata = $mdata['data'];
        } elseif (is_object($mdata)) {
            $mdata = (array)$mdata;
        }

        if (!$status && count($mdata)) {
            $status = 200;
        } elseif (!$status) {
            $status = 400;
        }

        $response = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $mdata,
            'errors' => $mdata
        );

        return $response;
    }

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseJson($mdata = array(), $status = null, $msg = '', array $headers = array(), $options = 0)
    {
        if (!isset($mdata['data'], $mdata['status'], $mdata['msg'])) {
            $response = self::response($mdata, $status, $msg);
        } else {
            $response = $mdata;
        }

        return Response::json($response, $response['status'], $headers, $options);
    } // response

    /**
     * Response Wrapper Helper
     *
     * It return 400 code status if no data
     *
     * @param array $mdata
     * @param bool $status
     * @param string $msg
     *
     * @return array
     */
    public static function response($mdata = array(), $status = null, $msg = '')
    {
        if (isset($mdata['data'], $mdata['status'], $mdata['msg'])) {
            return $mdata;
        }

        $data = [];

        if (is_array($mdata) && !isset($mdata['data'])) {
            $data = $mdata;
            $mdata = [];
        } elseif (is_array($mdata) && isset($mdata['data'])) {
            $data = $mdata['data'];
        }

        if (!$status && !isset($mdata['status'])) {
            $status = 200;
        }

        if (!$msg && !isset($mdata['msg'])) {
            $msg = "";
        }

        $response = array_merge((array)$mdata, array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ));

        return $response;
    } // response

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseJsonError($mdata = array(), $status = null, $msg = '', array $headers = array(), $options = 0)
    {
        $response = self::responseError($mdata, $status, $msg);

        return Response::json($response, $response['status'], $headers, $options);
    } // response

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseError($mdata = array(), $status = null, $msg = null)
    {
        Log::error($mdata);

        if (!$status) {
            $status = 400;
        }

        if (is_object($mdata)) {
            $data = [
                "msg" => $msg ?: $mdata->getMessage(),
                "status" => $status,
                "data" => [],
            ];
            if (LEVEL_ENV <= 2) {
                $data['data']['file'] = @$mdata->getFile();
                $data['data']['line'] = @$mdata->getLine();
                $data['data']['code'] = @$mdata->getCode();
                $data['data']['debug'] = debug_backtrace();
            }
        } else {
            $data = [
                "msg" => $msg,
                "status" => $status,
                "data" => $mdata,
            ];
        }

        if (!isset($data['notifications'])) {
            $data['notifications'] = $msg;
        }

        return $data;
    } // response

    /**
     * Return a formatted ResponseJson
     *
     * @param array $mdata
     * @param array $mergedData
     * @param null $status
     * @param string $msg
     * @param array $headers
     * @param int $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseJsonMerge($mdata = array(), $mergedData = [], $status = null, $msg = '', array $headers = array(), $options = 0)
    {
        $response = self::responseMerge($mdata, $mergedData, $status, $msg);
        return Response::json($response, $response['status'], $headers, $options);
    } // response

    /**
     * Little response helper to merge data
     *
     * @param $mdata
     * @param $mergedData
     * @param null $status
     * @param null $msg
     * @return array
     * @throws Exception
     * @example Api::responseMerge()
     * @internal param $data
     */
    public static function responseMerge($mdata, $mergedData, $status = null, $msg = null)
    {
        $data = self::response($mdata, $status, $msg);
        $data = Arr::merge($data, $mergedData);
        return $data;
    }
#S

    /**
     * Response with simple notifications
     * @param $msg
     * @param array $data
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function responseJsonNotification($msg, $data = [], $status = 200)
    {
        return Response::json(['notifications' => $msg, 'data' => $data], $status);
    }

    /**
     * Notification helper
     * @param $msg
     * @param array $data
     * @param int $status
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public static function responseWithNotification($notifications, $data = [], $status = 200, $msg = "")
    {
        return ['notifications' => $notifications, 'data' => $data, 'status' => $status, 'msg' => $msg];
    }

    /**
     * Send Admin notification
     *
     * @param $mData
     * @param null $to
     * @param null $subject
     * @return mixed
     */
    public static function sendAdminNotification($mData, $to = 'backup@boxify.be', $subject = null)
    {
        if (!$subject) {
            $subject = lg('New Admin notification from Boxify', 'emails');
        }

        if (is_string($mData)) {
            $mData = array('content' => $mData);
        }

        if (LEVEL_ENV <= 2) {
            $subject .= ' [to=' . $to . ']';
            $to = env('REDIRECT_EMAIL', REDIRECT_EMAIL);
        }

        Mail::send(['emails.layout', 'emails.text'], $mData, function ($message) use ($to, $subject) {
            $message->to($to)
                ->subject($subject);
        });
    }

    /**
     * Send an email notification to user
     *
     * @param $mData
     * @param null $to User
     *
     * @return bool|int
     */
    public static function sendUserNotification($mData, $to = null, $subject = null)
    {
        if (is_string($to)) {
            $user = new User();
            $user->email = $to;
            $user->first_name = $to;
            $to = $user;
        }

        if (!$to) {
            $user = auth()->user();

            if ($user) {
                $to = $user;
            } else {
                return false;
            }
        }

        if (!$subject) {
            $subject = lg('New notification from Boxify', 'emails');
        }

        if (is_string($mData)) {
            $mData = array('content' => $mData);
        }

        if (LEVEL_ENV <= 2 && !preg_match('/cherrypulp/i', $to->email)) {
            $subject .= ' [to=' . $to->email . ']';
            $to->email = REDIRECT_EMAIL;
        }

        Mail::send(['emails.layout', 'emails.text'], $mData, function ($message) use ($to, $subject) {
            $message->to($to->email)
                ->subject($subject);
        });
    } // getEnv

#T

#U

    /**
     * Handle the business logic of the users to invoice
     */
    public static function usersToInvoice()
    {
        return User::query()->whereNotNull('order_plan_id')->whereNull('end_subscription')->whereNull('deleted_at');
    }
#V

#W

#X

#Y

#Z
}
