<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Output;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\StreamableInputInterface;
use Symfony\Component\Console\Output\ConsoleSectionOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Console\Question\Question;

class ConsoleSectionOutputTest extends TestCase
{
    private $stream;

    protected function setUp()
    {
        $this->stream = fopen('php://memory', 'r+b', false);
    }

    protected function tearDown()
    {
        $this->stream = null;
    }

    public function testClearAll()
    {
        $sections = [];
        $output = new ConsoleSectionOutput($this->stream, $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $output->writeln('Foo'.PHP_EOL.'Bar');
        $output->clear();

        rewind($output->getStream());
        $this->assertEquals('Foo'.PHP_EOL.'Bar'.PHP_EOL.sprintf("\x1b[%dA", 2)."\x1b[0J", stream_get_contents($output->getStream()));
    }

    public function testClearNumberOfLines()
    {
        $sections = [];
        $output = new ConsoleSectionOutput($this->stream, $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $output->writeln("Foo\nBar\nBaz\nFooBar");
        $output->clear(2);

        rewind($output->getStream());
        $this->assertEquals("Foo\nBar\nBaz\nFooBar".PHP_EOL.sprintf("\x1b[%dA", 2)."\x1b[0J", stream_get_contents($output->getStream()));
    }

    public function testClearNumberOfLinesWithMultipleSections()
    {
        $output = new StreamOutput($this->stream);
        $sections = [];
        $output1 = new ConsoleSectionOutput($output->getStream(), $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());
        $output2 = new ConsoleSectionOutput($output->getStream(), $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $output2->writeln('Foo');
        $output2->writeln('Bar');
        $output2->clear(1);
        $output1->writeln('Baz');

        rewind($output->getStream());

        $this->assertEquals('Foo'.PHP_EOL.'Bar'.PHP_EOL."\x1b[1A\x1b[0J\e[1A\e[0J".'Baz'.PHP_EOL.'Foo'.PHP_EOL, stream_get_contents($output->getStream()));
    }

    public function testClearPreservingEmptyLines()
    {
        $output = new StreamOutput($this->stream);
        $sections = [];
        $output1 = new ConsoleSectionOutput($output->getStream(), $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());
        $output2 = new ConsoleSectionOutput($output->getStream(), $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $output2->writeln(PHP_EOL.'foo');
        $output2->clear(1);
        $output1->writeln('bar');

        rewind($output->getStream());

        $this->assertEquals(PHP_EOL.'foo'.PHP_EOL."\x1b[1A\x1b[0J\x1b[1A\x1b[0J".'bar'.PHP_EOL.PHP_EOL, stream_get_contents($output->getStream()));
    }

    public function testOverwrite()
    {
        $sections = [];
        $output = new ConsoleSectionOutput($this->stream, $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $output->writeln('Foo');
        $output->overwrite('Bar');

        rewind($output->getStream());
        $this->assertEquals('Foo'.PHP_EOL."\x1b[1A\x1b[0JBar".PHP_EOL, stream_get_contents($output->getStream()));
    }

    public function testOverwriteMultipleLines()
    {
        $sections = [];
        $output = new ConsoleSectionOutput($this->stream, $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $output->writeln('Foo'.PHP_EOL.'Bar'.PHP_EOL.'Baz');
        $output->overwrite('Bar');

        rewind($output->getStream());
        $this->assertEquals('Foo'.PHP_EOL.'Bar'.PHP_EOL.'Baz'.PHP_EOL.sprintf("\x1b[%dA", 3)."\x1b[0J".'Bar'.PHP_EOL, stream_get_contents($output->getStream()));
    }

    public function testAddingMultipleSections()
    {
        $sections = [];
        $output1 = new ConsoleSectionOutput($this->stream, $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());
        $output2 = new ConsoleSectionOutput($this->stream, $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $this->assertCount(2, $sections);
    }

    public function testMultipleSectionsOutput()
    {
        $output = new StreamOutput($this->stream);
        $sections = [];
        $output1 = new ConsoleSectionOutput($output->getStream(), $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());
        $output2 = new ConsoleSectionOutput($output->getStream(), $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        $output1->writeln('Foo');
        $output2->writeln('Bar');

        $output1->overwrite('Baz');
        $output2->overwrite('Foobar');

        rewind($output->getStream());
        $this->assertEquals('Foo'.PHP_EOL.'Bar'.PHP_EOL."\x1b[2A\x1b[0JBar".PHP_EOL."\x1b[1A\x1b[0JBaz".PHP_EOL.'Bar'.PHP_EOL."\x1b[1A\x1b[0JFoobar".PHP_EOL, stream_get_contents($output->getStream()));
    }

    public function testClearSectionContainingQuestion()
    {
        $inputStream = fopen('php://memory', 'r+b', false);
        fwrite($inputStream, "Batman & Robin\n");
        rewind($inputStream);

        $input = $this->getMockBuilder(StreamableInputInterface::class)->getMock();
        $input->expects($this->once())->method('isInteractive')->willReturn(true);
        $input->expects($this->once())->method('getStream')->willReturn($inputStream);

        $sections = [];
        $output = new ConsoleSectionOutput($this->stream, $sections, OutputInterface::VERBOSITY_NORMAL, true, new OutputFormatter());

        (new QuestionHelper())->ask($input, $output, new Question('What\'s your favorite super hero?'));
        $output->clear();

        rewind($output->getStream());
        $this->assertSame('What\'s your favorite super hero?'.PHP_EOL."\x1b[2A\x1b[0J", stream_get_contents($output->getStream()));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Output;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;

class NullOutputTest extends TestCase
{
    public function testConstructor()
    {
        $output = new NullOutput();

        ob_start();
        $output->write('foo');
        $buffer = ob_get_clean();

        $this->assertSame('', $buffer, '->write() does nothing (at least nothing is printed)');
        $this->assertFalse($output->isDecorated(), '->isDecorated() returns false');
    }

    public function testVerbosity()
    {
        $output = new NullOutput();
        $this->assertSame(OutputInterface::VERBOSITY_QUIET, $output->getVerbosity(), '->getVerbosity() returns VERBOSITY_QUIET for NullOutput by default');

        $output->setVerbosity(OutputInterface::VERBOSITY_VERBOSE);
        $this->assertSame(OutputInterface::VERBOSITY_QUIET, $output->getVerbosity(), '->getVerbosity() always returns VERBOSITY_QUIET for NullOutput');
    }

    public function testSetFormatter()
    {
        $output = new NullOutput();
        $outputFormatter = new OutputFormatter();
        $output->setFormatter($outputFormatter);
        $this->assertNotSame($outputFormatter, $output->getFormatter());
    }

    public function testSetVerbosity()
    {
        $output = new NullOutput();
        $output->setVerbosity(Output::VERBOSITY_NORMAL);
        $this->assertEquals(Output::VERBOSITY_QUIET, $output->getVerbosity());
    }

    public function testSetDecorated()
    {
        $output = new NullOutput();
        $output->setDecorated(true);
        $this->assertFalse($output->isDecorated());
    }

    public function testIsQuiet()
    {
        $output = new NullOutput();
        $this->assertTrue($output->isQuiet());
    }

    public function testIsVerbose()
    {
        $output = new NullOutput();
        $this->assertFalse($output->isVerbose());
    }

    public function testIsVeryVerbose()
    {
        $output = new NullOutput();
        $this->assertFalse($output->isVeryVerbose());
    }

    public function testIsDebug()
    {
        $output = new NullOutput();
        $this->assertFalse($output->isDebug());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Output;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Output\Output;

class OutputTest extends TestCase
{
    public function testConstructor()
    {
        $output = new TestOutput(Output::VERBOSITY_QUIET, true);
        $this->assertEquals(Output::VERBOSITY_QUIET, $output->getVerbosity(), '__construct() takes the verbosity as its first argument');
        $this->assertTrue($output->isDecorated(), '__construct() takes the decorated flag as its second argument');
    }

    public function testSetIsDecorated()
    {
        $output = new TestOutput();
        $output->setDecorated(true);
        $this->assertTrue($output->isDecorated(), 'setDecorated() sets the decorated flag');
    }

    public function testSetGetVerbosity()
    {
        $output = new TestOutput();
        $output->setVerbosity(Output::VERBOSITY_QUIET);
        $this->assertEquals(Output::VERBOSITY_QUIET, $output->getVerbosity(), '->setVerbosity() sets the verbosity');

        $this->assertTrue($output->isQuiet());
        $this->assertFalse($output->isVerbose());
        $this->assertFalse($output->isVeryVerbose());
        $this->assertFalse($output->isDebug());

        $output->setVerbosity(Output::VERBOSITY_NORMAL);
        $this->assertFalse($output->isQuiet());
        $this->assertFalse($output->isVerbose());
        $this->assertFalse($output->isVeryVerbose());
        $this->assertFalse($output->isDebug());

        $output->setVerbosity(Output::VERBOSITY_VERBOSE);
        $this->assertFalse($output->isQuiet());
        $this->assertTrue($output->isVerbose());
        $this->assertFalse($output->isVeryVerbose());
        $this->assertFalse($output->isDebug());

        $output->setVerbosity(Output::VERBOSITY_VERY_VERBOSE);
        $this->assertFalse($output->isQuiet());
        $this->assertTrue($output->isVerbose());
        $this->assertTrue($output->isVeryVerbose());
        $this->assertFalse($output->isDebug());

        $output->setVerbosity(Output::VERBOSITY_DEBUG);
        $this->assertFalse($output->isQuiet());
        $this->assertTrue($output->isVerbose());
        $this->assertTrue($output->isVeryVerbose());
        $this->assertTrue($output->isDebug());
    }

    public function testWriteWithVerbosityQuiet()
    {
        $output = new TestOutput(Output::VERBOSITY_QUIET);
        $output->writeln('foo');
        $this->assertEquals('', $output->output, '->writeln() outputs nothing if verbosity is set to VERBOSITY_QUIET');
    }

    public function testWriteAnArrayOfMessages()
    {
        $output = new TestOutput();
        $output->writeln(['foo', 'bar']);
        $this->assertEquals("foo\nbar\n", $output->output, '->writeln() can take an array of messages to output');
    }

    public function testWriteAnIterableOfMessages()
    {
        $output = new TestOutput();
        $output->writeln($this->generateMessages());
        $this->assertEquals("foo\nbar\n", $output->output, '->writeln() can take an iterable of messages to output');
    }

    private function generateMessages(): iterable
    {
        yield 'foo';
        yield 'bar';
    }

    /**
     * @dataProvider provideWriteArguments
     */
    public function testWriteRawMessage($message, $type, $expectedOutput)
    {
        $output = new TestOutput();
        $output->writeln($message, $type);
        $this->assertEquals($expectedOutput, $output->output);
    }

    public function provideWriteArguments()
    {
        return [
            ['<info>foo</info>', Output::OUTPUT_RAW, "<info>foo</info>\n"],
            ['<info>foo</info>', Output::OUTPUT_PLAIN, "foo\n"],
        ];
    }

    public function testWriteWithDecorationTurnedOff()
    {
        $output = new TestOutput();
        $output->setDecorated(false);
        $output->writeln('<info>foo</info>');
        $this->assertEquals("foo\n", $output->output, '->writeln() strips decoration tags if decoration is set to false');
    }

    public function testWriteDecoratedMessage()
    {
        $fooStyle = new OutputFormatterStyle('yellow', 'red', ['blink']);
        $output = new TestOutput();
        $output->getFormatter()->setStyle('FOO', $fooStyle);
        $output->setDecorated(true);
        $output->writeln('<foo>foo</foo>');
        $this->assertEquals("\033[33;41;5mfoo\033[39;49;25m\n", $output->output, '->writeln() decorates the output');
    }

    public function testWriteWithInvalidStyle()
    {
        $output = new TestOutput();

        $output->clear();
        $output->write('<bar>foo</bar>');
        $this->assertEquals('<bar>foo</bar>', $output->output, '->write() do nothing when a style does not exist');

        $output->clear();
        $output->writeln('<bar>foo</bar>');
        $this->assertEquals("<bar>foo</bar>\n", $output->output, '->writeln() do nothing when a style does not exist');
    }

    /**
     * @dataProvider verbosityProvider
     */
    public function testWriteWithVerbosityOption($verbosity, $expected, $msg)
    {
        $output = new TestOutput();

        $output->setVerbosity($verbosity);
        $output->clear();
        $output->write('1', false);
        $output->write('2', false, Output::VERBOSITY_QUIET);
        $output->write('3', false, Output::VERBOSITY_NORMAL);
        $output->write('4', false, Output::VERBOSITY_VERBOSE);
        $output->write('5', false, Output::VERBOSITY_VERY_VERBOSE);
        $output->write('6', false, Output::VERBOSITY_DEBUG);
        $this->assertEquals($expected, $output->output, $msg);
    }

    public function verbosityProvider()
    {
        return [
            [Output::VERBOSITY_QUIET, '2', '->write() in QUIET mode only outputs when an explicit QUIET verbosity is passed'],
            [Output::VERBOSITY_NORMAL, '123', '->write() in NORMAL mode outputs anything below an explicit VERBOSE verbosity'],
            [Output::VERBOSITY_VERBOSE, '1234', '->write() in VERBOSE mode outputs anything below an explicit VERY_VERBOSE verbosity'],
            [Output::VERBOSITY_VERY_VERBOSE, '12345', '->write() in VERY_VERBOSE mode outputs anything below an explicit DEBUG verbosity'],
            [Output::VERBOSITY_DEBUG, '123456', '->write() in DEBUG mode outputs everything'],
        ];
    }
}

class TestOutput extends Output
{
    public $output = '';

    public function clear()
    {
        $this->output = '';
    }

    protected function doWrite($message, $newline)
    {
        $this->output .= $message.($newline ? "\n" : '');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Output;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\StreamOutput;

class StreamOutputTest extends TestCase
{
    protected $stream;

    protected function setUp()
    {
        $this->stream = fopen('php://memory', 'a', false);
    }

    protected function tearDown()
    {
        $this->stream = null;
    }

    public function testConstructor()
    {
        $output = new StreamOutput($this->stream, Output::VERBOSITY_QUIET, true);
        $this->assertEquals(Output::VERBOSITY_QUIET, $output->getVerbosity(), '__construct() takes the verbosity as its first argument');
        $this->assertTrue($output->isDecorated(), '__construct() takes the decorated flag as its second argument');
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The StreamOutput class needs a stream as its first argument.
     */
    public function testStreamIsRequired()
    {
        new StreamOutput('foo');
    }

    public function testGetStream()
    {
        $output = new StreamOutput($this->stream);
        $this->assertEquals($this->stream, $output->getStream(), '->getStream() returns the current stream');
    }

    public function testDoWrite()
    {
        $output = new StreamOutput($this->stream);
        $output->writeln('foo');
        rewind($output->getStream());
        $this->assertEquals('foo'.PHP_EOL, stream_get_contents($output->getStream()), '->doWrite() writes to the stream');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Question;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class ConfirmationQuestionTest extends TestCase
{
    /**
     * @dataProvider normalizerUsecases
     */
    public function testDefaultRegexUsecases($default, $answers, $expected, $message)
    {
        $sut = new ConfirmationQuestion('A question', $default);

        foreach ($answers as $answer) {
            $normalizer = $sut->getNormalizer();
            $actual = $normalizer($answer);
            $this->assertEquals($expected, $actual, sprintf($message, $answer));
        }
    }

    public function normalizerUsecases()
    {
        return [
            [
                true,
                ['y', 'Y', 'yes', 'YES', 'yEs', ''],
                true,
                'When default is true, the normalizer must return true for "%s"',
            ],
            [
                true,
                ['n', 'N', 'no', 'NO', 'nO', 'foo', '1', '0'],
                false,
                'When default is true, the normalizer must return false for "%s"',
            ],
            [
                false,
                ['y', 'Y', 'yes', 'YES', 'yEs'],
                true,
                'When default is false, the normalizer must return true for "%s"',
            ],
            [
                false,
                ['n', 'N', 'no', 'NO', 'nO', 'foo', '1', '0', ''],
                false,
                'When default is false, the normalizer must return false for "%s"',
            ],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Question;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Question\Question;

class QuestionTest extends TestCase
{
    private $question;

    protected function setUp()
    {
        parent::setUp();
        $this->question = new Question('Test question');
    }

    public function providerTrueFalse()
    {
        return [[true], [false]];
    }

    public function testGetQuestion()
    {
        self::assertSame('Test question', $this->question->getQuestion());
    }

    public function testGetDefault()
    {
        $question = new Question('Test question', 'Default value');
        self::assertSame('Default value', $question->getDefault());
    }

    public function testGetDefaultDefault()
    {
        self::assertNull($this->question->getDefault());
    }

    /**
     * @dataProvider providerTrueFalse
     */
    public function testIsSetHidden(bool $hidden)
    {
        $this->question->setHidden($hidden);
        self::assertSame($hidden, $this->question->isHidden());
    }

    public function testIsHiddenDefault()
    {
        self::assertFalse($this->question->isHidden());
    }

    public function testSetHiddenWithAutocompleterCallback()
    {
        $this->question->setAutocompleterCallback(
            function (string $input): array { return []; }
        );

        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage(
            'A hidden question cannot use the autocompleter.'
        );

        $this->question->setHidden(true);
    }

    public function testSetHiddenWithNoAutocompleterCallback()
    {
        $this->question->setAutocompleterCallback(
            function (string $input): array { return []; }
        );
        $this->question->setAutocompleterCallback(null);

        $exception = null;
        try {
            $this->question->setHidden(true);
        } catch (\Exception $exception) {
            // Do nothing
        }

        $this->assertNull($exception);
    }

    /**
     * @dataProvider providerTrueFalse
     */
    public function testIsSetHiddenFallback(bool $hidden)
    {
        $this->question->setHiddenFallback($hidden);
        self::assertSame($hidden, $this->question->isHiddenFallback());
    }

    public function testIsHiddenFallbackDefault()
    {
        self::assertTrue($this->question->isHiddenFallback());
    }

    public function providerGetSetAutocompleterValues()
    {
        return [
            'array' => [
                ['a', 'b', 'c', 'd'],
                ['a', 'b', 'c', 'd'],
            ],
            'associative array' => [
                ['a' => 'c', 'b' => 'd'],
                ['a', 'b', 'c', 'd'],
            ],
            'iterator' => [
                new \ArrayIterator(['a', 'b', 'c', 'd']),
                ['a', 'b', 'c', 'd'],
            ],
            'null' => [null, null],
        ];
    }

    /**
     * @dataProvider providerGetSetAutocompleterValues
     */
    public function testGetSetAutocompleterValues($values, $expectValues)
    {
        $this->question->setAutocompleterValues($values);
        self::assertSame(
            $expectValues,
            $this->question->getAutocompleterValues()
        );
    }

    public function providerSetAutocompleterValuesInvalid()
    {
        return [
            ['Potato'],
            [new \stdclass()],
            [false],
        ];
    }

    /**
     * @dataProvider providerSetAutocompleterValuesInvalid
     */
    public function testSetAutocompleterValuesInvalid($values)
    {
        self::expectException(InvalidArgumentExcepti