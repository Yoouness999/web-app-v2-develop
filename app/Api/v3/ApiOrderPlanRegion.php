<?php
namespace App\Api\v3;

use App\OrderPlanRegion;

class ApiOrderPlanRegion {

	public static function get($params = []) {
		return ApiHelper::get(OrderPlanRegion::query(), $params);
	}

	public static function add($params = []) {
		$item = OrderPlanRegion::create($params);
		$item->save();
		return $item;
	}

	public static function save($id, $params = []) {
		$item = OrderPlanRegion::find($id);
		$item = $item->fill($params);
		$item->save();

		return $item;
	}

    public static function delete($id)
    {
        $item = OrderPlanRegion::find($id);
        $item->delete();
        return true;
    }
}
