<?php

/**
 * Entry point for the DataTypes extension.
 * For usage as MediaWiki extension, use the DataTypes.mw.php entry point.
 *
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:DataTypes
 * Support					https://www.mediawiki.org/wiki/Extension_talk:DataTypes
 * Source code:				https://gerrit.wikimedia.org/r/gitweb?p=mediawiki/extensions/DataValues.git
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

/**
 * Files belonging to the DataTypes extension.
 *
 * @defgroup DataTypes DataTypes
 */

/**
 * Tests part of the DataTypes extension.
 *
 * @defgroup DataTypesTests DataTypesTests
 * @ingroup DataTypes
 */

if ( !defined( 'DATAVALUES' ) ) {
	die( 'Not an entry point.' );
}

define( 'DataTypes_VERSION', '0.1' );

$wgDataTypes = array(
//	'geo' => array(
//		'datavalue' => 'geo-dv',
//		'parser' => 'geo-parser',
//		'formatter' => 'geo-formatter',
//	),
//	'positive-number' => array(
//		'datavalue' => 'numeric-dv',
//		'parser' => 'numeric-parser',
//		'formatter' => 'numeric-formatter',
//		'validators' => array( $rangeValidator ),
//	),
);
