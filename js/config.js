/**
 * RequireJS configuration
 * Basic RequireJS configuration object expanded with the list of test modules.
 *
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 */
this.config = ( function() {
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
				init: function() {
					QUnit.config.autoload = false;
					QUnit.config.autostart = false;
				}
			},

			'qunit.parameterize': {
				exports: 'QUnit.cases',
				deps: ['qunit']
			},

			'dataTypes/DataType': {
				exports: 'dataTypes',
				deps: ['jquery', 'qunit.parameterize']
			},

			'dataTypes/DataTypeStore': {
				exports: 'dataTypes',
				deps: ['jquery', 'dataTypes/DataType']
			}
		},
		tests: [
			'tests/qunit/dataTypes/DataType.tests',
			'tests/qunit/dataTypes/DataTypeStore.tests'
		]
	};

} )();
