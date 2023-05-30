<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIconColorToHistoricalCategories extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('historical_categories', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historical_categories', function (Blueprint $table) {
            $table->dropColumn('icon');
            $table->dropColumn('color');
            $table->dropColumn('name');
        });
    }

}
