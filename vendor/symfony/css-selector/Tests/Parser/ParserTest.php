tion = null;
        }

        try {
            if (null !== $exception) {
                self::$exitCode = 255;
                $handler->handleException($exception, $error);
            }
        } catch (FatalErrorException $e) {
            // Ignore this re-throw
        }

        if ($exit && self::$exitCode) {
            $exitCode = self::$exitCode;
            register_shutdown_function('register_shutdown_function', function () use ($exitCode) { exit($exitCode); });
        }
    }

    /**
     * Gets the fatal error handlers.
     *
     * Override this method if you want to define more fatal error handlers.
     *
     * @return FatalErrorHandlerInterface[] An array of FatalErrorHandlerInterface
     */
    protected function getFatalErrorHandlers()
    {
        return [
            new UndefinedFunctionFatalErrorHandler(),
            new UndefinedMethodFatalErrorHandler(),
            new ClassNotFoundFatalErrorHandler(),
        ];
    }

    /**
     * Cleans the trace by removing function arguments and the frames added by the error handler and DebugClassLoader.
     */
    private function cleanTrace($backtrace, $type, $file, $line, $throw)
    {
        $lightTrace = $backtrace;

        for ($i = 0; isset($backtrace[$i]); ++$i) {
            if (isset($backtrace[$i]['file'], $backtrace[$i]['line']) && $backtrace[$i]['line'] === $line && $backtrace[$i]['file'] === $file) {
                $lightTrace = \array_slice($lightTrace, 1 + $i);
                break;
            }
        }
        if (class_exists(DebugClassLoader::class, false)) {
            for ($i = \count($lightTrace) - 2; 0 < $i; --$i) {
                if (DebugClassLoader::class === ($lightTrace[$i]['class'] ?? null)) {
                    array_splice($lightTrace, --$i, 2);
                }
            }
        }
        if (!($throw || $this->scopedErrors & $type)) {
            for ($i = 0; isset($lightTrace[$i]); ++$i) {
                unset($lightTrace[$i]['args'], $lightTrace[$i]['object']);
            }
        }

        return $lightTrace;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         INDX( 	 F?�             (   X  �         �                  �-     h V     �-     �k2�pk� ސ����s{��<��k2�pk�(       "               
 . g i t i g n o r e   �-     x h     �-     �W>�pk� ސ����s{��<��W>�pk�       �               B u f f e r i n g L o g g e r . p h p �-     p Z     �-     B�@�pk� ސ����t�}��<�B�@�pk�       �               C H A N G E L O G . m d       �-     p \     �-     �E�pk� ސ�����8���<��E�pk�       �               c o m p o s e r . j s o n    �-     h T     �-     ^O�pk� ސ����s����<�^O�pk�       �              	 D e b u g . p h p     �-     � j     �-     ��X�pk� ސ����s����<���X�pk� P      �F               D e b u g C l a s s L o a d e r . p h p       �-     x b     �-     ��k�pk� ސ���������<���k�pk� p      'h               E r r o r H a n d l e r . p h p       �-     h T     �-     R�e�pk��Zկ %�R�e�pk�R�e�pk�                       	 E x c e p t i o n H a �-     � j     �-     ��y�pk� ސ�����_���<���y�pk  p      ga               E x c e p t i o n H a n d l e r . p h p       �-     x d     �-     N���pk���� %�N���pk�N���pk�                        F a t a l E r r o r H a n d l e r    �-     ` P     �-     0U|�pk� ސ�����_���<�0U|�pk�       )               L I C E N S E �-     x b     �-     �8a�pk� ސ����L��<��8a�pk�       �               p h p u n i t . x m l . d i s t       �-     h T     �-     R�e�pk� ސ�����#���<�R�e�pk��      �              	 R E A D M E . m d    �-     ` L     �-     "���pk� �i�pk� �i�pk� �i�pk�                        T e s t s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\Exception\OutOfMemoryException;
use Symfony\Component\HttpKernel\Debug\FileLinkFormatter;

/**
 * ExceptionHandler converts an exception to a Response object.
 *
 * It is mostly useful in debug mode to replace the default PHP/XDebug
 * output with something prettier and more useful.
 *
 * As this class is mainly used during Kernel boot, where nothing is yet
 * available, the Response content is always HTML.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ExceptionHandler
{
    private $debug;
    private $charset;
    private $handler;
    private $caughtBuffer;
    private $caughtLength;
    private $fileLinkFormat;

    public function __construct(bool $debug = true, string $charset = null, $fileLinkFormat = null)
    {
        $this->debug = $debug;
        $this->charset = $charset ?: ini_get('default_charset') ?: 'UTF-8';
        $this->fileLinkFormat = $fileLinkFormat;
    }

    /**
     * Registers the exception handler.
     *
     * @param bool        $debug          Enable/disable debug mode, where the stack trace is displayed
     * @param string|null $charset        The charset used by exception messages
     * @param string|null $fileLinkFormat The IDE link template
     *
     * @return static
     */
    public static function register($debug = true, $charset = null, $fileLinkFormat = null)
    {
        $handler = new static($debug, $charset, $fileLinkFormat);

        $prev = set_exception_handler([$handler, 'handle']);
        if (\is_array($prev) && $prev[0] instanceof ErrorHandler) {
            restore_exception_handler();
            $prev[0]->setExceptionHandler([$handler, 'handle']);
        }

        return $handler;
    }

    /**
     * Sets a user exception handler.
     *
     * @param callable $handler An handler that will be called on Exception
     *
     * @return callable|null The previous exception handler if any
     */
    public function setHandler(callable $handler = null)
    {
        $old = $this->handler;
        $this->handler = $handler;

        return $old;
    }

    /**
     * Sets the format for links to source files.
     *
     * @param string|FileLinkFormatter $fileLinkFormat The format for links to source files
     *
     * @return string The previous file link format
     */
    public function setFileLinkFormat($fileLinkFormat)
    {
        $old = $this->fileLinkFormat;
        $this->fileLinkFormat = $fileLinkFormat;

        return $old;
    }

    /**
     * Sends a response for the given Exception.
     *
     * To be as fail-safe as possible, the exception is first handled
     * by our simple exception handler, then by the user exception handler.
     * The latter takes precedence and any output from the former is cancelled,
     * if and only if nothing bad happens in this handling path.
     */
    public function handle(\Exception $exception)
    {
        if (null === $this->handler || $exception instanceof OutOfMemoryException) {
            $this->sendPhpResponse($exception);

            return;
        }

        $caughtLength = $this->caughtLength = 0;

        ob_start(function ($buffer) {
            $this->caughtBuffer = $buffer;

            return '';
        });

        $this->sendPhpResponse($exception);
        while (null === $this->caughtBuffer && ob_end_flush()) {
            // Empty loop, everything is in the condition
        }
        if (isset($this->caughtBuffer[0])) {
            ob_start(function ($buffer) {
                if ($this->caughtLength) {
                    // use substr_replace() instead of substr() for mbstring overloading resistance
                    $cleanBuffer = substr_replace($buffer, '', 0, $this->caughtLength);
                    if (isset($cleanBuffer[0])) {
                        $buffer = $cleanBuffer;
                    }
                }

                return $buffer;
            });

            echo $this->caughtBuffer;
           