<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_booking_statuses', function(Blueprint $table) {
			$table->increments('id');
			$table->string('slug')->unique();
			$table->timestamps();
		});
		
		Schema::create('order_bookings', function(Blueprint $table) {
			$table->increments('id');
			
			$table->double('price_per_month', 10, 2)->default(0);
			$table->double('appointment', 10, 2)->default(0);
			$table->timestamp('dropoff_date_from')->nullable();
			$table->timestamp('dropoff_date_to')->nullable();
			$table->timestamp('pickup_date_from')->nullable();
			$table->timestamp('pickup_date_to')->nullable();
			$table->string('address_full')->nullable();
			$table->string('address_route')->nullable();
			$table->string('address_street_number')->nullable();
			$table->string('address_locality')->nullable();
			$table->string('address_postal_code')->nullable();
			$table->string('address_country')->nullable();
			$table->string('address_box')->nullable();
			$table->boolean('wait_fill_boxes')->default(false);
			$table->string('company_name')->nullable();
			$table->string('company_vat_number')->nullable();
			$table->string('company_address_full')->nullable();
			$table->string('company_address_route')->nullable();
			$table->string('company_address_street_number')->nullable();
			$table->string('company_address_locality')->nullable();
			$table->string('company_address_postal_code')->nullable();
			$table->string('company_address_country')->nullable();
			$table->string('company_address_box')->nullable();
			$table->text('how_did_your_hear_about_us')->nullable();
			$table->text('comments')->nullable();
			$table->integer('user_id')->unsigned();
			$table->integer('order_plan_id')->unsigned();
			$table->integer('order_storing_duration_id')->unsigned()->nullable();
			$table->integer('order_assurance_id')->unsigned()->nullable();
			$table->integer('order_booking_status_id')->unsigned();
			$table->integer('assigned_deliveryman_arxmin_user_id')->unsigned()->nullable();
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('order_plan_id')->references('id')->on('order_plans');
			$table->foreign('order_storing_duration_id')->references('id')->on('order_storing_durations');
			$table->foreign('order_assurance_id')->references('id')->on('order_assurances');
			$table->foreign('order_booking_status_id')->references('id')->on('order_booking_statuses');
			$table->foreign('assigned_deliveryman_arxmin_user_id')->references('id')->on('arxmin_users');
		});
		
		Schema::create('order_booking_calculator_items', function(Blueprint $table) {
			$table->integer('order_booking_id')->unsigned();
			$table->integer('order_calculator_item_id')->unsigned();
			
			$table->foreign('order_booking_id')->references('id')->on('order_bookings');
			$table->foreign('order_calculator_item_id')->references('id')->on('order_calculator_items');
			
			$table->index(['order_booking_id', 'order_calculator_item_id'], 'obci_index');
		});
		
		Schema::create('order_booking_answers', function(Blueprint $table) {
			$table->integer('order_booking_id')->unsigned();
			$table->integer('order_answer_id')->unsigned();
			
			$table->foreign('order_booking_id')->references('id')->on('order_bookings');
			$table->foreign('order_answer_id')->references('id')->on('order_answers');
			
			$table->index(['order_booking_id', 'order_answer_id'], 'oba_index');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('order_booking_statuses');
		Schema::drop('order_bookings');
		Schema::drop('order_booking_calculator_items');
		Schema::drop('order_booking_answers');
	}

}
