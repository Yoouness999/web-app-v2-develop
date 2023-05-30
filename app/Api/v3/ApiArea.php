<?php
namespace App\Api\v3;

use App\Area;

class ApiArea {

	public static function get($params = []) {
		return ApiHelper::get(Area::query(), $params);
	}

	public static function add($params = []) {
		$item = Area::create($params);
		$item->save();
		return $item;
	}

	public static function save($id, $params = []) {
		$item = Area::find($id);
		$item = $item->fill($params);
		$item->save();

		return $item;
	}

    public static function delete($id)
    {
        $item = Area::find($id);
        $item->delete();
        return true;
    }
}
