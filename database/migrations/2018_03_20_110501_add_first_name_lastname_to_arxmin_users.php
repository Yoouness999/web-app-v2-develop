<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFirstNameLastnameToArxminUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('arxmin_users', function(Blueprint $table)
        {
            $table->string('last_name')->nullable();
            $table->string('first_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('arxmin_users', function(Blueprint $table)
        {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
        });
	}

}
