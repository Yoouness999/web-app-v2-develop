<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLemonwayCardInfoUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('billing_card_holder')->after('business');
            $table->string('billing_card_number')->after('business');
            $table->string('billing_card_month')->after('business');
            $table->string('billing_card_year')->after('business');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('billing_card_holder');
            $table->dropColumn('billing_card_number');
            $table->dropColumn('billing_card_month');
            $table->dropColumn('billing_card_year');
        });
    }

}
