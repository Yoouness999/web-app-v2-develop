<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\User;
use App\OrderStoringDuration;
use Lang;
use Config;
use Datetime;

class ApiUser {
	public static function get($params = []) {
		return ApiHelper::get(User::query(), $params);
	}
	
	public static function add($params = []) {
		$item = User::create($params);
		
		if (isset($params['password'])) {
			$item->password = bcrypt($params['password']);
		}
		
		$item->save();
		
		return $item;
	}
	
	public static function save($item, $params = []) {
		
		/* Update end commitment period */
		
		if (isset($params['order_storing_duration_id'])) {
			$storingDuration = OrderStoringDuration::find($params['order_storing_duration_id']);
			
			$item->updateStoringDuration($storingDuration);
		}
		
		/* Save other params */
		
		$item = $item->fill($params);
		
		if (isset($params['password'])) {
			$item->password = bcrypt($params['password']);
		}
		
		$item->save();
		
		return $item;
	}
	
	public static function cities($locale = null) {
		if (!$locale) {
			$locale = Config::get('app.locale');
		}
		
		return Lang::get('cities', [], $locale);
	}
}