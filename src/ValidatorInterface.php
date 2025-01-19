<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Interface ValidatorInterface
 *
 * @author  Christian Brückner <chris@chrico.info>
 * @package inpsyde-validator
 */
interface ValidatorInterface {

	/**
	 * Validate given value against some requirements.
	 *
	 * @param  mixed $value
	 *
	 * @return bool $is_valid `true` if and only if given value meets the validation requirements.
	 */
	public function is_valid( $value );

	/**
	 * @deprecated Messages are now managed via the `Error\WordPressErrorLogger` class.
	 *
	 * @return array
	 */
	public function get_error_messages();

}