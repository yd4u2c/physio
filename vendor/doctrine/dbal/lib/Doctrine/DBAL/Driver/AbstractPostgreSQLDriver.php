to prevent exceptional situation
        if (! $this->result) {
            return false;
        }

        $args      = func_get_args();
        $fetchMode = $fetchMode ?: $this->defaultFetchMode;

        if ($fetchMode === FetchMode::COLUMN) {
            return $this->fetchColumn();
        }

        if (isset(self::$fetchMap[$fetchMode])) {
            return sqlsrv_fetch_array($this->stmt, self::$fetchMap[$fetchMode]) ?: false;
        }

        if (in_array($fetchMode, [FetchMode::STANDARD_OBJECT, FetchMode::CUSTOM_OBJECT], true)) {
            $className = $this->defaultFetchClass;
            $ctorArgs  = $this->defaultFetchClassCtorArgs;

            if (count($args) >= 2) {
                $className = $args[1];
                $ctorArgs  = $args[2] ?? [];
            }

            return sqlsrv_fetch_object($this->stmt, $className, $ctorArgs) ?: false;
        }

        throw new SQLSrvException('Fetch mode is not supported!');
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        $rows = [];

        switch ($fetchMode) {
            case FetchMode::CUSTOM_OBJECT:
                while (($row = $this->fetch(...func_get_args())) !== false) {
                    $rows[] = $row;
                }
                break;

            case FetchMode::COLUMN:
                while (($row = $this->fetchColumn()) !== false) {
                    $rows[] = $row;
                }
                break;

            default:
                while (($row = $this->fetch($fetchMode)) !== false) {
                    $rows[] = $row;
                }
        }

        return $rows;
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn($columnIndex = 0)
    {
        $row = $this->fetch(FetchMode::NUMERIC);

        if ($row === false) {
            return false;
        }

        return $row[$columnIndex] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function rowCount()
    {
        return sqlsrv_rows_affected($this->stmt);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Doctrine\DBAL\Event;

use Doctrine\Common\EventArgs;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;

/**
 * Event Arguments used when a Driver connection is established inside Doctrine\DBAL\Connection.
 */
class ConnectionEventArgs extends EventArgs
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return Driver
     */
    public function getDriver