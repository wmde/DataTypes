<?php
/**
 * Definition of 'DataTypes' resourceloader modules.
 * When included this returns an array with all modules introduced by the 'DataTypes' extension.
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
 * @author Daniel Werner
 *
 * @codeCoverageIgnoreStart
 */
return call_user_func( function() {

	$moduleTemplate = array(
		'localBasePath' => __DIR__ . '/resources',
		'remoteExtPath' =>  'DataValues/DataTypes/resources',
	);

	return array(
		'dataTypes' => $moduleTemplate + array(
			'scripts' => 'dataTypes.js', // also contains dataType.DataType constructor
			'dependencies' => array(
				'dataTypes.dataTypesModule',
				'dataValues',
				'valueParsers'
			),
		),

		'dataTypes.jquery.valueview' => $moduleTemplate + array(
			'scripts' => array(
				'jquery.valueview.js',
				'jquery.valueview.Widget.js',
				'jquery.valueview.PersistentDomWidget.js',
				'jquery.valueview.SingleInputWidget.js',
				'jquery.valueview.LinkedSingleInputWidget.js'
			),
			'dependencies' => array(
				'jquery.ui.widget',
				'dataTypes',
				'dataValues.util',
				'dataValues.values',
				'valueParsers.parsers'
			),
			'styles' => array(
				'jquery.valueview.css',
			),
		),

		'dataTypes.jquery.valueview.views' => $moduleTemplate + array(
			'scripts' => array(
				'views/string.js',
				'views/commonsMedia.js',
			),
			'dependencies' => array(
				'dataTypes.jquery.valueview',
				'jquery.eachchange'
			),
		),

		'dataTypes.dataTypesModule' => $moduleTemplate + array(
			'class' => 'DataTypes\DataTypesModule',
		)
	);

} );
// @codeCoverageIgnoreEnd
