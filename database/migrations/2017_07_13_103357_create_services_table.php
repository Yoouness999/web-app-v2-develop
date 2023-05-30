<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_questions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
			$table->string('type');
			$table->timestamps();
		});
		
		Schema::create('order_answers', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_question_parent_id')->unsigned();
			$table->integer('order_question_target_id')->unsigned()->nullable();
			$table->string('slug')->unique();
			$table->boolean('value_boolean');
			$table->integer('value_number_from')->unsigned();
			$table->integer('value_number_to')->unsigned();
			$table->double('appointment', 10, 2);
			$table->double('appointment_by_number', 10, 2);
			$table->timestamps();
			
			$table->foreign('order_question_parent_id')->references('id')->on('order_questions');
			$table->foreign('order_question_target_id')->references('id')->on('order_questions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_questions');
		Schema::drop('order_answers');
	}

}
