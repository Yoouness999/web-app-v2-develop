<?php
namespace App\Http\Controllers\Api\v2;

use App\ArxminPermission;
use App\ArxminUser;
use App\Http\Requests\EmailRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiArxminUser;
use Arxmin\models\Arxmin;

class ApiArxminUsersController extends Controller {
	/**
	 * Get transporters.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 * @param boolean $admin_excluded (optionnal) Force the results to exlude admin role.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$adminExcluded = isset($request->all()['admin_excluded']);

		$data = ApiArxminUser::get($params, $adminExcluded);

		return ApiHelper::response($data);
	}

	/**
	 * Add a transporter.
	 *
     * @param string $first_name (required) First Name.
     * @param string $last_name (required) Last Name.
	 * @param string $email (required) Email, unique.
	 * @param string $password (required) Password.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$params = array_merge(['role' => 'transporter'], $request->all());
		$item = ApiArxminUser::add($params);

		return ApiHelper::response($item->toArrayApi());
	}

	/**
	 * Save a transporter.
	 *
	 * @param int $id (required) Id.
	 * @param string $name (optionnal) Name.
	 * @param string $email (optionnal) Email, unique.
	 * @param string $password (optionnal) Password.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = array_merge(['role' => 'transporter'], $request->all());
		$id = $params['id'];
		unset($params['id']);

		// Api can edit transporter only
		$arxminUser = ApiArxminUser::get(['filters' => [['attribute' => 'id', 'value' => $id]], 'first']);

		/*if ($arxminUser->first()->role != 'transporter') {
			return ApiHelper::response([], 400, 'User selected is not a transporter');
		}*/

		$item = ApiArxminUser::save($id, $params);

		return ApiHelper::response($item->toArrayApi());
	}

    /**
     * Delete arxmin user (soft delete)
     *
     * @param int $id (required) Id.
     * @return array
     */
    public function delete(Request $request) {
        $arxminUser = ApiArxminUser::delete($request->get('id'));
        return ApiHelper::response($arxminUser);
    }

	/**
	 * Login.
	 *
	 * @param string $email (required) Email.
	 * @param string $password (required) Password.
	 */
	public function login(Request $request) {
		$credentials = $request->only('email', 'password');
		$auth = Arxmin::getAuth();

    	if($auth->attempt($credentials)) {
			$user = $auth->getUser();

			$params = [
                'deep' => 1,
				'restricted' => true,
				'filters' => [[
					'attribute' => 'id',
					'value' => $user->id
				]]
			];

			$data = ApiArxminUser::get($params);
			if (isset($data) && isset($data[0]) && $data[0]['role'] != 'API') {
				return ApiHelper::response($data);
			} else {
				return ApiHelper::response([], 400, 'Login failed');
			}
		}

		return ApiHelper::response([], 400, 'Login failed');
	}

    /**
     * Permissions
     *
     *
     */
    public function permissions(){

        $data = ArxminPermission::all();

        return ApiHelper::response($data);
	}

    /**
     * Reset arxmin user
     *
     * @param string $email (required) Email
     */
    public function reset(EmailRequest $request){

        $data = ApiArxminUser::resetPassword($request->get('email'));

        return ApiHelper::response($data);
	}
}
