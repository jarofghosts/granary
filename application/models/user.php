<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author kab0b0
 */
class User extends Eloquent {

    public static $timestamps = true;

    public function posts()
    {

        return $this->has_many('Post', 'author_id');

    }

    public function replies()
    {

        return $this->has_many('Reply', 'author_id');

    }

    public function groups()
    {
        return $this->has_many_and_belongs_to('Group');

    }

    public function categories()
    {
        return $this->has_many('Category', 'creator_id');

    }

    public function ips()
    {

        return $this->has_many('Ip');

    }

    public function activity()
    {

        return $this->has_one('Activity');

    }

    public function exclusions()
    {

        return $this->has_many('User_category_exclusion');

    }

    public function ignore()
    {

        return $this->has_many('Ignore');

    }

    public function unread_messages()
    {

        return Message::where('recipient_id', '=', $this->get_attribute('id'))
                        ->where('read', '=', 0)
                        ->get();

    }

    public function ignores($user_id)
    {

        $ignore = Ignore::where('user_id', '=', $this->get_attribute('id'))
                        ->where('jerk_id', '=', $user_id)->get();
        if (count($ignore) < 1) {
            return false;
        } else {
            return true;
        }

    }

    public function excludes($category_id)
    {

        $exclude = Exclusion::where('user_id', '=', $this->get_attribute('id')->where('category_id', '=', $category_id)->get());
        if (count($exclude) < 1) {
            return false;
        } else {
            return true;
        }

    }

    public function set_password($password)
    {

        $this->set_attribute('password', Hash::make($password));

    }

    public function get_display_name()
    {
        $prefix = "";
        
        if ($this->get_attribute('access_level') >= 5) {
            $prefix = "+";
        }
        if ($this->get_attribute('access_level') >= 10) {
            $prefix = "@";
        }
        if ($this->get_attribute('access_level') >= 15) {
            $prefix = "&";
        }

        return $prefix . substr($this->get_attribute('username'), 0, 24);

    }

    public function add_experience($experience_value = 1)
    {

        $this->set_attribute('experience', DB::raw('experience + ' . $experience_value));
        $this->save();

    }

    public function get_avatar()
    {

        if (!($this->get_attribute('avatar'))) {

            return "/img/defaults/avatar.jpg";
        } else {

            return $this->get_attribute('avatar');
        }

    }

}