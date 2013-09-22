<?php

namespace DataTypes\Tests\Modules;

use DataTypes\DataTypeFactory;
use DataTypes\Modules\DataTypesModule;

/**
 * @covers DataTypes\Modules\DataTypesModule
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
	 * @return array [instance, resource definition]
	 */
	public function provideDataTypesModuleAndResourceDefinition() {
		$dataTypeFactory = new DataTypeFactory();

		$validResourceDefinitions = array(
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

		$cases = array();

		foreach( $validResourceDefinitions as $definition ) {
			$instance = new DataTypesModule( $definition );
			$cases[] = array( $instance, $definition );
		}

		return $cases;
	}

	/**
	 * @dataProvider provideDataTypesModuleAndResourceDefinition
	 *
	 * @param DataTypesModule $module
	 */
	public function testGetDataTypeFactory( DataTypesModule $module ) {
		$this->assertInstanceOf(
			'DataTypes\DataTypeFactory',
			$module->getDataTypeFactory()
		);
	}

	/**
	 * @return array [invalid resource definition, case description]
	 */
	public function provideInvalidResourceDefinition() {
		$dataTypeFactory = new DataTypeFactory();

		$validDefinition = array(
			'datatypesconfigvarname' => 'foo',
			'datatypefactory' => function() {
				return new DataTypeFactory();
			}
		);

		return array(
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
					$validDefinition,
					array(
						'datatypefactory' => 123
					)
				),
				'"datatypefactory" field has value of wrong type'
			),
			array(
				array_merge(
					$validDefinition,
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
