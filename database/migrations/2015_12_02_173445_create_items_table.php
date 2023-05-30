<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
				->references('id')->on('users')->onDelete('cascade');
			$table->integer('pickup_id')->unsigned();
			$table->string('ref')->nullable();
			$table->string('type')->nullable();
			$table->string('status')->nullable();
			$table->string('name')->nullable();
			$table->string('description')->nullable();
			$table->string('bulk_item')->nullable();
			$table->string('picture_option')->nullable();
			$table->string('street')->nullable();
			$table->string('number')->nullable();
			$table->string('box')->nullable();
			$table->string('postalcode')->nullable();
			$table->string('city')->nullable();
			$table->string('longitude')->nullable();
			$table->string('latitude')->nullable();
			$table->string('add_infos')->nullable();
			$table->string('pickup_date')->nullable();
			$table->string('ending_date')->nullable();
			$table->string('billing_date')->nullable();
			$table->string('billing_status')->nullable();
			$table->string('billing_ref')->nullable();
			$table->string('box_id')->nullable();
			$table->string('storage_country')->nullable();
			$table->string('storage_warehouse')->nullable();
			$table->string('storage_floor')->nullable();
			$table->string('storage_row')->nullable();
			$table->string('storage_rack')->nullable();
			$table->string('storage_rack_floor')->nullable();
			$table->string('storage_pallet')->nullable();
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
		Schema::drop('items');
	}

}
