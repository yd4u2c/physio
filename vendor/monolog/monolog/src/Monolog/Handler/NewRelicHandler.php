<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog;

class RegistryTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        Registry::clear();
    }

    /**
     * @dataProvider hasLoggerProvider
     * @covers Monolog\Registry::hasLogger
     */
    public function testHasLogger(array $loggersToAdd, array $loggersToCheck, array $expectedResult)
    {
        foreach ($loggersToAdd as $loggerToAdd) {
            Registry::addLogger($loggerToAdd);
        }
        foreach ($loggersToCheck as $index => $loggerToCheck) {
            $this->assertSame($expectedResult[$index], Registry::hasLogger($loggerToCheck));
        }
    }

    public function hasLoggerProvider()
    {
        $logger1 = new Logger('test1');
        $logger2 = new Logger('test2');
        $logger3 = new Logger('test3');

        return array(
            // only instances
            array(
                array($logger1),
                array($logger1, $logger2),
                array(true, false),
            ),
            // only names
            array(
                array($logger1),
                array('test1', 'test2'),
                array(true, false),
            ),
            // mixed case
            array(
                array($logger1, $logger2),
                array('test1', $logger2, 'test3', $logger3),
                array(true, true, false, false),
            ),
        );
    }

    /**
     * @covers Monolog\Registry::clear
     */
    public function testClearClears()
    {
        Registry::addLogger(new Logger('test1'), 'log');
        Registry::clear();

        $this->setExpectedException('\InvalidArgumentException');
        Registry::getInstance('log');
    }

    /**
     * @dataProvider removedLoggerProvider
     * @covers Monolog\Registry::addLogger
     * @covers Monolog\Registry::removeLogger
     */
    public function testRemovesLogger($loggerToAdd, $remove)
    {
        Registry::addLogger($loggerToAdd);
        Registry::removeLogger($remove);

        $this->setExpectedException('\InvalidArgumentException');
        Registry::getInstance($loggerToAdd->getName());
    }

    public function removedLoggerProvider()
    {
        $logger1 = new Logger('test1');

        return array(
            array($logger1, $logger1),
            array($logger1, 'test1'),
        );
    }

    /**
     * @covers Monolog\Registry::addLogger
     * @covers Monolog\Registry::getInstance
     * @covers Monolog\Registry::__callStatic
     */
    public function testGetsSameLogger()
    {
        $logger1 = new Logger('test1');
        $logger2 = new Logger('test2');

        Registry::addLogger($logger1, 'test1');
        Registry::addLogger($logger2);

        $this->assertSame($logger1, Registry::getInstance('test1'));
        $this->assertSame($logger2, Registry::test2());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers Monolog\Registry::getInstance
     */
    public function testFailsOnNonExistantLogger()
    {
        Registry::getInstance('test1');
    }

    /**
     * @covers Monolog\Registry::addLogger
     */
    public function testReplacesLogger()
    {
        $log1 = new Logger('test1');
        $log2 = new Logger('test2');

        Registry::addLogger($log1, 'log');

        Registry::addLogger($log2, 'log', true);

        $this->assertSame($log2, Registry::getInstance('log'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @covers Monolog\Registry::addLogger
     */
    public function testFailsOnUnspecifiedReplacement()
    {
        $log1 = new Logger('test1');
        $log2 = new Logger('test2');

        Registry::addLogger($log1, 'log');

        Registry::addLogger($log2, 'log');
    }
}
                                                                                                                            <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog;

use Monolog\Handler\StreamHandler;
use Monolog\Handler\TestHandler;
use Psr\Log\LogLevel;

/**
 * @author Robert Gust-Bardon <robert@gust-bardon.org>
 * @covers Monolog\SignalHandler
 */
class SignalHandlerTest extends TestCase
{

    private $asyncSignalHandling;
    private $blockedSignals;
    private $signalHandlers;

    protected function setUp()
    {
        $this->signalHandlers = array();
        if (extension_loaded('pcntl')) {
            if (function_exists('pcntl_async_signals')) {
                $this->asyncSignalHandling = pcntl_async_signals();
            }
            if (function_exists('pcntl_sigprocmask')) {
                pcntl_sigprocmask(SIG_BLOCK, array(), $this->blockedSignals);
            }
        }
    }

    protected function tearDown()
    {
        if ($this->asyncSignalHandling !== null) {
            pcntl_async_signals($this->asyncSignalHandling);
        }
        if ($this->blockedSignals !== null) {
            pcntl_sigprocmask(SIG_SETMASK, $this->blockedSignals);
        }
        if ($this->signalHandlers) {
            pcntl_signal_dispatch();
            foreach ($this->signalHandlers as $signo => $handler) {
                pcntl_signal($signo, $handler);
            }
        }
    }

    private function setSignalHandler($signo, $handler = SIG_DFL) {
        if (function_exists('pcntl_signal_get_handler')) {
            $this->signalHandlers[$signo] = pcntl_signal_get_handler($signo);
        } else {
            $this->signalHandlers[$signo] = SIG_DFL;
        }
        $this->assertTrue(pcntl_signal($signo, $handler));
    }

    public function testHandleSignal()
    {
        $logger = new Logger('test', array($handler = new TestHandler));
        $errHandler = new SignalHandler($logger);
        $signo = 2;  // SIGINT.
        $siginfo = array('signo' => $signo, 'errno' =