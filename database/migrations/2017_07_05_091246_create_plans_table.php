<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_plan_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
			$table->timestamps();
		});
		
		Schema::create('order_plans', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_plan_category_id')->unsigned();
			$table->string('slug')->unique();
			$table->double('volume_m3', 10, 2);
			$table->double('price_per_month', 10, 2);
			$table->timestamps();
			
			$table->foreign('order_plan_category_id')->references('id')->on('order_plan_categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_plan_categories');
		Schema::drop('order_plans');
	}

}
