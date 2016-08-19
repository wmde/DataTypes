<?php

/**
 * Entry point for the DataTypes library.
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

namespace DataTypes;

if ( defined( 'DataTypes_VERSION' ) ) {
	// Do not initialize more than once.
	return 1;
}

define( 'DataTypes_VERSION', '0.5.2' );

if ( defined( 'MEDIAWIKI' ) ) {
	include __DIR__ . '/DataTypes.mw.php';
}
