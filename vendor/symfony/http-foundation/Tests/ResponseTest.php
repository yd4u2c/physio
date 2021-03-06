<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

/**
 * Test class for NullSessionHandler.
 *
 * @author Drak <drak@zikula.org>
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class NullSessionHandlerTest extends TestCase
{
    public function testSaveHandlers()
    {
        $storage = $this->getStorage();
        $this->assertEquals('user', ini_get('session.save_handler'));
    }

    public function testSession()
    {
        session_id('nullsessionstorage');
        $storage = $this->getStorage();
        $session = new Session($storage);
        $this->assertNull($session->get('something'));
        $session->set('something', 'unique');
        $this->assertEquals('unique', $session->get('something'));
    }

    public function testNothingIsPersisted()
    {
        session_id('nullsessionstorage');
        $storage = $this->getStorage();
        $session = new Session($storage);
        $session->start();
        $this->assertEquals('nullsessionstorage', $session->getId());
        $this->assertNull($session->get('something'));
    }

    public function getStorage()
    {
        return new NativeSessionStorage([], new NullSessionHandler());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

/**
 * @requires extension pdo_sqlite
 * @group time-sensitive
 */
class PdoSessionHandlerTest extends TestCase
{
    private $dbFile;

    protected function tearDown()
    {
        // make sure the temporary database file is deleted when it has been created (even when a test fails)
        if ($this->dbFile) {
            @unlink($this->dbFile);
        }
        parent::tearDown();
    }

    protected function getPersistentSqliteDsn()
    {
        $this->dbFile = tempnam(sys_get_temp_dir(), 'sf_sqlite_sessions');

        return 'sqlite:'.$this->dbFile;
    }

    protected function getMemorySqlitePdo()
    {
        $pdo = new \PDO('sqlite::memory:');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $storage = new PdoSessionHandler($pdo);
        $storage->createTable();

        return $pdo;
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testWrongPdoErrMode()
    {
        $pdo = $this->getMemorySqlitePdo();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);

        $storage = new PdoSessionHandler($pdo);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInexistentTable()
    {
        $storage = new PdoSessionHandler($this->getMemorySqlitePdo(), ['db_table' => 'inexistent_table']);
        $storage->open('', 'sid');
        $storage->read('id');
        $storage->write('id', 'data');
        $storage->close();
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testCreateTableTwice()
    {
        $storage = new PdoSessionHandler($this->getMemorySqlitePdo());
        $storage->createTable();
    }

    public function testWithLazyDsnConnection()
    {
        $dsn = $this->getPersistentSqliteDsn();

        $storage = new PdoSessionHandler($dsn);
        $storage->createTable();
        $storage->open('', 'sid');
        $data = $storage->read('id');
        $storage->write('id', 'data');
        $storage->close();
        $this->assertSame('', $data, 'New session returns empty string data');

        $storage->open('', 'sid');
        $data = $storage->read('id');
        $storage->close();
        $this->assertSame('data', $data, 'Written value can be read back correctly');
    }

    public function testWithLazySavePathConnection()
    {
        $dsn = $this->getPersistentSqliteDsn();

        // Open is called with what ini_set('session.save_path', $dsn) would mean
        $storage = new PdoSessionHandler(null);
        $storage->open($dsn, 'sid');
        $storage->createTable();
        $data = $storage->read('id');
        $storage->write('id', 'data');
        $storage->close();
        $this->assertSame('', $data, 'New session returns empty string data');

        $storage->open($dsn, 'sid');
        $data = $storage->read('id');
        $storage->close();
        $this->assertSame('data', $data, 'Written value can be read back correctly');
    }

    public function testReadWriteReadWithNullByte()
    {
        $sessionData = 'da'."\0".'ta';

        $storage = new PdoSessionHandler($this->getMemorySqlitePdo());
        $storage->open('', 'sid');
        $readData = $storage->read('id');
        $storage->write('id', $sessionData);
        $storage->close();
        $this->assertSame('', $readData, 'New session returns empty string data');

        $storage->open('', 'sid');
        $readData = $storage->read('id');
        $storage->close();
        $this->assertSame($sessionData, $readData, 'Written value can be read back correctly');
    }

    public function testReadConvertsStreamToString()
    {
        $pdo = new MockPdo('pgsql');
        $pdo->prepareResult = $this->getMockBuilder('PDOStatement')->getMock();

        $content = 'foobar';
        $stream = $this->createStream($content);

        $pdo->prepareResult->expects($this->once())->method('fetchAll')
            ->will($this->returnValue([[$stream, 42, time()]]));

        $storage = new PdoSessionHandler($pdo);
        $result = $storage->read('foo');

        $this->assertSame($content, $result);
    }

    public function testReadLockedConvertsStreamToString()
    {
        if (filter_var(ini_get('session.use_strict_mode'), FILTER_VALIDATE_BOOLEAN)) {
            $this->markTestSkipped('Strict mode needs no locking for new sessions.');
        }

        $pdo = new MockPdo('pgsql');
        $selectStmt = $this->getMockBuilder('PDOStatement')->getMock();
        $insertStmt = $this->getMockBuilder('PDOStatement')->getMock();

        $pdo->prepareResult = function ($statement) use ($selectStmt, $insertStmt) {
            return 0 === strpos($statement, 'INSERT') ? $insertStmt : $selectStmt;
        };

        $content = 'foobar';
        $stream = $this->createStream($content);
        $exception = null;

        $selectStmt->expects($this->atLeast(2))->method('fetchAll')
            ->will($this->returnCallback(function () use (&$exception, $stream) {
                return $exception ? [[$stream, 42, time()]] : [];
            }));

        $insertStmt->expects($this->once())->method('execute')
            ->will($this->returnCallback(function () use (&$exception) {
                throw $exception = new \PDOException('', '23');
            }));

        $storage = new PdoSessionHandler($pdo);
        $result = $storage->read('foo');

        $this->assertSame($content, $result);
    }

    public function testReadingRequiresExactlySameId()
    {
        $storage = new PdoSessionHandler($this->getMemorySqlitePdo());
        $storage->open('', 'sid');
        $storage->write('id', 'data');
        $storage->write('test', 'data');
        $storage->write('space ', 'data');
        $storage->close();

        $storage->open('', 'sid');
        $readDataCaseSensitive = $storage->read('ID');
        $readDataNoCharFolding = $storage->read('tést');
        $readDataKeepSpace = $storage->read('space ');
        $readDataExtraSpace = $storage->read('space  ');
        $storage->close();

        $this->assertSame('', $readDataCaseSensitive, 'Retrieval by ID should be case-sensitive (collation setting)');
        $this->assertSame('', $readDataNoCharFolding, 'Retrieval by ID should not do character folding (collation setting)');
        $this->assertSame('data', $readDataKeepSpace, 'Retrieval by ID requires spaces as-is');
        $this->assertSame('', $readDataExtraSpace, 'Retrieval by ID requires spaces as-is');
    }

    /**
     * Simulates session_regenerate_id(true) which will require an INSERT or UPDATE (replace).
     */
    public function testWriteDifferentSessionIdThanRead()
    {
        $storage = new PdoSessionHandler($this->getMemorySqlitePdo());
        $storage->open('', 'sid');
        $storage->read('id');
        $storage->destroy('id');
        $storage->write('new_id', 'data_of_new_session_id');
        $storage->close();

        $storage->open('', 'sid');
        $data = $storage->read('new_id');
        $storage->close();

        $this->assertSame('data_of_new_session_id', $data, 'Data of regenerated session id is available');
    }

    public function testWrongUsageStillWorks()
    {
        // wrong method sequence that should no happen, but still works
        $storage = new PdoSessionHandler($this->getMemorySqlitePdo());
        $storage->write('id', 'data');
        $storage->write('other_id', 'other_data');
        $storage->destroy('inexistent');
        $storage->open('', 'sid');
        $data = $storage->read('id');
        $otherData = $storage->read('other_id');
        $storage->close();

        $this->assertSame('data', $data);
        $this->assertSame('other_data', $otherData);
    }

    public function testSessionDestroy()
    {
        $pdo = $this->getMemorySqlitePdo();
        $storage = new PdoSessionHandler($pdo);

        $storage->open('', 'sid');
        $storage->read('id');
        $storage->write('id', 'data');
        $storage->close();
        $this->assertEquals(1, $pdo->query('SELECT COUNT(*) FROM sessions')->fetchColumn());

        $storage->open('', 'sid');
        $storage->read('id');
        $storage->destroy('id');
        $storage->close();
        $this->assertEquals(0, $pdo->query('SELECT COUNT(*) FROM sessions')->fetchColumn());

        $storage->open('', 'sid');
        $data = $storage->read('id');
        $storage->close();
        $this->assertSame('', $data, 'Destroyed session returns empty string');
    }

    /**
     * @runInSeparateProcess
     */
    public function testSessionGC()
    {
        $previousLifeTime = ini_set('session.gc_maxlifetime', 1000);
        $pdo = $this->getMemorySqlitePdo();
        $storage = new PdoSessionHandler($pdo);

        $storage->open('', 'sid');
        $storage->read('id');
        $storage->write('id', 'data');
        $storage->close();

        $storage->open('', 'sid');
        $storage->read('gc_id');
        ini_set('session.gc_maxlifetime', -1); // test that you can set lifetime of a session after it has been read
        $storage->write('gc_id', 'data');
        $storage->close();
        $this->assertEquals(2, $pdo->query('SELECT COUNT(*) FROM sessions')->fetchColumn(), 'No session pruned because gc not called');

        $storage->open('', 'sid');
        $data = $storage->read('gc_id');
        $storage->gc(-1);
        $storage->close();

        ini_set('session.gc_maxlifetime', $previousLifeTime);

        $this->assertSame('', $data, 'Session already considered garbage, so not returning data even if it is not pruned yet');
        $this->assertEquals(1, $pdo->query('SELECT COUNT(*) FROM sessions')->fetchColumn(), 'Expired session is pruned');
    }

    public function testGetConnection()
    {
        $storage = new PdoSessionHandler($this->getMemorySqlitePdo());

        $method = new \ReflectionMethod($storage, 'getConnection');
        $method->setAccessible(true);

        $this->assertInstanceOf('\PDO', $method->invoke($storage));
    }

    public function testGetConnectionConnectsIfNeeded()
    {
        $storage = new PdoSessionHandler('sqlite::memory:');

        $method = new \ReflectionMethod($storage, 'getConnection');
        $method->setAccessible(true);

        $this->assertInstanceOf('\PDO', $method->invoke($storage));
    }

    /**
     * @dataProvider provideUrlDsnPairs
     */
    public function testUrlDsn($url, $expectedDsn, $expectedUser = null, $expectedPassword = null)
    {
        $storage = new PdoSessionHandler($url);

        $this->assertAttributeEquals($expectedDsn, 'dsn', $storage);

        if (null !== $expectedUser) {
            $this->assertAttributeEquals($expectedUser, 'username', $storage);
        }

        if (null !== $expectedPassword) {
            $this->assertAttributeEquals($expectedPassword, 'password', $storage);
        }
    }

    public function provideUrlDsnPairs()
    {
        yield ['mysql://localhost/test', 'mysql:host=localhost;dbname=test;'];
        yield ['mysql://localhost:56/test', 'mysql:host=localhost;port=56;dbname=test;'];
        yield ['mysql2://root:pwd@localhost/test', 'mysql:host=localhost;dbname=test;', 'root', 'pwd'];
        yield ['postgres://localhost/test', 'pgsql:host=localhost;dbname=test;'];
        yield ['postgresql://localhost:5634/test', 'pgsql:host=localhost;port=5634;dbname=test;'];
        yield ['postgres://root:pwd@localhost/test', 'pgsql:host=localhost;dbname=test;', 'root', 'pwd'];
        yield 'sqlite relative path' => ['sqlite://localhost/tmp/test', 'sqlite:tmp/test'];
        yield 'sqlite absolute path' => ['sqlite://localhost//tmp/test', 'sqlite:/tmp/test'];
        yield 'sqlite relative path without host' => ['sqlite:///tmp/test', 'sqlite:tmp/test'];
        yield 'sqlite absolute path without host' => ['sqlite3:////tmp/test', 'sqlite:/tmp/test'];
        yield ['sqlite://localhost/:memory:', 'sqlite::memory:'];
        yield ['mssql://localhost/test', 'sqlsrv:server=localhost;Database=test'];
        yield ['mssql://localhost:56/test', 'sqlsrv:server=localhost,56;Database=test'];
    }

    private function createStream($content)
    {
        $stream = tmpfile();
        fwrite($stream, $content);
        fseek($stream, 0);

        return $stream;
    }
}

class MockPdo extends \PDO
{
    public $prepareResult;
    private $driverName;
    private $errorMode;

    public function __construct($driverName = null, $errorMode = null)
    {
        $this->driverName = $driverName;
        $this->errorMode = null !== $errorMode ?: \PDO::ERRMODE_EXCEPTION;
    }

    public function getAttribute($attribute)
    {
        if (\PDO::ATTR_ERRMODE === $attribute) {
            return $this->errorMode;
        }

        if (\PDO::ATTR_DRIVER_NAME === $attribute) {
            return $this->driverName;
        }

        return parent::getAttribute($attribute);
    }

    public function prepare($statement, $driverOptions = [])
    {
        return \is_callable($this->prepareResult)
            ? ($this->prepareResult)($statement, $driverOptions)
            : $this->prepareResult;
    }

    public function beginTransaction()
    {
    }

    public function rollBack()
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

class RedisClusterSessionHandlerTest extends AbstractRedisSessionHandlerTestCase
{
    public static function setupBeforeClass()
    {
        if (!class_exists('RedisCluster')) {
            self::markTestSkipped('The RedisCluster class is required.');
        }

        if (!$hosts = getenv('REDIS_CLUSTER_HOSTS')) {
            self::markTestSkipped('REDIS_CLUSTER_HOSTS env var is not defined.');
        }
    }

    protected function createRedisClient(string $host): \RedisCluster
    {
        return new \RedisCluster(null, explode(' ', getenv('REDIS_CLUSTER_HOSTS')));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\StrictSessionHandler;

class StrictSessionHandlerTest extends TestCase
{
    public function testOpen()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('open')
            ->with('path', 'name')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertInstanceOf('SessionUpdateTimestampHandlerInterface', $proxy);
        $this->assertInstanceOf(AbstractSessionHandler::class, $proxy);
        $this->assertTrue($proxy->open('path', 'name'));
    }

    public function testCloseSession()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('close')
            ->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->close());
    }

    public function testValidateIdOK()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('data');
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->validateId('id'));
    }

    public function testValidateIdKO()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('');
        $proxy = new StrictSessionHandler($handler);

        $this->assertFalse($proxy->validateId('id'));
    }

    public function testRead()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('data');
        $proxy = new StrictSessionHandler($handler);

        $this->assertSame('data', $proxy->read('id'));
    }

    public function testReadWithValidateIdOK()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('data');
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->validateId('id'));
        $this->assertSame('data', $proxy->read('id'));
    }

    public function testReadWithValidateIdMismatch()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->exactly(2))->method('read')
            ->withConsecutive(['id1'], ['id2'])
            ->will($this->onConsecutiveCalls('data1', 'data2'));
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->validateId('id1'));
        $this->assertSame('data2', $proxy->read('id2'));
    }

    public function testUpdateTimestamp()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('write')
            ->with('id', 'data')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->updateTimestamp('id', 'data'));
    }

    public function testWrite()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('write')
            ->with('id', 'data')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->write('id', 'data'));
    }

    public function testWriteEmptyNewSession()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('');
        $handler->expects($this->never())->method('write');
        $handler->expects($this->once())->method('destroy')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertFalse($proxy->validateId('id'));
        $this->assertSame('', $proxy->read('id'));
        $this->assertTrue($proxy->write('id', ''));
    }

    public function testWriteEmptyExistingSession()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('data');
        $handler->expects($this->never())->method('write');
        $handler->expects($this->once())->method('destroy')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertSame('data', $proxy->read('id'));
        $this->assertTrue($proxy->write('id', ''));
    }

    public function testDestroy()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('destroy')
            ->with('id')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->destroy('id'));
    }

    public function testDestroyNewSession()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('');
        $handler->expects($this->once())->method('destroy')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertSame('', $proxy->read('id'));
        $this->assertTrue($proxy->destroy('id'));
    }

    public function testDestroyNonEmptyNewSession()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('read')
            ->with('id')->willReturn('');
        $handler->expects($this->once())->method('write')
            ->with('id', 'data')->willReturn(true);
        $handler->expects($this->once())->method('destroy')
            ->with('id')->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertSame('', $proxy->read('id'));
        $this->assertTrue($proxy->write('id', 'data'));
        $this->assertTrue($proxy->destroy('id'));
    }

    public function testGc()
    {
        $handler = $this->getMockBuilder('SessionHandlerInterface')->getMock();
        $handler->expects($this->once())->method('gc')
            ->with(123)->willReturn(true);
        $proxy = new StrictSessionHandler($handler);

        $this->assertTrue($proxy->gc(123));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

use Symfony\Component\HttpFoundation\Session\Storage\Handler\AbstractSessionHandler;

$parent = __DIR__;
while (!@file_exists($parent.'/vendor/autoload.php')) {
    if (!@file_exists($parent)) {
        // open_basedir restriction in effect
        break;
    }
    if ($parent === dirname($parent)) {
        echo "vendor/autoload.php not found\n";
        exit(1);
    }

    $parent = dirname($parent);
}

require $parent.'/vendor/autoload.php';

error_reporting(-1);
ini_set('html_errors', 0);
ini_set('display_errors', 1);
ini_set('session.gc_probability', 0);
ini_set('session.serialize_handler', 'php');
ini_set('session.cookie_lifetime', 0);
ini_set('session.cookie_domain', '');
ini_set('session.cookie_secure', '');
ini_set('session.cookie_httponly', '');
ini_set('session.use_cookies', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cache_expire', 180);
ini_set('session.cookie_path', '/');
ini_set('session.cookie_domain', '');
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.lazy_write', 1);
ini_set('session.name', 'sid');
ini_set('session.save_path', __DIR__);
ini_set('session.cache_limiter', '');

header_remove('X-Powered-By');
header('Content-Type: text/plain; charset=utf-8');

register_shutdown_function(function () {
    echo "\n";
    session_write_close();
    print_r(headers_list());
    echo "shutdown\n";
});
ob_start();

class TestSessionHandler extends AbstractSessionHandler
{
    private $data;

    public function __construct($data = '')
    {
        $this->data = $data;
    }

    public function open($path, $name)
    {
        echo __FUNCTION__, "\n";

        return parent::open($path, $name);
    }

    public function validateId($sessionId)
    {
        echo __FUNCTION__, "\n";

        return parent::validateId($sessionId);
    }

    /**
     * {@inheritdoc}
     */
    public function read($sessionId)
    {
        echo __FUNCTION__, "\n";

        return parent::read($sessionId);
    }

    /**
     * {@inheritdoc}
     */
    public function updateTimestamp($sessionId, $data)
    {
        echo __FUNCTION__, "\n";

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function write($sessionId, $data)
    {
        echo __FUNCTION__, "\n";

        return parent::write($sessionId, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function destroy($sessionId)
    {
        echo __FUNCTION__, "\n";

        return parent::destroy($sessionId);
    }

    public function close()
    {
        echo __FUNCTION__, "\n";

        return true;
    }

    public function gc($maxLifetime)
    {
        echo __FUNCTION__, "\n";

        return true;
    }

    protected function doRead($sessionId)
    {
        echo __FUNCTION__.': ', $this->data, "\n";

        return $this->data;
    }

    protected function doWrite($sessionId, $data)
    {
        echo __FUNCTION__.': ', $data, "\n";

        return true;
    }

    protected function doDestroy($sessionId)
    {
        echo __FUNCTION__, "\n";

        return true;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   INDX( 	 ���             (   �  �       n  �               j/     h V     i/     ���pk� ;n< ��C��<����pk�       =              
 c o m m o n . i n c   k/     � p     i/     �+�pk� ;n< �h���<��+�pk�H      C               e m p t y _ d e s t r o y s . e x p e c t e d l/     x f     i/     Y��pk� ;n< ����<�Y��pk��       �                e m p t y _ d e s t r o y s . p h p   m/     x f     i/     S �pk� ;n< ��i��<�S �pk��       �                r e a d _ o  l y . e x p e c t e d   n/     p \     i/     ��"�pk� ;n< ��i��<���"�pk��       �                r e a d _ o n l y . p h p     o/     x h     i/     ��"�pk� ;n< �L���<���"�pk�h      b               r e g e n e r a t e . e x p e c t e d p/     p ^     i/     &z'�pk� ;n< ��/��<�&z'�pk�                       r e g e n e r a t e . p h p   q/     x b     i/     &z'�pk� ;n< ��/��<�&z'�pk�                     s t o r a g e . e x p e c t e d       r/     h X     i/     
�)�pk� ;n< ��� ��<�
�)�pk��      �               s t o r a g e . p h p s/     � j     i/     �>,�pk� ;n< ���"��<��>,�pk��       �                w i t h _ c o o k i e . e x p e c t e d       t/     p `     i/     