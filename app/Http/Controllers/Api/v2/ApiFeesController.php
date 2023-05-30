<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use App\Api\v2\ApiFee;

class ApiFeesController extends Controller {

    /**
     * Get available fees list
     */
    public function getList(){
        $data = lg("fees");
        return ApiHelper::response($data);
	}

	/**
	 * Add a fee AND generate an invoice of type = fees
	 *
	 * @param string $name (required) Name.
	 * @param string $user_id (required) Customer.
	 * @param string $item_id (required) Item.
	 * @param string $type (optionnal) Type.
	 * @param string $ref (optionnal) Reference.
	 * @param string $price (optionnal) Price.
	 * @param string $nb (optionnal) Quantity.
	 * @param string $status (optionnal) Status: settlement_confirmed...
	 * @param string $created_at (optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.
	 * @param string $updated_at (optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.
	 */
	public function add(Request $request) {
		$item = ApiFee::add($request->all());

		return ApiHelper::response($item);
	}
}
