<?php

/**
 * MediaWiki setup for the DataTypes library.
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

namespace DataTypes;

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$GLOBALS['wgExtensionCredits']['datavalues'][] = array(
	'path' => __DIR__,
	'name' => 'DataTypes',
	'version' => DataTypes_VERSION,
	'author' => array(
		'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
		'[https://www.mediawiki.org/wiki/User:Danwe Daniel Werner]',
		'[http://www.snater.com H. Snater]',
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:DataTypes',
	'descriptionmsg' => 'datatypes-desc',
);

$GLOBALS['wgExtensionMessagesFiles']['DataTypes'] = __DIR__ . '/DataTypes.i18n.php';

Message::registerTextFunction( function() {
	// @codeCoverageIgnoreStart
	$args = func_get_args();
	$key = array_shift( $args );
	$language = array_shift( $args );
	$message = new \Message( $key, $args );
	return $message->inLanguage( $language )->text();
	// @codeCoverageIgnoreEnd
} );

// Resource Loader module registration
$GLOBALS['wgResourceModules'] = array_merge(
	$GLOBALS['wgResourceModules'],
	include( __DIR__ . '/js/resources.php' )
);
