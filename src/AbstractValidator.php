<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Class AbstractValidator.
 *
 * Deprecated, will be removed in future versions.
 *
 * @author     Christian Brückner <chris@chrico.info>
 * @package    inpsyde-validator
 * @deprecated Implement ExtendedValidatorInterface for custom validators
 */
abstract class AbstractValidator implements ValidatorInterface {

	/**
	 * The Message-Templates for Error-Description.
	 *
	 * @var     array
	 */
	protected $message_templates = [ ];

	/**
	 * Contains all error-Messages after Validation.
	 *
	 * @var     array
	 */
	protected $error_messages = [ ];

	/**
	 * Contains the Validation-Options.
	 *
	 * @var     array
	 */
	protected $options = [ ];

	/**
	 * @param array $options
	 * @param array $message_templates
	 *
	 * @return \Inpsyde\Validator\AbstractValidator
	 * @deprecated
	 */
	public function __construct( array $options = [ ], array $message_templates = [ ] ) {

		foreach ( $options as $name => $value ) {
			$this->options[ $name ] = $value;
		}

		foreach ( $message_templates as $name => $value ) {
			$this->message_templates[ $name ] = (string) $value;
		}
	}

	/**
	 * {@inheritdoc}
	 * @deprecated
	 */
	public function get_error_messages() {

		return array_unique( $this->error_messages );
	}

	/**
	 * Returns the stored messages templates.
	 *
	 * @return array
	 * @deprecated
	 */
	public function get_message_templates() {

		return $this->message_templates;
	}

	/**
	 * Returns the error message template or empty string by a given name.
	 *
	 * @param    String $name
	 *
	 * @return    String $template
	 *
	 * @deprecated
	 */
	public function get_message_template( $name ) {

		if ( ! isset( $this->message_templates[ $name ] ) ) {
			return '';
		}

		return $this->message_templates[ $name ];
	}

	/**
	 * Returns the stored options.
	 *
	 * @return array
	 *
	 * @deprecated
	 */
	public function get_options() {

		return $this->options;
	}

	/**
	 *
	 * @param string $message_name
	 * @param mixed  $value
	 *
	 * @return ValidatorInterface
	 *
	 * @deprecated
	 */
	protected function set_error_message( $message_name, $value ) {

		$this->error_messages[] = $this->create_error_message( $message_name, $value );

		return $this;
	}

	/**
	 * Creating an Error-Message for the given messageName from an messageTemplate.
	 *
	 * @param   String $message_name
	 * @param   String $value
	 *
	 * @return  Null|String
	 *
	 * @deprecated
	 */
	protected function create_error_message( $message_name, $value ) {

		$message = $this->get_message_template( $message_name );

		if ( ! is_scalar( $value ) ) {
			$value = $this->get_value_as_string( $value );
		}

		// replacing the placeholder for the %value%
		$message = str_replace( '%value%', $value, $message );

		// replacing the possible options-placeholder on the message
		foreach ( $this->options as $search => $replace ) {
			$replace = $this->get_value_as_string( $replace );
			$message = str_replace( '%' . $search . '%', $replace, $message );
		}

		return $message;
	}

	/**
	 * Converts non-scalar values into a readable string.
	 *
	 * @param   mixed $value
	 *
	 * @return  string $type
	 *
	 * @deprecated
	 */
	protected function get_value_as_string( $value ) {

		if ( is_object( $value ) && ! in_array( '__toString', get_class_methods( $value ) ) ) {
			$value = get_class( $value ) . ' object';
		} else if ( is_array( $value ) ) {
			$value = var_export( $value, TRUE );
		}

		return (string) $value;
	}

}