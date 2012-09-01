<?php

class Create_Users_Ips {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_ips', function($table) {
                    
                    $table->increments('id');
                    $table->integer('user_id')->index();
                    $table->string('ip',32)->index();
                    $table->boolean('confirmed')->default(0);
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
		Schema::drop('users_ips');
	}

}