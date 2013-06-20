<?php

namespace DataTypes\Test;

use DataTypes\DataTypesModule;
use DataTypes\DataTypeFactory;

/**
 * @covers DataTypesModule
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
 * @file
 * @since 0.1
 *
 * @ingroup DataTypesTest
 *
 * @group DataTypes
 * @group DataValueExtensions
 *
 * @licence GNU GPL v2+
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 */
class DataTypesModuleTest extends \PHPUnit_Framework_TestCase {
	/**
	 * Array holding arrays with keys-value pairs required in resource definitions using the
	 * DataTypesModule class.
	 *
	 * @var array
	 */
	protected $validResourceDefinitions = array();

	/**
	 * Array of arrays where the first value is an array of invalid resource definitions that will
	 * raise an error if used in resource definitions using the DataTypesModule class. The second
	 * value of each 2nd level array is a string describing what is wrong with the resource
	 * definition.
	 *
	 * @var array
	 */
	protected $invalidResourcesCases = array();

	public function __construct( $name = null, $data = array(), $dataName = '' ) {
		parent::__construct( $name, $data, $dataName );

		$dataTypeFactory = new DataTypeFactory();

		$this->validResourceDefinitions += array(
			array(
				'datatypesconfigvarname' => 'foo',
				'datatypefactory' => function() {
					return new DataTypeFactory();
				}
			 ),
			array(
				'datatypesconfigvarname' => 'bar123',
				'datatypefactory' => $dataTypeFactory
			)
		);

		$this->invalidResourcesCases += array(
			array(
				array(
					'datatypesconfigvarname' => 'foo'
				 ),
				'missing "datatypefactory" field'
			),
			array(
				array(
					'datatypefactory' => $dataTypeFactory
				),
				'missing "datatypesconfigvarname" field'
			),
			array(
				array(),
				'all fields missing'
			),
			array(
				array_merge(
					$this->validResourceDefinitions[0],
					array(
						'datatypefactory' => 123
					)
				),
				'"datatypefactory" field has value of wrong type'
			),
			array(
				array_merge(
					$this->validResourceDefinitions[0],
					array(
						'datatypefactory' => function() {
							return null;
						}
					)
				),
				'"datatypefactory" callback does not return a DataTypeFactory instance'
			)
		);
	}

	/**
	 * @return array [instance, resource definition]
	 */
	public function provideDataTypesModuleAndResourceDefinition() {
		$cases = array();

		foreach( $this->validResourceDefinitions as $definition ) {
			$instance = new DataTypesModule( $definition );
			$cases[] = array( $instance, $definition );
		}

		return $cases;
	}

	/**
	 * @return array [invalid resource definition, case description]
	 */
	public function provideInvalidResourceDefinition() {
		return $this->invalidResourcesCases;
	}

	/**
	 * @dataProvider provideDataTypesModuleAndResourceDefinition
	 *
	 * @param DataTypesModule $module
	 * @param array $definition
	 */
	public function testGetDataTypeFactory( DataTypesModule $module, array $definition ) {
		$this->assertInstanceOf(
			'DataTypes\DataTypeFactory',
			$module->getDataTypeFactory()
		);
	}

	/**
	 * @dataProvider provideDataTypesModuleAndResourceDefinition
	 *
	 * @param DataTypesModule $module
	 * @param array $definition
	 */
	public function testGetConfigVarName( DataTypesModule $module, array $definition ) {
		$configVarName = $module->getConfigVarName();

		$this->assertInternalType( 'string', $configVarName );

		$this->assertSame(
			$definition['datatypesconfigvarname'],
			$module->getConfigVarName()
		);
	}

	/**
	 * @dataProvider provideInvalidResourceDefinition
	 *
	 * @param array $definition
	 * @param string $caseDescription
	 */
	public function testConstructorErrors( array $definition, $caseDescription ) {
		$this->setName( 'Instantiation raises exception in case ' . $caseDescription );
		$this->setExpectedException( 'Exception' );

		new DataTypesModule( $definition );
	}

}
