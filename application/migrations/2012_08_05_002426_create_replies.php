<?php

class Create_Replies {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('replies', function($table) {
                    $table->increments('id');
                    $table->integer('author_id')->index();
                    $table->integer('parent_id')->index();
                    $table->integer('grandparent_id')->index();
                    $table->text('body');
                    $table->string('slug', 64);
                    $table->boolean('active')->default(1);
                    $table->integer('up_votes');
                    $table->integer('down_votes');
                    $table->integer('score');
                    $table->timestamps();
                });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('replies');
	}

}