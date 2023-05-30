<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDataTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forms', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('title')->index('title')->nullable();
            $table->text('description')->nullable();
            $table->text('meta')->nullable();
            $table->string('uri')->index('uri');
            $table->string('lang')->nullable()->index('lang');
            $table->string('type')->index('type');
            $table->string('manage')->index('manage');
            $table->string('status')->nullable()->index('status');
            $table->text('context')->nullable();
            $table->text('logs')->nullable();
            $table->timestamps();
        });

        Schema::create('posts', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('slug')->index('slug');
            $table->string('title')->index('title')->nullable();
            $table->text('content')->nullable();
            $table->text('meta')->nullable();
            $table->string('meta_type')->nullable();
            $table->string('ref')->nullable()->index('ref');
            $table->string('lang')->nullable()->index('lang');
            $table->string('type');
            $table->string('version')->nullable();
            $table->string('level')->nullable();
            $table->string('position')->nullable();
            $table->text('categories')->nullable();
            $table->string('status')->nullable();
            $table->text('tags')->nullable();
            $table->string('thumb')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();
            $table->text('context')->nullable();
            $table->text('logs')->nullable();
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
        Schema::dropIfExists('forms');
        Schema::dropIfExists('posts');
    }

}
