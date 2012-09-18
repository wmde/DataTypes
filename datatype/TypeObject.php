<?php

/**
 * Implementation of the data types interface.
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
class TypeObject implements DataType {

	/**
	 * @since 0.1
	 * @var string
	 */
	protected $typeId;

	/**
	 * Constructor.
	 * Typically you should not construct such objects yourself but use the TypeFactory.
	 *
	 * @since 0.1
	 *
	 * @param string $typeId
	 */
	public function __construct( $typeId ) {
		$this->typeId = $typeId;
	}

	/**
	 * @see DataType::getIdentifier
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getIdentifier() {
		return $this->typeId;
	}

	/**
	 * @see DataType::getDataValueType
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDataValueType() {

	}

	/**
	 * @see DataType::getParser
	 *
	 * @since 0.1
	 *
	 * @return ValueParser
	 */
	public function getParser() {

	}

	/**
	 * @see DataType::getFormatter
	 *
	 * @since 0.1
	 *
	 * @return ValueFormatter
	 */
	public function getFormatter() {

	}

	/**
	 * @see DataType::getLabel
	 *
	 * @since 0.1
	 *
	 * @param string $langCode
	 *
	 * @return string|null
	 */
	public function getLabel( $langCode ) {

	}

}
