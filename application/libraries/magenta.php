<?php

class Magenta {
	
	public static function get()
	{

		Cache::forget('smilies');
		return Cache::remember('smilies', function() { 
			return DB::table('smilies')->where('active', '=', 1)
			->get();
			}, 'forever');

	}

	public static function smilerize( $text )
	{
		$rules = self::get();

		foreach ( $rules as $rule )
		{

			$text = str_replace($rule->trigger, "<img src='{$rule->replacement}' class='smiley' alt='{$rule->trigger}'/>", $text);

		}

		return $text;

	}

}