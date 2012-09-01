<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_category_exclusion
 *
 * @author jarofghosts
 */
class Ignore extends Eloquent {

    public static $table = 'user_ignores';
    public static $timestamps = true;

    public function user()
    {
        
        return $this->belongs_to('User');

    }
    
    public function jerk() {
        
        return $this->has_one('User', 'jerk_id');
        
    }

}

?>
