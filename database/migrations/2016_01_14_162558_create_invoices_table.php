<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->text('content')->nullable();
			$table->string('price')->nullable();
			$table->string('user_id')->nullable();
			$table->string('item_id')->nullable();
			$table->string('pickup_id')->nullable();
			$table->string('fee_id')->nullable();
			$table->string('status')->nullable();
			$table->string('payment_date')->nullable();
			$table->string('payment_schedule')->nullable();
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
		Schema::drop('invoices');
	}

}
