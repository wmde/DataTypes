/**
 * QUnit tests for jQuery.valueview
 * @see https://www.mediawiki.org/wiki/Extension:Wikibase
 *
 * @since 0.1
 * @file
 * @ingroup DataValues
 *
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 */

( function( mw, dt, dv, $, QUnit, undefined ) {
	'use strict';

	QUnit.module( 'dataTypes.dataTypes.tests', QUnit.newMwEnvironment() );

	QUnit.test( 'Test initializing a DataType object', function( assert ) {

		// TODO: remove dynamic loading as soon as the module gets loaded on page initialization
		QUnit.stop();

		mw.loader.using( 'dataTypes.DataType', function() {
			var testDataTypeId = 'commonsMedia';
			var testDataType = dt.newDataType( testDataTypeId );

			assert.ok(
				dt.hasDataType( testDataTypeId ),
				'hasDataType: Data type "' + testDataTypeId + '" is available.'
			);

			assert.ok(
				$.inArray( dt.getDataTypes(), testDataTypeId ),
				'getDataTypes: Data type "' + testDataTypeId + '" is available.'
			);

			assert.equal(
				testDataType.getId(),
				testDataTypeId,
				'Instantiated "' + testDataTypeId + '" data type.'
			);

			assert.equal(
				testDataType.getDataValueType(),
				'string',
				'Verified data value type.'
			);

			QUnit.start();

		} );

	} );

}( mediaWiki, dataTypes, dataValues, jQuery, QUnit ) );
