<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToPickups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('pickups', function(Blueprint $table)
        {
            $table->string('country')->nullable();
            $table->string('fragile')->nullable();
            $table->string('floor')->nullable();
            $table->string('transporter_number')->nullable();
            $table->string('parking')->nullable();
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
            $table->dropColumn('country');
            $table->dropColumn('fragile');
            $table->dropColumn('floor');
            $table->dropColumn('transporter_number');
            $table->dropColumn('parking');
        });
	}

}
