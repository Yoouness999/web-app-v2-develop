<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\OrderPlan;

class ApiOrderPlan {
	public static function get($params = []) {
		return ApiHelper::get(OrderPlan::query(), $params);
	}
}