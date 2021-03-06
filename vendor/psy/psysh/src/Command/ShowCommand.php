<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Readline;

/**
 * An interface abstracting the various readline_* functions.
 */
interface Readline
{
    /**
     * Check whether this Readline class is supported by the current system.
     *
     * @return bool
     */
    public static function isSupported();

    /**
     * Add a line to the command history.
     *
     * @param string $line
     *
     * @return bool Success
     */
    public function addHistory($line);

    /**
     * Clear the command history.
     *
     * @return bool Success
     */
    public function clearHistory();

    /**
     * List the command history.
     *
     * @return array
     */
    public function listHistory();

    /**
     * Read the command history.
     *
     * @return bool Success
     */
    public function readHistory();

    /**
     * Read a single line of input from the user.
     *
     * @param null|string $prompt
     *
     * @return false|string
     */
    public function readline($prompt = null);

    /**
     * Redraw readline to redraw the display.
     */
    public function redisplay();

    /**
     * Write the command history to a file.
     *
     * @return bool Success
     */
    public function writeHistory();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Readline;

use Psy\Exception\BreakException;

/**
 * An array-based Readline emulation implementation.
 */
class Transient implements Readline
{
    private $history;
    private $historySize;
    private $eraseDups;
    private $stdin;

    /**
     * Transient Readline is always supported.
     *
     * {@inheritdoc}
     */
    public static function isSupported()
    {
        return true;
    }

    /**
     * Transient Readline constructor.
     */
    public function __construct($historyFile = null, $historySize = 0, $eraseDups = false)
    {
        // don't do anything with the history file...
        $this->history     = [];
        $this->historySize = $historySize;
        $this->eraseDups   = $eraseDups;
    }

    /**
     * {@inheritdoc}
     */
    public function addHistory($line)
    {
        if ($this->eraseDups) {
            if (($key = \array_search($line, $this->history)) !== false) {
                unset($this->history[$key]);
            }
        }

        $this->history[] = $line;

        if ($this->historySize > 0) {
            $histsize = \count($this->history);
            if ($histsize > $this->historySize) {
                $this->history = \array_slice($this->history, $histsize - $this->historySize);
            }
        }

        $this->history = \array_values($this->history);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clearHistory()
    {
        $this->history = [];

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function listHistory()
    {
        return $this->history;
    }

    /**
     * {@inheritdoc}
     */
    public function readHistory()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BreakException if user hits Ctrl+D
     *
     * @return string
     */
    public function readline($prompt = null)
    {
        echo $prompt;

        return \rtrim(\fgets($this->getStdin()), "\n\r");
    }

    /**
     * {@inheritdoc}
     */
    public function redisplay()
    {
        // noop
    }

    /**
     * {@inheritdoc}
     */
    public function writeHistory()
    {
        return true;
    }

    /**
     * Get a STDIN file handle.
     *
     * @throws BreakException if user hits Ctrl+D
     *
     * @return resource
     */
    private function getStdin()
    {
        if (!isset($this->stdin)) {
            $this->stdin = \fopen('php://stdin', 'r');
        }

        if (\feof($this->stdin)) {
            throw new BreakException('Ctrl+D');
        }

        return $this->stdin;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Reflection;

/**
 * Somehow the standard reflection library didn't include class constants until 7.1.
 *
 * ReflectionClassConstant corrects that omission.
 */
class ReflectionClassConstant implements \Reflector
{
    public $class;
    public $name;
    private $value;

    /**
     * Construct a ReflectionClassConstant object.
     *
     * @param string|object $class
     * @param string        $name
     */
    public function __construct($class, $name)
    {
        if (!$class instanceof \ReflectionClass) {
            $class = new \ReflectionClass($class);
        }

        $this->class = $class;
        $this->name  = $name;

        $constants = $class->getConstants();
        if (!\array_key_exists($name, $constants)) {
            throw new \InvalidArgumentException('Unknown constant: ' . $name);
        }

        $this->value = $constants[$name];
    }

    /**
     * Exports a reflection.
     *
     * @param string|object $class
     * @param string        $name
     * @param bool          $return pass true to retu