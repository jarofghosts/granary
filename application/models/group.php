<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of group
 *
 * @author kab0b0
 */
class Group extends Eloquent {

    public static $timestamps = true;

    function creator()
    {
        
        return $this->belongs_to('User', 'creator_id');

    }

    function members()
    {
        
        return $this->has_many_and_belongs_to('User');

    }

}

?>
