<?php

namespace DataTypes\Tests\Phpunit;

use DataTypes\DataType;
use DataTypes\DataTypeFactory;

/**
 * @covers DataTypes\DataType
 *
 * @licence GNU GPL v2+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class DataTypeTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @return DataType[]
	 */
	protected function getInstances() {
		$factory = new DataTypeFactory( array(
			'string' => 'string',
		) );

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
	public function testGetLabel( DataType $type ) {
		foreach ( array( 'en', 'de', 'nl', 'o_O' ) as $langCode ) {
			$actual = $type->getLabel( $langCode );
			$this->assertTrue( $actual === null || is_string( $actual ) );
		}
	}

}
