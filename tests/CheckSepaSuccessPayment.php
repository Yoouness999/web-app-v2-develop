<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/CheckSepaSuccessPayment
 */

use App\Adyen;
use App\Api;
use App\Invoice;
use App\User;
use App\Events\AdyenNotificationEvent;

class CheckSepaSuccessPayment extends TestCase
{
    /**
     * Test the payment flow from Adyen for sepadirect with success response
     *
     * @scenario :
     *
     * - 10€ Invoice with sepa
	 * - First payment attempt
	 * - Invoice should be queued
     * - Adyen Webhook success
     * - Invoice should be paid
     */
    public function testSepaSuccessPayment()
    {
        echo '#Test sepa success payment';
		
		// Check user is sepa
		
		$user = User::where('email', 'user@cherrypulp.com')->first();
        $user->billing_method = User::BILLING_METHOD_SEPA;
        $user->billing_iban = 'FR1420041010050500013M02606';
        $user->save();
		
		// Create invoice 10€ queued
		
		$invoice = Invoice::create([
            'user_id' => $user->id,
            'price' => 10,
            'type' => 'TEST',
            'status' => Invoice::STATUS_QUEUED
        ]);

        // Add a sepa contract for the user
		
        $result = Adyen::createShopperSepaContract($user, $user->billing_iban, 'A. Grand');

        $this->assertEquals('Authorised', $result['resultCode']);

        // Make a payment
		
        $response = Api::makePayment($user, $invoice);

        $this->assertEquals('Authorised', $response->result['resultCode']);
		$this->assertEquals(Invoice::STATUS_QUEUED, $invoice->status);

        // Mock a fake Adyen Notification event with a merchantReference

        $mockhook = json_decode('{"originalReference":"","reason":"","additionalData_sepadirectdebit_mandateId":"8815208504010610","additionalData_sepadirectdebit_dateOfSignature":"2019-01-15","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"sepadirectdebit","currency":"EUR","additionalData_sepadirectdebit_sequenceType":"First","pspReference":"8835185152538298","merchantReference":"invoice-'.$user->id.'-'.$invoice->id.'","value":"1","live":"false","eventDate":"2018-02-13T09:47:33.37Z"}', true);

        event(new AdyenNotificationEvent($mockhook));
		
		$invoice = $invoice->fresh();

		$this->assertEquals(Invoice::STATUS_PAID, $invoice->status);
    }
}
