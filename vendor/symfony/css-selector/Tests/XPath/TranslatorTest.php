<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug\Exception;

/**
 * Data Object that represents a Silenced Error.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class SilencedErrorContext implements \JsonSerializable
{
    public $count = 1;

    private $severity;
    private $file;
    private $line;
    private $trace;

    public function __construct(int $severity, string $file, int $line, array $trace = [], int $count = 1)
    {
        $this->severity = $severity;
        $this->file = $file;
        $this->line = $line;
        $this->trace = $trace;
        $this->count = $count;
    }

    public function getSeverity()
    {
        return $this->severity;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getLine()
    {
        return $this->line;
    }

    public function getTrace()
    {
        return $this->trace;
    }

    public function JsonSerialize()
    {
        return [
            'severity' => $this->severity,
            'file' => $this->file,
            'line' => $this->line,
            'trace' => $this->trace,
            'count' => $this->count,
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug\Exception;

/**
 * Undefined Function Exception.
 *
 * @author Konstanton Myakshin <koc-dp@yandex.ru>
 */
class UndefinedFunctionException extends FatalErrorException
{
    public function __construct(string $message, \ErrorException $previous)
    {
        parent::__construct(
            $message,
            $previous->getCode(),
            $previous->getSeverity(),
            $previous->getFile(),
            $previous->getLine(),
            null,
            true,
            null,
            $previous->getPrevious()
        );
        $this->setTrace($previous->getTrace());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug\Exception;

/**
 * Undefined Method Exception.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class UndefinedMethodException extends FatalErrorException
{
    public function __construct(string $message, \ErrorException $previous)
    {
        parent::__construct(
            $message,
            $previous->getCode(),
            $previous->getSeverity(),
            $previous->getFile(),
            $previous->getLine(),
            null,
            true,
            null,
            $previous->getPrevious()
        );
        $this->setTrace($previous->getTrace());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug\FatalErrorHandler;

use Composer\Autoload\ClassLoader as ComposerClassLoader;
use Symfony\Component\ClassLoader\ClassLoader as SymfonyClassLoader;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Symfony\Component\Debug\Exception\FatalErrorException;

/**
 * ErrorHandler for classes that do not exist.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ClassNotFoundFatalErrorHandler implements FatalErrorHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function handleError(array $error, FatalErrorException $exception)
    {
        $messageLen = \strlen($error['message']);
        $notFoundSuffix = '\' not found';
        $notFoundSuffixLen = \strlen($notFoundSuffix);
        if ($notFoundSuffixLen > $messageLen) {
            return;
        }

        if (0 !== substr_compare($error['message'], $notFoundSuffix, -$notFoundSuffixLen)) {
            return;
        }

        foreach (['class', 'interface', 'trait'] as $typeName) {
            $prefix = ucfirst($typeName).' \'';
            $prefixLen = \strlen($prefix);
            if (0 !== strpos($error['message'], $prefix)) {
                continue;
            }

            $fullyQualifiedClassName = substr($error['message'], $prefixLen, -$notFoundSuffixLen);
            if (false !== $namespaceSeparatorIndex = strrpos($fullyQualifiedClassName, '\\')) {
                $className = substr($fullyQualifiedClassName, $namespaceSeparatorIndex + 1);
                $namespacePrefix = substr($fullyQualifiedClassName, 0, $namespaceSeparatorIndex);
                $message = sprintf('Attempted to load %s "%s" from namespace "%s".', $typeName, $className, $namespacePrefix);
                $tail = ' for another namespace?';
            } else {
                $className = $fullyQualifiedClassName;
                $message = sprintf('Attempted to load %s "%s" from the global namespace.', $typeName, $className);
                $tail = '?';
            }

            if ($candidates = $this->getClassCandidates($className)) {
                $tail = array_pop($candidates).'"?';
                if ($candidates) {
                    $tail = ' for e.g. "'.implode('", "', $candidates).'" or "'.$tail;
                } else {
                    $tail = ' for "'.$tail;
                }
            }
            $message .= "\nDid you forget a \"use\" statement".$tail;

            return new ClassNotFoundException($message, $exception);
        }
    }

    /**
     * Tries to guess the full namespace for a given class name.
     *
     * By default, it looks for PSR-0 and PSR-4 classes registered via a Symfony or a Composer
     * autoloader (that should cover all common cases).
     *
     * @param string $class A class name (without its namespace)
     *
     * @return array An array of possible fully qualified class names
     */
    private function getClassCandidates(string $class): array
    {
        if (!\is_array($functions = spl_autoload_functions())) {
            return [];
        }

        // find Symfony and Composer autoloaders
        $classes = [];

        foreach ($functions as $function) {
            if (!\is_array($function)) {
                continue;
            }
            // get class loaders wrapped by DebugClassLoader
            if ($function[0] instanceof DebugClassLoader) {
                $function = $function[0]->getClassLoader();

                if (!\is_array($function)) {
                    continue;
                }
            }

            if ($function[0] instanceof ComposerClassLoader || $function[0] instanceof SymfonyClassLoader) {
                foreach ($function[0]->getPrefixes() as $prefix => $paths) {
                    foreach ($paths as $path) {
                        $classes = array_merge($classes, $this->findClassInPath($path, $class, $prefix));
                    }
                }
            }
            if ($function[0] instanceof ComposerClassLoader) {
                foreach ($function[0]->getPrefixesPsr4() as $prefix => $paths) {
                    foreach ($paths as $path) {
                        $classes = array_merge($classes, $this->findClassInPath($path, $class, $prefix));
                    }
                }
            }
        }

        return array_unique($classes);
    }

    private function findClassInPath(string $path, string $class, string $prefix): array
    {
        if (!$path = realpath($path.'/'.strtr($prefix, '\\_', '//')) ?: realpath($path.'/'.\dirname(strtr($prefix, '\\_', '//'))) ?: realpath($path)) {
            return [];
        }

        $classes = [];
        $filename = $class.'.php';
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::LEAVES_ONLY) as $file) {
            if ($filename == $file->getFileName() && $class = $this->convertFileToClass($path, $file->getPathName(), $prefix)) {
                $classes[] = $class;
            }
        }

        return $classes;
    }

    private function convertFileToClass(string $path, string $file, string $prefix): ?string
    {
        $candidates = [
            // namespaced class
            $namespacedClass = str_replace([$path.\DIRECTORY_SEPARATOR, '.php', '/'], ['', '', '\\'], $file),
            // namespaced class (with target dir)
            $prefix.$namespacedClass,
            // namespaced class (with target dir and separator)
            $prefix.'\\'.$namespacedClass,
            // PEAR class
            str_replace('\\', '_', $namespacedClass),
            // PEAR class (with target dir)
            str_