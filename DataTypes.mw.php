<?php

/**
 * MediaWiki entry point for the DataTypes extension.
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

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( !defined( 'DATAVALUES' ) ) {
	define( 'DATAVALUES', true );
}

include __DIR__ . '/DataTypes.php';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DataTypes',
	'version' => DataTypes_VERSION,
	'author' => array( '[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:DataTypes',
	'descriptionmsg' => 'datatypes-desc',
);

$wgExtensionMessagesFiles['DataTypes'] = __DIR__ . '/DataTypes.i18n.php';

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
	$testFiles = array(

	);

	foreach ( $testFiles as $file ) {
		$files[] = __DIR__ . '/tests/' . $file . 'Test.php';
	}

	return true;
};