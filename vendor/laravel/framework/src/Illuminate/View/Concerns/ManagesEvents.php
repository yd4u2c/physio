<?php

namespace League\Flysystem;

use BadMethodCallException;

/**
 * @deprecated
 */
abstract class Handler
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var FilesystemInterface
     */
    protected $filesystem;

    /**
     * Constructor.
     *
     * @param FilesystemInterface $filesystem
     * @param string              $path
     */
    public function __construct(FilesystemInterface $filesystem = null, $path = null)
    {
        $this->path = $path;
        $this->filesystem = $filesystem;
    }

    /**
     * Check whether the entree is a directory.
     *
     * @return bool
     */
    public function isDir()
    {
        return $this->getType() === 'dir';
    }

    /**
     * Check whether the entree is a file.
     *
     * @return bool
     */
    public function isFile()
    {
        return $this->getType() === 'file';
    }

    /**
     * Retrieve the entree type (file|dir).
     *
     * @return string file or dir
     */
    public function getType()
    {
        $metadata = $this->filesystem->getMetadata($this->path);

        return $metadata['type'];
    }

    /**
     * Set the Filesystem object.
     *
     * @param FilesystemInterface $filesystem
     *
     * @return $this
     */
    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }
    
    /**
     * Retrieve the Filesystem object.
     *
     * @return FilesystemInterface
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Set the entree path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Retrieve the entree path.
     *
     * @return string path
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Plugins pass-through.
     *
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, array $arguments)
    {
        array_unshift($arguments, $this->path);
        $callback = [$this->filesystem, $method];

        try {
            return call_user_func_array($callback, $arguments);
        } catch (BadMethodCallException $e) {
            throw new BadMethodCallException(
                'Call to undefined method '
                . get_called_class()
                . '::' . $method
            );
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

namespace League\Flysystem;

use InvalidArgumentException;
use League\Flysystem\Plugin\PluggableTrait;
use League\Flysystem\Plugin\PluginNotFoundException;

/**
 * Class MountManager.
 *
 * Proxies methods to Filesystem (@see __call):
 *
 * @method AdapterInterface getAdapter($prefix)
 * @method Config getConfig($prefix)
 * @method array listFiles($directory = '', $recursive = false)
 * @method array listPaths($directory = '', $recursive = false)
 * @method array getWithMetadata($path, array $metadata)
 * @method Filesystem flushCache()
 * @method void assertPresent($path)
 * @method void assertAbsent($path)
 * @method Filesystem addPlugin(PluginInterface $plugin)
 */
class MountManager implements FilesystemInterface
{
    use PluggableTrait;

    /**
     * @var FilesystemInterface[]
     */
    protected $filesystems = [];

    /**
     * Constructor.
     *
     * @param FilesystemInterface[] $filesystems [:prefix => Fi