<?php

/**
 * MediaWiki setup for the DataTypes library.
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$GLOBALS['wgMessagesDirs']['DataTypes'] = __DIR__ . '/i18n';

$GLOBALS['wgHooks']['UnitTestsList'][] = function( array &$paths ) {
	$paths[] = __DIR__ . '/tests/Modules/';
	$paths[] = __DIR__ . '/tests/Phpunit/';
};

// Resource Loader module registration
$GLOBALS['wgResourceModules'] = array_merge(
	$GLOBALS['wgResourceModules'],
	include __DIR__ . '/js/resources.php'
);
