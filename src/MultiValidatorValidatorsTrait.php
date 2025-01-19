<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
trait MultiValidatorValidatorsTrait {

	/**
	 * @var ExtendedValidatorInterface[]
	 */
	private $validators = [ ];

	/**
	 * @param ExtendedValidatorInterface $validator
	 *
	 * @return MultiValidatorInterface
	 * @see MultiValidatorInterface::add_validator()
	 */
	public function add_validator( ExtendedValidatorInterface $validator ) {

		$this->validators[] = $validator;

		return $this;
	}

	/**
	 * @see \Countable::count()
	 */
	public function count() {

		return count( $this->validators );
	}
}