<?php

namespace Doctrine\DBAL\Event;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\Index;

/**
 * Event Arguments used when the portable index definition is generated inside Doctrine\DBAL\Schema\AbstractSchemaManager.
 */
class SchemaIndexDefinitionEventArgs extends SchemaEventArgs
{
    /** @var Index|null */
    private $index = null;

    /**
     * Raw index data as fetched from the database.
     *
     * @var mixed[]
     */
    private $tableIndex;

    /** @var string */
    private $table;

    /** @var Connection */
    private $connection;

    /**
     * @param mixed[] $tableIndex
     * @param string  $table
     */
    public function __construct(array $tableIndex, $table, Connection $connection)
    {
        $this->tableIndex = $tableIndex;
        $this->table      = $table;
        $this->connection = $connection;
    }

    /**
     * Allows to clear the index which means the index will be excluded from tables index list.
     *
     * @return SchemaIndexDefinitionEventArgs
     */
    public function setIndex(?Index $index = null)
    {
        $this->index = $index;

        return $this;
    }

    /**
     * @return Index|null
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return mixed[]
     */
    public function getTableIndex()
    {
        return $this->tableIndex;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return AbstractPlatform
     */
    public function getDatabasePlatform()
    {
        return $this->connection->getDatabasePlatform();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Doctrine\DBAL\Event\Listeners;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Event\ConnectionEventArgs;
use Doctrine\DBAL\Events;

/**
 * MySQL Session Init Event Subscriber which allows to set the Client Encoding of the Connection.
 *
 * @deprecated Use "charset" option to PDO MySQL Connection instead.
 */
class MysqlSessionInit implements EventSubscriber
{
    /**
     * The charset.
     *
     * @var string
     */
    private $charset;

    /**
     * The collation, or FALSE if no collation.
     *
     * @var string|bool
     */
    private $collation;

    /**
     * Configure Charset and Collation options of MySQL Client for each Connection.
     *
     * @param string      $charset   The charset.
     * @param string|bool $collation The collation, or FALSE if no collation.
     */
    public function __construct($charset = 'utf8', $collation = false)
    {
        $this->charset   = $charset;
        $this->collation = $collation;
    }

    /**
     * @return void
     */
    public function postConnect(ConnectionEventArgs $args)
    {
        $collation = $this->collation ? ' COLLATE ' . $this->collation : '';
        $args->getConnection()->executeUpdate('SET NAMES ' . $this->charset . $collation);
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [Events::postConnect];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  