<?php

namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiNotification;
use Auth;

class ApiNotificationsController extends Controller
{
    /**
     * Get notification
     *
     * @param string $token (required) Access token.
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);

        $data = ApiNotification::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Update a notification
     *
     * @param string $token (required) Access token.
     * @param int $id (required) Id.
     * @param string $slug (optionnel) slug
     * @param string $detail_json (optionnel) details in json
     */
    public function save(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        unset($params['id']);

        $item = ApiNotification::save($id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Add a notification
     *
     * @return array
     * @param string $token (required) Access token.
     * @param string $slug (required) slug
     * @param string $detail_json (required) details in json
     *
     */
    public function add(Request $request)
    {
        $params = $request->all();
        $user = Auth::user();

        $params['user_id'] = $user->id;

        $item = ApiNotification::add($params);

        return ApiHelper::response($item->toArrayApi());
    }
}
