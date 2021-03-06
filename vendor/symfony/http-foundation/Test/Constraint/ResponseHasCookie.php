ic function testTrustedPort()
    {
        Request::setTrustedProxies(['1.1.1.1'], -1);

        $request = Request::create('/');
        $request->server->set('REMOTE_ADDR', '1.1.1.1');
        $request->headers->set('Forwarded', 'host=localhost:8080');
        $request->headers->set('X-Forwarded-Port', 8080);

        $this->assertSame(8080, $request->getPort());

        $request = Request::create('/');
        $request->server->set('REMOTE_ADDR', '1.1.1.1');
        $request->headers->set('Forwarded', 'host=localhost');
        $request->headers->set('X-Forwarded-Port', 80);

        $this->assertSame(80, $request->getPort());

        $request = Request::create('/');
        $request->server->set('REMOTE_ADDR', '1.1.1.1');
        $request->headers->set('Forwarded', 'host="[::1]"');
        $request->headers->set('X-Forwarded-Proto', 'https');
        $request->headers->set('X-Forwarded-Port', 443);

        $this->assertSame(443, $request->getPort());
    }
}

class RequestContentProxy extends Request
{
    public function getContent($asResource = false)
    {
        return http_build_query(['_method' => 'PUT', 'content' => 'mycontent'], '', '&');
    }
}

class NewRequest extends Request
{
    public function getFoo()
    {
        return 'foo';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      