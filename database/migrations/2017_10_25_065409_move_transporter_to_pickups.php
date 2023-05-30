<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveTransporterToPickups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('order_bookings', function(Blueprint $table) {
			$table->dropColumn('assigned_deliveryman_arxmin_user_id');
		});
		
		Schema::table('pickups', function(Blueprint $table) {
			$table->integer('assigned_deliveryman_arxmin_user_id')->unsigned()->nullable();
			$table->foreign('assigned_deliveryman_arxmin_user_id')->references('id')->on('arxmin_users');
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
			$table->dropColumn('assigned_deliveryman_arxmin_user_id');
		});
		
		Schema::table('order_bookings', function(Blueprint $table) {
			$table->integer('assigned_deliveryman_arxmin_user_id')->unsigned()->nullable();
			$table->foreign('assigned_deliveryman_arxmin_user_id')->references('id')->on('arxmin_users');
		});
	}

}
