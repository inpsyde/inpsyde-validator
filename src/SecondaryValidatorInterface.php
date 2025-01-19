<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * Interface SecondaryValidatorInterface
 *
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
interface SecondaryValidatorInterface extends ExtendedValidatorInterface {

	/**
	 * @param ExtendedValidatorInterface $validator
	 *
	 * @return SecondaryValidatorInterface
	 */
	public static function with_validator( ExtendedValidatorInterface $validator );

}