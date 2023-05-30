<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixErrorVolumeM3InPickups extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if (!Schema::hasColumn('pickups', 'volume_m3')) {
            Schema::table('pickups', function(Blueprint $table)
            {
                $table->double('volume_m3', 10, 2);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('pickups', 'volume_m3')) {
            Schema::table('pickups', function(Blueprint $table)
            {
                $table->dropColumn('volume_m3');
            });
        }
	}

}
