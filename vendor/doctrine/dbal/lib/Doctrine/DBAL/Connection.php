$cursorOrientation);
            }

            return parent::fetch($fetchMode, $cursorOrientation, $cursorOffset);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null)
    {
        $fetchMode = $this->convertFetchMode($fetchMode);

        try {
            if ($fetchMode === null && $fetchArgument === null && $ctorArgs === null) {
                return parent::fetchAll();
            }

            if ($fetchArgument === null && $ctorArgs === null) {
                return parent::fetchAll($fetchMode);
            }

            if ($ctorArgs === null) {
                return parent::fetchAll($fetchMode, $fetchArgument);
            }

            return parent::fetchAll($fetchMode, $fetchArgument, $ctorArgs);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function fetchColumn($columnIndex = 0)
    {
        try {
            return parent::fetchColumn($columnIndex);
        } catch (\PDOException $exception) {
            throw new PDOException($exception);
        }
    }

    /**
     * Converts DBAL parameter type to PDO parameter type
     *
     * @param int $type Parameter type
     */
    private function convertParamType(int $type) : int
    {
        if (! isset(self::PARAM_TYPE_MAP[$type])) {
            // TODO: next major: throw an exception
            @trigger_error(sprintf(
                'Using a PDO parameter type (%d given) is deprecated and will cause an error in Doctrine 3.0',
                $type
            ), E_USER_DEPRECATED);

            return $type;
        }

        return self::PARAM_TYPE_MAP[$type];
    }

    /**
     * Converts DBAL fetch mode to PDO fetch mode
     *
     * @param int|null $fetchMode Fetch mode
     */
    private function convertFetchMode(?int $fetchMode) : ?int
    {
        if ($fetchMode === null) {
            return null;
        }

        if (! isset(self::FETCH_MODE_MAP[$fetchMode])) {
            // TODO: next major: throw an exception
            @trigger_error(sprintf(
                'Using a PDO fetch mode or their combination (%d given)' .
                ' is deprecated and will cause an error in Doctrine 3.0',
                $fetchMode
            ), E_USER_DEPRECATED);

            return $fetchMode;
        }

        return self::FETCH_MODE_MAP[$fetchMode];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Doctrine\DBAL\Driver;

use PDO;
use Traversable;

/**
 * Interface for the reading part of a prepare statement only.
 */
interface ResultStatement extends Traversable
{
    /**
     * Closes the cursor, enabling the statement to be executed again.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function closeCursor();

    /**
     * Returns the number of columns in the result set
     *
     * @return int The number of columns in the result set represented
     *                 by the PDOStatement object. If there is no result set,
     *                 this method should return 0.
     */
    public function columnCount();

    /**
     * Sets the fetch mode to use while iterating this statement.
     *
     * @param int   $fetchMode The fetch mode must be one of the {@link \Doctrine\DBAL\FetchMode} constants.
     * @param mixed $arg2
     * @param mixed $arg3
     *
     * @return bool
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null);

    /**
     * Returns the next row of a result set.
     *
     * @param int|null $fetchMode         Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     * @param int      $cursorOrientation For a ResultStatement object representing a scrollable cursor,
     *                                    this value determines which row will be returned to the caller.
     *                                    This value must be one of the \PDO::FETCH_ORI_* constants,
     *                                    defaulting to \PDO::FETCH_ORI_NEXT. To request a scrollable
     *                                    cursor for your ResultStatement object, you must set the \PDO::ATTR_CURSOR
     *                                    attribute to \PDO::CURSOR_SCROLL when you prepare the SQL statement with
     *                                    \PDO::prepare().
     * @param int      $cursorOffset      For a ResultStatement object representing a scrollable cursor for which the
     *                                    cursorOrientation parameter is set to \PDO::FETCH_ORI_ABS, this value
     *                                    specifies the absolute number of the row in the result set that shall be
     *                                    fetched.
     *                                    For a ResultStatement object representing a scrollable cursor for which the
     *                                    cursorOrientation parameter is set to \PDO::FETCH_ORI_REL, this value
     *                                    specifies the row to fetch relative to the cursor position before
     *                                    ResultStatement::fetch() was called.
     *
     * @return mixed The return value of this method on success depends on the fetch mode. In all cases, FALSE is
     *               returned on failure.
     */
    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0);

    /**
     * Returns an array containing all of the result set rows.
     *
     * @param int|null     $fetchMode     Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     * @param int|null     $fetchArgument This argument has a different meaning depending on the value of the $fetchMode parameter:
     *                                    * {@link \Doctrine\DBAL\FetchMode::COLUMN}:
     *                                      Returns the indicated 0-indexed column.
     *                                    * {@link \Doctrine\DBAL\FetchMode::CUSTOM_OBJECT}:
     *                                      Returns instances of the specified class, mapping the columns of each row
     *                                      to named properties in the class.
     *                                    * \PDO::FETCH_FUNC: Returns the results of calling the specified function, using each row's
     *                                      columns as parameters in the call.
     * @param mixed[]|null $ctorArgs      Controls how the next row will be returned to the caller.
     *                                    The value must be one of the {@link \Doctrine\DBAL\FetchMode} constants,
     *                                    defaulting to {@link \Doctrine\DBAL\FetchMode::MIXED}.
     *
     * @return mixed[]
     */
    public function fetchAll($fetchMode = null, $fetchArgument = null, $ctorArgs = null);

    /**
     * Returns a single column from the next row of a result set or FALSE if there are no more rows.
     *
     * @param int $columnIndex 0-indexed number of the column you wish to retrieve from the row.
     *                         If no value is supplied, fetches the first column.
     *
     * @return mixed|false A single column in the next row of a result set, or FALSE if there are no more rows.
     */
    public function fetchColumn($columnIndex = 0);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\ParameterType;

/**
 * Statement interface.
 * Drivers must implement this interface.
 *
 * This resembles (a subset of) the PDOStatement interface.
 */
interface Statement extends ResultStatement
{
    /**
     * Binds a value to a corresponding named (not supported by mysqli driver, see comment below) or positional
     * placeholder in the SQL statement that was used to prepare the statement.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * @param mixed $param Parameter identifier. For a prepared statement using named placeholders,
     *                     this will be a parameter name of the form :name. For a prepared statement
     *                     using question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed $value The value to bind to the parameter.
     * @param int   $type  Explicit data type for the parameter using the {@link \Doctrine\DBAL\ParameterType}
     *                     constants.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function bindValue($param, $value, $type = ParameterType::STRING);

    /**
     * Binds a PHP variable to a corresponding named (not supported by mysqli driver, see comment below) or question
     * mark placeholder in the SQL statement that was use to prepare the statement. Unlike PDOStatement->bindValue(),
     * the variable is bound as a reference and will only be evaluated at the time
     * that PDOStatement->execute() is called.
     *
     * As mentioned above, the named parameters are not natively supported by the mysqli driver, use executeQuery(),
     * fetchAll(), fetchArray(), fetchColumn(), fetchAssoc() methods to have the named parameter emulated by doctrine.
     *
     * Most parameters are input parameters, that is, parameters that are
     * used in a read-only fashion to build up the query. Some drivers support the invocation
     * of stored procedures that return data as output parameters, and some also as input/output
     * parameters that both send in data and are updated to receive it.
     *
     * @param mixed    $column   Parameter identifier. For a prepared statement using named placeholders,
     *                           this will be a parameter name of the form :name. For a prepared statement using
     *                           question mark placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed    $variable Name of the PHP variable to bind to the SQL statement parameter.
     * @param int|null $type     Explicit data type for the parameter using the {@link \Doctrine\DBAL\ParameterType}
     *                           constants. To return an INOUT parameter from a stored procedure, use the bitwise
     *                           OR operator to set the PDO::PARAM_INPUT_OUTPUT bits for the data_type parameter.
     * @param int|null $length   You must specify maxlength when using an OUT bind
     *                           so that PHP allocates enough memory to hold the returned value.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null);

    /**
     * Fetches the SQLSTATE associated with the last operation on the statement handle.
     *
     * @see Doctrine_Adapter_Interface::errorCode()
     *
     * @return string|int|bool The error code string.
     */
    public function errorCode();

    /**
     * Fetches extended error information associated with the last operation on the statement handle.
     *
     * @return mixed[] The error info array.
     */
    public function errorInfo();

    /**
     * Executes a prepared statement
     *
     * If the prepared statement included parameter markers, you must either:
     * call PDOStatement->bindParam() to bind PHP variables to the parameter markers:
     * bound variables pass their value as input and receive the output value,
     * if any, of their associated parameter markers or pass an array of input-only
     * parameter values.
     *
     * @param mixed[]|null $params An array of values with as many elements as there are
     *                             bound parameters in the SQL statement being executed.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function execute($params = null);

    /**
     * Returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement
     * executed by the corresponding object.
     *
     * If the last SQL statement executed by the associated Statement object was a SELECT statement,
     * some databases may return the number of rows returned by that statement. However,
     * this behaviour is not guaranteed for all databases and should not be
     * relied on for portable applications.
     *
     * @return int The number of rows.
     */
    public function rowCount();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

declare(strict_types=1);

namespace Doctrine\DBAL\Driver\AbstractOracleDriver;

use function implode;
use function is_array;
use function sprintf;

/**
 * Represents an Oracle Easy Connect string
 *
 * @link https://docs.oracle.com/database/121/NETAG/naming.htm
 */
final class EasyConnectString
{
    /** @var string */
    private $string;

    private function __construct(string $string)
    {
        $this->string = $string;
    }

    public function __toString() : string
    {
        return $this->string;
    }

    /**
     * Creates the object from an array representation
     *
     * @param mixed[] $params
     */
    public static function fromArray(array $params) : self
    {
        return new self(self::renderParams($params));
    }

    /**
     * Creates the object from the given DBAL connection parameters.
     *
     * @param mixed[] $params
     */
    public static function fromConnectionParameters(array $params) : self
    {
        if (! empty($params['connectstring'])) {
            return new self($params['connectstring']);
        }

        if (empty($params['host'])) {
            return new self($params['dbname'] ?? '');
        }

        $connectData = [];

        if (isset($params['servicename']) || isset($params['dbname'])) {
            $serviceKey = 'SID';

            if (! empty($params['service'])) {
                $serviceKey = 'SERVICE_NAME';
            }

            $serviceName = $params['servicename'] ?? $params['dbname'];

            $connectData[$serviceKey] = $serviceName;
        }

        if (! empty($params['instancename'])) {
            $connectData['INSTANCE_NAME'] = $params['instancename'];
        }

        if (! empty($params['pooled'])) {
            $connectData['SERVER'] = 'POOLED';
        }

        return self::fromArray([
            'DESCRIPTION' => [
                'ADDRESS' => [
                    'PROTOCOL' => 'TCP',
                    'HOST' => $params['host'],
                    'PORT' => $params['port'] ?? 1521,
                ],
                'CONNECT_DATA' => $connectData,
            ],
        ]);
    }

    /**
     * @param mixed[] $params
     */
    private static function renderParams(array $params) : string
    {
        $chunks = [];

        foreach ($params as $key => $value) {
            $string = self::renderValue($value);

            if ($string === '') {
                continue;
            }

            $chunks[] = sprintf('(%s=%s)', $key, $string);
        }

        return implode('', $chunks);
    }

    /**
     * @param mixed $value
     */
    private static function renderValue($value) : string
    {
        if (is_array($value)) {
            return self::renderParams($value);
        }

        return (string) $value;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Doctrine\DBAL\Driver\DrizzlePDOMySql;

use Doctrine\DBAL\Platforms\DrizzlePlatform;
use Doctrine\DBAL\Schema\DrizzleSchemaManager;

/**
 * Drizzle driver using PDO MySql.
 */
class Driver extends \Doctrine\DBAL\Driver\PDOMySql\Driver
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        return new Connection(
            $this->constructPdoDsn($params),
            $username,
            $password,
            $driverOptions
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createDatabasePlatformForVersion($version)
    {
        return $this->getDatabasePlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new DrizzlePlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(\Doctrine\DBAL\Connection $conn)
    {
        return new DrizzleSchemaManager($conn);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'drizzle_pdo_mysql';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

namespace Doctrine\DBAL\Driver\IBMDB2;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Driver\ServerInfoAwareConnection;
use Doctrine\DBAL\ParameterType;
use stdClass;
use const DB2_AUTOCOMMIT_OFF;
use const DB2_AUTOCOMMIT_ON;
use function db2_autocommit;
use function db2_commit;
use function db2_conn_error;
use function db2_conn_errormsg;
use function db2_connect;
use function db2_escape_string;
use function db2_exec;
use function db2_last_insert_id;
use function db2_num_rows;
use function db2_pconnect;
use function db2_prepare;
use function db2_rollback;
use function db2_server_info;
use function db2_stmt_errormsg;
use function func_get_args;

class DB2Connection implements Connection, ServerInfoAwareConnection
{
    /** @var resource */
    private $conn = null;

    /**
     * @param mixed[] $params
     * @param string  $username
     * @param string  $password
     * @param mixed[] $driverOptions
     *
     * @throws DB2Exception
     */
    public function __construct(array $params, $username, $password, $driverOptions = [])
    {
        $isPersistent = (isset($params['persistent']) && $params['persistent'] === true);

        if ($isPersistent) {
            $this->conn = db2_pconnect($params['dbname'], $username, $password, $driverOptions);
        } else {
            $this->conn = db2_connect($params['dbname'], $username, $password, $driverOptions);
        }
        if (! $this->conn) {
            throw new DB2Exception(db2_conn_errormsg());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getServerVersion()
    {
        /** @var stdClass $serverInfo */
        $serverInfo = db2_server_info($this->conn);

        return $serverInfo->DBMS_VER;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresQueryForServerVersion()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function prepare($sql)
    {
        $stmt = @db2_prepare($this->conn, $sql);
        if (! $stmt) {
            throw new DB2Exception(db2_stmt_errormsg());
        }

        return new DB2Statement($stmt);
    }

    /**
     * {@inheritdoc}
     */
    public function query()
    {
        $args = func_get_args();
        $sql  = $args[0];
        $stmt = $this->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    /**
     * {@inheritdoc}
     */
    public function quote($input, $type = ParameterType::STRING)
    {
        $input = db2_escape_string($input);

        if ($type === ParameterType::INTEGER) {
            return $input;
        }

        return "'" . $input . "'";
    }

    /**
     * {@inheritdoc}
     */
    public function exec($statement)
    {
        $stmt = @db2_exec($this->conn, $statement);

        if ($stmt === false) {
            throw new DB2Exception(db2_stmt_errormsg());
        }

        return db2_num_rows($stmt);
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        return db2_last_insert_id($this->conn);
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
        db2_autocommit($this->conn, DB2_AUTOCOMMIT_OFF);
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        if (! db2_commit($this->conn)) {
            throw new DB2Exception(db2_conn_errormsg($this->conn));
        }
        db2_autocommit($this->conn, DB2_AUTOCOMMIT_ON);
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack()
    {
        if (! db2_rollback($this->conn)) {
            throw new DB2Exception(db2_conn_errormsg($this->conn));
        }
        db2_autocommit($this->conn, DB2_AUTOCOMMIT_ON);
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
        return db2_conn_error($this->conn);
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
        return [
            0 => db2_conn_errormsg($this->conn),
            1 => $this->errorCode(),
        ];
    }
}
                                                                    <?php

namespace Doctrine\DBAL\Driver\IBMDB2;

use Doctrine\DBAL\Driver\AbstractDB2Driver;

/**
 * IBM DB2 Driver.
 */
class DB2Driver extends AbstractDB2Driver
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        if (! isset($params['protocol'])) {
            $params['protocol'] = 'TCPIP';
        }

        if ($params['host'] !== 'localhost' && $params['host'] !== '127.0.0.1') {
            // if the host isn't localhost, use extended connection params
            $params['dbname'] = 'DRIVER={IBM DB2 ODBC DRIVER}' .
                     ';DATABASE=' . $params['dbname'] .
                     ';HOSTNAME=' . $params['host'] .
                     ';PROTOCOL=' . $params['protocol'] .
                     ';UID=' . $username .
                     ';PWD=' . $password . ';';
            if (isset($params['port'])) {
                $params['dbname'] .= 'PORT=' . $params['port'];
            }

            $username = null;
            $password = null;
        }

        return new DB2Connection($params, $username, $password, $driverOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ibm_db2';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

namespace Doctrine\DBAL\Driver\IBMDB2;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Driver\StatementIterator;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use PDO;
use ReflectionClass;
use ReflectionObject;
use ReflectionProperty;
use stdClass;
use const CASE_LOWER;
use const DB2_BINARY;
use const DB2_CHAR;
use const DB2_LONG;
use const DB2_PARAM_FILE;
use const DB2_PARAM_IN;
use function array_change_key_case;
use function db2_bind_param;
use function db2_execute;
use function db2_fetch_array;
use function db2_fetch_assoc;
use function db2_fetch_both;
use function db2_fetch_object;
use function db2_free_result;
use function db2_num_fields;
use function db2_num_rows;
use function db2_stmt_error;
use function db2_stmt_errormsg;
use function error_get_last;
use function fclose;
use function func_get_args;
use function func_num_args;
use function fwrite;
use function gettype;
use function is_object;
use function is_resource;
use function is_string;
use function ksort;
use function sprintf;
use function stream_copy_to_stream;
use function stream_get_meta_data;
use function strtolower;
use function tmpfile;

class DB2Statement implements IteratorAggregate, Statement
{
    /** @var resource */
    private $stmt;

    /** @var mixed[] */
    private $bindParam = [];

    /**
     * Map of LOB parameter positions to the tuples containing reference to the variable bound to the driver statement
     * and the temporary file handle bound to the underlying statement
     *
     * @var mixed[][]
     */
    private $lobs = [];

    /** @var string Name of the default class to instantiate when fetching class instances. */
    private $defaultFetchClass = '\stdClass';

    /** @var mixed[] Constructor arguments for the default class to instantiate when fetching class instances. */
    private $defaultFetchClassCtorArgs = [];

    /** @var int */
    private $defaultFetchMode = FetchMode::MIXED;

    /**
     * Indicates whether the statement is in the state when fetching results is possible
     *
     * @var bool
     */
    private $result = false;

    /**
     * @param resource $stmt
     */
    public function __construct($stmt)
    {
        $this->stmt = $stmt;
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = ParameterType::STRING)
    {
        return $this->bindParam($param, $value, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null)
    {
        switch ($type) {
            case ParameterType::INTEGER:
                $this->bind($column, $variable, DB2_PARAM_IN, DB2_LONG);
                break;

            case ParameterType::LARGE_OBJECT:
                if (isset($this->lobs[$column])) {
                    [, $handle] = $this->lobs[$column];
                    fclose($handle);
                }

                $handle = $this->createTemporaryFile();
                $path   = stream_get_meta_data($handle)['uri'];

                $this->bind($column, $path, DB2_PARAM_FILE, DB2_BINARY);

                $this->lobs[$column] = [&$variable, $handle];
                break;

            default:
                $this->bind($column, $variable, DB2_PARAM_IN, DB2_CHAR);
                break;
        }

        return true;
    }

    /**
     * @param int|string $parameter Parameter position or name
     * @param mixed      $variable
     *
     * @throws DB2Exception
     */
    private function bind($parameter, &$variable, int $parameterType, int $dataType) : void
    {
        $this->bindParam[$parameter] =& $variable;

        if (! db2_bind_param($this->stmt, $parameter, 'variable', $parameterType, $dataType)) {
            throw new DB2Exception(db2_stmt_errormsg());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function closeCursor()
    {
        if (! $this->stmt) {
            return false;
        }

        $this->bindParam = [];

        if (! db2_free_result($this->stmt)) {
            return false;
        }

        $this->result = false;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function columnCount()
    {
        if (! $this->stmt) {
            return false;
        }

        return db2_num_fields($this->stmt);
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
        return db2_stmt_error();
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
        return [
            db2_stmt_errormsg(),
            db2_stmt_error(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function execute($params = null)
    {
        if (! $this->stmt) {
            return false;
        }

        if ($params === null) {
            ksort($this->bindParam);

            $params = [];

            foreach ($this->bindParam as $column => $value) {
                $params[] = $value;
            }
        }

        foreach ($this->lobs as [$source, $target]) {
            if (is_resource($source)) {
                $this->copyStreamToStream($source, $target);

                continue;
            }

            $this->writeStringToStream($source, $target);
        }

        $retval = db2_execute($this->stmt, $params);

        foreach ($this->lobs as [, $handle]) {
            fclose($handle);
        }

        $this->lobs = [];

        if ($retval === false) {
            throw new DB2Exception(db2_stmt_errormsg());
        }

        $this->result = true;

        return $retval;
    }

    /**
     * {@inheritdoc}
     */
    public function setFetchMode($fetchMode, $arg2 = null, $arg3 = null)
    {
        $this->defaultFetchMode          = $fetchMode;
        $this->defaultFetchClass         = $arg2 ?: $this->defaultFetchClass;
        $this->defaultFetchClassCtorArgs = $arg3 ? (array) $arg3 : $this->defaultFetchClassCtorArgs;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new StatementIterator($this);
    }

    /**
     * {@inheritdoc}
     */
    public function fetch($fetchMode = null, $cursorOrientation = PDO::FETCH_ORI_NEXT, $cursorOffset = 0)
    {
        // do not try fetching from the statement if it's not expected to contain result
        // in order to prevent exceptional situation
        if (! $this->result) {
            return false;
        }

        $fetchMode = $fetchMode ?: $this->defaultFetchMode;
        switch ($fetchMode) {
            case FetchMode::COLUMN:
                return $this->fetchColumn();

            case FetchMode::MIXED:
                return db2_fetch_both($this->stmt);

            case FetchMode::ASSOCIATIVE:
                return db2_fetch_assoc($this->stmt);

            case FetchMode::CUSTOM_OBJECT:
                $className = $this->defaultFetchClass;
                $ctorArgs  = $this->defaultFetchClassCtorArgs;

                if (func_num_args() >= 2) {
                    $args      = func_get_args();
                    $className = $args[1];
                    $ctorArgs  = $args[2] ?? [];
                }

                $result = db2_fetch_object($this->stmt);

                if ($result instanceof stdClass) {
                    $result = $this->castObject($result, $className, $ctorArgs);
                }

                return $result;

            case FetchMode::NUMERIC:
                return db2_fetch_array($this->stmt);

            case FetchMode::STANDARD_OBJECT:
                return db2_fetch_object($this->stmt);

            default:
                throw new DB2Exception('Given Fetch-Style ' . $fetchMode . ' is not supported.');
        }
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
        return @db2_num_rows($this->stmt) ? : 0;
    }

    /**
     * Casts a stdClass object to the given class name mapping its' properties.
     *
     * @param stdClass      $sourceObject     Object to cast from.
     * @param string|object $destinationClass Name of the class or class instance to cast to.
     * @param mixed[]       $ctorArgs         Arguments to use for constructing the destination class instance.
     *
     * @return object
     *
     * @throws DB2Exception
     */
    private function castObject(stdClass $sourceObject, $destinationClass, array $ctorArgs = [])
    {
        if (! is_string($destinationClass)) {
            if (! is_object($destinationClass)) {
                throw new DB2Exception(sprintf(
                    'Destination class has to be of type string or object, %s given.',
                    gettype($destinationClass)
                ));
            }
        } else {
            $destinationClass = new ReflectionClass($destinationClass);
            $destinationClass = $destinationClass->newInstanceArgs($ctorArgs);
        }

        $sourceReflection           = new ReflectionObject($sourceObject);
        $destinationClassReflection = new ReflectionObject($destinationClass);
        /** @var ReflectionProperty[] $destinationProperties */
        $destinationProperties = array_change_key_case($destinationClassReflection->getProperties(), CASE_LOWER);

        foreach ($sourceReflection->getProperties() as $sourceProperty) {
            $sourceProperty->setAccessible(true);

            $name  = $sourceProperty->getName();
            $value = $sourceProperty->getValue($sourceObject);

            // Try to find a case-matching property.
            if ($destinationClassReflection->hasProperty($name)) {
                $destinationProperty = $destinationClassReflection->getProperty($name);

                $destinationProperty->setAccessible(true);
                $destinationProperty->setValue($destinationClass, $value);

                continue;
            }

            $name = strtolower($name);

            // Try to find a property without matching case.
            // Fallback for the driver returning either all uppercase or all lowercase column names.
            if (isset($destinationProperties[$name])) {
                $destinationProperty = $destinationProperties[$name];

                $destinationProperty->setAccessible(true);
                $destinationProperty->setValue($destinationClass, $value);

                continue;
            }

            $destinationClass->$name = $value;
        }

        return $destinationClass;
    }

    /**
     * @return resource
     *
     * @throws DB2Exception
     */
    private function createTemporaryFile()
    {
        $handle = @tmpfile();

        if ($handle === false) {
            throw new DB2Exception('Could not create temporary file: ' . error_get_last()['message']);
        }

        return $handle;
    }

    /**
     * @param resource $source
     * @param resource $target
     *
     * @throws DB2Exception
     */
    private function copyStreamToStream($source, $target) : void
    {
        if (@stream_copy_to_stream($source, $target) === false) {
            throw new DB2Exception('Could not copy source stream to temporary file: ' . error_get_last()['message']);
        }
    }

    /**
     * @param resource $target
     *
     * @throws DB2Exception
     */
    private function writeStringToStream(string $string, $target) : void
    {
        if (@fwrite($target, $string) === false) {
            throw new DB2Exception('Could not write string to temporary file: ' . error_get_last()['message']);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              