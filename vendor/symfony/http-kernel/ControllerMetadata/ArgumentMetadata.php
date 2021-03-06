>throwAt) {
                    $handler->throwAt($this->throwAt, true);
                }
            }
        }
        if (!$this->exceptionHandler) {
            if ($event instanceof KernelEvent) {
                if (method_exists($kernel = $event->getKernel(), 'terminateWithException')) {
                    $request = $event->getRequest();
                    $hasRun = &$this->hasTerminatedWithException;
                    $this->exceptionHandler = static function (\Exception $e) use ($kernel, $request, &$hasRun) {
                        if ($hasRun) {
                            throw $e;
                        }
                        $hasRun = true;
                        $kernel->terminateWithException($e, $request);
                    };
                }
            } elseif ($event instanceof ConsoleEvent && $app = $event->getCommand()->getApplication()) {
                $output = $event->getOutput();
                if ($output instanceof ConsoleOutputInterface) {
                    $output = $output->getErrorOutput();
                }
                $this->exceptionHandler = function ($e) use ($app, $output) {
                    $app->renderException($e, $output);
                };
            }
        }
        if ($this->exceptionHandler) {
            if ($handler instanceof ErrorHandler) {
                $h = $handler->setExceptionHandler('var_dump');
                if (\is_array($h) && $h[0] instanceof ExceptionHandler) {
                    $handler->setExceptionHandler($h);
                    $handler = $h[0];
                } else {
                    $handler->setExceptionHandler($this->exceptionHandler);
                }
            }
            if ($handler instanceof ExceptionHandler) {
                $handler->setHandler($this->exceptionHandler);
                if (null !== $this->fileLinkFormat) {
                    $handler->setFileLinkFormat($this->fileLinkFormat);
                }
            }
            $this->exceptionHandler = null;
        }
    }

    public static function getSubscribedEvents()
    {
        $events = [KernelEvents::REQUEST => ['configure', 2048]];

        if ('cli' === \PHP_SAPI && \defined('Symfony\Component\Console\ConsoleEvents::COMMAND')) {
            $events[ConsoleEvents::COMMAND] = ['configure', 2048];
        }

        return $events;
    }
}
                                                                                                                                                                                                                