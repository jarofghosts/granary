<?php

class Replies_Controller extends Base_Controller {

    public $restful = true;

    public function get_new($grandparent_id = null, $parent_id = null)
    {

        if ($grandparent_id != null) {

            $grandparent = Post::find($grandparent_id);
            $parent = Reply::find($parent_id);

            return View::make('replies.new')->with('post', $grandparent)->with('reply', $parent);
        } else {

            return View::make('common.error')->with('error_message', 'No parent specified to replies.');
        }

    }

    public function post_new()
    {
        $author_id = Auth::user()->id;
        $reply = array(
            'parent_id' => 0,
            'grandparent_id' => Input::get('grandparent_id'),
            'body' => Input::get('body'),
            'author_id' => $author_id
        );

        $rules = array(
            'body' => 'required|min:3'
        );

        $validation = Validator::make($reply, $rules);

        if ($validation->fails()) {
            return View::make('common.error')->with('errors', $validation->errors)
                            ->with('error_message', 'Form validation errors');
        } else {

            $reply['slug'] = Reply::generate_slug($reply['body'], $reply['grandparent_id']);

            $new_reply = new Reply();
            $new_reply->fill($reply);
            $new_reply->save();

            $new_reply->grandparent->default_order = $new_reply->created_at;
            $new_reply->grandparent->save();

            $new_reply->user->add_experience();

            return Redirect::to('/!' . $new_reply->grandparent->category->handle . '/<' . $new_reply->grandparent->slug . '#reply-' . $new_reply->id);
        }

    }

    public function get_view($reply_id)
    {
        
        $reply = Reply::find($reply_id);
        if ($reply)
        {

            return View::make('replies.single')->with('reply', $reply);
       
        }
       
        return View::make('common.error')->with('error_message', 'Reply does not exist.');

    }

    public function get_edit($reply_id)
    {

        $reply = Reply::find($reply_id);
        if ($reply)
        {

            return View::make('replies.edit')->with('reply', $reply);

        }

        return View::make('common.error')->with('error_message', 'Reply does not exist.');

    }

    public function delete_remove($reply_id)
    {

        $reply = Reply::find($reply_id);

        if ($reply)
        {
            $reply->active = 0;
            $reply->save();
            return Redirect::to('/!' . $reply->grandparent->category->handle . '/<' . $reply->grandparent->slug);
        }

        return View::make('common.error')->with('error_message', 'Reply does not exist');

    }

    // Wrappers

    public function get_full_path( $category_handle, $post_slug, $reply_slug )
    {
        return $this->get_view(Reply::full_path($category_handle, $post_slug, $reply_slug));
    }

    public function get_full_path_edit( $category_handle, $post_slug, $reply_slug )
    {
        return $this->get_edit(Reply::full_path($category_handle, $post_slug, $reply_slug));
    }

    public function post_full_path_edit( $category_handle, $post_slug, $reply_slug )
    {
        return $this->post_edit(Reply::full_path($category_handle, $post_slug, $reply_slug));
    }

    public function post_full_path_delete(( $category_handle, $post_slug, $reply_slug )
    {
        return $this->delete_remove(Reply::full_path($category_handle, $post_slug, $reply_slug));
    }

}