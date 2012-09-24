<?php

/**
 * Implementation of the DataType interface.
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
class DataTypeObject implements DataType {

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
	 * The ValueParser used by this data type.
	 *
	 * @since 0.1
	 *
	 * @var ValueParser
	 */
	protected $parser;

	/**
	 * The ValueFormatter used by this data type.
	 *
	 * @since 0.1
	 *
	 * @var ValueFormatter
	 */
	protected $formatter;

	/**
	 * The ValueValidator objects used by this data type.
	 *
	 * @since 0.1
	 *
	 * @var array of ValueValidator
	 */
	protected $validators;

	/**
	 * Constructor.
	 * Typically you should not construct such objects yourself but use the TypeFactory.
	 *
	 * @since 0.1
	 *
	 * @param $typeId string
	 * @param $dataValueType string
	 * @param $parser ValueParser
	 * @param $formatter ValueFormatter
	 * @param $validators array of ValueValidator
	 */
	public function __construct( $typeId, $dataValueType, ValueParser $parser, /* ValueFormatter */ $formatter, array $validators ) {
		$this->typeId = $typeId;
		$this->dataValueType = $dataValueType;
		$this->parser = $parser;
		$this->formatter = $formatter;
		$this->validators = $validators;
	}

	/**
	 * @see DataType::getId
	 *
	 * @since 0.1
	 *
	 * @return string
	 */
	public function getId() {
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
		return $this->dataValueType;
	}

	/**
	 * @see DataType::getParser
	 *
	 * @since 0.1
	 *
	 * @return ValueParser
	 */
	public function getParser() {
		return $this->parser;
	}

	/**
	 * @see DataType::getFormatter
	 *
	 * @since 0.1
	 *
	 * @return ValueFormatter
	 */
	public function getFormatter() {
		return $this->formatter;
	}

	/**
	 * @see DataType::getValidators
	 *
	 * @since 0.1
	 *
	 * @return array of ValueValidator
	 */
	public function getValidators() {
		return $this->validators;
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
		// TODO: implement i18n system
		// https://www.mediawiki.org/wiki/Help:Extension:Translate/Group_configuration_example#Step_2:_File_Format_Support
		// https://gerrit.wikimedia.org/r/gitweb?p=mediawiki/extensions/Translate.git;a=tree;f=ffs;hb=HEAD
		return __CLASS__ . '-' . $langCode;
	}

}
