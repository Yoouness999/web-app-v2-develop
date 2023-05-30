<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPickupHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('pickuphistory', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->integer('old_pickup_id');
            $table->integer('new_pickup_id');
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
        Schema::drop('fees');
	}

}
