<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\OrderCalculatorCategory;

class ApiOrderCalculatorCategory {
	public static function get($params = []) {
		return ApiHelper::get(OrderCalculatorCategory::query(), $params);
	}
}