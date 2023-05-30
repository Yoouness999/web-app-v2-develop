<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePickupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pickups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->text('items')->nullable();
			$table->string('total')->nullable();
			$table->text('street')->nullable();
			$table->string('number')->nullable();
			$table->string('box')->nullable();
			$table->string('postalcode')->nullable();
			$table->string('city')->nullable();
			$table->string('status')->nullable();
			$table->text('add_infos')->nullable();
			$table->text('history')->nullable();
			$table->timestamp('pickup_date')->nullable();
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
		Schema::drop('pickups');
	}

}
