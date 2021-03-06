<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Exception\LogicException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Kevin Bond <kevinbond@gmail.com>
 */
class ProgressIndicator
{
    private $output;
    private $startTime;
    private $format;
    private $message;
    private $indicatorValues;
    private $indicatorCurrent;
    private $indicatorChangeInterval;
    private $indicatorUpdateTime;
    private $started = false;

    private static $formatters;
    private static $formats;

    /**
     * @param OutputInterface $output
     * @param string|null     $format                  Indicator format
     * @param int             $indicatorChangeInterval Change interval in milliseconds
     * @param array|null      $indicatorValues         Animated indicator characters
     */
    public function __construct(OutputInterface $output, string $format = null, int $indicatorChangeInterval = 100, array $indicatorValues = null)
    {
        $this->output = $output;

        if (null === $format) {
            $format = $this->determineBestFormat();
        }

        if (null === $indicatorValues) {
            $indicatorValues = ['-', '\\', '|', '/'];
        }

        $indicatorValues = array_values($indicatorValues);

        if (2 > \count($indicatorValues)) {
            throw new InvalidArgumentException('Must have at least 2 indicator value characters.');
        }

        $this->format = self::getFormatDefinition($format);
        $this->indicatorChangeInterval = $indicatorChangeInterval;
        $this->indicatorValues = $indicatorValues;
        $this->startTime = time();
    }

    /**
     * Sets the current indicator message.
     *
     * @param string|null $message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        $this->display();
    }

    /**
     * Starts the indicator output.
     *
     * @param $message
     */
    public function start($message)
    {
        if ($this->started) {
            throw new LogicException('Progress indicator already started.');
        }

        $this->message = $message;
        $this->started = true;
        $this->startTime = time();
        $this->indicatorUpdateTime = $this->getCurrentTimeInMilliseconds() + $this->indicatorChangeInterval;
        $this->indicatorCurrent = 0;

        $this->display();
    }

    /**
     * Advances the indicator.
     */
    public function advance()
    {
        if (!$this->started) {
            throw new LogicException('Progress indicator has not yet been started.');
        }

        if (!$this->output->isDecorated()) {
            return;
        }

        $currentTime = $this->getCurrentTimeInMilliseconds();

        if ($currentTime < $this->indicatorUpdateTime) {
            return;
        }

        $this->indicatorUpdateTime = $currentTime + $this->indicatorChangeInterval;
        ++$this->indicatorCurrent;

        $this->display();
    }

    /**
     * Finish the indicator with message.
     *
     * @param $message
     */
    public function finish($message)
    {
        if (!$this->started) {
            throw new LogicException('Progress indicator has not yet been started.');
        }

        $this->message = $message;
        $this->display();
        $this->output->writeln('');
        $this->started = false;
    }

    /**
     * Gets the format for a given name.
     *
     * @param string $name The format name
     *
     * @return string|null A format string
     */
    public static function getFormatDefinition($name)
    {
        if (!self::$formats) {
            self::$formats = self::initFormats();
        }

        return isset(self::$formats[$name]) ? self::$formats[$name] : null;
    }

    /**
     * Sets a placeholder formatter for a given name.
     *
     * This method also allow you to override an existing placeholder.
     *
     * @param string   $name     The placeholder name (including the delimiter char like %)
     * @param callable $callable A PHP callable
     */
    public static function setPlaceholderFormatterDefinition($name, $callable)
    {
        if (!self::$formatters) {
            self::$formatters = self::initPlaceholderFormatters();
        }

        self::$formatters[$name] = $callable;
    }

    /**
     * Gets the placeholder formatter for a given name.
     *
     * @param string $name The placeholder name (including the delimiter char like %)
     *
     * @return callable|null A PHP callable
     */
    public static function getPlaceholderFormatterDefinition($name)
    {
        if (!self::$formatters) {
            self::$formatters = self::initPlaceholderFormatters();
        }

        return isset(self::$formatters[$name]) ? self::$formatters[$name] : null;
    }

    private function display()
    {
        if (OutputInterface::VERBOSITY_QUIET === $this->output->getVerbosity()) {
            return;
        }

        $self = $this;

        $this->overwrite(preg_replace_callback("{%([a-z\-_]+)(?:\:([^%]+))?%}i", function ($matches) use ($self) {
            if ($formatter = $self::getPlaceholderFormatterDefinition($matches[1])) {
                return $formatter($self);
            }

            return $matches[0];
        }, $this->format));
    }

    private function determineBestFormat()
    {
        switch ($this->output->getVerbosity()) {
            // OutputInterface::VERBOSITY_QUIET: display is disabled anyway
            case OutputInterface::VERBOSITY_VERBOSE:
                return $this->output->isDecorated() ? 'verbose' : 'verbose_no_ansi';
            case OutputInterface::VERBOSITY_VERY_VERBOSE:
            case OutputInterface::VERBOSITY_DEBUG:
                return $this->output->isDecorated() ? 'very_verbose' : 'very_verbose_no_ansi';
            default:
                return $this->output->isDecorated() ? 'normal' : 'normal_no_ansi';
        }
    }

    /**
     * Overwrites a previous message to the output.
     */
    private function overwrite(string $message)
    {
        if ($this->output->isDecorated()) {
            $this->output->write("\x0D\x1B[2K");
            $this->output->write($message);
        } else {
            $this->output->writeln($message);
        }
    }

    private function getCurrentTimeInMilliseconds()
    {
        return round(microtime(true) * 1000);
    }

    private static function initPlaceholderFormatters()
    {
        return [
            'indicator' => function (self $indicator) {
                return $indicator->indicatorValues[$indicator->indicatorCurrent % \count($indicator->indicatorValues)];
            },
            'message' => function (self $indicator) {
                return $indicator->message;
            },
            'elapsed' => function (self $indicator) {
                return Helper::formatTime(time() - $indicator->startTime);
            },
            'memory' => function () {
                return Helper::formatMemory(memory_get_usage(true));
            },
        ];
    }

    private static function initFormats()
    {
        return [
            'normal' => ' %indicator% %message%',
            'normal_no_ansi' => ' %message%',

            'verbose' => ' %indicator% %message% (%elapsed:6s%)',
            'verbose_no_ansi' => ' %message% (%elapsed:6s%)',

            'very_verbose' => ' %indicator% %message% (%elapsed:6s%, %memory:6s%)',
            'very_verbose_no_ansi' => ' %message% (%elapsed:6s%, %memory:6s%)',
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Helper;

use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

/**
 * The QuestionHelper class provides helpers to interact with the user.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class QuestionHelper extends Helper
{
    private $inputStream;
    private static $shell;
    private static $stty;

    /**
     * Asks a question to the user.
     *
     * @return mixed The user answer
     *
     * @throws RuntimeException If there is no data to read in the input stream
     */
    public function ask(InputInterface $input, OutputInterface $output, Question $question)
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }

        if (!$input->isInteractive()) {
            $default = $question->getDefault();

            if (null === $default) {
                return $default;
            }

            if ($validator = $question->getValidator()) {
                return \call_user_func($question->getValidator(), $default);
            } elseif ($question instanceof ChoiceQuestion) {
                $choices = $question->getChoices();

                if (!$question->isMultiselect()) {
                    return isset($choices[$default]) ? $choices[$default] : $default;
                }

                $default = explode(',', $default);
                foreach ($default as $k => $v) {
                    $v = trim($v);
                    $default[$k] = isset($choices[$v]) ? $choices[$v] : $v;
                }
            }

            return $default;
        }

        if ($input instanceof StreamableInputInterface && $stream = $input->getStream()) {
            $this->inputStream = $stream;
        }

        if (!$question->getValidator()) {
            return $this->doAsk($output, $question);
        }

        $interviewer = function () use ($output, $question) {
            return $this->doAsk($output, $question);
        };

        return $this->validateAttempts($interviewer, $output, $question);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'question';
    }

    /**
     * Prevents usage of stty.
     */
    public static function disableStty()
    {
        self::$stty = false;
    }

    /**
     * Asks the question to the user.
     *
     * @return bool|mixed|string|null
     *
     * @throws RuntimeException In case the fallback is deactivated and the response cannot be hidden
     */
    private function doAsk(OutputInterface $output, Question $question)
    {
        $this->writePrompt($output, $question);

        $inputStream = $this->inputStream ?: STDIN;
        $autocomplete = $question->getAutocompleterValues();

        if (null === $autocomplete || !$this->hasSttyAvailable()) {
            $ret = false;
            if ($question->isHidden()) {
                try {
                    $ret = trim($this->getHiddenResponse($output, $inputStream));
                } catch (RuntimeException $e) {
                    if (!$question->isHiddenFallback()) {
                        throw $e;
                    }
                }
            }

            if (false === $ret) {
                $ret = fgets($inputStream, 4096);
                if (false === $ret) {
                    throw new RuntimeException('Aborted.');
                }
                $ret = trim($ret);
            }
        } else {
            $ret = trim($this->autocomplete($output, $question, $inputStream, \is_array($autocomplete) ? $autocomplete : iterator_to_array($autocomplete, false)));
        }

        if ($output instanceof ConsoleSectionOutput) {
            $output->addContent($ret);
        }

        $ret = \strlen($ret) > 0 ? $ret : $question->getDefault();

        if ($normalizer = $question->getNormalizer()) {
            return $normalizer($ret);
        }

        return $ret;
    }

    /**
     * Outputs the question prompt.
     */
    protected function writePrompt(OutputInterface $output, Question $question)
    {
        $message = $question->getQuestion();

        if ($question instanceof ChoiceQuestion) {
            $maxWidth = max(array_map([$this, 'strlen'], array_keys($question->getChoices())));

            $messages = (array) $question->getQuestion();
            foreach ($question->getChoices() as $key => $value) {
                $width = $maxWidth - $this->strlen($key);
                $messages[] = '  [<info>'.$key.str_repeat(' ', $width).'</info>] '.$value;
            }

            $output->writeln($messages);

            $message = $question->getPrompt();
        }

        $output->write($message);
    }

    /**
     * Outputs an error message.
     */
    protected function writeError(OutputInterface $output, \Exception $error)
    {
        if (null !== $this->getHelperSet() && $this->getHelperSet()->has('formatter')) {
            $message = $this->getHelperSet()->get('formatter')->formatBlock($error->getMessage(), 'error');
        } else {
            $message = '<error>'.$error->getMessage().'</error>';
        }

        $output->writeln($message);
    }

    /**
     * Autocompletes a question.
     *
     * @param OutputInterface $output
     * @param Question        $question
     * @param resource        $inputStream
     */
    private function autocomplete(OutputInterface $output, Question $question, $inputStream, array $autocomplete): string
    {
        $ret = '';

        $i = 0;
        $ofs = -1;
        $matches = $autocomplete;
        $numMatches = \count($matches);

        $sttyMode = shell_exec('stty -g');

        // Disable icanon (so we can fread each keypress) and echo (we'll do echoing here instead)
        shell_exec('stty -icanon -echo');

        // Add highlighted text style
        $output->getFormatter()->setStyle('hl', new OutputFormatterStyle('black', 'white'));

        // Read a keypress
        while (!feof($inputStream)) {
            $c = fread($inputStream, 1);

            // as opposed to fgets(), fread() returns an empty string when the stream content is empty, not false.
            if (false === $c || ('' === $ret && '' === $c && null === $question->getDefault())) {
                shell_exec(sprintf('stty %s', $sttyMode));
                throw new RuntimeException('Aborted.');
            } elseif ("\177" === $c) { // Backspace Character
                if (0 === $numMatches && 0 !== $i) {
                    --$i;
                    // Move cursor backwards
                    $output->write("\033[1D");
                }

                if (0 === $i) {
                    $ofs = -1;
                    $matches = $autocomplete;
                    $numMatches = \count($matches);
                } else {
                    $numMatches = 0;
                }

                // Pop the last character off the end of our string
                $ret = substr($ret, 0, $i);
            } elseif ("\033" === $c) {
                // Did we read an escape sequence?
                $c .= fread($inputStream, 2);

                // A = Up Arrow. B = Down Arrow
                if (isset($c[2]) && ('A' === $c[2] || 'B' === $c[2])) {
                    if ('A' === $c[2] && -1 === $ofs) {
                        $ofs = 0;
                    }

                    if (0 === $numMatches) {
                        continue;
                    }

                    $ofs += ('A' === $c[2]) ? -1 : 1;
                    $ofs = ($numMatches + $ofs) % $numMatches;
                }
            } elseif (\ord($c) < 32) {
                if ("\t" === $c || "\n" === $c) {
                    if ($numMatches > 0 && -1 !== $ofs) {
                        $ret = $matches[$ofs];
                        // Echo out remaining chars for current match
                        $output->write(substr($ret, $i));
                        $i = \strlen($ret);
                    }

                    if ("\n" === $c) {
                        $output->write($c);
                        break;
                    }

                    $numMatches = 0;
                }

                continue;
            } else {
                if ("\x80" <= $c) {
                    $c .= fread($inputStream, ["\xC0" => 1, "\xD0" => 1, "\xE0" => 2, "\xF0" => 3][$c & "\xF0"]);
                }

                $output->write($c);
                $ret .= $c;
                ++$i;

                $numMatches = 0;
                $ofs = 0;

                foreach ($autocomplete as $value) {
                    // If typed characters match the beginning chunk of value (e.g. [AcmeDe]moBundle)
                    if (0 === strpos($value, $ret)) {
                        $matches[$numMatches++] = $value;
                    }
                }
            }

            // Erase characters from cursor to end of line
            $output->write("\033[K");

            if ($numMatches > 0 && -1 !== $ofs) {
                // Save cursor position
                $output->write("\0337");
                // Write highlighted text
                $output->write('<hl>'.OutputFormatter::escapeTrailingBackslash(substr($matches[$ofs], $i)).'</hl>');
                // Restore cursor position
                $output->write("\0338");
            }
        }

        // Reset stty so it behaves normally again
        shell_exec(sprintf('stty %s', $sttyMode));

        return $ret;
    }

    /**
     * Gets a hidden response from user.
     *
     * @param OutputInterface $output      An Output instance
     * @param resource        $inputStream The handler resource
     *
     * @throws RuntimeException In case the fallback is deactivated and the response cannot be hidden
     */
    private function getHiddenResponse(OutputInterface $output, $inputStream): string
    {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $exe = __DIR__.'/../Resources/bin/hiddeninput.exe';

            // handle code running from a phar
            if