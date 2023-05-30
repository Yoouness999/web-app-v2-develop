<?php
namespace App\Api\v3;

use App\Notification;

class ApiNotification {
	
	public static function save($id, $params = []) {
		$notification = Notification::find($id);
		$notification = $notification->fill($params);
		$notification->save();
		
		return $notification;
	}

    public static function add($params = []) {

        $notification = new Notification();
        $notification = $notification->fill($params);
        $notification->save();

        return $notification;
    }

    public static function get($params = []) {
        return ApiHelper::get(Notification::query(), $params);
    }

    public static function all($params = []) {
        return ApiHelper::get(Notification::query(), $params);
    }
}