<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$this->call('TestUserSeeder');
		$this->call('OrderPlanNameSeeder');
		$this->call('OrderPlanAssetNameSeeder');
		$this->call('OrderAssuranceNameSeeder');
		$this->call('OrderCalculatorItemNameSeeder');
		$this->call('OrderCalculatorCategoryNameSeeder');
	}

}
