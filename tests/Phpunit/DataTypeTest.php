<?php

namespace DataTypes\Tests\Phpunit;

use DataTypes\DataType;
use DataTypes\Message;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * @covers DataTypes\DataType
 *
 * @group DataTypes
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Thiemo Mättig
 */
class DataTypeTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var callable|null
	 */
	private $textFunction;

	protected function setUp() {
		parent::setUp();

		$class = new ReflectionClass( 'DataTypes\Message' );
		$properties = $class->getStaticProperties();
		$this->textFunction = $properties['textFunction'];

		Message::registerTextFunction( function( $key, $languageCode ) {
			return implode( '|', func_get_args() );
		} );
	}

	protected function tearDown() {
		Message::registerTextFunction( $this->textFunction );

		parent::tearDown();
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
