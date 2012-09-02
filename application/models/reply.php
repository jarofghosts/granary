<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of response
 *
 * @author kab0b0
 */
class Reply extends Eloquent {

    public static $timestamps = true;

    public function user()
    {

        return $this->belongs_to('User', 'author_id');

    }

    public function parent()
    {

        return $this->belongs_to('Reply', 'parent_id');

    }

    public function grandparent()
    { // this will always be the post the reply is under
        return $this->belongs_to('Post', 'grandparent_id');

    }

    public function replies()
    {

        return $this->has_many('Reply', 'parent_id');

    }

    public function get_body()
    {
        $body = $this->get_attribute('body');
        $body = str_replace('<', '&lt;', $body);
        $body = str_replace('>', '&gt;', $body);
        return $body;

    }

    public static function generate_slug($body, $post_id)
    {

            $slug = preg_replace('/\W+/', '-', substr($body, 0, 60));
            $slug = strtolower(trim($slug, '-'));

            $appendix = 0;
            $slug_check = $slug;

            while (Reply::where('grandparent_id', '=', $post_id)->where('slug', '=', $slug)->get()) {
                $slug = $slug_check . $appendix;
            }

            return $slug;

    }

    public static function full_path( $category_handle, $post_slug, $reply_slug )
    {

        $reply_id = Cache::remember(md5( $category_handle . $post_slug . $reply_slug),
            DB::table('replies')->join('posts', 'posts.id', '=', 'replies.grandparent_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where('posts.slug', '=', $post_slug)
            ->where('categories.handle', '=', $category_handle)
            ->where('replies.slug', '=', $reply_slug)
            ->only('replies.id'), 'forever');

        if ($reply_id === NULL) {

            Cache::forget(md5( $category_handle . $post_slug . $reply_slug)); // just in case this was some odd 404, we'll just forget the cache

        }

        return $reply_id;

    }

}

?>
