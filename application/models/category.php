<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of category
 *
 * @author kab0b0
 */
class Category extends Eloquent {
    
    public static $table = 'categories';
    public static $timestamps = true;

    public function posts() {
        
        return $this->has_many('Post', 'category_id');
        
    }
    
    public function creator() {
        
        return $this->belongs_to('User', 'creator_id');
        
    }
    
    public function exclusions() {
        
        return $this->has_many('User_category_exclusion');
        
    }

}

?>
