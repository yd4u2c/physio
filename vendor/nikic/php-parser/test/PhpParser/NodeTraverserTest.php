<?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision\Adapters\Laravel;

use NunoMaduro\Collision\Provider;
use Illuminate\Support\ServiceProvider;
use NunoMaduro\Collision\Adapters\Phpunit\Listener;
use NunoMaduro\Collision\Contracts\Provider as ProviderContract;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use NunoMaduro\Collision\Contracts\Adapters\Phpunit\Listener as ListenerContract;

/**
 * This is an Collision Laravel Adapter Service Provider implementation.
 *
 * Registers the Error Handler on Laravel.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
class CollisionServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        if ($this->app->runningInConsole() && ! $this->app->runningUnitTests()) {
            $this->app->singleton(ListenerContract::class, Listener::class);
            $this->app->bind(ProviderContract::class, Provider::class);

            $appExceptionHandler = $this->app->make(ExceptionHandlerContract::class);

            $this->app->singleton(
                ExceptionHandlerContract::class,
                function ($app) use ($appExceptionHandler) {
                    return new ExceptionHandler($app, $appExceptionHandler);
                }
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [ProviderContract::class];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision\Adapters\Laravel;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use NunoMaduro\Collision\Contracts\Provider as ProviderContract;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Symfony\Component\Console\Exception\ExceptionInterface as SymfonyConsoleExceptionInterface;

/**
 * This is an Collision Laravel Adapter ExceptionHandler implementation.
 *
 * Registers the Error Handler on Laravel.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
class ExceptionHandler implements ExceptionHandlerContract
{
    /**
     * Holds an instance of the application exception handler.
     *
     * @var \Illuminate\Contracts\Debug\ExceptionHandler
     */
    protected $appExceptionHandler;

    /**
     * Holds an instance of the application.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Creates a new instance of the ExceptionHandler.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Contracts\Debug\ExceptionHandler $appExceptionHandler
     */
    public function __construct(Application $app, ExceptionHandlerContract $appExceptionHandler)
    {
        $this->app = $app;
        $this->appExceptionHandler = $appExceptionHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function report(Exception $e)
    {
        $this->appExceptionHandler->report($e);
    }

    /**
     * {@inheritdoc}
     */
    public function render($request, Exception $e)
    {
        return $this->appExceptionHandler->render($request, $e);
    }

    /**
     * {@inheritdoc}
     */
    public function renderForConsole($output, Exception $e)
    {
        if ($e instanceof SymfonyConsoleExceptionInterface) {
            $this->appExceptionHandler->renderForConsole($output, $e);
        } else {
            $handler = $this->app->make(ProviderContract::class)
                ->register()
                ->getHandler()
                ->setOutput($output);

            $handler->setInspector((new Inspector($e)));

            $handler->handle();
        }
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param  \Exception  $e
     * @return bool
     */
    public function shouldReport(Exception $e)
    {
        return $this->appExceptionHandler->shouldReport($e);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision\Adapters\Phpunit;

use ReflectionObject;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\Warning;
use Whoops\Exception\Inspector;
use NunoMaduro\Collision\Writer;
use PHPUnit\Framework\TestSuite;
use Symfony\Component\Console\Application;
use PHPUnit\Framework\AssertionFailedError;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use NunoMaduro\Collision\Contracts\Writer as WriterContract;
use NunoMaduro\Collision\Contracts\Adapters\Phpunit\Listener as ListenerContract;

if (class_exists(\PHPUnit\Runner\Version::class) && substr(\PHPUnit\Runner\Version::id(), 0, 2) === '7.') {

    /**
     * This is an Collision Phpunit Adapter implementation.
     *
     * @author Nuno Maduro <enunomaduro@gmail.com>
     */
    class Listener implements ListenerContract
    {
        /**
         * Holds an instance of the writer.
         *
         * @var \NunoMaduro\Collision\Contracts\Writer
         */
        protected $writer;

        /**
         * Holds the exception found, if any.
         *
         * @var \Throwable|null
         */
        protected $exceptionFound;

        /**
         * Creates a new instance of the class.
         *
         * @param \NunoMaduro\Collision\Contracts\Writer|null $writer
         */
        public function __construct(WriterContract $writer = null)
        {
            $this->writer = $writer ?: $this->buildWriter();
        }

        /**
         * {@inheritdoc}
         */
        public function render(\Throwable $t)
        {
            $inspector = new Inspector($t);

            $this->writer->write($inspector);
        }

        /**
         * {@inheritdoc}
         */
        public function addError(Test $test, \Throwable $t, float $time): void
        {
            if ($this->exceptionFound === null) {
                $this->exceptionFound = $t;
            }
        }

        /**
         * {@inheritdoc}
         */
        public function addWarning(Test $test, Warning $t, float $time): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function addFailure(Test $test, AssertionFailedError $t, float $time): void
        {
            $this->writer->ignoreFilesIn(['/vendor/'])
            ->showTrace(false);

            if ($this->exceptionFound === null) {
                $this->exceptionFound = $t;
            }
        }

        /**
         * {@inheritdoc}
         */
        public function addIncompleteTest(Test $test, \Throwable $t, float $time): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function addRiskyTest(Test $test, \Throwable $t, float $time): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function addSkippedTest(Test $test, \Throwable $t, float $time): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function startTestSuite(TestSuite $suite): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function endTestSuite(TestSuite $suite): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function startTest(Test $test): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function endTest(Test $test, float $time): void
        {
        }

        /**
         * {@inheritdoc}
         */
        public function __destruct()
        {
            if ($this->exceptionFound !== null) {
                $this->render($this->exceptionFound);
            }
        }

        /**
         * Builds an Writer.
         *
         * @return \NunoMaduro\Collision\Contracts\Writer
         */
        protected function buildWriter(): WriterContract
        {
            $writer = new Writer;

            $application = new Application();
            $reflector = new ReflectionObject($application);
            $method = $reflector->getMethod('configureIO');
            $method->setAccessible(true);
            $method->invoke($application, new ArgvInput, $output = new ConsoleOutput);

            return $writer->setOutput($output);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             