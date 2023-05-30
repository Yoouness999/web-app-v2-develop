<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\ArxminUser;
use Datetime;

class ApiArxminUser {
	public static function get($params = []) {
		return ApiHelper::get(ArxminUser::query(), $params);
	}
	
	public static function pickups($user, $from, $to) {
		$from = new Datetime($from);
		$to = new Datetime($to);
		
		return $user->getPickups($from, $to);
	}
}