alizeWhenCompiledWithClass()
    {
        $route = new Route('/', [], [], ['compiler_class' => '\Symfony\Component\Routing\Tests\Fixtures\CustomRouteCompiler']);
        $this->assertInstanceOf('\Symfony\Component\Routing\Tests\Fixtures\CustomCompiledRoute', $route->compile(), '->compile() returned a proper route');

        $serialized = serialize($route);
        try {
            $unserialized = unserialize($serialized);
            $this->assertInstanceOf('\Symfony\Component\Routing\Tests\Fixtures\CustomCompiledRoute', $unserialized->compile(), 'the unserialized route compiled successfully');
        } catch (\Exception $e) {
            $this->fail('unserializing a route which uses a custom compiled route class');
        }
    }

    /**
     * Tests that the serialized representation of a route in one symfony version
     * also works in later symfony versions, i.e. the unserialized route is in the
     * same state as another, semantically equivalent, route.
     */
    public function testSerializedRepresentationKeepsWorking()
    {
        $serialized = 'C:31:"Symfony\Component\Routing\Route":936:{a:8:{s:4:"path";s:13:"/prefix/{foo}";s:4:"host";s:20:"{locale}.example.net";s:8:"defaults";a:1:{s:3:"foo";s:7:"default";}s:12:"requirements";a:1:{s:3:"foo";s:3:"\d+";}s:7:"options";a:1:{s:14:"compiler_class";s:39:"Symfony\Component\Routing\RouteCompiler";}s:7:"schemes";a:0:{}s:7:"methods";a:0:{}s:8:"compiled";C:39:"Symfony\Component\Routing\CompiledRoute":571:{a:8:{s:4:"vars";a:2:{i:0;s:6:"locale";i:1;s:3:"foo";}s:11:"path_prefix";s:7:"/prefix";s:10:"path_regex";s:31:"#^/prefix(?:/(?P<foo>\d+))?$#sD";s:11:"path_tokens";a:2:{i:0;a:4:{i:0;s:8:"variable";i:1;s:1:"/";i:2;s:3:"\d+";i:3;s:3:"foo";}i:1;a:2:{i:0;s:4:"text";i:1;s:7:"/prefix";}}s:9:"path_vars";a:1:{i:0;s:3:"foo";}s:10:"host_regex";s:40:"#^(?P<locale>[^\.]++)\.example\.net$#sDi";s:11:"host_tokens";a:2:{i:0;a:2:{i:0;s:4:"text";i:1;s:12:".example.net";}i:1;a:4:{i:0;s:8:"variable";i:1;s:0:"";i:2;s:7:"[^\.]++";i:3;s:6:"locale";}}s:9:"host_vars";a:1:{i:0;s:6:"locale";}}}}}';
        $unserialized = unserialize($serialized);

        $route = new Route('/prefix/{foo}', ['foo' => 'default'], ['foo' => '\d+']);
        $route->setHost('{locale}.example.net');
        $route->compile();

        $this->assertEquals($route, $unserialized);
        $this->assertNotSame($route, $unserialized);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 