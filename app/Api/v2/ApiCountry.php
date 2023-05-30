<?php
namespace App\Api\v2;

use App\Country;

class ApiCountry {

	public static function get($params = []) {
		return ApiHelper::get(Country::query(), $params);
	}
}
