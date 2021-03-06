POST"', $routeb->getCondition());
    }

    public function testClone()
    {
        $collection = new RouteCollection();
        $collection->add('a', new Route('/a'));
        $collection->add('b', new Route('/b', ['placeholder' => 'default'], ['placeholder' => '.+']));

        $clonedCollection = clone $collection;

        $this->assertCount(2, $clonedCollection);
        $this->assertEquals($collection->get('a'), $clonedCollection->get('a'));
        $this->assertNotSame($collection->get('a'), $clonedCollection->get('a'));
        $this->assertEquals($collection->get('b'), $clonedCollection->get('b'));
        $this->assertNotSame($collection->get('b'), $clonedCollection->get('b'));
    }

    public function testSetSchemes()
    {
        $collection = new RouteCollection();
        $routea = new Route('/a', [], [], [], '', 'http');
        $routeb = new Route('/b');
        $collection->add('a', $routea);
        $collection->add('b', $routeb);

        $collection->setSchemes(['http', 'https']);

        $this->assertEquals(['http', 'https'], $routea->getSchemes());
        $this->assertEquals(['http', 'https'], $routeb->getSchemes());
    }

    public function testSetMethods()
    {
        $collection = new RouteCollection();
        $routea = new Route('/a', [], [], [], '', [], ['GET', 'POST']);
        $routeb = new Route('/b');
        $collection->add('a', $routea);
        $collection->add('b', $routeb);

        $collection->setMethods('PUT');

        $this->assertEquals(['PUT'], $routea->getMethods());
        $this->assertEquals(['PUT'], $routeb->getMethods());
    }

    public function testAddNamePrefix()
    {
        $collection = new RouteCollection();
        $collection->add('foo', $foo = new Route('/foo'));
        $collection->add('bar', $bar = new Route('/bar'));
        $collection->add('api_foo', $apiFoo = new Route('/api/foo'));
        $collection->addNamePrefix('api_');

        $this->assertEquals($foo, $collection->get('api_foo'));
        $this->assertEquals($bar, $collection->get('api_bar'));
        $this->assertEquals($apiFoo, $collection->get('api_api_foo'));
        $this->assertNull($collection->get('foo'));
        $this->assertNull($collection->get('bar'));
    }

    public function testAddNamePrefixCanonicalRouteName()
    {
        $collection = new RouteCollection();
        $collection->add('foo', new Route('/foo', ['_canonical_route' => 'foo']));
        $collection->add('bar', new Route('/bar', ['_canonical_route' => 'bar']));
        $collection->add('api_foo', new Route('/api/foo', ['_canonical_route' => 'api_foo']));
        $collection->addNamePrefix('api_');

        $this->assertEquals('api_foo', $collection->get('api_foo')->getDefault('_canonical_route'));
        $this->assertEquals('api_bar', $collection->get('api_bar')->getDefault('_canonical_route'));
        $this->assertEquals('api_api_foo', $collection->get('api_api_foo')->getDefault('_canonical_route'));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                               