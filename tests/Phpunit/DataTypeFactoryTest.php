<?php

namespace DataTypes\Tests\Phpunit;

use DataTypes\DataType;
use DataTypes\DataTypeFactory;

/**
 * @covers DataTypes\DataTypeFactory
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
		if ( $this->instance === null ) {
			$types = array(
				'string' => 'string',
			);
			$this->instance = new DataTypeFactory( $types );
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
				'data-type',
				array( 'data-type' => 'valuetype' ),
				'valuetype'
			),
		);
	}

	/**
	 * @dataProvider provideDataTypeBuilder
	 */
	public function testDataTypeBuilder( $id, $types, $expected ) {
		$factory = new DataTypeFactory( $types );

		$type = $factory->getType( $id );

		$this->assertEquals( $id, $type->getId() );
		$this->assertEquals( $expected, $type->getDataValueType() );
	}

}
