<?php

namespace DataTypes\Tests\Phpunit;

use DataTypes\DataType;
use DataTypes\DataTypeFactory;
use PHPUnit_Framework_TestCase;

/**
 * @covers DataTypes\DataTypeFactory
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Daniel Kinzler
 * @author Thiemo Mättig
 */
class DataTypeFactoryTest extends PHPUnit_Framework_TestCase {

	/**
	 * @dataProvider valueTypesProvider
	 */
	public function testConstructor( array $valueTypes ) {
		$instance = new DataTypeFactory( $valueTypes );
		$this->assertInstanceOf( 'DataTypes\DataTypeFactory', $instance );
	}

	public function valueTypesProvider() {
		return array(
			array( array() ),
			array( array( 'string' => 'string' ) ),
			array( array( 'customType' => 'customValueType' ) ),
		);
	}

	/**
	 * @dataProvider invalidConstructorArgumentProvider
	 */
	public function testConstructorThrowsException( array $argument ) {
		$this->setExpectedException( 'InvalidArgumentException' );
		new DataTypeFactory( $argument );
	}

	public function invalidConstructorArgumentProvider() {
		return array(
			array( array( 'string' => 1 ) ),
			array( array( 'string' => new DataType( 'string', 'string' ) ) ),
			array( array( 0 => 'string' ) ),
			array( array( 0 => new DataType( 'string', 'string' ) ) ),
		);
	}

	public function testGetTypeIds() {
		$instance = new DataTypeFactory( array( 'customType' => 'string' ) );

		$expected = array( 'customType' );
		$this->assertSame( $expected, $instance->getTypeIds() );
	}

	public function testGetType() {
		$instance = new DataTypeFactory( array( 'customType' => 'string' ) );

		$expected = new DataType( 'customType', 'string' );
		$this->assertEquals( $expected, $instance->getType( 'customType' ) );
	}

	public function testGetUnknownType() {
		$instance = new DataTypeFactory( array() );

		$this->setExpectedException( 'OutOfBoundsException' );
		$instance->getType( 'unknownTypeId' );
	}

	public function testGetTypes() {
		$instance = new DataTypeFactory( array( 'customType' => 'string' ) );

		$expected = array( 'customType' => new DataType( 'customType', 'string' ) );
		$this->assertEquals( $expected, $instance->getTypes() );
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
