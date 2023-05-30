<?php
namespace App\Api\v2;

use App\Api\v2\ApiHelper;
use App\ArxminUser;

class ApiArxminUser {

    public static function get($params = [], $adminExcluded = false) {
		$query = ArxminUser::query();
		
		if ($adminExcluded) {
			$query = $query->where('role', '!=', 'admin');
		}
		
		return ApiHelper::get($query, $params);
	}

	public static function add($params = []) {
		$item = ArxminUser::create($params);

		if (isset($params['password'])) {
			$item->password = bcrypt($params['password']);
		}

		$item->save();

        if (isset($params['permissions'])) {
            $item->permissions()->sync($params['permissions']);
        }

		return $item;
	}

    public static function delete($id) {
        $item = ArxminUser::find($id);
        $item->delete();
        return true;
    }

    public static function resetPassword($email)
    {
        /**
         * @var $arxminUser ArxminUser
         */
        $arxminUser = ArxminUser::where('email', $email)->first();

        if ($arxminUser) {
            $token = $arxminUser->resetPassword();

            return $token;
        }

        return false;
    }

    public static function save($id, $params = []) {
		$item = ArxminUser::find($id);
		$item->fill($params);

		if (isset($params['password'])) {
			$item->password = bcrypt($params['password']);
		}

		$item->save();

        if (isset($params['permissions'])) {
            $item->permissions()->sync($params['permissions']);
        }

		return $item;
	}
}
