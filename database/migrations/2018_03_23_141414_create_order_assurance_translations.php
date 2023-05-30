<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderAssuranceTranslations extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('order_assurance_translations', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('order_assurance_id')->unsigned();
			$table->string('name');
			$table->string('locale')->index();
			$table->unique(['order_assurance_id', 'locale'], 'ord_ass_tra_ord_ass_id_loc_uni');
		});

		Schema::table('order_assurances', function(Blueprint $table) {
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('order_assurance_translations');

		Schema::table('order_assurances', function(Blueprint $table) {
			$table->dropSoftDeletes();
		});
	}
}
