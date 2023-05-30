<?php
namespace App\Http\Controllers\Api\v3;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiArxminUser;
use Arxmin\models\Arxmin;
use App\ArxminUser;
use App\Api\ApiToken;
use Session;

class ApiArxminUsersController extends Controller {
    /**
     * Get current transporter informations.
     *
     * @param string $token (required) Access token.
     * @return Response
     */
	public function current(Request $request) {
		$auth = Arxmin::getAuth();
		$user = $auth->getUser();
		$arxminUser = ArxminUser::find($user->id);

		return new Response($arxminUser->toArrayApi(), 200);
	}

    /**
     * Login.
     *
     * @param string $token (required) Request token.
     * @param string $email (required) Email.
     * @param string $password (required) Password.
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $app = Session::get('token')->app()->first();

        $auth = Arxmin::getAuth();
        if ($auth->attempt($credentials)) {

            $user = $auth->getUser();

			$params = [
                'deep' => 1,
				'restricted' => true,
				'filters' => [[
					'attribute' => 'id',
					'value' => $user->id
				]]
			];

			$data = ApiArxminUser::get($params);
			if (isset($data) && isset($data[0]) && $data[0]['role'] != 'API') {
				/**
                 * @var $access_token ApiToken
                 */
                $access_token = $auth->getUser()->getApiAccessToken($app);
                /**
                 * @var $refresh_token ApiToken
                 */
                $refresh_token = $auth->getUser()->getApiRefreshToken($app);

                $data = array_merge(
                    $auth->getUser()->toArray(),
                    [
                        'access_token' => $access_token->token,
                        'access_token_expiration_date' => $access_token ? $access_token->getExpirationDate()->format('c') : null,
                        'expires_in' => $access_token->getExpirationDate()->diffInSeconds(Carbon::now('Europe/Brussels')),
                        'refresh_token' => $refresh_token->token,
                        'refresh_token_expiration_date' => $refresh_token ? $refresh_token->getExpirationDate()->format('c') : null
                    ]
                );

                return new Response($data, 201);
			}
        }

        return new Response('Login failed', 400);
    }

    /**
     * Refresh access token.
     *
     * @param string $token (required) Refresh token.
     * @return Response
     */
	public function token(Request $request) {
		if (Session::get('token')->type != ApiToken::TYPE_REFRESH) {
			return new Response('Token invalid', 400);
		}

		$auth = Arxmin::getAuth();
		$user = $auth->getUser();
		$arxminUser = ArxminUser::find($user->id);
		$app = Session::get('token')->app()->first();

		$data = $arxminUser->getApiAccessToken($app)->token;

		return new Response($data, 200);
	}

    /**
     * Get transporter pickups.
     *
     * @param string $token (required) Access token.
     * @param string $from (required) From. Format: YYYY-MM-DD HH:MM:SS.
     * @param string $to (required) To. Format: YYYY-MM-DD HH:MM:SS.
     * @return Response
     */
	public function pickups(Request $request) {
		$auth = Arxmin::getAuth();
		$user = $auth->getUser();
		$arxminUser = ArxminUser::find($user->id);

		$data = ApiArxminUser::pickups(
			$arxminUser,
			$request->get('from'),
			$request->get('to')
		);

		return new Response($data, 200);
	}
}
