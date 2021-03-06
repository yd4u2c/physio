<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Test\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestFailure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint\ResponseStatusCodeSame;

class ResponseStatusCodeSameTest extends TestCase
{
    public function testConstraint(): void
    {
        $constraint = new ResponseStatusCodeSame(200);
        $this->assertTrue($constraint->evaluate(new Response(), '', true));
        $this->assertFalse($constraint->evaluate(new Response('', 404), '', true));
        $constraint = new ResponseStatusCodeSame(404);
        $this->assertTrue($constraint->evaluate(new Response('', 404), '', true));

        $constraint = new ResponseStatusCodeSame(200);
        try {
            $constraint->evaluate(new Response('', 404));
        } catch (ExpectationFailedException $e) {
            $this->assertContains("Failed asserting that the Response status code is 200.\nHTTP/1.0 404 Not Found", TestFailure::exceptionToString($e));

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             CHANGELOG
=========

4.2.0
-----

 * deprecated `KernelInterface::getRootDir()` and the `kernel.root_dir` parameter
 * deprecated `KernelInterface::getName()` and the `kernel.name` parameter
 * deprecated the first and second constructor argument of `ConfigDataCollector` 
 * deprecated `ConfigDataCollector::getApplicationName()` 
 * deprecated `ConfigDataCollector::getApplicationVersion()`

4.1.0
-----

 * added orphaned events support to `EventDataCollector`
 * `ExceptionListener` now logs exceptions at priority `0` (previously logged at `-128`)
 * Added support for using `service::method` to reference controllers, making it consistent with other cases. It is recommended over the `service:action` syntax with a single colon, which will be deprecated in the future.
 * Added the ability to profile individual argument value resolvers via the
   `Symfony\Component\HttpKernel\Controller\ArgumentResolver\TraceableValueResolver`

4.0.0
-----

 * removed the `DataCollector::varToString()` method, use `DataCollector::cloneVar()`
   instead
 * using the `DataCollector::cloneVar()` method requires the VarDumper component
 * removed the `ValueExporter` class
 * removed `ControllerResolverInterface::getArguments()`
 * removed `TraceableControllerResolver::getArguments()`
 * removed `ControllerResolver::getArguments()` and the ability to resolve arguments
 * removed the `argument_resolver` service dependency from the `debug.controller_resolver`
 * removed `LazyLoadingFragmentHandler::addRendererService()`
 * removed `Psr6CacheClearer::addPool()`
 * removed `Extension::addClassesToCompile()` and `Extension::getClassesToCompile()`
 * removed `Kernel::loadClassCache()`, `Kernel::doLoadClassCache()`, `Kernel::setClassCache()`,
   and `Kernel::getEnvParameters()`
 * support for the `X-Status-Code` when handling exceptions in the `HttpKernel`
   has been dropped, use the `HttpKernel::allowCustomResponseCode()` method
   instead
 * removed convention-based commands registration
 * removed the `ChainCacheClearer::add()` method
 * removed the `CacheaWarmerAggregate::add()` and `setWarmers()` methods
 * made `CacheWarmerAggregate` and `ChainCacheClearer` classes final

3.4.0
-----

 * added a minimalist PSR-3 `Logger` class that writes in `stderr`
 * made kernels implementing `CompilerPassInterface` able to process the container
 * deprecated bundle inheritance
 * added `RebootableInterface` and implemented it in `Kernel`
 * deprecated commands auto registration
 * deprecated `EnvParametersResource`
 * added `Symfony\Component\HttpKernel\Client::catchExceptions()`
 * deprecated the `ChainCacheClearer::add()` method
 * deprecated the `CacheaWarmerAggregate::add()` and `setWarmers()` methods
 * made `CacheWarmerAggregate` and `ChainCacheClearer` classes final
 * added the possibility to reset the profiler to its initial state
 * deprecated data collectors without a `reset()` method
 * deprecated implementing `DebugLoggerInterface` without a `clear()` method

3.3.0
-----

 * added `kernel.project_dir` and `Kernel::getProjectDir()`
 * deprecated `kernel.root_dir` and `Kernel::getRootDir()`
 * deprecated `Kernel::getEnvParameters()`
 * deprecated the special `SYMFONY__` environment variables
 * added the possibility to change the query string parameter used by `UriSigner`
 * deprecated `LazyLoadingFragmentHandler::addRendererService()`
 * deprecated `Extension::addClassesToCompile()` and `Extension::getClassesToCompile()`
 * deprecated `Psr6CacheClearer::addPool()`

3.2.0
-----

 * deprecated `DataCollector::varToString()`, use `cloneVar()` instead
 * changed surrogate capability name in `AbstractSurrogate::addSurrogateCapability` to 'symfony'
 * Added `ControllerArgumentValueResolverPass`

3.1.0
-----
 * deprecated passing objects as URI attributes to the ESI and SSI renderers
 * deprecated `ControllerResolver::getArguments()`
 * added `Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface`
 * added `Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface` as argument to `HttpKernel`
 * added `Symfony\Component\HttpKernel\Controller\ArgumentResolver`
 * added `Symfony\Component\HttpKernel\DataCollector\RequestDataCollector::getMethod()`
 * added `Symfony\Component\HttpKernel\DataCollector\RequestDataCollector::getRedirect()`
 * added the `kernel.controller_arguments` event, triggered after controller arguments have been resolved

3.0.0
-----

 * removed `Symfony\Component\HttpKernel\Kernel::init()`
 * removed `Symfony\Component\HttpKernel\Kernel::isClassInActiveBundle()` and `Symfony\Component\HttpKernel\KernelInterface::isClassInActiveBundle()`
 * removed `Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher::setProfiler()`
 * removed `Symfony\Component\HttpKernel\EventListener\FragmentListener::getLocalIpAddresses()`
 * removed `Symfony\Component\HttpKernel\EventListener\LocaleListener::setRequest()`
 * removed `Symfony\Component\HttpKernel\EventListener\RouterListener::setRequest()`
 * removed `Symfony\Component\HttpKernel\EventListener\ProfilerListener::onKernelRequest()`
 * removed `Symfony\Component\HttpKernel\Fragment\FragmentHandler::setRequest()`
 * removed `Symfony\Component\HttpKernel\HttpCache\Esi::hasSurrogateEsiCapability()`
 * removed `Symfony\Component\HttpKernel\HttpCache\Esi::addSurrogateEsiCapability()`
 * removed `Symfony\Component\HttpKernel\HttpCache\Esi::needsEsiParsing()`
 * removed `Symfony\Component\HttpKernel\HttpCache\HttpCache::getEsi()`
 * removed `Symfony\Component\HttpKernel\DependencyInjection\ContainerAwareHttpKernel`
 * removed `Symfony\Component\HttpKernel\DependencyInjection\RegisterListenersPass`
 * removed `Symfony\Component\HttpKernel\EventListener\ErrorsLoggerListener`
 * removed `Symfony\Component\HttpKernel\EventListener\EsiListener`
 * removed `Symfony\Component\HttpKernel\HttpCache\EsiResponseCacheStrategy`
 * removed `Symfony\Component\HttpKernel\HttpCache\EsiResponseCacheStrategyInterface`
 * removed `Symfony\Component\HttpKernel\Log\LoggerInterface`
 * removed `Symfony\Component\HttpKernel\Log\NullLogger`
 * removed `Symfony\Component\HttpKernel\Profiler::import()`
 * removed `Symfony\