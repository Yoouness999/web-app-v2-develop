<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameToFees extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fees', function ($table) {
			$table->string('name')->after('id');
			//$table->string('billing_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fees', function ($table) {
			$table->dropColumn('name');
			//$table->dropColumn('billing_type');
		});
	}

}
