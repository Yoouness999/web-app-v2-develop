<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\OrderCalculatorCategory;

class ApiOrderCalculatorCategory {
	public static function get($params = []) {
		return ApiHelper::get(OrderCalculatorCategory::query(), $params);
	}
	
	public static function add($params = []) {
		$item = OrderCalculatorCategory::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderCalculatorCategory::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}