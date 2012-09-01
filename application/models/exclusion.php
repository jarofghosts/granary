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
class Exclusion extends Eloquent {

    public static $table = 'user_category_exclusions';
    public static $timestamps = true;

    public function user()
    {
        
        return $this->belongs_to('User');

    }
    
    public function category() {
        
        return $this->has_one('Category');
        
    }

}

?>
