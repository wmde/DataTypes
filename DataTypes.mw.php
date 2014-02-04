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

/**
 * Hook to add QUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ResourceLoaderTestModules
 * @since 0.1
 *
 * @param array &$testModules
 * @param \ResourceLoader &$resourceLoader
 * @return boolean
 */
$GLOBALS['wgHooks']['ResourceLoaderTestModules'][] = function ( array &$testModules, \ResourceLoader &$resourceLoader ) {
	$remoteExtPathParts = explode( DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR , __DIR__, 2 );

	$moduleTemplate = array(
		'localBasePath' => __DIR__ . '/tests/qunit',
		'remoteExtPath' => $remoteExtPathParts[1] . '/tests/qunit',
	);

	$testModules['qunit']['dataTypes.tests'] = $moduleTemplate + array(
		'scripts' => array(
			'dataTypes.tests.js',
		),
		'dependencies' => array(
			'dataTypes',
		),
	);

	$testModules['qunit']['dataTypes.DataType.tests'] = $moduleTemplate + array(
		'scripts' => array(
			'dataTypes.DataType.tests.js',
		),
		'dependencies' => array(
			'dataTypes',
			'qunit.parameterize',
		),
	);

	return true;
};

// Resource Loader module registration
$GLOBALS['wgResourceModules'] = array_merge(
	$GLOBALS['wgResourceModules'],
	include( __DIR__ . '/DataTypes.resources.php' )
);
