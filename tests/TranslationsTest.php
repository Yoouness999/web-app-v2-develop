<?php

/**
 * TranslationsTest
 *
 * $ php vendor/phpunit/phpunit/phpunit tests/TranslationsTest
 */

use App\Api\ApiApp;

class TranslationsTest extends TestCase {
    public function testOrderPlan(){
		$app = ApiApp::find(1);
		
        $response = $this->call('get', '/api/v2/order/plans', [
			'app_id' => $app->app_id,
			'app_secret' => $app->app_secret,
			'first' => true
		]);
		
		$data = json_decode($response->getContent(), true);
		
		$this->assertResponseOk();
		$this->assertEquals(isset($data['data']['name']), true);
		$this->assertEquals(!empty($data['data']['name']), true);
    }
	
	public function testOrderPlanAsset(){
		$app = ApiApp::find(1);
		
        $response = $this->call('get', '/api/v2/order/plans/assets', [
			'app_id' => $app->app_id,
			'app_secret' => $app->app_secret,
			'first' => true
		]);
		
		$data = json_decode($response->getContent(), true);
		
		$this->assertResponseOk();
		$this->assertEquals(isset($data['data']['name']), true);
		$this->assertEquals(!empty($data['data']['name']), true);
    }
	
	public function testOrderCalculatorItem(){
		$app = ApiApp::find(1);
		
        $response = $this->call('get', '/api/v2/order/calculator/items', [
			'app_id' => $app->app_id,
			'app_secret' => $app->app_secret,
			'first' => true
		]);
		
		$data = json_decode($response->getContent(), true);
		
		$this->assertResponseOk();
		$this->assertEquals(isset($data['data']['name']), true);
		$this->assertEquals(!empty($data['data']['name']), true);
    }
	
	public function testOrderCalculatorCategory(){
		$app = ApiApp::find(1);
		
        $response = $this->call('get', '/api/v2/order/calculator/categories', [
			'app_id' => $app->app_id,
			'app_secret' => $app->app_secret,
			'first' => true
		]);
		
		$data = json_decode($response->getContent(), true);
		
		$this->assertResponseOk();
		$this->assertEquals(isset($data['data']['name']), true);
		$this->assertEquals(!empty($data['data']['name']), true);
    }
	
	public function testOrderAssurance(){
		$app = ApiApp::find(1);
		
        $response = $this->call('get', '/api/v2/order/assurances', [
			'app_id' => $app->app_id,
			'app_secret' => $app->app_secret,
			'first' => true
		]);
		
		$data = json_decode($response->getContent(), true);
		
		$this->assertResponseOk();
		$this->assertEquals(isset($data['data']['name']), true);
		$this->assertEquals(!empty($data['data']['name']), true);
    }
}