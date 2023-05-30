<?php
namespace App\Api\v2;

use App\Api;
use App\Api\v2\ApiHelper;
use App\Fee;
use App\Invoice;
use App\User;
use Exception;

class ApiFee {
    /*get fees*/
	public static function get($params = []) {
		return ApiHelper::get(Fee::query(), $params);
	}
}
