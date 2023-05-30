<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\EventGuest;

class ApiEventGuest {
	public static function get($params = []) {
		return ApiHelper::get(EventGuest::query(), $params);
	}
	
	public static function add($params = []) {
		$item = EventGuest::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = EventGuest::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}