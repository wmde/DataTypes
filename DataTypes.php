<?php

if ( !defined( 'DATAVALUES' ) ) {
	die( 'Not an entry point.' );
}

define( 'DataTypes_VERSION', '0.1' );

$wgDataTypes = array(
	'geo' => array(
		'datavalue' => 'geo-dv',
		'parser' => 'geo-parser',
		'formatter' => 'geo-formatter',
	),
	'positive-number' => array(
		'datavalue' => 'numeric-dv',
		'parser' => 'numeric-parser',
		'formatter' => 'numeric-formatter',
		'validators' => array( $rangeValidator ),
	),
);
