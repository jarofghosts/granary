<?php

class Posts_Controller extends Base_Controller {

    public $restful = true;

    public function get_new()
    {
        return View::make('posts.new');

    }

    public function post_new()
    {
        $author_id = Auth::check() ? Auth::user()->id : 0;

        $post = array(
            'title' => Input::get('title'),
            'body' => Input::get('body'),
            'category_id' => Input::get('category_id'),
            'author_id' => $author_id
        );

        $rules = array(
            'title' => 'required|max:128',
            'body' => 'required'
        );

        $validation = Validator::make($post, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            // replace all non letters or digits with -, chomp it to 60 characters
            $post['slug'] = preg_replace('/\W+/', '-', $post['title']);
            $post['slug'] = strtolower(trim($post['slug'], '-'));
            $post['slug'] = substr($post['slug'], 0, 60);

            $appendix = 0;
            $slug_check = $post['slug'];

            while (Post::where('slug', '=', $post['slug'])->get()) {
                $post['slug'] = $slug_check . $appendix;
            }

            $new_post = new Post();
            $new_post->fill($post);
            $new_post->save();

            $new_post->user->add_experience(2);

            return View::make('posts.single')->with('post', $new_post);
        }

    }

    public function get_edit($id = null)
    {

        if ($id != null) {

            $post = Post::find($id);

            if ($post) {

                return View::make('posts.edit')->with('post', $post);
            } else {

                return View::make('common.error')->with('error_message', 'Post does not exist');
            }
        } else {

            return View::make('common.error')->with('error_message', 'Internal error, no post specified');
        }

    }

    public function delete_remove($post_id = null)
    {

        $post = Post::find($post_id);

        if (Auth::user()->id == $post->user->id ||
                Auth::user()->access_level > $post->user->access_level) {
            $post->active = 0;
            $post->save();
        } else {

            return View::make('common.error')->with('error_message', 'Insufficient priveleges');
        }

        return;

    }

    public function get_delete($post_id = null)
    {

        $this->delete_remove($post_id);
        return Redirect::to('/posts');

    }

    public function post_edit()
    {
        $post_id = Input::get('id');
        $post_data = array(
            'title' => Input::get('title'),
            'body' => Input::get('body')
        );

        $rules = array(
            'title' => 'required|min:1|max:128',
            'body' => 'required|min:1'
        );

        $validation = Validator::make($post_data, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $post = Post::find($post_id);
            $post->fill($post_data);
            $post->save();

            return View::make('posts.single')->with('post', $post);
        }

    }

    public function get_index()
    {
        $exclusions = Auth::check() ? Exclusion::where('user_id', '=', Auth::user()->id)->get() : array();
        $ignores = Auth::check() ? Ignore::where('user_id', '=', Auth::user()->id)->get() : array();

        $limit = Auth::check() ? Preference::find(Auth::user()->id)->front_page_posts : 15;

        $excluded_categories = array(0);
        $ignored_users = array(0);

        foreach ($exclusions as $exclusion) {

            array_push($excluded_categories, $exclusion->category_id);
        }

        foreach ($ignores as $ignore) {

            array_push($ignored_users, $ignore->jerk_id);
        }

        $categories = Auth::check() ?
                Category::where('active', '=', '1')->where_not_in('id', $excluded_categories)->take(10)->get() : Category::where('active', '=', '1')->take(10)->get();

        $posts = Post::where('posts.active', '=', 1)
                ->left_join('categories', 'posts.category_id', '=', 'categories.id')
                ->left_join('users', 'posts.author_id', '=', 'users.id')
                ->where_not_in('categories.id', $excluded_categories)
                ->where_not_in('users.id', $ignored_users)
                ->order_by('posts.created_at', 'desc')
                ->take($limit)
                ->get(array('posts.*'));

        return View::make('posts.list')->with('posts', $posts)->with('categories', $categories);

    }

    public function get_view($post_id = null)
    {

        if ($post_id !== null) {
            $post = Post::find($post_id);
            if ($post) {

                $this->buildTree($post);

                return View::make('posts.single')->with('post', $post);
            } else {

                return View::make('common.error')->with('error_message', 'Invalid post ID');
            }
        } else {
            return View::make('common.error')->with('error_message', 'No post ID specified');
        }

    }

    public function get_by_slug($post_slug = null)
    {

        $post = Post::where('slug', '=', $post_slug)->take(1)->get();

        if ($post) {

            return $this->get_view($post[0]->id);
        } else {

            $this->handle = $post_slug;
            $object = $this;
            $search = Post::where('active', '=', 1)->where(function($query) use($object) {
                                $query->where('slug', 'LIKE', '%' . $object->handle . '%');
                                $query->or_where('title', 'LIKE', '%' . $object->handle . '%');
                            })
                    ->get();
            return View::make('posts.not_found')->with('possibilities', $search);
        }

    }

}
