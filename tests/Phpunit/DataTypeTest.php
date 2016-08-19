<?php

namespace DataTypes\Tests\Phpunit;

use DataTypes\DataType;
use DataTypes\Message;
use PHPUnit_Framework_TestCase;

/**
 * @covers DataTypes\DataType
 *
 * @group DataTypes
 *
 * @license GPL-2.0+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Mättig
 */
class DataTypeTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		parent::setUp();

		Message::registerTextFunction( function( $key, $languageCode ) {
			return implode( '|', func_get_args() );
		} );
	}

	/**
	 * @dataProvider invalidConstructorArgumentsProvider
	 */
	public function testConstructorThrowsException( $propertyType, $valueType ) {
		$this->setExpectedException( 'InvalidArgumentException' );
		new DataType( $propertyType, $valueType );
	}

	public function invalidConstructorArgumentsProvider() {
		return array(
			array( 'propertyType', null ),
			array( 'propertyType', false ),
			array( null, 'valueType' ),
			array( false, 'valueType' ),
		);
	}

	public function testGetId() {
		$type = new DataType( 'propertyType', 'valueType' );
		$this->assertSame( 'propertyType', $type->getId() );
	}

	public function testGetDataValueType() {
		$type = new DataType( 'propertyType', 'valueType' );
		$this->assertSame( 'valueType', $type->getDataValueType() );
	}

	public function testGetLabel() {
		$type = new DataType( 'propertyType', 'valueType' );
		$this->assertSame( 'datatypes-type-propertyType|en', $type->getLabel( 'en' ) );
	}

	public function testToArray() {
		$type = new DataType( 'propertyType', 'valueType' );
		$this->assertSame( array( 'dataValueType' => 'valueType' ), $type->toArray() );
	}

}
