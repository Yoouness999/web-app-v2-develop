<?php

namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiRegion;

class ApiRegionsController extends Controller
{
    /**
     * Get Regions (link between id and name)
     *
     * @param string $token (required) Access token.
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);
        $data = ApiRegion::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Add a Region.
     *
     * @param integer $id
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $item = ApiRegion::add($request->all());
        return ApiHelper::response($item);
    }

    /**
     * Save a Region.
     *
     * @param integer $id
     * @param string $name
     */
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];
        unset($params['id']);

        $item = ApiRegion::save($id, $params);

        return ApiHelper::response($item);
    }

    /**
     * Delete Region
     *
     * @param string $id id of the Region to delete
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){

        $item = ApiRegion::delete($request->get('id'));

        return ApiHelper::response($item);
    }
}
