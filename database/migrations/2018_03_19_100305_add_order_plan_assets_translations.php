<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderPlanAssetsTranslations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('order_plan_asset_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('order_plan_asset_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['order_plan_asset_id', 'locale']);
            //$table->foreign('order_plan_id')->references('id')->on('order_plans')->onDelete('cascade');
        });

        Schema::table('order_plan_assets', function(Blueprint $table)
        {
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
        Schema::dropIfExists('order_plan_assets_translations');

        Schema::table('order_plan_assets', function(Blueprint $table)
        {
            $table->dropSoftDeletes();
        });
	}

}
