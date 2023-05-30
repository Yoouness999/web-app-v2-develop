<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingItemStatusHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_item_status_history', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('booking_id')->unsigned()->nullable(false);
            $table->integer('item_id')->unsigned()->nullable(false);
            $table->integer('arxmin_user_id')->unsigned()->nullable(false);
            $table->string('status')->nullable(false);
            $table->foreign('arxmin_user_id')->references('id')->on('arxmin_users')->onDelete('cascade');
            $table->foreign('booking_id')->references('id')->on('pickups')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_item_status_history');
    }
}
