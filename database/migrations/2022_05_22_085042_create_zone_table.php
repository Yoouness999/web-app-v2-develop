<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone', function (Blueprint $table) {
            $table->increments('id');
            $table->string('qrcode', 25)->unique()->nullable(false);
            $table->string('warehouse', 50)->nullable(false);
            $table->string('line', 50)->nullable(true);
            $table->string('rack', 50)->nullable(true);
            $table->string('space', 50)->nullable(true);
            $table->string('level', 50)->nullable(true);
            $table->integer('warehouse_id')->unsigned()->nullable()->index();
            $table->foreign('warehouse_id')->references('id')->on('warehouses')->onDelete('cascade');
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
        Schema::dropIfExists('zone');
    }
}
