<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\CouponUser;
use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\User;

class InvoiceProcessTest extends TestCase
{
    /**
     * Test the payment flow
     *
     * @see https://docs.google.com/document/d/1bIIA0VfYNeP_Q3wFyn0Ju4KnHEf0xc-cAxHvIpRob6M/edit?ts=5a5de4ec#
     *
     * @scenario :
     *
     * - User have for 20€ of purchase in January
     * - 01/02 user is invoiced for 20€
     * - User add items for 10€/month the 15/02
     * - 01/03 user is invoiced for 20€ + 5€ (prorata)
     * - 01/4 user is invoiced for 20€
     */
    public function testPaymentFlow()
    {
        global $cp_debug;

        /**
         * Reset user test
         */
        $faker = Faker\Factory::create('fr_BE');

        echo "#Test payment scenario case 1";

        /**
         * @var $orderPlan \App\OrderPlan
         */
        $orderPlan = \App\OrderPlan::find(2);

        /**
         * @var $user User
         */
        $user = $this->getTestUser();


        // By default we use sepa
        $user->company_address_country = 'BE';
        $user->billing_exempted = 0;
        $user->business = 0;
        $user->billing_method = User::BILLING_METHOD_SEPA;
        $user->billing_iban = "FR1420041010050500013M02606";

        // By default we link the order plan #2 (50m3)
        $user->order_plan_id = null;
        $user->order_plan_price_per_month = null;
        $user->order_plan_region_id = null;
        $user->end_subscription = null;
        $user->save();

        $this->assertNotNull($user);

        # Delete all items from user
        $user->coupons()->forceDelete();
        $user->items()->forceDelete();
        $user->invoices()->forceDelete();

        /**
         * @see \App\Http\Controllers\CronController::anyMonthly();
         */
        $response = $this->callCron();

        $this->assertArrayHasKey('user_count', $response);

        # User must count 0
        $this->assertTrue($response['user_count'] == 0);

        /**
         * TEST PRICE CASE (without payment confirmation)
         */

        /**
         * Case 1 :
         *
         * @scenario : User has :
         * - volume plan of 3m3
         * - an order_plan of 3m3 not linked to order_plan_region, no order_storing_duration
         * - pay via SEPA CARD
         *
         * @expected : User should pay 50€
         */
        $currentVolume = 3;

        $item = \App\Item::create([
            'user_id' => $user->id,
            'name' => $faker->name(),
            'status' => \App\Item::STATUS_STORED,
            'volume' => $currentVolume,
            'storage_date' => date('Y-m-d', strtotime('first day of -2 month')),
        ]);

        $orderPlan = \App\OrderPlan::getByVolume($currentVolume, true);

        $user->order_plan_id = $orderPlan->id;
        $user->order_plan_price_per_month = $orderPlan->price_per_month;
        $user->order_assurance_id = null;
        $user->save();
        $user->fresh();

        $response = $this->callCron();

        $this->assertArrayHasKey('user_count', $response);

        $this->assertTrue($response['user_count'] == 1);

        $this->assertEquals($user->getPricePerMonth(), $response['invoice']['price']);

        /**
         * Case 2 : User has an insurance => should pay the pricing plan + the insurance
         *
         * @var $insurance \App\OrderAssurance
         */
        $insurance = \App\OrderAssurance::find(2);
        $user->order_assurance_id = $insurance->id;
        $user->save();

        $response = $this->callCron();

        $this->assertEquals($orderPlan->getPricePerMonth() + $insurance->getPricePerMonth(), $response['invoice']['price']);

        $user->order_assurance_id = null;
        $user->save();

        /**
         * Case 3 : simulate user is engaged and have a discount
         */
        $user->order_assurance_id = $insurance->id;
        $user->save();

        $response = $this->callCron();

        $this->assertEquals($orderPlan->getPricePerMonth() + $insurance->getPricePerMonth(), $response['invoice']['price']);

        $user->order_assurance_id = null;
        $user->save();

        /**
         * If user is billing_exempted it should not pay the TVA
         */
        $user->billing_exempted = 1;
        $user->save();

        $item->storage_date = date('Y-m-d', strtotime('first day of -2 month'));
        $item->save();

        $response = $this->callCron();

        $expectedPrice = round($orderPlan->getPricePerMonth() / 1.21, 2);

        $this->assertEquals($expectedPrice, $response['invoice']['price']);

        /**
         * If user is in Bulgaria and is business => we should apply a tax of 20%
         *
         * @url https://media1.tenor.com/images/c4b14b6a41fb91a2caa57aacba5d347a/tenor.gif?itemid=9318757
         */
        $user->company_address_country = 'BG';
        $user->billing_exempted = 0;
        $user->business = 1;
        $user->save();

        $this->assertEquals(20, $user->tax);

        $response = $this->callCron();
        $expectedPrice = round(($orderPlan->getPricePerMonth() / 1.21) * 1.20, 2);

        $this->assertEquals($expectedPrice, $response['invoice']['price']);

        /**
         * Test payment in case of success
         */
        $response = $this->callCron(true, MonthlyUserInvoiceHandler::FAKE_STATUS_PAID);

        $invoice = \App\Invoice::where('user_id', $user->id)->first();

        $this->assertNotNull($invoice);
        $this->assertEquals($invoice->status, \App\Invoice::STATUS_PAID);

        // Reset user
        $this->resetUser($user);

        /**
         * Test payment in case of error => payment
         */
        $response = $this->callCron(true, MonthlyUserInvoiceHandler::FAKE_STATUS_UNPAID);
        $invoice = \App\Invoice::where('user_id', $user->id)->first();
        $this->assertNotNull($invoice);
        $this->assertEquals($invoice->status, \App\Invoice::STATUS_UNPAID);
        $this->assertEquals($invoice->attempt, 1);
        $this->resetUser($user);

        /**
         * Test a true payment request by sepa
         *
         * By default invoice should be unpaid if via Sepa
         */
        $this->callCron(true, 'unpaid');

        /**
         * @var $invoice Invoice
         */
        $invoice = \App\Invoice::where('user_id', $user->id)->first();
        $this->assertNotNull($invoice);
        $this->assertEquals($invoice->status, \App\Invoice::STATUS_UNPAID);
        $this->assertEquals($invoice->attempt, 1);

        # Simulate a payment notification from Adyen
        event(new \App\Events\AdyenNotificationEvent(json_decode('{"originalReference":"","reason":"97079:3335:08/2018","additionalData_authCode":"97079","additionalData_expiryDate":"08/2018","additionalData_cardSummary":"3335","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"mc","currency":"EUR","pspReference":"8835185152538298","merchantReference":"'.$invoice->getRef().'","value":"1000","live":"false","eventDate":"2018-02-13T09:47:33.37Z"}', true)));

        $invoice = \App\Invoice::where('user_id', $user->id)->first();
        $this->assertNotNull($invoice);
        $this->assertEquals($invoice->status, \App\Invoice::STATUS_PAID);
        $this->assertEquals($invoice->attempt, 1);

        event(new \App\Events\AdyenNotificationEvent(json_decode('{"originalReference":"","reason":"97079:3335:08/2018","additionalData_authCode":"97079","additionalData_expiryDate":"08/2018","additionalData_cardSummary":"3335","merchantAccountCode":"BoxifyCom","eventCode":"CHARGEBACK","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"mc","currency":"EUR","pspReference":"8835185152538298","merchantReference":"'.$invoice->getRef().'","value":"1000","live":"false","eventDate":"2018-02-13T09:47:33.37Z"}', true)));

        $invoice = \App\Invoice::where('user_id', $user->id)->first();
        $this->assertNotNull($invoice);
        $this->assertEquals($invoice->status, \App\Invoice::STATUS_UNPAID);
        $this->assertEquals($invoice->attempt, 2);

        event(new \App\Events\AdyenNotificationEvent(json_decode('{"originalReference":"","reason":"97079:3335:08/2018","additionalData_authCode":"97079","additionalData_expiryDate":"08/2018","additionalData_cardSummary":"3335","merchantAccountCode":"BoxifyCom","eventCode":"REFUND","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"mc","currency":"EUR","pspReference":"8835185152538298","merchantReference":"'.$invoice->getRef().'","value":"1000","live":"false","eventDate":"2018-02-13T09:47:33.37Z"}', true)));

        $invoice = \App\Invoice::where('user_id', $user->id)->first();
        $this->assertNotNull($invoice);
        $this->assertEquals($invoice->status, \App\Invoice::STATUS_UNPAID);
        $this->assertEquals($invoice->attempt, 1);

    }

    /**
     * Reset user
     */
    public function resetUser($user)
    {
        $user->invoices()->delete();
        return $user;
    }

    /**
     * Call cron
     * @param bool $confirm Confirm the payment or not
     * @param null $fakePayment for test mode only => Fake a success payment
     * @return array|bool|mixed|null
     */
    public function callCron($confirm = false, $fakePayment = null)
    {
        /**
         * @see \App\Handlers\Events\MonthlyUserInvoiceHandler
         */
        $response = event(new \App\Events\MonthlyUserInvoiceEvent($confirm, null, true, $fakePayment));

        if ($response) {

            $response = array_pop($response);

            $this->assertTrue(is_array($response));

            return $response;

        } else {
            echo "Error call cron/monthly";
            return false;
        }
    }
}
