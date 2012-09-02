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
        return $this->has_many('Reply', 'grandparent_id')->where('parent_id', '=', '0');

    }

    public function category()
    {

        return $this->belongs_to('Category', 'category_id');

    }

    public function set_body($source)
    {

        $this->set_attribute('body_source', $source);
        $this->set_attribute('body', Sparkdown\Markdown($source));

    }

    public static function generate_slug($title) {

        // replace all non letters or digits with -, chomp it to 60 characters
        $slug = preg_replace('/\W+/', '-', $title);
        $slug = strtolower(trim($post['slug'], '-'));
        $slug = substr($post['slug'], 0, 60);

        $appendix = 0;
        $slug_check = $post['slug'];

        while (Post::where('slug', '=', $post['slug'])
            ->where('category_id', '=', $post['category_id'])
            ->get()) {
            $slug = $slug_check . $appendix;
        }

        return $slug;

    }

}

?>
