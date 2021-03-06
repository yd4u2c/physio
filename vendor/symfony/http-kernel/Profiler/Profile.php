s->assertTrue($request->attributes->get('_redirected'));
    }

    public function testItSetsARedirectCookieIfTheResponseIsARedirection()
    {
        $c = new RequestDataCollector();

        $response = $this->createResponse();
        $response->setStatusCode(302);
        $response->headers->set('Location', '/somewhere-else');

        $c->collect($request = $this->createRequest(), $response);
        $c->lateCollect();

        $cookie = $this->getCookieByName($response, 'sf_redirect');

        $this->assertNotEmpty($cookie->getValue());
        $this->assertSame('lax', $cookie->getSameSite());
        $this->assertFalse($cookie->isSecure());
    }

    public function testItCollectsTheRedirectionAndClearTheCookie()
    {
        $c = new RequestDataCollector();

        $request = $this->createRequest();
        $request->attributes->set('_redirected', true);
        $request->cookies->add([
            'sf_redirect' => '{"method": "POST"}',
        ]);

        $c->collect($request, $response = $this->createResponse());
        $c->lateCollect();

        $this->assertEquals('POST', $c->getRedirect()['method']);

        $cookie = $this->getCookieByName($response, 'sf_redirect');
        $this->assertNull($cookie->getValue());
    }

    protected function createRequest($routeParams = ['name' => 'foo'])
    {
        $request = Request::create('http://test.com/foo?bar=baz');
        $request->attributes->set('foo', 'bar');
        $request->attributes->set('_route', 'foobar');
        $request->attributes->set('_route_params', $routeParams);
        $request->attributes->set('resource', fopen(__FILE__, 'r'));
        $request->attributes->set('object', new \stdClass());

        return $request;
    }

    private function createRequestWithSession()
    {
        $request = $this->createRequest();
        $request->attributes->set('_controller', 'Foo::bar');
        $request->setSession(new Session(new MockArraySessionStorage()));
        $request->getSession()->start();

        return $request;
    }

    protected function createResponse()
    {
        $response = new Response();
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('X-Foo-Bar', null);
        $response->headers->setCookie(new Cookie('foo', 'bar', 1, '/foo', 'localhost', true, true, false, null));
        $response->headers->setCookie(new Cookie('bar', 'foo', new \DateTime('@946684800'), '/', null, false, true, false, null));
        $response->headers->setCookie(new Cookie('bazz', 'foo', '2000-12-12', '/', null, false, true, false, null));

        return $response;
    }

    /**
     * Inject the given controller callable into the data collector.
     */
    protected function injectController($collector, $controller, $request)
    {
        $resolver = $this->getMockBuilder('Symfony\\Component\\HttpKernel\\Controller\\ControllerResolverInterface')->getMock();
        $httpKernel = new HttpKernel(new EventDispatcher(), $resolver, null, $this->getMockBuilder(ArgumentResolverInterface::class)->getMock());
        $event = new FilterControllerEvent($httpKernel, $controller, $request, HttpKernelInterface::MASTER_REQUEST);
        $collector->onKernelController($event);
    }

    /**
     * Dummy method used as controller callable.
     */
    public static function staticControllerMethod()
    {
        throw new \LogicException('Unexpected method call');
    }

    /**
     * Magic method to allow non existing methods to be called and delegated.
     */
    public function __call($method, $args)
    {
        throw new \LogicException('Unexpected method call');
    }

    /**
     * Magic method to allow non existing methods to be called and delegated.
     */
    public static function __callStatic($method, $args)
    {
        throw new \LogicException('Unexpected method call');
    }

    public function __invoke()
    {
        throw new \LogicException('Unexpected method call');
    }

    private function getCookieByName(Response $response, $name)
    {
        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie->getName() == $name) {
                return $cookie;
            }
        }

        throw new \InvalidArgumentException(sprintf('Cookie named "%s" is not in response', $name));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              