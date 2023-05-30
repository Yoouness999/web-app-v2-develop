<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPlanRegionTable extends Migration
{

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
        Schema::dropIfExists('regions_translations');
        Schema::dropIfExists('areas_translations');
        Schema::dropIfExists('order_plans_regions');

        Schema::table('areas', function (Blueprint $table) {
            $table->dropColumn('region_id');
        });
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('region_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('region_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();
        });

        Schema::table('areas', function (Blueprint $table) {
            $table->unsignedInteger('region_id');
        });

        Schema::create('areas_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('area_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['area_id', 'locale']);
        });

        Schema::create('order_plan_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_plan_id');
            $table->unsignedInteger('region_id');
            $table->double('price_per_month');
            $table->timestamps();
        });
    }

}
