<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAnswer extends Model {
	protected $fillable = [
		"id",
        "order_question_parent_id",
		"order_question_target_id",
        "slug",
        "floor_value",
        "value_boolean",
        "value_number_from",
        "value_number_to",
		"appointment",
        "visible"
    ];

	////////////////////
	// Relationships
	////////////////////

	public function questionParent() {
		return $this->belongsTo(OrderQuestion::class, 'order_question_parent_id');
	}

	public function questionTarget() {
		return $this->belongsTo(OrderQuestion::class, 'order_question_target_id');
	}

	public function getQuestionTargetId() {
		$question = $this->questionTarget()->first();
		if($question) {
			return $question->id;
		} else {
			return '';
		}
	}

	////////////////////
	// Util
	////////////////////

	public function getAppointment($value) {
		if ($value !== 'no' || $this->isWithoutParking()) {
            return $this->appointment;
        }
        return 0;
	}

	/**
	 * Is a fragile answer
	 *
	 * @return boolean
	 */
	public function getFloorAttribute() {
		return in_array($this->slug, [
			'without_carriers_<=6m3_floors_=0',
			'without_carriers_<=6m3_floors_>=1',
			'without_carriers_>6m3_floors_=0',
			'without_carriers_>6m3_floors_>=1',
			'with_carriers_floors_=0',
			'with_carriers_floors_>=1',
			'with_carriers_floors_>=4',
			'with_carriers_floors_>=8',
			'floors',
			'floors_0'
		]);
	}

	/**
	 * Is a floor answer
	 *
	 * @return boolean
	 */
	public function getFragileAttribute() {
		return in_array($this->slug, [
			'with_carriers_fragile',
			'without_carriers_fragile',
			'fragile'
		]);
	}

	/**
	 * Is a carriers answer
	 *
	 * @return boolean
	 */
	public function getCarriersAttribute() {
		return in_array($this->slug, [
			'with_carriers'
		]);
	}

	/**
	 * Is a without parking answer
	 *
	 * @return boolean
	 */
	public function isWithoutParking() {
		return in_array($this->slug, [
			'without_carriers_without_parking',
			'with_carriers_without_parking',
			'without_parking'
		]);
	}

	/**
	 * Is a parking answer
	 *
	 * @return boolean
	 */
	public function getParkingAttribute() {
		return in_array($this->slug, [
			'without_carriers_with_parking',
			'with_carriers_with_parking',
			'with_parking'
		]);
	}
}
