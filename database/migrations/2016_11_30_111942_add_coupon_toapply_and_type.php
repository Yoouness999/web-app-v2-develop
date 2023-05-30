<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponToapplyAndType extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('coupons', function(Blueprint $table)
        {
            $table->boolean('touse')->after('user_id')->nullable();
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
            $table->boolean('toapply')->after('promo_applied')->nullable();
        });
	}

}
