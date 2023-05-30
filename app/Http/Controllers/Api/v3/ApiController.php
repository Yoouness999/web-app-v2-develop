<?php
namespace App\Http\Controllers\Api\v3;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Api\ApiApp;

class ApiController extends Controller {
	/**
	 * Get request token.
	 *
	 * @param string $app_id (required) App id.
	 * @param string $app_secret (required) App secret.
	 */
	public function token(Request $request) {
        /**
         * @var $apiApp ApiApp
         */
		$apiApp = ApiApp::where('app_id', $request->get('app_id'))
			->where('app_secret', $request->get('app_secret'))
			->first();
		
		if (!$apiApp) {
			return new Response('Unauthorized action', 403);
		}
		
		$token = $apiApp->getApiToken();
		
		return response()->json(['token' => $token->token], 200);
	}
}