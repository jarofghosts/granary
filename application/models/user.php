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

        return $prefix . $this->get_attribute('username');

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

        $categories = DB::table('user_category_exclusions')
        ->where('user_id', '=', $this->get_attribute('id'))
        ->get(array('category_id'));

        $users = DB::table('user_ignores')
        ->where('user_id', '=', $this->get_attribute('id'))
        ->get(array('jerk_id'));

        $excluded_categories = array();
        $ignored_users = array();

        foreach ($categories as $category) {
            array_push($excluded_categories, $category->category_id);
        }
        foreach ($users as $user) {
            array_push($ignored_users, $user->jerk_id);
        }

        return Post::where('posts.active', '=', 1)
                ->left_join('categories', 'posts.category_id', '=', 'categories.id')
                ->left_join('users', 'posts.author_id', '=', 'users.id')
                ->where_not_in('categories.id', $excluded_categories)
                ->where_not_in('users.id', $ignored_users)
                ->order_by('posts.created_at', 'desc')
                ->take($take)
                ->skip($skip)
                ->get(array('posts.*'));

    }

    private function flatten(array $array) {
    $return = array();
    
    return $return;
    
    }

}