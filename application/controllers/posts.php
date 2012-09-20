<?php

class Posts_Controller extends Base_Controller {

    public $restful = true;

    public function get_new( $category_id = null )
    {

        return View::make('posts.new')->with('category_id', $category_id);

    }

    public function post_new()
    {

        $post = array(

            'title' => Input::get('title'),
            'body' => Input::get('body'),
            'category_id' => Input::get('category_id'),
            'author_id' => Auth::user()->id

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

            $post['slug'] = Post::generate_slug($post['title'], $post['category_id']);

            $new_post = new Post();
            $new_post->fill($post);
            $new_post->save();

            $new_post->default_order = $new_post->created_at;
            $new_post->save();

            $this->post_up($new_post->id);

            $new_post->user->add_experience(1);

            return View::make('posts.single')->with('post', $new_post);
        }

    }

    public function get_edit($id = null)
    {

        if ($id != null) {

            $post = Post::find($id);

            if ($post) {

                if (Auth::user()->can_edit_post($id)) {
                    
                    return View::make('posts.edit')->with('post', $post);

                }
                return View::make('common.error')->with('error_message', 'Insufficient priveleges');
                
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

        $posts = Auth::check() ? Auth::user()->post_list() : Anonymous::post_list();
        return View::make('posts.list')->with('posts', $posts);

    }

    public function get_view($post_id = null)
    {

        if ($post_id != null) {
            $post = Post::find($post_id);
            if ($post) {

                return View::make('posts.single')->with('post', $post);

            } 

            return View::make('common.error')->with('error_message', 'Invalid post ID');

        } 

        return View::make('common.error')->with('error_message', 'No post ID specified');

    }
    public function post_up( $post_id )
    {
        $current_vote = Auth::user()->check_vote( $post_id );
        if ($current_vote < 1) {
            Post::find( $post_id )->vote_up();
            Auth::user()->cast_vote( $post_id, 1 );
            return Response::json( array('success' => true, 'changed' => true ) );
        }
        return Response::json( array('success' => true ) );
    }
    public function post_down( $post_id )
    {
        $current_vote = Auth::user()->check_vote( $post_id );
        if ($current_vote >= 0) {
            Post::find( $post_id )->vote_down(Auth::user()->id);
            Auth::user()->cast_vote( $post_id, -1 );
            return Response::json( array('success' => true, 'hide_post' => true, 'changed' => true ) );
        }
        return Response::json( array('success' => true ) );
    }

    public function get_full_path( $category_handle = null, $post_slug = null )
    {
        return $this->get_view(Post::full_path( $category_handle, $post_slug ));
    }
    public function get_full_path_new( $category_handle = null )
    {
        return $this->get_new(Category::where('handle', '=', $category_handle)->only('id'));
    }
    public function post_full_path_new( $category_handle = null )
    {
        return $this->post_new();
    }
    public function get_full_path_edit( $category_handle, $post_slug )
    {
        return $this->get_edit(Post::full_path( $category_handle, $post_slug ));
    }
    public function post_full_path_edit( $category_handle, $post_slug )
    {
        return $this->post_edit();
    }
    public function get_full_path_delete( $category_handle, $post_slug )
    {
        return $this->get_delete( Post::full_path( $category_handle, $post_slug ));
    }

}
