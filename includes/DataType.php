<?php

namespace DataTypes;

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
interface DataType {

	/**
	 * Returns the identifier of this data type.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getId();

	/**
	 * Returns the DataValue used by this data type.
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getDataValueType();

	/**
	 * Returns the ValueParser used by this data type.
	 *
	 * TODO: support for multiple parsers
	 *
	 * @since 0.1
	 *
	 * @return ValueParser
	 */
	public function getParser();

	/**
	 * Returns the ValueFormatter used by this data type.
	 *
	 * TODO: support for multiple formatters
	 *
	 * @since 0.1
	 *
	 * @return ValueFormatter
	 */
	public function getFormatter();

	/**
	 * Returns the label of the data type in the provided language or null if there is none.
	 *
	 * @since 0.1
	 *
	 * @param string $langCode
	 *
	 * @return string|null
	 */
	public function getLabel( $langCode );


	/**
	 * Returns the ValueValidators that are supported by this data type.
	 *
	 * @since 0.1
	 *
	 * @return array of ValueValidator
	 */
	public function getValidators();

}
