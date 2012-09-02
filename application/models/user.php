<?php

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

        $exclude = Exclusion::where('user_id', '=', $this->get_attribute('id'))
                            ->where('category_id', '=', $category_id)->get();

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
        $display_name = Cache::get($this->get_attribute('username') . '&display_name');

        if ($display_name === NULL)
        {
            $access_level = $this->get_attribute('access_level');

            $prefix = "";

            if ($access_level >= 5 && $access_level < 10) {
                $prefix = "+";
            }
            if ($access_level >= 10 && $access_level < 15) {
                $prefix = "@";
            }
            if ($access_level >= 15) {
                $prefix = "&";
            }

            $display_name = $prefix . $this->get_attribute('username');

            Cache::forever($this->get_attribute('username') . '&display_name', $display_name);
        }
        
        return $display_name;

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

    public function get_enrolled_categories()
    {
        $user_rules = DB::table('users_categories')
        ->where('user_id', '=', $this->get_attribute('id'))
        ->get(array('users_categories.category_id'));

        $group_rules = DB::table('group_category')
        ->join('group_user', 'user_id', '=', $this->get_attribute('id'))
        ->where('group_category.group_id', '=', 'group_user.group_id')
        -get(array('group_category.category_id'));

        return array_merge($user_rules, $group_rules);

    }

    public function get_can_read( $category_id )
    {

    }

    public function post_list( $take = 15, $skip = 0 )
    {

        $username = $this->get_attribute('username');
        $user_id = $this->get_attribute('id');

        $excluded_categories = Cache::get($username . '&cat_excludes');

        if ( $excluded_categories === NULL )
        {
        
            $categories = DB::table('user_category_exclusions')
            ->where('user_id', '=', $user_id)
            ->get(array('category_id'));

            $excluded_categories = array();

            foreach ($categories as $category) {
               array_push($excluded_categories, $category->category_id);
            }

            Cache::forever($username . '&cat_excludes', $excluded_categories);

        }

        $ignored_users = Cache::get($username . '&jerk_ignores');

        if ( $ignored_users === NULL )
        {

            $users = DB::table('user_ignores')
            ->where('user_id', '=', $user_id)
            ->get(array('jerk_id'));

        
            $ignored_users = array();


            foreach ($users as $user) {
                array_push($ignored_users, $user->jerk_id);
            }

        }

        return Post::where('active', '=', 1)
                ->where_not_in('category_id', $excluded_categories)
                ->where_not_in('author_id', $ignored_users)
                ->order_by('created_at', 'desc')
                ->take($take)
                ->skip($skip)
                ->get();

    }

    public function category_list() {

        return Cache::remember($this->get_username . '&cat_list',Category::where('categories.active', '=', 1)
        ->where('categories.access_required', '<=', $this->get_attribute('access_level'))
        ->get(), 'forever');

    }


}