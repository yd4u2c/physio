dateData, $options) {
                $this->assertEquals([$this->options['id_field'] => 'foo'], $criteria);
                $this->assertEquals(['upsert' => true], $options);

                $data = $updateData['$set'];
                $expectedExpiry = time() + (int) ini_get('session.gc_maxlifetime');
                $this->assertInstanceOf(\MongoDB\BSON\Binary::class, $data[$this->options['data_field']]);
                $this->assertEquals('bar', $data[$this->options['data_field']]->getData());
                $this->assertInstanceOf(\MongoDB\BSON\UTCDateTime::class, $data[$this->options['time_field']]);
                $this->assertInstanceOf(\MongoDB\BSON\UTCDateTime::class, $data[$this->options['expiry_field']]);
                $this->assertGreaterThanOrEqual($expectedExpiry, round((string) $data[$this->options['expiry_field']] / 1000));
            }));

        $this->assertTrue($this->storage->write('foo', 'bar'));
    }

    public function testReplaceSessionData()
    {
        $collection = $this->createMongoCollectionMock();

        $this->mongo->expects($this->once())
            ->method('selectCollection')
            ->with($this->options['database'], $this->options['collection'])
            ->will($this->returnValue($collection));

        $data = [];

        $collection->expects($this->exactly(2))
            ->method('updateOne')
            ->will($this->returnCallback(function ($criteria, $updateData, $options) use (&$data) {
                $data = $updateData;
            }));

        $this->storage->write('foo', 'bar');
        $this->storage->write('foo', 'foobar');

        $this->assertEquals('foobar', $data['$set'][$this->options['data_field']]->getData());
    }

    public function testDestroy()
    {
        $collection = $this->createMongoCollectionMock();

        $this->mongo->expects($this->once())
            ->method('selectCollection')
            ->with($this->options['database'], $this->options['collection'])
            ->will($this->returnValue($collection));

        $collection->expects($this->once())
            ->method('deleteOne')
            ->with([$this->options['id_field'] => 'foo']);

        $this->assertTrue($this->storage->destroy('foo'));
    }

    public function testGc()
    {
        $collection = $this->createMongoCollectionMock();

        $this->mongo->expects($this->once())
            ->method('selectCollection')
            ->with($this->options['database'], $this->options['collection'])
            ->will($this->returnValue($collection));

        $collection->expects($this->once())
            ->method('deleteMany')
            ->will($this->returnCallback(function ($criteria) {
                $this->assertInstanceOf(\MongoDB\BSON\UTCDateTime::class, $criteria[$this->options['expiry_field']]['$lt']);
                $this->assertGreaterThanOrEqual(time() - 1, round((string) $criteria[$this->options['expiry_field']]['$lt'] / 1000));
            }));

        $this->assertTrue($this->storage->gc(1));
    }

    public function testGetConnection()
    {
        $method = new \ReflectionMethod($this->storage, 'getMongo');
        $method->setAccessible(true);

        $this->assertInstanceOf(\MongoDB\Client::class, $method->invoke($this->storage));
    }

    private function createMongoCollectionMock()
    {
        $collection = $this->getMockBuilder(\MongoDB\Collection::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $collection;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                INDX( 	 Lr�             (   �  �       �a �r               [/     � �     Z/     0���pk� ;n< ��m���<�0���pk�       0              ' A b s t r a c t R e d i s S e s s i o n H a n d l e r T e s t C a s e . p h p \/     � ~     Z/     y7��pk� ;n< ������<�y7��pk�       D               A b s t r a c t S e s s i o n H a n d l e r T e s t . p h p   i/     h R     Z/     ���pk���ީ %����pk����pk�                        F i x t u r e s d S e ]/     � �     Z/     1���pk� ;n<  �����<�1���pk�       [               M e m c a c h e d S e s s i o n H a n d l e r T e s t . p h p ^/     � �     Z/     �"��pk� ;n< �!0���<��"��pk�        f               M i g r a t i n g S e s s i o n H a n d l e r T e s t . p h p _/     � |     Z/     ~���pk� ;n< �����<�~���pk�        �               M o n g o D b S e s s i o n H a n d l e r T e s t . p h p     `/     � �     Z/     XJ��pk� ;n< �����<�XJ��pk�       �                N a t i v e F i l e S e s s i o n H  n d l e r T e s t . p h p       a/     � v     Z/     [���pk� ;n< �����<�[���pk�       �               N u l l S e s s i o n H a n d l e r T e s t . p h p   b/     � t     Z/     ����pk� ;n< �	X��<�����pk� @      M5               P d o S e s s i o n H a n d l e r T e s t . p h p     c/     � �     Z/     Ki��pk� ;n< �r���<�Ki��pk�                     # P r e d i s C l u s t e r S e s s i o n H a n d l e r T e s t . p h p d/     � z     Z/     �-��pk� ;n< ����<��-��pk                      P r e d i s S e s s i o n H a n d l e r T e s t . p h p       e/     � �     Z/     ���pk� ;n< ����<����pk�                      R e d i s A r r a y S e s s i o n H a n d l e r T e s t . p h p       f/     � �     Z/     ���pk� ;n< �$~��<����pk�       �              " R e d i s C l u s t e r S e s s i o n H a n d l e r T e s t . p h p   g/     � x     Z/     ��pk� ;n< �����<���pk�0      ,               R e d i s S e s s i o n H a n d l e  T e s t . p h p h/     � z     Z/     @�pk� ;n< ��C��<�@�pk�                       S t r i c t S e s s i o n H a n d l e r T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

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
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

/**
 * Test class for NativeFileSessionHandler.
 *
 * @author Drak <drak@zikula.org>
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class NativeFileSessionHandlerTest extends TestCase
{
    public function testConstruct()
    {
        $storage = new NativeSessionStorage(['name' => 'TESTING'], new NativeFileSessionHandler(sys_get_temp_dir()));

        $this->assertEquals('user', ini_get('session.save_handler'));

        $this->assertEquals(sys_get_temp_dir(), ini_get('session.save_path'));
        $this->assertEquals('TESTING', ini_get('session.name'));
    }

    /**
     * @dataProvider savePathDataProvider
     */
    public function testConstructSavePath($savePath, $expectedSavePath, $path)
    {
        $handler = new NativeFileSessionHandler($savePath);
        $this->assertEquals($expectedSavePath, ini_get('session.save_path'));
        $this->assertTrue(is_dir(realpath($path)));

        rmdir($path);
    }

    public function savePathDataProvider()
    {
        $base = sys_get_temp_dir();

        return [
            ["$base/foo", "$base/foo", "$base/foo"],
            ["5;$base/foo", "5;$base/foo", "$base/foo"],
            ["5;0600;$base/foo", "5;0600;$base/foo", "$base/foo"],
        ];
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructException()
    {
        $handler = new NativeFileSessionHandler('something;invalid;with;too-many-args');
    }

    public function testConstructDefault()
    {
        $path = ini_get('session.save_path');
        $storage = new NativeSessionStorage(['name' => 'TESTING'], new NativeFileSessionHandler());

        $this->assertEquals($path, ini_get('session.save_path'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            