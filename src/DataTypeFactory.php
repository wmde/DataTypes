<?php

namespace DataTypes;

use OutOfBoundsException;
use InvalidArgumentException;

/**
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Daniel Kinzler
 */
class DataTypeFactory {

	/**
	 * Maps type id to DataType.
	 *
	 * @var DataType[]
	 */
	private $types = array();

	/**
	 * @var string[]
	 */
	private $valueTypes = array();

	/**
	 * @since 0.5
	 *
	 * @param string[] $valueTypes
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( array $valueTypes ) {
		foreach ( $valueTypes as $valueType ) {
			if ( !is_string( $valueType ) ) {
				throw new InvalidArgumentException( '$valueTypes needs to be an array of string' );
			}
		}

		$this->valueTypes = $valueTypes;
	}

	/**
	 * @since 0.1
	 *
	 * @param DataType[] $dataTypes
	 *
	 * @return DataTypeFactory
	 */
	public static function newFromTypes( array $dataTypes ) {
		$factory = new self( array() );

		foreach ( $dataTypes as $dataType ) {
			$factory->registerDataType( $dataType );
		}

		return $factory;
	}

	/**
	 * @since 0.1
	 *
	 * @param DataType $dataType
	 */
	public function registerDataType( DataType $dataType ) {
		$this->types[$dataType->getId()] = $dataType;
	}

	/**
	 * Returns the type identifiers.
	 *
	 * @since 0.1
	 *
	 * @return string[]
	 */
	public function getTypeIds() {
		return array_keys( $this->valueTypes );
	}

	/**
	 * Returns the data type that has the specified type identifier.
	 * Types may be instantiated on the fly using a type builder spec.
	 *
	 * @since 0.1
	 *
	 * @param string $typeId
	 *
	 * @throws OutOfBoundsException if the requested type is not known.
	 * @return DataType
	 */
	public function getType( $typeId ) {
		if ( !array_key_exists( $typeId, $this->types ) ) {
			if ( !array_key_exists( $typeId, $this->valueTypes ) ) {
				throw new OutOfBoundsException( "Unknown data type '$typeId'" );
			}

			$valueType = $this->valueTypes[$typeId];
			$this->types[$typeId] = new DataType( $typeId, $valueType );
		}

		return $this->types[$typeId];
	}

	/**
	 * Returns all data types in an associative array with
	 * the keys being type identifiers pointing to their
	 * corresponding data type.
	 *
	 * @since 0.1
	 *
	 * @return DataType[]
	 */
	public function getTypes() {
		$types = array();

		foreach ( $this->getTypeIds() as $typeId ) {
			$types[] = $this->getType( $typeId );
		}

		return $types;
	}

}
