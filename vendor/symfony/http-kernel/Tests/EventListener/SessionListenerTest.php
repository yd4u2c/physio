 "<s"; ?>cript language=php>', $response->getContent());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testProcessWhenNoSrcInAnSsi()
    {
        $ssi = new Ssi();

        $request = Request::create('/');
        $response = new Response('foo <!--#include -->');
        $ssi->process($request, $response);
    }

    public function testProcessRemoveSurrogateControlHeader()
    {
        $ssi = new Ssi();

        $request = Request::create('/');
        $response = new Response('foo <!--#include virtual="..." -->');
        $response->headers->set('Surrogate-Control', 'content="SSI/1.0"');
        $ssi->process($request, $response);
        $this->assertEquals('SSI', $response->headers->get('x-body-eval'));

        $response->headers->set('Surrogate-Control', 'no-store, content="SSI/1.0"');
        $ssi->process($request, $response);
        $this->assertEquals('SSI', $response->headers->get('x-body-eval'));
        $this->assertEquals('no-store', $response->headers->get('surrogate-control'));

        $response->headers->set('Surrogate-Control', 'content="SSI/1.0", no-store');
        $ssi->process($request, $response);
        $this->assertEquals('SSI', $response->headers->get('x-body-eval'));
        $this->assertEquals('no-store', $response->headers->get('surrogate-control'));
    }

    public function testHandle()
    {
        $ssi = new Ssi();
        $cache = $this->getCache(Request::create('/'), new Response('foo'));
        $this->assertEquals('foo', $ssi->handle($cache, '/', '/alt', true));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testHandleWhenResponseIsNot200()
    {
        $ssi = new Ssi();
        $response = new Response('foo');
        $response->setStatusCode(404);
        $cache = $this->getCache(Request::create('/'), $response);
        $ssi->handle($cache, '/', '/alt', false);
    }

    public function testHandleWhenResponseIsNot200AndErrorsAreIgnored()
    {
        $ssi = new Ssi();
        $response = new Response('foo');
        $response->setStatusCode(404);
        $cache = $this->getCache(Request::create('/'), $response);
        $this->assertEquals('', $ssi->handle($cache, '/', '/alt', true));
    }

    public function testHandleWhenResponseIsNot200AndAltIsPresent()
    {
        $ssi = new Ssi();
        $response1 = new Response('foo');
        $response1->setStatusCode(404);
        $response2 = new Response('bar');
        $cache = $this->getCache(Request::create('/'), [$response1, $response2]);
        $this->assertEquals('bar', $ssi->handle($cache, '/', '/alt', false));
    }

    protected function getCache($request, $response)
    {
        $cache = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpCache\HttpCache')->setMethods(['getRequest', 'handle'])->disableOriginalConstructor()->getMock();
        $cache->expects($this->any())
              ->method('getRequest')
              ->will($this->returnValue($request))
        ;
        if (\is_array($response)) {
            $cache->expects($this->any())
                  ->method('handle')
                  ->will($this->onConsecutiveCalls(...$response))
            ;
        } else {
            $cache->expects($this->any())
                  ->method('handle')
                  ->will($this->returnValue($response))
            ;
        }

        return $cache;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\HttpCache;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpCache\Store;

class StoreTest extends TestCase
{
    protected $request;
    protected $response;

    /**
     * @var Store
     */
    protected $store;

    protected function setUp()
    {
        $this->request = Request::create('/');
        $this->response = new Response('hello world', 200, []);

        HttpCacheTestCase::clearDirectory(sys_get_temp_dir().'/http_cache');

        $this->store = new Store(sys_get_temp_dir().'/http_cache');
    }

    protected function tearDown()
    {
        $this->store = null;
        $this->request = null;
        $this->response = null;

        HttpCacheTestCase::clearDirectory(sys_get_temp_dir().'/http_cache');
    }

    public function testReadsAnEmptyArrayWithReadWhenNothingCachedAtKey()
    {
        $this->assertEmpty($this->getStoreMetadata('/nothing'));
    }

    public function testUnlockFileThatDoesExist()
    {
        $cacheKey = $this->storeSimpleEntry();
        $this->store->lock($this->request);

        $this->assertTrue($this->store->unlock($this->request));
    }

    public function testUnlockFileThatDoesNotExist()
    {
        $this->assertFalse($this->store->unlock($this->request));
    }

    public function testRemovesEntriesForKeyWithPurge()
    {
        $request = Request::create('/foo');
        $this->store->write($request, new Response('foo'));

        $metadata = $this->getStoreMetadata($request);
        $this->assertNotEmpty($metadata);

        $this->assertTrue($this->store->purge('/foo'));
        $this->assertEmpty($this->getStoreMetadata($request));

        // cached content should be kept after purging
        $path = $this->store->getPath($metadata[0][1]['x-content-digest'][0]);
        $this->assertTrue(is_file($path));

        $this->assertFalse($this->store->purge('/bar'));
    }

    public function testStoresACacheEntry()
    {
        $cacheKey = $this->storeSimpleEntry();

        $this->assertNotEmpty($this->getStoreMetadata($cacheKey));
    }

    public function testSetsTheXContentDigestResponseHeaderBeforeStoring()
    {
        $cacheKey = $this->storeSimpleEntry();
        $entries = $this->getStoreMetadata($cacheKey);
        list($req, $res) = $entries[0];

        $this->assertEquals('en9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', $res['x-content-digest'][0]);
    }

    public function testFindsAStoredEntryWithLookup()
    {
        $this->storeSimpleEntry();
        $response = $this->store->lookup($this->request);

        $this->assertNotNull($response);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
    }

    public function testDoesNotFindAnEntryWithLookupWhenNoneExists()
    {
        $request = Request::create('/test', 'get', [], [], [], ['HTTP_FOO' => 'Foo', 'HTTP_BAR' => 'Bar']);

        $this->assertNull($this->store->lookup($request));
    }

    public function testCanonizesUrlsForCacheKeys()
    {
        $this->storeSimpleEntry($path = '/test?x=y&p=q');
        $hitsReq = Request::create($path);
        $missReq = Request::create('/test?p=x');

        $this->assertNotNull($this->store->lookup($hitsReq));
        $this->assertNull($this->store->lookup($missReq));
    }

    public function testDoesNotFindAnEntryWithLookupWhenTheBodyDoesNotExist()
    {
        $this->storeSimpleEntry();
        $this->assertNotNull($this->response->headers->get('X-Content-Digest'));
        $path = $this->getStorePath($this->response->headers->get('X-Content-Digest'));
        @unlink($path);
        $this->assertNull($this->store->lookup($this->request));
    }

    public function testRestoresResponseHeadersProperlyWithLookup()
    {
        $this->storeSimpleEntry();
        $response = $this->store->lookup($this->request);

        $this->assertEquals($response->headers->all(), array_merge(['content-length' => 4, 'x-body-file' => [$this->getStorePath($response->headers->get('X-Content-Digest'))]], $this->response->headers->all()));
    }

    public function testRestoresResponseContentFromEntityStoreWithLookup()
    {
        $this->storeSimpleEntry();
        $response = $this->store->lookup($this->reque