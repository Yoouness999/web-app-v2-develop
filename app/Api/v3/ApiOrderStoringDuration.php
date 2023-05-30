<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\OrderStoringDuration;

class ApiOrderStoringDuration {
	public static function get($params = []) {
		return ApiHelper::get(OrderStoringDuration::query(), $params);
	}
	
	public static function add($params = []) {
		$item = OrderStoringDuration::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderStoringDuration::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}