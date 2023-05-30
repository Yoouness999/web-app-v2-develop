<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('proformas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->text('content')->nullable();
            $table->string('price')->nullable();
            $table->string('user_id')->nullable();
            $table->string('item_id')->nullable();
            $table->string('pickup_id')->nullable();
            $table->string('fee_id')->nullable();
            $table->string('status')->nullable();
            $table->integer('attempt')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('payment_schedule')->nullable();
            $table->string('billing_ref')->nullable();
            $table->string('billing_type')->nullable();
            $table->string('billing_id')->nullable();
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
        Schema::drop('proformas');
	}

}
