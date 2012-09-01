<?php

/**
 * Description of user_category_exclusion
 *
 * @author jarofghosts
 */
class Activity extends Eloquent {

    public static $table = 'user_activity';
    public static $timestamps = false;

    public function user()
    {

        return $this->belongs_to('User');

    }
    
    public function shake()
    {
        
        $this->set_attribute('last_activity', DB::raw('NOW()'));
        $this->save();
        
    }

    public static function sweep()
    {

        $old_logins = Activity::where('last_activity', '<', DB::raw('DATE_SUB(NOW(), INTERVAL 1 MINUTE)'))->get();
        foreach ($old_logins as $old_login) {
            $old_login->delete();
// @todo add logging
        }
        
    }

}

?>
