<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCouponsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('code')->nullable();
            $table->string('user_id')->nullable();
            $table->boolean('used')->nullable();
            $table->string('promo_applied')->nullable();
            $table->string('promo_type')->default('redeem');
            $table->dateTime('expiry_date')->nullable();
            $table->integer('quantity')->default(-1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupons');
    }

}
