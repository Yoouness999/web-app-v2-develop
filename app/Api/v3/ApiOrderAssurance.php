<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\OrderAssurance;

class ApiOrderAssurance {
	public static function get($params = []) {
		return ApiHelper::get(OrderAssurance::query(), $params);
	}
}