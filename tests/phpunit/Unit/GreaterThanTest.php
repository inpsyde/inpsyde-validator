<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator\Tests\Unit;

use Inpsyde\Validator\Error\ErrorLoggerInterface;
use Inpsyde\Validator\GreaterThan;

/**
 * Class GreaterThanTest
 *
 * @author  Christian Brückner <chris@chrico.info>
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class GreaterThanTest extends AbstractTestCase {

	/**
	 * Ensures that the validator follows expected behavior
	 *
	 * @dataProvider provide__basic_data
	 */
	public function test_basic( $options, $excepted, $values ) {

		$validator = new GreaterThan( $options );
		foreach ( $values as $value ) {
			$this->assertEquals(
				$excepted,
				$validator->is_valid( $value )
			);
		}

	}

	/**
	 * @return array
	 */
	public function provide__basic_data() {

		return [
			// options, excepted, values
			'valid_default'         => [
				[ 'min' => 0 ],
				TRUE,
				[ 0.01, 1, 100 ]
			],
			'invalid_default'       => [
				[ 'min' => 0 ],
				FALSE,
				[ 0, 0.00, - 0.01, - 1, - 100 ]
			],
			'valid_char'            => [
				[ 'min' => 'a' ],
				TRUE,
				[ 'b', 'c', 'd' ]
			],
			'invalid_char'          => [
				[ 'min' => 'z' ],
				FALSE,
				[ 'x', 'y', 'z' ]
			],
			'valid_inclusive'       => [
				[ 'min' => 0, 'inclusive' => TRUE ],
				TRUE,
				[ 0, 0.00, 0.01, 1, 100 ]
			],
			'invalid_inclusive'     => [
				[ 'min' => 0, 'inclusive' => TRUE ],
				FALSE,
				[ - 0.01, - 1, - 100 ]
			],
			'valid_not_inclusive'   => [
				[ 'min' => 0, 'inclusive' => FALSE ],
				TRUE,
				[ 0.01, 1, 100 ]
			],
			'invalid_not_inclusive' => [
				[ 'min' => 0, 'inclusive' => FALSE ],
				FALSE,
				[ 0, 0.00, - 0.01, - 1, - 100 ]
			]
		];
	}

	/**
	 * Tests that error code is returned according to validation results and options.
	 */
	public function test_get_error_code() {

		$validator_strict = new GreaterThan( [ 'min' => 2 ] );
		$validator_strict->is_valid( 2 );
		$code_strict = $validator_strict->get_error_code();

		$validator = new GreaterThan( [ 'min' => 2, 'inclusive' => TRUE ] );
		$validator->is_valid( - 1 );
		$code = $validator->get_error_code();

		$this->assertSame( ErrorLoggerInterface::NOT_GREATER, $code_strict );
		$this->assertSame( ErrorLoggerInterface::NOT_GREATER_INCLUSIVE, $code );
	}

	/**
	 * Even if deprecated, we need to test get_error_messages() is backward compatible
	 */
	public function test_get_error_messages() {

		$validator = new GreaterThan( [ 'min' => 10 ] );
		$validator->is_valid( 5 );
		$validator->is_valid( 8 );

		// muted because triggers deprecation notices
		$messages = @$validator->get_error_messages();

		$this->assertIsArray( $messages );
		$this->assertCount( 2, $messages );
		$this->assertStringContainsString( '5</code> is not greater than', reset( $messages ) );
		$this->assertStringContainsString( '8</code> is not greater than', end( $messages ) );
	}

	/**
	 * Tests that input data is returned according to validation results and options.
	 */
	public function test_get_input_data() {

		$validator = new GreaterThan();

		$validator->is_valid( 1 );
		$input = $validator->get_input_data();

		$this->assertIsArray( $input );
		$this->assertArrayHasKey( 'value', $input );
		$this->assertSame( 1, $input[ 'value' ] );

		$validator->is_valid( 2 );

		$input = $validator->get_input_data();
		$this->assertSame( 2, $input[ 'value' ] );
	}

}