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

use Gelf\Message;
use Monolog\TestCase;
use Monolog\Logger;
use Monolog\Formatter\GelfMessageFormatter;

class GelfHandlerLegacyTest extends TestCase
{
    public function setUp()
    {
        if (!class_exists('Gelf\MessagePublisher') || !class_exists('Gelf\Message')) {
            $this->markTestSkipped("mlehner/gelf-php not installed");
        }

        require_once __DIR__ . '/GelfMockMessagePublisher.php';
    }

    /**
     * @covers Monolog\Handler\GelfHandler::__construct
     */
    public function testConstruct()
    {
        $handler = new GelfHandler($this->getMessagePublisher());
        $this->assertInstanceOf('Monolog\Handler\GelfHandler', $handler);
    }

    protected function getHandler($messagePublisher)
    {
        $handler = new GelfHandler($messagePublisher);

        return $handler;
    }

    protected function getMessagePublisher()
    {
        return new GelfMockMessagePublisher('localhost');
    }

    public function testDebug()
    {
        $messagePublisher = $this->getMessagePublisher();
        $handler = $this->getHandler($messagePublisher);

        $record = $this->getRecord(Logger::DEBUG, "A test debug message");
        $handler->handle($record);

        $this->assertEquals(7, $messagePublisher->lastMessage->getLevel());
        $this->assertEquals('test', $messagePublisher->lastMessage->getFacility());
        $this->assertEquals($record['message'], $messagePublisher->lastMessage->getShortMessage());
        $this->assertEquals(null, $messagePublisher->lastMessage->getFullMessage());
    }

    public function testWarning()
    {
        $messagePublisher = $this->getMessagePublisher();
        $handler = $this->getHandler($messagePublisher);

        $record = $this->getRecord(Logger::WARNING, "A test warning message");
        $handler->handle($record);

        $this->assertEquals(4, $messagePublisher->lastMessage->getLevel());
        $this->assertEquals('test', $messagePublisher->lastMessage->getFacility());
        $this->assertEquals($record['message'], $messagePublisher->lastMessage->getShortMessage());
        $this->assertEquals(null, $messagePublisher->lastMessage->getFullMessage());
    }

    public function testInjectedGelfMessageFormatter()
    {
        $messagePublisher = $this->getMessagePublisher();
        $handler = $this->getHandler($messagePublisher);

        $handler->setFormatter(new GelfMessageFormatter('mysystem', 'EXT', 'CTX'));

        $record = $this->getRecord(Logger::WARNING, "A test warning message");
        $record['extra']['blarg'] = 'yep';
        $record['context']['from'] = 'logger';
        $handler->handle($record);

        $this->assertEquals('mysystem', $messagePublisher->lastMessage->getHost());
        $this->assertArrayHasKey('_EXTblarg', $messagePublisher->lastMessage->toArray());
        $this->assertArrayHasKey('_CTXfrom', $messagePublisher->lastMessage->toArray());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Gelf\Message;
use Monolog\TestCase;
use Monolog\Logger;
use Monolog\Formatter\GelfMessageFormatter;

class GelfHandlerTest extends TestCase
{
    public function setUp()
    {
        if (!class_exists('Gelf\Publisher') || !class_exists('Gelf\Message')) {
            $this->markTestSkipped("graylog2/gelf-php not installed");
        }
    }

    /**
     * @covers Monolog\Handler\GelfHandler::__construct
     */
    public function testConstruct()
    {
        $handler = new GelfHandler($this->getMessagePublisher());
        $this->assertInstanceOf('Monolog\Handler\GelfHandler', $handler);
    }

    protected function getHandler($messagePublisher)
    {
        $handler = new GelfHandler($messagePublisher);

        return $handler;
    }

    protected function getMessagePublisher()
    {
        return $this->getMock('Gelf\Publisher', array('publish'), array(), '', false);
    }

    public function testDebug()
    {
        $record = $this->getRecord(Logger::DEBUG, "A test debug message");
        $expectedMessage = new Message();
        $expectedMessage
            ->setLevel(7)
            ->setFacility("test")
            ->setShortMessage($record['message'])
            ->setTimestamp($record['datetime'])
        ;

        $messagePublisher = $this->getMessagePublisher();
        $messagePublisher->expects($this->once())
            ->method('publish')
            ->with($expectedMessage);

        $handler = $this->getHandler($messagePublisher);

        $handler->handle($record);
    }

    public function testWarning()
    {
        $record = $this->getRecord(Logger::WARNING, "A test warning message");
        $expectedMessage = new Message();
        $expectedMessage
            ->setLevel(4)
            ->setFacility("test")
            ->setShortMessage($record['message'])
            ->setTimestamp($record['datetime'])
        ;

        $messagePublisher = $this->getMessagePublisher();
        $messagePublisher->expects($this->once())
            ->method('publish')
            ->with($expectedMessage);

        $handler = $this->getHandler($messagePublisher);

        $handler->handle($record);
    }

    public function testInjectedGelfMessageFormatter()
    {
        $record = $this->getRecord(Logger::WARNING, "A test warning message");
        $record['extra']['blarg'] = 'yep';
        $record['context']['from'] = 'logger';

        $expectedMessage = new Message();
        $expectedMessage
            ->setLevel(4)
            ->setFacility("test")
            ->setHost("mysystem")
            ->setShortMessage($record['message'])
            ->setTimestamp($record['datetime'])
            ->setAdditional("EXTblarg", 'yep')
            ->setAdditional("CTXfrom", 'logger')
        ;

        $messagePublisher = $this->getMessagePublisher();
        $messagePublisher->expects($this->once())
            ->method('publish')
            ->with($expectedMessage);

        $handler = $this->getHandler($messagePublisher);
        $handler->setFormatter(new GelfMessageFormatter('mysystem', 'EXT', 'CTX'));
        $handler->handle($record);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

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

class GroupHandlerTest extends TestCase
{
    /**
     * @covers Monolog\Handler\GroupHandler::__construct
     * @expectedException InvalidArgumentException
     */
    public function testConstructorOnlyTakesHandler()
    {
        new GroupHandler(array(new TestHandler(), "foo"));
    }

    /**
     * @covers Monolog\Handler\GroupHandler::__construct
     * @covers Monolog\Handler\GroupHandler::handle
     */
    public function testHandle()
    {
        $testHandlers = array(new TestHandler(), new TestHandler());
        $handler = new GroupHandler($testHandlers);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        foreach ($testHandlers as $test) {
            $this->assertTrue($test->hasDebugRecords());
            $this->assertTrue($test->hasInfoRecords());
            $this->assertTrue(count($test->getRecords()) === 2);
        }
    }

    /**
     * @covers Monolog\Handler\GroupHandler::handleBatch
     */
    public function testHandleBatch()
    {
        $testHandlers = array(new TestHandler(), new TestHandler());
        $handler = new GroupHandler($testHandlers);
        $handler->handleBatch(array($this->getRecord(Logger::DEBUG), $this->getRecord(Logger::INFO)));
        foreach ($testHandlers as $test) {
            $this->assertTrue($test->hasDebugRecords());
            $this->assertTrue($test->hasInfoRecords());
            $this->assertTrue(count($test->getRecords()) === 2);
        }
    }

    /**
     * @covers Monolog\Handler\GroupHandler::isHandling
     */
    public function testIsHandling()
    {
        $testHandlers = array(new TestHandler(Logger::ERROR), new TestHandler(Logger::WARNING));
        $handler = new GroupH