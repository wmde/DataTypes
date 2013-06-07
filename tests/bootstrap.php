<?php

/**
 * PHPUnit test bootstrap file for the DataTypes library.
 *
 * @since 0.1
 *
 * @file
 * @ingroup DataTypes
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

require_once( __DIR__ . '/../DataTypes.php' );

\DataTypes\Message::registerTextFunction( function() { return ''; } );

require_once( __DIR__ . '/testLoader.php' );
