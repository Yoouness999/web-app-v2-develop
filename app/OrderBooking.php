<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderBooking extends Model {

    use SoftDeletes;

    /**
     * @see https://docs.google.com/spreadsheets/d/1_NwPeAh8PTr9aYMgb40qEU9wgRMU4Hc7fZmyF6gya28/edit#gid=742417254&range=123:123
     */
    const MEETING_TYPE_DROP_OFF = "drop_off";
    const MEETING_TYPE_PICKUP = "pickup";
    const MEETING_TYPE_WAIT_FILL_BOXES = "wait_fill_boxes";

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price_per_month',
		'appointment',
		'dropoff_date_from',
		'dropoff_date_to',
		'pickup_date_from',
		'pickup_date_to',
		'address_route',
		'address_street_number',
		'address_locality',
		'address_postal_code',
		'address_country',
		'address_box',
		'wait_fill_boxes',
		'company_name',
		'company_vat_number',
		'company_route',
		'company_street_number',
		'company_locality',
		'company_postal_code',
		'company_country',
		'company_box',
		'how_did_your_hear_about_us',
		'comments',
		'user_id',
		'order_plan_id',
		'order_storing_duration_id',
		'order_assurance_id',
		'order_booking_status_id',
        'total_description',
        'total_price_to_invoice'
    ];

	////////////////
	// Relationships
	////////////////

	public function user() {
        return $this->belongsTo('App\User');
    }

	public function plan() {
        return $this->belongsTo('App\OrderPlan', 'order_plan_id');
    }

	public function storingDuration() {
        return $this->belongsTo('App\OrderStoringDuration', 'order_storing_duration_id');
    }

	public function assurance() {
        return $this->belongsTo('App\OrderAssurance', 'order_assurance_id');
    }

	public function status() {
        return $this->belongsTo('App\OrderBookingStatus', 'order_booking_status_id');
    }

	public function calculatorItems() {
        return $this->belongsToMany('App\OrderCalculatorItem', 'order_booking_calculator_items')->withPivot(['qty']);
    }

	public function answers() {
        return $this->belongsToMany('App\OrderAnswer', 'order_booking_answers');
    }

    public function pickup(){
        return $this->hasOne('App\Pickup');
     }

    /**
     * Get the order booking ref (used for thank you page + invoice)
     */
    public function getReference(){
        return 'booking-'.$this->user_id.'-'.$this->id;
    }

    /**
     * get the meeting type
     */
    public function getMeetingType(){
        if ($this->dropoff_date_to) {
            return self::MEETING_TYPE_DROP_OFF;
        }
    }

    /**
     * Get the volume of the current order_booking
     *
     * The volume depends of whatever the order_booking has a pickup_id attached
     *
     * @see https://docs.google.com/spreadsheets/d/1_NwPeAh8PTr9aYMgb40qEU9wgRMU4Hc7fZmyF6gya28/edit#gid=742417254&range=125:125
     */
    public function getVolume(){
        /**
         * @var $pickup Pickup
         */
        if ($this->plan) {
            return $this->plan->volume_m3;
        }

        return 0;
    }

    /**
     * Get fragile attribute
     *
     * @return boolean
     */
    public function getFragileAttribute() {
        $fragile = $this->answers->filter(function($answer){
			return $answer->fragile;
		})->count();
		
		return $fragile > 0;
    }

    /**
     * Get floor attribute
     *
     * @return integer
     */
    public function getFloorAttribute() {
		$floor = $this->answers->filter(function($answer){
			return $answer->floor;
		})->first();
	
		if ($floor) {
			return $floor->pivot->value;
		}
		
		return 0;
    }

	/**
     * Get transporter number attribute
     *
     * @return integer
     */
    public function getTransporterNumberAttribute() {
        $carriers = $this->answers->filter(function($answer){
			return $answer->carriers;
		})->count();

        if ($carriers > 0) {
            return 1;
        }

        return 0;
    }
	
	/**
     * Get parking attribute
     *
     * @return boolean
     */
    public function getParkingAttribute() {
        $parking = $this->answers->filter(function($answer){
			return $answer->parking;
		})->count();

        return $parking > 0;
    }

	/**
     * Extends toArray method for the Api
     *
     * @return array
     */
    public function toArrayApi($deep = 1)
    {
        $data = $this->toArray();

        $pickup = $this->pickup;

        if ($pickup) {
            $data['pickup'] = $pickup->toArrayApi();
        }

        $data['volume'] = $this->getVolume();
        $data['fragile'] = $this->fragile;
        $data['transporter_number'] = $this->transport_number;
        $data['parking'] = $this->parking;
        $data['floor'] = $this->floor;

        return $data;
    }
}
