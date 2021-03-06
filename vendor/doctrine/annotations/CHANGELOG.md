<?php

namespace Doctrine\Common\Cache;

use const PHP_VERSION_ID;
use function apc_cache_info;
use function apc_clear_cache;
use function apc_delete;
use function apc_exists;
use function apc_fetch;
use function apc_sma_info;
use function apc_store;

/**
 * APC cache provider.
 *
 * @link       www.doctrine-project.org
 * @deprecated since version 1.6, use ApcuCache instead
 */
class ApcCache extends CacheProvider
{
    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        return apc_fetch($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return apc_exists($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        return apc_store($id, $data, $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        // apc_delete returns false if the id does not exist
        return apc_delete($id) || ! apc_exists($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        return apc_clear_cache() && apc_clear_cache('user');
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetchMultiple(array $keys)
    {
        return apc_fetch($keys) ?: [];
    }

    /**
     * {@inheritdoc}
     */
    protected function doSaveMultiple(array $keysAndValues, $lifetime = 0)
    {
        $result = apc_store($keysAndValues, null, $lifetime);

        return empty($result);
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        $info = apc_cache_info('', true);
        $sma  = apc_sma_info();

        // @TODO - Temporary fix @see https://github.com/krakjoe/apcu/pull/42
        if (PHP_VERSION_ID >= 50500) {
            $info['num_hits']   = $info['num_hits'] ?? $info['nhits'];
            $info['num_misses'] = $info['num_misses'] ?? $info['nmisses'];
            $info['start_time'] = $info['start_time'] ?? $info['stime'];
        }

        return [
            Cache::STATS_HITS             => $info['num_hits'],
            Cache::STATS_MISSES           => $info['num_misses'],
            Cache::STATS_UPTIME           => $info['start_time'],
            Cache::STATS_MEMORY_USAGE     => $info['mem_size'],
            Cache::STATS_MEMORY_AVAILABLE => $sma['avail_mem'],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Doctrine\Common\Cache;

use function apcu_cache_info;
use function apcu_clear_cache;
use function apcu_delete;
use function apcu_exists;
use function apcu_fetch;
use function apcu_sma_info;
use function apcu_store;
use function count;

/**
 * APCu cache provider.
 *
 * @link   www.doctrine-project.org
 */
class ApcuCache extends CacheProvider
{
    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        return apcu_fetch($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        return apcu_exists($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doSave($id, $data, $lifeTime = 0)
    {
        return apcu_store($id, $data, $lifeTime);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDelete($id)
    {
        // apcu_delete returns false if the id does not exist
        return apcu_delete($id) || ! apcu_exists($id);
    }

    /**
     * {@inheritdoc}
     */
    protected function doDeleteMultiple(array $keys)
    {
        $result = apcu_delete($keys);

        return $result !== false && count($result) !== count($keys);
    }

    /**
     * {@inheritdoc}
     */
    protected function doFlush()
    {
        return apcu_clear_cache();
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetchMultiple(array $keys)
    {
        return apcu_fetch($keys) ?: [];
    }

    /**
     * {@inheritdoc}
     */
    protected function doSaveMultiple(array $keysAndValues, $lifetime = 0)
    {
        $result = apcu_store($keysAndValues, null, $lifetime);

        return empty($result);
    }

    /**
     * {@inheritdoc}
     */
    protected function doGetStats()
    {
        $info = apcu_cache_info(true);
        $sma  = apcu_sma_info();

        return [
            Cache::STATS_HITS             => $info['num_hits'],
            Cache::STATS_MISSES           => $info['num_misses'],
            Cache::STATS_UPTIME           => $info['start_time'],
            Cache::STATS_MEMORY_USAGE     => $info['mem_size'],
            Cache::STATS_MEMORY_AVAILABLE => $sma['avail_mem'],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Doctrine\Common\Cache;

use function time;

/**
 * Array cache driver.
 *
 * @link   www.doctrine-project.org
 */
class ArrayCache extends CacheProvider
{
    /** @var array[] $data each element being a tuple of [$data, $expiration], where the expiration is int|bool */
    private $data = [];

    /** @var int */
    private $hitsCount = 0;

    /** @var int */
    private $missesCount = 0;

    /** @var int */
    private $upTime;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->upTime = time();
    }

    /**
     * {@inheritdoc}
     */
    protected function doFetch($id)
    {
        if (! $this->doContains($id)) {
            $this->missesCount += 1;

            return false;
        }

        $this->hitsCount += 1;

        return $this->data[$id][0];
    }

    /**
     * {@inheritdoc}
     */
    protected function doContains($id)
    {
        if (! isset($this->data[$id])) {
    