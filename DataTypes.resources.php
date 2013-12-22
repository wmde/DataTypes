<?php

/**
 * Definition of 'DataTypes' resourceloader modules.
 * When included this returns an array with all modules introduced by the 'DataTypes' extension.
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 *
 * @codeCoverageIgnoreStart
 */
return call_user_func( function() {

	$moduleTemplate = array(
		'localBasePath' => __DIR__ . '/resources',
		'remoteExtPath' => '../vendor/data-values/data-types/resources',
	);

	return array(
		'dataTypes' => $moduleTemplate + array(
			'scripts' => 'dataTypes.js', // also contains dataType.DataType constructor
			'dependencies' => array(
				'dataValues.DataValue',
				'valueParsers'
			),
		),
	);

} );
// @codeCoverageIgnoreEnd
