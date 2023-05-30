<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMonthInStoringDurations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('order_storing_durations', function(Blueprint $table) {
            if(!Schema::hasColumn('order_storing_durations', 'month')){
                $table->integer('month');
            }
        });

        Artisan::call('db:seed', [
            '--class' => OrderStoringDurationsSeeder::class,
        ]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('order_storing_durations', function(Blueprint $table) {
            $table->dropColumn('month');
        });
	}
}
