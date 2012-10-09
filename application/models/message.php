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

    public static function thread( $parent_id )
    {

    	return Message::where('id', '=', $parent_id)->or_where('parent_id', '=', $parent_id)
    			->order_by('created_at', 'asc')->get();

    }

}

?>