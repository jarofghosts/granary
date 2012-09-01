<?php

class Create_Ignores {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ignores', function ($table) {
                    $table->increments('id');
                    $table->integer('user_id')->index();
                    $table->integer('jerk_id')->index();
                    $table->string('note', 128);
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

        Schema::drop('user_ignores');

    }

}