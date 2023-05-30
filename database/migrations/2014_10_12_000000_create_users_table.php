<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('name');
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('postalcode')->nullable();
			$table->string('address')->nullable();
			$table->string('latitude')->nullable();
			$table->string('longitude')->nullable();
			$table->string('phone')->nullable();
			$table->string('billing_info_type')->nullable();
			$table->string('billing_status')->nullable();
			$table->string('billing_type')->nullable();
			$table->string('billing_env')->nullable();
			$table->string('billing_id')->nullable();
			$table->string('billing_customer_id')->nullable();
			$table->string('billing_next_date')->nullable();
			$table->string('password', 60);
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
