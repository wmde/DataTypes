<?php

namespace DataTypes;
use InvalidArgumentException;

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
class DataTypeFactory {

	/**
	 * Maps type id to DataType.
	 *
	 * @since 0.1
	 *
	 * @var DataType[]
	 */
	protected $types = array();

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct( array $dataTypes = array() ) {
		foreach ( $dataTypes as $typeId => $typeData ) {
			$this->types[$typeId] = $this->newType( $typeId, $typeData );
		}
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

//		$formatter = array_key_exists( 'formatter', $typeData ) ? $typeData['formatter'] : 'NullFormatter';
//		$formatter = new $formatter();
		$formatters = array(); // TODO

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
	 * @return array of $typeId
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
	 * @return DataType|null
	 */
	public function getType( $typeId ) {
		return array_key_exists( $typeId, $this->types ) ? $this->types[$typeId] : null;
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
