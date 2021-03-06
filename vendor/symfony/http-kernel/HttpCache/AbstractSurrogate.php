      $request->attributes->set('mandatory', 'mandatory');
        $controller = [new NullableController(), 'action'];

        $this->assertEquals(['foo', new \stdClass(), 'value', 'mandatory'], self::$resolver->getArguments($request, $controller));
    }

    public function testGetNullableArgumentsWithDefaults()
    {
        $request = Request::create('/');
        $request->attributes->set('mandatory', 'mandatory');
        $controller = [new NullableController(), 'action'];

        $this->assertEquals([null, null, 'value', 'mandatory'], self::$resolver->getArguments($request, $controller));
    }

    public function testGetSessionArguments()
    {
        $session = new Session(new MockArraySessionStorage());
        $request = Request::create('/');
        $request->setSession($session);
        $controller = [$this, 'controllerWithSession'];

        $this->assertEquals([$session], self::$resolver->getArguments($request, $controller));
    }

    public function testGetSessionArgumentsWithExtendedSession()
    {
        $session = new ExtendingSession(new MockArraySessionStorage());
        $request = Request::create('/');
        $request->setSession($session);
        $controller = [$this, 'controllerWithExtendingSession'];

        $this->assertEquals([$session], self::$resolver->getArguments($request, $controller));
    }

    public function testGetSessionArgumentsWithInterface()
    {
        $session = $this->getMockBuilder(SessionInterface::class)->getMock();
        $request = Request::create('/');
        $request->setSession($session);
        $controller = [$this, 'controllerWithSessionInterface'];

        $this->assertEquals([$session], self::$resolver->getArguments($request, $controller));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetSessionMissMatchWithInterface()
    {
        $session = $this->getMockBuilder(SessionInterface::class)->getMock();
        $request = Request::create('/');
        $request->setSession($session);
        $controller = [$this, 'controllerWithExtendingSession'];

        self::$resolver->getArguments($request, $controller);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetSessionMissMatchWithImplementation()
    {
        $session = new Session(new MockArraySessionStorage());
        $request = Request::create('/');
        $request->setSession($session);
        $controller = [$this, 'controllerWithExtendingSession'];

        self::$resolver->getArguments($request, $controller);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testGetSessionMissMatchOnNull()
    {
        $request = Request::create('/');
        $controller = [$this, 'controllerWithExtendingSession'];

        self::$resolver->getArguments($request, $controller);
    }

    public function __invoke($foo, $bar = null)
    {
    }

    public function controllerWithFoo($foo)
    {
    }

    public function controllerWithoutArguments()
    {
    }

    protected function controllerWithFooAndDefaultBar($foo, $bar = null)
    {
    }

    protected function controllerWithFooBarFoobar($foo, $bar, $foobar)
    {
    }

    protected function controllerWithRequest(Request $request)
    {
    }

    protected function controllerWithExtendingRequest(ExtendingRequest $request)
    {
    }

    protected function controllerWithSession(Session $session)
    {
    }

    protected function controllerWithSessionInterface(SessionInterface $session)
    {
    }

    protected function controllerWithExtendingSession(ExtendingSession $session)
    {
    }
}

function controller_function($foo, $foobar)
{
}
                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\Controller;

use Psr