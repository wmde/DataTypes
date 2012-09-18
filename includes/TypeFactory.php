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

	protected function initialize()  {

	}

	/**
	 * @return array of $typeId
	 */
	public function getTypesIds() {
		return array_keys( $this->types );
	}

	/**
	 * @param $typeId
	 * @return DataType
	 */
	public function getType( $typeId ) {
		return $this->types[$typeId];
	}

	/**
	 * @return array of Type
	 */
	public function getTypes() {
		return $this->types;
	}

}