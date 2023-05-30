<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\OrderCalculatorItem;

class ApiOrderCalculatorItem {
	public static function get($params = []) {
		return ApiHelper::get(OrderCalculatorItem::query(), $params);
	}
}