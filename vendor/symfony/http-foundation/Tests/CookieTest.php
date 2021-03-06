<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

abstract class ResponseTestCase extends TestCase
{
    public function testNoCacheControlHeaderOnAttachmentUsingHTTPSAndMSIE()
    {
        // Check for HTTPS and IE 8
        $request = new Request();
        $request->server->set('HTTPS', true);
        $request->server->set('HTTP_USER_AGENT', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)');

        $response = $this->provideResponse();
        $response->headers->set('Content-Disposition', 'attachment; filename="fname.ext"');
        $response->prepare($request);

        $this->assertFalse($response->headers->has('Cache-Control'));

        // Check for IE 10 and HTTPS
        $request->server->set('HTTP_USER_AGENT', 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)');

        $response = $this->provideResponse();
        $response->headers->set('Content-Disposition', 'attachment; filename="fname.ext"');
        $response->prepare($request);

        $this->assertTrue($response->headers->has('Cache-Control'));

        // Check for IE 9 and HTTPS
        $request->server->set('HTTP_USER_AGENT', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 7.1; Trident/5.0)');

        $response = $this->provideResponse();
        $response->headers->set('Content-Disposition', 'attachment; filename="fname.ext"');
        $response->prepare($request);

        $this->assertTrue($response->headers->has('Cache-Control'));

        // Check for IE 9 and HTTP
        $request->server->set('HTTPS', false);

        $response = $this->provideResponse();
        $response->headers->set('Content-Disposition', 'attachment; filename="fname.ext"');
        $response->prepare($request);

        $this->assertTrue($response->headers->has('Cache-Control'));

        // Check for IE 8 and HTTP
        $request->server->set('HTTP_USER_AGENT', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)');

        $response = $this->provideResponse();
        $response->headers->set('Content-Disposition', 'attachment; filename="fname.ext"');
        $response->prepare($request);

        $this->assertTrue($response->headers->has('Cache-Control'));

        // Check for non-IE and HTTPS
        $request->server->set('HTTPS', true);
        $request->server->set('HTTP_USER_AGENT', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.60 Safari/537.17');

        $response = $this->provideResponse();
        $response->headers->set('Content-Disposition', 'attachment; filename="fname.ext"');
        $response->prepare($request);

        $this->assertTrue($response->headers->has('Cache-Control'));

        // Check for non-IE and HTTP
        $request->server->set('HTTPS', false);

        $response = $this->provideResponse();
        $response->headers->set('Content-Disposition', 'attachment; filename="fname.ext"');
        $response->prepare($request);

        $this->assertTrue($response->headers->has('Cache-Control'));
    }

    abstract protected function provideResponse();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ServerBag;

/**
 * ServerBagTest.
 *
 * @author Bulat Shakirzyanov <mallluhuct@gmail.com>
 */
class ServerBagTest extends TestCase
{
    public function testShouldExtractHeadersFromServerArray()
    {
        $server = [
            'SOME_SERVER_VARIABLE' => 'value',
            'SOME_SERVER_VARIABLE2' => 'value',
            'ROOT' => 'value',
            'HTTP_CONTENT_TYPE' => 'text/html',
            'HTTP_CONTENT_LENGTH' => '0',
            'HTTP_ETAG' => 'asdf',
            'PHP_AUTH_USER' => 'foo',
            'PHP_AUTH_PW' => 'bar',
        ];

        $bag = new ServerBag($server);

        $this->assertEquals([
            'CONTENT_TYPE' => 'text/html',
            'CONTENT_LENGTH' => '0',
            'ETAG' => 'asdf',
            'AUTHORIZATION' => 'Basic '.base64_encode('foo:bar'),
            'PHP_AUTH_USER' => 'foo',
            'PHP_AUTH_PW' => 'bar',
        ], $bag->getHeaders());
    }

    public function testHttpPasswordIsOptional()
    {
        $bag = new ServerBag(['PHP_AUTH_USER' => 'foo']);

        $this->assertEquals([
            'AUTHORIZATION' => 'Basic '.base64_encode('foo:'),
            'PHP_AUTH_USER' => 'foo',
            'PHP_AUTH_PW' => '',
        ], $bag->getHeaders());
    }

    public function testHttpBasicAuthWithPhpCgi()
    {
        $bag = new ServerBag(['HTTP_AUTHORIZATION' => 'Basic '.base64_encode('foo:bar')]);

        $this->assertEquals([
            'AUTHORIZATION' => 'Basic '.base64_encode('foo:bar'),
            'PHP_AUTH_USER' => 'foo',
            'PHP_AUTH_PW' => 'bar',
        ], $bag->getHeaders());
    }

    public function testHttpBasicAuthWithPhpCgiBogus()
    {
        $bag = new ServerBag(['HTTP_AUTHORIZATION' => 'Basic_'.base64_encode('foo:bar')]);

        // Username and passwords should not be set as the header is bogus
        $headers = $bag->getHeaders();
        $this->assertArrayNotHasKey('PHP_AUTH_USER', $headers);
        $this->assertArrayNotHasKey('PHP_AUTH_PW', $headers);
    }

    public function testHttpBasicAuthWithPhpCgiRedirect()
    {
        $bag = new ServerBag(['REDIRECT_HTTP_AUTHORIZATION' => 'Basic '.base64_encode('username:pass:word')]);

        $this->assertEquals([
            'AUTHORIZATION' => 'Basic '.base64_encode('username:pass:word'),
            'PHP_AUTH_USER' => 'username',
            'PHP_AUTH_PW' => 'pass:word',
        ], $bag->getHeaders());
    }

    public function testHttpBasicAuthWithPhpCgiEmptyPassword()
    {
        $bag = new ServerBag(['HTTP_AUTHORIZATION' => 'Basic '.base64_encode('foo:')]);

        $this->assertEquals([
            'AUTHORIZATION' => 'Basic '.base64_encode('foo:'),
            'PHP_AUTH_USER' => 'foo',
            'PHP_AUTH_PW' => '',
        ], $bag->getHeaders());
    }

    public function testHttpDigestAuthWithPhpCgi()
    {
        $digest = 'Digest username="foo", realm="acme", nonce="'.md5('secret').'", uri="/protected, qop="auth"';
        $bag = new ServerBag(['HTTP_AUTHORIZATION' => $digest]);

        $this->assertEquals([
            'AUTHORIZATION' => $digest,
            'PHP_AUTH_DIGEST' => $digest,
        ], $bag->getHeaders());
    }

    public function testHttpDigestAuthWithPhpCgiBogus()
    {
        $digest = 'Digest_username="foo", realm="acme", nonce="'.md5('secret').'", uri="/protected, qop="auth"';
        $bag = new ServerBag(['HTTP_AUTHORIZATION' => $digest]);

        // Username and passwords should not be set as the header is bogus
        $headers = $bag->getHeaders();
        $this->assertArrayNotHasKey('PHP_AUTH_USER', $headers);
        $this->assertArrayNotHasKey('PHP_AUTH_PW', $headers);
    }

    public function testHttpDigestAuthWithPhpCgiRedirect()
    {
        $digest = 'Digest username="foo", realm="acme", nonce="'.md5('secret').'", uri="/protected, qop="auth"';
        $bag = new ServerBag(['REDIRECT_HTTP_AUTHORIZATION' => $digest]);

        $this->assertEquals([
            'AUTHORIZATION' => $digest,
            'PHP_AUTH_DIGEST' => $digest,
        ], $bag->getHeaders());
    }

    public function testOAuthBearerAuth()
    {
        $headerContent = 'Bearer L-yLEOr9zhmUYRkzN1jwwxwQ-PBNiKDc8dgfB4hTfvo';
        $bag = new ServerBag(['HTTP_AUTHORIZATION' => $headerContent]);

        $this->assertEquals([
            'AUTHORIZATION' => $headerContent,
        ], $bag->getHeaders());
    }

    public function testOAuthBearerAuthWithRedirect()
    {
        $headerContent = 'Bearer L-yLEOr9zhmUYRkzN1jwwxwQ-PBNiKDc8dgfB4hTfvo';
        $bag = new ServerBag(['REDIRECT