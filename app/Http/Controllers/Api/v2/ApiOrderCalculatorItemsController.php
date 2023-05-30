<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiOrderCalculatorItem;

class ApiOrderCalculatorItemsController extends Controller {
	/**
	 * Get calculator items.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderCalculatorItem::get($params);
		
		return ApiHelper::response($data);
	}
	
	/**
	 * Add a calculator item.
	 *
	 * @param int $order_calculator_category_id (required) Category.
	 * @param string $slug (required) Slug, unique.
	 * @param double $area_m2 (required) Area m2.
	 * @param double $volume_m3 (required) Volume m3.
	 * @param double $price (optionnal) Price.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiOrderCalculatorItem::add($request->all());
		
		return ApiHelper::response($item);
	}
	
	/**
	 * Save a calculator item.
	 *
	 * @param int $id (required) Id.
	 * @param int $order_calculator_category_id (optionnal) Category.
	 * @param string $slug (optionnal) Slug, unique.
	 * @param double $area_m2 (required) Area m2.
	 * @param double $volume_m3 (required) Volume m3.
	 * @param double $price (optionnal) Price.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);
		
		$item = ApiOrderCalculatorItem::save($id, $params);
		
		return ApiHelper::response($item);
	}
}