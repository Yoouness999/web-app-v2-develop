<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('logs', function (Blueprint $table) {
			$table->string('category')->nullable();
			$table->string('type')->nullable();
			$table->string('file_attachment')->nullable();
			$table->timestamp('due_date')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('logs', function (Blueprint $table) {
			$table->dropColumn('category');
			$table->dropColumn('type');
			$table->dropColumn('file_attachment');
			$table->dropColumn('due_date');
		});
	}

}
