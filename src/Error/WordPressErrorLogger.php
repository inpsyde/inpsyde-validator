<?php # -*- coding: utf-8 -*-

namespace Inpsyde\Validator\Error;

use Inpsyde\Validator\ExtendedValidatorInterface;

/**
 * @author  Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 * @package inpsyde-validator
 */
class WordPressErrorLogger implements ErrorLoggerInterface {

	/**
	 * @var ErrorLoggerInterface
	 */
	private $logger;

	/**
	 * Constructor.
	 *
	 * @param string[] $messages An array of messages to replace default ones.
	 */
	public function __construct( array $messages = [ ] ) {

		$default = [
			self::CUSTOM_ERROR                 => sprintf(
				__(
					'Some errors occurred for %s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_DATE                 => sprintf(
				__(
					'The input %s does not appear to be a valid date.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_DATE_FORMAT          => sprintf(
				__(
					'The input %1$s does not fit the date format %2$s .',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%format%</code>'
			),
			self::INVALID_DNS                  => sprintf(
				__(
					'The host for the given input %s could not be resolved.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_SIZE                 => sprintf(
				'Size for input %1$s is not %2$s.',
				'<code>%value%</code>',
				'<code>%size%</code>'
			),
			self::INVALID_TYPE_NON_ARRAY       => sprintf(
				__(
					'Invalid type given for %s. Array expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_TYPE_NON_COUNTABLE   => sprintf(
				__(
					'Invalid type given for %s. Countable data expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_TYPE_NON_DATE        => sprintf(
				__(
					'Invalid type given for %s. String, integer, array or DateTime expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_TYPE_NON_NUMERIC     => sprintf(
				__(
					'Invalid type given for %s. Integer or float expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_TYPE_NON_SCALAR      => sprintf(
				__(
					'Invalid type given for %s. String, integer or float expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_TYPE_NON_STRING      => sprintf(
				__(
					'Invalid type given for %s. String expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_TYPE_NON_TRAVERSABLE => sprintf(
				__(
					'Invalid type given for %s. Array or object implementing Traversable expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::INVALID_TYPE_GIVEN           => sprintf(
				__(
					'Invalid type given for %1$s. %2$s expected.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%type%</code>'
			),
			self::IS_EMPTY                     => __(
				'This value should not be empty.',
				'inpsyde-validator'
			),
			self::MULTIPLE_ERRORS              => sprintf(
				__(
					'Some errors occurred for %s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::NOT_BETWEEN                  => sprintf(
				__(
					'The input %1$s is not between %2$s and %3$s, inclusively.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%min%</code>',
				'<code>%max%</code>'
			),
			self::NOT_BETWEEN_STRICT           => sprintf(
				__(
					'The input %1$s is not strictly between %2$s and %3$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%min%</code>',
				'<code>%max%</code>'
			),
			self::NOT_CLASS_NAME               => sprintf(
				__(
					'The input %s is not a valid class name.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::NOT_EMAIL                    => sprintf(
				__(
					'The input %s is not a valid email address.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::NOT_GREATER                  => sprintf(
				__(
					'The input %1$s is not greater than %2$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%min%</code>'
			),
			self::NOT_GREATER_INCLUSIVE        => sprintf(
				__(
					'The input %1$s is not greater or equal than %2$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%min%</code>'
			),
			self::NOT_IN_ARRAY                 => sprintf(
				__(
					'The input %1$s is not in the haystack: %2$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%haystack%</code>'
			),
			self::NOT_LESS                     => sprintf(
				__(
					'The input %1$s is not less than %2$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%max%</code>'
			),
			self::NOT_LESS_INCLUSIVE           => sprintf(
				__(
					'The input %1$s is not less or equal than %2$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%max%</code>'
			),
			self::NOT_NEGATE_VALIDATOR         => sprintf(
				__(
					'%s returned true, but was expected to return false.',
					'inpsyde-validator'
				),
				'<code>%validator_name%::is_valid()</code>'
			),
			self::NOT_MATCH                    => sprintf(
				__(
					'The input %1$s does not match against pattern %2$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%pattern%</code>'
			),
			self::NOT_URL                      => sprintf(
				__(
					'The input %s is not a valid URL.',
					'inpsyde-validator'
				),
				'<code>%value%</code>'
			),
			self::REGEX_INTERNAL_ERROR         => sprintf(
				__(
					'There was an internal error while using the pattern %2$s for string %1$s.',
					'inpsyde-validator'
				),
				'<code>%value%</code>',
				'<code>%pattern%</code>'
			),
			self::WP_FILTER_ERROR              => sprintf(
				__(
					'The filter %2$s returned a false value for %1$s.',
					'inpsyde-validator'
				),
				'<code>%filter%</code>',
				'<code>%value%</code>'
			),
		];

		$this->logger = new ErrorLogger( array_merge( $default, array_filter( $messages, 'is_string' ) ) );
	}

	/**
	 * @inheritdoc
	 */
	public function getIterator(): \Traversable {

		return $this->logger->getIterator();
	}

	/**
	 * @inheritdoc
	 */
	public function log_error( $code, array $data = [ ], $error_template = NULL ) {

		return $this->logger->log_error( $code, $data, $error_template );
	}

	/**
	 * @inheritdoc
	 */
	public function log_error_for_key( $key, $code, array $data = [ ], $error_template = NULL ) {

		return $this->logger->log_error_for_key( $key, $code, $data, $error_template );
	}

	/**
	 * @inheritdoc
	 */
	public function get_error_messages( $error_code = NULL ) {

		return $this->logger->get_error_messages( $error_code );
	}

	/**
	 * @inheritdoc
	 */
	public function get_error_codes() {

		return $this->logger->get_error_codes();
	}

	/**
	 * @inheritdoc
	 */
	public function get_last_message( $error_code = NULL ) {

		return $this->logger->get_last_message( $error_code );
	}

	/**
	 * @inheritdoc
	 */
	public function use_error_template( $error_code, $error_template ) {

		return $this->logger->use_error_template( $error_code, $error_template );
	}

	/**
	 * @inheritdoc
	 */
	public function merge( ErrorLoggerInterface $logger ) {

		$this->logger = $this->logger->merge( $logger );

		return $this->logger;
	}

	/**
	 * @inheritdoc
	 */
	public function count(): int {

		return $this->logger->count();
	}
}
