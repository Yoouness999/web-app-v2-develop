<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiHistoricalCategory;

class ApiHistoricalCategoriesController extends Controller {
	/**
	 * Get historical categories.
	 *
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiHistoricalCategory::get($params);
		
		return ApiHelper::response($data);
	}
	
	/**
	 * Add a historical category.
	 *
	 * @param string $slug (required) Slug, unique.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiHistoricalCategory::add($request->all());
		
		return ApiHelper::response($item);
	}
	
	/**
	 * Save a historical category.
	 *
	 * @param int $id (required) Id.
	 * @param string $slug (required) Slug, unique.
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function save(Request $request) {
		$params = $request->all();
		$id = $params['id'];
		unset($params['id']);
		
		$item = ApiHistoricalCategory::save($id, $params);
		
		return ApiHelper::response($item);
	}
}