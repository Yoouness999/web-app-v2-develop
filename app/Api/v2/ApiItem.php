<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\BookingItemStatusHistory;
use App\Item;
use Lang;
use Config;

class ApiItem {
	public static function get($params = []) {
		return ApiHelper::get(Item::query(), $params);
	}

	public static function add($params = [], $photo = null) {
		$item = Item::create($params);
        $item->save();
        if (array_key_exists('pickup_id', $params)) {
            $item->pickup()->sync($params['pickup_id']);
            $bookingItemStatusHistory = new BookingItemStatusHistory();
            $bookingItemStatusHistory->create([
                'status' => $item->status,
                'booking_id' => $params['pickup_id'],
                'item_id'   => $item->id
            ]);
        }
		$item->save();

		if ($photo && $photo->isValid()) {
			$photo->move($item->path(), $photo->getClientOriginalName());

			$item->photo = $photo->getClientOriginalName();
			$item->save();
		}

		return $item;
	}

	public static function save($id, $params = [], $photo = null) {
		$item = Item::find($id);
		$item = $item->fill($params);

		if ($photo && $photo->isValid()) {
			$photo->move($item->path(), $photo->getClientOriginalName());
			$item->photo = $photo->getClientOriginalName();
		}

		$item->save();

		return $item;
	}

	public static function types($locale = null) {
		if (!$locale) {
			$locale = Config::get('app.locale');
		}

		$types = Lang::get('types', [], $locale);

		foreach ($types as &$type) {
			$type['thumb'] = url($type['thumb']);
		}

		return $types;
	}

	public static function statuses() {
		return [
			Item::STATUS_IN_TRANSIT,
			Item::STATUS_DELIVERED,
			Item::STATUS_STORED
		];
	}

	public static function pickupOptions() {
		return [
			Item::PICKUP_OPTION_DELAYED,
			Item::PICKUP_OPTION_DIRECT
		];
	}

    public static function delete($id) {
        $item = Item::find($id);
        $item->delete();
        return true;
    }
}
