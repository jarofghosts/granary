<?php

class Create_Votes {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function($table) {
			$table->increments('id');
			$table->integer('caster_id')->index();
			$table->integer('post_id')->index();
			$table->integer('good')->default(0);
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
		Schema::drop('votes');
	}

}