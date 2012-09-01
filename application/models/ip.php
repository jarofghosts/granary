<?php

class Ip extends Eloquent {

    public static $table = 'users_ips';
    public static $timestamps = true;

    public function user()
    {
        return $this->belongs_to('User');

    }

}

?>
