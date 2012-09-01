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
                    $table->integer('replies_per_page')->default(0);
                    $table->integer('reply_depth')->default(3);
                    $table->integer('account_type')->default(1);
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