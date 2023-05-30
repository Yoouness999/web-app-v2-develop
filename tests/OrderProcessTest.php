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

class OrderProcessTest extends TestCase
{
    /**
     * Test the whole order process flow
     *
     * Scenarios see :
     * @see https://docs.google.com/document/d/1bIIA0VfYNeP_Q3wFyn0Ju4KnHEf0xc-cAxHvIpRob6M/edit?ts=5a5de4ec#
     *
     */
    public function it_testOrderFlows()
    {
        $faker = $this->faker;

        /**
         * Actors
         *
         * @var $customer User
         * @var $employee \App\ArxminUser
         */
        $customer = User::where('email', 'user@cherrypulp.com')->first();
        $employee = \App\ArxminUser::where('email', 'private@cherrypulp.com')->first();

        $this->assertNotNull($customer);
        $this->assertNotNull($employee);

        /**
         * 1. Init an order process
         */
        $order = $this->makeOrder($customer, [
            'items' => [
                [
                    1 => 1
                ]
            ],
            'answers' => [[
                'Answer' => 1
            ]],
            'pickup_date' => date('Y-m-d', strtotime('first day of next month')) . ' 10:00:00',
            'pickup_date_to' => date('Y-m-d', strtotime('first day of next month')) . ' 12:00:00'
        ]);

        /**
         * 1.1 Check that new pickup is created
         */
        $this->assertNotNull($order->pickup);

        /**
         * @var $pickup \App\Pickup
         */
        $pickup = $order->pickup;

        /**
         * Check that we invoice the order
         */
        //$this->assertNotNull($pickup->invoice);

        $this->assertEquals($pickup->status, \App\Pickup::STATUS_ORDERED);

        /**
         * Admin must assigned a delivery man
         */
        $pickup->assigned_deliveryman_arxmin_user_id = $employee->id;

        $pickup->save();

        $deliveryMan = $pickup->assignedDeliveryMan;

        $this->assertEquals('private@cherrypulp.com', $deliveryMan->email);

        $pickupData = $pickup->toArrayApi();

        $this->assertNotNull($pickupData['assigned_delivery_man']);

        /**
         * User must be able to see the pickup in their manager
         * @todo !!
         */

        /**
         * Add an item to a pickup
         */
        $pickup->itemsRecords()->create([
            'name' => $faker->title,
            'volume_m3' => 3,
            'status' => \App\Item::STATUS_STORED
        ]);

        /**
         * Reset database
         */
        $pickup->forceDelete();
        $order->forceDelete();
    }

    /**
     * Make an order
     */
    public function makeOrder($customer, $params = [])
    {

        $faker = $this->faker;

        $order = new \App\Order();

        $order->booking = null;
        $order->pickup = null;

        $order->items = [
            [
                'CalculatorItem' => 1
            ]
        ];

        $order->plan = null;
        $order->storingDuration = null;
        $order->isComingFromCalculator = false;

        $order->address_full = $faker->address;
        $order->address_street_number = $faker->streetAddress;
        $order->address_postal_code = $faker->postcode;
        $order->address_locality = $faker->city;
        $order->address_country = $faker->country;

        $order->dropoff_date_from = null;
        $order->dropoff_date_to = null;
        $order->pickup_date_from = null;
        $order->pickup_date_to = null;
        $order->wait_fill_boxes = false;

        $order->card_number = '';
        $order->iban = '';
        $order->iban_owner = '';
        $order->adyen_card_encrypted_json = '';
        $order->expiration_month = '';
        $order->expiration_year = '';

        $order->company_address_full = '';
        $order->company_address_street_number = '';
        $order->company_address_route = '';
        $order->company_address_postal_code = '';
        $order->company_address_locality = '';
        $order->company_address_country = '';
        $order->company_address_box = '';
        $order->company_name = '';
        $order->company_vat_number = '';

        $order->how_did_your_hear_about_us = '';
        $order->comments = '';

        $order->user = $customer;
        $order->assurance = null;

        foreach ($params as $key => $value) {
            $order->{$key} = $value;
        }

        $order->save();
        return $order;
    }

    /**
     * Test the order process
     */
    public function testOrder()
    {
        $this->it_test_frontend_order_process();
        //$this->it_testOrderFlows();
    }

    /**
     * Test each front end post request
     */
    public function it_test_frontend_order_process()
    {
        Session::start();

        /**
         * Setup the scenario
         *
         * @var $user User
         */
        $user = User::where('email', 'user@cherrypulp.com')->first();

        // Remove any plan or
        $user->update([
            'order_plan_id' => "",
            'order_plan_region_id' => "",
            'order_plan_price_per_month' => "",
            'order_assurance_id' => "",
            'order_storing_duration_id' => "",
            'end_commitment_period' => "",
        ]);

        // Delete all orders related to user
        $user->orderBookings()->delete();
        $user->invoices()->delete();

        $this->be($user);

        $postal_code = 1030;

        $this->session([
            'order' => new Order(),
            "postal_code" => $postal_code,
        ]);

        echo "POST /order/storage";

        $this->call('post', '/order/storage', [
            '_token' => csrf_token(),
            'plan' => 2
        ]);

        $this->assertSessionHas('order');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('order/services');

        /**
         * @var $order Order
         */
        $order = Session::get('order');

        $this->assertEquals($order->plan->id, 2);

        $this->session([
            'order' => $order,
            "postal_code" => $postal_code,
        ]);

        $this->call('post', '/order/services', [
            '_token' => csrf_token(),
            "postal_code" => $postal_code,
            'answers' => [
                'boolean' => [
                    '1' => 'no',
                    '4' => 'no',
                    '5' => 'no',
                ],
                'number' => [
                    '2' => 0
                ],
            ],
        ]);

        $this->assertSessionHas('order');

        /**
         * @var $order Order
         */
        $order = Session::get('order');

        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('order/appointment');

        $this->session([
            'order' => Session::get('order')
        ]);

        $this->call('post', '/order/appointment', [
            '_token' => csrf_token(),
            'plan_price_per_month' => "61",
            'appointment' => 300,
            'address_route' => "Rue des palais",
            'address_street_number' => "115",
            'address_box' => '',
            'address_postal_code' => $postal_code,
            "address_locality" => "Schaerbeek",
            "address_country" => "Belgique",
            "pickup_time" => "2018-04-20 10:00:00_2018-04-20 12:00:00",
            "storing_duration" => 4
        ]);

        $this->assertSessionHas('order');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('order/billing');

        $this->session([
            'order' => Session::get('order')
        ]);
        $this->call('post', '/order/billing', [
            '_token' => csrf_token(),
            'payment_type' => "sepa",
            'iban' => "FR1420041010050500013M02606",
            'iban_owner' => "A. Grand",
        ]);

        $this->assertSessionHas('order');
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('order/review');

        $this->session([
            'order' => Session::get('order')
        ]);

        // Create a coupon that need to be applied directly
        $coupon = \App\Coupon::create([
            'code' => 'TESTUNIT',
            "promo_applied" => "10%",
            "promo_type" => \App\Coupon::PROMO_TYPE_PROMO,
            "quantity" => 1
        ]);

        \App\CouponUser::where('coupon_id', $coupon->id)->delete();

        $this->call('post', '/order/review', [
            '_token' => csrf_token(),
            'price_per_month' => '61',
            'first_name' => '1521701603',
            'last_name' => 'Sum',
            'phone' => '+32 485662569',
            'email' => 'user@cherrypulp.com',
            'assurance' => '1',
            'comments' => '',
            'business' => 0,
            'company_address_route' => '',
            'company_address_street_number' => '',
            'company_address_box' => '',
            'company_address_postal_code' => $postal_code,
            'company_address_locality' => '',
            'company_address_country' => '1',
            'company_name' => '',
            'company_vat_number' => '',
            'coupon' => $coupon->code,
            'how_did_your_hear_about_us' => 'google-advertising',
            'how_did_your_hear_about_us_comment' => 'test-comment',
            'gdpr' => 1
        ]);

        $this->assertSessionHas('order');
        $this->assertResponseStatus(302);

        if (Session::has('errors') || Session::has('common.errors')) {
            echo "Errors";
            var_dump(Session::all());
        }

        $this->assertRedirectedTo('order/confirmation');


        // Refresh user
        $user = User::where('email', 'user@cherrypulp.com')->first();

        $order = Session::get('order');

        $this->assertNotNull($order->invoice);
        $this->assertNotNull($order->pickup);
        $this->assertNotNull($order->booking);

        $invoice = $order->invoice;

        echo "Invoice total : " . $invoice->price;

        /**
         * Invoice price total should be the prorata regarding the date
         */

        $booking = $order->booking;

        $this->assertEquals('test-comment', $booking->how_did_your_hear_about_us);

        // Assert that the plan linked to the user is the 3m2
        $this->assertEquals(2, $user->order_plan_id);

        // User should have a region id linked to his profile
        $this->assertEquals(1331, $user->order_plan_region_id);

        $this->assertContains(ucfirst(__("common.discount")), $invoice->content);

        \App\CouponUser::where('coupon_id', $coupon->id)->forceDelete();

        $coupon->forceDelete();

        /**
         * Order plan price should be equal to Region order plan price
         */
        $orderPlan = \App\OrderPlanRegion::where('id', $user->order_plan_region_id)->first();

        $this->assertEquals($coupon->promo_applied, $order->promo_code_applied);

        $this->assertEquals($orderPlan->price_per_month, $user->order_plan_price_per_month);
    }
}
