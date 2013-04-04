<?php

namespace DataTypes;

use ResourceLoaderContext;
use ResourceLoaderModule;

/**
 * @since 0.1
 *
 * @file
 * @ingroup Wikibase
 *
 * @licence GNU GPL v2+
 * @author H. Snater < mediawiki@snater.com >
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 */
class DataTypesModule extends ResourceLoaderModule {

	protected $dataTypes;

	/**
	 * @since 0.1
	 */
	public function __construct() {
		$factory = new DataTypeFactory( $GLOBALS['wgDataTypes'] );
		$this->dataTypes = $factory->getTypes();
	}

	/**
	 * Used to propagate available data type ids to JavaScript.
	 * Data type ids will be available in 'wbDataTypeIds' config var.
	 * @see ResourceLoaderModule::getScript
	 *
	 * @since 0.1
	 *
	 * @param \ResourceLoaderContext $context
	 *
	 * @return string
	 */
	public function getScript( ResourceLoaderContext $context ) {
		$typesJson = array();

		foreach( $this->dataTypes as $dataType ) {
			$typesJson[ $dataType->getId() ] = $dataType->toArray();
		}

		return 'mediaWiki.config.set( "wbDataTypes", ' . \FormatJson::encode( $typesJson ) . ' );';
	}

	/**
	 * Returns the message keys of the registered data types.
	 * @see ResourceLoaderModule::getMessages
	 * @since 0.1
	 *
	 * @return Array
	 */
	public function getMessages() {
		$messageKeys = array();

		foreach( $this->dataTypes as $dataType ) {
			// TODO: currently we assume that the type is using a message while it does not have to.
			//  Either change the system to ensure that a message is used or put the type labels
			//  directly into the JSON. Either way, the information should be in DataType::toArray.
			$messageKeys[] = 'datatypes-type-' . $dataType->getId();
		}

		return $messageKeys;
	}
}