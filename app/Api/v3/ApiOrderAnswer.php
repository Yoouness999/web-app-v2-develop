<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\OrderAnswer;

class ApiOrderAnswer {
	public static function get($params = []) {
		return ApiHelper::get(OrderAnswer::query()->where('visible', true), $params);
	}
	
	public static function add($params = []) {
		$item = OrderAnswer::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = OrderAnswer::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}