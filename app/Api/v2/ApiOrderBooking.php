<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\OrderBooking;

class ApiOrderBooking {
	public static function get($params = []) {
		return ApiHelper::get(OrderBooking::query(), $params);
	}

	public static function add($params = []) {
		$item = OrderBooking::create($params);
		$item->save();

		return $item;
	}

	public static function save($id, $params = []) {
		$item = OrderBooking::find($id);
		$item = $item->fill($params);

        /**
         * @todo Add pickup info livreur
         */
		$item->save();

		return $item;
	}

    public static function delete($id) {
        $item = OrderBooking::find($id);
        $item->delete();
        return true;
    }

    public static function undelete($id) {
        $item = OrderBooking::withTrashed()->find($id);
        $item->restore();
        return true;
    }
}
