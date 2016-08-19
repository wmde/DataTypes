<?php

namespace DataTypes\Tests\Modules;

use DataTypes\DataTypeFactory;
use DataTypes\Modules\DataTypesModule;
use ResourceLoaderContext;

/**
 * @covers DataTypes\Modules\DataTypesModule
 *
 * @group DataTypes
 *
 * @license GPL-2.0+
 * @author Daniel Werner < daniel.werner@wikimedia.de >
 * @author Katie Filbert < aude.wiki@gmail.com >
 */
class DataTypesModuleTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @return array [instance, resource definition]
	 */
	public function provideDataTypesModuleAndResourceDefinition() {
		$dataTypeFactory = new DataTypeFactory( array( 'url' => 'string' ) );

		$validResourceDefinitions = array(
			array(
				'datatypesconfigvarname' => 'foo',
				'datatypefactory' => function() {
					return new DataTypeFactory( array() );
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
		$dataTypeFactory = new DataTypeFactory( array() );

		$validDefinition = array(
			'datatypesconfigvarname' => 'foo',
			'datatypefactory' => function() {
				return new DataTypeFactory( array() );
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

	public function testGetDefinitionSummary() {
		$definition = $this->makeDefinition(
			array( 'foo' => 'string' )
		);

		$module = new DataTypesModule( $definition );
		$summary = $module->getDefinitionSummary( $this->getContext() );

		$this->assertInternalType( 'array', $summary );
		$this->assertArrayHasKey( 0, $summary );
		$this->assertArrayHasKey( 'dataHash', $summary[0] );
	}

	public function testGetDefinitionSummary_notEqualForDifferentDataTypes() {
		$definition1 = $this->makeDefinition( array(
			'foo' => 'string'
		) );

		$definition2 = $this->makeDefinition( array(
			'foo' => 'string',
			'bar' => 'string'
		) );

		$module1 = new DataTypesModule( $definition1 );
		$module2 = new DataTypesModule( $definition2 );

		$context = $this->getContext();

		$summary1 = $module1->getDefinitionSummary( $context );
		$summary2 = $module2->getDefinitionSummary( $context );

		$this->assertNotEquals( $summary1[0]['dataHash'], $summary2[0]['dataHash'] );
	}


	private function makeDefinition( array $dataTypes ) {
		return array(
			'datatypesconfigvarname' => 'foo123',
			'datatypefactory' => new DataTypeFactory( $dataTypes )
		);
	}

	/**
	 * @return ResourceLoaderContext
	 */
	private function getContext() {
		return $this->getMockBuilder( 'ResourceLoaderContext' )
			->disableOriginalConstructor()
			->getMock();
	}

}
