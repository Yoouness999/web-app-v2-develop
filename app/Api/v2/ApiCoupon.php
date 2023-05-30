<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\Coupon;

class ApiCoupon {
	public static function get($params = []) {
		return ApiHelper::get(Coupon::query(), $params);
	}
	
	public static function add($params = []) {
		$item = Coupon::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = Coupon::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}