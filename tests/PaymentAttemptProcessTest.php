<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

require_once __DIR__ . '/Mocks/PaymentMock.php';

use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\User;

class PaymentAttemptProcessTest extends TestCase
{
    /**
     * Test the payment flow V2
     *
     * @see https://docs.google.com/document/d/1bIIA0VfYNeP_Q3wFyn0Ju4KnHEf0xc-cAxHvIpRob6M/edit#heading=h.pzyocoeaq5al
     *
     * @scenario :
     *
     * Facture de 10€
     *
     * Tentatives: 1er du mois, 3 du mois, 7 du mois, 14 du mois, 21 du mois, +1 mois.
     * Après 2 tentatives infructueuses: 15€ d’amende à rajouter sur le proforma avec le libellé (frais administratif de défaut de paiement 7 jours)
     * Après 3 tentatives infructueuses: 20€ d’amende à rajouter sur le proforma avec le libellé (frais administratif de défaut de paiement 14 jours)
     * Après 4 tentatives infructueuses: 30€ d’amende à rajouter sur le proforma avec le libellé (frais administratif de défaut de paiement 21 jours)
     * Après 5 tentatives infructueuses: 50€ d’amende à rajouter sur le proforma avec le libellé (frais administratif de défaut de paiement 1 mois)
     * Ensuite, 50€/mois échu avec une facture en défaut.
     *
     * @see \App\Handlers\Events\PaymentAttemptHandler
     */
    public function testAttempt()
    {
        $user = User::where('email', 'user@cherrypulp.com')->first();
        $user->restore();
        $this->resetUser($user);

        /**
         * We create a fake invoice invoiced
         */
        Invoice::create([
            'user_id' => $user->id,
            'price' => 10,
            'type' => 'TEST'
        ]);

        $this->assertNotNull($user->invoices);

        /**
         * 1. check that user doesn't have any invoice
         */
        //$response = $this->makeAttempt();
        //$this->assertEquals(0, count($response['invoices']));

        // Add an old proforma
        $invoice = Invoice::create([
            'user_id' => $user->id,
            'price' => 10,
            'attempt' => 0,
            'type' => 'TEST',
            'status' => Invoice::STATUS_UNPAID,
            'last_attempt_at' => date('Y-m-d H:i:s', strtotime('-3 days')),
        ]);

        $invoice->save();

        $response = $this->makeAttempt($user, PaymentMock::error(['payment' => true]));

        $this->assertEquals(1, count($response['invoices']));
        $this->assertEquals(1, $response['invoices'][0]->attempt);
        $this->assertEquals(10, $response['invoices'][0]->price);
        $this->assertEquals('TEST', $response['invoices'][0]->type);
        // Last attempt should be the date of today
        $this->assertEquals(date('Y-m-d'), $response['invoices'][0]->last_attempt_at->format('Y-m-d'));

        // If we recall it => it shouldn't be callable
        $response = $this->makeAttempt($user, PaymentMock::error(['payment' => true]));
        $this->assertEquals(0, count($response['invoices']));

        // Restore last_attempt_at
        $invoice->last_attempt_at = date('Y-m-d H:i:s', strtotime('-14 days'));
        $invoice->save();

        // Make a second attempt
        $response = $this->makeAttempt($user, PaymentMock::error(['payment' => true]));
        $this->assertEquals(1, count($response['invoices']));
        $this->assertEquals(2, $response['invoices'][0]->attempt);
        $this->assertEquals(25, $response['invoices'][0]->price);
        $this->assertEquals('TEST', $response['invoices'][0]->type);

        /**
         * Make a third attempt => should trigger a fee of 15€
         */
        // Restore last_attempt_at
        $invoice = $response['invoices'][0];
        $invoice->last_attempt_at = date('Y-m-d H:i:s', strtotime('-21 days'));
        $invoice->save();

        $response = $this->makeAttempt($user, PaymentMock::error(['payment' => true]));

        $this->assertEquals(1, count($response['invoices']));
        $this->assertEquals(3, $response['invoices'][0]->attempt);
        $this->assertEquals(40, $response['invoices'][0]->price);
        $this->assertEquals('TEST', $response['invoices'][0]->type);

        /**
         * Make a 4th attempt => should trigger a fee of 15€ more
         */
        // Restore last_attempt_at
        $invoice = $response['invoices'][0];
        $invoice->last_attempt_at = date('Y-m-d H:i:s', strtotime('-21 days'));
        $invoice->save();

        $response = $this->makeAttempt($user, PaymentMock::error(['payment' => true]));

        $this->assertEquals(1, count($response['invoices']));
        $this->assertEquals(4, $response['invoices'][0]->attempt);
        $this->assertEquals(55, $response['invoices'][0]->price);
        $this->assertEquals('TEST', $response['invoices'][0]->type);

        /**
         * Make a 5th attempt => should trigger a fee of 50€ more
         */
        // Restore last_attempt_at
        $invoice = $response['invoices'][0];
        $invoice->last_attempt_at = date('Y-m-d H:i:s', strtotime('-1 month'));
        $invoice->save();

        $response = $this->makeAttempt($user, PaymentMock::error(['payment' => true]));

        $this->assertEquals(1, count($response['invoices']));
        $this->assertEquals(5, $response['invoices'][0]->attempt);
        $this->assertEquals(75, $response['invoices'][0]->price);
        $this->assertEquals('TEST', $response['invoices'][0]->type);


        /**
         * Make an attempt each month => should trigger a fee of 65€ more
         */
        // Restore last_attempt_at
        $invoice = $response['invoices'][0];
        $invoice->last_attempt_at = date('Y-m-d H:i:s', strtotime('-2 month'));
        $invoice->save();

        $response = $this->makeAttempt($user, PaymentMock::error(['payment' => true]));

        $this->assertEquals(1, count($response['invoices']));
        $this->assertEquals(6, $response['invoices'][0]->attempt);
        $this->assertEquals(140, $response['invoices'][0]->price);
        $this->assertEquals('TEST', $response['invoices'][0]->type);
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
     * @param $user
     * @param null $mockPayment
     * @param bool $confirm Confirm the payment or not
     * @param null $date
     * @return array|bool|mixed|null
     * @internal param null $fakePayment for test mode only => Fake a success payment
     */
    public function makeAttempt($user, $mockPayment = null, $date = null)
    {
        $confirm = false;

        /**
         * @see \App\Handlers\Events\PaymentAttemptHandler
         */
        if ($mockPayment) {
            $confirm = true;
        }

        $response = event(new \App\Events\PaymentAttemptEvent($user, true, $confirm, $date, $mockPayment));

        if ($response) {

            $response = array_pop($response);

            $this->assertTrue(is_array($response));

            return $response;

        } else {
            echo "Error call payment attempt";
            return false;
        }
    }
}
