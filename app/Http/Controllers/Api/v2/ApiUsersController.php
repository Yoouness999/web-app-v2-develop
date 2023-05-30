<?php

namespace App\Http\Controllers\Api\v2;

use App\Http\Requests\FeeCreateRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiUser;
use Auth;
use Modules\Boxifymanager\Http\Requests\CreateFeeRequest;

class ApiUsersController extends Controller
{
    /**
     * Get users.
     *
     * @param string  $filters       (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string  $order         (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int     $page          (optionnal) Current page for pagination.
     * @param int     $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first         (optionnal) Force the results to only one item. Not working with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);
        if (!isset($params['deep'])) {
            $params['deep'] = 15;
        }
        $data = ApiUser::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Delete an user
     *
     * @param int $id (required) Id.
     *
     * @return array
     */
    public function delete(Request $request)
    {
        $item = ApiUser::delete($request->get('id'));

        return ApiHelper::response($item);
    }

    /**
     * Add a user.
     *
     * @param string  $email              (required) Email, unique.
     * @param string  $name               (required) Name.
     * @param string  $first_name         (optionnal) First name.
     * @param string  $last_name          (optionnal) Last name.
     * @param string  $postalcode         (optionnal) Postal code.
     * @param string  $add_infos          (optionnal) Infos added.
     * @param string  $city               (optionnal) City.
     * @param string  $box                (optionnal) Box.
     * @param string  $number             (optionnal) Number.
     * @param string  $street             (optionnal) Street.
     * @param string  $latitude           (optionnal) Latitude.
     * @param string  $longitude          (optionnal) Longitude.
     * @param string  $phone              (optionnal) Phone.
     * @param string  $godfather_id       (required) User godfather.
     * @param string  $lang               (required) Lang.
     * @param boolean $business           (optionnal) Business: 1 or 0.
     * @param string  $password           (required) Password.
     * @param int     $active             (optionnal) Active: 1 or 0.
     * @param string  $status             (optionnal) Status: active or empty.
     * @param string  $avg_card           (optionnal) Avantage card.
     * @param string  $last_order         (optionnal) Last order date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string  $country            (optionnal) Country.
     * @param string  $customer_type      (optionnal) Customer type : private or professionnal. Default value is private.
     * @param string  $id_card_file_recto (optionnal) ID Card file recto.
     * @param string  $id_card_file_verso (optionnal) ID Card file verso.
     * @param string  $oauth_id           (optionnal) Facebook id.
     * @param string  $created_at         (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string  $updated_at         (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string  $deleted_at         (optionnal) Deleted date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function add(Request $request)
    {
        $item = ApiUser::add($request->all());

        $params = ApiHelper::uploadFiles('users', $item->id);
        $item = ApiUser::save($item->id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Save a user.
     *
     * @param int     $id                   (required) Id.
     * @param string  $email                (optionnal) Email, unique.
     * @param string  $name                 (optionnal) Name.
     * @param string  $first_name           (optionnal) First name.
     * @param string  $last_name            (optionnal) Last name.
     * @param string  $postalcode           (optionnal) Postal code.
     * @param string  $add_infos            (optionnal) Infos added.
     * @param string  $city                 (optionnal) City.
     * @param string  $box                  (optionnal) Box.
     * @param string  $number               (optionnal) Number.
     * @param string  $street               (optionnal) Street.
     * @param string  $latitude             (optionnal) Latitude.
     * @param string  $longitude            (optionnal) Longitude.
     * @param string  $phone                (optionnal) Phone.
     * @param string  $godfather_id         (optionnal) User godfather.
     * @param string  $lang                 (optionnal) Lang.
     * @param boolean $business             (optionnal) Business: 1 or 0.
     * @param string  $password             (optionnal) Password.
     * @param int     $active               (optionnal) Active: 1 or 0.
     * @param string  $status               (optionnal) Status: active or empty.
     * @param string  $avg_card             (optionnal) Avantage card.
     * @param string  $country              (optionnal) Country.
     * @param string  $customer_type        (optionnal) Customer type : private or professionnal. Default value is private.
     * @param file    $id_card_file_recto   (optionnal) ID Card file recto.
     * @param file    $id_card_file_verso   (optionnal) ID Card file verso.
     * @param string  $oauth_id             (optionnal) Facebook id.
     * @param string  $last_order           (optionnal) Last order date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string  $created_at           (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string  $updated_at           (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string  $deleted_at           (optionnal) Deleted date. Format: YYYY-MM-DD HH:MM:SS.
     * @param int     $order_plan_region_id Order Plan Region id
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];
        unset($params['id']);

        $params = array_merge($params, ApiHelper::uploadFiles('users', $id));

        $item = ApiUser::save($id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Get cities.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     * @internal param string $locale (optionnal) Locale: en, fr, nl. Default: en.
     */
    public function cities(Request $request)
    {
        $locale = null;

        if ($request->has('locale')) {
            $locale = $request->get('locale');
        }

        return ApiHelper::response(ApiUser::cities($locale));
    }

    /**
     * Login.
     *
     * @param string $email    (required) Email.
     * @param string $password (required) Password.
     */
    public function login(Request $request)
    {

        $credentials = [
            'email' => $request->get('password'),

        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $params = [
                'restricted' => true,
                'filters' => [
                    [
                        'attribute' => 'id',
                        'value' => $user->id,
                    ],
                ],
            ];

            $data = ApiUser::get($params);

            return ApiHelper::response($data);
        }

        return ApiHelper::response([], 400, 'Login failed');
    }

    public function autocompleteUser()
    {
        $users = User::query()
                     ->select('users.first_name', 'users.last_name', 'users.id')
                     ->get();

        $toReturn = [];
        $toReturn[] = ['text' => 'all', 'id' => 0];
        foreach ($users as $user) {
            $toReturn[] = ['text' => $user['first_name'].' '.$user['last_name'], 'id' => $user['id']];
        }

        return new JsonResponse([
            'data' => $toReturn,
            'status' => 200,
        ], 200);
    }
}
