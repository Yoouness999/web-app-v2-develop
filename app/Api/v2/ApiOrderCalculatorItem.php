<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\OrderCalculatorItem;

class ApiOrderCalculatorItem {
	public static function get($params = []) {
		return ApiHelper::get(OrderCalculatorItem::query(), $params);
	}
	
	public static function add($params = []) {
		$item = OrderCalculatorItem::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderCalculatorItem::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}