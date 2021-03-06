    ],
        ];

        $this->setNextResponses($responses);

        $this->request('HEAD', '/', [], [], true);
        $this->assertEmpty($this->response->getContent());
        $this->assertNull($this->response->getETag());
        $this->assertNull($this->response->getLastModified());
    }

    public function testDoesNotCacheOptionsRequest()
    {
        $this->setNextResponse(200, ['Cache-Control' => 'public, s-maxage=60'], 'get');
        $this->request('GET', '/');
        $this->assertHttpKernelIsCalled();

        $this->setNextResponse(200, ['Cache-Control' => 'public, s-maxage=60'], 'options');
        $this->request('OPTIONS', '/');
        $this->assertHttpKernelIsCalled();

        $this->request('GET', '/');
        $this->assertHttpKernelIsNotCalled();
        $this->assertSame('get', $this->response->getContent());
    }

    public function testUsesOriginalRequestForSurrogate()
    {
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $store = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpCache\StoreInterface')->getMock();

        $kernel
            ->expects($this->exactly(2))
            ->method('handle')
            ->willReturnCallback(function (Request $request) {
                $this->assertSame('127.0.0.1', $request->server->get('REMOTE_ADDR'));

                return new Response();
            });

        $cache = new HttpCache($kernel,
            $store,
            new Esi()
        );

        $request = Request::create('/');
        $request->server->set('REMOTE_ADDR', '10.0.0.1');

        // Main request
        $cache->handle($request, HttpKernelInterface::MASTER_REQUEST);

        // Main request was now modified by HttpCache
        // The surrogate will ask for the request using $this->cache->getRequest()
        // which MUST return the original request so the surrogate
        // can actually behave like a reverse proxy like e.g. Varnish would.
        $this->assertSame('10.0.0.1', $cache->getRequest()->getClientIp());
        $this->assertSame('10.0.0.1', $cache->getRequest()->server->get('REMOTE_ADDR'));

        // Surrogate request
        $cache->handle($request, HttpKernelInterface::SUB_REQUEST);
    }
}

class TestKernel implements HttpKernelInterface
{
    public $terminateCalled = false;

    public function terminate(Request $request, Response $response)
    {
        $this->terminateCalled = true;
    }

    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, pleas