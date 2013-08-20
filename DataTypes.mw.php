<?php

/**
 * MediaWiki setup for the DataTypes extension.
 *
 * @since 0.1
 *
 * @file
 * @ingroup DataTypes
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

namespace DataTypes;

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

global $wgExtensionCredits, $wgExtensionMessagesFiles, $wgHooks, $wgResourceModules;

$wgExtensionCredits['datavalues'][] = array(
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

$wgExtensionMessagesFiles['DataTypes'] = __DIR__ . '/DataTypes.i18n.php';

if ( defined( 'MW_PHPUNIT_TEST' ) ) {
	require_once __DIR__ . '/tests/testLoader.php';
}

/**
 * Hook to add PHPUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/UnitTestsList
 *
 * @since 0.1
 *
 * @param array $files
 *
 * @return boolean
 */
$wgHooks['UnitTestsList'][] = function( array &$files ) {
	// @codeCoverageIgnoreStart
	$directoryIterator = new \RecursiveDirectoryIterator( __DIR__ . '/tests/phpunit/' );

	/**
	 * @var \SplFileInfo $fileInfo
	 */
	foreach ( new \RecursiveIteratorIterator( $directoryIterator ) as $fileInfo ) {
		if ( substr( $fileInfo->getFilename(), -8 ) === 'Test.php' ) {
			$files[] = $fileInfo->getPathname();
		}
	}

	return true;
	// @codeCoverageIgnoreEnd
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

/**
 * Hook to add QUnit test cases.
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ResourceLoaderTestModules
 * @since 0.1
 *
 * @param array &$testModules
 * @param \ResourceLoader &$resourceLoader
 * @return boolean
 */
$wgHooks['ResourceLoaderTestModules'][] = function ( array &$testModules, \ResourceLoader &$resourceLoader ) {
	$moduleTemplate = array(
		'localBasePath' => __DIR__ . '/tests/qunit',
		'remoteExtPath' => 'DataValues/DataTypes/tests/qunit',
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
			'dataValues.values',
			'qunit.parameterize',
		),
	);

	return true;
};

// Resource Loader module registration
$wgResourceModules = array_merge(
	$wgResourceModules,
	include( __DIR__ . '/Resources.php' )
);
