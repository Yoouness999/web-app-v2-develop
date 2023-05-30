<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAssurancesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_assurances', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
			$table->double('price_per_month', 10, 2);
			$table->boolean('on_demand');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_assurances');
	}

}
