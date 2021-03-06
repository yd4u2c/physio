<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Acme;

class Tester
{
    public function test($handler, $record)
    {
        $handler->handle($record);
    }
}

function tester($handler, $record)
{
    $handler->handle($record);
}

namespace Monolog\Processor;

use Monolog\Logger;
use Monolog\TestCase;
use Monolog\Handler\TestHandler;

class IntrospectionProcessorTest extends TestCase
{
    public function getHandler()
    {
        $processor = new IntrospectionProcessor();
        $handler = new TestHandler();
        $handler->pushProcessor($processor);

        return $handler;
    }

    public function testProcessorFromClass()
    {
        $handler = $this->getHandler();
        $tester = new \Acme\Tester;
        $tester->test($handler, $this->getRecord());
        list($record) = $handler->getRecords();
        $this->assertEquals(__FILE__, $record['extra']['file']);
        $this->assertEquals(18, $record['extra']['line']);
        $this->assertEquals('Acme\Tester', $record['extra']['class']);
        $this->assertEquals('test', $record['extra']['function']);
    }

    public function testProcessorFromFunc()
    {
        $handler = $this->getHandler();
        \Acme\tester($handler, $this->getRecord());
        list($record) = $handler->getRecords();
        $this->assertEquals(__FILE__, $record['extra']['file']);
        $this->assertEquals(24, $record['extra']['line']);
        $this->assertEquals(null, $record['extra']['class']);
        $this->assertEquals('Acme\tester', $record['extra']['function']);
    }

    public function testLevelTooLow()
    {
        $input = array(
            'level' => Logger::DEBUG,
            'extra' => array(),
        );

        $expected = $input;

        $processor = new IntrospectionProcessor(Logger::CRITICAL);
        $actual = $processor($input);

        $this->assertEquals($expected, $actual);
    }

    public function testLevelEqual()
    {
        $input = array(
            'level' => Logger::CRITICAL,
            'extra' => array(),
        );

        $expected = $input;
        $expected['extra'] = array(
            'file' => null,
            'line' => null,
            'class' => 'ReflectionMethod',
            'function' => 'invokeArgs',
        );

        $processor = new IntrospectionProcessor(Logger::CRITICAL);
        $actual = $processor($input);

        $this->assertEquals($expected, $actual);
    }

    public function testLevelHigher()
    {
        $input = array(
            'level' => Logger::EMERGENCY,
            'extra' => array(),
        );

        $expected = $input;
        $expected['extra'] = array(
            'file' => null,
            'line' => null,
            'class' => 'ReflectionMethod',
            'function' => 'invokeArgs',
        );

        $processor = new IntrospectionProcessor(Logger::CRITICAL);
        $actual = $processor($input);

        $this->assertEquals($expected, $actual);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Processor;

use Monolog\TestCase;

class MemoryPeakUsageProcessorTest extends TestCase
{
    /**
     * @covers Monolog\Processor\MemoryPeakUsageProcessor::__invoke
     * @covers Monolog\Processor\MemoryProcessor::formatBytes
     */
    public function testProcessor()
    {
        $processor = new MemoryPeakUsageProcessor();
        $record = $processor($this->getRecord());
        $this->assertArrayHasKey('memory_peak_usage', $record['extra']);
        $this->assertRegExp('#[0-9.]+ (M|K)?B$#', $record['extra']['memory_peak_usage']);
    }

    /**
     * @covers Monolog\Processor\MemoryPeakUsageProcessor::__invoke
     * @covers Monolog\Processor\MemoryProcessor::formatBytes
     */
    public function testProcessorWithoutFormatting()
    {
        $processor = new MemoryPeakUsageProcessor(true, false);
        $record = $processor($this->getRecord());
        $this->assertArrayHasKey('memory_peak_usage', $record['extra']);
        $this->assertInternalType('int', $record['extra']['memory_peak_usage']);
        $this->assertGreaterThan(0, $record['extra']['memory_peak_usage']);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Processor;

use Monolog\TestCase;

class MemoryUsageProcessorTest extends TestCase
{
    /**
     * @covers Monolog\Processor\MemoryUsageProcessor::__invoke
     * @covers Monolog\Processor\MemoryProcessor::formatBytes
     */
    public function testProcessor()
    {
        $processor = new MemoryUsageProcessor();
        $record = $processor($this->getRecord());
        $this->assertArrayHasKey('memory_usage', $record['extra']);
        $this->assertRegExp('#[0-9.]+ (M|K)?B$#', $record['extra']['memory_usage']);
    }

    /**
     * @covers Monolog\Processor\MemoryUsageProcessor::__invoke
     * @covers Monolog\Processor\MemoryProcessor::formatBytes
     */
    public function testProcessorWithoutFormatting()
    {
        $processor = new MemoryUsageProcessor(true, false);
        $record = $processor($this->getRecord());
        $this->assertArrayHasKey('memory_usage', $record['extra']);
        $this->assertInternalType('int', $record['extra']['memory_usage']);
        $this->assertGreaterThan(0, $record['extra']['memory_usage']);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          