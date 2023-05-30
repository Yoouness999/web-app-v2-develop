<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\OrderPlanCategory;

class ApiOrderPlanCategory {
	public static function get($params = []) {
		return ApiHelper::get(OrderPlanCategory::query(), $params);
	}
	
	public static function add($params = []) {
		$item = OrderPlanCategory::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderPlanCategory::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}