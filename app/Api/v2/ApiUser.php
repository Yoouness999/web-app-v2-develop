<?php

namespace App\Api\v2;

use App\Api;
use App\Api\v2\ApiHelper;
use App\Fee;
use App\Invoice;
use App\OrderPlanRegion;
use App\OrderStoringDuration;
use App\User;
use Lang;
use Config;

class ApiUser
{
    /**
     * @param array $params
     * @return \App\User
     */
    public static function add($params = [])
    {
        $item = User::create($params);

        if (isset($params['password'])) {
            $item->password = bcrypt($params['password']);
        }
        if (isset($params['order_insurance_custom_price']) && is_numeric($params['order_insurance_custom_price'])) {
            $item->order_insurance_custom_price = $params['order_insurance_custom_price'];
        }
        $item->save();

        self::handlePlan($item, $params);

        return $item;
    }

    /**
     * @param $item User
     * @param $params
     */
    public static function handlePlan($item, $params)
    {
        if (isset($params['order_storing_duration_id'])) {
            $orderStoringDuration = OrderStoringDuration::find($params['order_storing_duration_id']);

            if ($orderStoringDuration) {
                $item->updateStoringDuration($orderStoringDuration);
                $item->order_storing_duration_id = $orderStoringDuration->id;
                $item->save();
            }
        }

        if (isset($params['order_plan_region_id'])) {
            $orderPlanRegion = OrderPlanRegion::find($params['order_plan_region_id']);

            if ($orderPlanRegion) {
                $item->order_plan_id = $orderPlanRegion->order_plan_id;
                if (isset($params['order_plan_price_per_month']) && $item->fixed_price == 0) {
                    if ($item->old_pricing == 1) {
                        $item->order_plan_price_per_month = $orderPlanRegion->old_price_per_month;
                    } else {
                        $item->order_plan_price_per_month = $orderPlanRegion->price_per_month;
                    }
                }
                $item->save();
            }
        }
    }

    public static function cities($locale = null)
    {
        if (!$locale) {
            $locale = Config::get('app.locale');
        }

        return Lang::get('cities', [], $locale);
    }

    public static function delete($id)
    {
        /**
         * @var $item User
         */
        $item = User::withTrashed()->find($id);

        if ($item) {
            if ($item->deleted_at) {
                return Api::deleteUser($item->id);
            } else {
                $item->delete();
            }
        }

        return true;
    }

    public static function get($params = [])
    {
        return ApiHelper::get(User::query(), $params);
    }

    public static function save($id, $params = [])
    {
        $item = User::find($id);
        $item = $item->fill($params);

        if (isset($params['password'])) {
            $item->password = bcrypt($params['password']);
        }
        if (isset($params['order_insurance_custom_price']) && is_numeric($params['order_insurance_custom_price'])) {
            $item->order_insurance_custom_price = $params['order_insurance_custom_price'];
        }
        $item->save();

        self::handlePlan($item, $params);

        return $item;
    }
}
