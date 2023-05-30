<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiRegion;

class ApiRegionsController extends Controller
{
    /**
     * Get Regions
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
