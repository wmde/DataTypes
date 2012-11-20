<?php

namespace DataTypes;
use ResourceLoaderModule, ResourceLoaderContext;

/**
 * @since 0.2
 *
 * @file
 * @ingroup Wikibase
 *
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 */
class DataTypesModule extends ResourceLoaderModule {

	/**
	 * Used to propagate available data type ids to JavaScript.
	 * Data type ids will be available in 'wbDataTypeIds' config var.
	 * @see ResourceLoaderModule::getScript
	 *
	 * @since 0.2
	 *
	 * @param \ResourceLoaderContext $context
	 *
	 * @return string
	 */
	public function getScript( ResourceLoaderContext $context ) {
		$types = array();

		foreach ( DataTypeFactory::singleton()->getTypes() as $type ) {
			$types[ $type->getId() ] = $type->getDataValueType();
		}

		return 'mediaWiki.config.set( "wbDataTypes", ' . \FormatJson::encode( $types ) . ' );';
	}
}