<?php

/**
 * ApiUserTest
 *
 * $ php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\User;

class ApiUserTest extends TestCase {
	public $basePath = '/api/v2/users';

    /**
     * Test the user apis
     */
    public function testUsersApi(){
        $this->checkEnvironmentTesting();

        $this->it_should_add_fee();
	}

    /**
     *
     */
    public function it_should_add_fee(){

    }

	public function it_should_login() {

		$params = array_merge($this->getAuthParams(), [
			'email' => 'user@cherrypulp.com',
			'password' => '123456'
		]);

		$response = $this->call('POST', $this->basePath . '/login', $params);

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function it_should_update_user() {

		$user = User::find(2);

		$params = array_merge($this->getAuthParams(), [
			'id' => $user->id,
			'country' => 'France',
			'password' => '789456'
		]);

		$response = $this->call('PUT', $this->basePath, $params);

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

    /**
     * Check if users infos is there
     */
    public function it_should_get_users_infos(){

        $response = $this->callV2('GET', $this->endpoint('users'), $this->params());

        $this->assertArrayHasKey('invoice_status', $response[0]);
        $this->assertArrayHasKey('card_status', $response[0]);
        $this->assertArrayHasKey('advisor', $response[0]);
        $this->assertArrayHasKey('average_cart', $response[0]);
        $this->assertArrayHasKey('last_order', $response[0]);
    }
}
