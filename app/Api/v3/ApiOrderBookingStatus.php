<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\OrderBookingStatus;

class ApiOrderBookingStatus {
	public static function get($params = []) {
		return ApiHelper::get(OrderBookingStatus::query(), $params);
	}
	
	public static function add($params = []) {
		$item = OrderBookingStatus::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderBookingStatus::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}