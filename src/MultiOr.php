<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Class MultiOr
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class MultiOr implements ExtendedValidatorInterface, MultiValidatorInterface {

	use ValidatorDataGetterTrait;
	use GetErrorMessagesTrait;
	use MultiValidatorDataGetterTrait;
	use MultiValidatorValidatorsTrait;

	/**
	 * Named constructor
	 *
	 * @return MultiOr
	 */
	public static function with_validators() {

		return new static( [ 'validators' => func_get_args() ] );
	}

	/**
	 * MultiOr constructor.
	 *
	 * @param array                        $options
	 * @param ExtendedValidatorInterface[] $validators
	 */
	public function __construct( array $options = [ ], array $validators = [ ] ) {

		$factory = new ValidatorFactory();

		array_key_exists( 'validators', $options ) and $validators = array_merge(
			(array) $options[ 'validators' ],
			$validators
		);

		foreach ( $validators as $validator ) {

			$options = [ ];

			if ( is_array( $validator ) && isset( $validator[ 'validator' ] ) ) {
				empty( $validator[ 'options' ] ) or $options = (array) $validator[ 'options' ];
				$validator = $validator[ 'validator' ];
			}

			$this->add_validator( $factory->create( $validator, $options ) );
		}
	}

	/**
	 * @inheritdoc
	 */
	public function is_valid( $value ) {

		$this->input_data = [ 'value' => $value ];

		$error_data = [ ];
		$error_code = '';

		if ( ! $this->validators ) {
			return TRUE;
		}

		foreach ( $this->validators as $validator ) {

			if ( $validator->is_valid( $value ) ) {
				$this->input_data = [ 'value' => $value ];
				$this->error_code = '';
				$this->error_data = [ ];

				return TRUE;
			}

			$data             = $validator->get_input_data();
			$data[ 'value' ]  = $value;
			$this->input_data = $data;
			$error_code       = $validator->get_error_code();
			isset( $error_data[ $error_code ] ) or $error_data[ $error_code ] = [ ];
			$error_data[ $error_code ][] = $data;
		}

		$this->error_data = $error_data;
		$this->error_code = $error_code;

		$this->update_error_messages();

		return FALSE;
	}

}