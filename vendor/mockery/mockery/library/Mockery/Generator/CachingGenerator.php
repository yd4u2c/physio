<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace test\Mockery;

use Mockery as m;
use Mockery\Spy;
use Mockery\Exception\InvalidCountException;
use PHPUnit\Framework\TestCase;

class AllowsExpectsSyntaxTest extends TestCase
{
    /** @test */
    public function allowsSetsUpMethodStub()
    {
        $stub = m::mock();
        $stub->allows()->foo(123)->andReturns(456);

        $this->assertEquals(456, $stub->foo(123));
    }

    /** @test */
    public function allowsCanTakeAnArrayOfCalls()
    {
        $stub = m::mock();
        $stub->allows([
            "foo" => "bar",
      