<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\Historical;
use DB;

class ApiHistorical {
	public static function get($params = []) {
		$query = Historical::select(DB::raw('historicals.*'))
			->leftJoin('historical_categories', 'historical_categories.id', '=', 'historicals.historical_category_id');
		
		return ApiHelper::get($query, $params);
	}
	
	public static function add($params = []) {
		$item = Historical::create($params);
		$item->save();
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = Historical::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
	
	public static function delete($id) {
		$item = Historical::find($id);
		$item->delete();
		
		return true;
	}
}