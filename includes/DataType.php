<?php

namespace DataTypes;

use InvalidArgumentException;
use ValueFormatters\ValueFormatter;
use ValueParsers\ValueParser;
use ValueValidators\ValueValidator;

/**
 * Interface for data types.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @since 0.1
 *
 * @file
 * @ingroup DataTypes
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
	 * The ValueFormatter used by this data type.
	 *
	 * @since 0.1
	 *
	 * @var ValueFormatter[]
	 */
	protected $formatters;

	/**
	 * The ValueValidator objects used by this data type.
	 *
	 * @since 0.1
	 *
	 * @var ValueValidator[]
	 */
	protected $validators;

	/**
	 * Constructor.
	 * Typically you should not construct such objects yourself but use the TypeFactory.
	 *
	 * @since 0.1
	 *
	 * @param string $typeId
	 * @param string $dataValueType
	 * @param ValueParser[] $parsers // TODO: remove
	 * @param ValueFormatter[] $formatters
	 * @param ValueValidator[] $validators
	 *
	 * @throws InvalidArgumentException
	 */
	public function __construct( $typeId, $dataValueType, array $parsers, array $formatters, array $validators ) {
		if ( !is_string( $typeId ) ) {
			throw new InvalidArgumentException( '$typeId must be a string' );
		}

		if ( !is_string( $dataValueType ) ) {
			throw new InvalidArgumentException( '$dataValueType must be a string' );
		}

		$this->typeId = $typeId;
		$this->dataValueType = $dataValueType;
		$this->formatters = $formatters;
		$this->validators = $validators;
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
	 * Returns the ValueFormatter used by this data type.
	 *
	 * TODO: finish design and decide on the exact role of this and if we do not need multiple
	 *
	 * @since 0.1
	 *
	 * @return ValueFormatter[]
	 */
	public function getFormatters() {
		return $this->formatters;
	}

	/**
	 * Returns the ValueValidators that are supported by this data type.
	 *
	 * @since 0.1
	 *
	 * @return ValueValidator[]
	 */
	public function getValidators() {
		return $this->validators;
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
	 * @see DataType::toArray
	 *
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
