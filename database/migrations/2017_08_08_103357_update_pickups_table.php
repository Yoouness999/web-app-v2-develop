<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePickupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('pickups', function (Blueprint $table) {
			$table->text('sign_photo')->nullable();
			$table->text('intern_note')->nullable();
			$table->timestamp('dropoff_date_from')->nullable();
			$table->text('dropoff_intern_note')->nullable();
			$table->timestamp('dropoff_date_to')->nullable();
			$table->timestamp('pickup_date_to')->nullable();
			$table->integer('order_booking_id')->unsigned()->nullable();
			
			$table->foreign('order_booking_id')->references('id')->on('order_bookings');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('pickups', function (Blueprint $table) {
			$table->dropColumn('sign_photo');
			$table->dropColumn('intern_note');
			$table->dropColumn('dropoff_date_from');
			$table->dropColumn('dropoff_intern_note');
			$table->dropColumn('dropoff_date_to');
			$table->dropColumn('pickup_date_to');
			$table->dropColumn('order_booking_id');
		});
	}

}
