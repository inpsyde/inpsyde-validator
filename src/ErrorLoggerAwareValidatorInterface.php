<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Interface MapValidatorInterface
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
interface ErrorLoggerAwareValidatorInterface extends MultiValidatorInterface {

	/**
	 * @param ExtendedValidatorInterface $validator
	 * @param string                     $error_message
	 *
	 * @return ErrorLoggerAwareValidatorInterface
	 */
	public function add_validator_with_message( ExtendedValidatorInterface $validator, $error_message );

	/**
	 * Return an instance of `ErrorLoggerAwareValidatorInterface` that make use of given error logger instance.
	 * The method should be implemented in a way that keeps the object immutable.
	 *
	 * @param Error\ErrorLoggerInterface $error_logger
	 *
	 * @return ErrorLoggerAwareValidatorInterface
	 */
	public function with_error_logger( Error\ErrorLoggerInterface $error_logger );

	/**
	 * Return a plain array of error messages.
	 *
	 * @return string[]
	 */
	public function get_error_messages();

}