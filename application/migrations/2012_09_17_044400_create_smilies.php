<?php

class Create_Smilies {

	public function up()
	{
		Schema::create('smilies', function ($table) {

			$table->increments('id');
			$table->integer('author_id');
			$table->string('trigger', 24);
			$table->string('replacement', 128);
			$table->boolean('active')->default(true);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('smilies');
	}

}