<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
trait ValidatorDataGetterTrait {

	/**
	 * @var array
	 */
	protected $input_data = [ ];

	/**
	 * @var string
	 */
	protected $error_code = '';

	/**
	 * @see ExtendedValidatorInterface::get_error_code()
	 */
	public function get_error_code() {

		return $this->error_code;
	}

	/**
	 * @see ExtendedValidatorInterface::get_input_data()
	 */
	public function get_input_data() {

		return $this->input_data;
	}
}