<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPickupOption extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('items', function (Blueprint $table) {
			$table->dropColumn('direct_pickup')->nullable()->after('pickup_date');
			$table->string('pickup_option')->nullable()->after('pickup_date');
			$table->string('price')->nullable()->after('description');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('items', function (Blueprint $table) {
			$table->dropColumn('direct_pickup');
		});
	}

}
