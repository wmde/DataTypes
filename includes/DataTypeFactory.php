<?php

namespace DataTypes;

use InvalidArgumentException;
use OutOfBoundsException;

/**
 * Factory for creating data types.
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
final class DataTypeFactory {

	/**
	 * Maps type id to DataType.
	 *
	 * @since 0.1
	 *
	 * @var DataType[]
	 */
	protected $types = array();

	/**
	 * @since 0.1
	 */
	public function __construct( array $dataTypes = array() ) {
		foreach ( $dataTypes as $typeId => $typeData ) {
			$this->registerDataType( $this->newType( $typeId, $typeData ) );
		}
	}

	/**
	 * @since 0.1
	 *
	 * @param DataType[] $dataTypes
	 *
	 * @return DataTypeFactory
	 */
	public static function newFromTypes( array $dataTypes ) {
		$factory = new self();

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
	 * Returns a new instance of DataType constructed from the
	 * provided type data.
	 *
	 * @since 0.1
	 *
	 * @param string $typeId
	 * @param array $typeData
	 *
	 * @return DataType
	 * @throws InvalidArgumentException
	 */
	protected function newType( $typeId, array $typeData ) {
		if ( !array_key_exists( 'datavalue', $typeData ) || !is_string( $typeData['datavalue'] ) ) {
			throw new InvalidArgumentException( 'Invalid datavalue type provided to DataTypeFactory' );
		}

		// TODO: use string ids for components once they have their own factories

		// TODO: cleanup this whole method

		$parser = array_key_exists( 'parser', $typeData ) ? $typeData['parser'] : 'ValueParsers\NullParser';

		if ( is_string( $parser ) ) {
			$parser = new $parser();
		}

		$formatters = array();

		if ( array_key_exists( 'formatter', $typeData ) ) {
			$formatter = $typeData['formatter'];

			if ( is_string( $formatter ) ) {
				$formatter = new $formatter();
			}

			$formatters[] = $formatter;
		}

		if ( array_key_exists( 'validators', $typeData ) ) {
			$validators = is_array( $typeData['validators'] ) ? $typeData['validators'] : array( $typeData['validators'] );
		}
		else {
			$validators = array();
		}

		foreach ( $validators as &$validator ) {
			if ( is_string( $validator ) ) {
				$validator = new $validator();
			}
		}

		return new DataType(
			$typeId,
			$typeData['datavalue'],
			array( $parser ), // TODO
			$formatters,
			$validators
		);
	}

	/**
	 * Returns the type identifiers.
	 *
	 * @since 0.1
	 *
	 * @return string[] $typeId
	 */
	public function getTypeIds() {
		return array_keys( $this->types );
	}

	/**
	 * Returns the data type that has the specified type identifier
	 * or null if there is no such data type.
	 *
	 * @since 0.1
	 *
	 * @param string $typeId
	 *
	 * @return DataType
	 * @throws OutOfBoundsException
	 */
	public function getType( $typeId ) {
		if ( array_key_exists( $typeId, $this->types ) ) {
			return $this->types[$typeId];
		}

		throw new OutOfBoundsException( "Cannot obtain non-registered type id '$typeId'" );
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
		return $this->types;
	}

}
