<?php

/**
 * Test the whole Invoice Process
 *
 * @comment php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\Handlers\Events\MonthlyUserInvoiceHandler;
use App\Invoice;
use App\User;

class ProfileAccountProcessTest extends TestCase
{

    /**
     * Test the payment flow
     *
     * @see https://docs.google.com/document/d/1bIIA0VfYNeP_Q3wFyn0Ju4KnHEf0xc-cAxHvIpRob6M/edit?ts=5a5de4ec#
     */
    public function testAccount()
    {
        Session::start();

        /**
         * Reset user test
         */
        $faker = Faker\Factory::create('fr_BE');

        echo "#Test payment scenario case 1 \n";

        /**
         * @var $user User
         */
        $user = User::where('email', "test@cherrypulp.com")->withTrashed()->first();
        $user->restore();

        $this->resetUser($user);

        $this->be($user);

        $this->addMessage("POST /profile/account");

        $dataUser = [
            '_token' => csrf_token(),
            "form_name" => "informations",
            "first_name" => $faker->firstName(),
            "last_name" => "Pulp",
            "phone" => "+32 485662569",
            "email" => "test@cherrypulp.com",
            "address_route" => "Connecticut Avenue Northwest",
            "address_street_number" => "4489",
            "address_box" => "2D",
            "address_postal_code" => "1060",
            "address_locality" => "Washington",
            "business" => 1,
            "billing_street" => "Avenue Paul Deschanel",
            "billing_number" => "115",
            "billing_box" => "2D",
            "billing_postalcode" => "1030",
            "billing_city" => "Schaerbeek",
            "billing_country" => "1",
            "company_name" => "Cherry Pulp",
            "company_vat_number" => "BE0826543829",
            "company_address_route" => "Paleizenstraat",
            "company_address_street_number" => "44",
            "company_address_box" => "2D",
            "company_address_postal_code" => "1060",
            "company_address_locality" => "Washington",
            "company_address_country" => "1",
            "submit" => true
        ];

        # Check if we correclty store the data
        $this->call('post', '/profile/account', $dataUser);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/profile/account');

        $this->refreshUser($user);

        $this->assertEquals($dataUser['last_name'], "Pulp");

        # Check if we correclty block email overiding

        $dataUser['email'] = "user@cherrypulp.com";
        $dataUser['first_name'] = "Wrong user";

        $this->call('post', '/profile/account', $dataUser);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/profile/account');
        $this->assertNotEquals($dataUser['first_name'], $user->first_name);

        $this->addMessage("Check Account/informations passed");

        /**
         * Check billing info
         */

        $dataUser = [
            '_token' => csrf_token(),
            'form_name' => 'billing',
            'payment_type' => 'sepa',
            'iban' => 'NL13TEST0123456789',
            'iban_owner' => 'A. Klaassen',
            "submit" => true
        ];

        $this->call('post', '/profile/account', $dataUser);
        $this->assertResponseStatus(302);
        $this->assertRedirectedTo('/profile/account');

        $this->refreshUser($user);
        $this->assertEquals($dataUser['iban'], $user->billing_iban);
        $this->assertEquals($user->billing_method, User::BILLING_METHOD_SEPA);

        $this->addMessage("Check Billing passed /!\ you should test credit card in the front!");

        $this->addMessage('You should also test the password confirmation in the front');
    }

    public function refreshUser(&$user)
    {
        $user = User::where('email', $user->email)->first();
        return $user;
    }

    /**
     * Reset the current user
     * @param $user
     */
    public function resetUser(&$user)
    {
        $user->billing_to = '';
        $user->add_infos = '';
        $user->billing_env = '';
        $user->billing_next_date = '';
        $user->billing_card_holder = '';
        $user->city = '';
        $user->first_name = '';
        $user->street = '';
        $user->phone = '';
        $user->billing_card_month = '';
        $user->number = '';
        $user->billing_number = '';
        $user->billing_box = '';
        $user->last_name = '';
        $user->billing_wallet_id = '';
        $user->longitude = '';
        $user->billing_address = '';
        $user->billing_status = '';
        $user->billing_info_type = '';
        $user->billing_exempted = '';
        $user->billing_type = '';
        $user->oauth_id = '';
        $user->billing_id = '';
        $user->billing_card_number = '';
        $user->postalcode = '';
        $user->lang = '';
        $user->billing_card_year = '';
        $user->billing_customer_id = '';
        $user->billing_card_id = '';
        $user->godfather_id = '';
        $user->billing_street = '';
        $user->box = '';
        $user->latitude = '';
        $user->billing_postalcode = '';
        $user->billing_city = '';
        $user->business = '';
        $user->billing_vat = '';
        $user->billing_iban = "";
        $user->billing_method = "";
        $user->active = 1;
        $user->save();
    }
}
