<?php

/**
 * Definition of 'DataTypes' ResourceLoader modules.
 *
 * @license GPL-2.0+
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 * @author H. Snater < mediawiki@snater.com >
 *
 * @codeCoverageIgnoreStart
 */
return call_user_func( function() {
	preg_match( '+' . preg_quote( DIRECTORY_SEPARATOR ) . '(?:vendor|extensions)'
		. preg_quote( DIRECTORY_SEPARATOR ) . '.*+', __DIR__, $remoteExtPath );

	$moduleTemplate = [
		'localBasePath' => __DIR__,
		'remoteExtPath' => '..' . $remoteExtPath[0],
	];

	return [
		'dataTypes.__namespace' => $moduleTemplate + [
			'scripts' => 'dataTypes/__namespace.js',
		],

		'dataTypes.DataType' => $moduleTemplate + [
			'scripts' => 'dataTypes/DataType.js',
			'dependencies' => 'dataTypes.__namespace',
		],

		'dataTypes.DataTypeStore' => $moduleTemplate + [
			'scripts' => 'dataTypes/DataTypeStore.js',
			'dependencies' => [
				'dataTypes.__namespace',
				'dataTypes.DataType',
			],
		],
	];

} );
