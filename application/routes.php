<?php

Route::get('/', function() {
            return View::make('common.index');
        });
Route::get('posts/(:num)/reply/(:num)/new', 'replies@get_new');
Route::get('posts/(:num)/reply/new', 'replies@get_new');
Route::post('posts/(:num)/reply/(:num)/new', 'replies@post_new');
Route::post('posts/(:num)/reply/new', 'replies@post_new');
Route::delete('posts/(:num)', 'posts@remove');
Route::get('users/settings', 'users@get_settings');
Route::get('users/(:num)', 'users@index');
Route::get('posts/(:num)', 'posts@view');
Route::get('users/new', function() {
            return View::make('users.register');
        });
Route::post('users/new', 'users@post_register');
Route::get('login', function() {
            return View::make('users.login_form');
        });
Route::post('login', 'users@post_login');
Route::get('users/edit/(:num)/avatar', function($id) {
            return View::make('users.edit')->with('user', User::find($id))->with('change_avatar', 1);
        }
);
Route::get('users/edit/(:num)', function($id) {
            return View::make('users.edit')->with('user', User::find($id))->with('change_avatar', 0);
        }
);
Route::post('users/edit', 'users@post_edit');
Route::get('logout', function() {
            Auth::user()->activity->delete();
            Auth::logout();
            return Redirect::to('/');
        });

Route::get('categories/(:num)', 'categories@view');
Route::get('categories/(:num)/posts', 'posts@category_id');

Route::controller('users');
Route::controller('posts');
Route::controller('categories');
Route::controller('replies');
Route::controller('messages');
Route::controller('ignores');
Route::controller('groups');

Route::get('categories/(:any)', 'categories@by_handle');
Route::get('categories/(:any)/posts', 'posts@category_handle');

Route::get('~/settings', 'users@get_settings');
Route::get('!(:any)/posts', 'categories@posts_by_handle');
Route::get('~(:any)/posts', 'users@posts_by_handle');
Route::get('!(:any)', 'categories@by_handle');
Route::get('<(:any)/>(:any)', 'replies@by_slug');
Route::get('<(:any)', 'posts@by_slug');
Route::get('~(:any)', 'users@by_handle');

/*
  |--------------------------------------------------------------------------
  | Application 404 & 500 Error Handlers
  |--------------------------------------------------------------------------
  |
  |
 */

Event::listen('404', function() {
            return Response::error('404');
        });

Event::listen('500', function() {
            return Response::error('500');
        });

/*
  |--------------------------------------------------------------------------
  | Route Filters
  |--------------------------------------------------------------------------
  |
  | Filters provide a convenient method for attaching functionality to your
  | routes. The built-in before and after filters are called before and
  | after every request to your application, and you may even create
  | other filters that can be attached to individual routes.
  |
  | Let's walk through an example...
  |
  | First, define a filter:
  |
  |		Route::filter('filter', function()
  |		{
  |			return 'Filtered!';
  |		});
  |
  | Next, attach the filter to a route:
  |
  |		Router::register('GET /', array('before' => 'filter', function()
  |		{
  |			return 'Hello World!';
  |		}));
  |
 */

Route::filter('before', function() {
            if (!(Auth::check()) &&
                    ((substr_count(URI::current(), 'new')) && URI::segment(1) != 'users' ||
                    ((substr_count(URI::current(), 'edit'))) || URI::segment(1) == 'messages')) {
                Session::put('pre_login', URI::current());
                return Redirect::to('users/login');
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
