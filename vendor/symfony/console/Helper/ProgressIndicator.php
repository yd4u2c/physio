<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Style;

use Symfony\Component\Console\Formatter\OutputFormatterInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Decorates output to add console style guide helpers.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
abstract class OutputStyle implements OutputInterface, StyleInterface
{
    private $output;

    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * {@inheritdoc}
     */
    public function newLine($count = 1)
    {
        $this->output->write(str_repeat(PHP_EOL, $count));
    }

    /**
     * @param int $max
     *
     * @return ProgressBar
     */
    public function createProgressBar($max = 0)
    {
        return new ProgressBar($this->output, $max);
    }

    /**
     * {@inheritdoc}
     */
    public function write($messages, $newline = false, $type = self::OUTPUT_NORMAL)
    {
        $this->output->write($messages, $newline, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function writeln($messages, $type = self::OUTPUT_NORMAL)
    {
        $this->output->writeln($messages, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function setVerbosity($level)
    {
        $this->output->setVerbosity($level);
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity()
    {
        return $this->output->getVerbosity();
    }

    /**
     * {@inheritdoc}
     */
    public function setDecorated($decorated)
    {
        $this->output->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->output->isDecorated();
    }

    /**
     * {@inheritdoc}
     */
    public function setFormatter(OutputFormatterInterface $formatter)
    {
        $this->output->setFormatter($formatter);
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatter()
    {
        return $this->output->getFormatter();
    }

    /**
     * {@inheritdoc}
     */
    public function isQuiet()
    {
        return $this->output->isQuiet();
    }

    /**
     * {@inheritdoc}
     */
    public function isVerbose()
    {
        return $this->output->isVerbose();
    }

    /**
     * {@inheritdoc}
     */
    public function isVeryVerbose()
    {
        return $this->output->isVeryVerbose();
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return $this->output->isDebug();
    }

    protected function getErrorOutput()
    {
        if (!$this->output instanceof ConsoleOutputInterface) {
            return $this->output;
        }

        return $this->output->getErrorOutput();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Style;

/**
 * Output style helpers.
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
interface StyleInterface
{
    /**
     * Formats a command title.
     *
     * @param string $message
     */
    public function title($message);

    /**
     * Formats a section title.
     *
     * @param string $message
     */
    public function section($message);

    /**
     * Formats a list.
     */
    public function listing(array $elements);

    /**
     * Formats informational text.
     *
     * @param string|array $message
     */
    public function text($message);

    /**
     * Formats a success result bar.
     *
     * @param string|array $message
     */
    public function success($message);

    /**
     * Formats an error result bar.
     *
     * @param string|array $message
     */
    public function error($message);

    /**
     * Formats an warning result bar.
     *
     * @param string|array $message
     */
    public function warning($message);

    /**
     * Formats a note admonition.
     *
     * @param string|array $message
     */
    public function note($message);

    /**
     * Formats a caution admonition.
     *
     * @param string|array $message
     */
    public function caution($message);

    /**
     * Formats a table.
     */
    public function table(array $headers, array $rows);

    /**
     * Asks a question.
     *
     * @param string        $question
     * @param string|null   $default
     * @param callable|null $validator
     *
     * @return mixed
     */
    public function ask($question, $default = null, $validator = null);

    /**
     * Asks a question with the user input hidden.
     *
     * @param string        $question
     * @param callable|null $validator
     *
     * @return mixed
     */
    public function askHidden($question, $validator = null);

    /**
     * Asks for confirmation.
     *
     * @param string $question
     * @param bool   $default
     *
     * @return bool
     */
    public function confirm($question, $default = true);

    /**
     * Asks a choice question.
     *
     * @param string          $question
     * @param array           $choices
     * @param string|int|null $default
     *
     * @return mixed
     */
    public function choice($question, array $choices, $default = null);

    /**
     * Add newline(s).
     *
     * @param int $count The number of newlines
     */
    public function newLine($count = 1);

    /**
     * Starts the progress output.
     *
     * @param int $max Maximum steps (0 if unknown)
     */
    public function progressStart($max = 0);

    /**
     * Advances the progress output X steps.
     *
     * @param int $step Number of steps to advance
     */
    public function progressAdvance($step = 1);

    /**
     * Finishes the progress output.
     */
    public function progressFinish();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               