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

class ZendMonitorHandlerTest extends TestCase
{
    protected $zendMonitorHandler;

    public function setUp()
    {
        if (!function_exists('zend_monitor_custom_event')) {
            $this->markTestSkipped('ZendServer is not installed');
        }
    }

    /**
     * @covers  Monolog\Handler\ZendMonitorHandler::write
     */
    public function testWrite()
    {
        $record = $this->getRecord();
        $formatterResult = array(
            'message' => $record['message'],
        );

        $zendMonitor = $this->getMockBuilder('Monolog\Handler\ZendMonitorHandler')
            ->setMethods(array('writeZendMonitorCustomEvent', 'getDefaultFormatter'))
            ->getMock();

        $formatterMock = $this->getMockBuilder('Monolog\Formatter\NormalizerFormatter')
            ->disableOriginalConstructor()
            ->getMock();

        $formatterMock->expects($this->once())
            ->method('format')
            ->will($this->returnValue($formatterResult));

        $zendMonitor->expects($this->once())
            ->method('getDefaultFormatter')
            ->will($this->returnValue($formatterMock));

        $levelMap = $zendMonitor->getLevelMap();

        $zendMonitor->expects($this->once())
            ->method('writeZendMonitorCustomEvent')
            ->with($levelMap[$record['level']], $record['message'], $formatterResult);

        $zendMonitor->handle($record);
    }

    /**
     * @covers Monolog\Handler\ZendMonitorHandler::getDefaultFormatter
     */
    public function testGetDefaultFormatterReturnsNormalizerFormatter()
    {
        $zendMonitor = new ZendMonitorHandler();
        $this->assertInstanceOf('Monolog\Formatter\NormalizerFormatter', $zendMonitor->getDefaultFormatter());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler\Slack;

use Monolog\Logger;
use Monolog\TestCase;

/**
 * @coversDefaultClass Monolog\Handler\Slack\SlackRecord
 */
class SlackRecordTest extends TestCase
{
    private $jsonPrettyPrintFlag;

    protected function setUp()
    {
        $this->jsonPrettyPrintFlag = defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 128;
    }

    public function dataGetAttachmentColor()
    {
        return array(
            array(Logger::DEBUG, SlackRecord::COLOR_DEFAULT),
            array(Logger::INFO, SlackRecord::COLOR_GOOD),
            array(Logger::NOTICE, SlackRecord::COLOR_GOOD),
            array(Logger::WARNING, SlackRecord::COLOR_WARNING),
            array(Logger::ERROR, SlackRecord::COLOR_DANGER),
            array(Logger::CRITICAL, SlackRecord::COLOR_DANGER),
            array(Logger::ALERT, SlackRecord::COLOR_DANGER),
            array(Logger::EMERGENCY, SlackRecord::COLOR_DANGER),
        );
    }

    /**
     * @dataProvider dataGetAttachmentColor
     * @param  int $logLevel
     * @param  string $expectedColour RGB hex color or name of Slack color
     * @covers ::getAttachmentColor
     */
    public function testGetAttachmentColor($logLevel, $expectedColour)
    {
        $slackRecord = new SlackRecord();
        $this->assertSame(
            $expectedColour,
            $slackRecord->getAttachmentColor($logLevel)
        );
    }

    public function testAddsChannel()
    {
        $channel = '#test';
        $record = new SlackRecord($channel);
        $data = $record->getSlackData($this->getRecord());

        $this->assertArrayHasKey('channel', $data);
        $this->assertSame($channel, $data['channel']);
    }

    public function testNoUsernameByDefault()
    {
        $record = new SlackRecord();
        $data = $record->getSlackData($this->getRecord());

        $this->assertArrayNotHasKey('username', $data);
    }

    /**
     * @return array
     */
    public function dataStringify()
    {
        $jsonPrettyPrintFlag = defined('JSON_PRETTY_PRINT') ? JSON_PRETTY_PRINT : 128;

        $multipleDimensions = array(array(1, 2));
        $numericKeys = array('library' => 'monolog');
        $singleDimension = array(1, 'Hello', 'Jordi');

        return array(
            array(array(), '[]'),
            array($multipleDimensions, json_encode($multipleDimensions, $jsonPrettyPrintFlag)),
            array($numericKeys, json_encode($numericKeys, $jsonPrettyPrintFlag)),
            array($singleDimension, json_encode($singleDimension))
        );
    }

    /**
     * @dataProvider dataStringify
     */
    public function testStringify($fields, $expectedResult)
    {
        $slackRecord = new SlackRecord(
            '#test',
            'test',
            true,
            null,
            true,
            true
        );

        $this->assertSame($expectedResult, $slackRecord->stringify($fields));
    }

    public function testAddsCustomUsername()
    {
        $username = 'Monolog bot';
        $record = new SlackRecord(null, $username);
        $data = $record->getSlackData($this->getRecord());

        $this->assertArrayHasKey('username', $data);
        $this->assertSame($username, $data['username']);
    }

    public function testNoIcon()
    {
        $record = new SlackRecord();
        $data = $record->getSlackData($this->getRecord());

