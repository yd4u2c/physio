               $this->addLongOption($option->getName(), null);
            }
        }
    }

    /**
     * Parses a long option.
     *
     * @param string $token The current token
     */
    private function parseLongOption($token)
    {
        $name = \substr($token, 2);

        if (false !== $pos = \strpos($name, '=')) {
            if (0 === \strlen($value = \substr($name, $pos + 1))) {
                // if no value after "=" then substr() returns "" since php7 only, false before
                // see http://php.net/manual/fr/migration70.incompatible.php#119151
                if (PHP_VERSION_ID < 70000 && false === $value) {
                    $value = '';
                }
                \array_unshift($this->parsed, [$value, null]);
            }
            $this->addLongOption(\substr($name, 0, $pos), $value);
        } else {
            $this->addLongOption($name, null);
        }
    }

    /**
     * Adds a short option value.
     *
     * @param string $shortcut The short option key
     * @param mixed  $value    The value for the option
     *
     * @throws \RuntimeException When option given doesn't exist
     */
    private function addShortOption($shortcut, $value)
    {
        if (!$this->definition->hasShortcut($shortcut)) {
            throw new \RuntimeException(\sprintf('The "-%s" option does not exist.', $shortcut));
        }

        $this->addLongOption($this->definition->getOptionForShortcut($shortcut)->getName(), $value);
    }

    /**
     * Adds a long option value.
     *
     * @param string $name  The long option key
     * @param mixed  $value The value for the option
     *
     * @throws \RuntimeException When option given doesn't exist
     */
    private function addLongOption($name, $value)
    {
        if (!$this->definition->hasOption($name)) {
            throw new \RuntimeException(\sprintf('The "--%s" option does not exist.', $name));
        }

        $option = $this->definition->getOption($name);

        if (null !== $value && !$option->acceptValue()) {
            throw new \RuntimeException(\sprintf('The "--%s" option does not accept a value.', $name));
        }

        if (\in_array($value, ['', null], true) && $option->acceptValue() && \count($this->parsed)) {
            // if option accepts an optional or mandatory argument
            // let's see if there is one provided
            $next = \array_shift($this->parsed);
            $nextToken = $next[0];
            if ((isset($nextToken[0]) && '-' !== $nextToken[0]) || \in_array($nextToken, ['', null], true)) {
                $value = $nextToken;
            } else {
                \array_unshift($this->parsed, $next);
            }
        }

        if (null === $value) {
            if ($option->isValueRequired()) {
                throw new \RuntimeException(\sprintf('The "--%s" option requires a value.', $name));
            }

            if (!$option->isArray() && !$option->isValueOptional()) {
                $value = true;
            }
        }

        if ($option->isArray()) {
            $this->options[$name][] = $value;
        } else {
            $this->options[$name] = $value;
        }
    }

    // @codeCoverageIgnoreEnd
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Input;

/**
 * A simple class used internally by PsySH to represent silent input.
 *
 * Silent input is generally used for non-user-generated code, such as the
 * rewritten user code run by sudo command. Silent input isn't echoed before
 * evaluating, and it's not added to the readline history.
 */
class SilentInput
{
    private $inputString;

    /**
     * Constructor.
     *
     * @param string $inputString
     */
    public function __construct($inputString)
    {
        $this->inputString = $inputString;
    }

    /**
     * To. String.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->inputString;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Output;

use Symfony\Component\Console\Output\StreamOutput;

/**
 * A passthrough pager is a no-op. It simply wraps a StreamOutput's stream and
 * does nothing when the pager is closed.
 */
class PassthruPager extends StreamOutput implements OutputPager
{
    /**
     * Constructor.
     *
     * @param StreamOutput $output
     */
    public function __construct(StreamOutput $output)
    {
        parent::__construct($output->getStream());
    }

    /**
     * Close the current pager process.
     */
    public function close()
    {
        // nothing to do here
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           