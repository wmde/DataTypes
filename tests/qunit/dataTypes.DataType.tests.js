/**
 * QUnit tests for DataType construtor and instances.
 *
 * @since 0.1
 * @file
 * @ingroup DataTypes
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 */

( function( dt, $, QUnit ) {
	'use strict';

	var DataType = dt.DataType;

	QUnit.module( 'dataTypes.DataType.tests' );

	var instanceDefinitions = [
		{
			title: 'simple DataType',
			constructorParams: [ 'foo', 'string' ],
			valueType: 'string'
		}, {
			title: 'another simple datatype',
			constructorParams: [ 'bar', 'bool' ],
			valueType: 'bool'
		}
	];

	function instanceFromDefinition( definition ) {
		var cp = definition.constructorParams;
		return new DataType( cp[0], cp[1] );
	}

	QUnit
	.cases( instanceDefinitions )
		.test( 'constructor', function( params, assert ) {
			var dataType = instanceFromDefinition( params );

			assert.ok(
				dataType instanceof DataType,
				'New data type created and instance of DataType'
			);
		} )
		.test( 'getId', function( params, assert ) {
			var dataType = instanceFromDefinition( params );

			assert.strictEqual(
				dataType.getId(),
				params.constructorParams[0],
				'getId() returns string ID provided in constructor'
			);
		} )
		.test( 'getDataValueType', function( params, assert ) {
			var dataType = instanceFromDefinition( params ),
				dvType = dataType.getDataValueType();

			assert.equal(
				typeof dvType,
				'string',
				'getDataValueType() returns string'
			);

			assert.ok(
				dvType !== '',
				'string returned by getDataValueType() is not empty'
			);
		} );

	QUnit
	.cases( [
		{
			title: 'no arguments',
			constructorParams: []
		}, {
			title: 'missing data value type',
			constructorParams: [ 'foo' ]
		}
	] )
		.test( 'invalid construtor arguments', function( params, assert ) {
			assert.throws(
				function() {
					instanceFromDefinition( params );
				},
				'DataType can not be constructed from invalid arguments'
			);
		} );

}( dataTypes, jQuery, QUnit ) );
