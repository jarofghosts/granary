<?php

class Create_Categories {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function($table) {
                    $table->increments('id');
                    $table->integer('parent_id')->default(0);
                    $table->integer('creator_id')->index();
                    $table->string('title', 128);
                    $table->string('handle', 32);
                    $table->string('logo', 128);
                    $table->text('description');
                    $table->boolean('active')->default(1);
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
        Schema::drop('categories');

    }

}