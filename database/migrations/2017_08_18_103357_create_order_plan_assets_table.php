<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPlanAssetsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_plan_assets', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
			$table->timestamps();
		});
		
		Schema::create('order_plan_asset_relations', function(Blueprint $table) {
			$table->integer('order_plan_id')->unsigned();
			$table->integer('order_plan_asset_id')->unsigned();
			
			$table->foreign('order_plan_id')->references('id')->on('order_plans');
			$table->foreign('order_plan_asset_id')->references('id')->on('order_plan_assets');
			
			$table->index(['order_plan_id', 'order_plan_asset_id'], 'opar_index');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_plan_assets');
		Schema::drop('order_plan_asset_relations');
	}

}
