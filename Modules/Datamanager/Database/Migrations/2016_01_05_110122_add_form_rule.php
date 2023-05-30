<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormRule extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_rules', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('form_id');
            $table->string('association');
            $table->string('expression1');
            $table->string('operand');
            $table->string('expression2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('form_rules', function(Blueprint $table)
        {
            $table->drop();
        });
    }

}
