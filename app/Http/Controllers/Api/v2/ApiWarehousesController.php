<?php

namespace App\Http\Controllers\Api\v2;

use App\Api\v2\ApiHelper;
use App\Api\v3\ApiWarehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiWarehousesController extends Controller {
    /**
     * Get users.
     *
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request) {
        $params = ApiHelper::getParamsFromRequest($request);
        $data = ApiWarehouse::get($params);

        return ApiHelper::response($data);
    }
}
