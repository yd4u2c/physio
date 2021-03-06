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
use Monolog\Formatter\LineFormatter;

class RedisHandlerTest extends TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructorShouldThrowExceptionForInvalidRedis()
    {
        new RedisHandler(new \stdClass(), 'key');
    }

    public function testConstructorShouldWorkWithPredis()
    {
        $redis = $this->getMock('Predis\Client');
        $this->assertInstanceof('Monolog\Handler\RedisHandler', new RedisHandler($redis, 'key'));
    }

    public function testConstructorShouldWorkWithRedis()
    {
        $redis = $this->getMock('Redis');
        $this->assertInstanceof('Monolog\Handler\RedisHandler', new RedisHandler($redis, 'key'));
    }

    public function testPredisHandle()
    {
        $redis = $this->getMock('Predis\Client', array('rpush'));

        // Predis\Client uses rpush
        $redis->expects($this->once())
            ->method('rpush')
            ->with('key', 'test');

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key');
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }

    public function testRedisHandle()
    {
        $redis = $this->getMock('Redis', array('rpush'));

        // Redis uses rPush
        $redis->expects($this->once())
            ->method('rPush')
            ->with('key', 'test');

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key');
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }

    public function testRedisHandleCapped()
    {
        $redis = $this->getMock('Redis', array('multi', 'rpush', 'ltrim', 'exec'));

        // Redis uses multi
        $redis->expects($this->once())
            ->method('multi')
            ->will($this->returnSelf());

        $redis->expects($this->once())
            ->method('rpush')
            ->will($this->returnSelf());

        $redis->expects($this->once())
            ->method('ltrim')
            ->will($this->returnSelf());

        $redis->expects($this->once())
            ->method('exec')
            ->will($this->returnSelf());

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key', Logger::DEBUG, true, 10);
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }

    public function testPredisHandleCapped()
    {
        $redis = $this->getMock('Predis\Client', array('transaction'));

        $redisTransaction = $this->getMock('Predis\Client', array('rpush', 'ltrim'));

        $redisTransaction->expects($this->once())
            ->method('rpush')
            ->will($this->returnSelf());

        $redisTransaction->expects($this->once())
            ->method('ltrim')
            ->will($this->returnSelf());

        // Redis uses multi
        $redis->expects($this->once())
            ->method('transaction')
            ->will($this->returnCallback(function ($cb) use ($redisTransaction) {
                $cb($redisTransaction);
            }));

        $record = $this->getRecord(Logger::WARNING, 'test', array('data' => new \stdClass, 'foo' => 34));

        $handler = new RedisHandler($redis, 'key', Logger::DEBUG, true, 10);
        $handler->setFormatter(new LineFormatter("%message%"));
        $handler->handle($record);
    }
}
                                                                                                                                                                              <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Exception;
use Monolog\TestCase;
use Monolog\Logger;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * @author Erik Johansson <erik.pm.johansson@gmail.com>
 * @see    https://rollbar.com/docs/notifier/rollbar-php/
 *
 * @coversDefaultClass Monolog\Handler\RollbarHandler
 */
class RollbarHandlerTest extends TestCase
{
    /**
     * @var MockObject
     */
    private $rollbarNotifier;

    /**
     * @var array
     */
    public $reportedExceptionArguments = null;

    protected function setUp()
    {
        parent::setUp();

        $this->setupRollbarNotifierMock();
    }

    /**
     * When reporting exceptions to Rollbar the
     * level has to be set in the payload data
     */
    public function testExceptionLogLevel()
    {
        $handler = $this->createHandler();

        $handler->handle($this->createExceptionRecord(Logger::DEBUG));

        $this->assertEquals('debug', $this->reportedExceptionArguments['payload']['level']);
    }

    private function setupRollbarNotifierMock()
    {
        $this->rollbarNotifier = $this->getMockBuilder('RollbarNotifier')
            ->setMethods(array('report_message', 'report_exception', 'flush'))
            ->getMock();

        $that = $this;

        $this->rollbarNotifier
            ->expects($this->any())
            ->method('report_exception')
            ->willReturnCallback(function ($exception, $context, $payload) use ($that) {
                $that->reportedExceptionArguments = compact('exception', 'context', 'payload');
            });
    }

    private function createHandler()
    {
        return new RollbarHandler($this->rollbarNotifier, Logger::DEBUG);
    }

    private function createExceptionRecord($level = Logger::DEBUG, $message = 'test', $exception = null)
    {
        return $this->getRecord($level, $message, array(
            'exception' => $exception ?: new Exception()
        ));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

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
use PHPUnit_Framework_Error_Deprecated;

/**
 * @covers Monolog\Handler\RotatingFileHandler
 */
class RotatingFileHandlerTest extends TestCase
{
    /**
     * This var should be private but then the anonymous function
     * in the `setUp` method won't be able to set it. `$this` cant't
     * be used in the anonymous function in `setUp` because PHP 5.3
     * does not support it.
     */
    public $lastError;

    public function setUp()
    {
        $dir = __DIR__.'/Fixtures';
        chmod($dir, 0777);
        if (!is_writable($dir)) {
            $this->markTestSkipped($dir.' must be writable to test the RotatingFileHandler.');
        }
        $this->lastError = null;
        $self = $this;
        // workaround with &$self used for PHP 5.3
        set_error_handler(function($code, $message) use (&$self) {
            $self->lastError = array(
                'code' => $code,
                'message' => $message,
            );
        });
    }

    private function assertErrorWasTriggered($code, $message)
    {
        if (empty($this->lastError)) {
            $this->fail(
                sprintf(
                    'Failed asserting that error with code `%d` and message `%s` was triggered',
                    $code,
                    $message
                )
            );
        }
        $this->assertEquals($code, $this->lastError['code'], sprintf('Expected an error with code %d to be triggered, got `%s` instead', $code, $this->lastError['code']));
        $this->assertEquals($message, $this->lastError['message'], sprintf('Expected an error with message `%d` to be triggered, got `%s` instead', $message, $this->lastError['message']));
    }

    public function testRotationCreatesNewFile()
    {
        touch(__DIR__.'/Fixtures/foo-'.date('Y-m-d', time() - 86400).'.rot');

        $handler = new RotatingFileHandler(__DIR__.'/Fixtures/foo.rot');
        $handler->setFormatter($this->getIdentityFormatter());
        $handler->handle($this->getRecord());

        $log = __DIR__.'/Fixtures/foo-'.date('Y-m-d').'.rot';
        $this->assertTrue(file_exists($log));
        $this->assertEquals('test', file_get_contents($log));
    }

    /**
     * @dataProvider rotationTests
     */
    public function testRotation($createFile, $dateFormat, $timeCallback)
    {
        touch($old1 = __DIR__.'/Fixtures/foo-'.date($dateFormat, $timeCallback(-1)).'.rot');
        touch($old2 = __DIR__.'/Fixtures/foo-'.date($dateFormat, $timeCallback(-2)).'.rot');
        touch($old3 = __DIR__.'/Fixtures/foo-'.date($dateFormat, $timeCallback(-3)).'.rot');
        touch($old4 = __DIR__.'/Fixtures/foo-'.date($dateFormat, $timeCallback(-4)).'.rot');

        $log = __DIR__.'/Fixtures/foo-'.date($dateFormat).'.rot';

        if ($createFile) {
            touch($log);
        }

        $handler = new RotatingFileHandler(__DIR__.'/Fixtures/foo.rot', 2);
        $handler->setFormatter($this->getIdentityFormatter());
        $handler->setFilenameFormat('{filename}-{date}', $dateFormat);
        $handler->handle($this->getRecord());

        $handler->close();

        $this->assertTrue(file_exists($log));
        $this->assertTrue(file_exists($old1));
        $this->assertEquals($createFile, file_exists($old2));
        $this->assertEquals($createFile, file_exists($old3));
        $this->assertEquals($createFile, file_exists($old4));
        $this->assertEquals('test', file_get_contents($log));
    }

    public function rotationTests()
    {
        $now = time();
        $dayCallback = function($ago) use ($now) {
            return $now + 86400 * $ago;
        };
        $monthCallback = function($ago) {
            return gmmktime(0, 0, 0, date('n') + $ago, 1, date('Y'));
        };
        $yearCallback = function($ago) {
            return gmmktime(0, 0, 0, 1, 1, date('Y') + $ago);
        };

        return array(
            'Rotation is triggered when the file of the current day is not present'
                => array(true, RotatingFileHandler::FILE_PER_DAY, $dayCallback),
            'Rotation is not triggered when the file of the current day is already present'
                => array(false, RotatingFileHandler::FILE_PER_DAY, $dayCallback),

            'Rotation is triggered when the file of the current month is not present'
                => array(true, RotatingFileHandler::FILE_PER_MONTH, $monthCallback),
            'Rotation is not triggered when the file of the current month is already present'
                => array(false, RotatingFileHandler::FILE_PER_MONTH, $monthCallback),

            'Rotation is triggered when the file of the current year is not present'
                => array(true, RotatingFileHandler::FILE_PER_YEAR, $yearCallback),
            'Rotation is not triggered when the file of the current year is already present'
                => array(false, RotatingFileHandler::FILE_PER_YEAR, $yearCallback),
        );
    }

    /**
     * @dataProvider dateFormatProvider
     */
    public function testAllowOnlyFixedDefinedDateFormats($dateFormat, $valid)
    {
        $handler = new RotatingFileHandler(__DIR__.'/Fixtures/foo.rot', 2);
        $handler->setFilenameFormat('{filename}-{date}', $dateFormat);
        if (!$valid) {
            $this->assertErrorWasTriggered(
                E_USER_DEPRECATED,
                'Invalid date format - format must be one of RotatingFileHandler::FILE_PER_DAY ("Y-m-d"), '.
                'RotatingFileHandler::FILE_PER_MONTH ("Y-m") or RotatingFileHandler::FILE_PER_YEAR ("Y"), '.
                'or you can set one of the date formats using slashes, underscores and/or dots instead of dashes.'
            );
        }
    }

    public function dateFormatProvider()
    {
        return array(
            array(RotatingFileHandler::FILE_PER_DAY, true),
            array(RotatingFileHandler::FILE_PER_MONTH, true),
            array(RotatingFileHandler::FILE_PER_YEAR, true),
            array('m-d-Y', false),
            array('Y-m-d-h-i', false)
        );
    }

    /**
     * @dataProvider filenameFormatProvider
     */
    public function testDisallowFilenameFormatsWithoutDate($filenameFormat, $valid)
    {
        $handler = new RotatingFileHandler(__DIR__.'/Fixtures/foo.rot', 2);
        $handler->setFilenameFormat($filenameFormat, RotatingFileHandler::FILE_PER_DAY);
        if (!$valid) {
            $this->assertErrorWasTriggered(
                E_USER_DEPRECATED,
                'Invalid filename format - format should contain at least `{date}`, because otherwise rotating is impossible.'
            );
        }
    }

    public function filenameFormatProvider()
    {
        return array(
            array('{filename}', false),
            array('{filename}-{date}', true),
            array('{date}', true),
            array('foobar-{date}', true),
            array('foo-{date}-bar', true),
            array('{date}-foobar', true),
            array('foobar', false),
        );
    }

    /**
     * @dataProvider rotationWhenSimilarFilesExistTests
     */
    public function testRotationWhenSimilarFileNamesExist($dateFormat)
    {
        touch($old1 = __DIR__.'/Fixtures/foo-foo-'.date($dateFormat