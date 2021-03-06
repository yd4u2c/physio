<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\TestCase;
use Monolog\Logger;

/**
 * @covers Monolog\Handler\TestHandler
 */
class TestHandlerTest extends TestCase
{
    /**
     * @dataProvider methodProvider
     */
    public function testHandler($method, $level)
    {
        $handler = new TestHandler;
        $record = $this->getRecord($level, 'test'.$method);
        $this->assertFalse($handler->hasRecords($level));
        $this->assertFalse($handler->hasRecord($record, $level));
        $this->assertFalse($handler->{'has'.$method}($record), 'has'.$method);
        $this->assertFalse($handler->{'has'.$method.'ThatContains'}('test'), 'has'.$method.'ThatContains');
        $this->assertFalse($handler->{'has'.$method.'ThatPasses'}(function ($rec) {
            return true;
        }), 'has'.$method.'ThatPasses');
        $this->assertFalse($handler->{'has'.$method.'ThatMatches'}('/test\w+/'));
        $this->assertFalse($handler->{'has'.$method.'Records'}(), 'has'.$method.'Records');
        $handler->handle($record);

        $this->assertFalse($handler->{'has'.$method}('bar'), 'has'.$method);
        $this->assertTrue($handler->hasRecords($level));
        $this->assertTrue($handler->hasRecord($record, $level));
        $this->assertTrue($handler->{'has'.$method}($record), 'has'.$method);
        $this->assertTrue($handler->{'has'.$method}('test'.$method), 'has'.$method);
        $this->assertTrue($handler->{'has'.$method.'ThatContains'}('test'), 'has'.$method.'ThatContains');
        $this->assertTrue($handler->{'has'.$method.'ThatPasses'}(function ($rec) {
            return true;
        }), 'has'.$method.'ThatPasses');
        $this->assertTrue($handler->{'has'.$method.'ThatMatches'}('/test\w+/'));
        $this->assertTrue($handler->{'has'.$method.'Records'}(), 'has'.$method.'Records');

        $records = $handler->getRecords();
        unset($records[0]['formatted']);
        $this->assertEquals(array($record), $records);
    }

    public function testHandlerAssertEmptyContext() {
        $handler = new TestHandler;
        $record  = $this->getRecord(Logger::WARNING, 'test', array());
        $this->assertFalse($handler->hasWarning(array(
            'message' => 'test',
            'context' => array(),
        )));

        $handler->handle($record);

        $this->assertTrue($handler->hasWarning(array(
            'message' => 'test',
            'context' => array(),
        )));
        $this->assertFalse($handler->hasWarning(array(
            'message' => 'test',
            'context' => array(
                'foo' => 'bar'
            ),
        )));
    }

    public function testHandlerAssertNonEmptyContext() {
        $handler = new TestHandler;
        $record  = $this->getRecord(Logger::WARNING, 'test', array('foo' => 'bar'));
        $this->assertFalse($handler->hasWarning(array(
            'message' => 'test',
            'context' => array(
                'foo' => 'bar'
            ),
        )));

        $handler->handle($record);

        $this->assertTrue($handler->hasWarning(array(
            'message' => 'test',
            'context' => array(
                'foo' => 'bar'
            ),
        )));
        $this->assertFalse($handler->hasWarning(array(
            'message' => 'test',
            'context' => array(),
        )));
    }

    public function methodProvider()
    {
        return array(
            array('Emergency', Logger::EMERGENCY),
            array('Alert'    , Logger::ALERT),
            array('Critical' , Logger::CRITICAL),
            array('Error'    , Logger::ERROR),
            array('Warning'  , Logger::WARNING),
            array('Info'     , Logger::INFO),
            array('Notice'   , Logger::NOTICE),
            array('Debug'    , Logger::DEBUG),
        );
    }
}
                                                      <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\TestCase;
use Monolog\Handler\SyslogUdp\UdpSocket;

/**
 * @requires extension sockets
 */
class UdpSocketTest extends TestCase
{
    public function testWeDoNotTruncateShortMessages()
    {
        $socket = $this->getMock('\Monolog\Handler\SyslogUdp\UdpSocket', array('send'), array('lol', 'lol'));

        $socket->expects($this->at(0))
            ->method('send')
            ->with("HEADER: The quick brown fox jumps over the lazy dog");

        $socket->write("The quick brown fox jumps over the lazy dog", "HEADER: ");
    }

    public function testLongMessagesAreTruncated()
    {
        $socket = $this->getMock('\Monolog\Handler\SyslogUdp\UdpSocket', array('send'), array('lol', 'lol'));

        $truncatedString = str_repeat("derp", 16254).'d';

        $socket->expects($this->exactly(1))
            ->method('send')
            ->with("HEADER" . $truncatedString);

        $longString = str_repeat("derp", 20000);

        $socket->write($longString, "HEADER");
    }

    public function testDoubleCloseDoesNotError()
    {
        $socket = new UdpSocket('127.0.0.1', 514);
        $socket->close();
        $socket->close();
    }

    /**
     * @expectedException LogicException
     */
    public function testWriteAfterCloseErrors()
    {
        $socket = new UdpSocket('127.0.0.1', 514);
        $socket->close();
        $socket->write('foo', "HEADER");
    }
}
                                                                                                                                                                                                                                                                                                                                                                                 