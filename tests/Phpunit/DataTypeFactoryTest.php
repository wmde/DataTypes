<?php

namespace DataTypes\Tests\Phpunit;

use DataTypes\DataType;
use DataTypes\DataTypeFactory;

/**
 * @covers DataTypes\DataTypeFactory
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
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Kinzler
 */
class DataTypeFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var null|DataTypeFactory
	 */
	protected $instance = null;

	/**
	 * @return DataTypeFactory
	 */
	protected function getInstance() {
		static $typeSpecs = array(
			'commonsMedia' => array(
				'datavalue' => 'string',
			),
			'string' => array(
				'datavalue' => 'string',
			),
			'globe-coordinate' => array(
				'datavalue' => 'globecoordinate',
			),
			'quantity' => array(
				'datavalue' => 'quantity',
			),
			'monolingual-text' => array(
				'datavalue' => 'monolingualtext',
			),
			'multilingual-text' => array(
				'datavalue' => 'multilingualtext',
			),
			'time' => array(
				'datavalue' => 'time',
			) );

		if ( $this->instance === null ) {
			$this->instance = new DataTypeFactory( $typeSpecs );
		}

		return $this->instance;
	}

	public function testGetTypeIds() {
		$ids = $this->getInstance()->getTypeIds();
		$this->assertInternalType( 'array', $ids );

		foreach ( $ids as $id ) {
			$this->assertInternalType( 'string', $id );
		}

		$this->assertEquals( array_unique( $ids ), $ids );
	}

	public function testGetType() {
		$factory = $this->getInstance();

		foreach ( $factory->getTypeIds() as $id ) {
			$this->assertInstanceOf( 'DataTypes\DataType', $factory->getType( $id ) );
		}
	}

	public function testGetUnknownType() {
		$factory = $this->getInstance();

		$this->setExpectedException( 'OutOfBoundsException' );

		$factory->getType( "I'm in your tests, being rather silly ~=[,,_,,]:3" );
	}

	public function testGetTypes() {
		$factory = $this->getInstance();

		$expectedIds = array_map(
			function( DataType $type ) {
				return $type->getId();
			},
			$factory->getTypes()
		);

		$expectedIds = array_values( $expectedIds );

		$this->assertEquals(
			$expectedIds,
			$factory->getTypeIds()
		);
	}

	public static function provideDataTypeBuilder() {
		return array(
			array( // #0
				'old-school',
				array( 'datavalue' => 'oldschool' ),
				'oldschool',
				'old style spec'
			),
			array( // #1
				'new-school',
				new DataType( 'new-school', 'newschool', array() ),
				'newschool',
				'DataValue object'
			),
			array( // #2
				'new-school',
				array( '\DataTypes\Tests\Phpunit\DummyType', '__construct' ),
				'dummy',
				'constructor'
			),
			array( // #3
				'new-school',
				array( '\DataTypes\Tests\Phpunit\DummyType', 'newDummy' ),
				'dummy',
				'callable'
			),
		);
	}

	/**
	 * @dataProvider provideDataTypeBuilder
	 */
	public function testDataTypeBuilder( $id, $builderSpec, $expected, $message ) {
		$factory = new DataTypeFactory( array( $id => $builderSpec ) );

		$type = $factory->getType( $id );

		$this->assertEquals( $id, $type->getId(), $message );
		$this->assertEquals( $expected, $type->getDataValueType(), $message );
	}

}

class DummyType extends DataType {
	public function __construct( $typeId, $dataValueType = 'dummy' ) {
		parent::__construct( $typeId, $dataValueType, array(), array(), array() );
	}

	public static function newDummy( $typeId ) {
		return new DummyType( $typeId );
	}
}
