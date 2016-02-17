<?php

namespace DataTypes;

use InvalidArgumentException;

/**
 * @since 0.1
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataType {

	/**
	 * Identifier for the data type.
	 *
	 * @since 0.1
	 *
	 * @var string
	 */
	protected $typeId;

	/**
	 * Identifier for the type of the DataValue.
	 *
	 * @since 0.1
	 *
	 * @var string
	 */
	protected $dataValueType;

	/**
	 * @since 0.5
	 *
	 * @param string $typeId
	 * @param string $dataValueType
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $typeId, $dataValueType ) {
		if ( !is_string( $typeId ) ) {
			throw new InvalidArgumentException( '$typeId must be a string' );
		}

		if ( !is_string( $dataValueType ) ) {
			throw new InvalidArgumentException( '$dataValueType must be a string' );
		}

		$this->typeId = $typeId;
		$this->dataValueType = $dataValueType;
	}

	/**
	 * Returns the identifier of this data type.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getId() {
		return $this->typeId;
	}

	/**
	 * Returns the type of the DataValue used by this data type.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDataValueType() {
		return $this->dataValueType;
	}

	/**
	 * Returns the label of the data type in the provided language or null if there is none.
	 *
	 * @since 0.1
	 *
	 * @param string $langCode
	 *
	 * @return string|null
	 */
	public function getLabel( $langCode ) {
		return Message::text( 'datatypes-type-' . $this->getId(), $langCode );
	}

	/**
	 * @since 0.1
	 *
	 * @return array
	 */
	public function toArray() {
		return array(
			'dataValueType' => $this->dataValueType
		);
	}

}
