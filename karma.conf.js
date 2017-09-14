module.exports = function ( config ) {
	config.set( {
		frameworks: [ 'qunit' ],

		files: [
			'node_modules/jquery/dist/jquery.js',
			'js/dataTypes/__namespace.js',
			'js/dataTypes/DataType.js',
			'js/dataTypes/DataTypeStore.js',
			'tests/qunit/dataTypes/*.js'
		],

		port: 9876,

		logLevel: config.LOG_INFO,
		browsers: [ 'PhantomJS' ]
	} );
};
