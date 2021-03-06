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
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\ConsoleEvents;
use Symfony\Component\Console\Event\ConsoleEvent;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\EventListener\DebugHandlersListener;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DebugHandlersListenerTest extends TestCase
{
    public function testConfigure()
    {
        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $userHandler = function () {};
        $listener = new DebugHandlersListener($userHandler, $logger);
        $xHandler = new ExceptionHandler();
        $eHandler = new ErrorHandler();
        $eHandler->setExceptionHandler([$xHandler, 'handle']);

        $exception = null;
        set_error_handler([$eHandler, 'handleError']);
        set_exception_handler([$eHandler, 'handleException']);
        try {
            $listener->configure();
        } catch (\Exception $exception) {
        }
        restore_exception_handler();
        restore_error_handler();

        if (null !== $exception) {
            throw $exception;
        }

        $this->assertSame($userHandler, $xHandler->setHandler('var_dump'));

        $loggers = $eHandler->setLoggers([]);

        $this->assertArrayHasKey(E_DEPRECATED, $loggers);
        $this->assertSame([$logger, LogLevel::INFO], $loggers[E_DEPRECATED]);
    }

    public function testConfigureForHttpKernelW