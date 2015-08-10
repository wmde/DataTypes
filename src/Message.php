<?php

namespace DataTypes;

use Exception;

class Message {

	protected static $textFunction = null;

	/**
	 * Sets the function to call from @see text.
	 *
	 * @since 0.1
	 *
	 * @param callable $textFunction
	 * This function should take a message key, a language code, and an optional list of arguments.
	 */
	public static function registerTextFunction( $textFunction ) {
		self::$textFunction = $textFunction;
	}

	public static function text() {
		if ( is_null( self::$textFunction ) ) {
			throw new Exception( 'No text function set in DataTypes\Message' );
		} else {
			return call_user_func_array( self::$textFunction, func_get_args() );
		}
	}

}
