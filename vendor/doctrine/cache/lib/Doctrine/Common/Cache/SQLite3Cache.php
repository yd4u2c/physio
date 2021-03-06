tableName, $identifier, $types);
    }

    /**
     * {@inheritDoc}
     */
    public function close()
    {
        unset($this->connections['master'], $this->connections['slave']);

        parent::close();

        $this->_conn       = null;
        $this->connections = ['master' => null, 'slave' => null];
    }

    /**
     * {@inheritDoc}
     */
    public function update($tableName, array $data, array $identifier, array $types = [])
    {
        $this->connect('master');

        return parent::update($tableName, $data, $identifier, $types);
    }

    /**
     * {@inheritDoc}
     */
    public function insert($tableName, array $data, array $types = [])
    {
        $this->connect('master');

        return parent::insert($tableName, $data, $types);
    }

    /**
     * {@inheritDoc}
     */
    public function exec($statement)
    {
        $this->connect('master');

        return parent::exec($statement);
    }

    /**
     * {@inheritDoc}
     */
    public function createSavepoint($savepoint)
    {
        $this->connect('master');

        parent::createSavepoint($savepoint);
    }

    /**
     * {@inheritDoc}
     */
    public function releaseSavepoint($savepoint)
    {
        $this->connect('master');

        parent::releaseSavepoint($savepoint);
    }

    /**
     * {@inheritDoc}
     */
    public function rollbackSavepoint($savepoint)
    {
        $this->connect('master');

        parent::rollbackSavepoint($savepoint);
    }

    /**
     * {@inheritDoc}
     */
    public function query()
    {
        $this->connect('master');

        $args = func_get_args();

        $logger = $this->getConfiguration()->getSQLLogger();
        if ($logger) {
            $logger->startQuery($args[0]);
        }

        $statement = $this->_conn->query(...$args);

        $statement->setFetchMode($this->defaultFetchMode);

        if ($logger) {
            $logger->stopQuery();
        }

        return $statement;
    }

    /**
     * {@inheritDoc}
     */
    public function prepare($statement)
    {
        $this->connect('master');

        return parent::prepare($statement);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\DB2Platform;
use Doctrine\DBAL\Schema\DB2SchemaManager;

/**
 * Abstract base implementation of the {@link Doctrine\DBAL\Driver} interface for IBM DB2 based drivers.
 */
abstract class AbstractDB2Driver implements Driver
{
    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();

        return $params['dbname'];
    }

    /**
     * {@inheritdoc