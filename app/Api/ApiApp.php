<?php
namespace App\Api;

use Illuminate\Database\Eloquent\Model;
use App\Api\ApiToken;

class ApiApp extends Model {
	
	/**
	 * Gett request token
	 */
	public function getApiToken() {
		$token = new ApiToken();
		$token->type = ApiToken::TYPE_REQUEST;
		$token->setToken();
		$token->app()->associate($this);
		$token->save();
		
		return $token;
	}
}