<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixOrderPlanTranslationsIssues extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    if(!Schema::hasTable('order_plan_translations')){
            Schema::create('order_plan_translations', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('order_plan_id')->unsigned();
                $table->string('name');
                $table->string('locale')->index();
                $table->unique(['order_plan_id','locale']);
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
