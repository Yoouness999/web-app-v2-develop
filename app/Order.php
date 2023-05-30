<?php
/**
 * Order
 *
 * This component is used to save informations about the current order in session.
 */

namespace App;

use App\Events\PickupConfirmationEvent;
use App\Exceptions\BillingErrorException;
use App\Exceptions\ChallengeException;
use App\Handlers\Events\PickupConfirmationHandler;
use App\OrderCalculatorItem;
use App\OrderQuestion;
use App\OrderBooking;
use App\OrderBookingStatus;
use App\Pickup;
use Arx\classes\Date;
use Carbon\Carbon;
use Cookie;
use Datetime;
use Exception;
use Illuminate\Support\Facades\Log;

class Order
{
    static $cookieWhiteList = [
        'items',
        'plan',
        'services',
        'storingDuration',
        'isComingFromCalculator',
        'address_full',
        'address_street_number',
        'address_route',
        'address_postal_code',
        'address_locality',
        'address_country',
        'address_box',
        'dropoff_date_from',
        'dropoff_date_to',
        'pickup_date_from',
        'pickup_date_to',
        'wait_fill_boxes',
        'company_address_full',
        'company_address_street_number',
        'company_address_route',
        'company_address_postal_code',
        'company_address_locality',
        'company_address_country',
        'company_address_box',
        'company_name',
        'company_vat_number',
        'comments',
        'user',
        'assurance',
        'business',
        'billing_address_route',
        'billing_address_street_number',
        'billing_address_locality',
        'billing_city',
        'billing_address_postal_code',
        'billing_address_country',
        'billing_address_box',
    ];

    public function toArrayForSlack()
    {
        $toReturn = [];

        $servicesData = [];
        foreach ($this->services as $service) {
            $servicesData[$service['Answer']->slug] = $service['value'];
        }

        $toReturn[] = [
            'title' => 'USER',
            'data' => $this->user ? [
                'first_name' => $this->user->first_name,
                'last_name' => $this->user->last_name,
                'email' => $this->user->email,
            ] : [],
            'color' => '#33FF3C'
        ];

        $toReturn[] = [
            'title' => 'PLAN',
            'data' => $this->plan ? [
                'volume_m3' => $this->plan->volume_m3,
                'price_per_month' => $this->plan->price_per_month
            ] : [],
            'color' => '#BE33FF'
        ];

        $toReturn[] = [
            'title' => 'SELECTED SERVICES',
            'data' => $servicesData,
            'color' => '#33CAFF'
        ];

        if($this->items && count($this->items) > 0)
        {
            $itemsData = [];
            foreach ($this->items as $item) {
                $itemsData[$item['CalculatorItem']->slug] = $item['quantity'];
            }

            $toReturn[] = [
                'title' => 'OBJET',
                'data' => $itemsData,
                'color' => '#E3FF33'
            ];
        }

        $toReturn[] = [
            'title' => 'APPOINTMENT',
            'data' => array_filter([
                'pickup_date_from'  => $this->pickup_date_from ? $this->pickup_date_from->format('Y-m-d H:i:s') : null,
                'pickup_date_to'  => $this->pickup_date_to ? $this->pickup_date_to->format('Y-m-d H:i:s') : null,
                'storingDuration'  => $this->storingDuration ? $this->storingDuration->slug: null,
                'wait_fill_boxes'  => $this->wait_fill_boxes,
                'address_full'  => $this->address_full
            ]),
            'color' => '#FF4F33'
        ];

        $toReturn[] = [
            'title' => 'MORE INFOS',
            'data' => array_filter([
                'dropoff_date_from'  => $this->dropoff_date_from,
                'dropoff_date_to'  => $this->dropoff_date_to,
                'company_address_full'  => $this->company_address_full,
                'company_address_street_number'  => $this->company_address_street_number,
                'company_address_route'  => $this->company_address_route,
                'company_address_postal_code'  => $this->company_address_postal_code,
                'company_address_locality'  => $this->company_address_locality,
                'company_address_country'  => $this->company_address_country,
                'company_address_box'  => $this->company_address_box,
                'company_name'  => $this->company_name,
                'company_vat_number'  => $this->company_vat_number,
                'comments'  => $this->comments,
                'assurance'  => $this->assurance,
                'business'  => $this->business,
                'billing_address_route'  => $this->billing_address_route,
                'billing_address_street_number'  => $this->billing_address_street_number,
                'billing_address_locality'  => $this->billing_address_locality,
                'billing_city'  => $this->billing_city,
                'billing_address_postal_code'  => $this->billing_address_postal_code,
                'billing_address_country'  => $this->billing_address_country,
                'billing_address_box'  => $this->billing_address_box
            ]),
            'color' => '#FF336E'

        ];

        return $toReturn;
    }

    public $items;
    public $plan;
    public $services;
    public $storingDuration;
    public $isComingFromCalculator;

    public $address_full;
    public $address_street_number;
    public $address_route;
    public $address_postal_code;
    public $address_locality;
    public $address_country;
    public $address_box;

    public $dropoff_date_from;
    public $dropoff_date_to;

    /**
     * @var Carbon
     */
    public $pickup_date_from;
    public $pickup_date_to;
    public $wait_fill_boxes;

    public $card_number;
    public $iban;
    public $iban_owner;
    public $adyen_card_encrypted_json;

    public $company_address_full;
    public $company_address_street_number;
    public $company_address_route;
    public $company_address_postal_code;
    public $company_address_locality;
    public $company_address_country;
    public $company_address_box;
    public $company_name;
    public $company_vat_number;

    public $how_did_your_hear_about_us;
    public $comments;

    public $user;
    public $assurance;

    public $business;

    public $billing_address_route;
    public $billing_address_street_number;
    public $billing_address_locality;
    public $billing_city;
    public $billing_address_postal_code;
    public $billing_address_country;
    public $billing_address_box;
    public $keep_payment = true;

    public $promo_code = null;
    public $promo_code_applied = null;
    public $invitation_code = null;

    public $invoice = null;

    public function __construct()
    {
        $this->booking = null;
        $this->pickup = null;

        $this->items = [];
        $this->plan = null;
        $this->services = [];
        $this->storingDuration = null;
        $this->isComingFromCalculator = false;

        $this->address_full = '';
        $this->address_street_number = '';
        $this->address_route = '';
        $this->address_postal_code = '';
        $this->address_locality = '';
        $this->address_country = '';
        $this->address_box = '';

        $this->dropoff_date_from = null;
        $this->dropoff_date_to = null;
        $this->pickup_date_from = null;
        $this->pickup_date_to = null;
        $this->wait_fill_boxes = false;

        $this->card_number = '';
        $this->iban = '';
        $this->iban_owner = '';
        $this->adyen_card_encrypted_json = '';
        $this->expiration_month = '';
        $this->expiration_year = '';

        $this->company_address_full = '';
        $this->company_address_street_number = '';
        $this->company_address_route = '';
        $this->company_address_postal_code = '';
        $this->company_address_locality = '';
        $this->company_address_country = '';
        $this->company_address_box = '';
        $this->company_name = '';
        $this->company_vat_number = '';

        $this->how_did_your_hear_about_us = '';
        $this->comments = '';

        $this->user = null;
        $this->assurance = null;

        /**
         * Add promo_code and invitation_code
         */
        $this->promo_code = null;
        $this->invitation_code = null;

        return $this;
    }

    ////////////////
    // Calculator
    ////////////////

    /* Initialize order items from request inputs */

    /**
     * @deprecated use getServicesAppointement
     */
    public function getAppointment()
    {
        return $this->getServicesAppointment();
    }

    /* Get a calculator item by his slug */

    public function getServicesAppointment()
    {
        $appointment = 0;

        foreach ($this->services as $service) {
            $appointment += $service['price'];
        }

        return $appointment;
    }

    /**
     * Check Order dataset to determine what is the current step URL
     * @return string
     */
    public function getCurrentStepUrl()
    {
        if (empty($this->plan)) {
            if ($this->isComingFromCalculator) {
                return url('/order/calculator');
            } else {
                return url('/order/storage');
            }
        } elseif (empty($this->services)) {
            return url('/order/services');
        } elseif (empty($this->address_full)) {
            return url('/order/appointment');
        } elseif (!($this->iban || $this->adyen_card_encrypted_json)) {
            return url('/order/billing');
        }

        return url('/order/review');
    }

    ////////////////
    // Services
    ////////////////

    /* Initialize order services from request inputs */

    public function getDropoffDate()
    {
        if ($this->dropoff_date_from) {
            return $this->dropoff_date_from->format('F j, Y');
        }

        return '';
    }

    /* Return true if the order has heavy items which need two carriers */

    public function getDropoffTime()
    {
        if ($this->dropoff_date_from && $this->dropoff_date_to) {
            return $this->dropoff_date_from->format('Y-m-d H:i:s') . '_' . $this->dropoff_date_to->format('Y-m-d H:i:s');
        }

        return '';
    }

    ////////////////
    // Price per month
    ////////////////

    public function getItem($slug)
    {
        if ($this->items) {
            foreach ($this->items as $item) {
                if ($item['CalculatorItem']->slug == $slug) {
                    return $item;
                }
            }
        }

        return null;
    }

    public function getMinimumBalance()
    {
        if ($this->isComingFromCalculator) {
            if ($this->isPickupNeedsTwoCarriers()) {
                if ($this->getPricePerMonth() <= 50) {
                    return 50; // calculator, at least one item <= 0.6m3, total <= 50€
                } else {
                    return 150; // calculator, at least one item <= 0.6m3, total > 50€
                }
            } else {
                if ($this->getPricePerMonth() <= 50) {
                    return 50; // calculator, all items > 0.6m3, total <= 50€
                } else {
                    return 100; // calculator, all items > 0.6m3, total > 50€
                }
            }
        } else {
            if ($this->plan->volume_m3 <= 6) {
                if ($this->getPricePerMonth() <= 50) {
                    return 50; // no calculator items, plan <= 6m3, total <= 50€
                } else {
                    return 100; // no calculator items, plan <= 6m3, total > 50€
                }
            } else {
                if ($this->getPricePerMonth() <= 50) {
                    return 50; // no calculator items, plan > 6m3, total <= 50€
                } else {
                    return 150; // no calculator items, plan > 6m3, total > 50€
                }
            }
        }
    }

    /* Get storing duration discount value from plan */

    public function isPickupNeedsTwoCarriers()
    {
        foreach ($this->items as $item) {
            if ($item['CalculatorItem']->volume_m3 >= 0.6) {
                return true;
            }
        }

        return false;
    }

    public function getPricePerMonth()
    {
        $price_per_month = 0;

        if ($this->plan) {

            /**
             * Adapt the pricing if postal_code is defined
             */
            if ($this->address_postal_code) {
                $area = Area::where('zip_code', $this->address_postal_code)->first();

                if ($area) {

                    $orderPlanRegion = OrderPlanRegion::where('region_id', $area->region_id)->where('order_plan_id', $this->plan->id)->first();

                    if ($orderPlanRegion) {
                        $price_per_month = $orderPlanRegion->price_per_month;
                    }
                }
            }

            if (!$price_per_month) {
                $price_per_month = $this->plan->price_per_month;
            }
        }

        if ($this->storingDuration) {
            $price_per_month += $this->getStoringDurationDiscount();
        }

        //$price_per_month = Api::proratePrice($price_per_month, $this->pickup_date_from);

        if ($this->assurance) {
            $price_per_month += $this->assurance->price_per_month;
        }

        /**
         * if user has already a plan =>  he has to pay the difference betwen the old plan and the new plan
         */
        $user = $this->user;
        if ($user && $user->price_per_month) {
            $price_per_month = $price_per_month - $user->price_per_month;
        }

        return $price_per_month;
    }

    ////////////////
    // Appointment
    ////////////////

    public function getStoringDurationDiscount()
    {
        $discount = 0;

        if ($this->plan && $this->storingDuration) {
            $discount = Api::getStorageDurationDiscount($this->plan->price_per_month, $this->storingDuration);
        }

        return $discount;
    }

    /* Get appointment value from services */

    public function getPickupDate()
    {
        if (isset($this->pickup_date_from)) {
            return $this->pickup_date_from->format('F j, Y');
        }

        return '';
    }

    /* Get formated dropoff date to prefill date field */

    public function getPickupTime()
    {
        if ($this->pickup_date_from && $this->pickup_date_to) {
            return $this->pickup_date_from->format('Y-m-d H:i:s') . '_' . $this->pickup_date_to->format('Y-m-d H:i:s');
        }

        return '';
    }

    /* Get formated dropoff time to prefill time field */

    public function getPriceFormatedPerMonth()
    {
        return $this->formatPrice($this->getPricePerMonth());
    }

    /* Get formated pickup date to prefill date field */

    public function formatPrice($price)
    {
        return str_replace('.', ',', number_format(round($price, 2), 2));
    }

    /* Get formated pickup time to prefill time field */

    /**
     * Return the price of insurance
     *
     */
    public function getPriceInsurance()
    {
        if ($this->assurance) {
            return $this->assurance->price_per_month;
        }

        return 0;
    }

    /**
     * Get the price prorated per month
     */
    public function getPriceProratedPerMonth()
    {
        return round(Api::proratePrice($this->getPricePerMonth(), $this->pickup_date_from), 2);
    }

    public function getStoringDurationFormatedDiscount()
    {
        return $this->formatPrice($this->getStoringDurationDiscount());
    }

    public function isStoringDurationChecked($storingDuration)
    {
        return $this->storingDuration && $this->storingDuration->id == $storingDuration->id || !$this->storingDuration && $storingDuration->slug == '-3_months';
    }


    ////////////////
    // Billing
    ////////////////

    /* Initialize order billing informations from request inputs */

    /**
     * Check if the order has enough information to keep going
     */
    public function isValid($step)
    {
        return !$this->getRedirectUrlWhenInvalid($step);
    }

    /**
     * Get redirect page url when order is not valid
     */
    public function getRedirectUrlWhenInvalid($step)
    {
        if ($step > 1 && !$this->plan) {
            var_dump('a');
            return '/order/storage';
        }

        if ($step > 2 && empty($this->services)) {
            var_dump('b');
            return '/order/services';
        }

        if ($step > 3 && empty($this->address_full)) {
            var_dump('c');
            return '/order/appointment';
        }

        if ($step > 4 && !($this->iban || $this->adyen_card_encrypted_json || $this->keep_payment)) {
            var_dump('d');
            return '/order/billing';
        }

        if ($step > 5) {
            var_dump('e');
            return '/order/review';
        }

        return null;
    }

    /**
     * Retrieve an Order from Session or Cookie or return a new instance
     * @return Order|mixed
     */
    public static function retrieve()
    {
        $instance = new self();

        if (session()->exists('order') && !empty(session()->get('order'))) {
            $instance = $instance->loadSession();
        }

        return $instance;
    }

    ////////////////
    // Review
    ////////////////

    /**
     * Load an order object from session
     */
    public function loadSession()
    {
        return session()->get('order', $this);
    }

    ////////////////
    // Other
    ////////////////

    /**
     * @return \App\OrderBooking
     * @throws BillingErrorException
     * @throws ChallengeException
     * @throws Exceptions\PaymentErrorException
     * @throws \Adyen\AdyenException
     */
    public function save()
    {
        /**
         * 1. Check if user is logged or not => to save an order => user must be logged
         *
         * @var $user User
         */
        $user = $this->user;

        if (!$user) {

            $user = auth()->user();

            if (!$user) {
                throw new Exception('User not logged');
            }

            $this->user = $user;
        }

        // Force update user lang
        $user->lang = app()->getLocale();

        // Set user billing_method before invoicing user
        if ($this->iban) {
            $user->billing_method = User::BILLING_METHOD_SEPA;
            $user->save();
        } elseif ($this->adyen_card_encrypted_json) {
            $user->billing_method = User::BILLING_METHOD_CREDITCARD;
            $user->save();
        } elseif ($this->keep_payment) {
            if (!$user->billing_method) {
                throw new BillingErrorException();
            }
        }

        $booking = new OrderBooking();

        /* Appointment */
        $booking->dropoff_date_from = $this->dropoff_date_from;
        $booking->dropoff_date_to = $this->dropoff_date_to;

        $booking->pickup_date_from = $this->pickup_date_from;
        $booking->pickup_date_to = $this->pickup_date_to;

        $booking->address_full = $this->address_full;
        $booking->address_route = $this->address_route;
        $booking->address_street_number = $this->address_street_number;
        $booking->address_locality = $this->address_locality;
        $booking->address_postal_code = $this->address_postal_code;
        $booking->address_country = $this->address_country;
        $booking->address_box = $this->address_box;

        $booking->wait_fill_boxes = $this->wait_fill_boxes;

        /* Review */
        $booking->company_name = $this->company_name;
        $booking->company_vat_number = $this->company_vat_number;
        $booking->company_address_full = $this->company_address_full;
        $booking->company_address_route = $this->company_address_route;
        $booking->company_address_street_number = $this->company_address_street_number;
        $booking->company_address_locality = $this->company_address_locality;
        $booking->company_address_postal_code = $this->company_address_postal_code;
        $booking->company_address_country = $this->company_address_country;
        $booking->company_address_box = $this->company_address_box;

        $booking->how_did_your_hear_about_us = $this->how_did_your_hear_about_us;
        $booking->comments = $this->comments;

        /* Total */
        $booking->price_per_month = $this->getPricePerMonth();
        $booking->appointment = $this->getServicesAppointment();

        $booking->total_description = json_encode($this->getTotalDescription());
        $booking->total_price_to_invoice = $this->getTotalPriceToInvoice();

        /* Relationships */
        $booking->user()->associate($user);

        if ($this->plan) {
            $booking->plan()->associate($this->plan);
        }

        if ($this->storingDuration) {
            $booking->storingDuration()->associate($this->storingDuration);
        }

        if ($this->assurance) {
            $booking->assurance()->associate($this->assurance);
        }

        $status = OrderBookingStatus::where('slug', 'pending')->first();
        $booking->status()->associate($status);

        $booking->save();

        /* Calculator items */
        if ($this->items) {
            foreach ($this->items as $item) {
                $booking->calculatorItems()->attach($item['CalculatorItem'], ['qty' => $item['quantity']]);
            }
        }

        /* Answers */
        if ($this->services) {
            foreach ($this->services as $service) {
                $booking->answers()->attach($service['Answer'], ['value' => $service['value']]);
            }
        }

        $this->booking = $booking;

        /**
         * Save Address in user profile
         */
        $user->street = $this->address_route;
        $user->number = $this->address_street_number;
        $user->city = $this->address_locality;
        $user->postalcode = $this->address_postal_code;
        $user->country = $this->address_country;
        $user->box = $this->address_box;

        /**
         * Update user infos
         */
        if ($this->business) {
            $user->business = 1;
            $user->company_name = $this->company_name;
            $user->company_vat_number = $this->company_vat_number;
            $user->company_address_route = $this->company_address_route;
            $user->company_address_street_number = $this->company_address_street_number;
            $user->company_address_locality = $this->company_address_locality;
            $user->company_address_postal_code = $this->company_address_postal_code;
            $user->company_address_country = $this->company_address_country;
            $user->company_address_box = $this->company_address_box;
        } else {
            $user->business = 0;
            $user->billing_street = $this->billing_address_route;
            $user->billing_number = $this->billing_address_street_number;
            $user->billing_city = $this->billing_city;
            $user->billing_postalcode = $this->billing_address_postal_code;
            $user->billing_country = $this->billing_address_country;
            $user->billing_box = $this->billing_address_box;
        }

        # Check if the user plan need to be updated right now or later
        if ($this->pickup_date_from < date('Y-m-d 23:59:59', strtotime("end of the month"))) {
            if (!$this->dropoff_date_from || $this->dropoff_date_from < date('Y-m-d 23:59:59', strtotime("end of the month"))) {
                /**
                 * Check if we should adapt the user plan (only if it's bigger normally !)
                 */
                if (!$user->plan || ($this->plan && $user->plan->volume_m3 < $this->plan->volume_m3)) {
                    $user->plan()->associate($this->plan);
                    # We should keep the current price per month (in case of commitment period => we can't keep the new plan price !)
                    $user->order_plan_price_per_month = $this->plan->price_per_month;
                    $user->old_pricing = 0;
                }
            }
        }

        /**
         * Check if we should reajust the insurance id
         *
         * @see https://docs.google.com/spreadsheets/d/1_NwPeAh8PTr9aYMgb40qEU9wgRMU4Hc7fZmyF6gya28/edit#gid=1360913119&range=A29
         */
        if ($user->insurance && $user->insurance->price_per_month < $this->assurance->price_per_month) {
            $user->order_assurance_id = $this->assurance->id;
        } elseif (!$user->order_assurance_id && isset($this->assurance->id)) {
            $user->order_assurance_id = $this->assurance->id;
        }

        /**
         * Check current user engagement => if < new engagement => we should update that
         */
        if ($this->storingDuration && (!$user->storingDuration || $user->storingDuration->discount_percentage < $this->storingDuration->discount_percentage)) {

            $user->storingDuration()->associate($this->storingDuration);

            if ($this->pickup_date_to) {
                $begin_commitment_period = Carbon::instance($this->pickup_date_to);
            } elseif ($booking->pickup_date_from) {
                $begin_commitment_period = Carbon::instance($booking->pickup_date_from);
            } elseif ($this->dropoff_date_from) {
                $begin_commitment_period = Carbon::instance($booking->dropoff_date_from);
            } else {
                $begin_commitment_period = Carbon::instance($booking->dropoff_date_from);
            }

            if (!$user->end_commitment_period) {
                $user->end_commitment_period = $begin_commitment_period->addMonth($this->storingDuration->month);
            } else {
                $diffMonths = Carbon::createFromFormat('Y-m-d H:i:s', $user->end_commitment_period)->diffInMonths($begin_commitment_period);

                $begin_commitment_period = Carbon::instance($this->pickup_date_to);

                $user->end_commitment_period = $begin_commitment_period->addMonth($diffMonths);
            }
            $user->old_pricing = 0;
        }

        /**
         * If there is a price adapted to current region => adapt the monthly user_price
         */
        $area = Area::where('zip_code', $this->address_postal_code)->first();

        if ($area) {
            $orderPlanRegion = OrderPlanRegion::where('region_id', $area->region_id)->where('order_plan_id', $user->order_plan_id)->first();

            if ($orderPlanRegion) {

                $user->order_plan_region_id = $orderPlanRegion->id;

                if ($orderPlanRegion) {
                    $user->order_plan_price_per_month = $orderPlanRegion->price_per_month;
                    $user->old_pricing = 0;                 
                }
            } else {
                \Log::info("Cannot find order plan region : Cannot find order #".$user->id);
            }
        }

        $user->save();

        if($user->old_pricing == 0) {
            $user->recalculateOrderPlanPrice($user->plan, true);
        }

        /**
         * Store pickup infos
         *
         * @see https://docs.google.com/document/d/16TxOv75-HacjNkQX88jaooq93zoW1vjqyPa0gY0x26M/edit#
         */
        $pickup = new Pickup();

        $pickup->total = $this->getServicesAppointment();
        $pickup->street = $this->address_route;
        $pickup->number = $this->address_street_number;
        $pickup->box = $this->address_box;
        $pickup->postalcode = $this->address_postal_code;
        $pickup->city = $this->address_locality;
        $pickup->country = $this->address_country;
        $pickup->status = Pickup::STATUS_ORDERED;
        $pickup->pickup_date = $this->pickup_date_from;
        $pickup->pickup_date_to = $this->pickup_date_to;
        $pickup->dropoff_date_from = $this->dropoff_date_from;
        $pickup->dropoff_date_to = $this->dropoff_date_to;
        $pickup->order_booking_id = $booking->id;
        $pickup->fragile = $booking->fragile;
        $pickup->floor = $booking->floor;
        $pickup->transporter_number = $booking->transporter_number;
        $pickup->parking = $booking->parking;
        $pickup->volume_m3 = $booking->getVolume();
        $pickup->type = Pickup::TYPE_PICKUP;

        $pickup->user()->associate($user);
        $pickup->booking()->associate($booking);
        /**
         * @see http://pm2.cherrypulp.com/projects/673?modal=Task-13614-673
         */
        if ($this->dropoff_date_from && $this->dropoff_date_to && !$this->wait_fill_boxes) {

            $dropPickup = new Pickup();

            $dropPickup->total = $this->getServicesAppointment();
            $dropPickup->street = $this->address_route;
            $dropPickup->number = $this->address_street_number;
            $dropPickup->box = $this->address_box;
            $dropPickup->postalcode = $this->address_postal_code;
            $dropPickup->city = $this->address_locality;
            $dropPickup->country = $this->address_country;
            $dropPickup->status = Pickup::STATUS_ORDERED;
            $dropPickup->pickup_date = $this->pickup_date_from;
            $dropPickup->pickup_date_to = $this->pickup_date_to;
            $dropPickup->dropoff_date_from = $this->dropoff_date_from;
            $dropPickup->dropoff_date_to = $this->dropoff_date_to;
            $dropPickup->order_booking_id = $booking->id;
            $dropPickup->fragile = $booking->fragile;
            $dropPickup->floor = $booking->floor;
            $dropPickup->transporter_number = $booking->transporter_number;
            $dropPickup->parking = $booking->parking;
            $dropPickup->volume_m3 = $booking->getVolume();
            $dropPickup->type = Pickup::TYPE_PICKUP;

            $dropPickup->user()->associate($user);
            $dropPickup->booking()->associate($booking);

            $dropPickup->save();
            /* Answers */
            if ($this->services) {
                foreach ($this->services as $service) {
                    $dropPickup->answers()->create(['order_answer_id' => $service['Answer']->id, 'value' => $service['value'], 'price' => $service['price']]);
                }
                $dropPickup->updateServices($this->services);
            }

            $pickup->pickup_date = $this->pickup_date_from;
            $pickup->pickup_date_to = $this->pickup_date_to;
            $pickup->type = Pickup::TYPE_DROP_OFF;

        } elseif ($this->wait_fill_boxes) {
            $pickup->type = Pickup::TYPE_DROP_OFF_PICKUP;
        }

        $pickup->save();
        /* Answers */
        if ($this->services) {
            foreach ($this->services as $service) {
                $pickup->answers()->create(['order_answer_id' => $service['Answer']->id, 'value' => $service['value'], 'price' => $service['price']]);
            }
            $pickup->updateServices($this->services);
        }

        $this->pickup = $pickup;

        /**
         * Generate Invoice immediately the user for the first month prorata
         *
         * @see : https://docs.google.com/spreadsheets/d/1_NwPeAh8PTr9aYMgb40qEU9wgRMU4Hc7fZmyF6gya28/edit#gid=1360913119&range=A64
         */
        $total = $this->getTotalPriceToInvoice();


        $beginDate = Carbon::instance($this->pickup_date_to)->format('d/m/Y');
        $endDate = Carbon::instance($this->pickup_date_to)->endOfMonth()->format('d/m/Y');

        $invoice = new Invoice();
        $invoice->type = Invoice::TYPE_PICKUP;        

        $invoice->title = shortcode(lg("invoice.order.pickup.title"), [
            'plan' => $this->plan->name,
            'date' => [
                'start' => $beginDate,
                'end' => $endDate
            ]
        ]);

        //$invoice->content = "<strong>" . $invoice->title . "</strong><br />";
        $invoice->content .= $this->getTotalDescription('invoice');

        $invoice->price = $total;
        $invoice->user_id = $user->id;
        $invoice->pickup_id = $pickup->id;
        $invoice->status = Invoice::STATUS_QUEUED;
        if ($user->isIban()) {
            $invoice->billing_method = 'sepa';
        } else {
            $invoice->billing_method = 'creditcard';
        }
        $invoice->save();
        $invoice->generateNumber(true, true);

        $this->invoice = $invoice;

        // Validate the invitation flow
        if ($this->invitation_code) {
            Api::applyInvitationCode($user, $this->invitation_code);
        }

        if ($this->promo_code) {
            /**
             * @var  $couponUser CouponUser
             */
            $couponUser = Api::applyPromoCode($user, $this->promo_code, true);

            if ($couponUser) {
                $this->promo_code_applied = $couponUser->coupon->promo_applied;
                $invoice->price = $couponUser->applyCoupon($invoice->price) ?: 0;
                $invoice->content .= "<br />- ".ucfirst(lg("common.discount")).' -'.$couponUser->coupon->promo_applied;
                $invoice->save();
            }
        }

        if ($invoice->price < 0) {
            $invoice->price = 0;
        }
        $invoice->total = $invoice->price;
        $invoice->save();

        //dd($this->keep_payment, \Request::all());

        try {
            session()->put('pickupAd', $pickup);
            session()->put('bookingAd', $booking);
            session()->put('invoiceAd', $invoice);
            session()->put('orderAd', $this);

            /**
             * Make a payment attempt
             */
            if ($invoice->total == 0) {
                $invoice->status = Invoice::STATUS_PAID;
                $invoice->payment_date = date('Y-m-d H:i:s');
                $invoice->save();

                if ($this->iban) {
                    Adyen::createShopperSepaContract($user, $this->iban, $this->iban_owner);
                } elseif ($this->adyen_card_encrypted_json) {
                    Adyen::createShopperContract($user, $this->adyen_card_encrypted_json);
                }

            } elseif ($this->keep_payment) {
                Api::makePayment($user, $invoice);
            } else {
                if ($this->iban) {
                    Api::makePayment($user, $invoice, [
                        'type' => 'sepa',
                        'iban' => $this->iban,
                        'iban_owner' => $this->iban_owner
                    ]);
                } else {
                    Api::makePayment($user, $invoice, [
                        'type' => 'card',
                        'adyen_card_encrypted_json' => $this->adyen_card_encrypted_json
                    ]);
                }
            }

        } catch (ChallengeException $e) {
            throw $e;
        } catch(Exception $e) {

            /**
             * In case of error or any type of error we need to delete the invoice and the pickup ref
             */
            try {
                if($pickup) {
                    $pickup->forceDelete();
                }
                if($invoice) {
                    $invoice->forceDelete();
                }
                if($booking) {
                    $booking->delete();
                }
            } catch (Exception $e) {
                \Log::info('Error deleting invoice');
                \Log::error($e);
                Api::sendAdminNotification($e->getMessage(), 'product@boxify.be', $e->getLine());
            }

            throw $e;
        }

        /**
         * @see PickupConfirmationHandler
         */
        event(new PickupConfirmationEvent($pickup));

        $this->saveSession();

        return $booking;
    }

    /**
     * Get order total
     */
    public function getTotalPriceToInvoice()
    {
        if ($this->invoice) {
            return $this->invoice->price;
        }

        $total = Api::proratePrice($this->getPricePerMonth(), $this->pickup_date_from) + $this->getServicesAppointment();
        $total += $this->assurance->price_per_month;
        $user = $this->user;
        if ($user && $user->isCreditCard()) {
            $total = $total * 1.02;
        }

        return $total;
    }

    /**
     * Get the total description in an array with description and price
     *
     * return Array
     * @param string $format could as array or as text for invoice
     * @return array|string
     */
    public function getTotalDescription($format = "array")
    {
        $lines = [];
        $user = $this->user;
        if ($this->plan) {
            $beginDate = Carbon::instance($this->pickup_date_to)->format('d/m/Y');
            $endDate = Carbon::instance($this->pickup_date_to)->endOfMonth()->format('d/m/Y');
            $lines[] = [
                'description' => '<strong>'. shortcode(lg("invoice.order.pickup.title"), [
                    'plan' => $this->plan->name,
                    'date' => [
                        'start' => $beginDate,
                        'end' => $endDate
                    ]
                ]) .'</strong>',
                'price_formatted' => number_format(Api::proratePrice($this->getPricePerMonth(), $this->pickup_date_from), 2, ',', '.') . ' €'
            ];
        }

        if ($this->storingDuration && isset($this->storingDuration->discount_percentage)) {
            $discount = $this->storingDuration->discount_percentage;
            //if($this->old_pricing) {
            //    $discount = $this->storingDuration->old_discount_percentage;
            //}
            if ($discount >= 0) {
                $label = "";
                if($this->storingDuration->slug == '-3_months') {
                    $label = lg('invoice.monthly.storage-duration.-3_months', null, [], $user->lang);
                } else {
                    $label = shortcode(lg("invoice.storage-duration.description", null, [], $user->lang), [
                        'months' => lg("order.appointment.storing-duration." . $this->storingDuration->slug, null, [], $user->lang),
                        'discount' => round($discount)
                    ]);
                }
                $lines[] = [
                    'description' => ' - ' . $label,
                    'price_formatted' => ''
                ];
            }
        }

        if ($this->assurance) {
            $lines[] = [
                'description' => ' - ' . str_replace('strong', 'span', lg("order.review.assurance." . $this->assurance->slug . ".description", null, [], $user->lang)),
                'price_formatted' => $this->assurance->price_per_month ? number_format($this->assurance->price_per_month, 2, ',', '.') . ' €' : ucfirst(lg("common.free"))
            ];
        }

        $servicePrice = 0.00;
        foreach ($this->services as $service) {
            $servicePrice += $service['price'];
        }
        $lines[] = [
            'description' => '<br /><strong>'. lg('invoice.order.pickup.services.title', null, [], $user->lang) . '</strong>',
            'price_formatted' => $servicePrice > 0 ? number_format($servicePrice, 2, ',', '.') . ' €' : ucfirst(lg("common.free"))
        ];
        $lines[] = [
            'description' => ' - '. shortcode(lg('invoice.order.services.moving.description', null, [], $user->lang), [
                'volume' => $this->plan->name
            ]),
            'price_formatted' => ''
        ];

        foreach ($this->services as $service) {
            $lines[] = [
                'id' => $service['Answer']->id,
                'value' => $service['value'],
                'description' => ' - ' . shortcode(lg("order.resume.services." . $service['Answer']->slug, null, [], $user->lang), [
                    'floor' => $service['value']
                ]),
                'price_formatted' => ''
            ];
        }

        if ($this->promo_code && $this->promo_code_applied) {
            $lines[] = [
                'description' => ucfirst(lg("common.discount", null, [], $user->lang)) . ' (' . preg_match('/\%/i', $this->promo_code_applied) ? $this->promo_code_applied : $this->promo_code_applied . ' €' . ')',
                'price_formatted' => '-' . preg_match('/\%/i', $this->promo_code_applied) ? $this->promo_code_applied : $this->promo_code_applied . ' €'
            ];
        }

        if ($user && $user->isCreditCard()) {
            $lines[] = [
                'description' => lg("common.payment-type-credit-card", null, [], $user->lang),
                'price_formatted' => "2%"
            ];
        }

        if ($format == "invoice") {
            $content = "";
            foreach ($lines as $value) {
                //Price removed from description
                //$content .= "- " . $value['description'] . " - " . $value['price_formatted'] . "<br />";
                if($value['description'] !== '') {
                    $content .= $value['description'] . "<br />";
                }
            }
            return $content;
        }

        return $lines;
    }

    /**
     * Save the session helper
     */
    public function saveSession()
    {
        session()->put('order', $this);
        return $this;
    }

    function setCardNumber($card_number_part)
    {
        if (!empty($card_number_part)) {
            $this->card_number = '**** **** **** ' . $card_number_part;
        }
    }

    public function setItems($items)
    {
        $this->items = [];

        foreach ((array)$items as $calculatorItemId => $quantity) {
            if ($quantity > 0) {
                $this->items[] = [
                    'CalculatorItem' => OrderCalculatorItem::find($calculatorItemId),
                    'quantity' => $quantity
                ];
            }
        }
    }

    public function setServices($answers)
    {
        $this->services = Order::populateServices($answers, $this->plan->volume_m3, 'pickup');
    }

    public static function populateServices($answers, $volume = 0, $bookingType = null)
    {
        $services = [];
        
        $floor_number = 0;
        $move_total = 0;
        if ($answers['number']) {
            $questions = $answers['number'];
            foreach ($questions as $questionId => $value) {
                $question = OrderQuestion::find($questionId);
                if ($value != '' && $floor_number == 0) {
                    $floor_number = $value;
                }
                $answer = $question->getAnswer($value == 'yes', $volume, $floor_number, $bookingType);
                if ($answer) {
                    $appointment = $answer->appointment * 1.21;
                    $move_total += $appointment;
                    
                    $services[] = [
                        'Answer' => $answer,
                        'value' => $value,
                        'price' => round($appointment, 2),
                        'slug' => $question->slug
                    ];
                }
            }
        }

        if ($answers['boolean']) {
            $questions = $answers['boolean'];
            foreach ($questions as $questionId => $value) {
                $question = OrderQuestion::find($questionId);
                $answer = $question->getAnswer($value == 'yes', $volume, $floor_number, $bookingType);
                if ($answer) {
                    $appointment = 0;
                    if ($question->slug == 'carriers') {
                        $appointment = $answer->appointment * 1.21;
                        $move_total += $appointment;
                    } elseif ($question->slug == 'handling' || $question->slug == 'fragile') {
                        if ($floor_number == 0 && $bookingType == 'pickup') {
                            $appointment = $answer->appointment_alt * 1.21;
                        } else {
                            $appointment = $move_total * ($answer->appointment/100);
                        }
                    } elseif ($question->slug == 'parking') {
                        $appointment = $answer->appointment * 1.21;
                    }

                    $services[] = [
                        'Answer' => $answer,
                        'value' => $value,
                        'price' => round($appointment, 2),
                        'slug' => $question->slug
                    ];
                }
            }
        }
        return $services;
    }
}
