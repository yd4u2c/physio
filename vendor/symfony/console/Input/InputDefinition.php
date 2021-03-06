_isatty($inputStream));
    }

    public function testRunLazyCommandService()
    {
        $container = new ContainerBuilder();
        $container->addCompilerPass(new AddConsoleCommandPass());
        $container
            ->register('lazy-command', LazyCommand::class)
            ->addTag('console.command', ['command' => 'lazy:command'])
            ->addTag('console.command', ['command' => 'lazy:alias'])
            ->addTag('console.command', ['command' => 'lazy:alias2']);
        $container->compile();

        $application = new Application();
        $application->setCommandLoader($container->get('console.command_loader'));
        $application->setAutoExit(false);

        $tester = new ApplicationTester($application);

        $tester->run(['command' => 'lazy:command']);
        $this->assertSame("lazy-command called\n", $tester->getDisplay(true));

        $tester->run(['command' => 'lazy:alias']);
        $this->assertSame("lazy-command called\n", $tester->getDisplay(true));

        $tester->run(['command' => 'lazy:alias2']);
        $this->assertSame("lazy-command called\n", $tester->getDisplay(true));

        $command = $application->get('lazy:command');
        $this->assertSame(['lazy:alias', 'lazy:alias2'], $command->getAliases());
    }

    /**
     * @expectedException \Symfony\Component\Console\Exception\CommandNotFoundException
     */
    public function testGetDisabledLazyCommand()
    {
        $application = new Application();
        $application->setCommandLoader(new FactoryCommandLoader(['disabled' => function () { return new DisabledCommand(); }]));
        $application->get('disabled');
    }

    public function testHasReturnsFalseForDisabledLazyCommand()
    {
        $application = new Application();
        $application->setCommandLoader(new FactoryCommandLoader(['disabled' => function () { return new DisabledCommand(); }]));
        $this->assertFalse($application->has('disabled'));
    }

    public function testAllExcludesDisabledLazyCommand()
    {
        $application = new Application();
        $application->setCommandLoader(new FactoryCommandLoader(['disabled' => function () { return new DisabledCommand(); }]));
        $this->assertArrayNotHasKey('disabled', $application->all());
    }

    protected function getDispatcher($skipCommand = false)
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener('console.command', function (ConsoleCommandEvent $event) use ($skipCommand) {
            $event->getOutput()->write('before.');

            if ($skipCommand) {
                $event->disableCommand();
            }
        });
        $dispatcher->addListener('console.terminate', function (ConsoleTerminateEvent $event) use ($skipCommand) {
            $event->getOutput()->writeln('after.');

            if (!$skipCommand) {
                $event->setExitCode(ConsoleCommandEvent::RETURN_CODE_DISABLED);
            }
        });
        $dispatcher->addListener('console.error', function (ConsoleErrorEvent $event) {
            $event->getOutput()->write('error.');

            $event->setError(new \LogicException('error.', $event->getExitCode(), $event->getError()));
        });

        return $dispatcher;
    }

    public function testErrorIsRethrownIfNotHandledByConsoleErrorEventWithCatchingEnabled()
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->setDispatcher(new EventDispatcher());

        $application->register('dym')->setCode(function (InputInterface $input, OutputInterface $output) {
            new \UnknownClass();
        });

        $tester = new ApplicationTester($application);

        try {
            $tester->run(['command' => 'dym']);
            $this->fail('->run() should rethrow PHP errors if not handled via ConsoleErrorEvent.');
        } catch (\Error $e) {
            $this->assertSame($e->getMessage(), 'Class \'UnknownClass\' not found');
        }
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage foo
     */
    public function testThrowingErrorListener()
    {
        $dispatcher = $this->getDispatcher();
        $dispatcher->addListener('console.error', function (ConsoleErrorEvent $event) {
            throw new \RuntimeException('foo');
        });

        $dispatcher->addListener('console.command', function () {
            throw new \RuntimeException('bar');
        });

        $application = new Application();
        $application->setDispatcher($dispatcher);
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        $application->register('foo')->setCode(function (InputInterface $input, OutputInterface $output) {
            $output->write('foo.');
        });

        $tester = new ApplicationTester($application);
        $tester->run(['command' => 'foo']);
    }
}

class CustomApplication extends Application
{
    /**
     * Overwrites the default input definition.
     *
     * @return InputDefinition An InputDefinition instance
     */
    protected function getDefaultInputDefinition()
    {
        return new InputDefinition([new InputOption('--custom', '-c', InputOption::VALUE_NONE, 'Set the custom input definition.')]);
    }

    /**
     * Gets the default helper set with the helpers that should always be available.
     *
     * @return HelperSet A HelperSet instance
     */
    protected function getDefaultHelperSet()
    {
        return new HelperSet([new FormatterHelper()]);
    }
}

class CustomDefaultCommandApplication extends Application
{
    /**
     * Overwrites the constructor in order to set a different default command.
     */
    public function __construct()
    {
        parent::__construct();

        $command = new \FooCommand();
        $this->add($command);
        $this->setDefaultCommand($command->getName());
    }
}

class LazyCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('lazy-command called');
    }
}

class DisabledCommand extends Command
{
    public function isEnabled()
    {
        return false;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Terminal;

class TerminalTest extends TestCase
{
    private $colSize;
    private $lineSize;

    protected function setUp()
    {
        $this->colSize = getenv('COLUMNS');
        $this->lineSize = getenv('LINES');
    }

    protected function tearDown()
    {
        putenv($this->colSize ? 'COLUMNS='.$this->colSize : 'COLUMNS');
        putenv($this->lineSize ? 'LINES' : 'LINES='.$this->lineSize);
    }

    public function test()
    {
        putenv('COLUMNS=100');
        putenv('LINES=50');
        $terminal = new Terminal();
        $this->assertSame(100, $terminal->getWidth());
        $this->assertSame(50, $terminal->getHeight());

        putenv('COLUMNS=120');
        putenv('LINES=60');
        $terminal = new Terminal();
        $this->assertSame(120, $terminal->getWidth());
        $this->assertSame(60, $terminal->getHeight());
    }

    public function test_zero_values()
    {
        putenv('COLUMNS=0');
        putenv('LINES=0');

        $terminal = new Terminal();

        $this->assertSame(0, $terminal->getWidth());
        $this->assertSame(0, $terminal->getHeight());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 