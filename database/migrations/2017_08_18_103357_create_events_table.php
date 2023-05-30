<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title')->nullable();
			$table->string('location')->nullable();
			$table->timestamp('date')->nullable();
			$table->text('notes')->default('');
			$table->timestamps();
		});
		
		Schema::create('events_guests', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('event_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->string('user_type')->nullable();
			$table->boolean('accept')->default(false);
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
		Schema::drop('events');
		Schema::drop('events_guests');
	}

}
