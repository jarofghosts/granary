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

}

?>
