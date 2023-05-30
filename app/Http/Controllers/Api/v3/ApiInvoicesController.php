<?php
namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiInvoice;

class ApiInvoicesController extends Controller {
	/**
	 * Get invoices : works only for user. Return his invoices	 
	 *
	 * @param string $token (required) Access token.
	 * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
	 * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
	 * @param int $page (optionnal) Current page for pagination.
	 * @param int $items_by_page (optionnal) Items by page for pagination.
	 * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
	 */
	public function get(Request $request) {

		if (Session::get('token')->isClientAccess()) {

			$user = Auth::user();
		
			$params = ApiHelper::getParamsFromRequest($request);

				//on force qu'un token utilisateur n'accède qu'à ses propres factures
			$params['filters'][] = [
				'attribute' => 'user_id',
				'operator' => '=',
				'value' => $user->id
			];

			$data = ApiInvoice::get($params);
		
			return ApiHelper::response($data);
		}
	}
	

}