<?php
namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiOrderAssurance;
use App\Http\Controllers\Profile\ApiProfileController;
use Session;
use Auth;
use User;

class ApiOrderAssurancesController extends Controller {
	/**
	 * Get assurances
	 *
	 * @param string $token (required) Access token.
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 * @param string $locale (optionnal) lang : en, fr, nl. default : en.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderAssurance::get($params);
		
		return ApiHelper::response($data);
	}
	/**
	 * update assurance user
	 *
	 * @param string $token (required) Access token.
	 * @param string $insurance (required) slug of new assurance
	 */
	public function updateUser(Request $request) {

		$params=$request->all();
		//check if $token is empty
		if(empty($params['token']))
		{
			$data=array("message"=>"Token not found","sub_error"=>0, "status"=>400);
			return ApiHelper::response($data,400);
		}
		//check token
		if(!Session::get('token')->isValid())
		{
			$data=array("message"=>"Token Expired","sub_error"=>1, "status"=>400);
			return ApiHelper::response($data,400);
		}

		/** 
		*	@var User user */
		$user = Auth::getUser();
		$APC= new ApiProfileController();
		return $APC->postInsurance($request);
	}
}