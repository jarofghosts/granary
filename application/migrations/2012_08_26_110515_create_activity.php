<?php

class Create_Activity {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_activity', function($table) {
                    
                    $table->increments('id');
                    $table->integer('user_id')->index();
                    $table->string('ip',32)->index();
                    $table->timestamp('last_activity');
                    
                });
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_activity');
	}

}