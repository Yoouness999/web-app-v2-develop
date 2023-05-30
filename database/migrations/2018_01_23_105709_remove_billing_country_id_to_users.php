<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveBillingCountryIdToUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('billing_country_id');
            $table->renameColumn('company_address_country', 'company_address_country_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->integer('billing_country_id')->after('billing_address')->nullable();
            $table->renameColumn('company_address_country_id', 'company_address_country');
        });
    }

}
