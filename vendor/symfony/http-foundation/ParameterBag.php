<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\File\MimeType;

use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

/**
 * Guesses the mime type of a file.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
interface MimeTypeGuesserInterface
{
    /**
     * Guesses the mime type of the file with the given path.
     *
     * @param string $path The path to the file
     *
     * @return string The mime type or NULL, if none could be guessed
     *
     * @throws FileNotFoundException If the file does not exist
     * @throws AccessDeniedException If the file could not be read
     */
    public function guess($path);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Session;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBagInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Drak <drak@zikula.org>
 */
class Session implements SessionInterface, \IteratorAggregate, \Countable
{
    protected $storage;

    private $flashName;
    private $attributeName;
    private $data = [];
    private $usageIndex = 0;

    /**
     * @param SessionStorageInterface $storage    A SessionStorageInterface instance
     * @param AttributeBagInterface   $attributes An AttributeBagInterface instance, (defaults null for default AttributeBag)
     * @param FlashBagInterface       $flashes    A FlashBagInterface instance (defaults null for default FlashBag)
     */
    public function __construct(SessionStorageInterface $storage = null, AttributeBagInterface $attributes = null, FlashBagInterface $flashes = null)
    {
        $this->storage = $storage ?: new NativeSessionStorage();

        $attributes = $attributes ?: new AttributeBag();
        $this->attributeName = $attributes->getName();
        $this->registerBag($attributes);

        $flashes = $flashes ?: new FlashBag();
        $this->flashName = $flashes->getName();
        $this->registerBag($flashes);
    }