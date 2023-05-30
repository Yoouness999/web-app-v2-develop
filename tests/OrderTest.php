<?php

/**
 * OrderTest
 *
 * $ php vendor/phpunit/phpunit/phpunit tests/OrderTest
 */

use App\Order;

class OrderTest extends TestCase {
    public function testCalculator(){
		Session::start();
		
		$this->session([
			'order' => new Order()
		]);
		
        $response = $this->call('post', '/order/calculator', [
			'_token' => csrf_token(),
			'items' => []
		]);
		
		$this->assertSessionHas('order');
		$this->assertResponseStatus(302);
		$this->assertRedirectedTo('order/services');
    }
}