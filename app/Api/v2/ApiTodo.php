<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\Todo;

class ApiTodo {
	public static function get($params = []) {
		return ApiHelper::get(Todo::query(), $params);
	}
	
	public static function add($params = []) {
		$item = Todo::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = Todo::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}