<?php

class Diceman {


	static $no_words
	 = array( 'Zilch', 'Zip', 'Goose egg', 'Nothin\'', 'Nada', 'N/A', '---', 'DIVIDE_BY_ZERO_ERROR',
	 'Not anything', 'Null', 'Naught', '{}', '&empty;', 'Empty', '0', 'Nein', 'nope.avi', 'Cero',
	 'Zero' );

	
	public static function nothing() {
		return self::$no_words[rand(0, (count(self::$no_words) - 1))];
	}

}