<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

/**
 * StreamedResponse represents a streamed HTTP response.
 *
 * A StreamedResponse uses a callback for its content.
 *
 * The callback should use the standard PHP functions like echo
 * to stream the response back to the client. The flush() function
 * can also be used if needed.
 *
 * @see flush()
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class StreamedResponse extends Response
{
    protected $callback;
    protected $streamed;
    private $headersSent;

    /**
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     */
    public function __construct(callable $callback = null, int $status = 200, array $headers = [])
    {
        parent::__construct(null, $status, $headers);

        if (null !== $callback) {
            $this->setCallback($callback);
        }
        $this->streamed = false;
        $this->headersSent = false;
    }

    /**
     * Factory method for chainability.
     *
     * @param callable|null $callback A valid PHP callback or null to set it later
     * @param int           $status   The response status code
     * @param array         $headers  An array of response headers
     *
     * @return static
     */
    public static function create($callback = null, $status = 200, $headers = [])
    {
        return new static($callback, $status, $headers);
    }

    /**
     * Sets the PHP callback associated with this Response.
     *
     * @param callable $callback A valid PHP callback
     *
     * @return $this
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the headers once.
     *
     * @return $this
     */
    public function sendHeaders()
    {
        if ($this->headersSent) {
            return $this;
        }

        $this->headersSent = true;

        return parent::sendHeaders();
    }

    /**
     * {@inheritdoc}
     *
     * This method only sends the content once.
     *
     * @return $this
     */
    public function sendContent()
    {
        if ($this->streamed) {
            return $this;
        }

        $this->streamed = true;

        if (null === $this->callback) {
            throw new \LogicException('The Response callback must not be null.');
        }

        ($this->callback)();

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException when the content is not null
     *
     * @return $this
     */
    public function setContent($content)
    {
        if (null !== $content) {
            throw new \LogicException('The content cannot be set on a StreamedResponse instance.');
        }

        $this->streamed = true;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return false
     */
    public function getContent()
    {
        return false;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation;

use Symfony\Component\Routing\RequestContext;

/**
 * A helper service for manipulating URLs within and outside the request scope.
 *
 * @author Valentin Udaltsov <udaltsov.valentin@gmail.com>
 */
final class UrlHelper
{
    private $requestStack;
    private $requestContext;

    public function __construct(RequestStack $requestStack, ?RequestContext $requestContext = null)
    {
        $this->requestStack = $requestStack;
        $this->requestContext = $requestContext;
    }

    public function getAbsoluteUrl(string $path): string
    {
        if (false !== strpos($path, '://') || '//' === substr($path, 0, 2)) {
            return $path;
        }

        if (null === $request = $this->requestStack->getMasterRequest()) {
            return $this->getAbsoluteUrlFromContext($path);
        }

        if ('#' === $path[0]) {
            $path = $request->getRequestUri().$path;
        } elseif ('?' === $path[0]) {
            $path = $request->getPathInfo().$path;
        }

        if (!$path || '/' !== $path[0]) {
            $prefix = $request->getPathInfo();
            $last = \strlen($prefix) - 1;
            if ($last !== $pos = strrpos($prefix, '/')) {
                $prefix = substr($prefix, 0, $pos).'/';
            }

            return $request->getUriForPath($prefix.$path);
        }

        return $request->getSchemeAndHttpHost().$path;
    }

    public function getRelativePath(string $path): string
    {
        if (false !== strpos($path, '://') || '//' === substr($path, 0, 2)) {
            return $path;
        }

        if (null === $request = $this->requestStack->getMasterRequest()) {
            return $path;
        }

        return $request->getRelativeUriForPath($path);
    }

    private function getAbsoluteUrlFromContext(string $path): string
    {
        if (null === $this->requestContext || '' === $host = $this->requestContext->getHost()) {
            return $path;
        }

        $scheme = $this->requestContext->getScheme();
        $port = '';

        if ('http' === $scheme && 80 !== $this->requestContext->getHttpPort()) {
            $port = ':'.$this->requestContext->getHttpPort();
        } elseif ('https' === $scheme && 443 !== $this->requestContext->getHttpsPort()) {
            $port = ':'.$this->requestContext->getHttpsPort();
        }

        if ('#' === $path[0]) {
            $queryString = $this->requestContext->getQueryString();
            $path = $this->requestContext->getPathInfo().($queryString ? '?'.$queryString : '').$path;
        } elseif ('?' === $path[0]) {
            $path = $this->requestContext->getPathInfo().$path;
        }

        if ('/' !== $path[0]) {
            $path = rtrim($this->requestContext->getBaseUrl(), '/').'/'.$path;
        }

        return $scheme.'://'.$host.$port.$path;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\File;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * A file in the file system.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class File extends \SplFileInfo
{
    /**
     * Constructs a new file from the given path.
     *
     * @param string $path      The path to the file
     * @param bool   $checkPath Whether to check the path or not
     *
     * @throws FileNotFoundException If the given path is not a file
     */
    public function __construct(string $path, bool $checkPath = true)
    {
        if ($checkPath && !is_file($path)) {
            throw new FileNotFoundException($path);
        }

        parent::__construct($path);
    }

    /**
     * Returns the extension based on the mime type.
     *
     * If the mime type is unknown, returns null.
     *
     * This method uses the mime type as guessed by getMimeType()
     * to guess the file extension.
     *
     * @return string|null The guessed extension or null if it cannot be guessed
     *
     * @see ExtensionGuesser
     * @see getMimeType()
     */
    public function guessExtension()
    {
        $type = $this->getMimeType();
        $guesser = ExtensionGuesser::getInstance();

        return $guesser->guess($type);
    }

    /**
     * Returns the mime type of the file.
     *
     * The mime type is guessed using a MimeTypeGuesser instance, which uses finfo(),
     * mime_content_type() and the system binary "file" (in this order), depending on
     * which of those are available.
     *
     * @return string|null The guessed mime type (e.g. "application/pdf")
     *
     * @see MimeTypeGuesser
     */
    public function getMimeType()
    {
        $guesser = MimeTypeGuesser::getInstance();

        return $guesser->guess($this->getPathname());
    }

    /**
     * Moves the file to a new location.
     *
     * @param string $directory The destination folder
     * @param string $name      The new file name
     *
     * @return self A File object representing the new file
     *
     * @throws FileException if the target file could not be created
     */
    public function move($directory, $name = null)
    {
        $target = $this->getTargetFile($directory, $name);

        set_error_handler(function ($type, $msg) use (&$error) { $error = $msg; });
        $renamed = rename($this->getPathname(), $target);
        restore_error_handler();
        if (!$renamed) {
            throw new FileException(sprintf('Could not move the file "%s" to "%s" (%s)', $this->getPathname(), $target, strip_tags($error)));
        }

        @chmod($target, 0666 & ~umask());

        return $target;
    }

    protected function getTargetFile($directory, $name = null)
    {
        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory', $directory));
        }

        $target = rtrim($directory, '/\\').\DIR