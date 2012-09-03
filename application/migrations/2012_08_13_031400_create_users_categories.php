<?php

class Create_Users_Categories {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('user_category', function($table) {
                    
                    $table->integer('user_id')->index();
                    $table->integer('category_id')->index();
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
		Schema::drop('user_category');
	}

}