<?php

class Create_Preferences {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferences', function($table) {
                    $table->integer('id')->primary();
                    $table->integer('front_page_posts')->default(15);
                    $table->integer('rating_threshold')->default(0);
                    $table->integer('responses_per_page')->default(0);
                    $table->boolean('bot_messages')->default(1);
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
        Schema::drop('preferences');

    }

}