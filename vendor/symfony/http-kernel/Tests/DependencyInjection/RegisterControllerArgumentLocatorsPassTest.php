adersPossiblyResultingIn304AreNotAssignedToSubrequest()
    {
        $expectedSubRequest = Request::create('/');
        $expectedSubRequest->headers->set('x-forwarded-for', ['127.0.0.1']);
        $expectedSubRequest->headers->set('forwarded', ['for="127.0.0.1";host="localhost";proto=http']);
        $expectedSubRequest->server->set('HTTP_X_FORWARDED_FOR', '127.0.0.1');
        $expectedSubRequest->server->set('HTTP_FORWARDED', 'for="127.0.0.1";host="localhost";proto=http');

        $strategy = new InlineFragmentRenderer($this->getKernelExpectingRequest($expectedSubRequest));
        $request = Request::create('/', 'GET', [], [], [], ['HTTP_IF_MODIFIED_SINCE' => 'Fri, 01 Jan 2016 00:00:00 GMT', 'HTTP_IF_NONE_MATCH' => '*']);
        $strategy->render('/', $request);
    }

    public function testFirstTrustedProxyIsSetAsRemote()
    {
        Request::setTrustedProxies(['1.1.1.1'], -1);

        $expectedSubRequest = Request::create('/');
        $expectedSubRequest->headers->set('Surrogate-Capability', 'abc="ESI/1.0"');
        $expectedSubRequest->server->set('REMOTE_ADDR', '127.0.0.1');
        $expectedSubRequest->headers->set('x-forwarded-for', ['127.0.0.1']);
        $expectedSubRequest->headers->set('forwarded', ['for="127.0.0.1";host="localhost";proto=http']);
        $expectedSubRequest->server->set('HTTP_X_FORWARDED_FOR', '127.0.0.1');
        $expectedSubRequest->server->set('HTTP_FORWARDED', 'for="127.0.0.1";host="localhost";proto=http');

        $strategy = new InlineFragmentRenderer($this->getKernelExpectingRequest($expectedSubRequest));

        $request = Request::create('/');
        $request->headers->set('Surrogate-Capability', 'abc="ESI/1.0"');
        $strategy->render('/', $request);

        Request::setTrustedProxies([], -1);
    }

    public function testIpAddressOfRangedTrustedProxyIsSetAsRemote()
    {
        $expectedSubRequest = Request::create('/');
        $expectedSubRequest->headers->set('Surrogate-Capability', 'abc="ESI/1.0"');
        $expectedSubRequest->server->set('REMOTE_ADDR', '127.0.0.1');
        $expectedSubRequest->headers->set('x-forwarded-for', ['127.0.0.1']);
        $expectedSubRequest->headers->set('forwarded', ['for="127.0.0.1";host="localhost";proto=http']);
        $expectedSubRequest->server->set('HTTP_X_FORWARDED_FOR', '127.0.0.1');
        $expectedSubRequest->server->set('HTTP_FORWARDED', 'for="127.0.0.1";host="localhost";proto=http');

        Request::setTrustedProxies(['1.1.1.1/24'], -1);

        $strategy = new InlineFragmentRenderer($this->getKernelExpectingRequest($expectedSubRequest));

        $request = Request::create('/');
        $request->headers->set('Surrogate-Capability', 'abc="ESI/1.0"');
        $strategy->render('/', $request);

        Request::setTrustedProxies([], -1);
    }

    /**
     * Creates a Kernel expecting a request equals to $request
     * Allows delta in comparison in case REQUEST_TIME changed by 1 second.
     */
    private function getKernelExpectingRequest(Request $request, $strict = false)
    {
        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
        $kernel
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($request, 1))
            ->willReturn(new Response('foo'));

        return $kernel;
    }
}

class Bar
{
    public $bar = 'bar';

    public function getBar()
    {
        return $this->bar;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          INDX( 	 �S�             (   �  �       �                    �0     � x     �0     X�qk� �V0e ���=��<�X�qk�        "               E s i F r a g m e n t R e n d e r e r T e s t . p h p �0     � p     �0     �+�qk� �V0e ��*@��<��+�qk�       �
               F r a g m e n t H a n d l e r T e s t . p h p �0     � �     �0     ��qk� �V0e �)�B��<���qk�        �                H I n c l u d e F r a g m e n t R e n d e r e r T e s t . p h p       �0     � ~     �0     �qk  �V0e �)�B��<��qk� 0      �-               I n l i n e F r a g m e n t R e n d e r e r T e s t . p h p   �0     � �     �0     $*�qk� �V0e �}�D��<�$*�qk�       �                R o u t a b l e F r a g m e n t R e n d e r e r T e s t . p h p       �0     � x     �0     ��qk� �V0e ��RG��<���qk�       �               S s i F r a g m e n t R e n d e r e r T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\Fragment;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerReference;

class RoutableFragmentRendererTest extends TestCase
{
    /**
     * @dataProvider getGenerateFragmentUriData
     */
    public function testGenerateFragmentUri($uri, $controller)
    {
        $this->assertEquals($uri, $this->callGenerateFragmentUriMethod($controller, Request::create('/')));
    }

    /**
     * @dataProvider getGenerateFragmentUriData
     */
    public function testGenerateAbsoluteFragmentUri($uri, $controller)
    {
        $this->assertEquals('http://localhost'.$uri, $this->callGenerateFragmentUriMethod($controller, Request::create('/'), true));
    }

    public function getGenerateFragmentUriData()
    {
        return [
            ['/_fragment?_path=_format%3Dhtml%26_locale%3Den%26_controller%3Dcontroller', new ControllerReference('controller', [], [])],
            ['/_fragment?_path=_format%3Dxml%26_locale%3Den%26_controller%3Dcontroller', new ControllerReference('controller', ['_format' => 'xml'], [])],
            ['/_fragment?_path=foo%3Dfoo%26_format%3Djson%26_locale%3Den%26_controller%3Dcontroller', new ControllerReference('controller', ['foo' => 'foo', '_format' => 'json'], [])],
            ['/_fragment?bar=bar&_path=foo%3Dfoo%26_format%3Dhtml%26_locale%3Den%26_controller%3Dcontroller', new ControllerReference('controller', ['foo' => 'foo'], ['bar' => 'bar'])],
            ['/_fragment?foo=foo&_path=_format%3Dhtml%26_locale%3Den%26_controller%3Dcontroller', new ControllerReference('controller', [], ['foo' => 'foo'])],
            ['/_fragment?_path=foo%255B0%255D%3Dfoo%26foo%255B1%255D%3Dbar%26_format%3Dhtml%26_locale%3Den%26_controller%3Dcontroller', new ControllerReference('controller', ['foo' => ['foo', 'bar']], [])],
        ];
    }

    public function testGenerateFragmentUriWithARequest()
    {
        $request = Request::create('/');
        $request->attributes->set('_format', 'json');
        $request->setLocale('fr');
        $controller = new ControllerReference('controller', [], []);

        $this->assertEquals('/_fragment?_path=_format%3Djson%26_locale%3Dfr%26_controller%3Dcontroller', $this->callGenerateFragmentUriMethod($controller, $request));
    }

    /**
     * @expectedException \LogicException
     * @dataProvider      getGenerateFragmentUriDataWithNonScalar
     */
    public function testGenerateFragmentUriWithNonScalar($controller)
    {
        $this->callGenerateFragmentUriMethod($controller, Request::create('/'));
    }

    public function getGenerateFragmentUriDataWithNonScalar()
    {
        return [
            [new ControllerReference('controller', ['foo' => new Foo(), 'bar' => 'bar'], [])],
            [new ControllerReference('controller', ['foo' => ['foo' => 'foo'], 'bar' => ['bar' => new Foo()]], [])],
        ];
    }

    private function callGenerateFragmentUriMethod(ControllerReference $reference, Request $request, $absolute = false)
    {
        $renderer = $this->getMockForAbstractClass('Symfony\Component\HttpKernel\Fragment\RoutableFragmentRenderer');
        $r = new \ReflectionObject($renderer);
        $m = $r->getMethod('generateFragmentUri');
        $m->setAccessible(true);

        return $m->invoke($renderer, $reference, $request, $absolute);
    }
}

class Foo
{
    public $foo;

    public function getFoo()
    {
        return $this->foo;
    }
}
                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\Fragment;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ControllerReference;
use Symfony\Component\HttpKernel\Fragment\SsiFragmentRenderer;
use Symfony\Component\HttpKernel\HttpCache\Ssi;
use Symfony\Component\HttpKernel\UriSigner;

class SsiFragmentRendererTest extends TestCase
{
    public function testRenderFallbackToInlineStrategyIfSsiNotSupported()
    {
        $strategy = new SsiFragmentRenderer(new Ssi(), $this->getInlineStrategy(true));
        $strategy->render('/', Request::create('/'));
    }

    public function testRender()
    {
        $strategy = new SsiFragmentRenderer(new Ssi(), $this->getInlineStrategy());

        $request = Request::create('/');
        $request->setLocale('fr');
        $request->headers->set('Surrogate-Capability', 'SSI/1.0');

        $this->assertEquals('<!--#include virtual="/" -->', $strategy->render('/', $request)->getContent());
        $this->assertEquals('<!--#include virtual="/" -->', $strategy->render('/', $request, ['comment' => 'This is a comment'])->getContent(), 'Strategy options should not impact the ssi include tag');
    }

    public function testRenderControllerReference()
    {
        $signer = new UriSigner('foo');
        $strategy = new SsiFragmentRenderer(new Ssi(), $this->getInlineStrategy(), $signer);

        $request = Request::create('/');
        $request->setLocale('fr');
        $request->headers->set('Surrogate-Capability', 'SSI/1.0');

        $reference = new ControllerReference('main_controller', [], []);
        $altReference = new ControllerReference('alt_controller', [], []);

        $this->assertEquals(
            '<!--#include virtual="/_fragment?_hash=Jz1P8NErmhKTeI6onI1EdAXTB85359MY3RIk5mSJ60w%3D&_path=_format%3Dhtml%26_locale%3Dfr%26_controller%3Dmain_controller" -->',
            $strategy->render($reference, $request, ['alt' => $altReference])->getContent()
        );
    }

    /**
     * @expectedException \LogicException
     */
    public function testRenderControllerReferenceWithoutSignerThrowsException()
    {
        $strategy = new SsiFragmentRenderer(new Ssi(), $this->getInlineStrategy());

        $request = Request::create('/');
        $request->setLocale('fr');
        $request->headers->set('Surrogate-Capability', 'SSI/1.0');

        $strategy->render(new ControllerReference('main_controller'), $request);
    }

    /**
     * @expectedException \LogicException
     */
    public function testRenderAltControllerReferenceWithoutSignerThrowsException()
    {
        $strategy = new SsiFragmentRenderer(new Ssi(), $this->getInlineStrategy());

        $request = Request::create('/');
        $request->setLocale('fr');
        $request->headers->set('Surrogate-Capability', 'SSI/1.0');

        $strategy->render('/', $request, ['alt' => new ControllerReference('alt_controller')]);
    }

    private function getInlineStrategy($called = false)
    {
        $inline = $this->getMockBuilder('Symfony\Component\HttpKernel\Fragment\InlineFragmentRenderer')->disableOriginalConstructor()->getMock();

        if ($called) {
            $inline->expects($this->once())->method('render');
        }

        return $inline;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

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
use Symfony\Component\HttpKernel\HttpCache\Esi;

class EsiTest extends TestCase
{
    public function testHasSurrogateEsiCapability()
    {
        $esi = new Esi();

        $request = Request::create('/');
        $request->headers->set('Surrogate-Capability', 'abc="ESI/1.0"');
        $this->assertTrue($esi->hasSurrogateCapability($request));

        $request = Request::create('/');
        $request->headers->set('Surrogate-Capability', 'foobar');
        $this->assertFalse($esi->hasSurrogateCapability($request));

        $re