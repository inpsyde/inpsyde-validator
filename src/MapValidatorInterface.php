<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Interface MapValidatorInterface
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
interface MapValidatorInterface extends MultiValidatorInterface {

	/**
	 * Adds a "leaf" validator to validate a specific key.
	 *
	 * @param ExtendedValidatorInterface $validator
	 * @param                            $key
	 * @param string|null                $error_message
	 *
	 * @return MapValidatorInterface
	 */
	public function add_validator_by_key( ExtendedValidatorInterface $validator, $key, $error_message = NULL );

	/**
	 * Adds more validator at once using an array where item keys are the key to validate and item values
	 * are validator instances.
	 *
	 * @param array $validators
	 *
	 * @return MapValidatorInterface
	 */
	public function add_validator_map( array $validators );

}