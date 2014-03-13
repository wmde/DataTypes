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
	$remoteExtPathParts = explode(
		DIRECTORY_SEPARATOR . 'extensions' . DIRECTORY_SEPARATOR, __DIR__, 2
	);

	$moduleTemplate = array(
		'localBasePath' => __DIR__ . '/js',
		'remoteExtPath' => $remoteExtPathParts[1] . '/js',
	);

	return array(
		'dataTypes' => $moduleTemplate + array(
			'scripts' => 'dataTypes.js', // also contains dataType.DataType constructor
		),
	);

} );
