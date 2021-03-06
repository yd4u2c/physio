<?php

namespace Doctrine\Common\Cache;

use function is_object;
use function method_exists;
use function restore_error_handler;
use function serialize;
use function set_error_handler;
use function sprintf;
use function time;
use function var_export;

/**
 * Php file cache driver.
 */
class PhpFileCache extends FileCache
{
    public const EXTENSION = '.doctrinecache.php';

    /**
     * @var callable
     *
     * This is cached in a local static variable to avoid instantiating a closure each time we need an empty handler
     */
    private static $emptyErrorHandler;

    /**
     * {@inheritdoc}
     */
    public function __construct($directory, $extension = self::EXTENSION, $umask = 0002)
    {
        parent::__construct($directory, $extension, $umask);

        self::$emptyErrorHandler = function () {
        };
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        $value = $this->includeFileForId($id);

        if ($value === null) {
            return false;
        }

        if ($value['lifetime'] !== 0 && $value['lifetime'] < time()) {
            return false;
        }

        return $value['data'];
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        $value = $this->includeFileForId($id);

        if ($value === null) {
            return false;
        }

        return $value['lifetime'] === 0 || $value['lifetime'] > time();
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        if ($lifeTime > 0) {
            $lifeTime = time() + $lifeTime;
        }

        $filename = $this->getFilename($id);

        $value = [
            'lifetime'  => $lifeTime,
            'data'      => $data,
        ];

        if (is_object($data) && method_exists($data, '__set_state')) {
            $value = var_export($value, true);
            $code  = sprintf('<?php return %s;', $value);
        } else {
            $value = var_export(serialize($value), true);
            $code  = sprintf('<?php return unserialize(%s);', $value);
        }

        return $this->writeFile($filename, $code);
    }

    /**
     * @return array|null
     */
    private function includeFileForId(string $id) : ?array
    {
        $fileName = $this->getFilename($id);

        // note: error suppression is still faster than `file_exists`, `is_file` and `is_readable`
        set_error_handler(self::$emptyErrorHandler);

        $value = include $fileName;

        restore_error_handler();

        if (! isset($value['lifetime'])) {
            return null;
        }

        return $value;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

namespace Doctrine\Common\Cache;

use Predis\ClientInterface;
use function array_combine;
use function array_filter;
use function array_map;
use function call_user_func_array;
use function serialize;
use function unserialize;

/**
 * Predis cache provider.
 */
class PredisCache extends CacheProvider
{
    /** @var ClientInterface */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        $result = $this->client->get($id);
        if ($result === null) {
            return false;
        }

        return unserialize($result);
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetchMultiple(array $keys)
    {
        $fetchedItems = call_user_func_array([$this->client, 'mget'], $keys);

        return array_map('unserialize', array_filter(array_combine($keys, $fetchedItems)));
    }

    /**
     * {@inheritdoc}
     */
    protected function doSaveMultiple(array $keysAndValues, $lifetime = 0)
    {
        if ($lifetime) {
            $success = true;

            // Keys have lifetime, use SETEX for each of them
            foreach ($keysAndValues as $key => $value) {
                $response = (string) $this->client->setex($key, $lifetime, serialize($value));

                if ($response == 'OK') {
                    continue;
                }

                $success = false;
            }

            return $success;
        }

        // No lifetime, use MSET
        $response = $this->client->mset(array_map(function ($value) {
            return serialize($value);
        }, $keysAndValues));

        return (string) $response == 'OK';
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return (bool) $this->client->exists($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        $data = serialize($data);
        if ($lifeTime > 0) {
            $response = $this->client->setex($id, $lifeTime, $data);
        } else {
            $response = $this->client->set($id, $data);
        }

        return $response === true || $response == 'OK';
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        return $this->client->del($id) >= 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function doDeleteMultiple(array $keys)
    {
        return $this->client->del($keys) >= 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        $response = $this->client->flushdb();

        return $response === true || $response == 'OK';
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        $info = $this->client->info();

        return [
            Cache::STATS_HITS              => $info['Stats']['keyspace_hits'],
            Cache::STATS_MISSES            => $info['Stats']['keyspace_misses'],
            Cache::STATS_UPTIME            => $info['Server']['uptime_in_seconds'],
            Cache::STATS_MEMORY_USAGE      => $info['Memory']['used_memory'],
   