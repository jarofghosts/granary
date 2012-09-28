<?php

class Create_Posts {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function($table) {
                    $table->increments('id');
                    $table->integer('author_id')->index();
                    $table->integer('category_id')->index();
                    $table->string('title', 128);
                    $table->text('body');
                    $table->text('body_source');
                    $table->boolean('active')->default(1);
                    $table->timestamp('default_order');
                    $table->string('slug', 64);
                    $table->string('full_path', 256);
                    $table->integer('score');
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
        Schema::drop('posts');

    }

}