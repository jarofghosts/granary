<?php

class Users_Controller extends Base_Controller {

    public function action_index($id = null)
    {

        if ($id != null) {

            $user = User::find($id);

            if ($user) {

                return View::make('users.single')->with('user', $user);
            } else {

                return View::make('common.error')->with('error_message', 'User does not exist.');
            }
        } else {
            $users = User::all();


            return View::make('users.list')->with('users', $users);
        }

    }

    public function action_change_avatar()
    {
            if ( Input::file('avatar-upload', FALSE )) {

                $new_name = Bernie::generate_filename(Input::get('avatar-upload'));

                Input::upload('avatar-upload', './public/attic/users', $new_name);
                
                $new_avatar = '/attic/users/' . $new_name;

            } else if (Input::get('avatar', FALSE) !== FALSE) {

                $new_avatar = Bernie::migrate(Input::get('avatar'), "attic/users/");

            } else {

                return Response::json(array('success' => false));

            }

            Bernie::format($new_avatar);
            $response = array(
                'img_src' => $new_avatar,
                'success' => true
            );

            return Response::json($response);

    }

    public function action_post_register()
    {

        $input = Input::all();

        $input['display_name'] = preg_replace('/^[^a-zA-Z]+/', '', $input['display_name']);

        $rules = array(
            'username' => 'required|unique:users|max:24',
            'password' => 'required',
            'real_name' => 'max:128',
            'avatar' => 'max:128',
            'email' => 'email|max:128',
            'color' => 'max:32'
        );

        $validation = Validator::make($input, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $input['avatar'] = $this->action_upload_avatar();

            if (!$input['avatar']) { unset($input['avatar']); }

            $user_data = array_merge($input, array(
                'active' => 1
                    ));

            $new_user = new User();
            $new_user->fill($user_data);
            $new_user->save();

            $preference = new Preference();
            $preference_defaults = array(
                'id' => $new_user->id,
                'front_page_posts' => 9,
                'bot_messages' => 1
            );
            $preference->fill($preference_defaults);
            $preference->save();

            Auth::login($new_user->id);

            return Redirect::to('/');
        }

    }

    public function action_post_edit()
    {

        $user_id = Input::get('id');
        $user_data = array(
            'real_name' => Input::get('name'),
            'email' => Input::get('email'),
            'color' => Input::get('color'),
            'about_me' => Input::get('about_me'),
        );

        $rules = array(
            'real_name' => 'max:128',
            'email' => 'email|min:7|max:128',
            'color' => 'max:32',
            'avatar' => 'url'
        );

        $validation = Validator::make($user_data, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $user_data['avatar'] = $this->action_upload_avatar();

            if (!$user_data['avatar']) { unset($user_data['avatar']); }

            $user = User::find($user_id);
            $user->fill($user_data);

            $user->save();

            return Redirect::to('users/' . $user_id);

        }

    }

    public function action_post_login()
    {

        $credentials = array(
            'username' => Input::get('username'),
            'password' => Input::get('password')
        );

        if (strlen($credentials['username']) > 1 &&
             strlen($credentials['password']) > 0 &&
              !(User::where('username', '=', $credentials['username'])->get())) {

            Session::put('temp_password', Hash::make(Input::get('password')));
            return View::make('users.new_prompt')->with('username', Input::get('username'));
        }

        if (Auth::attempt($credentials)) {

            if (Session::has('pre_login')) {
                
                $pre_login = Session::get('pre_login');
                Session::forget('pre_login');
                return Redirect::to($pre_login);

            } else {

                return Redirect::to('/');
            }
            
        } else {

            return View::make('common.error')->with('error_message', 'Incorrect login information.');

        }

    }

    public function action_confirm($new_username = null)
    {

        if ($new_username != null) {

            if (!(User::where('username', '=', $new_username)->get()) && Session::has('temp_password')) {

                $new_user = new User;
                $new_user->username = substr($new_username, 0, 24);
                $new_user->set_attribute('password', Session::get('temp_password'));
                $new_user->save();

                Session::forget('temp_password');

                $preference = new Preference();
                $preference_defaults = array(
                    'id' => $new_user->id,
                    'front_page_posts' => 9,
                    'bot_messages' => 1
                );
                $preference->fill($preference_defaults);
                $preference->save();

                Auth::login($new_user->id);
                return Redirect::to('/');

            } else {
                Session::forget('temp_password');
                return View::make('users.login_form');
            }
        } else {
            Session::forget('temp_password');
            return View::make('users.login_form');
        }

    }

    public function action_get_settings()
    {

        return View::make('users.center')
        ->with('preferences', Preference::find(Auth::user()->id));

    }

    public function action_save_profile()
    {

        $user_id = Input::get('id');

        $user_data = array(
            'real_name' => Input::get('real_name'),
            'email' => Input::get('email'),
            'color' => Input::get('color'),
            'about_me' => Input::get('about_me'),
            'avatar' => Input::get('avatar')
        );

        $rules = array(
            'real_name' => 'max:128',
            'email' => 'email|min:7|max:128',
            'color' => 'max:32'
        );

        $validation = Validator::make($user_data, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $user = User::find($user_id);

            $user->fill($user_data);

            $user->save();

            echo 'success';
            return;

        }
    }

    public function action_save_preferences()
    {
        $preferences = array(
            'front_page_posts' => Input::get('front_page_posts',9),
            'rating_threshold' => Input::get('rating_threshold',0),
            'responses_per_page' => Input::get('responses_per_page',0),
            'bot_messages' => Input::get('bot_messages', 0),
        );
        $rules = array(
            'front_page_posts' => 'numeric',
            'rating_threshold' => 'numeric',
            'responses_per_page' => numeric
        );

        $validation = Validator::make($preferences, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $user_preferences = Preference::find(Auth::user()->id);
            $user_preferences->fill($preferences);
            $user_preferences->save();

            echo 'success';
            return;
        }
    }

    public function action_by_handle($user_handle = null)
    {

        $user = User::where('username', '=', $user_handle)->take(1)->get();

        if ($user) {

            return $this->action_index($user[0]->id);

        } else {

            $search = User::where('active', '=', 1)->where('username', 'LIKE', '%' . $user_handle . '%')
                    ->get();
            return View::make('users.not_found')->with('possibilities', $search);

        }

    }

}