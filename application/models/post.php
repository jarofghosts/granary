<?php

class Post extends Eloquent {

    public static $timestamps = true;

    public function user()
    {

        return $this->belongs_to('User', 'author_id');

    }

    public function replies()
    {

        // this will only pull top-level replies.
        return $this->has_many('Reply', 'grandparent_id')
        ->where('parent_id', '=', '0')
        ->where('active', '=', 1);

    }

    public function category()
    {

        return $this->belongs_to('Category', 'category_id');

    }

    public function set_body($source)
    {

        $this->set_attribute('body_source', $source);
        $source = Sparkdown\Markdown($source);
        $source = Magenta::smilerize($source);
        $this->set_attribute('body', $source);

    }

    public function set_category_id( $new_category ){
        if ($new_category != $this->get_attribute('category_id')){
            Cache::forget('full_path_post&' . $this->get_attribute('id'));
        }
        $this->set_attribute('category_id', $new_category);
    }

    public static function generate_slug($title, $category_id)
    {

        // replace all non letters or digits with -, chomp it to 60 characters
        $slug = preg_replace('/\W+/', '-', $title);
        $slug = strtolower(trim($slug, '-'));
        $slug = substr($slug, 0, 60);

        $appendix = 0;
        $slug_check = $slug;

        while (Post::where('slug', '=', $slug)
            ->where('category_id', '=', $category_id)
            ->get()) {
            $slug = $slug_check . $appendix;
        }

        return $slug;

    }

    public function get_absolute_path()
    {
        return Cache::remember('full_path_post&' . $this->get_attribute('id'),
            URL::base() . '/!' . $this->category->handle . '/<' . $this->get_attribute('slug')
            , 'forever');
    }

    // @todo make a generator for this as well.
    public static function full_path( $category_handle, $post_slug )
    {
        $post_id = Cache::remember(md5( $category_handle . $post_slug ),
            DB::table('posts')->join('categories', 'categories.id', '=', 'posts.category_id')
            ->where('posts.slug', '=', $post_slug)
            ->where('categories.handle', '=', $category_handle)
            ->only('posts.id'), 'forever');

        if ($post_id === NULL) {

            Cache::forget(md5( $category_handle . $post_slug )); // just in case this was some odd 404, we'll just forget the cache

        }

        return $post_id;

    }

    public function vote_up ()
    {
        $this->set_attribute('score', DB::raw('score + 1'));
        $this->save();
        $this->user->add_experience(1);
    }
    public function vote_down ()
    {
        $this->set_attribute('score', DB::raw('score - 1'));
        $this->save();
        $this->user->add_experience(-1);
    }

}

?>
