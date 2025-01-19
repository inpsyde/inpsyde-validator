<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Interface ExtendedValidatorInterface
 *
 * The methods of this interface should go in the `ValidatorInterface`, however, for backward compatibility
 * we can't just add methods to an existing interface or any custom validator out there will immediately break.
 * In next major release WE WILL DEPRECATE THIS interface and move its methods to `ValidatorInterface`.
 * Finally, a major release after, we can remove this interface for good.
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
interface ExtendedValidatorInterface extends ValidatorInterface {

	/**
	 * Return the error code
	 *
	 * @return string
	 */
	public function get_error_code();

	/**
	 * Return the input data that can be used to provide information on the error.
	 *
	 * @return array
	 */
	public function get_input_data();

}