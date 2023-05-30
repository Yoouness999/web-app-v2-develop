<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoices', function(Blueprint $table){
		   $table->softDeletes();
        });

        Schema::table('order_bookings', function(Blueprint $table){
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('invoices', function(Blueprint $table){
            $table->dropSoftDeletes();
        });

        Schema::table('order_bookings', function(Blueprint $table){
            $table->dropSoftDeletes();
        });
	}

}
