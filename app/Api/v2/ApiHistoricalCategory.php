<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\HistoricalCategory;

class ApiHistoricalCategory {
	public static function get($params = []) {
		return ApiHelper::get(HistoricalCategory::query(), $params);
	}
	
	public static function add($params = []) {
		$item = HistoricalCategory::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = HistoricalCategory::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}