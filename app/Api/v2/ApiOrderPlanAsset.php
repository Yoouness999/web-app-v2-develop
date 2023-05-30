<?php

namespace App\Api\v2;

use App\OrderPlanAsset;

class ApiOrderPlanAsset
{

    public static function add($params = [])
    {
        $item = OrderPlanAsset::create($params);
        $item->save();

        return $item;
    }

    public static function get($params = [])
    {
        return ApiHelper::get(OrderPlanAsset::query(), $params);
    }

    public static function save($id, $params = [])
    {

        $item = OrderPlanAsset::find($id);
        $item = $item->fill($params);
        $item->save();

        return $item;
    }
}
