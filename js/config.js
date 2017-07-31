/**
 * RequireJS configuration
 * Basic RequireJS configuration object expanded with the list of test modules.
 *
 * @license GPL-2.0+
 * @author H. Snater < mediawiki@snater.com >
 */
this.config = ( function () {
	'use strict';

	return {
		baseUrl: '..',
		paths: {
			jquery: 'js/lib/jquery/jquery',
			qunit: 'js/lib/qunit/qunit',
			'qunit.parameterize': 'js/lib/qunit.parameterize/qunit.parameterize',
			dataTypes: 'js/dataTypes'
		},
		shim: {
			qunit: {
				exports: 'QUnit',
				init: function () {
					QUnit.config.autoload = false;
					QUnit.config.autostart = false;
				}
			},

			'qunit.parameterize': {
				exports: 'QUnit.cases',
				deps: [ 'qunit' ]
			},

			'dataType/__namespace': {
				exports: 'dataTypes'
			},

			'dataTypes/DataType': {
				exports: 'dataTypes',
				deps: [ 'jquery', 'dataTypes/__namespace', 'qunit.parameterize' ]
			},

			'dataTypes/DataTypeStore': {
				exports: 'dataTypes',
				deps: [ 'jquery', 'dataTypes/__namespace', 'dataTypes/DataType' ]
			}
		},
		tests: [
			'tests/qunit/dataTypes/DataType.tests',
			'tests/qunit/dataTypes/DataTypeStore.tests'
		]
	};

}() );
