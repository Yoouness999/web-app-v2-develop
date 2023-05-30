<?php
namespace App\Api\v3;

use App\Api\v3\ApiHelper;
use Arxmin\models\Arxmin;
use App\ArxminUser;
use App\BookingItemStatusHistory;
use App\Pickup;
use App\Item;
use Datetime;

class ApiPickup extends \App\Api\v2\ApiPickup {

	/**
	 * Get pickups
	 *
     * @param $user User
     * @param array $params
     * @return \Illuminate\Support\Collection
     */
	public static function get($params = []) {
		return ApiHelper::get(Pickup::query(), $params);
	}

    /**
     * @param $arxminUser ArxminUser
     * @param array $params
     * @return \Illuminate\Support\Collection
     */
	public static function getTransporterPickups($arxminUser, $params = []) {
		$pickups = $arxminUser->transporterPickups();

		return ApiHelper::get($pickups, $params);
	}

	public static function save($id, $params = []) {
		$pickup = Pickup::find($id);
		$pickup = $pickup->fill($params);
		$pickup->save();
		
		if ($pickup->status === Pickup::STATUS_DONE
                    && $pickup->type === Pickup::TYPE_DROP_OFF_DELIVERY) {
			$user = Arxmin::getAuth()->getUser();
            foreach ($pickup->itemsRecords as $item) {
                if ($item->status !== Item::STATUS_TRANSIT) {
                    continue;
                }
				$bookingItemStatusHistory = new BookingItemStatusHistory();
				$bookingItemStatusHistory->create([
					'status' => $item->status,
					'booking_id' => $pickup->id,
					'item_id'   => $item->id,
					'arxmin_user_id' => $user->id
				]);

                $item->status = Item::STATUS_INDEXED;
				$item->save();
            }
		}
		return $pickup;
	}


    public static function store($params = []) {

        $pickup = new Pickup();
        $pickup = $pickup->fill($params);
        $pickup->save();

        return $pickup;
    }

	public static function timeSlots($params) {

		$from = new Datetime($params['from']);
		$from->setTime(0, 0, 0);
		
		$to = clone($from);
		if($params['to'] == null) {
			$to->modify('+1 day');
		} else {
			$to = new Datetime($params['to']);
		}
		$to->setTime(0, 0, 0);
		

		$timeSlots = Pickup::getTimeSlots($from, $to);
		$groupByDay = [];

		foreach ($timeSlots as $timeSlot) {
			$groupByDay[$timeSlot['from']->format('Y-m-d')][] = [
				'hoursStart' => $timeSlot['from']->format('H:i'),
				'hoursEnd' => $timeSlot['to']->format('H:i')
			];
		}

		return $groupByDay;
	}
}
