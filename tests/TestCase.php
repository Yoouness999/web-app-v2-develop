<?php

use App\User;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @property \Faker\Generator faker
 */
class TestCase extends Illuminate\Foundation\Testing\TestCase {

    /**
     * Additional headers for the request.
     *
     * @var array
     */
    protected $defaultHeaders = [];

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://loc.boxify.be';


    public $basePathV2 = '/api/v2/';
    public $basePathV3 = '/api/v3/';

    public static $apiCredentials = null;

    public $faker = null;

    /**
     * @return \Faker\Generator
     */
    public function getFaker()
    {
        return $this->faker?: \Faker\Factory::create('fr_BE');
    }

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		require_once __DIR__ . '/../_config.php';

		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		config(['app.url' => 'http://local.boxify.be']);

		// Prevent unit testing to be ran in production or demo env !
        $this->checkEnvironmentTesting();

        // Add faker
        $this->faker = Faker\Factory::create('fr_BE');

		return $app;
	}

	public function getAuthParams() {
		return [
			'app_id' => 68413973,
			'app_secret' => 'qzd498il21d68ear79ipo54ed'
		];
	}

    /**
     * Get a test user by default
     * @param string $email
     * @return
     */
    public function getTestUser($email = 'test@cherrypulp.com'){

        $user = \App\User::withTrashed()->where('email', $email)->first();

        if (!$user) {
            $user = \App\User::create([
                'active' => 1,
                'email' => "test@cherrypulp.com",
                'name' => 'Test',
                "first_name" => "test",
                'last_name' => 'test',
                'lang' => 'en'
            ]);
        } else {
            $user->restore();
        }


        if (!$user->billing_method == \App\User::BILLING_METHOD_SEPA) {

            $user->company_address_country = 'BE';
            $user->billing_exempted = 0;
            $user->business = 0;
            $user->billing_method = User::BILLING_METHOD_SEPA;
            $user->billing_iban = "FR1420041010050500013M02606";
            $user->save();

            /**
             * Test Sepa flow
             */
            # 1. add a sepa contract for the user
            $result = App\Adyen::createShopperSepaContract($user, $user->billing_iban, 'A. Grand');
        }


        return $user;
	}

    /**
     * Decode json from response
     *
     * @param $response
     * @param bool $toarray
     * @return mixed
     */
    public function decodeJson($response, $toarray = true){
        return json_decode($response->getContent(), $toarray);
	}

    /**
     * Check if we are in environment testing to prevent any error
     */
    public function checkEnvironmentTesting(){

        $result = config('database.connections.' . config('database.default'));

        if ($result['password'] != 'root') {
            die('[X] This test cannot be run in demo or production !');
        }
	}

	public function getUploadedFile($source, $dest, $mimetype = 'image/jpeg') {
		copy($source, $dest);
		return new UploadedFile($dest, basename($dest), $mimetype, filesize($dest), null, true);
	}

	public function displayResponseMessage($response) {
		echo json_decode($response->getContent())->message;
	}


    public function callV2Json($method, $endpoint, $parameters = [], $cookies = [], $files = [], $server = [], $content = null){

        $response = $this->call($method, $this->endpoint($endpoint), $this->params($parameters), $cookies, $files, $server, $content);

        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->decodeJson($response, true);

        return $response;
	}

    /**
     * Helper to return the first entity in data result
     *
     * @param $method
     * @param $endpoint
     * @param array $parameters
     * @param array $cookies
     * @param array $files
     * @param array $server
     * @param null $content
     * @return \Illuminate\Http\Response|mixed
     */
    public function callV2JsonFirstItem($method, $endpoint, $parameters = [], $cookies = [], $files = [], $server = [], $content = null){

        $response = $this->call($method, $this->endpoint($endpoint), $this->params($parameters), $cookies, $files, $server, $content);

        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->decodeJson($response, true);

        if ($response['data']) {
            return $response['data'][0];
        }

        return $response;
    }

    /**
     * Little helper to output a message
     * @param $msg
     */
    public function addMessage($msg){
        echo $msg . "\n";
    }

    /**
     * Litte helper to build the full api url
     *
     * @param $url
     * @return string
     */
    public function endpoint($url){
        return $this->basePathV2.$url;
    }

    /**
     * Add api_token to any request
     *
     * @param array $data
     * @return array
     */
    public function params(array $data = []){

        if (!self::$apiCredentials) {
            $api = \App\Api\ApiApp::first();
            self::$apiCredentials = ["app_id" => $api->app_id, "app_secret" => $api->app_secret];
        }

        return array_merge(self::$apiCredentials, $data);
    }
}
