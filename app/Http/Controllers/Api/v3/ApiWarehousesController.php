<?php

namespace App\Http\Controllers\Api\v3;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiWarehouse;

class ApiWarehousesController extends Controller
{
    /**
     * Get warehouse
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

        $data = ApiWarehouse::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Update a warehouse
     *
     * @param string $token (required) Access token.
     * @param int $id (required) Id.
     * @param ref $ref (optionnal) Reference
     * @param string $name (optionnal) Complete name of the warehouse.
     * @param string $country (optionnal) country of the warehouse.
     * @param string $city (optionnal) city of the warehouse.
     * @param string $number (optionnal) number of the warehouse.
     * @param string $street (optionnal) street of the warehouse.
     * @param string $latitude (optionnal) latitude of the warehouse.
     * @param string $longitude (optionnal) longitude of the warehouse.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function save(Request $request)
    {
        $params = $request->all();

        $id = $params['id'];
        unset($params['id']);

        $item = ApiWarehouse::save($id, $params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Add a pickup.
     *
     * @param string $token (required) Access token.
     * @param string $ref (optionnal) Reference of warehouse (3 letters).
     * @param string $name (optionnal) Complete name of the warehouse.
     * @param string $country (optionnal) country of the warehouse.
     * @param string $city (optionnal) city of the warehouse.
     * @param string $number (optionnal) number of the warehouse.
     * @param string $street (optionnal) street of the warehouse.
     * @param string $latitude (optionnal) latitude of the warehouse.
     * @param string $longitude (optionnal) longitude of the warehouse.
     * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     *
     * @return array
     */
    public function add(Request $request)
    {
        $params = $request->all();

        $item = ApiWarehouse::add($params);

        return ApiHelper::response($item->toArrayApi());
    }

    /**
     * Delete an user
     *
     * @param int $id (required) Id.
     * @return array
     */
    public function delete(Request $request) {
        $item = ApiWarehouse::delete($request->get('id'));

        return ApiHelper::response($item);
    }
}
