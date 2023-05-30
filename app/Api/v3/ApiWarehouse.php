<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\Pickup;
use App\Warehouse;
use Datetime;

class ApiWarehouse {

    public static function delete($id)
    {

        $warehouse = Warehouse::find($id);

        return $warehouse->delete();
    }

    public static function save($id, $params = []) {
		$warehouse = Warehouse::find($id);
		$warehouse = $warehouse->fill($params);
		$warehouse->save();

		return $warehouse;
	}

    public static function add($params = []) {

        $warehouse = new Warehouse();
        $warehouse = $warehouse->fill($params);
        $warehouse->save();

        return $warehouse;
    }

    public static function get($params = []) {
        return ApiHelper::get(Warehouse::query(), $params);
    }

    public static function all($params = []) {
        return ApiHelper::get(Warehouse::query(), $params);
    }
}
