<?php

/**
 * ApiPickupTest
 *
 * $ php vendor/phpunit/phpunit/phpunit tests/ApiPickupTest
 */

use App\Pickup;
use App\User;
use App\Api\v2\ApiUser;

class ApiPickupTest extends TestCase {

	public $basePath = '/api/v2/pickups';

    public function testPickup(){
        $this->it_check_pickups_list();
	}

    public function it_check_pickups_list(){
        $data = $this->callV2JsonFirstItem('GET', 'pickups');

        $this->assertArrayHasKey('type', $data);
        $this->assertArrayHasKey('volume', $data);
        $this->assertArrayHasKey('assigned_delivery_man', $data);

        $this->assertArrayHasKey('fragile', $data);
        $this->assertArrayHasKey('floor', $data);
        $this->assertArrayHasKey('transporter_number', $data);
        $this->assertArrayHasKey('parking', $data);
	}

	public function it_testGet() {
		$response = $this->call('GET', $this->basePath, $this->getAuthParams());

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function it_testAdd() {
		$user = User::orderByRaw('RAND()')->first();
		$cities = ApiUser::cities();

		$params = array_merge($this->getAuthParams(), [
			'user_id' => $user->id,
			'total' => rand(100, 10000) / 100,
			'street' => "Rue de l'Etuve",
			'number' => '48',
			'box' => '1st floor',
			'postalcode' => '1000',
			'city' => $cities[array_rand($cities)],
			'status' => 'ordered',
			'add_infos' => 'Test',
			'history'=> 'Test',
			'pickup_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'intern_note' => 'Test',
			'dropoff_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'dropoff_time_from' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'dropoff_time_to' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'pickup_time_from' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'pickup_time_to' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time())
		]);

		$signPhoto = $this->getUploadedFile(
			public_path('assets/img/item-box.jpg'),
			public_path('assets/img/test.jpg')
		);

		$response = $this->call('POST', $this->basePath, $params, [], ['sign_photo' => $signPhoto]);

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function it_testSave() {

		$pickup = Pickup::orderByRaw('RAND()')->first();
		$user = User::orderByRaw('RAND()')->first();
		$cities = ApiUser::cities();

		$params = array_merge($this->getAuthParams(), [
			'id' => $pickup->id,
			'user_id' => $user->id,
			'total' => rand(100, 10000) / 100,
			'street' => "Rue de l'Etuve",
			'number' => '48',
			'box' => '1st floor',
			'postalcode' => '1000',
			'city' => $cities[array_rand($cities)],
			'status' => 'ordered',
			'add_infos' => 'Test',
			'history'=> 'Test',
			'pickup_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'intern_note' => 'Test',
			'dropoff_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'dropoff_time_from' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'dropoff_time_to' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'pickup_time_from' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'pickup_time_to' => date('H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time())
		]);

		$signPhoto = $this->getUploadedFile(
			public_path('assets/img/item-box.jpg'),
			public_path('assets/img/test.jpg')
		);

		$response = $this->call('PUT', $this->basePath, $params, [], ['sign_photo' => $signPhoto]);

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}
}
