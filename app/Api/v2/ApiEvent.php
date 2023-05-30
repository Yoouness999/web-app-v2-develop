<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\Event;

class ApiEvent {
	public static function get($params = []) {
		return ApiHelper::get(Event::query(), $params);
	}
	
	public static function add($params = []) {
		$item = Event::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = Event::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}