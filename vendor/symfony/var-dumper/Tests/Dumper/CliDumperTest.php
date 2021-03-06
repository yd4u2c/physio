                  );
                    }
                case self::WHITESPACE_STATE:
                    if ($char === '#') {
                        return [$data[0], self::COMMENT_STATE];
                    } elseif (!ctype_space($char)) {
                        throw new InvalidFileException(
                            self::getErrorMessage('unexpected whitespace', $value)
                        );
                    } else {
                        return [$data[0], self::WHITESPACE_STATE];
                    }
                case self::COMMENT_STATE:
                    return [$data[0], self::COMMENT_STATE];
            }
        }, ['', self::INITIAL_STATE])[0];
    }

    /**
     * Generate a friendly error message.
     *
     * @param string $cause
     * @param string $subject
     *
     * @return string
     */
    private static function getErrorMessage($cause, $subject)
    {
        return sprintf(
            'Failed to parse dotenv file due to %s. Failed at [%s].',
            $cause,
            strtok($subject, "\n")
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

namespace Dotenv;

use Dotenv\Exception\ValidationException;

/**
 * This is the validator class.
 *
 * It's responsible for applying validations against a number of variables.
 */
class Validator
{
    /**
     * The variables to validate.
     *
     * @var string[]
     */
    protected $variables;

    /**
     * The loader instance.
     *
     * @var \Dotenv\Loader
     */
    protected $loader;

    /**
     * Create a new validator instance.
     *
     * @param string[]       $variables
     * @param \Dotenv\Loader $loader
     *
     * @throws \Dotenv\Exception\ValidationException
     *
     * @return void
     */
    public function __construct(array $variables, Loader $loader)
    {
        $this->variables = $variables;
        $this->loader = $loader;

        $this->assertCallback(
            function ($value) {
                return $value !== null;
            },
            'is missing'
        );
    }

    /**
     * Assert that each variable is not empty.
     *
     * @throws \Dotenv\Exception\ValidationException
     *
     * @return \Dotenv\Validator
     */
    public function notEmpty()
    {
        return $this->assertCallback(
            function ($value) {
                return strlen(trim($value)) > 0;
            },
            'is empty'
        );
    }

    /**
     * Assert that each specified variable is an integer.
     *
     * @throws \Dotenv\Exception\ValidationException
     *
     * @return \Dotenv\Validator
     */
    public function isInteger()
    {
        return $this->assertCallback(
            function ($value) {
                return ctype_digit($value);
            },
            'is not an integer'
        );
    }

    /**
     * Assert that each specified variable is a boolean.
     *
     * @throws \Dotenv\Exception\ValidationException
     *
     * @return \Dotenv\Validator
     */
    public function isBoolean()
    {
        return $this->assertCallback(
            function ($value) {
                if ($value === '') {
                    return false;
                }

                return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
            },
            'is not a boolean'
        );
    }

    /**
     * Assert that each variable is amongst the given choices.
     *
     * @param string[] $choices
     *
     * @throws \Dotenv\Exception\ValidationException
     *
     * @return \Dotenv\Validator
     */
    public function allowedValues(array $choices)
    {
        return $this->assertCallback(
            function ($value) use ($choices) {
                return in_array($value, $choices, true);
            },
            sprintf('is not one of [%s]', implode(', ', $choices))
        );
    }

    /**
     * Assert that the callback returns true for each variable.
     *
     * @param callable $callback
     * @param string   $message
     *
     * @throws \Dotenv\Exception\ValidationException
     *
     * @return \Dotenv\Validator
     */
    protected function assertCallback(callable $callback, $message = 'failed callback assertion')
    {
        $failing = [];

        foreach ($this->variables as $variable) {
            if ($callback($this->loader->getEnvironmentVariable($variable)) === false) {
                $failing[] = sprintf('%s %s', $variable, $message);
            }
        }

        if (count($failing) > 0) {
            throw new ValidationException(sprintf(
                'One or more environment variables failed assertions: %s.',
                implode(', ', $failing)
            ));
        }

        return $this;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Dotenv\Environment;

/**
 * This is the abstract variables implementation.
 *
 * Extend this as required, implementing "get", "set", and "clear".
 */
abstract class AbstractVariables implements VariablesInterface
{
    /**
     * Are we immutable?
     *
     * @var bool
     */
    private $immutable;

    /**
     * Create a new environment variables instance.
     *
     * @param bool $immutable
     *
     * @return void
     */
    public function __construct($immutable)
    {
        $this->immutable = $immutable;
    }

    /**
     * Determine if the environment is immutable.
     *
     * @return bool
     */
    public function isImmutable()
    {
        return $this->immutable;
    }

    /**
     * Tells whether environment variable has been defined.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has($name)
    {
        return is_string($name) && $this->get($name) !== null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->clear($offset);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  