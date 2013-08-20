<?php

namespace DataTypes\Tests\Phpunit;

use DataTypes\DataType;
use DataTypes\DataTypeFactory;

/**
 * @covers DataTypes\DataType
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
 */
class DataTypeTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @return DataType[]
	 */
	protected function getInstances() {
		$factory = new DataTypeFactory( $GLOBALS['wgDataTypes'] );
		return $factory->getTypes();
	}

	public function instanceProvider() {
		$argLists = array();

		foreach ( $this->getInstances() as $instance ) {
			$argLists[] = array( $instance );
		}

		return $argLists;
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataType $type
	 */
	public function testGetId( DataType $type ) {
		$this->assertInternalType( 'string', $type->getId() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataType $type
	 */
	public function testGetDataValueType( DataType $type ) {
		$this->assertInternalType( 'string', $type->getDataValueType() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataType $type
	 */
	public function testGetFormatter( DataType $type ) {
		$this->assertInternalType( 'array', $type->getFormatters() );
		$this->assertContainsOnlyInstancesOf( 'ValueFormatters\ValueFormatter', $type->getFormatters() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataType $type
	 */
	public function testGetValidators( DataType $type ) {
		$this->assertInternalType( 'array', $type->getValidators() );
		$this->assertContainsOnlyInstancesOf( 'ValueValidators\ValueValidator', $type->getValidators() );
	}

	/**
	 * @dataProvider instanceProvider
	 * @param DataType $type
	 */
	public function testGetLabel( DataType $type ) {
		foreach ( array( 'en', 'de', 'nl', 'o_O' ) as $langCode ) {
			$actual = $type->getLabel( $langCode );
			$this->assertTrue( $actual === null || is_string( $actual ) );
		}
	}

}
