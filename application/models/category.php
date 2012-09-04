<?php

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

    public function mods() {
        User::join('user_category', 'user_category.user_id', '=', 'users.id')
        ->where('user_category.category_id', '=', $this->get_attribute('id'))
        ->get(array('users.*'));
    }

    public function clearance_required()
    {
        switch ( $this->get_attribute('access_required')) {
            case 0:
                return Diceman::nothing();
                break;
            case 5:
                return "Moderators+";
                break;
            case 10:
                return "Admins+";
                break;
            default:
                return Diceman::nothing();
                break;
        }

    }

}

?>
