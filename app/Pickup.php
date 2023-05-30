<?php namespace App;

use App\Traits\HasAnswers;
use App\Traits\ModelFilesHandlingTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Config;
use Datetime;
use Carbon\Carbon;
use Log;

class Pickup extends Model
{
    use modelFilesHandlingTrait;
    use HasAnswers;

    const STATUS_ORDERED = 'ORDERED';
    const STATUS_GET_BACK = 'ORDERED';
    const STATUS_CANCELED = 'CANCELED';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_DONE = 'DONE';
    const STATUS_READY_TO_DESTROY = "READY-TO-DESTROY";

    /**
     * droppoff,
     * pickup,
     * delivery = getback
     * dropoff_pickup
     * dropoff_delivery
     */
    const TYPE_DROP_OFF = 'drop_off';
    const TYPE_PICKUP = 'pickup';
    const TYPE_DELIVERY = 'delivery';
    const TYPE_DROP_OFF_PICKUP = 'dropoff_pickup';
    const TYPE_DROP_OFF_DELIVERY = 'dropoff_delivery';

    public static $currentPath = 'files';
    public static $filepath = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'total',
        'street',
        'number',
        'box',
        'postalcode',
        'city',
        'status',
        'add_infos',
        'history',
        'pickup_date',
        'sign_photo',
        'intern_note',
        'dropoff_intern_note',
        'pickup_option',
        'dropoff_date_from',
        'dropoff_date_to',
        'pickup_date_to',
        'assigned_deliveryman_arxmin_user_id',
        'latitude',
        'longitude',
        'type',
        "country",
        "fragile",
        "floor",
        "handling",
        "transporter_number",
        "parking",
        "volume_m3",
        "items_on_error",
        'warehouse_id',
        'ref_pickup_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'dropoff_date_from',
        'dropoff_date_to',
        'pickup_date_to',
        'pickup_date',
    ];

    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();

        static::deleting(function($pickup) { // before delete() method call this
            $pickup->answers()->forceDelete();
        });
    }

    public function assignedDeliveryMan()
    {
        return $this->belongsTo(ArxminUser::class, 'assigned_deliveryman_arxmin_user_id');
    }

    public function booking()
    {
        return $this->belongsTo('App\OrderBooking', 'order_booking_id');
    }

    public function report()
    {
        return $this->belongsTo('App\Report', 'report_id');
    }

    /**
     * Zone belongs to warehouse
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function cancel() {
        if ($this->status == Pickup::STATUS_ORDERED) {
            $this->status = Pickup::STATUS_CANCELED;
            $this->save();
            $items = $this->itemsRecords()->get();
            foreach ($items as $item) {
                $item->updateStatusToPreviousOne($this->id);
            }

            /*$invoices = Invoice::query()->where('pickup_id', '=', $this->id)
                            ->where('status', '=', Invoice::STATUS_UNPAID)
                            ->where('type', '=', $this->type)
                            ->where('attempt', '<', 3)
                            ->get();
            foreach ($invoices as $invoice) {
                $invoice->status = Invoice::STATUS_CANCELLED;
                $invoice->save();
            }*/
        }
    }

    /**
     * Complete the pickup
     */
    public function complete()
    {
        $status = $this->status !== Pickup::STATUS_COMPLETED
                    || $this->status !== Pickup::STATUS_DONE
                    || $this->status !== Pickup::STATUS_CANCELED;

        if ($status) {

            $prorata = $this->reajustProrata();

            if ($prorata < 0) {

                $prorata = abs($prorata);

                // Generate invoice
                $invoice = new Invoice();
                $invoice->type = Invoice::TYPE_SERVICES;
                if ($this->user->isIban()) {
                    $invoice->billing_method = 'sepa';
                } else {
                    $invoice->billing_method = 'creditcard';
                }
                $invoice->title = lg("Prorata adjustments {from} - {to}", [
                    'from' => $this->pickup_date->format('d/m/Y'),
                    'to' => $this->pickup_date->format('t/m/Y'),
                ]);
                $invoice->content = lg("Prorata adjustments {from} - {to}");
                $invoice->price = $prorata;
                $invoice->user_id = $this->user->id;
                $invoice->pickup_id = $this->id;
                $invoice->payment_date = date('Y-m-d H:i:s');
                $invoice->total = $invoice->price;
                $invoice->save();

            } elseif ($prorata > 0) {

                $couponPrice = abs($prorata);

                $coupon = new Coupon();
                $coupon->code = 'ADJ-' . $this->id . '-' . $this->user_id;
                $coupon->promo_type = Coupon::PROMO_TYPE_REDEEM;
                $coupon->promo_applied = $couponPrice;
                $coupon->quantity = 1;
                $coupon->save();

                $couponUser = new CouponUser();
                $couponUser->user_id = $this->user_id;
                $couponUser->coupon_id = $coupon->id;
                $couponUser->touse = 1;
                $couponUser->save();
            }

            return true;
        }

        return false;
    }

    public function getAddressAttribute()
    {
        return $this->number . ' ' . ($this->box ? shortcode(lg('pickup.box'), ['box' => $this->box]) : '') . ' ' . $this->street . "\n" . $this->postalcode . ', ' . $this->city;
    }

    public function getItemsToDropAttribute()
    {
        $items = collect(json_decode($this->items, true))->where('bulk_item', 0)->toArray();

        return $items;
    }

    public function getItemsToGetBackAttribute()
    {
        $items = collect(json_decode($this->items, true))->toArray();

        return $items;
    }

    public function getItemsToPickupAttribute()
    {
        $items = collect(json_decode($this->items, true))->where('bulk_item', 1)->toArray();

        return $items;
    }

    /**
     * Get the price of the pickups
     */
    public function getDeliveryPrice()
    {
        $answers = $this->answers()->get();
        $price = 0.0;
        $movePrice = 0.0;

        foreach ($answers as $answer) {
            $price += $answer->price;
            $slugStr = $answer->answer()->first()->slug;
            if(str_contains($slugStr, "floors") || str_contains($slugStr, "carriers")) {
                $movePrice += $answer->price;
            }
        }

        $busyDay = Api::isBusyDay($this->pickup_date);
        if($busyDay) {
            $price += $movePrice * 0.10;
        }

        if ($this->user && $this->user->isCreditCard()) {
            $price = $price * 1.02;
        }

        return round($price, 2);
    }

    /**
     * Get the price description
     */
    public function getDeliveryPriceDescription($format = "array")
    {
        $answers = $this->answers()->get();
        $data = '<strong>'. lg('invoice.description.delivery', null, [], $this->user->lang) . ' (' . $this->pickup_date->format('d/m/Y') . ') </strong><br />';
        $data .= '<strong>'. lg('invoice.order.delivery.services.title', null, [], $this->user->lang) . '</strong><br />';
        $data .= ' - '. shortcode(lg('invoice.order.services.moving.description', null, [], $this->user->lang), [
            'volume' => ceil($this->volume_m3) . "m3"
        ]) . '<br />';
        foreach ($answers as $answer) {
            //Price removed from description
            //$data .= '- ' . $answer->getName($this->user->lang) . ' (' . $answer->getPrice(true) . ')' . '<br />';
            $data .= ' - ' . $answer->getName($this->user->lang) . '<br />';
        }
        if ($this->user && $this->user->isCreditCard()) {
            $data .= lg("common.payment-type-credit-card", null, [], $this->user->lang) . '<br />';
        }

        return $data;
    }

    /**
     * Get sign photo path
     *
     * @return string
     */
    public function getSignPhotoPathAttribute()
    {
        if (is_file($this->path($this->sign_photo))) {
            return $this->relPath($this->sign_photo);
        }

        return null;
    }

    /**
     * Delivery time slots
     *
     * Return time slot every 2 hours. From 8a.m. to 8p.m. on normal day, from 8a.m. to 12a.m. on busy day.
     * Check how many delivery trucks are available by time slot. 2 cars are available by default.
     * Check also if a date is available (table unavailable_dates).
     *
     * @param Datetime $from
     * @param Datetime $to
     * @param int $trucks
     *
     * @return Array of time slots availables
     * TODO-HM : This can be improved with floor and volume parameter for unavailable dates.
     */
    public static function getTimeSlots(Datetime $from, Datetime $to, $trucks = 1)
    {
        $from = clone($from);
        $to = clone($to);

        // Force pair hours

        $fromHours = $from->format('H');
        $from->setTime($fromHours, 0, 0);
        if ($fromHours % 2 == 1) $from->modify('+1 hour');

        $toHours = $to->format('H');
        $to->setTime($toHours, 0, 0);
        if ($toHours % 2 == 1) $to->modify('-1 hour');

        // Get pickups from database

        $dropoffs = Self::where('dropoff_date_from', '<', $to)
            ->where('status', Self::STATUS_ORDERED)
            ->where('dropoff_date_to', '>=', $from)
            ->get();

        $pickups = Self::where('pickup_date', '<', $to)
            ->where('status', Self::STATUS_ORDERED)
            ->where('pickup_date', '>=', $from)
            ->get();

        // Get unavailable dates from database

        $unavailableDates = Api::getUnavailableDates();

        // Get time slot every 2 hours. From 8a.m. to 8p.m. on normal day, from 8a.m. to 12a.m. on busy day.

        $timeSlots = [];

        while ($from < $to) {
            $isABusyDay = Self::isABusyDay($from);

            $startHour = clone($from);
            $startHour->setTime(8, 0, 0);

            $endHour = clone($from);
            //16-18 timeslot is blocked for the moment
            $endHour->setTime(16, 0, 0);

            $currentTimeSlotTo = clone($from);
            $currentTimeSlotTo->modify('+2 hour');

            if (!$isABusyDay && $from >= $startHour && $currentTimeSlotTo <= $endHour) {
                // Check how many trucks are available for this time slot. 2 trucks are available by default.

                $slots = $trucks;
                $dropoffsOnThatSlot = [];
                $pickupsOnThatSlot = [];

                foreach ($dropoffs as $dropoff) {
                    if ($dropoff->dropoff_date_from < $currentTimeSlotTo && $dropoff->dropoff_date_to >= $from) {
                        $dropoffsOnThatSlot[] = $dropoff;
                        $slots--;
                    }

                    if ($slots <= 0) {
                        break;
                    }
                }

                if ($slots > 0) {
                    foreach ($pickups as $pickup) {
                        $pickup_date_from = new Datetime($pickup->pickup_date);
                        $pickup_date_to = clone($pickup_date_from);

                        if ($pickup_date_from < $currentTimeSlotTo && $pickup_date_to >= $from) {
                            $pickupsOnThatSlot[] = $pickup;
                            $slots--;
                        }

                        if ($slots <= 0) {
                            break;
                        }
                    }
                }

                // Check if the date is available

                if ($slots > 0) {
                    foreach ($unavailableDates as $unavailableDate) {
                        $unavailableDate = new Datetime($unavailableDate['date']);
                        if ($unavailableDate < $currentTimeSlotTo && $unavailableDate >= $from) {
                            $slots = 0;
                            break;
                        }
                    }
                }

                if ($slots > 0) {
                    $timeSlots[] = [
                        'from' => clone($from),
                        'to' => clone($currentTimeSlotTo),
                        'dropoffs' => $dropoffsOnThatSlot,
                        'pickups' => $pickupsOnThatSlot,
                        'slots' => $slots
                    ];
                }
            }

            $from->modify('+2 hour');
        }

        return $timeSlots;
    }

    /**
     * Return true if the date if a busy day / dayoff
     */
    public static function isABusyDay(Datetime $date)
    {
        $easterDate = new Datetime();
        $easterDate->setTimestamp(easter_date($date->format('Y')));

        $ascension = clone($easterDate);
        $ascension->modify('+40 day');

        $pentecote = clone($easterDate);
        $pentecote->modify('+50 day');

        $saturday = clone($date);
        $saturday->modify('+' . (6 - $saturday->format('N')) . ' day');

        $sunday = clone($date);
        $sunday->modify('+' . (7 - $sunday->format('N')) . ' day');

        $busyDates = [
            ['month' => 1, 'day' => 1], // Jour de l'an
            ['month' => $easterDate->format('m'), 'day' => $easterDate->format('d')], // Lundi de Pâques
            ['month' => 5, 'day' => 1], // Fête du Travail
            ['month' => $ascension->format('m'), 'day' => $ascension->format('d')], // Jeudi de l'Ascension
            ['month' => $pentecote->format('m'), 'day' => $pentecote->format('d')], // Lundi de Pentecôte
            ['month' => 7, 'day' => 21], // Fête nationale
            ['month' => 8, 'day' => 15], // Assomption
            ['month' => 11, 'day' => 1], // Toussaint
            ['month' => 11, 'day' => 11], // Armistice 1918
            ['month' => 12, 'day' => 25], // Noël
            ['month' => $saturday->format('m'), 'day' => $saturday->format('d')], // Saturday
            ['month' => $sunday->format('m'), 'day' => $sunday->format('d')] // Sunday
        ];

        foreach ($busyDates as $busyDate) {
            if ($date->format('m') == $busyDate['month'] && $date->format('d') == $busyDate['day']) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get volume of the currents pickups in m3
     */
    public function getVolume()
    {
        $items = $this->itemsRecords;

        if ($items) {
            return $this->itemsRecords()->sum('volume_m3');
        }

        return 0;
    }

    public function itemsRecords()
    {
        return $this->belongsToMany(Item::class, 'booking_item', 'booking_id', 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'pickup_id');
    }

    public function answers()
    {
        return $this->hasMany(PickupAnswer::class, 'pickup_id');
    }

    /***********************************/
    /***GESTION DES SCOPES SUR PICKUP***/
    /***********************************/

    /**
     * @param $period : "history","today", "future"
     * @param $cat : "pickup", "delivery", "dropoff"
     * @return
     */
    public function scopePeriod($query, $period, $cat)
    {
        $today = Carbon::today()->toDateTimeString();
        $tomorrow = Carbon::tomorrow()->toDateTimeString();
        switch ($cat) {
            case "pickup":
            case "delivery":
                $attribute = "pickup_date";
                break;
            case "dropoff":
                $attribute = "dropoff_date_from";
                break;
        }
        switch ($period) {
            case "history":
                return $query->whereRaw($attribute, "<", $today);
            case "today":
                return $query->where($attribute, ">=", $today)->where($attribute, "<", $tomorrow);
            case "future":
                // return $query->where($attribute,">=",$tomorrow);
                return $query->where(
                    function ($q) use ($tomorrow) {
                        $q->where('pickup_date', ">=", $tomorrow)
                            ->orWhere('dropoff_date_from', ">=", $tomorrow);
                    });
        }
    }

    /**
     * @param $status : "ordered" or "getback"
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', '=', $status);
    }

    /**
     * @param $user_type : "user" or "deliverman"
     * @param $user_id : id of user or deliverman
     */
    public function scopeUser($query, $user_type, $user_id)
    {
        switch ($user_type) {
            case "user":
                return $query->where("user_id", "=", $user_id);
            case "deliverman":
                return $query->where("assigned_deliveryman_arxmin_user_id", "=", $user_id);
        }
    }

    /**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();
        return $data;
    }



    /**********************/
    /******TO ARRAY********/
    /**********************/

    /**
     * Override default toArray method
     *
     * @return array
     */
    public function toArray()
    {
        $data = parent::toArray();

        $data['sign_photo'] = $this->sign_photo_path;

        unset($data['items']);
        $data['items'] = [];
        foreach ($this->itemsRecords as $item) {
            $data['items'][] = $item;
        }


        /**
         * add delivery man info for admin
         */
        $data['assigned_delivery_man'] = null;

        if ($this->assignedDeliveryMan) {
            $data['assigned_delivery_man'] = $this->assignedDeliveryMan->toArrayMinimal();
        }

        $data['user'] = $this->user ? $this->user->toArrayApi(0) : $this->user;

        if ($this->sign_photo) {
            $data['sign_photo'] = url($this->sign_photo);
        }

        $data['report'] = $this->report ? $this->report->toArray():  null;

        $data['volume_m3'] = empty($this->volume_m3) ? 0 : round($this->volume_m3, 2);

        $data['calculatorItems'] = $this->getCalculatorItems();


        if ($data['status'] == self::STATUS_COMPLETED) {
            $data['prorate_price'] = 0;
        } else {
            $data['prorate_price'] = $this->reajustProrata();
        }
        $data['answers']= $this->answers->toArray();

        return $data;
    }

    /**
     * Return calculators items
     */
    public function getCalculatorItems()
    {
        $data = [];

        if ($booking = $this->booking) {

            /**
             * @var $booking OrderBooking
             */
            if ($booking->calculatorItems) {
                return $booking->calculatorreajustProrataItems;
            }
        }

        return $data;
    }

    /**
     * Reajust the prorata
     */
    public function reajustProrata($preview = true, $invoice = false, $asArray = false)
    {
        if (!$this->booking || !$this->user) {
            return 0;
        }

        /**
         * @var $booking OrderBooking
         */
        $booking = $this->booking;

        /**
         * Booking price_per_month = plan + storageDiscount + insurance
         */
        $old_plan_price = $booking->price_per_month;

        $new_plan_price = $this->user->order_plan_price_per_month;

        $storingDurationDiscount = $booking->storingDuration ? Api::getStorageDurationDiscount($new_plan_price, $booking->storingDuration) : 0;

        $insurance = $booking->assurance ? $booking->assurance->price_per_month : 0;

        if(!$this->invoices || !isset($this->invoices)){
            return 0;
        }

        if (!isset($this->invoices[0]) || !count($this->invoices)) {
            return 0;
        }

        $invoicedPrice = $this->invoices[0]->price;


        /**
         * @var $user User
         */
        $user = $this->user;

        /**
         * @var $plan OrderPlan
         */
        $price = $user->order_plan_price_per_month;

        $daysInMonth = $this->pickup_date->daysInMonth;
        $day = $this->pickup_date->format('d') - 1;

        if ($booking->storingDuration) {
            $storingDurationDiscountPercent = (100 - $booking->storingDuration->discount_percentage) / 100;
        } else {
            $storingDurationDiscountPercent = 1;
        }

        $cardFee = $user->isCreditCard() ? 1.02 : 1;

        //dd($storingDurationDiscount);

        $services = 0;

        /**
         * @var $answer OrderAnswer
         */
        foreach ($booking->answers as $answer) {
            $services = $services + $answer->getAppointment($answer->value_number_from);
        }

        $insurance = 0;

        if ($booking->assurance) {
            $insurance = $booking->assurance->price_per_month;
        }

        $prorata = ((((($price / $daysInMonth) * ($daysInMonth - $day))) * $storingDurationDiscountPercent) + ($services + $insurance)) * $cardFee;

        $prorata = round($prorata, 2);

        //This(asArray) is not being used anywhere.
        if ($asArray) {
            return [
                'invoiced_price' => $invoicedPrice,
                'plan' => $price,
                'prorata' => $prorata,
                'reajusted_price' => round($invoicedPrice - $prorata, 2),
                'services' => $services,
                'insurance' => $insurance,
                'storingDiscount' => $storingDurationDiscountPercent,
                'daysInMonth' => $daysInMonth,
                'day' => $day,
                'cardFee' => $cardFee
            ];
        }

        $prorata = round($invoicedPrice - $prorata, 2);

        return $prorata;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

	/**
	 * Update services
	 *
	 * If the pickup have answers attached, use them to set up services
	 * Else use a previous pickup
	 * TODO-HM : else part can be improved but may it is not required for future.
	 * @return boolean false if services couldn't be updated
	 */
	public function updateServices($services) {
		if ($services) {
            foreach ($services as $service) {
                if ($service['slug'] == 'fragile') {
                    $this->fragile = $service['value'] == 'yes';
                } elseif ($service['slug'] == 'floors') {
                    $this->floor = $service['value'];
                } elseif ($service['slug'] == 'carriers') {
                    $this->transporter_number = ($service['value'] == 'yes')? 1 : 0;
                } elseif ($service['slug'] == 'parking') {
                    $this->parking = $service['value'] == 'yes';
                } elseif ($service['slug'] == 'handling') {
                    $this->handling = $service['value'] == 'yes';
                }
            }
			$this->save();

			return true;
		}
		return false;
	}
}
