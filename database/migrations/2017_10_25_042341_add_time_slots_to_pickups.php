<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimeSlotsToPickups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pickups', function(Blueprint $table) {
			$table->dropColumn('dropoff_date');
			$table->dropColumn('dropoff_time');
			$table->dropColumn('pickup_time');
			$table->timestamp('dropoff_date_from')->nullable();
			$table->timestamp('dropoff_date_to')->nullable();
			$table->timestamp('pickup_date_to')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pickups', function(Blueprint $table) {
			$table->timestamp('dropoff_date')->nullable();
			$table->string('dropoff_time')->nullable();
			$table->string('pickup_time')->nullable();
			$table->dropColumn('dropoff_date_from');
			$table->dropColumn('dropoff_date_to');
			$table->dropColumn('pickup_date_to');
		});
	}

}
