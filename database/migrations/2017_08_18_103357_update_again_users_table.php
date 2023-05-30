<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAgainUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->text('country')->nullable();
			$table->string('customer_type')->default('private');
			$table->string('id_card_file_recto')->nullable();
			$table->string('id_card_file_verso')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->dropColumn('country');
			$table->dropColumn('customer_type');
			$table->dropColumn('id_card_file_recto');
			$table->dropColumn('id_card_file_verso');
		});
	}

}
