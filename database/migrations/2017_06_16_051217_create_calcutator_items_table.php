<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalcutatorItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_calculator_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
			$table->timestamps();
		});
		
		Schema::create('order_calculator_items', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_calculator_category_id')->unsigned();
			$table->string('slug')->unique();
			$table->double('area_m2', 10, 2);
			$table->double('volume_m3', 10, 2);
			$table->timestamps();
			
			$table->foreign('order_calculator_category_id')->references('id')->on('order_calculator_categories');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_calculator_categories');
		Schema::drop('order_calculator_items');
	}

}
