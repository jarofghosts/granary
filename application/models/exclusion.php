<?php

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