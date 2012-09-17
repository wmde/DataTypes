<?php

include __DIR__ . '/DataTypes.php';

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'DataTypes',
	'version' => DataTypes_VERSION,
	'author' => array( '[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw]' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:DataTypes',
	'descriptionmsg' => 'datatypes-desc',
);
