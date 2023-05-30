<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalPriceToInvoiceFieldOnOrderBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_bookings', function (Blueprint $table) {
            $table->float('total_price_to_invoice')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_bookings', function (Blueprint $table) {
            $table->dropColumn('total_price_to_invoice');
        });
    }
}
