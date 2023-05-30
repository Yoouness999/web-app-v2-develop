<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\OrderPlan;
use App\User;
use Exception;

class ApiOrderPlan {

	public static function get($params = []) {
		return ApiHelper::get(OrderPlan::query(), $params);
	}

	public static function add($params = [], $image = null) {

        if (isset($params['order_plan_assets'])) {
            $order_plan_assets = $params['order_plan_assets'];
            unset($params['order_plan_assets']);
        }

		$item = OrderPlan::create($params);
		$item->save();

        if (isset($order_plan_assets)) {
            $item->assets()->sync($order_plan_assets);
        }

        if ($image) {
            self::uploadeImage($item, $image);
        }

		return $item;
	}

	public static function save($id, $params = [], $image = null) {

        if (isset($params['order_plan_assets'])) {
            $order_plan_assets = $params['order_plan_assets'];
            unset($params['order_plan_assets']);
        }

		$item = OrderPlan::find($id);

        if ($params) {
            $item = $item->fill($params);
            $item->save();
        }

        if (isset($order_plan_assets)) {
            $item->assets()->sync($order_plan_assets);
        }

        if ($image) {
            self::uploadeImage($item, $image);
        }

		return $item;
	}


    public static function delete($id)
    {
        $item = OrderPlan::find($id);

        /**
         * Check if any user is linked to the current plan
         */
        if (User::where('order_plan_id', $id)->exists()) {
            return false;
        }

        /*
         * Else try to make a soft delete
         */
        try {
            $item->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $item OrderPlan
     * @param $photo
     */
    public static function uploadeImage($item, $photo){

        if ($photo && $photo->isValid()) {
            $photo->move($item->path(), $photo->getClientOriginalName());
            $path = '/files/order_plans/' . $item->id . '/';
            $item->image = $path. $photo->getClientOriginalName();
        }

        $item->save();
    }
}
