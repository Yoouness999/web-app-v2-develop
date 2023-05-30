<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveUserRelatedInfosInCoupons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('coupons', function(Blueprint $table)
        {
            $table->dropColumn('user_id');
            $table->dropColumn('used');
            $table->dropColumn('touse');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('coupons', function(Blueprint $table)
        {
            $table->string('user_id')->nullable();
            $table->boolean('used')->nullable();
            $table->boolean('touse')->nullable();
        });
	}

}
