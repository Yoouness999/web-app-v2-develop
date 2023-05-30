<?php

/**
 * ApiItemTest
 *
 * $ php vendor/phpunit/phpunit/phpunit tests/ApiItemTest
 */

use App\Item;
use App\User;
use App\Pickup;
use App\Api\v2\ApiItem;
use App\Api\v2\ApiUser;

class ApiItemTest extends TestCase {

	public $basePath = '/api/v2/items';

    public function testItemsV2(){
        //$this->it_should_get_items_infos();

        $this->it_recalculcate_the_subscription_plan();
	}

    /**
     * Test the plan automatically
     *
     * @see http://pm2.cherrypulp.com/projects/543?modal=Task-11238-543
     */
    public function it_recalculcate_the_subscription_plan(){


        $user = User::where('email', 'test@cherrpulp.com')->first();

        // Delete all items related to the user

        $user->items()->delete();

        /**
         * Add just one item to user
         */

        $item = Item::create([
           'user_id' => $user->id,
            'volume_m3' => 3
        ]);

        /**
         * @see \App\Handlers\Events\ItemUpdatedHandler
         */
        event(new \App\Events\ItemUpdatedEvent($item));

        $this->assertEquals(3, $user->plan->volume_m3);
	}

	public function it_should_get_items_infos() {

		$data = $this->callV2JsonFirstItem('GET', 'items');

        $this->assertArrayHasKey('localisation', $data);
        $this->assertArrayHasKey('volume_m3', $data);
	}

	public function it_should_add_item() {

		$user = User::orderByRaw('RAND()')->first();
		$pickup = Pickup::orderByRaw('RAND()')->first();
		$types = ApiItem::types();
		$statuses = ApiItem::statuses();
		$cities = ApiUser::cities();
		$pickupOptions = ApiItem::pickupOptions();

		$params = array_merge($this->getAuthParams(), [
			'user_id' => $user->id,
			'pickup_id' => $pickup->id,
			'ref' => 'ref',
			'type' => $types[array_rand($types)]['id'],
			'status' => $statuses[array_rand($statuses)],
			'name' => 'Test',
			'description' => 'Test',
			'weight' => rand(100, 1000) / 100,
			'price' => rand(100, 10000) / 100,
			'bulk_item' => rand(0, 1) == 0,
			'picture_option' => rand(0, 1) == 0,
			'street' => "Rue de l'Etuve",
			'number' => '48',
			'box' => '1st floor',
			'postalcode' => '1000',
			'city' => $cities[array_rand($cities)],
			'longitude' => '50.844951',
			'latitude' => '4.349827',
			'add_infos' => 'test',
			'pickup_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'pickup_option' => $pickupOptions[array_rand($pickupOptions)],
			'storage_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'ending_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'billing_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'billing_status' => 'test',
			'billing_ref' => 'test',
			'box_id' => rand(1, 100),
			'storage_country' => 'Belgique',
			'storage_warehouse' => 'Test',
			'storage_floor' => '1',
			'storage_row' => '2',
			'storage_rack' => '5',
			'storage_rack_floor' => '2',
			'storage_pallet' => '6',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
			'intern_note' => 'Test',
			'price_estimation' => rand(100, 10000) / 100,
			'volume_m3' => rand(100, 10000) / 100,
		]);

		$photo = $this->getUploadedFile(
			public_path('assets/img/item-box.jpg'),
			public_path('assets/img/test.jpg')
		);

		$response = $this->call('POST', $this->basePath, $params, [], ['photo' => $photo]);

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function it_testSave() {
		$item = Item::orderByRaw('RAND()')->first();
		$user = User::orderByRaw('RAND()')->first();
		$pickup = Pickup::orderByRaw('RAND()')->first();
		$types = ApiItem::types();
		$statuses = ApiItem::statuses();
		$cities = ApiUser::cities();
		$pickupOptions = ApiItem::pickupOptions();

		$params = array_merge($this->getAuthParams(), [
			'id' => $item->id,
			'user_id' => $user->id,
			'pickup_id' => $pickup->id,
			'ref' => 'ref',
			'type' => $types[array_rand($types)]['id'],
			'status' => $statuses[array_rand($statuses)],
			'name' => 'Test',
			'description' => 'Test',
			'weight' => rand(100, 1000) / 100,
			'price' => rand(100, 10000) / 100,
			'bulk_item' => rand(0, 1) == 0,
			'picture_option' => rand(0, 1) == 0,
			'street' => "Rue de l'Etuve",
			'number' => '48',
			'box' => '1st floor',
			'postalcode' => '1000',
			'city' => $cities[array_rand($cities)],
			'longitude' => '50.844951',
			'latitude' => '4.349827',
			'add_infos' => 'test',
			'pickup_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'pickup_option' => $pickupOptions[array_rand($pickupOptions)],
			'storage_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'ending_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'billing_date' => date('Y-m-d H:i:s', rand(time(), time() + 60 * 60 * 24 * 30)),
			'billing_status' => 'test',
			'billing_ref' => 'test',
			'box_id' => rand(1, 100),
			'storage_country' => 'Belgique',
			'storage_warehouse' => 'Test',
			'storage_floor' => '1',
			'storage_row' => '2',
			'storage_rack' => '5',
			'storage_rack_floor' => '2',
			'storage_pallet' => '6',
			'created_at' => date('Y-m-d H:i:s', time()),
			'updated_at' => date('Y-m-d H:i:s', time()),
			'intern_note' => 'Test',
			'price_estimation' => rand(100, 10000) / 100
		]);

		$photo = $this->getUploadedFile(
			public_path('assets/img/bg-404.jpg'),
			public_path('assets/img/test.jpg')
		);

		$response = $this->call('PUT', $this->basePath, $params, [], ['photo' => $photo]);

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function it_testGetTypes() {
		$response = $this->call('GET', $this->basePath . '/types', $this->getAuthParams());

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function it_testGetStatuses() {
		$response = $this->call('GET', $this->basePath . '/statuses', $this->getAuthParams());

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function it_testGetPickupOptions() {
		$response = $this->call('GET', $this->basePath . '/pickup-options', $this->getAuthParams());

		$this->displayResponseMessage($response);
		$this->assertEquals(200, $response->getStatusCode());
	}
}
