<?php
/**
 * Messages model
 *
 * @author kab0b0
 */
class Message extends Eloquent {

    public static $timestamps = true;

    public function sender()
    {

        return $this->belongs_to('User', 'sender_id');

    }
    
    public function recipient()
    {
        
        return $this->belongs_to('User', 'recipient_id');
        
    }

}

?>