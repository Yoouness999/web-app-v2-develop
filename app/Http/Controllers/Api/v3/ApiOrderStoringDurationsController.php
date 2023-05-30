<?php
namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiOrderStoringDuration;
use App\Http\Controllers\Profile\ApiProfileController;
use Session;
use Auth;
use User;

class ApiOrderStoringDurationsController extends Controller {
	/**
	 * Get storing durations.
	 *
	 * @param string $token (required) Access token.
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderStoringDuration::get($params);
		
		return ApiHelper::response($data);
	}
	
	/**
	 * Add a storing duration.
	 *
	 * @param string $slug (required) Slug, unique.
	 * @param int $discount_percentage (required) Discount percentage.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiOrderStoringDuration::add($request->all());
		
		return ApiHelper::response($item);
	}
	
	/**
	 * Save a storing duration.
	 *
	 * @param int $id (required) Id.
	 * @param string $slug (optionnal) Slug, unique.
	 * @param int $discount_percentage (optionnal) Discount percentage.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);
		
		$item = ApiOrderStoringDuration::save($id, $params);
		
		return ApiHelper::response($item);
	}
	/**
	 * update storing duration of user
	 *
	 * @param string $token (required) Access token.
	 * @param string $storing_duration (required) slug of new storing duration
	 */
	public function updateUser(Request $request)
	{
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
		return $APC->postStoringDuration($request);
	}
}