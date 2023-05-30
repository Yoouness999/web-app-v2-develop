<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFees extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('fees', function (Blueprint $table) {
			$table->string('item_id');
			$table->string('type')->nullable();
			$table->string('ref')->nullable();
			$table->string('price')->nullable();
			$table->string('nb')->nullable();
			$table->string('status')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('fees', function (Blueprint $table) {
			$table->dropColumn('item_id');
			$table->dropColumn('type');
			$table->dropColumn('ref');
			$table->dropColumn('price');
			$table->dropColumn('nb');
			$table->dropColumn('status');
		});
	}

}