<?php

/**
 * ApiUserTest
 *
 * $ php vendor/phpunit/phpunit/phpunit tests/ApiUserTest
 */

use App\User;

class ApiCouponTest extends TestCase {

	public $basePath = '/api/v2/users';

    /**
     * Test the user apis
     */
    public function testCouponApi(){
        $this->checkEnvironmentTesting();

        $this->it_should_get_coupons();
	}

    /**
     * Check coupons
     */
    public function it_should_get_coupons(){

        $coupon = \App\Coupon::create([
            'code' => 'test',
            'promo_applied' => '20',
            'promo_type' => \App\Coupon::$types['promo'],
            'from_date' => date('Y-m-d H:i:s', strtotime('-10 days')),
            'expiry_date' => date('Y-m-d H:i:s', strtotime('10 days')),
            'quantity' => 1
        ]);

        $data = $this->callV2JsonFirstItem('GET', 'coupons');

        $this->assertArrayHasKey('promo_type', $data);
        $this->assertArrayHasKey('from_date', $data);

        $coupon->delete();
	}
}
