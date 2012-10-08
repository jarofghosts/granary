<?php

class Smiley extends Eloquent {

	public static $timestamps = true;
	public static $table = 'smilies';

	public function author()
	{
		$this->belongs_to('User', 'author_id');
	}

	public function set_trigger( $trigger )
	{
		Cache::forget('smilies');
		$this->set_attribute('trigger', $trigger);
	}

	public function set_active( $active )
	{
		Cache::forget('smilies');
		$this->set_attribute('active', $active);
	}

	public function set_replacement( $replacement )
	{
		Cache::forget('smilies');
		$this->set_attribute('replacement', $replacement);
	}

}