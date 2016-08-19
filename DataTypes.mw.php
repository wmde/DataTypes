<?php

/**
 * MediaWiki setup for the DataTypes library.
 *
 * @license GPL-2.0+
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
		'The Wikidata team',
	),
	'url' => 'https://github.com/wmde/DataTypes',
	'descriptionmsg' => 'datatypes-desc',
	'license-name' => 'GPL-2.0+'
);

$GLOBALS['wgMessagesDirs']['DataTypes'] = __DIR__ . '/i18n';

$GLOBALS['wgHooks']['UnitTestsList'][] = function( array &$paths ) {
	$paths[] = __DIR__ . '/tests/Modules/';
	$paths[] = __DIR__ . '/tests/Phpunit/';

	return true;
};

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
	include __DIR__ . '/js/resources.php'
);
