<?php

namespace Illuminate\Contracts\Bus;

interface Dispatcher
{
    /**
     * Dispatch a command to its appropriate handler.
     *
     * @param  mixed  $command
     * @return mixed
     */
    public function dispatch($command);

    /**
     * Dispatch a command to its appropriate handler in the current process.
     *
     * @param  mixed  $command
     * @param  mixed  $handler
     * @return mixed
     */
    public function dispatchNow($command, $handler = null);

    /**
     * Determine if the given command has a handler.
     *
     * @param  mixed  $command
     * @return bool
     */
    public function hasCommandHandler($command);

    /**
     * Retrieve the handler for a command.
     *
     * @param  mixed  $command
     * @return bool|mixed
     */
    public function getCommandHandler($command);

    /**
     * Set the pipes commands should be piped through before dispatching.
     *
     * @param  array  $pipes
     * @return $this
     */
    public function pipeThrough(array $pipes);

    /**
     * Map a command to a handler.
     *
     * @param  array  $map
     * @return $this
     */
    public function map(array $map);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

namespace Illuminate\Contracts\Cache;

interface Lock
{
    /**
     * Attempt to acquire the lock.
     *
     * @param  callable|null  $callback
     * @return mixed
     */
    public function get($callback = null);

    /**
     * Attempt to acquire the lock for the given number of seconds.
     *
     * @param  int  $seconds
     * @param  callable|null  $callback
     * @return bool
     */
    public function block($seconds, $callback = null);

    /**
     * Release the lock.
     *
     * @return void
     */
    public function release();

    /**
     * Returns the current owner of the lock.
     *
     * @return string
     */
    public function owner();

    /**
     * Releases this lock in disregard of ownership.
     *
     * @return void
     */
    public function forceRelease();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Illuminate\Contracts\Cache;

use Closure;
use Psr\SimpleCache\CacheInterface;

interface Repository extends CacheInterface
{
    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function pull($key, $default = null);

    /**
     * Store an item in the cache.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @return bool
     */
    public function put($key, $value, $ttl = null);

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @return bool
     */
    public function add($key, $value, $ttl = null);

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function increment($key, $value = 1);

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function decrement($key, $value = 1);

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return bool
     */
    public function forever($key, $value);

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param  string  $key
     * @param  \DateTimeInterface|\DateInterval|int|null  $ttl
     * @param  \Closure  $callback
     * @return mixed
     */
    public function remember($key, $ttl, Closure $callback);

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param  string  $key
     * @param  \Closure  $callback
     * @return mixed
     */
    public function sear($key, Closure $callback);

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param  string  $key
     * @param  \Closure  $callback
     * @return mixed
     */
    public function rememberForever($key, Closure $callback);

    /**
     * Remove an item from the cache.
     *
     * @param  string $key
     * @return bool
     */
    public function forget($key);

    /**
     * Get the cache store implementation.
     *
     * @return \Illuminate\Contracts\Cache\Store
     */
    public function getStore();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Illuminate\Contracts\Cache;

interface Store
{
    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|array  $key
     * @return mixed
     */
    public function get($key);

    /**
     * Retrieve multiple items from the cache by key.
     *
     * Items not found in the cache will have a null value.
     *
     * @param  array  $keys
     * @return array
     */
    public function many(array $keys);

    /**
     * Store an item in the cache for a given number of seconds.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $seconds
     * @return bool
     */
    public function put($key, $value, $seconds);

    /**
     * Store multiple items in the cache for a given number of seconds.
     *
     * @param  array  $values
     * @param  int  $seconds
     * @return bool
     */
    public function putMany(array $values, $seconds);

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function increment($key, $value = 1);

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function decrement($key, $value = 1);

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return bool
     */
    public function forever($key, $value);

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key);

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush();

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              