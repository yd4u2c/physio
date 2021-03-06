nction evalsha($script, $numkeys, ...$arguments)
    {
        return $this->command('evalsha', [
            $this->script('load', $script), $arguments, $numkeys,
        ]);
    }

    /**
     * Evaluate a script and return its result.
     *
     * @param  string  $script
     * @param  int  $numberOfKeys
     * @param  dynamic  $arguments
     * @return mixed
     */
    public function eval($script, $numberOfKeys, ...$arguments)
    {
        return $this->command('eval', [$script, $arguments, $numberOfKeys]);
    }

    /**
     * Subscribe to a set of given channels for messages.
     *
     * @param  array|string  $channels
     * @param  \Closure  $callback
     * @return void
     */
    public function subscribe($channels, Closure $callback)
    {
        $this->client->subscribe((array) $channels, function ($redis, $channel, $message) use ($callback) {
            $callback($message, $channel);
        });
    }

    /**
     * Subscribe to a set of given channels with wildcards.
     *
     * @param  array|string  $channels
     * @param  \Closure  $callback
     * @return void
     */
    public function psubscribe($channels, Closure $callback)
    {
        $this->client->psubscribe((array) $channels, function ($redis, $pattern, $channel, $message) use ($callback) {
            $callback($message, $channel);
        });
    }

    /**
     * Subscribe to a set of given channels for messages.
     *
     * @param  array|string  $channels
     * @param  \Closure  $callback
     * @param  string  $method
     * @return void
     */
    public function createSubscription($channels, Closure $callback, $method = 'subscribe')
    {
        //
    }

    /**
     * Execute a raw command.
     *
     * @param  array  $parameters
     * @return mixed
     */
    public function executeRaw(array $parameters)
    {
        return $this->command('rawCommand', $parameters);
    }

    /**
     * Disconnects from the Redis instance.
     *
     * @return void
     */
    public function disconnect()
    {
        $this->client->close();
    }

    /**
     * Apply prefix to the given key if necessary.
     *
     * @param  string  $key
     * @return string
     */
    private function applyPrefix($key)
    {
        $prefix = (string) $this->client->getOption(Redis::OPT_PREFIX);

        return $prefix.$key;
    }

    /**
     * Pass other method calls down to the underlying client.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return parent::__call(strtolower($method), $parameters);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Illuminate\Redis\Connections;

use Closure;
use Illuminate\Contracts\Redis\Connection as ConnectionContract;

/**
 * @mixin \Predis\Client
 */
class PredisConnection extends Connection implements ConnectionContract
{
    /**
     * Create a new Predis connection.
     *
     * @param  \Predis\Client  $client
     * @return void
     */
    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * Subscribe to a set of given channels for messages.
     *
     * @param  array|string  $channels
     * @param  \Closure  $callback
     * @param  string  $method
     * @return void
     */
    public function createSubscription($channels, Closure $callback, $method = 'subscribe')
    {
        $loop = $this->pubSubLoop();

        call_user_func_array([$loop, $method], (array) $channels);

        foreach ($loop as $message) {
            if ($message->kind === 'message' || $message->kind === 'pmessage') {
                call_user_func($callback, $message->payload, $message->channel);
            }
        }

        unset($loop);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     