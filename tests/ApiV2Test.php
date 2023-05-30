<?php

/**
 * ApiArxminUserTest
 *
 * $ php vendor/phpunit/phpunit/phpunit tests/ApiArxminUserTest
 */

class ApiV2Test extends TestCase {

    /**
     * Test if it's protected or not
     */
    public function testApiV2(){

	}

    /**
     * Test if user have av
     */
    public function it_should_block_user_if_no_api_keys_provided(){

        // Mock a wrong get
        $response = $this->call('GET', $this->endpoint('users'), []);

        $this->assertEquals(400, $response->getStatusCode());

        $response = $this->call('GET', $this->endpoint('users'), $this->params());

        $this->assertEquals(200, $response->getStatusCode());
	}

	public function it_should_login_user() {

		$params = $this->params([
			'email' => 'private@cherrypulp.com',
			'password' => '123456'
		]);

		$response = $this->call('GET', $this->endpoint('users/login'), $params);

		$this->assertEquals(200, $response->getStatusCode());
	}



    /**
     * Test the add of a fee
     */
    public function it_should_add_a_fee(){

        /*$response = \App\Api\v2\ApiUser::addFee([
            'name' => '',
            'user_id' => '',
            'ref' => '',
        ]);*/

        $order_plan = \App\OrderPlanAsset::create([
            'slug' => 'test',
            'fr' => [
                'name' => 'test fr'
            ],
            'en' => [
                'name' => 'test en'
            ],
        ]);

        $order_plan->save();

        $this->assertEquals($order_plan->name, 'test en');

        $order_plan->delete();
	}
}
