<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

use Inpsyde\Validator\Error\ErrorLoggerInterface;

/**
 * Class Callback
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class Callback implements ExtendedValidatorInterface {

	use ValidatorDataGetterTrait;
	use GetErrorMessagesTrait;

	/**
	 * @param callable $callback
	 *
	 * @return Callback
	 */
	public static function with_callback( callable $callback ) {

		return new static( [ 'callback' => $callback ] );
	}

	/**
	 * @param array $options
	 */
	public function __construct( array $options = [ ] ) {

		if ( empty( $options[ 'callback' ] ) || ! is_callable( $options[ 'callback' ] ) ) {
			throw new \InvalidArgumentException( sprintf( '%s "callback" option must be callable.', __CLASS__ ) );
		}

		$options[ 'error_code' ] = empty( $options[ 'error_code' ] ) || ! is_string( $options[ 'error_code' ] )
			? ErrorLoggerInterface::CUSTOM_ERROR
			: $options[ 'error_code' ];

		$this->input_data            = $options;
		$this->input_data[ 'value' ] = NULL;
	}

	/**
	 * @inheritdoc
	 */
	public function is_valid( $value ) {

		$this->input_data[ 'value' ] = $value;

		/** @var callable $callback */
		$callback = $this->input_data[ 'callback' ];

		$valid = filter_var( $callback( $value ), FILTER_VALIDATE_BOOLEAN );

		if ( ! $valid ) {
			$this->error_code = $this->input_data[ 'error_code' ];
			$this->update_error_messages();
		}

		return $valid;
	}

}