<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator\Error;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class ErrorLoggerFactory {

	const CONTRACT = ErrorLoggerInterface::class;

	public function get_logger( $class = NULL, array $args = [ ] ) {

		if ( ! is_null( $class ) && is_subclass_of( $class, self::CONTRACT, TRUE ) ) {
			return is_object( $class ) ? $class : $this->create_with_args( $args );
		}

		$class = function_exists( '__' ) ? WordPressErrorLogger::class : ErrorLogger::class;

		return $this->create_with_args( $class, $args );

	}

	/**
	 * @param string $class
	 * @param array  $args
	 *
	 * @return ErrorLoggerInterface
	 */
	private function create_with_args( $class, array $args ) {

		switch ( count( $args ) ) {
			case 0:
				return new $class();
			case 1:
				return new $class( reset( $args ) );
			case 2:
				return new $class( reset( $args ), end( $args ) );
		}

		return ( new \ReflectionClass( $class ) )->newInstanceArgs( $args );
	}
}