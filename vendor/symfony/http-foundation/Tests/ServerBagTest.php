<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Proxy;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy;

/**
 * Tests for SessionHandlerProxy class.
 *
 * @author Drak <drak@zikula.org>
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class SessionHandlerProxyTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_Matcher
     */
    private $mock;

    /**
     * @var SessionHandlerProxy
     */
    private $proxy;

    protected function setUp()
    {
        $this->mock = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $this->proxy = new SessionHandlerProxy($this->mock);
    }

    protected function tearDown()
    {
        $this->mock = null;
        $this->proxy = null;
    }

    public function testOpenTrue()
    {
        $this->mock->expects($this->once())
            ->method('open')
            ->will($this->returnValue(true));

        $this->assertFalse($this->proxy->isActive());
        $this->proxy->open('name', 'id');
        $this->assertFalse($this->proxy->isActive());
    }

    public function testOpenFalse()
    {
        $this->mock->expects($this->once())
            ->method('open')
            ->will($this->returnValue(false));

        $this->assertFalse($this->proxy->isActive());
        $this->proxy->open('name', 'id');
        $this->assertFalse($this->proxy->isActive());
    }

    public function testClose()
    {
        $this->mock->expects($this->once())
            ->method('close')
            ->will($this->returnValue(true));

        $this->assertFalse($this->proxy->isActive());
        $this->proxy->close();
        $this->assertFalse($this->proxy->isActive());
    }

    public function testCloseFalse()
    {
        $this->mock->expects($this->once())
            ->method('close')
            ->will($this->returnValue(false));

        $this->assertFalse($this->proxy->isActive());
        $this->proxy->close();
        $this->assertFalse($this->proxy->isActive());
    }

    public function testRead()
    {
        $this->mock->expects($this->once())
            ->method('read');

        $this->proxy->read('id');
    }

    public function testWrite()
    {
        $this->mock->expects($this->once())
            ->method('write');

        $this->proxy->write('id', 'data');
    }

    public function testDestroy()
    {
        $this->mock->expects($this->once())
            ->method('destroy');

        $this->proxy->destroy('id');
    }

    public function testGc()
    {
        $this->mock->expects($this->once())
            ->method('gc');

        $this->proxy->gc(86400);
    }

    /**
     * @requires PHPUnit 5.1
     */
    public function testValidateId()
    {
        $mock = $this->getMockBuilder(['SessionHandlerInterface', 'SessionUpdateTimestampHandlerInterface'])->getMock();
        $mock->expects($this->once())
            ->method('validateId');

        $proxy = new SessionHandlerProxy($mock);
        $proxy->validateId('id');

        $this->assertTrue($this->proxy->validateId('id'));
    }

    /**
     * @requires PHPUnit 5.1
     */
    public function testUpdateTimestamp()
    {
        $mock = $this->getMockBuilder(['SessionHandlerInterface', 'SessionUpdateTimestampHandlerInterface'])->getMock();
        $mock->expects($this->once())
            ->method('updateTimestamp');

        $proxy = new SessionHandlerProxy($mock);
        $proxy->updateTimestamp('id', 'data');

        $this->mock->expects($this->once())
            ->method('write');

        $this->proxy->updateTimestamp('id', 'data');
    }
}
                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Test\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestFailure;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Test\Constraint\RequestAttributeValueSame;

class RequestAttributeValueSameTest extends TestCase
{
    public function testConstraint(): void
    {
        $request = new Request();
        $request->attributes->set('foo', 'bar');
        $constraint = new RequestAttributeValueSame('foo', 'bar');
        $this->assertTrue($constraint->evaluate($request, '', true));
        $constraint = new RequestAttributeValueSame('bar', 'foo');
        $this->assertFalse($constraint->evaluate($request, '', true));

        try {
            $constraint->evaluate($request);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals("Failed asserting that the Request has attribute \"bar\" with value \"foo\".\n", TestFailure::exceptionToString($e));

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                      