<?php

namespace Illuminate\Queue;

use Closure;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\PhpExecutableFinder;

class Listener
{
    /**
     * The command working path.
     *
     * @var string
     */
    protected $commandPath;

    /**
     * The environment the workers should run under.
     *
     * @var string
     */
    protected $environment;

    /**
     * The amount of seconds to wait before polling the queue.
     *
     * @var int
     */
    protected $sleep = 3;

    /**
     * The amount of times to try a job before logging it failed.
     *
     * @var int
     */
    protected $maxTries = 0;

    /**
     * The output handler callback.
     *
     * @var \Closure|null
     */
    protected $outputHandler;

    /**
     * Create a new queue listener.
     *
     * @param 