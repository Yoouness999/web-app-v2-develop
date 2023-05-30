<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersBillingInfos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function (Blueprint $table) {
			$table->string('billing_address')->nullable()->after('billing_next_date');
			$table->string('billing_to')->nullable()->after('billing_next_date');
			$table->string('billing_street')->nullable()->after('billing_next_date');
			$table->string('billing_number')->nullable()->after('billing_next_date');
			$table->string('billing_box')->nullable()->after('billing_next_date');
			$table->string('billing_postalcode')->nullable()->after('billing_next_date');
			$table->string('billing_city')->nullable()->after('billing_next_date');
			$table->dropColumn('address');
			$table->string('street')->nullable()->after('postalcode');
			$table->string('number')->nullable()->after('postalcode');
			$table->string('box')->nullable()->after('postalcode');
			$table->string('city')->nullable()->after('postalcode');
			$table->string('add_infos')->nullable()->after('postalcode');
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
			$table->dropColumn('storage_date');
		});
	}

}
