<?php

/**
 * MediaWiki setup for the DataTypes extension.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
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

global $wgExtensionCredits, $wgExtensionMessagesFiles, $wgAutoloadClasses, $wgHooks, $wgResourceModules;

$wgExtensionCredits['datavalues'][] = array(
	'path' => __DIR__,
	'name' => 'DataTypes',
	'version' => DataTypes_VERSION,
	'author' => array(
		'[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]',
		'[https://www.mediawiki.org/wiki/User:Danwe Daniel Werner]'
	),
	'url' => 'https://www.mediawiki.org/wiki/Extension:DataTypes',
	'descriptionmsg' => 'datatypes-desc',
);

$wgExtensionMessagesFiles['DataTypes'] = __DIR__ . '/DataTypes.i18n.php';

// modules
$wgAutoloadClasses['DataTypes\DataTypesModule'] = __DIR__ . '/' . 'includes/modules/DataTypesModule.php';

foreach ( include( __DIR__ . '/DataTypes.classes.php' ) as $class => $file ) {
	if ( !array_key_exists( $class, $GLOBALS['wgAutoloadLocalClasses'] ) ) {
		$wgAutoloadClasses[$class] = __DIR__ . '/' . $file;
	}
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
	$testFiles = array(
		'includes/DataType',

		'includes/DataTypeFactory',
	);

	foreach ( $testFiles as $file ) {
		$files[] = __DIR__ . '/tests/' . $file . 'Test.php';
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
		'localBasePath' => __DIR__,
		'remoteExtPath' => 'DataValues/DataTypes',
	);

	$testModules['qunit']['dataTypes.jquery.valueview.tests'] = $moduleTemplate + array(
		'scripts' => array(
			'tests/qunit/dataTypes.tests.js',
			'tests/qunit/jquery.valueview.tests.js'
		),
		'dependencies' => array(
			'dataTypes.jquery.valueview',
		),
	);

	$testModules['qunit']['dataTypes.jquery.eachchange.tests'] = $moduleTemplate + array(
		'scripts' => array(
			'tests/qunit/jquery.eachchange.tests.js',
		),
		'dependencies' => array(
			'jquery.eachchange',
		),
	);

	$testModules['qunit']['dataTypes.jquery.inputAutoExpand.tests'] = $moduleTemplate + array(
		'scripts' => array(
			'tests/qunit/jquery/jquery.inputAutoExpand.tests.js',
		),
		'dependencies' => array(
			'jquery.inputAutoExpand',
		),
	);

	return true;
};

// Resource Loader module registration
$wgResourceModules = array_merge(
	$wgResourceModules,
	include( __DIR__ . '/Resources.php' )
);
