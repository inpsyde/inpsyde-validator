<?php # -*- coding: utf-8 -*-
/*
 * This file is part of the inpsyde-validator package.
 *
 * (c) Inpsyde GmbH
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Inpsyde\Validator\Tests\Unit;

use Inpsyde\Validator\Between;
use Inpsyde\Validator\Error\ErrorLoggerInterface;

/**
 * Class BetweenTest
 *
 * @author  Christian Brückner <chris@chrico.info>
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 * @license http://opensource.org/licenses/MIT MIT
 */
class BetweenTest extends AbstractTestCase {

	/**
	 * @return array
	 */
	public function provide__basic_data() {

		return [
			"integer_inclusive"       => [
				[ "min" => 1, "max" => 100, "inclusive" => TRUE ],
				TRUE,
				[ 1, 10, 100 ]
			],
			"mixed_numbers_inclusive" => [
				[ "min" => 1, "max" => 100, "inclusive" => TRUE ],
				FALSE,
				[ 0, 0.99, 100.01, 101 ]
			],
			"integer_not_inclusive"   => [
				[ "min" => 1, "max" => 100, "inclusive" => FALSE ],
				FALSE,
				[ 0, 1, 100, 101 ]
			],
			"chars_inclusive"         => [
				[ "min" => 'a', "max" => 'z', "inclusive" => TRUE ],
				TRUE,
				[ 'a', 'b', 'y', 'z' ]
			],
			"chars_not_inclusive"     => [
				[ "min" => 'a', "max" => 'z', "inclusive" => FALSE ],
				FALSE,
				[ '!', 'a', 'z' ]
			]
		];
	}

	/**
	 * Ensures that the validator follows expected behavior
	 *
	 * @dataProvider provide__basic_data
	 *
	 * @param array $options
	 * @param bool  $expected
	 * @param array $input_values
	 *
	 * @return void
	 */
	public function test_basic( $options, $expected, $input_values ) {

		$validator = new Between( $options );
		foreach ( $input_values as $key => $input ) {
			$this->assertEquals(
				$expected,
				$validator->is_valid( $input )
			);
		}
	}

	/**
	 * Tests that error code is returned according to validation results and options.
	 */
	public function test_get_error_code() {

		$validator = new Between( [ 'min' => 0, 'max' => 1 ] );
		$validator->is_valid( 3 );

		$validator_strict = new Between( [ 'min' => 0, 'max' => 1, 'inclusive' => FALSE ] );
		$validator_strict->is_valid( 1 );

		$validator_ok = new Between( [ 'min' => 0, 'max' => 1 ] );
		$validator_ok->is_valid( 1 );

		$code        = $validator->get_error_code();
		$code_strict = $validator_strict->get_error_code();
		$code_ok     = $validator_ok->get_error_code();

		$this->assertSame( ErrorLoggerInterface::NOT_BETWEEN, $code );
		$this->assertSame( ErrorLoggerInterface::NOT_BETWEEN_STRICT, $code_strict );
		$this->assertSame( '', $code_ok );

	}

	/**
	 * Tests that input data is returned according to validation results and options.
	 */
	public function test_get_input_data() {

		$validator = new Between( [ 'min' => 0, 'max' => 1 ] );
		$validator->is_valid( 3 );

		$input = $validator->get_input_data();

		$this->assertIsArray( $input );
		$this->assertArrayHasKey( 'value', $input );
		$this->assertArrayHasKey( 'min', $input );
		$this->assertArrayHasKey( 'max', $input );
		$this->assertSame( 3, $input[ 'value' ] );
		$this->assertSame( 0, $input[ 'min' ] );
		$this->assertSame( 1, $input[ 'max' ] );
	}

	/**
	 * Even if deprecated, we need to test get_error_messages() is backward compatible
	 */
	public function test_get_error_messages() {

		$validator = new Between( [ 'min' => 0, 'max' => 1 ] );
		$validator->is_valid( 3 );

		// muted because triggers deprecation notices
		$messages = @$validator->get_error_messages();

		$this->assertIsArray( $messages );
		$this->assertCount( 1, $messages );
		$this->assertStringContainsString( 'is not between', reset( $messages ) );
	}

	public function test_get_error_messages_is_deprecated() {

        static::markTestSkipped('TODO: testing trigger_error() with E_USER_DEPRECATED');

		$validator = new Between( [ 'min' => 0, 'max' => 1 ] );
		$validator->is_valid( 3 );
		$validator->get_error_messages();
	}

}