<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Class RegEx
 *
 * @author  Christian Brückner <chris@chrico.info>
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class RegEx implements ExtendedValidatorInterface {

	use ValidatorDataGetterTrait;
	use GetErrorMessagesTrait;

	/**
	 * @deprecated Error codes are now defined in Error\ErrorLoggerInterface
	 */
	const INVALID_TYPE = Error\ErrorLoggerInterface::INVALID_TYPE_NON_SCALAR;

	/**
	 * @deprecated Error codes are now defined in Error\ErrorLoggerInterface
	 */
	const NOT_MATCH = Error\ErrorLoggerInterface::NOT_MATCH;

	/**
	 * @deprecated Error codes are now defined in Error\ErrorLoggerInterface
	 */
	const ERROROUS = Error\ErrorLoggerInterface::REGEX_INTERNAL_ERROR;

	/**
	 * @var array
	 * @deprecated
	 */
	protected $message_templates = [
		Error\ErrorLoggerInterface::INVALID_TYPE_NON_SCALAR => "Invalid type given. String, integer or float expected",
		Error\ErrorLoggerInterface::NOT_MATCH               => "The input does not match against pattern '%pattern%'",
		Error\ErrorLoggerInterface::REGEX_INTERNAL_ERROR    => "There was an internal error while using the pattern '%pattern%'",
	];

	/**
	 * @param array $options
	 */
	public function __construct( array $options = [ ] ) {

		$pattern = isset( $options[ 'pattern' ] ) && is_string( $options[ 'pattern' ] ) ? $options[ 'pattern' ] : '';
		$first   = $pattern ? substr( $pattern, 0, 1 ) : '';
		$last    = $pattern ? substr( $pattern, - 1, 1 ) : '';
		( $first && ( $first !== $last || strlen( $pattern ) === 1 ) ) and $pattern = "~{$pattern}~";

		$options[ 'pattern' ]        = $pattern;
		$this->input_data            = $options;
		$this->input_data[ 'value' ] = NULL;
	}

	/**
	 * @inheritdoc
	 */
	public function is_valid( $value ) {

		$this->input_data[ 'value' ] = $value;

		$pattern = $this->input_data[ 'pattern' ];

		if ( ! is_string( $value ) && ! is_int( $value ) && ! is_float( $value ) ) {
			$this->error_code = Error\ErrorLoggerInterface::INVALID_TYPE_NON_SCALAR;
			$this->update_error_messages();

			return FALSE;
		}

		$valid = @preg_match( $pattern, $value );

		if ( $valid === FALSE ) {
			$this->error_code = Error\ErrorLoggerInterface::REGEX_INTERNAL_ERROR;
			$this->update_error_messages();

			return FALSE;
		}

		$valid or $this->error_code = Error\ErrorLoggerInterface::NOT_MATCH;
		$valid or $this->update_error_messages();

		return $valid > 0;
	}

}