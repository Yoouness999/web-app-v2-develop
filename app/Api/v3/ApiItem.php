<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use App\ArxminUser;
use App\BookingItemStatusHistory;
use App\Item;
use Lang;
use Config;

class ApiItem {
	public static function getClientItems($user, $params = []) {
		$items = $user->items();
		
		return ApiHelper::get($items, $params);
	}

    /**
     * @param $arxminUser ArxminUser
     * @param array $params
     * @return Illuminate\Support\Collection
     */
	public static function getTransporterItems($arxminUser, $params = []) {
		$pickups = $arxminUser->transporterPickups()->get();
		$ids = [];
		foreach ($pickups as $pickup) {
			$ids[] = $pickup->id;
		}
		
		$items = Item::where('pickup_id', $ids);
		
		return ApiHelper::get($items, $params);
	}
	
	public static function add($params = [])
    {
     	$item = Item::create($params);
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
		
		return $item;
	}
	
	public static function save($id, $params = []) {
		$item = Item::find($id);
		$item = $item->fill($params);
		$item->save();
		
		return $item;
	}
}