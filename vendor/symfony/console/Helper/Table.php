<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tester;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;

/**
 * @author Amrouche Hamza <hamza.simperfit@gmail.com>
 */
trait TesterTrait
{
    /** @var StreamOutput */
    private $output;
    private $inputs = [];
    private $captureStreamsIndependently = false;

    /**
     * Gets the display returned by the last execution of the command or application.
     *
     * @param bool $normalize Whether to normalize end of lines to \n or not
     *
     * @return string The display
     */
    public function getDisplay($normalize = false)
    {
        if (null === $this->output) {
            throw new \RuntimeException('Output not initialized, did you execute the command before requesting the display?');
        }

        rewind($this->output->getStream());

        $display = stream_get_contents($this->output->getStream());

        if ($normalize) {
            $display = str_replace(PHP_EOL, "\n", $display);
        }

        return $display;
    }

    /**
     * Gets the output written to STDERR by the application.
     *
     * @param bool $normalize Whether to normalize end of lines to \n or not
     *
     * @return string
     */
    public function getErrorOutput($normalize = false)
    {
        if (!$this->captureStreamsIndependently) {
            throw new \LogicException('The error output is not available when the tester is run without "capture_stderr_separately" option set.');
        }

        rewind($this->output->getErrorOutput()->getStream());

        $display = stream_get_contents($this->output->getErrorOutput()->getStream());

        if ($normalize) {
            $display = str_replace(PHP_EOL, "\n", $display);
        }

        return $display;
    }

    /**
     * Gets the input instance used by the last execution of the command or application.
     *
     * @return InputInterface The current input instance
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Gets the output instance used by the last execution of the command or application.
     *
     * @return OutputInterface The current output instance
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Gets the status code returned by the last execution of the command or application.
     *
     * @return int The status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the user inputs.
     *
     * @param array $inputs An array of strings representing each input
     *                      passed to the command input stream
     *
     * @return self
     */
    public function setInputs(array $inputs)
    {
        $this->inputs = $inputs;

        return $this;
    }

    /**
     * Initializes the output property.
     *
     * Available options:
     *
     *  * decorated:                 Sets the output decorated flag
     *  * verbosity:                 Sets the output verbosity flag
     *  * capture_stderr_separately: Make output of stdOut and stdErr separately available
     */
    private function initOutput(array $options)
    {
        $this->captureStreamsIndependently = \array_key_exists('capture_stderr_separately', $options) && $options['capture_stderr_separately'];
        if (!$this->captureStreamsIndependently) {
            $this->output = new StreamOutput(fopen('php://memory', 'w', false));
            if (isset($options['decorated'])) {
                $this->output->setDecorated($options['decorated']);
            }
            if (isset($options['verbosity'])) {
                $this->output->setVerbosity($options['verbosity']);
            }
        } else {
            $this->output = new ConsoleOutput(
                isset($options['verbosity']) ? $options['verbosity'] : ConsoleOutput::VERBOSITY_NORMAL,
                isset($options['decorated']) ? $options['decorated'] : null
            );

            $errorOutput = new StreamOutput(fopen('php://memory', 'w', false));
            $errorOutput->setFormatter($this->output->getFormatter());
            $errorOutput->setVerbosity($this->output->getVerbosity());
            $errorOutput->setDecorated($this->output->isDecorated());

            $reflectedOutput = new \ReflectionObject($this->output);
            $strErrProperty = $reflectedOutput->getProperty('stderr');
            $strErrProperty->setAccessible(true);
            $strErrProperty->setValue($this->output, $errorOutput);

            $reflectedParent = $reflectedOutput->getParentClass();
            $streamProperty = $reflectedParent->getProperty('stream');
            $streamProperty->setAccessible(true);
            $streamProperty->setValue($this->output, fopen('php://memory', 'w', false));
        }
    }

    private static function createStream(array $inputs)
    {
        $stream = fopen('php://memory', 'r+', false);

        foreach ($inputs as $input) {
            fwrite($stream, $input.PHP_EOL);
        }

        rewind($stream);

        return $stream;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

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
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\FactoryCommandLoader;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\Console\Event\ConsoleTerminateEvent;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Symfony\Component\Console\Exception\NamespaceNotFoundException;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Tester\ApplicationTester;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ApplicationTest extends TestCase
{
    protected static $fixturesPath;

    private $colSize;

    protected function setUp()
    {
        $this->colSize = getenv('COLUMNS');
    }

    protected function tearDown()
    {
        putenv($this->colSize ? 'COLUMNS='.$this->colSize : 'COLUMNS');
        putenv('SHELL_VERBOSITY');
        unset($_ENV['SHELL_VERBOSITY']);
        unset($_SERVER['SHELL_VERBOSITY']);
    }

    public static function setUpBeforeClass()
    {
        self::$fixturesPath = realpath(__DIR__.'/Fixtures/');
        require_once self::$fixturesPath.'/FooCommand.php';
        require_once self::$fixturesPath.'/FooOptCommand.php';
        require_once self::$fixturesPath.'/Foo1Command.php';
        require_once self::$fixturesPath.'/Foo2Command.php';
        require_once self::$fixturesPath.'/Foo3Command.php';
        require_once self::$fixturesPath.'/Foo4Command.php';
        require_once self::$fixturesPath.'/Foo5Command.php';
        require_once self::$fixturesPath.'/FooSameCaseUppercaseCommand.php';
        require_once self::$fixturesPath.'/FooSameCaseLowercaseCommand.php';
        require_once self::$fixturesPath.'/FoobarCommand.php';
        require_once self::$fixturesPath.'/BarBucCommand.php';
        require_once self::$fixturesPath.'/FooSubnamespaced1Command.php';
        require_once self::$fixturesPath.'/FooSubnamespaced2Command.php';
        require_once self::$fixturesPath.'/FooWithoutAliasCommand.php';
        require_once self::$fixturesPath.'/TestTiti.php';
        require_once self::$fixturesPath.'/TestToto.php';
    }

    protected function normalizeLineBreaks($text)
    {
        return str_replace(PHP_EOL, "\n", $text);
    }

    /**
     * Replaces the dynamic placeholders of the command help text with a static version.
     * The placeholder %command.full_name% includes the script path that is not predictable
     * and can not be tested against.
     */
    protected function ensureStaticCommandHelp(Application $application)
    {
        foreach ($application->all() as $command) {
            $command->setHelp(str_replace('%command.full_name%', 'app/console %command.name%', $command->getHelp()));
        }
    }

    public function testConstructor()
    {
        $application = new Application('foo', 'bar');
        $this->assertEquals('foo', $application->getName(), '__construct() takes the application name as its first argument');
        $this->assertEquals('bar', $application->getVersion(), '__construct() takes the application version as its second argument');
        $this->assertEquals(['help', 'list'], array_keys($application->all()), '__construct() registered the help and list commands by default');
    }

    public function testSetGetName()
    {
        $application = new Application();
        $application->setName('foo');
        $this->assertEquals('foo', $application->getName(), '->setName() sets the name of the application');
    }

    public function testSetGetVersion()
    {
        $application = new Application();
        $application->setVersion('bar');
        $this->assertEquals('bar', $application->getVersion(), '->setVersion() sets the version of the application');
    }

    public function testGetLongVersion()
    {
        $application = new Application('foo', 'bar');
        $this->assertEquals('foo <info>bar</info>', $application->getLongVersion(), '->getLongVersion() returns the long version of the application');
    }

    public function testHelp()
    {
        $application = new Application();
        $this->assertStringEqualsFile(self::$fixturesPath.'/application_gethelp.txt', $this->normalizeLineBreaks($application->getHelp()), '->getHelp() returns a help message');
    }

    public function testAll()
    {
        $application = new Application();
        $commands = $application->all();
        $this->assertInstanceOf('Symfony\\Component\\Console\\Command\\HelpCommand', $commands['help'], '->all() returns the registered commands');

        $application->add(new \FooCommand());
        $commands = $application->all('foo');
        $this->assertCount(1, $commands, '->all() takes a namespace as its first argument');
    }

    public function testAllWithCommandLoader()
    {
        $application = new Application();
        $commands = $application->all();
        $this->assertInstanceOf('Symfony\\Component\\Console\\Command\\HelpCommand', $commands['help'], '->all() returns the registered commands');

        $application->add(new \FooCommand());
        $commands = $application->all('foo');
        $this->assertCount(1, $commands, '->all() takes a namespace as its first argument');

        $application->setCommandLoader(new FactoryCommandLoader([
            'foo:bar1' => function () { return new \Foo1Command(); },
        ]));
        $commands = $application->all('foo');
        $this->assertCount(2, $commands, '->all() takes a namespace as its first argument');
        $this->assertInstanceOf(\FooCommand::class, $commands['foo:bar'], '->all() returns the registered commands');
        $this->assertInstanceOf(\Foo1Command::class, $commands['foo:bar1'], '->all() returns the registered commands');
    }

    public function testRegister()
    {
        $application = new Application();
        $command = $application->register('foo');
        $this->assertEquals('foo', $command->getName(), '->register() registers a new command');
    }

    public function testAdd()
    {
        $application = new Application();
        $application->add($foo = new \FooCommand());
        $commands = $application->all();
        $this->assertEquals($foo, $commands['foo:bar'], '->add() registers a command');

        $application = new Application();
        $application->addCommands([$foo = new \FooCommand(), $foo1 = new \Foo1Command()]);
        $commands = $application->all();
        $this->assertEquals([$foo, $foo1], [$commands['foo:bar'], $commands['foo:bar1']], '->addCommands() registers an array of commands');
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Command class "Foo5Command" is not correctly initialized. You probably forgot to call the parent constructor.
     */
    public function testAddCommandWithEmptyConstructor()
    {
        $application = new Application();
        $application->add(new \Foo5Command());
    }

    public function testHasGet()
    {
        $application = new Application();
        $this->assertTrue($application->has('list'), '->has() returns true if a named command is registered');
        $this->assertFalse($application->has('afoobar'), '->has() returns false if a named command is not registered');

        $application->add($foo = new \FooCommand());
        $this->assertTrue($application->has('afoobar'), '->has() returns true if an alias is registered');
        $this->assertEquals($foo, $application->get('foo:bar'), '->get() returns a command by name');
        $this->assertEquals($foo, $application->get('afoobar'), '->get() returns a command by alias');

        $application = new Application();
        $application->add($foo = new \FooCommand());
        // simulate --help
        $r = new \ReflectionObject($application);
        $p = $r->getProperty('wantHelps');
        $p->setAccessible(true);
        $p->setValue($application, true);
        $command = $application->get('foo:bar');
        $this->assertInstanceOf('Symfony\Component\Console\Command\HelpCommand', $command, '->get() returns the help command if --help is provided as the input');
    }

    public function testHasGetWithCommandLoader()
    {
        $application = new Application();
        $this->assertTrue($application->has('list'), '->has() returns true if a named command is registered');
        $this->assertFalse($application->has('afoobar'), '->has() returns false if a named command is not registered');

        $application->add($foo = new \FooCommand());
        $this->assertTrue($application->has('afoobar'), '->has() returns true if an alias is registered');
        $this->assertEquals($foo, $application->get('foo:bar'), '->get() returns a command by name');
        $this->assertEquals($foo, $application->get('afoobar'), '->get() returns a command by alias');

        $application->setCommandLoader(new FactoryCommandLoader([
            'foo:bar1' => function () { return new \Foo1Command(); },
        ]));

        $this->assertTrue($application->has('afoobar'), '->has() returns true if an instance is registered for an alias even with command loader');
        $this->assertEquals($foo, $application->get('foo:bar'), '->get() returns an instance by name even with command loader');
        $this->assertEquals($foo, $application->get('afoobar'), '->get() returns an instance by alias even with command loader');
        $this->assertTrue($application->has('foo:bar1'), '->has() returns true for commands registered in the loader');
        $this->assertInstanceOf(\Foo1Command::class, $foo1 = $application->get('foo:bar1'), '->get() returns a command by name from the command loader');
        $this->assertTrue($application->has('afoobar1'), '->has() returns true for commands registered in the loader');
        $this->assertEquals($foo1, $application->get('afoobar1'), '->get() returns a command by name from the command loader');
    }

    public function testSilentHelp()
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);

        $tester = new ApplicationTester($application);
        $tester->run(['-h' => true, '-q' => true], ['decorated' => false]);

        $this->assertEmpty($tester->getDisplay(true));
    }

    /**
     * @expectedException        \Symfony\Component\Console\Exception\CommandNotFoundException
     * @expectedExceptionMessage The command "foofoo" does not exist.
     */
    public function testGetInvalidCommand()
    {
        $application = new Application();
        $application->get('foofoo');
    }

    public function testGetNamespaces()
    {
        $application = new Application();
        $application->add(new \FooCommand());
        $application->add(new \Foo1Command());
        $this->assertEquals(['foo'], $application->getNamespaces(), '->getNamespaces() returns an array of unique used namespaces');
    }

    public function testFindNamespace()
    {
        $application = new Application();
        $application->add(new \FooCommand());
        $this->assertEquals('foo', $application->findNamespace('foo'), '->findNamespace() returns the given namespace if it exists');
        $this->assertEquals('foo', $application->findNamespace('f'), '->findNamespace() finds a namespace given an abbreviation');
        $application->add(new \Foo2Command());
        $this->assertEquals('foo', $application->findNamespace('foo'), '->findNamespace() returns the given namespace if it exists');
    }

    public function testFindNamespaceWithSubnamespaces()
    {
        $application = new Application();
        $application->add(new \FooSubnamespaced1Command());
        $application->add(new \FooSubnamespaced2Command());
        $this->assertEquals('foo', $application->findNamespace('foo'), '->findNamespace() returns commands even if the commands are only contained in subnamespaces');
    }

    public function testFindAmbiguousNamespace()
    {
        $application = new Application();
        $application->add(new \BarBucCommand());
        $application->add(new \FooCommand());
        $application->add(new \Foo2Command());

        $expectedMsg = "The namespace \"f\" is ambiguous.\nDid you mean one of these?\n    foo\n    foo1";

        if (method_exists($this, 'expectException')) {
            $this->expectException(NamespaceNotFoundException::class);
            $this->expectExceptionMessage($expectedMsg);
        } else {
            $this->setExpectedException(NamespaceNotFoundException::class, $expectedMsg);
        }

        $application->findNamespace('f');
    }

    public function testFindNonAmbiguous()
    {
        $application = new Application();
        $application->add(new \TestTiti());
        $application->add(new \TestToto());
        $this->assertEquals('test-toto', $application->find('test')->getName());
    }

    /**
     * @expectedException        \Symfony\Component\Console\Exception\NamespaceNotFoundException
     * @expectedExceptionMessage There are no commands defined in the "bar" namespace.
     */
    public function testFindInvalidNamespace()
    {
        $application = new Application();
        $application->findNamespace('bar');
    }

    /**
     * @expectedException        \Symfony\Component\Console\Exception\CommandNotFoundException
     * @expectedExceptionMessage Command "foo1" is not defined
     */
    public function testFindUniqueNameButNamespaceName()
    {
        $application = new Application();
        $application->add(new \FooCommand());
        $application->add(new \Foo1Command());
        $application->add(new \Foo2Command());

        $application->find($commandName = 'foo1');
    }

    public function testFind()
    {
        $application = new Application();
        $application->add(new \FooCommand());

        $this->assertInstanceOf('FooCommand', $application->find('foo:bar'), '->find() returns a command if its name exists');
        $this->assertInstanceOf('Symfony\Component\Console\Command\HelpCommand', $application->find('h'), '->find() returns a command if its name exists');
        $this->assertInstanceOf('FooCommand', $application->find('f:bar'), '->find() returns a command if the abbreviation for the namespace exists');
        $this->assertInstanceOf('FooCommand', $application->find('f:b'), '->find() returns a command if the abbreviation for the namespace and the command name exist');
        $this->assertInstanceOf('FooCommand', $application->find('a'), '->find() returns a command if the abbreviation exists for an alias');
    }

    public function testFindCaseSensitiveFirst()
    {
        $application = new Application();
        $application->add(new \FooSameCaseUppercaseCommand());
        $application->add(new \FooSameCaseLowercaseCommand());

        $this->assertInstanceOf('FooSameCaseUppercaseCommand', $application->find('f:B'), '->find() returns a command if the abbreviation is the correct case');
        $this->assertInstanceOf('FooSameCaseUppercaseCommand', $application->find('f:BAR'), '->find() returns a command if the abbreviation is the correct case');
        $this->assertInstanceOf('FooSameCaseLowercaseCommand', $application->find('f:b'), '->find() returns a command if the abbreviation is the correct case');
        $this->assertInstanceOf('FooSameCaseLowercaseCommand', $application->find('f:bar'), '->find() returns a command if the abbreviation is the correct case');
    }

    public function testFindCaseInsensitiveAsFallback()
    {
        $application = new Application();
        $application->add(new \FooSameCaseLowercaseCommand());

        $this->assertInstanceOf('FooSameCaseLowercaseCommand', $application->find('f:b'), '->find() returns a command if the abbreviation is the correct case');
        $this->assertInstanceOf('FooSameCaseLowercaseCommand', $application->find('f:B'), '->find() will fallback to case insensitivity');
        $this->assertInstanceOf('FooSameCaseLowercaseCommand', $application->find('FoO:BaR'), '->find() will fallback to case insensitivity');
    }

    /**
     * @expectedException        \Symfony\Component\Console\Exception\CommandNotFoundException
     * @expectedExceptionMessage Command "FoO:BaR" is ambiguous
     */
    public function testFindCaseInsensitiveSuggestions()
    {
        $application = new Application();
        $application->add(new \FooSameCaseLowercaseCommand());
        $application->add(new \FooSameCaseUppercaseCommand());

        $this->assertInstanceOf('FooSameCaseLowercaseCommand', $application->find('FoO:BaR'), '->find() will find two suggestions with case insensitivity');
    }

    public function testFindWithC