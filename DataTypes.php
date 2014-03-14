<?php

/**
 * Entry point for the DataTypes library.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

namespace DataTypes;

use Exception;

if ( defined( 'DataTypes_VERSION' ) ) {
	// Do not initialize more then once.
	return 1;
}

define( 'DataTypes_VERSION', '0.2' );

$GLOBALS['wgDataTypes'] = array(
	'commonsMedia' => array(
		'datavalue' => 'string',
	),
	'string' => array(
		'datavalue' => 'string',
	),
	'globe-coordinate' => array(
		'datavalue' => 'globecoordinate',
	),
	'quantity' => array(
		'datavalue' => 'quantity',
	),
	'monolingual-text' => array(
		'datavalue' => 'monolingualtext',
	),
	'multilingual-text' => array(
		'datavalue' => 'multilingualtext',
	),
	'time' => array(
		'datavalue' => 'time',
	),
);

// @codeCoverageIgnoreStart
if ( defined( 'MEDIAWIKI' ) ) {
	include __DIR__ . '/DataTypes.mw.php';
}

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
			throw new \Exception( 'No text function set in DataTypes\Message' );
		}
		else {
			return call_user_func_array( self::$textFunction, func_get_args() );
		}
	}

}

// @codeCoverageIgnoreEnd