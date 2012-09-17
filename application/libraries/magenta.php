<?php

class Magenta {
	
	public static function get()
	{
		return Cache::remember('smilies', function() { 
			DB::table('smilies')->where('active', '=', 1)
			->get();
			}, 'forever');
	}

	public static function smilerize( $text )
	{
		$rules = self::get();

		foreach ( $rules as $rule )
		{

			$text = str_replace($rule->trigger, $rule->image, $text);

		}

		return $text;

	}
	
}