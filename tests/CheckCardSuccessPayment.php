<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/CheckCardSuccessPayment
 */

use App\Adyen;
use App\Api;
use App\Invoice;
use App\User;
use App\Events\AdyenNotificationEvent;

class CheckCardSuccessPayment extends TestCase
{
    /**
     * Test the payment flow from Adyen for card with success response
     *
     * @scenario :
     *
     * - 10€ Invoice with card
	 * - First payment attempt
	 * - Invoice should be queued
     * - Adyen Webhook success
     * - Invoice should be paid
     */
    public function testSepaSuccessPayment()
    {
        echo '#Test card error payment';
		
		// Check user is card
		
		$user = User::where('email', 'user@cherrypulp.com')->first();
        $user->billing_method = User::BILLING_METHOD_CREDITCARD;
        $user->save();
		
		// Create invoice 10€ queued
		
		$invoice = Invoice::create([
            'user_id' => $user->id,
            'price' => 10,
            'type' => 'TEST',
            'status' => Invoice::STATUS_QUEUED
        ]);

        // Add a contract for the user
		
		$card_encrypted_json = '{"adyen-encrypted-data":"adyenjs_0_1_19$L+vMsDFaELy5zHVPQ+QoaD2vNlSWySsArVsSlL+g6SQf9jyrJ5AvILVB9mC8kcoQWig13UYGCc4SPRZOj/UYaNsEHFXB8t1R6/wXx7eQ2UK/ydmE0oO8P2wb8w2TFBU4aaSwIdKT1eWsmqnBaRJ4ALKMAHZ9GjJ3sTP8J9Ey/Va8dTpQR8SlISdWiBeGoIOcDmbEbvUlzU7g0aYw1jECYCDnlXy1Iy+luLs45WFYdj7Lzv0NuWbXW67FdQp7BfsFgNJviRtmVJ0VqI/eJan1whtCnRVH00QIHG6xUhh975QoNM/Us6M4VatRwQCcaELhaLGHP+lIe9i9yaVZ23UyCw==$xRY07vFDblvk11mU8Sa0MLIIkVj4Fc6bOj8qJnPBvp/p7flJu3JlLFNg+5kH2yHLL4ty2sxEXqfpe/OFW19bL4W4GhC2bQ2ZNLlUbhbx/9gSh5lL5HTxvSmEFx9y226Uct/+5/ybbOHyAdwXVHqSdGKbaNqJdVg5Lt5sKXHxREJL5kltFyKWMRoCo+ejIXXOfpFnT5bG3jH77K590g+hsJ5WeM3EFLHPKUucIpuegarad7sDZZiMUtqetC6RChSr8DuX2FD2k7InUtDQeKBOASjoOMVhN8XnR0RXmzAAi7TgCIqRSeUAo5X/j1x9OcpkiQvioQjEjCLnKFQcKWXFpAPZQGGX0khbRIyuBNFI70+uBzOK4ei5Z/1oRhoUOClDLRIt4yLJTdnmRfrdUpN5ncrAf7aOKPBUr3lZgo/VGL99ufs0yL2ArGsUQvozkdNeDxYE/z9q9xhVMFtf5N3weK+QpYA="}';
		
        $result = Adyen::createShopperContract($user, $card_encrypted_json);

        $this->assertEquals('Authorised', $result['resultCode']);

        // Make a payment
		
        $response = Api::makePayment($user, $invoice);

        $this->assertEquals('Authorised', $response->result['resultCode']);
		$this->assertEquals(Invoice::STATUS_QUEUED, $invoice->status);

        // Mock a fake Adyen Notification event with a merchantReference

        $mockhook = json_decode('{"originalReference":"","reason":"","additionalData_authCode":"97079","additionalData_expiryDate":"10/2020","additionalData_cardSummary":"3471","merchantAccountCode":"BoxifyCom","eventCode":"AUTHORISATION","operations":"CANCEL,CAPTURE,REFUND","success":"true","paymentMethod":"visa","currency":"EUR","pspReference":"8835185152538298","merchantReference":"invoice-'.$user->id.'-'.$invoice->id.'","value":"1","live":"false","eventDate":"2018-02-13T09:47:33.37Z"}', true);

        event(new AdyenNotificationEvent($mockhook));
		
		$invoice = $invoice->fresh();

		$this->assertEquals(Invoice::STATUS_PAID, $invoice->status);
    }
}
