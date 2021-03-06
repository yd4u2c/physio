<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime;

use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Exception\LogicException;

/**
 * Guesses the MIME type with the binary "file" (only available on *nix).
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @experimental in 4.3
 */
class FileBinaryMimeTypeGuesser implements MimeTypeGuesserInterface
{
    private $cmd;

    /**
     * The $cmd pattern must contain a "%s" string that will be replaced
     * with the file name to guess.
     *
     * The command output must start with the MIME type of the file.
     *
     * @param string $cmd The command to run to get the MIME type of a file
     */
    public function __construct(string $cmd = 'file -b --mime %s 2>/dev/null')
    {
        $this->cmd = $cmd;
    }

    /**
     * {@inheritdoc}
     */
    public function isGuesserSupported(): bool
    {
        static $supported = null;

        if (null !== $supported) {
            return $supported;
        }

        if ('\\' === \DIRECTORY_SEPARATOR || !\function_exists('passthru') || !\function_exists('escapeshellarg')) {
            return $supported = false;
        }

        ob_start();
        passthru('command -v file', $exitStatus);
        $binPath = trim(ob_get_clean());

        return $supported = 0 === $exitStatus && '' !== $binPath;
    }

    /**
     * {@inheritdoc}
     */
    public function guessMimeType(string $path): ?string
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf('The "%s" file does not exist or is not readable.', $path));
        }

        if (!$this->isGuesserSupported()) {
            throw new LogicException(sprintf('The "%s" guesser is not supported.', __CLASS__));
        }

        ob_start();

        // need to use --mime instead of -i. see #6641
        passthru(sprintf($this->cmd, escapeshellarg($path)), $return);
        if ($return > 0) {
            ob_end_clean();

            return null;
        }

        $type = trim(ob_get_clean());

        if (!preg_match('#^([a-z0-9\-]+/[a-z0-9\-\.]+)#i', $type, $match)) {
            // it's not a type, but an error message
            return null;
        }

        return $match[1];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime;

use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Exception\LogicException;

/**
 * Guesses the MIME type using the PECL extension FileInfo.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 *
 * @experimental in 4.3
 */
class FileinfoMimeTypeGuesser implements MimeTypeGuesserInterface
{
    private $magicFile;

    /**
     * @param string $magicFile A magic file to use with the finfo instance
     *
     * @see http://www.php.net/manual/en/function.finfo-open.php
     */
    public function __construct(string $magicFile = null)
    {
        $this->magicFile = $magicFile;
    }

    /**
     * {@inheritdoc}
     */
    public function isGuesserSupported(): bool
    {
        return \function_exists('finfo_open');
    }

    /**
     * {@inheritdoc}
     */
    public function guessMimeType(string $path): ?string
    {
        if (!is_file($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf('The "%s" file does not exist or is not readable.', $path));
        }

        if (!$this->isGuesserSupported()) {
            throw new LogicException(sprintf('The "%s" guesser is not supported.', __CLASS__));
        }

        if (false === $finfo = new \finfo(FILEINFO_MIME_TYPE, $this->magicFile)) {
            return null;
        }

        return $finfo->file($path);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   Copyright (c) 2010-2019 Fabien Potencier

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             