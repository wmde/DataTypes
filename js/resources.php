<?php

/**
 * Definition of 'DataTypes' ResourceLoader modules.
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 * @author H. Snater < mediawiki@snater.com >
 *
 * @codeCoverageIgnoreStart
 */
return call_user_func( function() {
	preg_match( '+' . preg_quote( DIRECTORY_SEPARATOR ) . '(?:vendor|extensions)'
		. preg_quote( DIRECTORY_SEPARATOR ) . '.*+', __DIR__, $remoteExtPath );

	$moduleTemplate = array(
		'localBasePath' => __DIR__,
		'remoteExtPath' => '..' . $remoteExtPath[0],
	);

	return array(
		'dataTypes.DataType' => $moduleTemplate + array(
			'scripts' => 'dataTypes/DataType.js',
		),

		'dataTypes.DataTypeStore' => $moduleTemplate + array(
			'scripts' => 'dataTypes/DataTypeStore.js',
			'dependencies' => array(
				'dataTypes.DataType',
			),
		),

	);

} );
