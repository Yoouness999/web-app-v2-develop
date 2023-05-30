<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArxminUserPermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('arxmin_permissions', function(Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->timestamps();
        });

        Schema::create('arxmin_user_permissions', function(Blueprint $table) {
            $table->integer('arxmin_user_id')->unsigned();
            $table->integer('arxmin_permission_id')->unsigned();
            $table->unique(['arxmin_user_id', 'arxmin_permission_id'], 'user_permisssion');
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
        Schema::drop('arxmin_permissions');
        Schema::drop('arxmin_user_permissions');
    }

}
