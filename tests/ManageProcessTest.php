<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\Order;
use App\User;

class ManageProcessTest extends TestCase
{
    /**
     * Test the order process
     */
    public function testManageProcess()
    {
        $this->it_get_back_an_item();
    }

    /**
     * Check items cancellation process
     */
    public function it_test_cancel_pickup(){

        Session::start();

        $faker = $this->getFaker();

        $user = $this->getTestUser();

        $this->be($user);

        $pickup = \App\Pickup::create([
            'user_id' => $user,
            'status' => \App\Pickup::STATUS_ORDERED
        ]);

        $this->assertNotNull($pickup);

        /**
         * Item 1 = when item is in transit with an ending date
         *
         * - if canceled should have a in_storage status
         */
        $item_1 = \App\Item::create([
            'user_id' => $user->id,
            'pickup_id' => $pickup->id,
            'pickup_date' => $faker->date('Y-m-d H:i:s'),
            'status' => \App\Item::STATUS_IN_TRANSIT,
            'ending_date' => $faker->date('Y-m-d H:i:s')
        ]);

        /**
         * Item 2 = item in transit with no ending date => if canceled should have a with_me status
         */
        $item_2 = \App\Item::create([
            'user_id' => $user->id,
            'pickup_id' => $pickup->id,
            'pickup_date' => $faker->date('Y-m-d H:i:s'),
            'status' => \App\Item::STATUS_IN_TRANSIT
        ]);

        $this->call('post', '/profile/api/v1/cancel-schedule', [
            '_token' => csrf_token(),
            'itemsIds' => [
                $item_1->id,
                $item_2->id
            ]
        ]);


        $this->assertResponseStatus(200);

        $item_1 = $item_1->fresh();
        $item_2 = $item_2->fresh();

        $this->assertEquals(\App\Item::STATUS_STORED, $item_1->status);

        $this->assertEquals(\App\Item::STATUS_DELIVERED, $item_2->status);
    }

    /**
     * Test different events
     */
    public function it_test_cancel_pickup_event(){

        $faker = $this->getFaker();

        $user = $this->getTestUser();

        $pickup = \App\Pickup::create([
            'user_id' => $user,
            'status' => \App\Pickup::STATUS_ORDERED
        ]);

        $this->assertNotNull($pickup);

        $item_1 = \App\Item::create([
            'user_id' => $user->id,
            'pickup_id' => $pickup->id,
            'pickup_date' => $faker->date('Y-m-d H:i:s'),
            'status' => \App\Item::STATUS_IN_TRANSIT,
            'ending_date' => $faker->date('Y-m-d H:i:s')
        ]);

        $item_2 = \App\Item::create([
            'user_id' => $user->id,
            'pickup_id' => $pickup->id,
            'pickup_date' => $faker->date('Y-m-d H:i:s'),
            'status' => \App\Item::STATUS_IN_TRANSIT
        ]);

        $data = event(new \App\Events\PickupCancelEvent($user, [$item_1->id, $item_2->id]));

        # Refresh values from event change
        $item_1 = \App\Item::find($item_1->id);
        $item_2 = \App\Item::find($item_2->id);
        $pickup = \App\Pickup::find($pickup->id);

        # If the pickup is canceled => the item should still in_storage
        $this->assertEquals($item_1->status, \App\Item::STATUS_STORED);
        $this->assertEquals($item_2->status, \App\Item::STATUS_DELIVERED);

        $this->assertEquals($pickup->status, \App\Pickup::STATUS_CANCELED);

        $this->assertTrue(is_array($data));

        $item_1->forceDelete();
        $item_2->forceDelete();
        $pickup->forceDelete();
    }

    /**
     * Process to get back an item
     */
    public function it_get_back_an_item(){

        Session::start();

        $faker = $this->getFaker();

        $user = $this->getTestUser();

        $this->be($user);

        $pickup = \App\Pickup::create([
            'user_id' => $user,
            'status' => \App\Pickup::STATUS_ORDERED
        ]);

        $this->assertNotNull($pickup);

        /**
         * Check get back process
         *
         * Item 1 = when item is in transit with an ending date
         *
         * - if canceled should have a in_storage status
         */
        $item_1 = \App\Item::create([
            'user_id' => $user->id,
            'name' => "Item test",
            'pickup_id' => $pickup->id,
            'pickup_date' => $faker->date('Y-m-d H:i:s'),
            'status' => \App\Item::STATUS_STORED
        ]);

        $this->call('post', '/profile/api/v1/get-back', [
            '_token' => csrf_token(),
            "add_infos" => null,
            "box" => "2D",
            "city" => "Schaerbeek",
            "itemsIds" => [
                $item_1->id
            ],
            "latitude" => null,
            "longitude" => null,
            'number' => 44,
            'pickup_date' => "2018-12-23 12:00:00",
            "postalcode" => "1030",
            "street" => "Rue des palais",
            "total" => 0,
            "wait_fill_boxes" => true,
            "services" => [
                'boolean' => [
                    1 => "yes",
                    4 => "yes",
                    5 => "yes",
                ],
                'number' => [
                    2 => 3,
                ],
            ],
        ]);

        $this->assertResponseStatus(200);

        $item_1 = $item_1->fresh();

        $this->assertEquals(\App\Item::STATUS_IN_TRANSIT, $item_1->status);

        /**
         * It should have an invoice autogenerated
         */
        $invoice = Invoice::where('user_id', $user->id)->orderBy('created_at', 'DESC')->first();

        $this->assertNotNull($invoice);

        $item_1->forceDelete();
        $pickup->forceDelete();
    }
}
