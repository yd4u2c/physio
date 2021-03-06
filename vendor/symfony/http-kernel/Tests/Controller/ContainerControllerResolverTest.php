INDX( 	 g��             (   X	  �       . e                   q0     � �     p0     �x>qk� �V0e ������<��x>qk�       �              ! A d d R e q u e s t F o r m a t s L i s t e n e r T e s t . p h p     r0     � |     p0     Hqk� �V0e �/���<�Hqk�        �               D e b u g H a n d l e r s L i s t e n e r T e s t . p h p     s0     � �     p0     ��Lqk�u�� %�u�� %���Lqk�       �              & D i s a l l o w R o b o t s I n d e x i n g L i s t e n e r T e s t  p h p   t0     � j     p0     s�Qqk� �V0e �tE���<�s�Qqk�       �               D u m p L i s t e n e r T e s t . p h p       u0     � t     p0     :PVqk� �V0e �tE���<�:PVqk�        }               E x c e p t i o n L i s t e n e r T e s t . p h p     v0     � r     p0     ��dqk� �V0e ������<���dqk�        &               F r a g m e n t L i s t e n e r T e s t . p h p       w0     � x     p0     T'nqk�?M� %�?M� %�T'nqk�        �               L o c a l e A w a r  L i s t e n e r T e s t . p h p x0     � n     p0     <Nuqk� �V0e �	���<�<Nuqk�       p               L o c a l e L i s t e n e r T e s t . p h p   y0     � r     p0     �u|qk� �V0e ��l���<��u|qk�       V
               P r o f i l e r L i s t e n e r T e s t . p h p       z0     � r     p0     b��qk� �V0e ��l���<�b��qk�       r               R e s p o n s e L i s t e n e r T e s t . p h p       {0     � n     p0     �%�qk� �V0e �����<��%�qk� 0      %              R o u t e r L i s t e n e r T e s t . p h p   |0     � x     p0     �M�qk� �V0e �71���<��M�qk�       \               S a v e S e s s i o n L i s t e n e r T e s t . p h p }0     � p     p0     u֝qk� �V0e �71���<�u֝qk� 0      "               S e s s i o n L i s t e n e r T e s t . p h p ~0     � t     p0     $©qk� �V0e ������<�$©qk�       K               S u r r o g a t e L i s t e n e r T e s t . p h p     0     � x     p0     xi�qk� �V0e ������<�xi�qk�       �               T e s t S e s s i o n L i s t e n e r T e s t . p h p �0     � v     p0     ��qk� �V0e �CX���<���qk�        *               T r a n s l a t o r L i s t e n e r T e s t . p h p   �0     � �     p0     �U�qk� �V0e �CX���<��U�qk�       �               V a l i d a t e R e q u e s t L i s t e n e r T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\EventListener\FragmentListener;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\UriSigner;

class FragmentListenerTest extends TestCase
{
    public function testOnlyTriggeredOnFragmentRoute()
    {
        $request = Request::create('http://example.com/foo?_path=foo%3Dbar%26_controller%3Dfoo');

        $listener = new FragmentListener(new UriSigner('foo'));
        $event = $this->createGetResponseEvent($request);

        $expected = $request->attributes->all();

        $listener->onKernelRequest($event);

        $this->assertEquals($expected, $request->attributes->all());
        $this->assertTrue($request->query->has('_path'));
    }

    public function testOnlyTriggeredIfControllerWasNotDefinedYet()
    {
        $request = Request::create('http://example.com/_fragment?_path=foo%3Dbar%26_controller%3Dfoo');
        $request->attributes->set('_controller', 'bar');

        $listener = new FragmentListener(new UriSigner('foo'));
        $event = $this->createGetResponseEvent($request, HttpKernelInterface::SUB_REQUEST);

        $expected = $request->attributes->all();

        $listener->onKernelRequest($event);

        $this->assertEquals($expected, $request->attributes->all());
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testAccessDeniedWithNonSafeMethods()
    {
        $request = Request::create('http://example.com/_fragment', 'POST');

        $listener = new FragmentListener(new UriSigner('foo'));
        $event = $this->createGetResponseEvent($request);

        $listener->onKernelRequest($event);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException
     */
    public function testAccessDeniedWithWrongSignature()
    {
        $request = Request::create('http://example.com/_fragment', 'GET', [], [], [], ['REMOTE_ADDR' => '10.0.0.1']);

        $listener = new FragmentListener(new UriSigner('foo'));
        $event = $this->createGetResponseEvent($request);

        $listener->onKernelRequest($event);
    }

    public function testWithSignature()
    {
        $signer = new UriSigner('foo');
        $request = Request::create($signer->sign('http://example.com/_fragment?_path=foo%3Dbar%26_controller%3Dfoo'), 'GET', [], [], [], ['REMOTE_ADDR' => '10.0.0.1']);

        $listener = new FragmentListener($signer);
        $event = $this->createGetResponseEvent($request);

        $listener->onKernelRequest($event);

        $this->assertEquals(['foo' => 'bar', '_controller' => 'foo'], $request->attributes->get('_route_params'));
        $this->assertFalse($request->query->has('_path'));
    }

    public function testRemovesPathWithControllerDefined()
    {
        $request = Request::create('http://example.com/_fragment?_path=foo%3Dbar%26_controller%3Dfoo');

        $listener = new FragmentListener(new UriSigner('foo'));
        $event = $this->createGetResponseEvent($request, HttpKernelInterface::SUB_REQUEST);

        $listener->onKernelRequest($event);

        $this->assertFalse($request->query->has('_path'));
    }

    public function testRemovesPathWithControllerNotDefined()
    {
        $signer = new UriSigner('foo');
        $request = Request::create($signer->sign('http://example.com/_fragment?_path=foo%3Dbar'), 'GET', [], [], [], ['REMOTE_ADDR' => '10.0.0.1']);

        $listener = new FragmentListener($signer);
        $event = $this->createGetResponseEvent($request);

        $listener->onKernelRequest($event);

        $this->assertFalse($request->query->has('_path'));
    }

    private function createGetResponseEvent(Request $request, $requestType = HttpKernelInterface::MASTER_REQUEST)
    {
        return new GetResponseEvent($this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock()