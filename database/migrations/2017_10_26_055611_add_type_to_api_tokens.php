<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToApiTokens extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('api_tokens', function(Blueprint $table) {
			$table->integer('api_apps_id')->unsigned()->nullable();
			$table->string('type')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('api_tokens', function(Blueprint $table) {
			$table->dropColumn('api_apps_id');
			$table->dropColumn('type');
		});
		
	}

}
