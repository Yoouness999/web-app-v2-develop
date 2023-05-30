<?php

namespace App\Http\Controllers\Api\v2;

use App\Api\v2\ApiCountry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;

class ApiCountriesController extends Controller
{
    /**
     * Get areas
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);
        $data = ApiCountry::get($params);

        return ApiHelper::response($data);
    }
}
