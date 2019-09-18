INDX( 	 4i             (   (  �       ��                  �     x h     �     I���ok� �������"�}�<�I���ok�       �               A b s t r a c t V i s i t o r . p h p �     � z     �     ���ok� ���������}�<����ok�       e	               C r e a t e S c h e m a S q l C o l l e c t o r . p h p       �     � v     �     y��ok� ���������}�<�y��ok�       �               D r o p S c h e m a S q l C o l l e c t o r . p h p   �     p Z     �     ���ok� ���������}�< ���ok�        x               G r a p h v i z . p h p       �     � j     �     $���ok� ������AJ�}�<�$���ok�H      A               N a m e s p a c e V i s i t o r . p h p       �     � v     �     n���ok� ������AJ�}�<�n���ok�       h               R e m o v e N a m e s p a c e d A s s e t s . p h p   �     � l     �     �)��ok� ������X��}�<��)��ok�       �               S c h e m a D i f f V i s i t o r . p h p     �     h X     �     <���ok� ��������}�<�<���ok        �               V i s i t o r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Doctrine\DBAL\Schema\Visitor;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;

/**
 * Removes assets from a schema that are not in the default namespace.
 *
 * Some databases such as MySQL support cross databases joins, but don't
 * allow to call DDLs to a database from another connected database.
 * Before a schema is serialized into SQL this visitor can cleanup schemas with
 * non default namespaces.
 *
 * This visitor filters all these non-default namespaced tables and sequences
 * and removes them from the SChema instance.
 */
class RemoveNamespacedAssets extends AbstractVisitor
{
    /** @var Schema */
    private $schema;

    /**
     * {@inheritdoc}
     */
    public function acceptSchema(Schema $schema)
    {
        $this->schema = $schema;
    }

    /**
     * {@inheritdoc}
     */
    public function acceptTable(Table $table)
    {
        if ($table->isInDefaultNamespace($this->schema->getName())) {
            return;
        }

        $this->schema->dropTable($table->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function acceptSequence(Sequence $sequence)
    {
        if ($sequence->isInDefaultNamespace($this->schema->getName())) {
            return;
        }

        $this->schema->dropSequence($sequence->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function acceptForeignKey(Table $localTable, ForeignKeyConstraint $fkConstraint)
    {
        // The table may already be deleted in a previous
        // RemoveNamespacedAssets#acceptTable call. Removing Foreign keys that
        // point to nowhere.
        if (! $this->schema->hasTable($fkConstraint->getForeignTableName())) {
            $localTable->removeForeignKey($fkConstraint->getName());
            return;
        }

        $foreignTable = $this->schema->getTable($fkConstraint->getForeignTableName());
        if ($foreignTable->isInDefaultNamespace($this->schema->getName())) {
            return;
        }

        $localTable->removeForeignKey($fkConstraint->getName());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

namespace Doctrine\DBAL\Schema\Visitor;

use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;

/**
 * Visit a SchemaDiff.
 */
interface SchemaDiffVisitor
{
    /**
     * Visit an orphaned foreign key whose table was deleted.
     */
    public function visitOrphanedForeignKey(ForeignKeyConstraint $foreignKey);

    /**
     * Visit a sequence that has changed.
     */
    public function visitChangedSequence(Sequence $sequence);

    /**
     * Visit a sequence that has been removed.
     */
    public function visitRemovedSequence(Sequence $sequence);

    public function visitNewSequence(Sequence $sequence);

    public function visitNewTable(Table $table);

    public function visitNewTableForeignKey(Table $table, ForeignKeyConstraint $foreignKey);

    public function visitRemovedTable(Table $table);

    public function visitChangedTable(TableDiff $tableDiff);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Doctrine\DBAL\Schema\Visitor;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;

/**
 * Schema Visitor used for Validation or Generation purposes.
 */
interface Visitor
{
    /**
     * @return void
     */
    public function acceptSchema(Schema $schema);

    /**
     * @return void
     */
    public function acceptTable(Table $table);

    /**
     * @return void
     */
    public function acceptColumn(Table $table, Column $column);

    /**
     * @return void
     */
    public function acceptForeignKey(Table $localTable, ForeignKeyConstraint $fkConstraint);

    /**
     * @return void
     */
    public function acceptIndex(Table $table, Index $index);

    /**
     * @return void
     */
    public function acceptSequence(Sequence $sequence);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Doctrine\DBAL\Sharding;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Driver\Connection as DriverConnection;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;
use Doctrine\DBAL\Sharding\ShardChoser\ShardChoser;
use InvalidArgumentException;
use function array_merge;
use function is_numeric;
use function is_string;

/**
 * Sharding implementation that pools many different connections
 * internally and serves data from the currently active connection.
 *
 * The internals of this class are:
 *
 * - All sharding clients are specified and given a shard-id during
 *   configuration.
 * - By default, the global shard is selected. If no global shard is configured
 *   an exception is thrown on access.
 * - Selecting a shard by distribution value delegates the mapping
 *   "distributionValue" => "client" to the ShardChooser interface.
 * - An exception is thrown if trying to switch shards during an open
 *   transaction.
 *
 * Instantiation through the DriverManager looks like:
 *
 * @example
 *
 * $conn = DriverManager::getConnection(array(
 *    'wrapperClass' => 'Doctrine\DBAL\Sharding\PoolingShardConnection',
 *    'driver' => 'pdo_mysql',
 *    'global' => array('user' => '', 'password' => '', 'host' => '', 'dbname' => ''),
 *    'shards' => array(
 *        array('id' => 1, 'user' => 'slave1', 'password', 'host' => '', 'dbname' => ''),
 *        array('id' => 2, 'user' => 'slave2', 'password', 'host' => '', 'dbname' => ''),
 *    ),
 *    'shardChoser' => 'Doctrine\DBAL\Sharding\ShardChoser\MultiTenantShardChoser',
 * ));
 * $shardManager = $conn->getShardManager();
 * $shardManager->selectGlobal();
 * $shardManager->selectShard($value);
 */
class PoolingShardConnection extends Connection
{
    /** @var DriverConnection[] */
    private $activeConnections = [];

    /** @var int|null */
    private $activeShardId;

    /** @var mixed[] */
    private $connectionParameters = [];

    /**
     * {@inheritDoc}
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $params, Driver $driver, ?Configuration $config = null, ?EventManager $eventManager = null)
    {
        if (! isset($params['global'], $params['shards'])) {
            throw new InvalidArgumentException("Connection Parameters require 'global' and 'shards' configurations.");
        }

        if (! isset($params['shardChoser'])) {
            throw new InvalidArgumentException("Missing Shard Choser configuration 'shardChoser'");
        }

        if (is_string($params['shardChoser'])) {
            $params['shardChoser'] = new $params['shardChoser']();
        }

        if (! ($params['shardChoser'] instanceof ShardChoser)) {
            throw new InvalidArgumentException("The 'shardChoser' configuration is not 