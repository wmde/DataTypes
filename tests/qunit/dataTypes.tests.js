/**
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 */
define( ['qunit', 'jquery', 'dataTypes/dataTypes'], function( QUnit, $, dt ) {
	'use strict';

	QUnit.module( 'dataTypes' );

	QUnit.test( 'Test initializing a DataType object', function( assert ) {
		// create new data type for testing and register it:
		var testDataType = new dt.DataType( 'foo', 'fooDataValueType' ),
			testDataTypeId = testDataType.getId();

		dt.registerDataType( testDataType );

		assert.ok(
			dt.hasDataType( testDataTypeId ),
			'hasDataType: Data type "' + testDataTypeId + '" is available after registering it'
		);

		assert.ok(
			$.inArray( dt.getDataTypeIds(), testDataTypeId ),
			'getDataTypes: Data type "' + testDataTypeId + '" is available.'
		);

		assert.ok(
			testDataType === dt.getDataType( testDataTypeId ),
			'getDataType: returns exact same instance of the data type which was registered before'
		);
	} );

} );
