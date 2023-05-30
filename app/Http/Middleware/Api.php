<?php
namespace App\Http\Middleware;

use Illuminate\Http\Response;
use App\Api\ApiApp;
use App\Api\ApiToken;
use Closure;
use Arxmin\models\Arxmin;
use App;
use Auth;
use Session;

class Api {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
		// v2

		if (strpos($request->url('/'), 'v2') !== false) {
			return $this->handleApiV2($request, $next);
		}

		// v3

		if (strpos($request->url('/'), 'v3') !== false) {
			return $this->handleApiV3($request, $next);
		}

        return $next($request);
    }

	/**
     * Handle an incoming request for Api v2
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	private function handleApiV2($request, $next) {

		if (!$request->has('app_id') && !App::environment('local')) {
			return new Response([
				'status' => 400,
				'message' => 'app_id not found.'
			], 400);
		}

		if (!$request->has('app_secret') && !App::environment('local')) {
			return new Response([
				'status' => 400,
				'message' => 'app_secret not found.'
			], 400);
		}

		$apiApp = ApiApp::where('app_id', $request->get('app_id'))
			->where('app_secret', $request->get('app_secret'))
			->where('api_version', 'v2')
			->first();

		if (!$apiApp && !App::environment('local')) {
			return new Response([
				'status' => 403,
				'message' => 'Unauthorized action.'
			], 403);
		}

		return $next($request);
	}

	/**
     * Handle an incoming request for Api v3
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	private function handleApiV3($request, $next) {

		if ($request->url('/') == url('/api/v3')) {
			return $this->handleApiV3GetRequestToken($request, $next);
		}

		return $this->checkApiV3AccessToken($request, $next);
	}

	/**
     * Handle an incoming request for Api v3 request token
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	private function handleApiV3GetRequestToken($request, $next) {
		if (!$request->has('app_id') && !App::environment('local')) {
			return new Response('app_id not found', 400);
		}

		if (!$request->has('app_secret') && !App::environment('local')) {
			return new Response('app_secret not found', 400);
		}

		return $next($request);
	}

	/**
     * Check Api v3 Token
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
	private function checkApiV3AccessToken($request, $next) {
		if (!$request->has('token')) {
			return new Response('Token not found', 400);
		}

        /**
         * @var $token ApiToken
         */
		$token = ApiToken::where('token', $request->get('token'))->get()->first();

		if (!$token || !$token->isValid()) {
			return new Response('Token expired', 400);
		}

		switch ($token->type) {
			case ApiToken::TYPE_REQUEST:
				if (!$token->app()->first() && !App::environment('local')) {
					return new Response('Unauthorized action', 403);
				}
				break;
			case ApiToken::TYPE_REFRESH:
			case ApiToken::TYPE_ACCESS:
				if ($token->isClientAccess()) {
					Auth::loginUsingId($token->getUser()->id);
				} elseif ($token->isTransporterAccess()) {
					$auth = Arxmin::getAuth();
					$auth->loginUsingId($token->getUser()->id);
				} else {
					return new Response('User not found', 400);
				}

				break;
		}

		Session::put('token', $token);

		return $next($request);
	}
}
