<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPlansTranslations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('order_plan_translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('order_plan_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();
            $table->unique(['order_plan_id','locale']);
        });

        Schema::table('order_plans', function(Blueprint $table)
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
        Schema::dropIfExists('order_plan_translations');

        Schema::table('order_plans', function(Blueprint $table)
        {
            $table->dropSoftDeletes();
        });
	}
}
