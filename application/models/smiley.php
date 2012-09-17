<?php

class Smiley extends Eloquent {

	public $timestamps = true;
	public $table = 'smilies';

	public function author()
	{
		$this->belongs_to('User', 'author_id');
	}

	public function set_trigger( $trigger )
	{
		Cache::forget('smilies');
	}
}