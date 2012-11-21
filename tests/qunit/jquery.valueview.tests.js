/**
 * QUnit tests for jQuery.valueview
 * @see https://www.mediawiki.org/wiki/Extension:Wikibase
 *
 * @since 0.1
 * @file
 * @ingroup DataTypes
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner
 */

( function( dt, dv, $, QUnit, undefined ) {
	'use strict';

	QUnit.module( 'dataTypes.jquery.valueview.tests', QUnit.newMwEnvironment() );

var // TEST HELPERS
	/**
	 * Test DataValue which as no valueview associated
	 * @Constructor
	 * @extends dv.StringValue
	 */
	WithoutViewDataValue = dv.util.inherit( dv.StringValue, {
		getType: function() { return 'test_withoutView'; }
	} ),

	SomeDataValue = dv.util.inherit( dv.StringValue, {
		getType: function() { return 'test_some'; }
	} ),

	dtWithoutView = new dt.DataType(
		'dtWithoutView',
		WithoutViewDataValue.prototype.getType(),
		null, null, null
	);

	// ACTUAL TESTS:

	QUnit.test( 'Initial tests on whether facilities for creating valueview views are available', function( assert ) {
		assert.ok(
			$.valueview !== undefined,
			'jQuery.valueview namespace is defined'
		);

		assert.ok(
			$.isFunction( $.fn.valueview ),
			'jQuery prototype has the valueview function'
		);

		assert.ok(
			$( ':valueview' ),
			"jQuery( ':valueview' ) selector has been registered (can be used without throwing an error)"
		);
	} );

	/**
	 * @todo this test should probably be part of all valueview view tests and therefore be in an
	 *       abstract test definition.
	 */
	QUnit.test( 'registering new valueview views with jquery.valueview.widget()', function( assert ) {
		// create data type we want to create a view for
		var fooType = new dt.DataType( 'fooTypeId', 'test_some', null, null, null );

		// register new valueview view widget for all data types using data values of type 'test_some'
		$.valueview.widget( 'foo', {
			dataValueType: fooType.getDataValueType(),
			/**
			 * Function for testing, will simply execute a given function and return whatever that
			 * function will return.
			 * @param {Function} func
			 */
			someTestFunc: function( func ) {
				return func.call( this );
			}
		} );

		assert.ok(
			$.isFunction( $.valueview.foo )
			&& $.valueview.foo.prototype.dataValueType === fooType.getDataValueType(),
			"Constructor for new valueview view widget 'foo' has been created."
		);

		assert.ok(
			$.isFunction( $.fn.valueview_foo ),
			'jQuery prototype has been extended with bridge to the new valueview widget'
		);

		assert.ok(
			$( ':valueview_foo' ),
			"jQuery( ':valueview_foo' ) selector has been registered (can be used without throwing an error)"
		);

		var tests = [
			[
				'valueview',
				{
					on: fooType
				}
			],
			[ 'valueview_foo' ]
		];

		// test everything for both, $.fn.valueview and the bridge created for the specific view!
		$.each( tests, function( i, val ) {
			var fnName = this[0],
				fullFnName = 'jQuery.fn.' + fnName,
				options = this[1] || {},
				$nodes = $( '<div></div><span></span>' ), // init widget on these TWO nodes!
				msgPrefix = "valueview Widget initialized with '" + fullFnName + "': ";

			assert.ok(
				$nodes[ fnName ]( options ) instanceof $,
				'Initialized valueview view on both nodes with ' + fullFnName + '. jQuery object was returned.'
			);

			assert.ok(
				$nodes.data( fnName ) !== undefined
				&& $nodes.data( fnName ) instanceof $.valueview.foo,
				msgPrefix + "jQuery.fn.data( '" + fnName + "' ) returns the widget Instance"
			);

			assert.ok(
				$nodes.data( 'valueview' ) === $nodes.data( 'valueview_foo' ),
				msgPrefix + "jQuery.fn.data( 'valueview' ) equals jQuery.fn.data( 'valueview_foo' ) on the widgets node"
			);

			assert.equal(
				$nodes.add( $( '<span/>' ) ).filter( ':valueview' ).length,
				2,
				msgPrefix + 'sizzle ":valueview" selector for filtering the widget node is working'
			);

			assert.equal(
				$nodes.add( $( '<span/>' ) ).filter( ':valueview_foo' ).length,
				2,
				msgPrefix + 'sizzle ":valueview_foo" selector for filtering the widget node is working'
			);

			/**
			 * Executes a value view widget function for all widgets in $nodes, check whether the
			 * return value will invoke the right behavior, e.g. stopping execution for the next
			 * widget and instead returning the value.
			 *
			 * @param {Function} func Will be executed by the widget, context is the widget object.
			 * @param {Number} expectedExecutions On how many widgets is the execution expected?
			 * @param {String} executionsDescr Description for the first test, checking the number
			 *        of executions.
			 * @param {mixed} expectedResult The expected overall result.
			 * @param {String} returnDescr Description for second test which compares the result.
			 */
			var testFunctionInvocation =
				function( func, expectedExecutions, executionsDescr, expectedResult, returnDescr ) {
					var i = 0;
					var result = $nodes[ fnName ]( 'someTestFunc', function() {
						i++;
						return func.apply( this, arguments );
					} );

					// check for number of widgets the function has been executed on:
					assert.equal( i, expectedExecutions, executionsDescr );

					// check the result returned by the called bridge:
					assert.equal(
						result,
						expectedResult || $nodes,
						returnDescr || 'The jQuery object has been returned.'
					);
				};

			testFunctionInvocation(
				$.noop,
				2,
				'Executing a function via $nodes.' + fnName + "('function') will execute the" +
					" function for all widgets appended to DOM nodes in $nodes."
			);

			testFunctionInvocation(
				function() { return this; },
				2,
				"Same as before, but function is returning the widget node - this shouldn't change the outcome."
			);

			var someObj = {};
			testFunctionInvocation(
				function() { return someObj; },
				1,
				'Executing a function via $nodes.' + fnName + "('function') with the function" +
					" returning a special value. The value returned by the function called on the" +
					" first widget has been returned. The function was not called on the other widget.",
				someObj, // expected result
				'The value returned by the function call on the first widget was returned.'
			);
		} );
	} );

	QUnit.test( 'expected jQuery.fn.valueview.widget errors', function( assert ) {
		assert.throws(
			function() {
				$.valueview.widget( 'foo' );
			},
			"Can't create a valueview view without prototype definition"
		);

		assert.throws(
			function() {
				$.valueview.widget( 'foo', {} );
			},
			"Can't create a valueview view without 'dataValueType' property"
		);

		assert.throws(
			function() {
				$.valueview.widget( 'foo', {
					dataValueType: 'foo'
				}, {} );
			},
			"Can't create a valueview view deriving from a prototype not inheriting from jQuery.valueview.Widget"
		);
	} );

	QUnit.test( 'expected jQuery.fn.valueview errors', function( assert ) {
		var $node = $( '<div/>' );

		assert.throws(
			function() {
				$node.valueview();
			},
			'calling jQuery.fn.valueview() without arguments will thrown an error'
		);

		var dvWithoutView = new WithoutViewDataValue( 'foo' );
		assert.throws(
			function() {
				$node.valueview( dvWithoutView );
			},
			'calling jQuery.fn.valueview() with an instance of a DataValue whose type has no view registered will fail'
		);

		assert.throws(
			function() {
				$node.valueview( dtWithoutView );
			},
			'calling jQuery.fn.valueview() with a DataType having a data value type no view is registered for will fail'
		);
	} );

}( dataTypes, dataValues, jQuery, QUnit ) );
