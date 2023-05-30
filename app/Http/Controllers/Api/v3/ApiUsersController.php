<?php

namespace App\Http\Controllers\Api\v3;

use App\Api;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Api\v3\ApiHelper;
use App\Api\v3\ApiUser;
use App\Api\ApiToken;
use Illuminate\Support\Facades\Auth;
use Session;

class ApiUsersController extends Controller
{
    /**
     * Get current user informations.
     *
     * @param string $token (required) Access token.
     */
    public function current(Request $request)
    {
        $user = Auth::user();

        return new Response($user->toArrayApi(), 200);
    }

    /**
     * Get users.
     *
     * @param string $token (required) Access Token.
     * @param string $filters (optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...
     * @param string $order (optionnal) Sort the result. Model: {attribute}:{way}
     * @param int $page (optionnal) Current page for pagination.
     * @param int $items_by_page (optionnal) Items by page for pagination.
     * @param boolean $first (optionnal) Force the results to only one item. Not working with pagination.
     */
    public function get(Request $request)
    {
        $params = ApiHelper::getParamsFromRequest($request);
        $data = ApiUser::get($params);

        return ApiHelper::response($data);
    }

    /**
     * Save informations of the current user.
     *
     * @param string $token (required) Access Token.
     * @param string $email (optionnal) Email, unique.
     * @param string $name (optionnal) Name.
     * @param string $first_name (optionnal) First name.
     * @param string $last_name (optionnal) Last name.
     * @param string $postalcode (optionnal) Postal code.
     * @param string $add_infos (optionnal) Infos added.
     * @param string $city (optionnal) City.
     * @param string $box (optionnal) Box.
     * @param string $number (optionnal) Number.
     * @param string $street (optionnal) Street.
     * @param string $latitude (optionnal) Latitude.
     * @param string $longitude (optionnal) Longitude.
     * @param string $phone (optionnal) Phone.
     * @param string $godfather_id (optionnal) User godfather.
     * @param string $lang (optionnal) Lang.
     * @param boolean $business (optionnal) Business: 1 or 0.
     * @param string $password (optionnal) Password.
     * @param int $active (optionnal) Active: 1 or 0.
     * @param string $status (optionnal) Status: active or empty.
     * @param string $avg_card (optionnal) Avantage card.
     * @param string $country (optionnal) Country.
     * @param string $customer_type (optionnal) Customer type : private or professionnal. Default value is private.
     * @param file $id_card_file_recto (optionnal) ID Card file recto.
     * @param file $id_card_file_verso (optionnal) ID Card file verso.
     * @param string $oauth_id (optionnal) Facebook id.
     * @param string $last_order (optionnal) Last order date. Format: YYYY-MM-DD HH:MM:SS.
     */
    public function save(Request $request)
    {
        $params = $request->all();
        $user = Auth::user();

        $params = array_merge($params, ApiHelper::uploadFiles('users', $user->id));

        $user = ApiUser::save($user, $params);

        return ApiHelper::response($user->toArrayApi());
    }


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

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            /**
             * @var $access_token ApiToken
             */
            $access_token = $user->getApiAccessToken($app);
            /**
             * @var $refresh_token ApiToken
             */
            $refresh_token = $user->getApiRefreshToken($app);

            /**
             * Change the structure of response data
             *
             * @see : http://pm2.cherrypulp.com/projects/543?modal=Task-10498-543
             */
            $data = [
                $user->toArray(),
                [
                    'access_token' => $access_token->token,
                    'access_token_expiration_date' => $access_token ? $access_token->getExpirationDate()->format('c') : null,
                    'expires_in' => Carbon::instance($access_token->getExpirationDate())->diffInSeconds(Carbon::now('Europe/Brussels')),
                    'refresh_token' => $refresh_token->token,
                    'refresh_token_expiration_date' => $refresh_token ? $refresh_token->getExpirationDate()->format('c') : null
                ]
            ];

            return new Response($data, 201);
        }

        return new Response('Login failed', 400);
    }

    /**
     * Refresh access token.
     *
     * @param string $token (required) Refresh token.
     */
    public function token(Request $request)
    {
        if (Session::get('token')->type != ApiToken::TYPE_REFRESH) {
            return new Response('Token invalid', 400);
        }

        $user = Auth::user();
        $app = Session::get('token')->app()->first();

        $data = $user->getApiAccessToken($app)->token;

        return new Response($data, 200);
    }

    /**
     * Subscribe.
     *
     * @param string $token (required) Request token.
     * @param string $email (required) Email, unique.
     * @param string $password (required) Password.
     * @param string $name (required) Name.
     * @param string $first_name (optionnal) First name.
     * @param string $last_name (optionnal) Last name.
     * @param string $phone (optionnal) Phone.
     * @param string $lang (required) Lang : en, fr, nl.
     * @param string $customer_type (optionnal) Customer type : private or professionnal. Default value is private.
     */
    public function subscribe(Request $request)
    {
        $params = $request->all();

        $params['active'] = true;
        $params['status'] = 'active';

        $item = ApiUser::add($params);

        return new Response('Ok', 200);
    }


    /**
     * Get cities.
     *
     * @param string $token (required) Access token.
     * @param string $locale (optionnal) Locale: en, fr, nl. Default: en.
     */
    public function cities(Request $request)
    {
        $locale = null;

        if ($request->has('locale')) {
            $locale = $request->get('locale');
        }

        return ApiHelper::response(ApiUser::cities($locale));
    }
}
