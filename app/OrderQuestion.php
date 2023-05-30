<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;
use Illuminate\Support\Facades\Log;

class OrderQuestion extends Model {
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_NUMBER = 'number';
	
	////////////////////
	// Relationships
	////////////////////

	public function answers($value_boolean = false, $volume = 0, $bookingType = null) {
		$bTypes = [0];
		if ($bookingType == 'pickup') {
			$bTypes[] = [1];
		} elseif ($bookingType == 'delivery') {
			$bTypes[] = [2];
		} else {
			$bTypes[] = [1];
			$bTypes[] = [2];
		}
		
		return $this->hasMany(OrderAnswer::class, 'order_question_parent_id')
					->where('visible', true)
					->where('value_boolean', $value_boolean)
					->where('value_number_from', '<', $volume)
					->where('value_number_to', '>=', $volume)
					->whereIn('booking_type', $bTypes);
	}
	
	////////////////////
	// Util
	////////////////////
	
	public function getAnswer($value_boolean = false, $volume = 0, $floor = 0, $bookingType = null) {
		if(!$this->isFloorSpecific()) {
			$floor = 0;
		}
		return $this->answers($value_boolean, $volume, $bookingType)
			->where('floor_value', '=', $floor)
			->first();
	}
	
	public function getAllAnswers($bookingType = null) {
		$bTypes = [0];
		if ($bookingType == 'pickup') {
			$bTypes[] = [1];
		} elseif ($bookingType == 'delivery') {
			$bTypes[] = [2];
		} else {
			$bTypes[] = [1];
			$bTypes[] = [2];
		}

		return $this->hasMany(OrderAnswer::class, 'order_question_parent_id')
					->where('visible', true)
					->whereIn('booking_type', $bTypes)
					->get();
	}
	
	public function isFirst(Order $order) {
		if ($this->slug == 'floors') {
			return true;
		} else {
			return false;
		}
	}

	public function isFloorSpecific() {
		if ($this->slug == 'handling' || $this->slug == 'fragile') {
			return false;
		} else {
			return true;
		}
	}
}