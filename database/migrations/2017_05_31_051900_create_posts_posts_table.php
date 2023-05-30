<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsPostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts_posts', function(Blueprint $table)
		{
			$table->integer('from_post_id');
			$table->integer('to_post_id');
			
			$table->timestamps();
			
			$table->index(['from_post_id', 'to_post_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('posts_posts');
	}

}
