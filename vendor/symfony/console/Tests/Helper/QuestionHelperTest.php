<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Style;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Tester\CommandTester;

class SymfonyStyleTest extends TestCase
{
    /** @var Command */
    protected $command;
    /** @var CommandTester */
    protected $tester;
    private $colSize;

    protected function setUp()
    {
        $this->colSize = getenv('COLUMNS');
        putenv('COLUMNS=121');
        $this->command = new Command('sfstyle');
        $this->tester = new CommandTester($this->command);
    }

    protected function tearDown()
    {
        putenv($this->colSize ? 'COLUMNS='.$this->colSize : 'COLUMNS');
        $this->command = null;
        $this->tester = null;
    }

    /**
     * @dataProvider inputCommandToOutputFilesProvider
     */
    public function testOutputs($inputCommandFilepath, $outputFilepath)
    {
        $code = require $inputCommandFilepath;
        $this->command->setCode($code);
        $this->tester->execute([], ['interactive' => false, 'decorated' => false]);
        $this->assertStringEqualsFile($outputFilepath, $this->tester->getDisplay(true));
    }

    /**
     * @dataProvider inputInteractiveCommandToOutputFilesProvider
     */
    public function testInteractiveOutputs($inputCommandFilepath, $outputFilepath)
    {
        $code = require $inputCommandFilepath;
        $this->command->setCode($code);
        $this->tester->execute([], ['interactive' => true, 'decorated' => false]);
        $this->assertStringEqualsFile($outputFilepath, $this->tester->getDisplay(true));
    }

    public function inputInteractiveCommandToOutputFilesProvider()
    {
        $baseDir = __DIR__.'/../Fixtures/Style/SymfonyStyle';

        return array_map(null, glob($baseDir.'/command/interactive_command_*.php'), glob($baseDir.'/output/interactive_output_*.txt'));
    }

    public function inputCommandToOutputFilesProvider()
    {
        $baseDir = __DIR__.'/../Fixtures/Style/SymfonyStyle';

        return array_map(null, glob($baseDir.'/command/command_*.php'), glob($baseDir.'/output/output_*.txt'));
    }

    public function testGetErrorStyle()
    {
        $input = $this->getMockBuilder(InputInterface::class)->getMock();

        $errorOutput = $this->getMockBuilder(OutputInterface::class)->getMock();
        $errorOutput
            ->method('getFormatter')
            ->willReturn(new OutputFormatter());
        $errorOutput
            ->expects($this->once())
            ->method('write');

        $output = $this->getMockBuilder(ConsoleOutputInterface::class)->getMock();
        $output
            ->method('getFormatter')
            ->willReturn(new OutputFormatter());
        $output
            ->expects($this->once())
            ->method('getErrorOutput')
            ->willReturn($errorOutput);

        $io = new SymfonyStyle($input, $output);
        $io->getErrorStyle()->write('');
    }

    public function testGetErrorStyleUsesTheCurrentOutputIfNoErrorOutputIsAvailable()
    {
        $output = $this->getMockBuilder(OutputInterface::class)->getMock();
        $output
            ->method('getFormatter')
            ->willReturn(new OutputFormatter());

        $style = new SymfonyStyle($this->getMockBuilder(InputInterface::class)->getMock(), $output);

        $this->assertInstanceOf(SymfonyStyle::class, $style->getErrorStyle());
    }
}
                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Tester;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Tester\ApplicationTester;

class ApplicationTesterTest extends TestCase
{
    protected $application;
    protected $tester;

    protected function setUp()
    {
        $this->application = new Application();
        $this->application->setAutoExit(false);
        $this->application->register('foo')
            ->addArgument('foo')
            ->setCode(function ($input, $output) {
                $output->writeln('foo');
            })
        ;

        $this->tester = new ApplicationTester($this->application);
        $this->tester->run(['command' => 'foo', 'foo' => 'bar'], ['interactive' => false, 'decorated' => false, 'verbosity' => Output::VERBOSITY_VERBOSE]);
    }

    protected function tearDown()
    {
        $this->application = null;
        $this->tester = null;
    }

    public function testRun()
    {
        $this->assertFalse($this->tester->getInput()->isInteractive(), '->execute() takes an interactive option');
        $this->assertFalse($this->tester->getOutput()->isDecorated(), '->execute() takes a decorated option');
        $this->assertEquals(Output::VERBOSITY_VERBOSE, $this->tester->getOutput()->getVerbosity(), '->execute() takes a verbosity option');
    }

    public function testGetInput()
    {
        $this->assertEquals('bar', $this->tester->getInput()->getArgument('foo'), '->getInput() returns the current input instance');
    }

    public function testGetOutput()
    {
        rewind($this->tester->getOutput()->getStream());
        $this->assertEquals('foo'.PHP_EOL, stream_get_contents($this->tester->getOutput()->getStream()), '->getOutput() returns the current output instance');
    }

    public function testGetDisplay()
    {
        $this->assertEquals('foo'.PHP_EOL, $this->tester->getDisplay(), '->getDisplay() returns the display of the last execution');
    }

    public function testSetInputs()
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->register('foo')->setCode(function ($input, $output) {
            $helper = new QuestionHelper();
            $helper->ask($input, $output, new Question('Q1'));
            $helper->ask($input, $output, new Question('Q2'));
            $helper->ask($input, $output, new Question('Q3'));
        });
        $tester = new ApplicationTester($application);

        $tester->setInputs(['I1', 'I2', 'I3']);
        $tester->run(['command' => 'foo']);

        $this->assertSame(0, $tester->getStatusCode());
        $this->assertEquals('Q1Q2Q3', $tester->getDisplay(true));
    }

    public function testGetStatusCode()
    {
        $this->assertSame(0, $this->tester->getStatusCode(), '->getStatusCode() returns the status code');
    }

    public function testErrorOutput()
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->register('foo')
            ->addArgument('foo')
            ->setCode(function ($input, $output) {
                $output->getErrorOutput()->write('foo');
            })
        ;

        $tester = new ApplicationTester($application);
        $tester->run(
            ['command' => 'foo', 'foo' => 'bar'],
            ['capture_stderr_separately' => true]
        );

        $this->assertSame('foo', $tester->getErrorOutput());
    }
}
                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Tester;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Tester\CommandTester;

class CommandTesterTest extends TestCase
{
    protected $command;
    protected $tester;

    protected function setUp()
    {
        $this->command = new Command('foo');
        $this->command->addArgument('command');
        $this->command->addArgument('foo');
        $this->command->setCode(function ($input, $output) { $output->writeln('foo'); });

        $this->tester = new CommandTester($this->command);
        $this->tester->execute(['foo' => 'bar'], ['interactive' => false, 'decorated' => false, 'verbosity' => Output::VERBOSITY_VERBOSE]);
    }

    protected function tearDown()
    {
        $this->command = null;
        $this->tester = null;
    }

    public function testExecute()
    {
        $this->assertFalse($this->tester->getInput()->isInteractive(), '->execute() takes an interactive option');
        $this->assertFalse($this->tester->getOutput()->isDecorated(), '->execute() takes a decorated option');
        $this->assertEquals(Output::VERBOSITY_VERBOSE, $this->tester->getOutput()->getVerbosity(), '->execute() takes a verbosity option');
    }

    public function testGetInput()
    {
        $this->assertEquals('bar', $this->tester->getInput()->getArgument('foo'), '->getInput() returns the current input instance');
    }

    public function testGetOutput()
    {
        rewind($this->tester->getOutput()->getStream());
        $this->assertEquals('foo'.PHP_EOL, stream_get_contents($this->tester->getOutput()->getStream()), '->getOutput() returns the current output instance');
    }

    public function testGetDisplay()
    {
        $this->assertEquals('foo'.PHP_EOL, $this->tester->getDisplay(), '->getDisplay() returns the display of the last execution');
    }

    public function testGetStatusCode()
    {
        $this->assertSame(0, $this->tester->getStatusCode(), '->getStatusCode() returns the status code');
    }

    public function testCommandFromApplication()
    {
        $application = new Application();
        $application->setAutoExit(false);

        $command = new Command('foo');
        $command->setCode(function ($input, $output) { $output->writeln('foo'); });

        $application->add($command);

        $tester = new CommandTester($application->find('foo'));

        // check that there is no need to pass the command name here
        $this->assertEquals(0, $tester->execute([]));
    }

    public function testCommandWithInputs()
    {
        $questions = [
            'What\'s your name?',
            'How are you?',
            'Where do you come from?',
        ];

        $command = new Command('foo');
        $command->setHelperSet(new HelperSet([new QuestionHelper()]));
        $command->setCode(function ($input, $output) use ($questions, $command) {
            $helper = $command->getHelper('question');
            $helper->ask($input, $output, new Question($questions[0]));
            $helper->ask($input, $output, new Question($questions[1]));
            $helper->ask($input, $output, new Question($questions[2]));
        });

        $tester = new CommandTester($command);
        $tester->setInputs(['Bobby', 'Fine', 'France']);
        $tester->execute([]);

        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertEquals(implode('', $questions), $tester->getDisplay(true));
    }

    public function testCommandWithDefaultInputs()
    {
        $questions = [
            'What\'s your name?',
            'How are you?',
            'Where do you come from?',
        ];

        $command = new Command('foo');
        $command->setHelperSet(new HelperSet([new QuestionHelper()]));
        $command->setCode(function ($input, $output) use ($questions, $command) {
            $helper = $command->getHelper('question');
            $helper->ask($input, $output, new Question($questions[0], 'Bobby'));
            $helper->ask($input, $output, new Question($questions[1], 'Fine'));
            $helper->ask($input, $output, new Question($questions[2], 'France'));
        });

        $tester = new CommandTester($command);
        $tester->setInputs(['', '', '']);
        $tester->execute([]);

        $this->assertEquals(0, $tester->getStatusCode());
        $this->assertEquals(implode('', $questions), $tester->getDisplay(true));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Aborted.
     */
    public function testCommandWithWrongInputsNumber()
    {
        $questions = [
            'What\'s your name?',
            'How are you?',
            'Where do you come from?',
        ];

        $command = new Command('foo');
        $command->setHelperSet(new HelperSet([new QuestionHelper()]));
        $command->setCode(function ($input, $output) use ($questions, $command) {
            $helper = $command->getHelper('question');
            $helper->ask($input, $output, new ChoiceQuestion('choice', ['a', 'b']));
            $helper->ask($input, $output, new Question($questions[0]));
            $helper->ask($input, $output, new Question($questions[1]));
            $helper->ask($input, $output, new Question($questions[2]));
        });

        $tester = new CommandTester($command);
        $tester->setInputs(['a', 'Bobby', 'Fine']);
        $tester->execute([]);
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Aborted.
     */
    public function testCommandWithQuestionsButNoInputs()
    {
        $questions = [
            'What\'s your name?',
            'How are you?',
            'Where do you come from?',
        ];

        $command = new Command('foo');
        $command->setHelperSet(new HelperSet([new QuestionHelper()]));
        $command->setCode(function ($input, $output) use ($questions, $command) {
            $helper = $command->getHelper('question');
            $helper->ask($input, $output, new ChoiceQuestion('choice', ['a', 'b']));
            $helper->ask($input, $output, new Question($questions[0]));
            $helper->ask($input, $output, new Question($questions[1]));
            $helper->ask($input, $output, new Question($questions[2]));
        });

        $tester = new CommandTester($command);
        $tester->execute([]);
    }

    public function testSymfonyStyleCommandWithInputs()
    {
        $questions = [
            'What\'s your name?',
            'How are you?',
            'Where do you come from?',
        ];

        $command = new Command('foo');
        $command->setCode(function ($input, $output) use ($questions, $command) {
            $io = new SymfonyStyle($input, $output);
            $io->ask($questions[0]);
            $io->ask($questions[1]);
            $io->ask($questions[2]);
        });

        $tester = new CommandTester($command);
        $tester->setInputs(['Bobby', 'Fine', 'France']);
        $tester->execute([]);

        $this->assertEquals(0, $tester->getStatusCode());
    }

    public function testErrorOutput()
    {
        $command = new Command('foo');
        $command->addArgument('command');
        $command->addArgument('foo');
        $command->setCode(function ($input, $output) {
            $output->getErrorOutput()->write('foo');
        }
        );

        $tester = new CommandTester($command);
        $tester->execute(
            ['foo' => 'bar'],
            ['capture_stderr_separately' => true]
        );

        $this->assertSame('foo', $tester->getErrorOutput());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   {
    "name": "symfony/contracts",
    "type": "library",
    "description": "A set of abstractions extracted out of the Symfony components",
    "keywords": ["abstractions", "contracts", "decoupling", "interfaces", "interoperability", "standards"],
    "homepage": "https://symfony.com",
    "license": "MIT",
    "authors": [
        {
            "name": "Nicolas Grekas",
            "email": "p@tchwork.com"
        },
        {
            "name": "Symfony Community",
            "homepage": "https://symfony.com/contributors"
        }
    ],
    "require": {
        "php": "^7.1.3"
    },
    "require-dev": {
        "psr/cache": "^1.0",
        "psr/container": "^1.0"
    },
    "suggest": {
        "psr/cache": "When using the Cache contracts",
        "psr/container": "When using the Service contracts",
        "symfony/cache-contracts-implementation": "",
        "symfony/service-contracts-implementation": "",
        "symfony/translation-contracts-implementation": ""
    },
    "autoload": {
        "psr-4": { "Symfony\\Contracts\\": "" },
        "exclude-from-classmap": [
            "**/Tests/"
        ]
    },
    "minimum-stability": "dev",
    "extra": {
        "branch-alias": {
            "dev-master": "1.0-dev"
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             Copyright (c) 2018 Fabien Potencier

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?xml version="1.0" encoding="UTF-8"?>

<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/5.2/phpunit.xsd"
         backupGlobals="false"
         colors="true"
         bootstrap="vendor/autoload.php"
         failOnRisky="true"
         failOnWarning="true"
>
    <php>
        <ini name="error_reporting" value="-1" />
    </php>

    <testsuites>
        <testsuite name="Symfony Contracts Test Suite">
            <directory>./Tests/</directory>
        </testsuite>
    </testsuites>

    <filter>
        <whitelist>
            <directory>./</directory>
            <exclude>
                <directory>./Tests</directory>
                <directory>./vendor</directory>
            </exclude>
        </whitelist>
    </filter>

</phpunit>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    