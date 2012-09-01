<?php

class Create_Messages {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function($table) {
                
                   $table->increments('id');
                   $table->integer('group_id')->index()->null();
                   $table->integer('sender_id')->index();
                   $table->integer('recipient_id')->index();
                   $table->string('subject', 128);
                   $table->text('body');
                   $table->integer('message_type');
                   $table->string('flag', 32)->null();
                   $table->boolean('read');
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
		Schema::drop('messages');
	}

}