<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\DataCollector;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\TimeDataCollector;
use Symfony\Component\Stopwatch\Stopwatch;

/**
 * @group time-sensitive
 */
class TimeDataCollectorTest extends TestCase
{
    public function testCollect()
    {
        $c = new TimeDataCollector();

        $request = new Request();
        $request->server->set('REQUEST_TIME', 1);

        $c->collect($request, new Response());

        $this->assertEquals(0, $c->getStartTime());

        $request->server->set('REQUEST_TIME_FLOAT', 2);

        $c->collect($request, new Response());

        $this->assertEquals(2000, $c->getStartTime());

        $request = new Request();
        $c->collect($request, new Response());
        $this->assertEquals(0, $c->getStartTime());

        $kernel = $this->getMockBuilder('Symfony\Component\HttpKernel\KernelInterface')->getMock();
        $kernel->expects($this->once())->method('getStartTime')->will($this->returnValue(123456));

        $c = new TimeDataCollector($kernel);
        $request = new Request();
        $request->server->set('REQUEST_TIME', 1);

        $c->collect($request, new Response());
        $this->assertEquals(123456000, $c->getStartTime());
        $this->assertSame(\class_exists(Stopwatch::class, false), $c->isStopwatchInstalled());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\Debug;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Debug\FileLinkFormatter;

class FileLinkFormatterTest extends TestCase
{
    public function testWhenNoFileLinkFormatAndNoRequest()
    {
        $sut = new FileLinkFormatter();

        $this->assertFalse($sut->format('/kernel/root/src/my/very/best/file.php', 3));
    }

    public function testWhenFileLinkFormatAndNoRequest()
    {
        $file = __DIR__.\DIRECTORY_SEPARATOR.'file.php';

        $sut = new FileLinkFormatter('debug://open?url=file://%f&line=%l', new RequestStack());

        $this->assertSame("debug://open?url=file://$file&line=3", $sut->format($file, 3));
    }

    public function testWhenFileLinkFormatAndRequest()
    {
        $file = __DIR__.\DIRECTORY_SEPARATOR.'file.php';
        $requestStack = new RequestStack();
        $request = new Request();
        $requestStack->push($request);

        $sut = new FileLinkFormatter('debug://open?url=file://%f&line=%l', $requestStack, __DIR__, '/_profiler/open?file=%f&line=%l#line%l');

        $this->assertSame("debug://open?url=file://$file&line=3", $sut->format($file, 3));
    }

    public function testWhenNoFileLinkFormatAndRequest()
    {
        $file = __DIR__.\DIRECTORY_SEPARATOR.'file.php';
        $requestStack = new RequestStack();
        $request = new Request();
        $requestStack->push($request);

        $request->server->set('SERVER_NAME', 'www.example.org');
        $request->server->set('SERVER_PORT', 80);
        $request->server->set('SCRIPT_NAME', '/index.php');
        $request->server->set('SCRIPT_FILENAME', '/public/index.php');
        $request->server->set('REQUEST_URI', '/index.php/example');

        $sut = new FileLinkFormatter(null, $requestStack, __DIR__, '/_profiler/open?file=%f&line=%l#line%l');

        $this->assertSame('http://www.example.org/_profiler/open?file=file.php&line=3#line3', $sut->format($file, 3));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     