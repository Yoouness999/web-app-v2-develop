<?php

namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiArea;

class ApiAreasController extends Controller
{
    /**
     * Get areas
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);
        $data = ApiArea::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Add a area.
     *
     * @param string $slug unique slug of the areas (required)
     * @param array $name Name associated to the areas (format ["en" => ["name"=>"Brussels"],"fr" => ["name" => "Bruxelles"]] (required)
     * @param string $zip_code Zipcode of the area (required)
     * @param integer $region_id Region ID where the area belong (optionnal)
     */
    public function add(Request $request)
    {
        $item = ApiArea::add($request->all());
        return ApiHelper::response($item);
    }

    /**
     * Save a area.
     *
     * @param integer $id (required)
     * @param string $slug unique slug of the areas (required)
     * @param array $name Name associated to the areas (format ["en" => ["name"=>"Brussels"],"fr" => ["name" => "Bruxelles"]] (required)
     * @param string $zip_code Zipcode of the area (required)
     * @param integer $region_id Region ID where the area belong (optionnal)
     */
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $params['id'];
        unset($params['id']);

        $item = ApiArea::save($id, $params);

        return ApiHelper::response($item);
    }

    /**
     * Delete area
     *
     * @param string $id id of the area to delete
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){

        $item = ApiArea::delete($request->get('id'));

        return ApiHelper::response($item);
    }
}
