<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
trait MultiValidatorDataGetterTrait {

	/**
	 * @var array
	 */
	private $error_data = [ ];

	/**
	 * @inheritdoc
	 */
	public function get_error_codes() {

		return $this->error_data ? array_keys( $this->error_data ) : [ ];
	}

	/**
	 * @inheritdoc
	 */
	public function get_error_data( $error_code = NULL ) {

		if ( is_null( $error_code ) ) {
			return $this->error_data;
		} elseif ( ! array_key_exists( $error_code, $this->error_data ) ) {
			return [ ];
		}

		return $this->error_data[ $error_code ];
	}
}