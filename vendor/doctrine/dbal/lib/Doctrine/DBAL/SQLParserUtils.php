<?php

namespace Doctrine\DBAL\Driver\PDOIbm;

use Doctrine\DBAL\Driver\AbstractDB2Driver;
use Doctrine\DBAL\Driver\PDOConnection;

/**
 * Driver for the PDO IBM extension.
 */
class Driver extends AbstractDB2Driver
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        return new PDOConnection(
            $this->_constructPdoDsn($params),
            $username,
            $password,
            $driverOptions
        );
    }

    /**
     * Constructs the IBM PDO DSN.
     *
     * @param mixed[] $params
     *
     * @return string The DSN.
     */
    private function _constructPdoDsn(array $params)
    {
        $dsn = 'ibm:';
        if (isset($params['host'])) {
            $dsn .= 'HOSTNAME=' . $params['host'] . ';';
        }
        if (isset($params['port'])) {
            $dsn .= 'PORT=' . $params['port'] . ';';
        }
        $dsn .= 'PROTOCOL=TCPIP;';
        if (isset($params['dbname'])) {
            $dsn .= 'DATABASE=' . $params['dbname'] . ';';
        }

        return $dsn;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pdo_ibm';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Doctrine\DBAL\Driver\PDOMySql;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\AbstractMySQLDriver;
use Doctrine\DBAL\Driver\PDOConnection;
use PDOException;

/**
 * PDO MySql driver.
 */
class Driver extends AbstractMySQLDriver
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        try {
            $conn = new PDOConnection(
                $this->constructPdoDsn($params),
                $username,
                $password,
                $driverOptions
            );
        } catch (PDOException $e) {
            throw DBALException::driverException($this, $e);
        }

        return $conn;
    }

    /**
     * Constructs the MySql PDO DSN.
     *
     * @param mixed[] $params
     *
     * @return string The DSN.
     */
    protected function constructPdoDsn(array $params)
    {
        $dsn = 'mysql:';
        if (isset($params['host']) && $params['host'] !== '') {
            $dsn .= 'host=' . $params['host'] . ';';
        }
        if (isset($params['port'])) {
            $dsn .= 'port=' . $params['port'] . ';';
        }
        if (isset($params['dbname'])) {
            $dsn .= 'dbname=' . $params['dbname'] . ';';
        }
        if (isset($params['unix_socket'])) {
            $dsn .= 'unix_socket=' . $params['unix_socket'] . ';';
        }
        if (isset($params['charset'])) {
            $dsn .= 'charset=' . $params['charset'] . ';';
        }

        return $dsn;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pdo_mysql';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Doctrine\DBAL\Driver\PDOOracle;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\AbstractOracleDriver;
use Doctrine\DBAL\Driver\PDOConnection;
use PDOException;

/**
 * PDO Oracle driver.
 *
 * WARNING: This driver gives us segfaults in our testsuites on CLOB and other
 * stuff. PDO Oracle is not maintained