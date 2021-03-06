<?php

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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;
use Symfony\Component\HttpKernel\EventListener\ProfilerListener;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfilerListenerTest extends TestCase
{
    /**
     * Test a master and sub request with an exception and `onlyException` profiler option enabled.
     */
    public function testKernelTerminate()
    {
        $profile = new Profile('token');

        $profiler = $this->getMockBuilder('Symfony\Component\HttpKernel\Profiler\Profiler')
            ->disableOriginalConstructor()
            ->getMock();

        $profiler->expects($this->once())
            ->method('collect')
            ->will($this->returnValue($profile));

        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();

        $masterRequest = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $subRequest = $this->getMockBuilder('Symfony\Component\HttpFoundation\Request')
            ->disableOriginalConstructor()
            ->getMock();

        $response = $this->getMockBuilder('Symfony\Component\HttpFoundation\Response')
            ->disableOriginalConstructor()
            ->getMock();

        $requestStack = new RequestStack();
        $requestStack->push($masterRequest);

        $onlyException = true;
        $listener = new ProfilerListener($profiler, $requestStack, null, $onlyException);

        // master request
        $listener->onKernelResponse(new FilterResponseEvent($kernel, $masterRequest, Kernel::MASTER_REQUEST, $response));

        // sub request
        $listener->onKernelException(new GetResponseForExceptionEvent($kernel, $subRequest, Kernel::SUB_REQUEST, new HttpException(404)));
        $listener->onKernelResponse(new FilterResponseEvent($kernel, $subRequest, Kernel::SUB_REQUEST, $response));

        $listener->onKernelTerminate(new PostResponseEvent($kernel, $masterRequest, $response));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

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
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\EventListener\ResponseListener;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseListenerTest extends TestCase
{
    private $dispatcher;

    private $kernel;

    protected function setUp()
    {
        $this->dispatcher = new EventDispatcher();
        $listener = new ResponseListener('UTF-8');
        $this->dispatcher->addListener(KernelEvents::RESPONSE, [$listener, 'onKernelResponse']);

        $this->kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\HttpKernelInterface')->getMock();
    }

    protected function tearDown()
    {
        $this->dispatcher = null;
        $this->kernel = null;
    }

    public function testFilterDoesNothingForSubRequests()
    {
        $response = new Response('foo');

        $event = new FilterResponseEvent($this->kernel, new Request(), HttpKe