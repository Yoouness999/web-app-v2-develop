<?php
namespace App\Api\v2;

use App\UnavailableDate;
use DateInterval;
use DatePeriod;
use DateTime;
use App\Api;

class ApiUnavailableDate {

	public static function get($params = []){
		return ApiHelper::get(UnavailableDate::query(), $params);
	}

	public static function add($params = []) {

		if (isset($params['date_start']) && isset($params['date_end'])) {

            if ($params['date_start'] == $params['date_end']) {
                $item = UnavailableDate::create([
                    'date' => $params['date_start']
                ]);
                $item->save();

                return $item;
            }

		    $datetime_start = new DateTime($params['date_start']);

            if ($datetime_start->format("H") % 2 !== 0) {
                $datetime_start->modify('+1 hour');
            }

		    $datetime_end = new DateTime($params['date_end']);

            if ($datetime_end->format("G") % 2 !== 0) {
                $datetime_end->modify('+1 hour');
            }

            $sameDay = $datetime_start->format("Y-m-d") === $datetime_end->format("Y-m-d");

            if (!$sameDay) {
                $datetime_end = $datetime_end->modify('+1 day');
            }


            /**
             * If start day is > 0 => we need to fill period till midnight
             *
             * Ex : if 2018-06-14 10:00:00 => we need to generate date every 2 hours for the rest of the days
             */

            if ($datetime_start->format("G") !== "0" && !$sameDay) {
                $period = new DatePeriod(
                    $datetime_start,
                    new DateInterval('PT2H'),
                    new DateTime($datetime_start->format("Y-m-d"). "23:59:59")
                );

                foreach ($period as $datetime) {
                    $item = UnavailableDate::updateOrCreate(['date' => $datetime->format('Y-m-d H:i:s')]);
                    $item->save();
                }
            }

            if ($datetime_start->format("G") !== "0" && $sameDay) {
                $period = new DatePeriod(
                    $datetime_start,
                    new DateInterval('PT2H'),
                    new DateTime($datetime_end->format("Y-m-d H:i:s"))
                );

                foreach ($period as $datetime) {
                    $item = UnavailableDate::updateOrCreate(['date' => $datetime->format('Y-m-d H:i:s')]);
                    $item->save();
                }
            }

            if ($datetime_end->format("G") !== "0" && !$sameDay) {
                $period =  new DatePeriod(
                    new DateTime($datetime_end->format("Y-m-d"). "00:00:00"),
                    new DateInterval('PT2H'),
                    $datetime_end
                );
                foreach ($period as $datetime) {
                    $item = UnavailableDate::updateOrCreate(['date' => $datetime->format('Y-m-d H:i:s')]);
                    $item->save();
                }
            }

            if (!$sameDay) {

                if ($datetime_start->format("G") !== "0") {
                    $datetime_start = $datetime_start->modify("+1 day");
                }

                if ($datetime_end->format("G") !== "0") {
                    $datetime_end = $datetime_end->modify("-1 day");
                }

                $period = new DatePeriod(
                    $datetime_start,
                    new DateInterval('P1D'),
                    $datetime_end
                );

                foreach ($period as $datetime) {
                    $item = UnavailableDate::updateOrCreate(['date' => $datetime->format('Y-m-d'). " 00:00:00"]);
                    $item->save();
                }
            }

        } else {
            $item = UnavailableDate::create($params);
            $item->save();
        }

		return $item;
	}

	public static function save($id, $params = []) {
		$item = UnavailableDate::find($id);
		$item = $item->fill($params);
		$item->save();

		return $item;
	}

    public static function delete($id) {
        $item = UnavailableDate::find($id);
        $item->delete();
        return true;
    }
}
