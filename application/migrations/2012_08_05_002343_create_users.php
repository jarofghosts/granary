<?php

class Create_Users {

    /**
     * Make changes to the database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function( $table ) {
                    $table->increments('id');
                    $table->string('username', 24);
                    $table->string('password', 64);
                    $table->string('real_name', 64);
                    $table->string('email', 128);
                    $table->string('color', 32)->default('#FFFFFF');
                    $table->string('avatar', 128);
                    $table->text('about_me');
                    $table->integer('experience')->default(0);
                    $table->integer('access_level')->default(0);
                    $table->boolean('active')->default(1);
                    $table->timestamps();
                });

        DB::table('users')->insert(array(
            'username' => 'Wadsworth',
            'password' => Hash::make('admin'),
            'real_name' => 'Wadsworth',
            'email' => 'me@jessekeane.me',
            'color' => '#FF3954',
            'display_name' => 'Wadsworth',
            'avatar' => '/sailor/img/wadsworth.jpg',
            'about_me' => 'I buttle.',
            'experience' => 0,
            'access_level' => 10,
            'active' => true
        ));

    }

    /**
     * Revert the changes to the database.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');

    }

}