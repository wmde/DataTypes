<?php

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
class TypeFactory {

	/**
	 * Maps type id to Type.
	 *
	 * @since 0.1
	 *
	 * @var array of Type
	 */
	protected $types;

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	protected function __construct() {
		// enforces singleton
	}

	/**
	 * Returns the global instance of the factory.
	 *
	 * @since 0.1
	 *
	 * @return TypeFactory
	 */
	public function singleton() {
		static $instance = false;

		if ( $instance === false ) {
			$instance = new static();
			$instance->initialize();
		}


		return $instance;
	}

	/**
	 * Initializes the factory.
	 *
	 * @since 0.1
	 */
	protected function initialize() {
		global $wgDataTypes;

		foreach ( $wgDataTypes as $typeId => $typeData ) {
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
		return new TypeObject( $typeId ); // TODO
	}

	/**
	 * Returns the type identifiers.
	 *
	 * @since 0.1
	 *
	 * @return array of $typeId
	 */
	public function getTypesIds() {
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
	 * @return array of DataType
	 */
	public function getTypes() {
		return $this->types;
	}

}
