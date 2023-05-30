<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageFieldOnPalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pallet', function (Blueprint $table) {
            $table->integer('zone_id')->unsigned()->nullable()->index();
            $table->foreign('zone_id')->references('id')->on('zone')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pallet', function (Blueprint $table) {
            $table->dropColumn('zone_id');
        });
    }
}
