<?php

namespace Doctrine\DBAL\Sharding;

use Doctrine\DBAL\DBALException;

/**
 * Sharding related Exceptions
 */
class ShardingException extends DBALException
{
    /**
     * @return \Doctrine\DBAL\Sharding\ShardingException
     */
    public static function notImplemented()
    {
        return new self('This functionality is not implemented with this sharding provider.', 1331557937);
    }

    /**
     * @return \Doctrine\DBAL\Sharding\ShardingException
     */
    public static function missingDefaultFederationName()
    {
        return new self('SQLAzure requires a federation name to be set during sharding configuration.', 1332141280);
    }

    /**
     * @return \Doctrine\DBAL\Sharding\ShardingException
     */
    public static function missingDefaultDistributionKey()
    {
        return new self('SQLAzure requires a distribution key to be set during sharding configuration.', 1332141329);
    }

    /**
     * @return \Doctrine\DBAL\Sharding\ShardingException
     */
    public static function activeTransaction()
    {
        return new self('Cannot switch shard during an active transaction.', 1332141766);
    }

    /**
     * @return \Doctrine\DBAL\Sharding\ShardingException
     */
    public static function noShardDistributionValue()
    {
        return new self('You have to specify a string or integer as shard distribution value.', 1332142103);
    }

    /**
     * @return \Doctrine\DBAL\Sharding\ShardingException
     */
    public static function missingDistributionType()
    {
        return new self("You have to specify a sharding distribution type such as 'integer', 'string', 'guid'.");
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Doctrine\DBAL\Sharding;

/**
 * Sharding Manager gives access to APIs to implementing sharding on top of
 * Doctrine\DBAL\Connection instances.
 *
 * For simplicity and developer ease-of-use (and understanding) the sharding
 * API only covers single shard queries, no fan-out support. It is primarily
 * suited for multi-tenant applications.
 *
 * The assumption about sharding here
 * is that a distribution value can be found that gives access to all the
 * necessary data for all use-cases. Switching between shards should be done with
 * caution, especially if lazy loading is implemented. Any query is always
 * executed against the last shard that was selected. If a query is created for
 * a shard Y but then a shard X is selected when its actually executed you
 * will hit the wrong shard.
 */
interface ShardManager
{
    /**
     * Selects global database with global data.
     *
     * This is the default database that is connected when no shard is
     * selected.
     *
     * @return void
     */
    public function selectGlobal();

    /**
     * Selects the shard against which the queries after this statement will be issued.
     *
     * @param string $distributionValue
     *
     * @return void
     *
     * @throws ShardingException If no value is passed as shard identifier.
     */
    public function selectShard($distributionValue);

    /**
     * Gets the distribution value currently used for sharding.
     *
     * @return string|null
     */
    public function getCurrentDistributionValue();

    /**
     * Gets information about the amount of shards and other details.
     *
     * Format is implementation specific, each shard is one element and has an
     * 'id' attribute at least.
     *
     * @return mixed[][]
     */
    public function getShards();

    /**
     * Queries all shards in undefined order and return the results appended to
     * each other. Restore the previous distribution value after execution.
     *
     * Using {@link \Doctrine\DBAL\Connection::fetchAll} to retrieve rows internally.
     *
     * @param string         $sql
     * @param mixed[]        $params
     * @param int[]|string[] $types
     *
     * @return mixed[]
     */
    public function queryAll($sql, array $params, array $types);
}
                                                                                                                                                                                                                                                                                           