<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSepainfosToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('invoices', function(Blueprint $table)
        {
            $table->dropColumn('billing_method');
            $table->dropColumn('billing_iban');
        });//

        Schema::table('users', function(Blueprint $table)
        {
            $table->string('billing_iban')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function(Blueprint $table)
        {
            $table->string('billing_method')->nullable();
            $table->string('billing_iban')->nullable();
        });

        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('billing_iban');
        });
	}

}
