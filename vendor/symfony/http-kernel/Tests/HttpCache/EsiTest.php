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

/**
 * Guesses the MIME type of a file.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
interface MimeTypeGuesserInterface
{
    /**
     * Returns true if this guesser is supported.
     */
    public function isGuesserSupported(): bool;

    /**
     * Guesses the MIME type of the file with the given path.
     *
     * @param string $path The path to the file
     *
     * @return string|null The MIME type or null, if none could be guessed
     *
     * @throws \LogicException           If the guesser is not supported
     * @throws \InvalidArgumentException If the file does not exist or is not readable
     */
    public function guessMimeType(string $path): ?string;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime;

use Symfony\Component\Mime\Exception\LogicException;

/**
 * Manages MIME types and file extensions.
 *
 * For MIME type guessing, you can register custom guessers
 * by calling the registerGuesser() method.
 * Custom guessers are always called before any default ones:
 *
 *     $guesser = new MimeTypes();
 *     $guesser->registerGuesser(new MyCustomMimeTypeGuesser());
 *
 * If you want to change the order of the default guessers, just re-register your
 * preferred one as a custom one. The last registered guesser is preferred over
 * previously registered ones.
 *
 * Re-registering a built-in guesser also allows you to configure it:
 *
 *     $guesser = new MimeTypes();
 *     $guesser->registerGuesser(new FileinfoMimeTypeGuesser('/path/to/magic/file'));
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
final class MimeTypes implements MimeTypesInterface
{
    private $extensions = [];
    private $mimeTypes = [];

    /**
     * @var MimeTypeGuesserInterface[]
     */
    private $guessers = [];
    private static $default;

    public function __construct(array $map = [])
    {
        foreach ($map as $mimeType => $extensions) {
            $this->extensions[$mimeType] = $extensions;

            foreach ($extensions as $extension) {
                $this->mimeTypes[$extension] = $mimeType;
            }
        }
        $this->registerGuesser(new FileBinaryMimeTypeGuesser());
        $this->registerGuesser(new FileinfoMimeTypeGuesser());
    }

    public static function setDefault(self $default)
    {
        self::$default = $default;
    }

    public static function getDefault(): self
    {
        return self::$default ?? self::$default = new self();
    }

    /**
     * Registers a MIME type guesser.
     *
     * The last registered guesser has precedence over the other ones.
     */
    public function registerGuesser(MimeTypeGuesserInterface $guesser)
    {
        array_unshift($this->guessers, $guesser);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtensions(string $mimeType): array
    {
        if ($this->extensions) {
            $extensions = $this->extensions[$mimeType] ?? $this->extensions[$lcMimeType = strtolower($mimeType)] ?? null;
        }

        return $extensions ?? self::$map[$mimeType] ?? self::$map[$lcMimeType ?? strtolower($mimeType)] ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function getMimeTypes(string $ext): array
    {
        if ($this->mimeTypes) {
            $mimeTypes = $this->mimeTypes[$ext] ?? $this->mimeTypes[$lcExt = strtolower($ext)] ?? null;
        }

        return $mimeTypes ?? self::$reverseMap[$ext] ?? self::$reverseMap[$lcExt ?? strtolower($ext)] ?? [];
    }

    /**
     * {@inheritdoc}
     */
    public function isGuesserSupported(): bool
    {
        foreach ($this->guessers as $guesser) {
            if ($guesser->isGuesserSupported()) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     *
     * The file is passed to each registered MIME type guesser in reverse order
     * of their registration (last registered is queried first). Once a guesser
     * returns a value that is not null, this method terminates and returns the
     * value.
     */
    public function guessMimeType(string $path): ?string
    {
        foreach ($this->guessers as $guesser) {
            if (!$guesser->isGuesserSupported()) {
                continue;
            }

            if (null !== $mimeType = $guesser->guessMimeType($path)) {
                return $mimeType;
            }
        }

        if (!$this->isGuesserSupported()) {
            throw new LogicException('Unable to guess the MIME type as no guessers are available (have you enable the php_fileinfo extension?).');
        }

        return null;
    }

    /**
     * A map of MIME types and their default extensions.
     *
     * Updated from upstream on 2019-01-16
     *
     * @see Resources/bin/update_mime_types.php
     */
    private static $map = [
        'application/acrobat' => ['pdf'],
        'application/andrew-inset' => ['ez'],
        'application/annodex' => ['anx'],
        'application/applixware' => ['aw'],
        'application/atom+xml' => ['atom'],
        'application/atomcat+xml' => ['atomcat'],
        'application/atomsvc+xml' => ['atomsvc'],
        'application/ccxml+xml' => ['ccxml'],
        'application/cdmi-capability' => ['cdmia'],
        'application/cdmi-container' => ['cdmic'],
        'application/cdmi-domain' => ['cdmid'],
        'application/cdmi-object' => ['cdmio'],
        'application/cdmi-queue' => ['cdmiq'],
        'application/cdr' => ['cdr'],
        'application/coreldraw' => ['cdr'],
        'applicat