<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPickupOptionToPickupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pickups', function(Blueprint $table)
		{
			$table->string('billing_deposit', 10, 2)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pickups', function(Blueprint $table)
		{
			$table->dropColumn('billing_deposit');
		});
	}

}
