<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Class GreaterThan
 *
 * @author  Christian Brückner <chris@chrico.info>
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class GreaterThan implements ExtendedValidatorInterface {

	use ValidatorDataGetterTrait;
	use GetErrorMessagesTrait;

	/**
	 * @deprecated Error codes are now defined in Error\ErrorLoggerInterface
	 */
	const NOT_GREATER = Error\ErrorLoggerInterface::NOT_GREATER;

	/**
	 * @deprecated Error codes are now defined in Error\ErrorLoggerInterface
	 */
	const NOT_GREATER_INCLUSIVE = Error\ErrorLoggerInterface::NOT_GREATER_INCLUSIVE;

	/**
	 * @var array
	 * @deprecated
	 */
	protected $message_templates = [
		Error\ErrorLoggerInterface::NOT_GREATER           => "The input <code>%value%</code> is not greater than <strong>'%min%'</strong>.",
		Error\ErrorLoggerInterface::NOT_GREATER_INCLUSIVE => "The input <code>%value%</code> is not greater or equal than <strong>'%min%'</strong>."
	];

	/**
	 * @param array $options
	 */
	public function __construct( array $options = [ ] ) {

		// Whether to do inclusive comparisons, allowing equivalence to min and/or max
		$options[ 'inclusive' ] = isset( $options[ 'inclusive' ] )
			? filter_var( $options[ 'inclusive' ], FILTER_VALIDATE_BOOLEAN )
			: FALSE;

		$options[ 'min' ]            = isset( $options[ 'min' ] ) ? $options[ 'min' ] : 0;
		$this->input_data            = $options;
		$this->input_data[ 'value' ] = NULL;
	}

	/**
	 * @inheritdoc
	 */
	public function is_valid( $value ) {

		$this->input_data[ 'value' ] = $value;

		$inc   = $this->input_data[ 'inclusive' ];
		$valid = $inc ? $value >= $this->input_data[ 'min' ] : $value > $this->input_data[ 'min' ];
		$valid or $this->error_code = $inc
			? Error\ErrorLoggerInterface::NOT_GREATER_INCLUSIVE
			: Error\ErrorLoggerInterface::NOT_GREATER;

		$valid or $this->update_error_messages();

		return $valid;
	}
}