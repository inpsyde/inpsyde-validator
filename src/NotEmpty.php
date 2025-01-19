<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Class NotEmpty
 *
 * @author  Christian Brückner <chris@chrico.info>
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class NotEmpty implements ExtendedValidatorInterface {

	use ValidatorDataGetterTrait;
	use GetErrorMessagesTrait;

	/**
	 * @deprecated Error codes are now defined in Error\ErrorLoggerInterface
	 */
	const IS_EMPTY = Error\ErrorLoggerInterface::IS_EMPTY;

	/**
	 * @var array
	 * @deprecated
	 */
	protected $message_templates = [
		Error\ErrorLoggerInterface::IS_EMPTY => "This value should not be empty.",
	];

	/**
	 * @inheritdoc
	 */
	public function is_valid( $value ) {

		$this->input_data = [ 'value' => $value ];

		$valid = ! empty( $value ) || in_array( $value, [ 0, '0' ], TRUE );
		$valid or $this->error_code = Error\ErrorLoggerInterface::IS_EMPTY;
		$valid or $this->update_error_messages();

		return $valid;
	}

}