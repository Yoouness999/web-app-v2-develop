<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('api_tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->string('token')->unique();
			$table->integer('user_id')->unsigned()->nullable();
			$table->integer('arxmin_user_id')->unsigned()->nullable();
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('arxmin_user_id')->references('id')->on('arxmin_users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('api_tokens');
	}

}
