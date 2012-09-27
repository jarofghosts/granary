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

    public function preferences()
    {

        return Preference::find($this->get_attribute('id'));

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
    public function check_vote($post_id)
    {

        $result = Cache::get($this->get_attribute('username') . '&' . $post_id . '&vote', FALSE);
        
        if ($result === FALSE)
        {
            $result = DB::table('votes')->where('caster_id', '=', $this->get_attribute('id'))
            ->where('post_id', '=', $post_id)->take(1)->only('votes.good');

            Cache::put($this->get_attribute('username') . '&' . $post_id . '&vote', $result, 'forever');

        }

        return $result;

    }
    public function cast_vote($post_id, $vote)
    {
        $insert_data = array(
                'caster_id' => $this->get_attribute('id'),
                'post_id' => $post_id,
                'good' => $vote
            );
        DB::table('votes')->insert($insert_data);
        Cache::put($this->get_attribute('username') . '&' . $post_id . '&vote', $vote, 'forever');
        return $vote;
    }

    public function get_edit_avatar()
    {
        return $this->get_attribute('avatar');
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
        
        $user_rules = DB::table('user_category')
        ->where('user_id', '=', $this->get_attribute('id'))
        ->get(array('user_category.category_id'));

/*        $group_rules = DB::table('group_category')
        ->join('group_user', 'user_id', '=', $this->get_attribute('id'))
        ->where('group_category.group_id', '=', 'group_user.group_id')
        ->get(array('group_category.category_id'));

        return array_merge($user_rules, $group_rules); */

        return $user_rules;

    }

    public function post_list( $skip = 0 )
    {

        $excluded_categories = $this->excluded_categories();
        $ignored_users = $this->ignored_users();

        $query = Post::where('active', '=', 1)
                ->order_by('default_order', 'desc')
                ->take($this->preferences()->front_page_posts)
                ->where('score', '>=', $this->preferences()->rating_threshold)
                ->skip($skip);

        if ($excluded_categories) {
            $query->where_not_in('category_id', $excluded_categories);
        }
        if ($ignored_users) {
            $query->where_not_in('author_id', $ignored_users);
        }
            return $query->get();

    }

    public function category_list() {

        return Cache::remember($this->get_username . '&cat_list', Category::where('categories.active', '=', 1)
        ->where('categories.access_required', '<=', $this->get_attribute('access_level'))
        ->get(), 'forever');

    }

    public function ignored_users()
    {

        $username = $this->get_attribute('username');
        $user_id = $this->get_attribute('id');

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

            Cache::forever($username . '&jerk_ignores', $ignored_users);

        }

        return $ignored_users;

    }

    public function excluded_categories()
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

        return $excluded_categories;
    }

    public function ignored() {

        $ignored_users = $this->ignored_users();

        if (count($ignored_users) > 0){
            return User::where_in('id', $ignored_users)
            ->get();    
        }

        return false;

    }

    public function excluded() {

        $excluded_categories = $this->excluded_categories();
        
        if (count($excluded_categories) > 0) {
            return Category::where_in('id', $excluded_categories)
            ->get();
        }

        return false;

    }

    public function can_edit($category_id)
    {
        $category = Category::find($category_id);

        if ( $category->creator_id == $this->get_attribute('id') 
            || $this->get_attribute('access_level') > $category->creator->access_level
            || DB::table('user_category')->where('user_id', '=', $this->get_attribute('id'))
                ->where('category_id', '=', $category_id)
                ->count() > 0)
        {

            return true;

        }

        return false;
    }

    public function can_edit_post($post_id)
    {

        $post = Post::find($post_id);

        if ($post->author_id == $this->get_attribute('id')
         || $this->get_attribute('access_level') > $post->user->access_level
         || ( $this->can_edit($post->category_id) && $post->user->access_level <= $this->get_attribute('access_level')))
        {

            return true;

        }

        return false;

    }

    public function can_edit_reply($reply_id)
    {
        $reply = Reply::find($reply_id);

        if ($reply->author_id == $this->get_attribute('id')
         || $this->get_attribute('access_level') > $reply->user->access_level
         || ( $this->can_edit($reply->grandfather->category_id) && $reply->user->access_level <= $this->get_attribute('access_level')))
        {

            return true;

        }

        return false;

    }

    public function can_edit_user($user_id)
    {
        $user = User::find($user_id);

        if ($user->id == $this->get_attribute('id')
            || $this->get_attribute('access_level') > $user->access_level )
        {

            return true;

        }

        return false;

    }


}