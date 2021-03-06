<?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision;

use Whoops\Handler\Handler as AbstractHandler;
use Symfony\Component\Console\Output\OutputInterface;
use NunoMaduro\Collision\Contracts\Writer as WriterContract;
use NunoMaduro\Collision\Contracts\Handler as HandlerContract;

/**
 * This is an Collision Handler implementation.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
class Handler extends AbstractHandler implements HandlerContract
{
    /**
     * Holds an instance of the writer.
     *
     * @var \NunoMaduro\Collision\Contracts\Writer
     */
    protected $writer;

    /**
     * Creates an instance of the Handler.
     *
     * @param \NunoMaduro\Collision\Contracts\Writer|null $writer
     */
    public function __construct(WriterContract $writer = null)
    {
        $this->writer = $writer ?: new Writer;
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        $this->writer->write($this->getInspector());

        return static::QUIT;
    }

    /**
     * {@inheritdoc}
     */
    public function setOutput(OutputInterface $output): HandlerContract
    {
        $this->writer->setOutput($output);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getWriter(): WriterContract
    {
        return $this->writer;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision;

use JakubOnderka\PhpConsoleColor\ConsoleColor;
use JakubOnderka\PhpConsoleHighlighter\Highlighter as BaseHighlighter;
use NunoMaduro\Collision\Contracts\Highlighter as HighlighterContract;

/**
 * This is an Collision Highlighter implementation.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
class Highlighter extends BaseHighlighter implements HighlighterContract
{
    /**
     * Holds the theme.
     *
     * @var array
     */
    protected $theme = [
        BaseHighlighter::TOKEN_STRING => ['light_gray'],
        BaseHighlighter::TOKEN_COMMENT => ['dark_gray', 'italic'],
        BaseHighlighter::TOKEN_KEYWORD => ['yellow'],
        BaseHighlighter::TOKEN_DEFAULT => ['default', 'bold'],
        BaseHighlighter::TOKEN_HTML => ['blue', 'bold'],
        BaseHighlighter::ACTUAL_LINE_MARK => ['bg_red', 'bold'],
        BaseHighlighter::LINE_NUMBER => ['dark_gray', 'italic'],
    ];

    /**
     * Creates an instance of the Highlighter.
     *
     * @param \JakubOnderka\PhpConsoleColor\ConsoleColor|null $color
     */
    public function __construct(ConsoleColor $color = null)
    {
        parent::__construct($color = $color ?: new ConsoleColor);

        foreach ($this->theme as $name => $styles) {
            $color->addTheme((string) $name, $styles);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function highlight(string $content, int $line): string
    {
        return rtrim($this->getCodeSnippet($content, $line, 4, 4));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision;

use Whoops\Run;
use Whoops\RunInterface;
use NunoMaduro\Collision\Contracts\Handler as HandlerContract;
use NunoMaduro\Collision\Contracts\Provider as ProviderContract;

/**
 * This is an Collision Provider implementation.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
class Provider implements ProviderContract
{
    /**
     * Holds an instance of the Run.
     *
     * @var \Whoops\RunInterface
     */
    protected $run;

    /**
     * Holds an instance of the handler.
     *
     * @var \NunoMaduro\Collision\Contracts\Handler
     */
    protected $handler;

    /**
     * Creates a new instance of the Provider.
     *
     * @param \Whoops\RunInterface|null $run
     * @param \NunoMaduro\Collision\Contracts\Handler|null $handler
     */
    public function __construct(RunInterface $run = null, HandlerContract $handler = null)
    {
        $this->run = $run ?: new Run;
        $this->handler = $handler ?: new Handler;
    }

    /**
     * {@inheritdoc}
     */
    public function register(): ProviderContract
    {
        $this->run->pushHandler($this->handler)
            ->register();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHandler(): HandlerContract
    {
        return $this->handler;
    }
}
                                                                                                                                                                                                                                                                                                                                            