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

            if (Input::get('avatar', FALSE) !== FALSE) {

                $avatar_bernie = new Bernie;

                $new_avatar = $avatar_bernie->migrate(Input::get('avatar'), "attic/users/");

                $input['avatar'] = $new_avatar;

                if ($avatar_bernie->getHeight() > $avatar_bernie->getWidth() && $avatar_bernie->getHeight() > 320) {
                    $avatar_bernie->resizeToHeight(320);
                } elseif ($avatar_bernie->getWidth() > $avatar_bernie->getHeight() && $avatar_bernie->getWidth() > 320) {
                    $avatar_bernie->resizeToWidth(320);
                }

                $avatar_bernie->save($new_avatar);
            }


            $user_data = array_merge($input, array(
                'active' => 1
                    ));

            $new_user = new User();
            $new_user->fill($user_data);
            $new_user->save();

            $preference = new Preference();
            $preference_defaults = array(
                'id' => $new_user->id,
                'front_page_posts' => 15,
                'account_type' => 1
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

        if (Input::get('avatar', FALSE) !== FALSE) {
            $user_data['avatar'] = Input::get('avatar');
        }

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

            if (isset($user_data['avatar'])) {
                $avatar_bernie = new Bernie;

                $new_avatar = $avatar_bernie->migrate(Input::get('avatar'), "attic/users/");

                $user_data['avatar'] = $new_avatar;

                if ($avatar_bernie->getHeight() > $avatar_bernie->getWidth() && $avatar_bernie->getHeight() > 320) {
                    $avatar_bernie->resizeToHeight(320);
                } elseif ($avatar_bernie->getWidth() > $avatar_bernie->getHeight() && $avatar_bernie->getWidth() > 320) {
                    $avatar_bernie->resizeToWidth(320);
                }

                $avatar_bernie->save($new_avatar);
            }

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

        if (!(User::where('username', '=', Input::get('username'))->get())) {

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
                $new_user->password = Session::get('temp_password');
                $new_user->save();

                Session::forget('temp_password');

                $preference = new Preference();
                $preference_defaults = array(
                    'id' => $new_user->id,
                    'front_page_posts' => 15,
                    'account_type' => 1
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
        ->with('preference', Preference::find(Auth::user()->id));
    }

    public function action_save_profile()
    {
        
    }

    public function action_save_content()
    {

    }

    public function action_save_exclusions()
    {

    }

    public function action_save_preferences()
    {
        
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