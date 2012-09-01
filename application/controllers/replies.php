<?php

/**
 * Handling replies interface
 *
 * @author jarofghosts
 */
class Replies_Controller extends Base_Controller {

    public function action_get_new($grandparent_id = null, $parent_id = null)
    {

        if ($grandparent_id != null) {

            $grandparent = Post::find($grandparent_id);
            $parent = Reply::find($parent_id);

            return View::make('replies.new')->with('post', $grandparent)->with('reply', $parent);
        } else {

            return View::make('common.error')->with('error_message', 'No parent specified to replies.');
        }

    }

    public function action_post_new()
    {
        $author_id = Auth::check() ? Auth::user()->id : 0;
        $reply = array(
            'parent_id' => Input::get('parent_id'),
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

            $reply['slug'] = preg_replace('/\W+/', '-', substr($reply['body'], 0, 60));
            $reply['slug'] = strtolower(trim($reply['slug'], '-'));

            $appendix = 0;
            $slug_check = $reply['slug'];

            while (Reply::where('grandparent_id', '=', $reply['grandparent_id'])->where('slug', '=', $reply['slug'])->get()) {
                $reply['slug'] = $slug_check . $appendix;
            }

            $new_reply = new Reply();
            $new_reply->fill($reply);
            $new_reply->save();

            $new_reply->grandparent->default_order = $new_reply->created_at;
            $new_reply->grandparent->save();

            $new_reply->user->add_experience();

            return Redirect::to('/<' . $new_reply->grandparent->slug . '#reply-' . $new_reply->id);
        }

    }

    public function action_view($reply_id)
    {
        $reply = Reply::find($reply_id);
        if ($reply) {

            return View::make('replies.single')->with('reply', $reply);
        } else {
            return View::make('common.error')->with('error_message', 'Reply does not exist.');
        }

    }

    public function action_by_slug($grandparent_slug = null, $slug = null)
    {

        $grandparent = Post::where('slug', '=', $grandparent_slug)->get();
        $reply = Reply::where('grandparent_id', '=', $grandparent[0]->id)->where('slug', '=', $slug)->get();

        return $this->action_view($reply[0]->id);

    }

}