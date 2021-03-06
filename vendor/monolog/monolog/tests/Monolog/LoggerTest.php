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

use Monolog\Logger;
use Monolog\TestCase;

class FilterHandlerTest extends TestCase
{
    /**
     * @covers Monolog\Handler\FilterHandler::isHandling
     */
    public function testIsHandling()
    {
        $test    = new TestHandler();
        $handler = new FilterHandler($test, Logger::INFO, Logger::NOTICE);
        $this->assertFalse($handler->isHandling($this->getRecord(Logger::DEBUG)));
        $this->assertTrue($handler->isHandling($this->getRecord(Logger::INFO)));
        $this->assertTrue($handler->isHandling($this->getRecord(Logger::NOTICE)));
        $this->assertFalse($handler->isHandling($this->getRecord(Logger::WARNING)));
        $this->assertFalse($handler->isHandling($this->getRecord(Logger::ERROR)));
        $this->assertFalse($handler->isHandling($this->getRecord(Logger::CRITICAL)));
        $this->assertFalse($handler->isHandling($this->getRecord(Logger::ALERT)));
        $this->assertFalse($handler->isHandling($this->getRecord(Logger::EMERGENCY)));
    }

    /**
     * @covers Monolog\Handler\FilterHandler::handle
     * @covers Monolog\Handler\FilterHandler::setAcceptedLevels
     * @covers Monolog\Handler\FilterHandler::isHandling
     */
    public function testHandleProcessOnlyNeededLevels()
    {
        $test    = new TestHandler();
        $handler = new FilterHandler($test, Logger::INFO, Logger::NOTICE);

        $handler->handle($this->getRecord(Logger::DEBUG));
        $this->assertFalse($test->hasDebugRecords());

        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertTrue($test->hasInfoRecords());
        $handler->handle($this->getRecord(Logger::NOTICE));
        $this->assertTrue($test->hasNoticeRecords());

        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertFalse($test->hasWarningRecords());
        $handler->handle($this->getRecord(Logger::ERROR));
        $this->assertFalse($test->hasErrorRecords());
        $handler->handle($this->getRecord(Logger::CRITICAL));
        $this->assertFalse($test->hasCriticalRecords());
        $handler->handle($this->getRecord(Logger::ALERT));
        $this->assertFalse($test->hasAlertRecords());
        $handler->handle($this->getRecord(Logger::EMERGENCY));
        $this->assertFalse($test->hasEmergencyRecords());

        $test    = new TestHandler();
        $handler = new FilterHandler($test, array(Logger::INFO, Logger::ERROR));

        $handler->handle($this->getRecord(Logger::DEBUG));
        $this->assertFalse($test->hasDebugRecords());
        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertTrue($test->hasInfoRecords());
        $handler->handle($this->getRecord(Logger::NOTICE));
        $this->assertFalse($test->hasNoticeRecords());
        $handler->handle($this->getRecord(Logger::ERROR));
        $this->assertTrue($test->hasErrorRecords());
        $handler->handle($this->getRecord(Logger::CRITICAL));
        $this->assertFalse($test->hasCriticalRecords());
    }

    /**
     * @covers Monolog\Handler\FilterHandler::setAcceptedLevels
     * @covers Monolog\Handler\FilterHandler::getAcceptedLevels
     */
    public function testAcceptedLevelApi()
    {
        $test    = new TestHandler();
        $handler = new FilterHandler($test);

        $levels = array(Logger::INFO, Logger::ERROR);
        $handler->setAcceptedLevels($levels);
        $this->assertSame($levels, $handler->getAcceptedLevels());

        $handler->setAcceptedLevels(array('info', 'error'));
        $this->assertSame($levels, $handler->getAcceptedLevels());

        $levels = array(Logger::CRITICAL, Logger::ALERT, Logger::EMERGENCY);
        $handler->setAcceptedLevels(Logger::CRITICAL, Logger::EMERGENCY);
        $this->assertSame($levels, $handler->getAcceptedLevels());

        $handler->setAcceptedLevels('critical', 'emergency');
        $this->assertSame($levels, $handler->getAcceptedLevels());
    }

    /**
     * @covers Monolog\Handler\FilterHandler::handle
     */
    public function testHandleUsesProcessors()
    {
        $test    = new TestHandler();
        $handler = new FilterHandler($test, Logger::DEBUG, Logger::EMERGENCY);
        $handler->pushProcessor(
            function ($record) {
                $record['extra']['foo'] = true;

                return $record;
            }
        );
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasWarningRecords());
        $records = $test->getRecords();
        $this->assertTrue($records[0]['extra']['foo']);
    }

    /**
     * @covers Monolog\Handler\FilterHandler::handle
     */
    public function testHandleRespectsBubble()
    {
        $test = new TestHandler();

        $handler = new FilterHandler($test, Logger::INFO, Logger::NOTICE, false);
        $this->assertTrue($handler->handle($this->getRecord(Logger::INFO)));
        $this->assertFalse($handler->handle($this->getRecord(Logger::WARNING)));

        $handler = new FilterHandler($test, Logger::INFO, Logger::NOTICE, true);
        $this->assertFalse($handler->handle($this->getRecord(Logger::INFO)));
        $this->assertFalse($handler->handle($this->getRecord(Logger::WARNING)));
    }

    /**
     * @covers Monolog\Handler\FilterHandler::handle
     */
    public function testHandleWithCallback()
    {
        $test    = new TestHandler();
        $handler = new FilterHandler(
            function ($record, $handler) use ($test) {
                return $test;
            }, Logger::INFO, Logger::NOTICE, false
        );
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertFalse($test->hasDebugRecords());
        $this->assertTrue($test->hasInfoRecords());
    }

    /**
     * @covers Monolog\Handler\FilterHandler::handle
     * @expectedException \RuntimeException
     */
    public function testHandleWithBadCallbackThrowsException()
    {
        $handler = new FilterHandler(
            function ($record, $handler) {
                return 'foo';
            }
        );
        $handler->handle($this->getRecord(Logger::WARNING));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

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
use Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy;
use Monolog\Handler\FingersCrossed\ChannelLevelActivationStrategy;
use Psr\Log\LogLevel;

class FingersCrossedHandlerTest extends TestCase
{
    /**
     * @covers Monolog\Handler\FingersCrossedHandler::__construct
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     */
    public function testHandleBuffers()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertFalse($test->hasDebugRecords());
        $this->assertFalse($test->hasInfoRecords());
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->close();
        $this->assertTrue($test->hasInfoRecords());
        $this->assertTrue(count($test->getRecords()) === 3);
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     */
    public function testHandleStopsBufferingAfterTrigger()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test);
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->close();
        $this->assertTrue($test->hasWarningRecords());
        $this->assertTrue($test->hasDebugRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     * @covers Monolog\Handler\FingersCrossedHandler::reset
     */
    public function testHandleResetBufferingAfterReset()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test);
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->reset();
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->close();
        $this->assertTrue($test->hasWarningRecords());
        $this->assertTrue($test->hasDebugRecords());
        $this->assertFalse($test->hasInfoRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     */
    public function testHandleResetBufferingAfterBeingTriggeredWhenStopBufferingIsDisabled()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, Logger::WARNING, 0, false, false);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::WARNING));
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->close();
        $this->assertTrue($test->hasWarningRecords());
        $this->assertTrue($test->hasDebugRecords());
        $this->assertFalse($test->hasInfoRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     */
    public function testHandleBufferLimit()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, Logger::WARNING, 2);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasWarningRecords());
        $this->assertTrue($test->hasInfoRecords());
        $this->assertFalse($test->hasDebugRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     */
    public function testHandleWithCallback()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler(function ($record, $handler) use ($test) {
                    return $test;
                });
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertFalse($test->hasDebugRecords());
        $this->assertFalse($test->hasInfoRecords());
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasInfoRecords());
        $this->assertTrue(count($test->getRecords()) === 3);
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     * @expectedException RuntimeException
     */
    public function testHandleWithBadCallbackThrowsException()
    {
        $handler = new FingersCrossedHandler(function ($record, $handler) {
                    return 'foo';
                });
        $handler->handle($this->getRecord(Logger::WARNING));
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::isHandling
     */
    public function testIsHandlingAlways()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, Logger::ERROR);
        $this->assertTrue($handler->isHandling($this->getRecord(Logger::DEBUG)));
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::__construct
     * @covers Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy::__construct
     * @covers Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy::isHandlerActivated
     */
    public function testErrorLevelActivationStrategy()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, new ErrorLevelActivationStrategy(Logger::WARNING));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $this->assertFalse($test->hasDebugRecords());
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasDebugRecords());
        $this->assertTrue($test->hasWarningRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::__construct
     * @covers Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy::__construct
     * @covers Monolog\Handler\FingersCrossed\ErrorLevelActivationStrategy::isHandlerActivated
     */
    public function testErrorLevelActivationStrategyWithPsrLevel()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, new ErrorLevelActivationStrategy('warning'));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $this->assertFalse($test->hasDebugRecords());
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasDebugRecords());
        $this->assertTrue($test->hasWarningRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::__construct
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     */
    public function testOverrideActivationStrategy()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, new ErrorLevelActivationStrategy('warning'));
        $handler->handle($this->getRecord(Logger::DEBUG));
        $this->assertFalse($test->hasDebugRecords());
        $handler->activate();
        $this->assertTrue($test->hasDebugRecords());
        $handler->handle($this->getRecord(Logger::INFO));
        $this->assertTrue($test->hasInfoRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossed\ChannelLevelActivationStrategy::__construct
     * @covers Monolog\Handler\FingersCrossed\ChannelLevelActivationStrategy::isHandlerActivated
     */
    public function testChannelLevelActivationStrategy()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, new ChannelLevelActivationStrategy(Logger::ERROR, array('othertest' => Logger::DEBUG)));
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertFalse($test->hasWarningRecords());
        $record = $this->getRecord(Logger::DEBUG);
        $record['channel'] = 'othertest';
        $handler->handle($record);
        $this->assertTrue($test->hasDebugRecords());
        $this->assertTrue($test->hasWarningRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossed\ChannelLevelActivationStrategy::__construct
     * @covers Monolog\Handler\FingersCrossed\ChannelLevelActivationStrategy::isHandlerActivated
     */
    public function testChannelLevelActivationStrategyWithPsrLevels()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, new ChannelLevelActivationStrategy('error', array('othertest' => 'debug')));
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertFalse($test->hasWarningRecords());
        $record = $this->getRecord(Logger::DEBUG);
        $record['channel'] = 'othertest';
        $handler->handle($record);
        $this->assertTrue($test->hasDebugRecords());
        $this->assertTrue($test->hasWarningRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::handle
     * @covers Monolog\Handler\FingersCrossedHandler::activate
     */
    public function testHandleUsesProcessors()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, Logger::INFO);
        $handler->pushProcessor(function ($record) {
            $record['extra']['foo'] = true;

            return $record;
        });
        $handler->handle($this->getRecord(Logger::WARNING));
        $this->assertTrue($test->hasWarningRecords());
        $records = $test->getRecords();
        $this->assertTrue($records[0]['extra']['foo']);
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::close
     */
    public function testPassthruOnClose()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, new ErrorLevelActivationStrategy(Logger::WARNING), 0, true, true, Logger::INFO);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->close();
        $this->assertFalse($test->hasDebugRecords());
        $this->assertTrue($test->hasInfoRecords());
    }

    /**
     * @covers Monolog\Handler\FingersCrossedHandler::close
     */
    public function testPsrLevelPassthruOnClose()
    {
        $test = new TestHandler();
        $handler = new FingersCrossedHandler($test, new ErrorLevelActivationStrategy(Logger::WARNING), 0, true, true, LogLevel::INFO);
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::INFO));
        $handler->close();
        $this->assertFalse($test->hasDebugRecords());
        $this->assertTrue($test->hasInfoRecords());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

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
 * @covers Monolog\Handler\FirePHPHandler
 */
class FirePHPHandlerTest extends TestCase
{
    public function setUp()
    {
        TestFirePHPHandler::resetStatic();
        $_SERVER['HTTP_USER_AGENT'] = 'Monolog Test; FirePHP/1.0';
    }

    public function testHeaders()
    {
        $handler = new TestFirePHPHandler;
        $handler->setFormatter($this->getIdentityFormatter());
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::WARNING));

        $expected = array(
            'X-Wf-Protocol-1'    => 'http://meta.wildfirehq.org/Protocol/JsonStream/0.2',
            'X-Wf-1-Structure-1' => 'http://meta.firephp.org/Wildfire/Structure/FirePHP/FirebugConsole/0.1',
            'X-Wf-1-Plugin-1'    => 'http://meta.firephp.org/Wildfire/Plugin/FirePHP/Library-FirePHPCore/0.3',
            'X-Wf-1-1-1-1'       => 'test',
            'X-Wf-1-1-1-2'       => 'test',
        );

        $this->assertEquals($expected, $handler->getHeaders());
    }

    public function testConcurrentHandlers()
    {
        $handler = new TestFirePHPHandler;
        $handler->setFormatter($this->getIdentityFormatter());
        $handler->handle($this->getRecord(Logger::DEBUG));
        $handler->handle($this->getRecord(Logger::WARN