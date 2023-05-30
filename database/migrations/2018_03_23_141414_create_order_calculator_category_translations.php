<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderCalculatorCategoryTranslations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('order_calculator_category_translations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_calculator_category_id')->unsigned();
			$table->string('name');
			$table->string('locale')->index();
			$table->unique(['order_calculator_category_id', 'locale'], 'ord_cal_cat_tra_ord_cal_cat_id_loc_uni');
		});

		Schema::table('order_calculator_categories', function(Blueprint $table) {
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('order_calculator_category_translations');

		Schema::table('order_calculator_categories', function(Blueprint $table) {
			$table->dropSoftDeletes();
		});
	}
}
