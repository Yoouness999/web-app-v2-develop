<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\OrderAssurance;

class ApiOrderAssurance {
	public static function get($params = []) {
		return ApiHelper::get(OrderAssurance::query(), $params);
	}
	
	public static function add($params = []) {
		$item = OrderAssurance::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderAssurance::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}