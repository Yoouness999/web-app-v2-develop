<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\Adyen;
use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\User;

class AdyenPaymentProcess extends TestCase
{
    /**
     * Test the payment flow from Adyen
     *
     * @see https://docs.google.com/document/d/1bIIA0VfYNeP_Q3wFyn0Ju4KnHEf0xc-cAxHvIpRob6M/edit?ts=5a5de4ec#
     *
     * @scenario :
     *
     * - User have for 20€ of purchase in January
     * - 01/02 user is invoiced for 20€
     * - User add items for 10€/month the 15/02
     * - 01/03 user is invoiced for 30€ + 5€ (prorata)
     * - 01/4 user is invoiced for 30€
     */
    public function testPaymentFlow()
    {
        echo "#Test payment scenario case 1";

        /**
         * @var $user User
         */
        $user = User::where('email', 'test@cherrypulp.com')->first();
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

        $this->assertEquals('Received', $result['resultCode']);

        $ref = 'test-'.$user->id.'-'.date('U');

        # 2. Make a payment
        $result = Adyen::makeRecurringPayment($user, 10, $ref);

        $this->assertEquals('Authorised', $result['resultCode']);

        # 3. Mock a fake Adyen Notification event with a merchantReference

        /**
         * @see \App\Handlers\Events\AdyenNotificationHandler
         */

        $mockhook = json_decode('{"originalReference":"","reason":"97079:3335:08/2018","additionalData_authCode":"97079","additionalData_expiryDate":"08/2018","additionalData_cardSummary":"3335","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"mc","currency":"EUR","pspReference":"8835185152538298","merchantReference":"'.$ref.'","value":"1000","live":"false","eventDate":"2018-02-13T09:47:33.37Z"}', true);

        $result = event(new \App\Events\AdyenNotificationEvent($mockhook));

        $this->assertEquals(1, count($result));

        $result = array_pop($result);

        $this->assertTrue($result);
    }
}
