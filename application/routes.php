<?php

Route::get('/', function() {
            return View::make('common.index');
        });

// >>>>>>>>>>>>>>>>>> CRUD routes
// for the most part the controllers are restful, but for some reason these need special declarations.
// a lot of these will probably go the way of the buffalo when I get down to brass tacks.


Route::delete('posts/(:num)', 'posts@remove');
Route::get('posts/(:num)', 'posts@view');

Route::post('reply/new', 'replies@new');
Route::get('posts/(:num)/reply/new', 'replies@new');

Route::get('users', 'users@index');

Route::get('users/(:num)', 'users@index');
Route::get('users/new', function() {
            return View::make('users.register');
        });
Route::post('users/new', 'users@post_register');
Route::get('users/edit/(:num)/avatar', function($id) {
            return View::make('users.edit')->with('user', User::find($id))->with('change_avatar', 1);
        }
);
Route::get('users/edit/(:num)', function($id) {
            return View::make('users.edit')->with('user', User::find($id))->with('change_avatar', 0);
        }
);
Route::post('users/edit', 'users@post_edit');


Route::get('categories/(:num)', 'categories@view');
Route::get('categories/(:num)/posts', 'posts@category_id');


// >>>>>>>>>>>>>>>>> Authentication
// ... self-explanatory

Route::get('login', function() {
            return View::make('users.login_form');
        });
Route::post('login', 'users@post_login');

Route::get('logout', function() {
            Auth::user()->activity->delete();
            Auth::logout();
            return Redirect::to('/');
        });

// >>>>>>>>>>>>>>>>> Generic
// ... generic loads of controllers

Route::controller('users');
Route::controller('posts');
Route::controller('categories');
Route::controller('replies');
Route::controller('messages');
Route::controller('ignores');
Route::controller('groups');

// >>>>>>>>>>>>>>>>> Search
// ... interfaces to SILO

Route::get('search/categories', function() {

    return Silo::categories( Input::get('q') );

});

Route::get('search/users', function() {

    return Silo::users( Input::get('q') );

});

// >>>>>>>>>>>>>>>>> Mostly AJAXy stuff
// ... all that stuff that gets called via ajax

Route::post('users/change_avatar', 'users@change_avatar');
Route::post('users/save_preferences', 'users@save_preferences');


// >>>>>>>>>>>>>>>>> File system
// ... our uber kawaii url structure

Route::get('~/settings', 'users@get_settings');
Route::get('~(:any)/posts', 'users@posts_by_handle');
Route::get('~(:any)', 'users@by_handle');

Route::get('!(:any)/edit', 'categories@edit_by_handle');
Route::post('!(:any)/edit', 'categories@edit_by_handle');

Route::get('!(:any)/new', 'posts@full_path_new');
Route::post('!(:any)/new', 'posts@full_path_new');

Route::get('!(:any)/<(:any)/>(:any)/edit', 'replies@full_path_edit');
Route::get('!(:any)/<(:any)/>(:any)/delete', 'replies@full_path_delete');
Route::post('!(:any)/<(:any)/>(:any)/edit', 'replies@full_path_edit');
Route::get('!(:any)/<(:any)/>(:any)', 'replies@full_path');
Route::get('!(:any)/<(:any)/edit', 'posts@full_path_edit');
Route::post('!(:any)/<(:any)/edit', 'posts@full_path_edit');
Route::get('!(:any)/<(:any)/delete', 'posts@full_path_delete');
Route::get('!(:any)/<(:any)', 'posts@full_path');
Route::get('!(:any)', 'categories@posts_by_handle');

Event::listen('404', function() {
            return Response::error('404');
        });

Event::listen('500', function() {
            return Response::error('500');
        });
Route::filter('pattern: */edit', 'auth');
Route::filter('pattern: messages/*', 'auth');
Route::filter('pattern: ~/settings', 'auth');
Route::filter('before', function() {
            if (!(Auth::check()) &&
                    ((substr_count(URI::current(), 'new')) && URI::segment(1) != 'users' )){
                Session::put('pre_login', URI::current());
                return Redirect::to('/login');
            }
           
        });

Route::filter('after', function($response) {

            if (Auth::check()) {
                if (!Auth::user()->activity) {
                    $activity_data = array(
                        'user_id' => Auth::user()->id,
                        'ip' => Request::ip(),
                    );
                    $activity = new Activity;
                    $activity->fill($activity_data);
                    $activity->save();
                } else {

                    Auth::user()->activity->shake();
                }
            }
        Activity::sweep();
        });

Route::filter('csrf', function() {
            if (Request::forged())
                return Response::error('500');
        });

Route::filter('auth', function() {
            if (Auth::guest())
                return Redirect::to('login');
        });
