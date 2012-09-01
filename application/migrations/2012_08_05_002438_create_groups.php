<?php

class Create_Groups {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function($table) {
                    $table->increments('id');
                    $table->integer('creator_id')->index();
                    $table->integer('parent_id')->default(0)->index();
                    $table->string('title', 128);
                    $table->text('description');
                    $table->string('logo', 128);
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
        Schema::drop('groups');

    }

}