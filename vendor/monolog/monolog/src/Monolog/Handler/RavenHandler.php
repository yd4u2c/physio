<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Formatter;

use Monolog\Logger;
use Monolog\TestCase;

class FlowdockFormatterTest extends TestCase
{
    /**
     * @covers Monolog\Formatter\FlowdockFormatter::format
     */
    public function testFormat()
    {
        $formatter = new FlowdockFormatter('test_source', 'source@test.com');
        $record = $this->getRecord();

        $expected = array(
            'source' => 'test_source',
            'from_address' => 'source@test.com',
            'subject' => 'in test_source: WARNING - test',
            'content' => 'test',
            'tags' => array('#logs', '#warning', '#test'),
            'project' => 'test_source',
        );
        $formatted = $formatter->format($record);

        $this->assertEquals($expected, $formatted['flowdock']);
    }

    /**
     * @ covers Monolog\Formatter\FlowdockFormatter::formatBatch
     */
    public function testFormatBatch()
    {
        $formatter = new FlowdockFormatter('test_source', 'source@test.com');
        $records = array(
            $this->getRecord(Logger::WARNING),
            $this->getRecord(Logger::DEBUG),
        );
        $formatted = $formatter->formatBatch($records);

        $this->assertArrayHasKey('flowdock', $formatted[0]);
        $this->assertArrayHasKey('flowdock', $formatted[1]);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Formatter;

use Monolog\Logger;
use Monolog\TestCase;

class FluentdFormatterTest extends TestCase
{
    /**
     * @covers Monolog\Formatter\FluentdFormatter::__construct
     * @covers Monolog\Formatter\FluentdFormatter::isUsingLevelsInTag
     */
    public function testConstruct()
    {
        $formatter = new FluentdFormatter();
        $this->assertEquals(false, $formatter->isUsingLevelsInTag());
        $formatter = new FluentdFormatter(false);
        $this->assertEquals(false, $formatter->isUsingLevelsInTag());
        $formatter = new FluentdFormatter(true);
        $this->assertEquals(true, $formatter->isUsingLevelsInTag());
    }

    /**
     * @covers Monolog\Formatter\FluentdFormatter::format
     */
    public function testFormat()
    {
        $record = $this->getRecord(Logger::WARNING);
        $record['datetime'] = new \DateTime("@0");

        $formatter = new FluentdFormatter();
        $this->assertEquals(
            '["test",0,{"message":"test","context":[],"extra":[],"level":300,"level_name":"WARNING"}]',
            $formatter->format($record)
        );
    }

    /**
     * @covers Monolog\Formatter\FluentdFormatter::format
     */
    public function testFormatWithTag()
    {
        $record = $this->getRecord(Logger::ERROR);
        $record['datetime'] = new \DateTime("@0");

        $formatter = new FluentdFormatter(true);
        $this->assertEquals(
            '["test.error",0,{"message":"test","context":[],"extra":[]}]',
            $formatter->format($record)
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 