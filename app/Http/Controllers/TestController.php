<?php namespace App\Http\Controllers;

use App\Api;
use App\Area;
use App\Commands\ConsolidateInvoices;
use App\Coupon;
use App\CouponUser;
use App\Events\ItemPickupAskEvent;
use App\Events\ItemUpdate;
use App\Events\PickupConfirmationEvent;
use App\Fee;
use App\Answer;
use App\Invoice;
use App\OrderAnswer;
use App\Item;
use App\Log;
use App\OrderBooking;
use App\OrderPlanRegion;
use App\Pickup;
use App\Region;
use App\UnavailableDate;
use App\User;
use App\ApiToken;
use App\OrderPlanAsset;
use Arx\BootstrapHelper;
use Blok\Utils\Arr;
use Carbon\Carbon;
use Eloquent;
use Exception;
use Illuminate\Http\Request;
use Lang;
use LemonWay\LemonWayAPI;
use LemonWay\Models\Operation;
use LemonWay\Models\Wallet;
use Modules\Datamanager\Entities\Post;
use Adyen\Client as AdyenClient;
use Adyen\Service\Payment as AdyenServicePayment;
use Session;
use App\Order;
use App\OrderPlan;
use App\OrderQuestion;
use App\OrderStoringDuration;
use App\OrderCalculatorItem;
use App\OrderAssurance;
use App\Adyen;
use Datetime;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\RequestException;
use App\Api\ApiApp;
use App\ArxminUser;
use App\Country;

class TestController extends Controller
{
    public function anyAdyen()
    {
        $users = User::query()->where("billing_type", User::BILLING_TYPE_LEMONWAY)->get();

        foreach ($users as $user) {
            $adyen = Adyen::getClient();
        }
    }

    /**
     * Run command
     *
     * @param $name
     * @return mixed
     */
    public function anyCommand($name, Request $request){

        $class = "\\App\\Commands\\".$name;

        return $this->dispatchFrom($class, $request);
    }

    public function anyApi()
    {
        $result = event(new \App\Events\AdyenNotificationEvent(json_decode('{"originalReference":"","reason":"Refused","additionalData_expiryDate":"03/2020","additionalData_cardSummary":"0520","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"","success":"false","paymentMethod":"visa","currency":"EUR","pspReference":"1835410631633113","merchantReference":"invoice-550-1370","value":"5100","live":"true","eventDate":"2018-11-01T09:06:03.49Z"}', true)));

        dd('ok');

        echo '<h1>Tests API v3</h1>
		<h2>Tokens</h2>
		<ul>
			<li><a href="' . url('/test/api-get-token') . '" target="_blank">Get request token</a></li>
			<li><a href="' . url('/test/api-post-users-login') . '" target="_blank">Get client access token from request token</a></li>
			<li><a href="' . url('/test/api-post-arxmin-users-login') . '" target="_blank">Get transporter access token from request token</a></li>
			<li><a href="' . url('/test/api-get-users-token') . '" target="_blank">Get client access token from refresh token</a></li>
			<li><a href="' . url('/test/api-get-arxmin-users-token') . '" target="_blank">Get transporter access token from refresh token</a></li>
		</ul>
		<h2>Users</h2>
		<ul>
			<li><a href="' . url('/test/api-get-users-current') . '" target="_blank">Get client informations</a></li>
			<li><a href="' . url('/test/api-get-arxmin-users-current') . '" target="_blank">Get transporter informations</a></li>
			<li><a href="' . url('/test/api-get-arxmin-users-pickups') . '" target="_blank">Get transporter pickups</a></li>
			<li><a href="' . url('/test/api-get-users') . '" target="_blank">Get users</a></li>
			<li><a href="' . url('/test/api-get-users-cities') . '" target="_blank">Get cities</a></li>
			<li><a href="' . url('/test/api-post-users-subscribe') . '" target="_blank">Register new user</a></li>
			<li><a href="' . url('/test/api-put-users') . '" target="_blank">Save a user</a></li>
		</ul>
		<h2>Items</h2>
		<ul>
			<li><a href="' . url('/test/api-get-items-client') . '" target="_blank">Get client items</a></li>
			<li><a href="' . url('/test/api-get-items-transporter') . '" target="_blank">Get transporter items</a></li>
			<li><a href="' . url('/test/api-post-items') . '" target="_blank">Add an item</a></li>
			<li><a href="' . url('/test/api-put-items') . '" target="_blank">Save an item</a></li>
		</ul>
		<h2>Pickups</h2>
		<ul>
			<li><a href="' . url('/test/api-get-pickups') . '" target="_blank">Get pickups</a></li>
			<li><a href="' . url('/test/api-put-pickups') . '" target="_blank">Save a pickup</a></li>
			<li><a href="' . url('/test/api-get-pickups-time-slots') . '" target="_blank">Get time slots</a></li>
		</ul>
		<h2>Order</h2>
		<ul>
			<li><a href="' . url('/test/api-get-calculator-items') . '" target="_blank">Get calculator items</a></li>
			<li><a href="' . url('/test/api-get-calculator-categories') . '" target="_blank">Get calculator categories</a></li>
			<li><a href="' . url('/test/api-get-plans') . '" target="_blank">Get plans</a></li>
		</ul>';
    }

    public function anyApiGetArxminUsersCurrent()
    {
        $client = new Client();

        $url = url('api/v3/arxmin/users/current');
        $arxminUser = ArxminUser::where('email', 'info@boxify.be')->first();
        $token = $this->getAccessToken(null, $arxminUser);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    private function getAccessToken(User $user = null, ArxminUser $arxminUser = null)
    {
        if (Session::has('access_token')) {
            $token = Token::where('token', Session::get('access_token'));

            if ($token->isValid()) {
                return $token->token;
            }
        }

        $app = ApiApp::all()->first();

        if ($user) {
            $token = $user->getApiAccessToken($app);
        }

        if ($arxminUser) {
            $token = $arxminUser->getApiAccessToken($app);
        }

        return $token->token;
    }

    public function anyApiGetArxminUsersPickups()
    {
        $client = new Client();

        $url = url('api/v3/arxmin/users/pickups');
        $arxminUser = ArxminUser::where('email', 'info@boxify.be')->first();
        $token = $this->getAccessToken(null, $arxminUser);

        $params = [
            'token' => $token,
            'from' => '2017-10-25 00:00:00',
            'to' => '2017-10-27 00:00:00'
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetArxminUsersToken()
    {
        $client = new Client();

        $url = url('api/v3/arxmin/users/token');
        $arxminUser = ArxminUser::where('email', 'info@boxify.be')->first();
        $token = $this->getRefreshToken(null, $arxminUser);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    private function getRefreshToken(User $user = null, ArxminUser $arxminUser = null)
    {
        if (Session::has('refresh_token')) {
            $token = Token::where('token', Session::get('request_token'));

            if ($token->isValid()) {
                return $token->token;
            }
        }

        $app = ApiApp::all()->first();

        if ($user) {
            $token = $user->getApiRefreshToken($app);
        }

        if ($arxminUser) {
            $token = $arxminUser->getApiRefreshToken($app);
        }

        return $token->token;
    }

    public function anyApiGetCalculatorCategories()
    {
        $client = new Client();

        $url = url('api/v3/order/calculator/categories');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetCalculatorItems()
    {
        $client = new Client();

        $url = url('api/v3/order/calculator/items');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetItemsClient()
    {
        $client = new Client();

        $url = url('api/v3/items');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetItemsTransporter()
    {
        $client = new Client();

        $url = url('api/v3/items');
        $arxminUser = ArxminUser::where('email', 'info@boxify.be')->first();
        $token = $this->getAccessToken(null, $arxminUser);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetPickups()
    {
        $client = new Client();

        $url = url('api/v3/pickups');
        $arxminUser = ArxminUser::where('email', 'info@boxify.be')->first();
        $token = $this->getAccessToken(null, $arxminUser);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetPickupsTimeSlots()
    {
        $client = new Client();

        $url = url('api/v3/pickups/timeslots');
        $arxminUser = ArxminUser::where('email', 'info@boxify.be')->first();
        $token = $this->getAccessToken(null, $arxminUser);

        $params = [
            'token' => $token,
            'from' => '2017-10-25 00:00:00',
            'to' => '2017-10-27 00:00:00'
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetPlans()
    {
        $client = new Client();

        $url = url('api/v3/order/plans');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetToken()
    {
        $client = new Client();

        $url = url('api/v3');
        $app = ApiApp::all()->first();

        $params = [
            'app_id' => $app->app_id,
            'app_secret' => $app->app_secret
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetUsers()
    {
        $client = new Client();

        $url = url('api/v3/users');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetUsersCities()
    {
        $client = new Client();

        $url = url('api/v3/users/cities');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetUsersCurrent()
    {
        $client = new Client();

        $url = url('api/v3/users/current');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiGetUsersToken()
    {
        $client = new Client();

        $url = url('api/v3/users/token');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getRefreshToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->get($url, ['json' => $params]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiPostArxminUsersLogin()
    {
        $client = new Client();

        $url = url('api/v3/arxmin/users/login');
        $token = $this->getRequestToken();

        $params = [
            'token' => $token,
            'email' => 'info@boxify.be',
            'password' => '123456'
        ];

        try {
            $response = $client->post($url, ['form_params' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    private function getRequestToken()
    {
        if (Session::has('request_token')) {
            $token = Token::where('token', Session::get('request_token'));

            if ($token->isValid()) {
                return $token->token;
            }
        }

        $app = ApiApp::all()->first();

        return $app->getApiToken()->token;
    }

    public function anyApiPostItems()
    {
        $client = new Client();

        $url = url('api/v3/items');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getRequestToken();

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->post($url, ['form_params' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiPostUsersLogin()
    {
        $client = new Client();

        $url = url('api/v3/users/login');
        $token = $this->getRequestToken();

        $params = [
            'token' => $token,
            'email' => 'user@cherrypulp.com',
            'password' => '123456'
        ];

        try {
            $response = $client->post($url, ['form_params' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiPostUsersSubscribe()
    {
        $client = new Client();

        $url = url('api/v3/users/subscribe');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getRequestToken();

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->post($url, ['form_params' => $params]);
            return $response->getBody()->getContents();
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiPutItems()
    {
        $client = new Client();

        $url = url('api/v3/items');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);
        $item = Item::all()->first();

        $params = [
            'token' => $token,
            'id' => $item->id
        ];

        try {
            $response = $client->put($url, ['form_params' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiPutPickups()
    {
        $client = new Client();

        $url = url('api/v3/pickups');
        $arxminUser = ArxminUser::where('email', 'info@boxify.be')->first();
        $token = $this->getAccessToken(null, $arxminUser);
        $pickup = Pickup::all()->first();

        $params = [
            'token' => $token,
            'id' => $pickup->id
        ];

        try {
            $response = $client->put($url, ['form_params' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    public function anyApiPutUsers()
    {
        $client = new Client();

        $url = url('api/v3/users');
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $token = $this->getAccessToken($user);

        $params = [
            'token' => $token
        ];

        try {
            $response = $client->put($url, ['form_params' => $params]);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (ServerException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
    }

    /**
     * Apply promocode
     */
    public function anyApplyCode()
    {

        $user = User::find(2);

        $code = base64_encode($user->id);

        Api::applyInvitationCode($user, $code);
    }

    /**
     * Apply promocode
     */
    public function anyApplyPromoCode()
    {
        $user = User::find(2);

        dd(Api::applyPromoCode($user, 'TESTCHERRY'));
    }

    /**
     * Update items
     */
    public function anyBackItem()
    {

        $source = Item::find(275);

        $data = [
            'status' => Item::STATUS_IN_TRANSIT,
        ];

        $response = event(new ItemUpdate($source, $data));

        return $response;
    }

    /**
     * Script to check if all is correctly invoiced or proforma
     */
    public function anyCheckInvoicedProforma()
    {

        // Cleanup invoices

        $invoices = Invoice::query()->where('id', '>', 700)->orWhere('number', '>', '18/W0340')->orderBy('id', 'asc')->get();

        foreach ($invoices as $invoice) {
            $invoice->number = "";
            $invoice->save();
        }

        $data = Arr::csvToArray(public_path('paymentlist.csv'), ['delimiter' => ',']);

        $data[0][] = "STATUS";

        // Remove empty param
        array_pop($data);

        $has_update = [];

        foreach ($data as $key => $row) {
            try {

                $parts = explode('-', $row[1]);

                if (count($parts) === 3) {
                    list($type, $id, $uid) = $parts;

                    if ($type == 'card') {

                        $user = User::find($id);

                        if ($user) {
                            $hasContract = Adyen::getRecurringContract($user, true);

                            if (isset($hasContract['details'])) {
                                $data[$key][] = "HAS CONTRACT";
                            } else {
                                $data[$key][] = "NO CONTRACT !";
                            }

                        } else {
                            $data[$key][] = "NO_USER";
                        }

                    } elseif ($type == 'sepa') {

                        $user = User::find($id);

                        if ($user) {
                            $hasContract = Adyen::getRecurringContract($user, true);

                            if (isset($hasContract['details'])) {
                                $data[$key][] = "HAS CARD CONTRACT";
                            } else {
                                $data[$key][] = "NO CARD CONTRACT !";
                            }

                        } else {
                            $data[$key][] = "NO_USER";
                        }

                    } elseif ($type == 'invoice') {

                        $user = User::find($id);
                        $invoice = Invoice::find($uid);

                        if ($uid <= 700) {
                            $data[$key][] = "Dont touch";
                            continue;
                        } elseif ($uid > 700 && $invoice->number <= '18/W0340') {
                            $data[$key][] = "Dont touch";
                            continue;
                        }

                        if (in_array($uid, $has_update)) {
                            $data[$key][] = "Updated status";
                            continue;
                        }

                        $has_update[] = $uid;

                        if ($user) {

                            if ($invoice) {
                                $status = $row[8];

                                $invoiceStatus = "";

                                switch ($status) {
                                    case "SettledBulk":
                                    case "Settled":

                                        if ($invoice->status != Invoice::STATUS_PAID) {
                                            $invoiceStatus .= "wrong status|";
                                            $invoice->status = Invoice::STATUS_PAID;
                                            $invoice->save();
                                        }

                                        if ($invoice->type != Invoice::TYPE_INVOICED) {
                                            $invoiceStatus .= "wrong type";
                                            $invoice->type = Invoice::TYPE_INVOICED;
                                            $invoice->save();
                                        }

                                        if (!strpos($invoice->number, 'W')) {
                                            $invoiceStatus .= "wrong number";
                                            $invoice->number = "";
                                            $invoice->save();
                                        }

                                        break;
                                    case "Refused":

                                        if ($invoice->status != Invoice::STATUS_UNPAID) {
                                            $invoiceStatus .= "wrong status|";
                                            $invoice->status = Invoice::STATUS_UNPAID;
                                            $invoice->save();
                                        }

                                        if ($invoice->type != Invoice::TYPE_INVOICED) {
                                            $invoiceStatus .= "wrong type";
                                            $invoice->type = Invoice::TYPE_INVOICED;
                                            $invoice->save();
                                        }

                                        if (!strpos($invoice->number, 'PI')) {
                                            $invoiceStatus .= "wrong number";
                                            $invoice->number = "";
                                            $invoice->save();
                                        }

                                        break;
                                }

                                $hasContract = Adyen::getRecurringContract($user, true);

                                if (isset($hasContract['details'])) {
                                    $data[$key][] = "HAS SEPA CONTRACT $invoiceStatus";
                                } else {
                                    $data[$key][] = "NO SEPA CONTRACT $invoiceStatus";
                                }

                            } else {
                                $data[$key][] = "NO_INVOICE !";
                            }

                        } else {
                            $data[$key][] = "NO_USER";
                        }

                    } else {
                        $data[$key][] = 'Type not recognized';
                    }

                } else {
                    $data[$key][] = 'REF not recognized';
                }

            } catch (Exception $e) {
                $data[$key][] = $e->getMessage();
            }
        }

        $data = [];

        /**
         * @var $invoice Invoice
         */
        foreach ($invoices as $invoice) {
            $data[$invoice->id] = $invoice->generateNumber(true);
        }

        dd($data);

        return cp_html_table($data, false);
    }

    /**
     * Check items with me status
     */
    public function anyCheckItemsWithMe()
    {
        dd(Api::consolidateItemsWithMe());
    }

    public function anyCheckOrderPlans()
    {
        Eloquent::unguard();

        $orderPlans = OrderPlan::all();
        $regions = Region::all();

        $data = [];

        foreach ($orderPlans as $orderPlan) {

            foreach ($regions as $region) {
                $orderPlanRegion = OrderPlanRegion::where('order_plan_id', $orderPlan->id)->where('region_id', $region->id)->first();

                if (!$orderPlanRegion) {
                    $data[] = OrderPlanRegion::create([
                        'order_plan_id' => $orderPlan->id,
                        'region_id' => $region->id,
                        'price_per_month' => $orderPlan->price_per_month
                    ]);
                }
            }
        }

        dd($data);
    }

    public function anyCheckOutdated(Request $request)
    {
        $usersOutdated = User::query()->with('items')->whereHas('items', function ($q) {
            $q->whereIn('status', [Item::STATUS_OUTDATED, Item::STATUS_DELIVERED]);
        })->get();

        $toDelete = [];

        /**
         * @var User $user
         */
        foreach ($usersOutdated as $user) {
            $itemsCount = $user->items->count();
            $itemsNotStoredCount = $user->items()->whereNotIn('status', [Item::STATUS_STORED, Item::STATUS_IN_TRANSIT])->count();

            if ($itemsCount == $itemsNotStoredCount) {
                $user->order_plan_id = null;
                $user->order_plan_region_id = null;
                $user->order_plan_price_per_month = null;
                $user->order_assurance_id = null;
                $user->order_storing_duration_id = null;
                $user->end_commitment_period = null;


                $toDelete[] = ['id' => $user->id, 'name' => $user->full_name];

                if ($request->has('confirm')) {
                    $user->save();
                }

            }
        }

        ddd($toDelete);
    }

    /**
     * Check the existance of the invoice
     */
    public function anyCheckTransactions()
    {
        $data = Arr::csvToArray(public_path('files/payments.csv'), ['delimiter' => ',', 'indexFromFirstRow' => true, 'skipFirstRow' => false]);

        $alreadyHandled = [];

        foreach ($data as $key => $item) {

            if ($key === 0) {
                $data[$key]['Reason'] = "Reason";
            } else {
                $data[$key]['Reason'] = "";
            }

            if (isset($item['Merchant Reference'])) {

                // Skip invoice there is different transactions on it
                $ref = $item['Merchant Reference'];

                if (isset($alreadyHandled[$ref])) {
                    continue;
                }

                $alreadyHandled[$ref] = $ref;

                $parts = explode('-', $item['Merchant Reference']);

                if (count($parts) === 3) {

                    list($type, $user_id, $invoice_id) = $parts;

                    if ($type === 'invoice') {

                        $invoice = Invoice::find($invoice_id);

                        if ($invoice) {

                            $invoice->billing_type = User::BILLING_TYPE_ADYEN;

                            if(preg_match('/sepa/i', $item['Payment Method'])){
                                $invoice->billing_method = User::BILLING_METHOD_SEPA;
                            } else {
                                $invoice->billing_method = User::BILLING_METHOD_CREDITCARD;
                            }

                            $invoice->save();

                            $data[$key]['Status'] = 'FOUND';
                        } else {
                            $data[$key]['Status'] = 'NOT FOUND';

                            if ($item['Payment Method'] === 'mc' || $item['Payment Method'] === 'visa' || in_array($item['Status'], ['Refused', 'RefundedBulk', 'Chargeback'])) {
                                $data[$key]['Reason'] = "Order canceled";
                                $data[$key]['Reason'] .= " Status : " . $item['Status'];
                            } else {
                                $data[$key]['Reason'] = "To check manually";
                                $data[$key]['Reason'] .= " Status : " . $item['Status'];
                            }
                        }
                    } else {
                        unset($data[$key]);
                        continue;
                    }

                } else {
                    $data[$key]['Status'] = 'UNKNOW';
                }
            }
        }

        cp_html_table($data, false, true);
    }

    /**
     * Cleaning Adyen payment for special user
     */
    public function anyCleaningAdyen()
    {
        /**
         * @var $user User
         */
        $user = User::where('email', 'user@cherrypulp.com')->first();

        $result = Adyen::getRecurringContract($user, true);

        $invoice = $user->invoices()->first();

        $result = Api::makePayment($user, $invoice);

        dd($result);
    }

    /**
     * Delete trashed user
     */
    public function anyDeleteTrashed()
    {

        /**
         * Delete all users that has been trashed
         */
        $users = User::onlyTrashed()->get();

        $logs = [];
        $usersUndeleted = [];

        foreach ($users as $user) {
            try {
                $logs[] = 'delete #' . Api::deleteUser($user->id);
                $logs[] = "#" . $user->id . " deleted";
            } catch (Exception $e) {
                $logs[] = "#" . $user->id . " error deleted" . $e->getMessage();
            }
        }

        dd($logs);
    }

    public function anyDeleteUsers()
    {

        $data = json_decode(file_get_contents('undeleted.json'));

        foreach ($data as $id) {
            d(Api::deleteUser($id));
        }

        die();
    }

    /**
     * Export account for pricing checking
     */
    public function anyExportAccounts()
    {
        $accounts = include_once __DIR__ . '/../../../database/seeds/sources/accounts.php';

        $data = [];

        foreach ($accounts as $id) {
            $user = User::find($id);

            if (!$user) {
                Throw new Exception('User not found !');
            }

            // Get old pricing
            $oldPricing = \DB::connection("old")->table('items')->where('status', 'in_storage')->where('user_id', $user->id)->sum('price');

            $prodUser = \DB::connection("old")->table('users')->where('id', $user->id)->first();

            if (!$prodUser) {
                $prodUser = new \stdClass();
                $prodUser->id = '-';
                $prodUser->name = '-';
            }

            // Get pricing old user
            $diff = $user->order_plan_price_per_month - $oldPricing;

            $data[] = [
                'ID PROD' => $prodUser->id,
                'NAME PROD' => $prodUser->name,
                'Old pricing' => $oldPricing,
                'Diff' => $diff,
                'ID new' => $user->id,
                'pricing new' => $user->order_plan_price_per_month,
                'volume' => $user->getVolume(),
                'volume_plan' => $user->getVolumePlan(),
                'name' => $user->name
            ];
        }


        echo BootstrapHelper::table($data);

        echo "<br><br>";

        $data = [];

        $users = User::whereNotIn('id', $accounts)->whereNotNull('order_plan_id')->get();

        /**
         * @var $user User
         */
        foreach ($users as $user) {

            if (!$user) {
                Throw new Exception('User not found !');
            }

            // Get old pricing
            $oldPricing = \DB::connection("old")->table('items')->where('status', 'in_storage')->where('user_id', $user->id)->sum('price');

            $prodUser = \DB::connection("old")->table('users')->where('id', $user->id)->first();

            if (!$prodUser) {
                $prodUser = new \stdClass();
                $prodUser->id = '-';
                $prodUser->name = '-';
            }

            // Get pricing old user
            $diff = $user->order_plan_price_per_month - $oldPricing;

            $data[] = [
                'ID PROD' => $prodUser->id,
                'NAME PROD' => $prodUser->name,
                'Old pricing' => $oldPricing,
                'Diff' => $diff,
                'ID new' => $user->id,
                'pricing new' => $user->order_plan_price_per_month,
                'volume' => $user->getVolume(),
                'volume_plan' => $user->getVolumePlan(),
                'name' => $user->name
            ];
        }

        echo BootstrapHelper::table($data);

        die();
    }

    /**
     * Export account for pricing checking
     */
    public function anyExportAccountsToKeep()
    {
        $items = Item::query()->whereIn('status', ['in_storage', 'in_transit'])->groupBy('user_id')->get();

        $data = [];

        foreach ($items as $item) {
            $data[$item->user->id] = array_only(collect($item->user->toArray())->toArray(), ['id', "email", "name"]);
        }

        echo "<h2>Users to keep</h2>";
        echo BootstrapHelper::table($data);

        $users = collect(User::whereNotIn('id', array_keys($data))->select(['id', "email", "name"])->get())->toArray();

        foreach ($users as $key => $user) {
            $users[$key] = array_only($user, ['id', "email", "name"]);
            if (isset($_GET['confirm'])) {
                $users[$key]['deleted'] = Api::deleteUser($user['id']);
            }
        }

        echo "<h2>Users to delete</h2>";
        echo BootstrapHelper::table($users);
        die();
    }

    public function anyExportAllInvoices(Request $request)
    {

        $invoices = Invoice::query()->where('id', '>=', $request->get('id', '700'))->orderBy('id', 'asc')->get();

        foreach ($invoices as $invoice) {
            $data[] = $invoice->toArray();
        }

        return cp_html_table($data, true);
    }

    /**
     * Get export invoices table helpers for a special dates
     */
    public function anyExportInvoices(Request $request)
    {

        $invoices = Invoice::query()->where('number', '>=', $request->get('from', '18/W0340'))->orderBy('number', 'asc')->get();

        $from = $request->get('from', '18/W0340');

        $current = sprintf("%04d", str_replace('18/W', '', $from));

        foreach ($invoices as $invoice) {
            if (preg_match('/18\/W/', $invoice->number)) {

                $number = str_replace('18/W', '', $invoice->number);

                if ($number != $current) {
                    $invoice->number = '18/W' . $current;
                    $invoice->save();
                }

                $current = sprintf("%04d", $current + 1);
            }
        }

        $data = [];

        foreach ($invoices as $invoice) {
            $data[] = $invoice->toArray();
        }

        return cp_html_table($data, true);
    }

    /**
     * Export account for pricing checking
     */
    public function anyExportPlansRegions()
    {
        $data = [];

        $orderPlanRegions = OrderPlanRegion::with('plan')->with('region')->get();

        foreach ($orderPlanRegions as $orderPlan) {

            if (!$orderPlan->plan) {
                $orderPlan->delete();
                continue;
            }

            $data[] = [
                'plan_id' => $orderPlan->plan->id,
                'volume_m3' => $orderPlan->plan->volume_m3,
                'plan_price_per_month' => $orderPlan->plan->price_per_month,
                'visible' => $orderPlan->plan->visible,
                'region' => $orderPlan->region->name,
                'region_id' => $orderPlan->region->id,
                'region_id_price_per_month' => $orderPlan->price_per_month,
            ];
        }

        echo BootstrapHelper::table($data);

        die();
    }

    /**
     * Fix missing card number infos
     */
    public function anyFixMissingCardNumber()
    {
        $users = User::where('billing_method', User::BILLING_METHOD_CREDITCARD)->where('billing_card_number', '')->get();

        /**
         * @var $user User
         */
        foreach ($users as $user) {
            // Get adyen info
            $contracts = Adyen::getRecurringContract($user, true);

            if (isset($contracts['details'], $contracts['details'][0], $contracts['details'][0]['RecurringDetail'])) {
                $detail = array_pop($contracts['details']);
                $detail = $detail['RecurringDetail'];
                $user->billing_card_number = "XXXX XXXX XXXX " . $detail['card']['number'];
                $user->billing_card_month = $detail['card']['expiryMonth'];
                $user->billing_card_year = $detail['card']['expiryYear'];
                $user->billing_card_holder = $detail['card']['holderName'];
                $user->save();
            }
        }
    }

    /**
     * Generate coupons REDEEM
     *
     */
    public function anyGenerateCoupons()
    {
        return "";

        $data = [
            902 => 20,
            888 => 20.4,
            891 => 89.25,
            886 => 12.24,
            873 => 107.25,
            904 => 72.5,
            898 => 87.5,
            848 => 107.25,
            868 => 51,
            884 => 62,
            882 => 72.5,
            883 => 123.338,
            887 => 35,
            890 => 87.5,
            892 => 99,
            893 => 73.95,
            894 => 107.25,
            899 => 51,
            885 => 107.25,
            897 => 73.95,
            901 => 51,
            900 => 72.50,
            896 => 73.95,
            889 => 73.95,
        ];

        foreach ($data as $uid => $price) {
            $coupon = new Coupon();
            $coupon->code = 'ADJ-' . $uid . '-' . $uid;
            $coupon->promo_type = Coupon::PROMO_TYPE_REDEEM;
            $coupon->promo_applied = $price;
            $coupon->quantity = 1;
            $coupon->save();

            $couponUser = new CouponUser();
            $couponUser->user_id = $uid;
            $couponUser->coupon_id = $coupon->id;
            $couponUser->touse = 1;
            $couponUser->save();
        }
    }

    /**
     * Generate invitation code for each users
     */
    public function anyGenerateInvitationCode()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->invitation_code = base64_encode($user->id);
            $user->save();
        }

        dd($users);
    }

    /**
     * Import the current post from prod
     */
    public function anyImportPostFromProd()
    {

        die('disabled');

        Eloquent::unguard();

        /**
         * Import users that are active on production
         */
        $posts = \DB::connection('prod')->table('posts')->where("type", "post")->get();

        $data = [];

        Post::where('type', "post")->forceDelete();

        foreach ($posts as $post) {
            $id = $post->id;

            $dataPost = collect($post)->toArray();

            $data[$id] = $dataPost;

            #Find all tags related to current post
            $data[$id]['tags'] = \DB::connection('prod')->table("post_tag")->where('post_id', $id)->pluck("tag_id");
            $data[$id]['cats'] = \DB::connection('prod')->table("category_post")->where('post_id', $id)->pluck("category_id");

            $data[$id]['posts'] = \DB::connection('prod')->table("posts_posts")->where('from_post_id', $id)->pluck("to_post_id");

            // Import post into new website
            unset($dataPost['id']);

            $newPost = Post::create($dataPost);
            $data[$id]['newPost'] = $newPost;
            $data[$id]['newid'] = $newPost->id;
        }

        foreach ($data as $oldID => $post) {
            #1. relink to tags
            foreach ($post['tags'] as $tagID) {
                \DB::table('post_tag')->insert([
                    'post_id' => $post['newid'],
                    'tag_id' => $tagID
                ]);
            }

            #1. relink to cats
            foreach ($post['cats'] as $tagID) {
                \DB::table('category_post')->insert([
                    'post_id' => $post['newid'],
                    'category_id' => $tagID
                ]);
            }

            if (!isset($data[$oldID]['newRef'])) {
                $data[$oldID]['newRef'] = $post['newid'];
                $data[$oldID]['newPost']->ref = $data[$oldID]['newRef'];
                $data[$oldID]['newPost']->save();
            }

            #1. relink to posts
            foreach ($post['posts'] as $postID) {

                if (!isset($data[$postID])) {
                    continue;
                }

                \DB::table('posts_posts')->insert([
                    'from_post_id' => $post['newid'],
                    'to_post_id' => $data[$postID]['newid']
                ]);
                if (!isset($data[$postID]['newRef'])) {
                    $data[$postID]['newRef'] = $post['newid'];
                    $data[$postID]['newPost']->ref = $data[$oldID]['newRef'];
                    $data[$postID]['newPost']->save();
                }
            }
        }

        ddd($data);
    }

    /**
     * Import the pricing per region
     */
    public function anyImportPricing()
    {

        #1. Fix double region
        $orderPlanRegions = OrderPlanRegion::with('plan')->with('region')->get();

        $data = [];

        foreach ($orderPlanRegions as $orderPlanRegion) {

            $key = $orderPlanRegion['order_plan_id'] . '-' . $orderPlanRegion['region_id'];

            if (!isset($data[$key])) {
                $data[$key] = [];
            }

            $data[$key][] = $orderPlanRegion;
        }

        foreach ($data as $key => $doublon) {
            if (count($doublon) > 1) {
                array_pop($doublon);
                foreach ($doublon as $d) {
                    $d->forceDelete();
                }
            }
        }

        $orderPlanRegions = OrderPlanRegion::with('plan')->with('region')->count();

        if ($orderPlanRegions != 1364) {
            die('Error in the count !');
        }

        $csv = Arr::csvToArray('https://docs.google.com/spreadsheets/d/e/2PACX-1vQ0RCHzWS-z3EOCl0etrpaQwrowVFN9lJhJvvfSTHN97Ai4Eyo-cr3Fz7NNm3VD_3LKhPQkl2_95Z-2/pub?gid=763084617&single=true&output=csv', ["delimiter" => ',', 'indexFromFirstRow' => true, 'skipFirstRow' => true]);

        $data = collect($csv)->groupBy(function ($item) {
            return $item['plan_id'] . '-' . $item['region_id'];
        })->toArray();

        $plansUpdated = [];

        foreach ($data as $plan) {

            $plan = $plan[0];

            $checksum = $plan["plan_id"] . '-' . $plan['volume_m3'] . '-' . $plan['plan_price_per_month'];

            if (!isset($plansUpdated[$plan["plan_id"]])) {
                # Update pricing per plan
                $orderPlan = OrderPlan::where('id', $plan['plan_id'])->first();
                $orderPlan->volume_m3 = $plan['volume_m3'];
                $orderPlan->price_per_month = $plan['plan_price_per_month'];
                $orderPlan->save();
                $plansUpdated[$key] = $checksum;
            } elseif ($plansUpdated[$plan['plan_id']] !== $checksum) {
                dd($checksum, 'Error should be', $plansUpdated[$plan['plan_id']]);
            }

            # Update orderPlan Per Region
            $orderPlanRegion = OrderPlanRegion::where('order_plan_id', $plan['plan_id'])->where('region_id', $plan['region_id'])->first();

            $orderPlanRegion->price_per_month = $plan["region_id_price_per_month"];

            $orderPlanRegion->save();
        }

        dd('ok');
    }

    public function anyInvoice()
    {
        /**
         * @var $pickup Pickup
         */
        $pickup = Pickup::query()->find(548);

        dd($pickup->complete());
    }

    public function anyLemonway()
    {
        $users = User::query()->where("billing_type", User::BILLING_TYPE_LEMONWAY)->get();

        $lemonway = Api::getClient('production');

        $data = $lemonway->GetWalletTransHistory([
            "wallet" => 'BOXIFY'
        ]);

        $logs = [];

        $lastinvoices = [];

        foreach ($data->operations as $operation) {
            if ($operation->TYPE == 0) {

                $log = [
                    "date" => $operation->DATE->__toString(),
                    "user_id" => "",
                    "invoice_id" => "",
                    "ref" => "",
                    "status" => $operation->MSG->__toString(),
                    "id" => $operation->ID->__toString()
                ];

                /**
                 * @var $operation Operation
                 */
                if (preg_match('/Invoice #(.*) User #(.*) (.*)/i', $operation->MSG, $matches)) {

                    list($ref, $invoiceID, $user_id, $email) = $matches;

                    if (isset($lastinvoices[$invoiceID])) {
                        continue;
                    }

                    $lastinvoices[$invoiceID] = $invoiceID;

                    $invoice = Invoice::query()->where('id', $invoiceID)->first();

                    $status_code = $operation->STATUS->__toString();

                    $log["user_id"] = $user_id;
                    $log["invoice_id"] = $invoiceID;
                    $log["ref"] = $ref;
                    $log["status"] = "";

                    if ($invoice) {

                        $invoice->billing_type = User::BILLING_TYPE_LEMONWAY;
                        $invoice->billing_method = User::BILLING_METHOD_CREDITCARD;
                        $invoice->save();

                        if ($status_code == 4 && $invoice->status !== Invoice::STATUS_UNPAID) {
                            $log['status'] = "Invoice #{$invoiceID} nok invoice should be unpaid";
                        } elseif ($status_code == 3 && $invoice->status !== Invoice::STATUS_PAID) {
                            $log['status'] = "Invoice #{$invoiceID} nok invoice should be paid";
                        } elseif (!in_array($status_code, [4, 3])) {
                            $log['status'] = "Invoice #{$invoiceID} undefined" . $status_code;
                        } else {
                            $log['status'] = "Invoice #{$invoiceID} ok {$invoice->status}";
                        }
                    } else {
                        $log['status'] = "Invoice #{$invoiceID} not found";
                    }

                } else {
                    $log['status'] = "unknown operation {$operation->ID} {$operation->MSG}";
                }

                $logs[] = $log;
            }
        }

        return cp_html_table($logs);

        /**
         * @var $invoice Invoice
         */
        /*foreach ($users as $user) {

            $invoices = $user->invoices;

            foreach ($invoices as $invoice) {
                $invoice->type = Invoice::TYPE_INVOICED;
                $invoice->save();
                $invoice->generateNumber(true, true);
            }

            $user->billing_status = User::BILLING_STATUS_UNPAID;
            $user->billing_card_id = "";
            $user->save();
        }*/
    }

    /**
     * Mail confirmation
     */
    public function anyMail()
    {

        $user = User::find(2);
        $invoice = new Invoice();
        $invoice->content = 'My invoice content';

        /*$data = \DM()->getBySlug('/mail/monthly-billing');

        $dataMail = [
            'user' => $user->toArray(),
            'invoice' => $invoice->toArray(),
            'billing_date' => date('d/m/Y')
        ];

        $content = shortcode($data['content'], $dataMail);
        $subject = shortcode($data['title'], $dataMail);

        Api::sendUserNotification($content, $user, $subject);*/

        $data = \DM()->getBySlug('/mail/error-billing');

        $dataMail = [
            'user' => $user->toArray(),
            'invoice' => $invoice->toArray(),
            'billing_date' => date('d/m/Y')
        ];

        $content = shortcode($data['content'], $dataMail);
        $subject = shortcode($data['title'], $dataMail);

        Api::sendUserNotification($content, $user, $subject);
    }

    /* API */

    /**
     * Mail confirmation
     */
    public function anyMailActivation()
    {
        /**
         * @var $user User
         */
        $user = User::first();
        $response = $user->sendMailConfirmation();

        dd($response);
    }

    /**
     * Test email
     */
    public function anyMailBack()
    {

        $pickup = Pickup::find(163);

        event(new ItemPickupAskEvent($pickup));
    }

    public function anyMailPickup()
    {
        $pickup = Pickup::find(37);
        event(new PickupConfirmationEvent($pickup));
        echo 'mail send';
    }

    /**
     * Add missing invoice into new project
     */
    public function anyMissingInvoices()
    {

        Eloquent::unguard();

        $old = \DB::connection('old');
        $prod = \DB::connection('prod');
        $invoices = $old->table('invoices')->where('number', 'LIKE', '18/W%')->get();

        $data = [];

        foreach ($invoices as $invoice) {
            $newInvoice = $prod->table('invoices')->where('id', $invoice->id)->first();

            if (!$newInvoice) {
                $parts = explode('/W', $invoice->number);
                $number = array_pop($parts);
                $invoice->number = '18/W' . sprintf("%04d", $number);
                $invoice = collect($invoice)->toArray();
                $data[] = $invoice;
                $prod->table('invoices')->insert($invoice);
            }
        }

        dd('Missing invoices', $data);
    }

    /**
     * Adjust prorate pickup
     */
    public function anyProratePickup()
    {

        /**
         * @var $pickup Pickup
         */
        $pickup = Pickup::query()->find(634);

        cp_html_table($pickup->reajustProrata());
    }

    /**
     * Regenerate invoice numbers
     */
    public function anyRegenerateNumber(Request $request)
    {
        $invoices = Invoice::where('number', '>', $request->get('number', '18/W0394'))->orderBy('number', 'asc')->get();

        $ref = "18/W0";
        foreach ($invoices as $invoice) {
            $invoice->number = "";
            $invoice->save();
        }

        /**
         * @var $invoice Invoice
         */
        foreach ($invoices as $invoice) {
            $invoice->generateNumber();
        }

        $invoices = Invoice::where('number', '>', $request->get('number', '18/W0394'))->orderBy('number', 'asc')->get();

        ddd($invoices->toArray());
    }

    public function anySendMissingInvoice()
    {
        die('');
        /**
         * @var User
         */
        $invoices = Invoice::query()->where('billing_ref', 'LIKE', 'monthly-2018-11-%')->where('status', 'paid')->get();

        $logs = [];

        foreach ($invoices as $invoice) {

            /**
             * @var $invoice Invoice
             */

            $user = $invoice->user;

            $data = \DM()->getBySlug('/mail/monthly-billing', ['format' => 'array'], $user->lang);

            app()->setLocale($user->lang);

            $dataMail = [
                'user' => $user->toArray(),
                'invoice' => $invoice->toArray(),
                'billing_date' => "01/11/2018"
            ];

            $content = shortcode($data['content'], $dataMail);
            $subject = shortcode($data['title'], $dataMail);

            $logs[] = [
                'content' => $content,
                'subject' => $subject,
                'email' => $user->email
            ];

            if (\request()->has('confirm')) {
                try {
                    Api::sendUserNotification($content, $user, $subject);
                } catch (Exception $e) {
                    \Log::error($e);
                }
            }
        }

        echo cp_html_table($logs);
        die();
    }

    /**
     * Sync Name script
     */
    public function anySyncName()
    {
        $items = Item::where('user_id', 76)->get();
        foreach ($items as $item) {
            if (!$item->name && $item->description) {
                $item->name = $item->description;
                $item->save();
            }
        }

        echo "ok";
    }

    /**
     * Generate Number
     */
    public function anyTest()
    {
        $invoices = Invoice::all();

        foreach ($invoices as $invoice) {
            $invoice->generateNumber();
        }
    }

    /**
     * TEST
     */
    public function anyTestInvoice()
    {
        /**
         * @var $orderBooking OrderBooking
         */
        $orderBookings = OrderBooking::where('user_id', '890')->get();


        $lines = [];

        foreach ($orderBookings as $order) {

            if ($order->plan) {
                $lines[] = [
                    'description' => ($order->plan->name ?: 'Plan ' . $order->plan->slug) . ' prorata',
                    'price_formatted' => number_format(Api::proratePrice($order->plan->price_per_month, $order->pickup_date_from), 2, ',', '.') . ' €'
                ];
            }

            foreach ($order->services as $service) {
                $lines[] = [
                    'id' => $service['Answer']->id,
                    'value' => $service['value'],
                    'description' => shortcode(lg("order.resume.services." . $service['Answer']->slug), [
                        'floor' => $service['value']
                    ]),
                    'price_formatted' => $service['Answer']->getAppointment($service['value']) ? number_format($service['Answer']->getAppointment($service['value']), 2, ',', '.') . ' €' : ucfirst(lg("common.free"))
                ];
            }
        }

        ddd($lines);
    }

    public function anyTimeSlots()
    {
        $from = new Datetime();
        $to = new Datetime();
        $to->modify('+8 day');

        $timeSlots = Pickup::getTimeSlots($from, $to);

        dd($from, $to, $timeSlots);
    }

    /**
     * Get all the users to prorate
     */
    public function anyUsersToProrate(Request $request)
    {
        $users = User::query()->whereHas('orderBookings', function ($query) {
            $query->where('created_at', ">", "2018-06-03");
        })->get();

        $d = [];

        /**
         * @var $user User
         */
        foreach ($users as $user) {

            $bookings = $user->orderBookings()->where('created_at', '>', "2018-06-03")->get();

            if ($user->billing_env == "sandbox") {
                continue;
            }

            /**
             * @var $booking OrderBooking
             */
            foreach ($bookings as $booking) {

                $pickups = Pickup::where('order_booking_id', $booking->id)->get();

                /**
                 * @var $pickup Pickup
                 */
                foreach ($pickups as $pickup) {

                    if ($pickup->id == '555') {
                        continue;
                    }

                    if ($pickup->status == Pickup::STATUS_CANCELED) {
                        continue;
                    }

                    if ($pickup->status == Pickup::STATUS_COMPLETED) {
                        continue;
                    }

                    if ($pickup->pickup_date->format('Y-m-d') > '2018-08-01') {
                        continue;
                    }

                    $invoices = Invoice::where('pickup_id', $pickup->id)->get();


                    if (count($invoices)) {

                        foreach ($invoices as $invoice) {
                            /**
                             * @var $plan OrderPlan
                             */
                            $plan = $booking->plan;

                            $price = $user->getPricePerMonth();

                            $prorateData = $pickup->reajustProrata(true, null, true);

                            $d[] = [
                                'booking_id' => $pickup->id,
                                'user_id' => $user->id,
                                'name' => $user->last_name,
                                'first_name' => $user->first_name,
                                'email' => $user->email,
                                'invoice_number' => $invoice->number,
                                'invoice_id' => $invoice->id,
                                'status' => $invoice->status,
                                'booked_date_from' => $booking->pickup_date_from,
                                'pickup_date_from' => $pickup->pickup_date,
                                'total_priced' => $prorateData['invoiced_price'],
                                'plan_price' => $prorateData['plan'],
                                "services" => $prorateData['services'],
                                'insurance' => $prorateData['insurance'],
                                'storingDiscount' => $prorateData['storingDiscount'],
                                'prorata' => $prorateData['prorata'],
                                'daysInMounth' => $prorateData['daysInMonth'],
                                'day' => $prorateData['day'],
                                'cardFee' => $prorateData['cardFee'],
                                'redeem_coupon' => $prorateData['reajusted_price']
                            ];

                            if ($request->has('confirm')) {
                                $pickup->complete();
                            }
                        }
                    }
                }
            }
        }

        echo cp_html_table($d, true);
        die();
    }

    public function getDeleteUser($id)
    {
        return Api::deleteUser($id);
    }

    /**
     * Test labels sync
     */
    public function getSyncLabels()
    {
        dd(\Artisan::call('labelmanager:sync'));
    }

	/**
	 * Check users countries
	 */
	public function anyCheckUsersCountries($page = 1, $id = null) {
		$limit = 20;
		$offset = $limit * ($page - 1);

		$users = User::query();

		if ($id) {
			$users = $users->where('id', $id);
			$count = 1;
		} else {
			$users = $users->limit($limit)->offset($offset);
			$count = User::count();
		}

		$users = $users->get();

		echo '<p style="text-align: center;">';

		if ($page > 1) {
			echo '<a href="' . url('/test/check-users-countries/' . ($page - 1)) .'"><</a>';
		}

		for ($number = $page - 5; $number <= $page + 5; $number++) {
			if ($number >= 1 && $number < $count / $limit) {
				echo '&nbsp;<a href="' . url('/test/check-users-countries/' . $number) .'">' . $number . '</a>';
			}
		}

		if ($page < $count / $limit) {
			echo '&nbsp;...&nbsp;<a href="' . url('/test/check-users-countries/' . ($page + 1)) .'">></a>';
		}

		echo '</p>
		<table border="1" cellpadding="5" cellspacing="0">
			<tr>
				<th>#</th>
				<th>Name</th>
				<th>Country</th>
				<th>Address country</th>
				<th>Address area</th>
				<th>Address region</th>
				<th>Billing area</th>
				<th>Billing region</th>
				<th>Billing country</th>
				<th>Company area</th>
				<th>Company region</th>
				<th>Company country</th>
				<th>Order plan region</th>
				<th>Pickup countries</th>
			</tr>';

		foreach ($users as $user) {
			$country = $user->country;
			$address_country = $user->address_country;
			$address_area = $user->area;
			$address_area = $address_area ? $address_area->slug : '';
			$address_region = $user->getRegion()->name;
			$billing_area = Area::where('zip_code', $user->billing_postalcode)->first();
			$billing_area = $billing_area ? $billing_area->slug : '';
			$billing_region = Area::where('zip_code', $user->billing_postalcode)->first();
			$billing_region = $billing_region ? $billing_region->region->name : '';
			$billing_country = is_numeric($user->billing_country) ? Country::find($user->billing_country)->slug : $user->billing_country;
			$company_area = Area::where('zip_code', $user->company_address_postal_code)->first();
			$company_area = $company_area ? $company_area->slug : '';
			$company_region = Area::where('zip_code', $user->company_address_postal_code)->first();
			$company_region = $company_region ? $company_region->region->name : '';
			$company_country = Country::find($user->company_address_country);
			$company_country = $company_country ? $company_country->slug : '';
			$order_plan_region = OrderPlanRegion::where('id', $user->order_plan_region_id)->first();
			$order_plan_region = $order_plan_region ? $order_plan_region->region->name : '';
			$pickups = $user->pickups;

			echo '<tr>
				<td>' . $user->id . '</td>
				<td>' . (empty($user->name) ? $user->firstname . ' ' . $user->lastname : $user->name) . '</td>
				<td>' . $country . '</td>
				<td>' . $address_country . '</td>
				<td>' . $address_area . '</td>
				<td>' . $address_region . '</td>
				<td>' . $billing_area . '</td>
				<td>' . $billing_region . '</td>
				<td>' . $billing_country . '</td>
				<td>' . $company_area . '</td>
				<td>' . $company_region . '</td>
				<td>' . $company_country . '</td>
				<td>' . $order_plan_region . '</td>
				<td>';

			$i = 0;
			foreach ($pickups as $pickup) {
				if (!empty($pickup->country)) {
					if ($i > 0) echo ', ';
					echo $pickup->country;
					$i++;
				}
			}

			echo '</td>
			</tr>';
		}

		echo '</table>';
	}

	public function anyInvoiceContent() {
		$answers = OrderAnswer::where('visible', true)->whereIn('order_question_parent_id', [2, 3, 6, 12])->get();

		echo '<p><strong>Invoice from order</strong></p>';

		$order = new Order();
		$order->services = [];

		foreach ($answers as $answer) {
			$order->services[] = [
				'Answer' => $answer,
				'value' => $answer->value_number_from
			];
		}

		$invoice = new Invoice();
		$invoice->title = shortcode(lg('invoice.description.order'), [
            'date' => [
                'begin' => date('01/m/Y'),
                'end' => date('d/m/Y')
            ]
        ]);
		$invoice->content = $invoice->title . '<br />';
        $invoice->content .= $order->getTotalDescription('invoice');

		echo $invoice->content;

		echo '<p><strong>Invoice from getback</strong></p>';

		$pickup = new Pickup();
		$pickup->pickup_date = new Datetime();
		$pickup->save();

		foreach ($answers as $answer) {
			$pickup->answers()->create([
				'value' => $answer->value_number_from,
				'order_answer_id' => $answer->id
			]);
		}

		$invoice = new Invoice();
        $invoice->content = $pickup->getDeliveryPriceDescription();

		echo $invoice->content;

		// TODO : check other way to create invoice
	}
}
