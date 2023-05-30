<?php
namespace App\Http\Controllers\Api\v2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Api\v2\ApiHelper;
use Datetime;

class ApiController extends Controller {
	/**
	 * Get server time.
	 */
	public function getServerTime(Request $request) {
		$data = new Datetime();

		return ApiHelper::response($data);
	}
}
