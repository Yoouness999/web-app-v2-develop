<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRev20CompaniesInfosToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function(Blueprint $table) {
            $table->string('address_country')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_vat_number')->nullable();
            $table->string('company_address_route')->nullable();
            $table->string('company_address_street_number')->nullable();
            $table->string('company_address_locality')->nullable();
            $table->string('company_address_postal_code')->nullable();
            $table->string('compagny_address_country')->nullable();
            $table->string('company_address_box')->nullable();
            $table->integer('order_plan_id')->unsigned()->nullable();
            $table->integer('order_assurance_id')->unsigned()->nullable();
            $table->integer('order_storing_duration_id')->unsigned()->nullable();
            $table->timestamp('end_commitment_period')->nullable();
            $table->string('photo')->nullable();
            $table->boolean('is_billable')->nullable();
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
            $table->dropColumn('address_country');
            $table->dropColumn('company_name')->nullable();
            $table->dropColumn('company_vat_number')->nullable();
            $table->dropColumn('company_address_route')->nullable();
            $table->dropColumn('company_address_street_number')->nullable();
            $table->dropColumn('company_address_locality')->nullable();
            $table->dropColumn('company_address_postal_code')->nullable();
            $table->dropColumn('compagny_address_country')->nullable();
            $table->dropColumn('company_address_box')->nullable();
            $table->dropColumn('order_plan_id')->unsigned()->nullable();
            $table->dropColumn('order_assurance_id')->unsigned()->nullable();
            $table->dropColumn('order_storing_duration_id')->unsigned()->nullable();
            $table->dropColumn('end_commitment_period')->nullable();
            $table->dropColumn('photo')->nullable();
            $table->dropColumn('is_billable')->nullable();
        });
    }

}
