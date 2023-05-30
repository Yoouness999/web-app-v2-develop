<?php
namespace App\Http\Controllers\Api\v2;

use App\Api\v2\ApiUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiOrderPlan;

class ApiOrderPlansController extends Controller {
	/**
	 * Get plans.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderPlan::get($params);

		return ApiHelper::response($data);
	}

	/**
	 * Add a plan.
	 *
	 * @param int $order_plan_category_id (required) Category.
	 * @param string $slug (required) Slug, unique.
	 * @param double $volume_m3 (required) Volume m3.
	 * @param double $price_per_month (required) Price per month in euros.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $order_plan_assets (optionnal) array of order_plan_assets with ids.
	 */
	public function add(Request $request) {
		$item = ApiOrderPlan::add($request->all());

		return ApiHelper::response($item);
	}

	/**
	 * Save a plan.
	 *
	 * @param int $id (required) Id.
	 * @param int $order_plan_category_id (optionnal) Category.
	 * @param string $slug (optionnal) Slug, unique.
	 * @param double $volume_m3 (optionnal) Volume m3.
	 * @param double $price_per_month (optionnal) Price per month in euros.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);

        $params = array_merge($params, ApiHelper::uploadFiles('orderplans', $id));

		$item = ApiOrderPlan::save($id, $params);

		return ApiHelper::response($item);
	}

    /**
     * Delete Plan
     *
     * @param string $id id of the Plan to delete
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request){

        $item = ApiOrderPlan::delete($request->get('id'));

        return ApiHelper::response($item);
    }
}
