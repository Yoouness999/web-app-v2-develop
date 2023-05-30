<?php
namespace App\Api\v3;

use App\Region;

class ApiRegion {

	public static function get($params = []) {
		return ApiHelper::get(Region::query(), $params);
	}

	public static function add($params = []) {
		$item = Region::create($params);
		$item->save();
		return $item;
	}

	public static function save($id, $params = []) {
		$item = Region::find($id);
		$item = $item->fill($params);
		$item->save();

		return $item;
	}

    public static function delete($id)
    {
        $item = Region::find($id);
        $item->delete();
        return true;
    }
}
