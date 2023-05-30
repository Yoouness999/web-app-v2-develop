<?php
namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiOrderCalculatorItem;

class ApiOrderCalculatorItemsController extends Controller {
	/**
	 * Get calculator items.
	 *
	 * @param string $token (required) Access token.
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 * @param string $lang (optionnal) Locale.
	 */
	public function get(Request $request) {
		$params = ApiHelper::getParamsFromRequest($request);
		$data = ApiOrderCalculatorItem::get($params);
		
		return ApiHelper::response($data);
	}
}