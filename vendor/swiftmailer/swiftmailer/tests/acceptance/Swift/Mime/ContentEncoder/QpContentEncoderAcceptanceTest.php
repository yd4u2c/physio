<?php

class Swift_Events_TransportExceptionEventTest extends \PHPUnit\Framework\TestCase
{
    public function testExceptionCanBeFetchViaGetter()
    {
        $ex = $this->createException();
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport, $ex);
        $ref = $evt->getException();
        $this->assertEquals($ex, $ref,
            '%s: Exception should be available via getException()'
            );
    }

    public function testSourceIsTransport()
    {
        $ex = $this->createException();
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport, $ex);
        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref,
            '%s: Transport should be available via getSource()'
            );
    }

    private function createEvent(Swift_Transport $transport, Swift_TransportException $ex)
    {
        return new Swift_Events_TransportExceptionEvent($transport, $ex);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }

    private function createException()
    {
        return new Swift_TransportException('');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

class Swift_KeyCache_ArrayKeyCacheTest extends \PHPUnit\Framework\TestCase
{
    private $key1 = 'key1';
    private $key2 = 'key2';

    public function testStringDataCanBeSetAndFetched()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $this->assertEquals('test', $cache->getString($this->key1, 'foo'));
    }

    public function testStringDataCanBeOverwritten()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $cache->setString(
            $this->key1, 'foo', 'whatever', Swift_KeyCache::MODE_WRITE
            );

        $this->assertEquals('whatever', $cache->getString($this->key1, 'foo'));
    }

    public function testStringDataCanBeAppended()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MODE_WRITE
            );
        $cache->setString(
            $this->key1, 'foo', 'ing', Swift_KeyCache::MODE_APPEND
            );

        $this->assertEquals('testing', $cache->getString($this->key1, 'foo'));
    }

    public function testHasKeyReturnValue()
    {
        $is = $this->createKeyCacheInputStream();
        $cache = $this->createCache($is);
        $cache->setString(
            $this->key1, 'foo', 'test', Swift_KeyCache::MOD