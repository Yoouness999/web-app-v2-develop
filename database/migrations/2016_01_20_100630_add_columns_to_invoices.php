<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToInvoices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoices', function ($table) {
			$table->string('billing_ref')->nullable();
			$table->string('billing_type')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoices', function ($table) {
			$table->dropColumn('billing_ref');
			$table->dropColumn('billing_type');
		});
	}

}
