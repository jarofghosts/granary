<?php

class Create_Users_Groups {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_user', function($table) {
                    $table->increments('id');
                    $table->integer('user_id')->index();
                    $table->integer('group_id')->index();
                    
                });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_user');
	}

}