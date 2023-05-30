<?php

namespace App\Http\Controllers\Api\v3;

use Arxmin\models\Arxmin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Api\ApiToken;
use Session;

class ApiExternalUsersController extends Controller
{
    /**
     * Login User and define a token lifetime (by default request = 6h, access_client = 6h, access_transporter = 14h, refresh_token = 90d)
     *
     * @param string $token (required) Request token.
     * @param string $email (required) Email.
     * @param string $password (required) Password.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $app = Session::get('token')->app()->first();
        $auth = Arxmin::getAuth();
        if ($auth->attempt($credentials) && $auth->getUser()->role == 'API') {
            $access_token = $auth->getUser()->getApiAccessToken($app);
            $refresh_token = $auth->getUser()->getApiRefreshToken($app);
            $data = [
                'access_token' => $access_token->token,
                'refresh_token' => $refresh_token->token,
            ];

            return new Response($data, 201);
        }
        $data = [
            "error" => "Login failed"
        ];
        return new Response($data, 400);
    }

    /**
     * Refresh access token.
     *
     * @param string $token (required) Refresh token.
     */
    public function refreshToken(Request $request)
    {
        if (Session::get('token')->type != ApiToken::TYPE_REFRESH) {
            return new Response('Token invalid', 400);
        }

        $user = Arxmin::getAuth()->getUser();
        $app = Session::get('token')->app()->first();

        $data = [
            "access_token" => $user->getApiAccessToken($app)->token,
        ];

        return new Response($data, 200);
    }
}
