<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Formatter;

use Psy\Formatter\DocblockFormatter;

class DocblockFormatterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * This is a docblock!
     *
     * @author Justin Hileman <justin@justinhileman.info>
     *
     * @throws InvalidArgumentException if $foo is empty
     *
     * @param mixed $foo It's a foo thing
     * @param int   $bar This is definitely bar
     *
     * @return string A string of no consequence
     */
    private function methodWithDocblock($foo, $bar = 1)
    {
        if (empty($foo)) {
            throw new \InvalidArgumentException();
        }

        return 'method called';
    }

    public function testFormat()
    {
        $expected = <<<EOS
<comment>Description:</comment>
  This is a docblock!

<comment>Throws:</comment>
  <info>InvalidArgumentException </info> if \$foo is empty

<comment>Param:</comment>
  <info>mixed </info> <strong>\$foo </strong> It's a foo thing
  <info>int   </info> <strong>\$bar </strong> This is definitely bar

<comment>Return:</comment>
  <info>string </info> A string of no consequence

<comment>Author:</comment> Justin Hileman \<justin@justinhileman.info>
EOS;

        $this->assertSame(
            $expected,
            DocblockFormatter::format(new \ReflectionMethod($this, 'methodWithDocblock'))
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Formatter;

use Psy\Formatter\SignatureFormatter;
use Psy\Reflection\ReflectionClassConstant;
use Psy\Reflection\ReflectionConstant_;

class SignatureFormatterTest extends \PHPUnit\Framework\TestCase
{
    const FOO = 'foo value';
    private static $bar = 'bar value';

    private function someFakeMethod(array $one, $two = 'TWO', \Reflector $three = null)
    {
    }

    /**
     * @dataProvider signatureReflectors
     */
    public function testFormat($reflector, $expected)
    {
        $this->assertSame($expected, \strip_tags(SignatureFormatter::format($reflector)));
    }

    public function signatureReflectors()
    {
        return [
            [
                new \ReflectionFunction('implode'),
                \defined('HHVM_VERSION') ? 'function implode($arg1, $arg2 = null)' : 'function implode($glue, $pieces)',
            ],
            [
                ReflectionClassConstant::create($this, 'FOO'),
                'const FOO = "foo value"',
            ],
            [
                new \ReflectionMethod($this, 'someFakeMethod'),
                'private function someFakeMethod(array $one, $two = \'TWO\', Reflector $three = null)',
            ],
            [
                new \ReflectionProperty($this, 'bar'),
                'private static $bar',
            ],
            [
                new \ReflectionClass('Psy\CodeCleaner\CodeCleanerPass'),
                'abstract class Psy\CodeCleaner\CodeCleanerPass '
                . 'extends PhpParser\NodeVisitorAbstract '
                . 'implements PhpParser\NodeVisitor',
            ],
            [
                new \ReflectionFunction('array_chunk'),
                'function array_chunk($arg, $size, $preserve_keys = unknown)',
            ],
            [
                new \ReflectionClass('Psy\Test\Formatter\Fixtures\BoringTrait'),
                'trait Psy\Test\Formatter\Fixtures\BoringTrait',
            ],
            [
                new \ReflectionMethod('Psy\Test\Formatter\Fixtures\BoringTrait', 'boringMethod'),
                'public function boringMethod($one = 1)',
            ],
            [
                new ReflectionConstant_('E_ERROR'),
                'define("E_ERROR", 1)',
            ],
            [
                new ReflectionConstant_('PHP_VERSION'),
                'define("PHP_VERSION", "' . PHP_VERSION . '")',
            ],
            [
                new ReflectionConstant_('__LINE__'),
                'define("__LINE__", null)', // @todo show this as `unknown` in red or something?
            ],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSignatureFormatterThrowsUnknownReflectorExpeption()
    {
        $refl = $this->getMockBuilder('Reflector')->getMock();
        SignatureFormatter::format($refl);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Input;

use Psy\Input\CodeArgument;
use Symfony\Component\Console\Input\InputArgument;

class CodeArgumentTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider getInvalidModes
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidModes($mode)
    {
        new CodeArgument('wat', $mode);
    }

    public function getInvalidModes()
    {
        return [
            [InputArgument::IS_ARRAY],
            [InputArgument::IS_ARRAY | InputArgument::REQUIRED],
            [InputArgument::IS_ARRAY | InputArgument::OPTIONAL],
        ];
    }

    /**
     * @dataProvider getValidModes
     */
    public function testValidModes($mode)
    {
        $this->assertInstanceOf('Psy\Input\CodeArgument', new CodeArgument('yeah', $mode));
    }

    public function getValidModes()
    {
        return [
            [InputArgument::REQUIRED],
            [InputArgument::OPTIONAL],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Input;

use Psy\Input\FilterOptions;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\StringInput;

class FilterOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetOptions()
    {
        $opts = FilterOptions::getOptions();
        $this->assertCount(3, $opts);
    }

    /**
     * @dataProvider validInputs
     */
    public function testBindValidInput($input, $hasFilter = true)
    {
        $input = $this->getInput($input);
        $filterOptions = new FilterOptions();
        $filterOptions->bind($input);

        $this->assertEquals($hasFilter, $filterOptions->hasFilter());
    }

    public function validInputs()
    {
        return [
            ['--grep="bar"'],
            ['--grep="bar" --invert'],
            ['--grep="bar" --insensitive'],
            ['--grep="bar" --invert --insensitive'],
            ['', false],
        ];
    }

    /**
     * @dataProvider invalidInputs
     * 