<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Formatter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Formatter\OutputFormatterStyleStack;

class OutputFormatterStyleStackTest extends TestCase
{
    public function testPush()
    {
        $stack = new OutputFormatterStyleStack();
        $stack->push($s1 = new OutputFormatterStyle('white', 'black'));
        $stack->push($s2 = new OutputFormatterStyle('yellow', 'blue'));

        $this->assertEquals($s2, $stack->getCurrent());

        $stack->push($s3 = new OutputFormatterStyle('green', 'red'));

        $this->assertEquals($s3, $stack->getCurrent());
    }

    public function testPop()
    {
        $stack = new OutputFormatterStyleStack();
        $stack->push($s1 = new OutputFormatterStyle('white', 'black'));
        $stack->push($s2 = new OutputFormatterStyle('yellow', 'blue'));

        $this->assertEquals($s2, $stack->pop());
        $this->assertEquals($s1, $stack->pop());
    }

    public function testPopEmpty()
    {
        $stack = new OutputFormatterStyleStack();
        $style = new OutputFormatterStyle();

        $this->assertEquals($style, $stack->pop());
    }

    public function testPopNotLast()
    {
        $stack = new OutputFormatterStyleStack();
        $stack->push($s1 = new OutputFormatterStyle('white', 'black'));
        $stack->push($s2 = new OutputFormatterStyle('yellow', 'blue'));
        $stack->push($s3 = new OutputFormatterStyle('green', 'red'));

        $this->assertEquals($s2, $stack->pop($s2));
        $this->assertEquals($s1, $stack->pop());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidPop()
    {
        $stack = new OutputFormatterStyleStack();
        $stack->push(new OutputFormatterStyle('white', 'black'));
        $stack->pop(new OutputFormatterStyle('yellow', 'blue'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Formatter;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class OutputFormatterStyleTest extends TestCase
{
    public function testConstructor()
    {
        $style = new OutputFormatterStyle('green', 'black', ['bold', 'underscore']);
        $this->assertEquals("\033[32;40;1;4mfoo\033[39;49;22;24m", $style->apply('foo'));

        $style = new OutputFormatterStyle('red', null, ['blink']);
        $this->assertEquals("\033[31;5mfoo\033[39;25m", $style->apply('foo'));

        $style = new OutputFormatterStyle(null, 'white');
        $this->assertEquals("\033[47mfoo\033[49m", $style->apply('foo'));
    }

    public function testForeground()
    {
        $style = new OutputFormatterStyle();

        $style->setForeground('black');
        $this->assertEquals("\033[30mfoo\033[39m", $style->apply('foo'));

        $style->setForeground('blue');
        $this->assertEquals("\033[34mfoo\033[39m", $style->apply('foo'))