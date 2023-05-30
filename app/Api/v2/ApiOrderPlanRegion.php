<?php
namespace App\Api\v2;

use App\OrderPlanRegion;
use App\User;
use App\Region;

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
		
	/**
	 * Get plans by region
	 *
     * @param $user_id User
     */
	public static function getByRegion($params = [], $user_id) {
		$planRegions = OrderPlanRegion::query();
		$region = Region::getDefaultRegion();
		
		if ($user = User::find($user_id)) {
			if ($userRegion = $user->getRegion()) {
				$region = $userRegion;
			}
		}
		
		$planRegions = $planRegions->where('region_id', $region->id)->where('price_per_month', ">", 0)->orderBy('price_per_month');
		
		return ApiHelper::get($planRegions, $params);
	}
}
