<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\OrderQuestion;

class ApiOrderQuestion {
	public static function get($params = []) {
		return ApiHelper::get(OrderQuestion::query()->where('visible', true)->orderBy('sequence'), $params);
	}
	
	public static function add($params = []) {
		$item = OrderQuestion::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderQuestion::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}