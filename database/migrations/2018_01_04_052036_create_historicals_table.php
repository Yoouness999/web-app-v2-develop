<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historicals', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('historical_category_id')->unsigned()->nullable();
			$table->string('title')->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
		});
		
		Schema::create('historical_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
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
		Schema::drop('historicals');
		Schema::drop('historical_categories');
	}

}
