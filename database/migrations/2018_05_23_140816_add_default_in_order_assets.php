<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultInOrderAssets extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('order_plan_assets', function(Blueprint $table)
        {
            $table->boolean('default')->nullable();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('order_plan_assets', function(Blueprint $table)
        {
            $table->dropColumn('default');
        });
	}
}
