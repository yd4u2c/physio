 /**
     * {@inheritdoc}
     */
    public function exec($statement)
    {
        if ($this->conn->query($statement) === false) {
            throw new MysqliException($this->conn->error, $this->conn->sqlstate, $this->conn->errno);
        }

        return $this->conn->affected_rows;
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        return $this->conn->insert_id;
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction()
    {
        $this->conn->query('START TRANSACTION');

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        return $this->conn->commit();
    }

    /**
     * {@inheritdoc}non-PHPdoc)
     */
    public function rollBack()
    {
        return $this->conn->rollback();
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
        return $this->conn->errno;
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo()
    {
        return $this->conn->error;
    }

    /**
     * Apply the driver options to the connection.
     *
     * @param mixed[] $driverOptions
     *
     * @throws MysqliException When one of of the options is not supported.
     * @throws MysqliException When applying doesn't work - e.g. due to incorrect value.
     */
    private function setDriverOptions(array $driverOptions = [])
    {
        $supportedDriverOptions = [
            MYSQLI_OPT_CONNECT_TIMEOUT,
            MYSQLI_OPT_LOCAL_INFILE,
            MYSQLI_INIT_COMMAND,
            MYSQLI_READ_DEFAULT_FILE,
            MYSQLI_READ_DEFAULT_GROUP,
        ];

        if (defined('MYSQLI_SERVER_PUBLIC_KEY')) {
            $supportedDriverOptions[] = MYSQLI_SERVER_PUBLIC_KEY;
        }

        $exceptionMsg = "%s option '%s' with value '%s'";

        foreach ($driverOptions as $option => $value) {
            if ($option === static::OPTION_FLAGS) {
                continue;
            }

            if (! in_array($option, $supportedDriverOptions, true)) {
                throw new MysqliException(
                    sprintf($exceptionMsg, 'Unsupported', $option, $value)
                );
            }

            if (@mysqli_options($this->conn, $option, $value)) {
                continue;
            }

            $msg  = sprintf($exceptionMsg, 'Failed to set', $option, $value);
            $msg .= sprintf(', error: %s (%d)', mysqli_error($this->conn), mysqli_errno($this->conn));

            throw new MysqliException(
                $msg,
                $this->conn->sqlstate,
                $this->conn->errno
            );
        }
    }

    /**
     * Pings the server and re-connects when `mysqli.reconnect = 1`
     *
     * @return bool
     */
    public function ping()
    {
        return $this->conn->ping();
    }

    /**
     * Establish a secure connection
     *
     * @param mixed[] $params
     *
     * @throws MysqliException
     */
    private function setSecureConnection(array $params)
    {
        if (! isset($params['ssl_key']) &&
            ! isset($params['ssl_cert']) &&
            ! isset($params['ssl_ca']) &&
            ! isset($params['ssl_capath']) &&
            ! isset($params['ssl_cipher'])
        ) {
            return;
        }

        $this->conn->ssl_set(
            $params['ssl_key']    ?? null,
            $params['ssl_cert']   ?? null,
            $params['ssl_ca']     ?? null,
            $params['ssl_capath'] ?? null,
            $params['ssl_cipher'] ?? null
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Doctrine\DBAL\Driver\Mysqli;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Driver\StatementIterator;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use mysqli;
use mysqli_stmt;
use PDO;
use stdClass;
use function array_combine;
use function array_fill;
use function count;
use function feof;
use function fread;
use function get_resource_type;
use function is_resource;
use function sprintf;
use function str_repeat;

class MysqliStatement implements IteratorAggregate, Statement
{
    /** @var string[] */
    protected static $_paramTypeMap = [
        ParameterType::STRING       => 's',
        ParameterType::BINARY       => 's',
        ParameterType::BOOLEAN      => 'i',
        ParameterType::NULL         => 's',
        ParameterType::INTEGER      => 'i',
        ParameterType::LARGE_OBJECT => 'b',
    ];

    /** @var mysqli */
    protected $_conn;

    /** @var mysqli_stmt */
    protected $_stmt;

    /** @var string[]|bool|null */
    protected $_columnNames;

    /** @var mixed[]|null */
    protected $_rowBindedValues;

    /** @var mixed[] */
    protected $_bindedValues;

    /** @var string */
    protected $types;

    /**
     * Contains ref values for bindValue().
     *
     * @var mixed[]
     */
    protected $_values = [];

    /** @var int */
    protected $_defaultFetchMode = FetchMode::MIXED;

    /**
     * Indicates whether the statement is in the state when fetching results is possible
     *
     * @var bool
     */
    private $result = false;

    /**
     * @param string $prepareString
     *
     * @throws MysqliException
     */
    public function __construct(mysqli $conn, $prepareString)
    {
        $this->_conn = $conn;
        $this->_stmt = $conn->prepare($prepareString);
        if ($this->_stmt === false) {
            throw new MysqliException($this->_conn->error, $this->_conn->sqlstate, $this->_conn->errno);
        }

        $paramCount = $this->_stmt->param_count;
        if (0 >= $paramCount) {
            return;
        }

        $this->types         = str_repeat('s', $paramCount);
        $this->_bindedValues = array_fill(1, $paramCount, null);
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($column, &$variable, $type = ParameterType::STRING, $length = null)
    {
        if ($type === null) {
            $type = 's';
        } else {
            if (! isset(self::$_paramTypeMap[$type])) {
                throw new MysqliException(sprintf("Unknown type: '%s'", $type));
            }

            $type = self::$_paramTypeMap[$type];
        }

        $this->_bindedValues[$column] =& $variable;
        $this->types[$column - 1]     = $type;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($param, $value, $type = ParameterType::STRING)
    {
        if ($type === null) {
            $type = 's';
        } else {
            if (! isset(self::$_paramTypeMap[$type])) {
                throw new MysqliException(sprintf("Unknown type: '%s'", $type));
            }

            $type = self::$_paramTypeMap[$type];
        }

        $this->_values[$param]       = $value;
        $this->_bindedValues[$param] =& $this->_values[$param];
        $this->types[$param - 1]     = $type;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($params = null)
    {
        if ($this->_bindedValues !== null) {
            if ($params !== null) {
                if (! $this->_bindValues($params)) {
                    throw new MysqliException($this->_stmt->error, $this->_stmt->errno);
                }
            } else {
                [$types, $values, $streams] = $this->separateBoundValues();
                if (! $this->_stmt->bind_param($types, ...$values)) {
                    throw new MysqliException($this->_stmt->error, $this->_stmt->sqlstate, $this->_stmt->errno);
                }
                $this->sendLongData($streams);
            }
        }

        if (! $this->_stmt->execute()) {
            throw new MysqliException($this->_stmt->error, $this->_stmt->sqlstate, $this->_stmt->errno);
        }

        if ($this->_columnNames === null) {
            $meta = $this->_stmt->result_metadata();
            if ($meta !== false) {
                $columnNames = [];
                foreach ($meta->fetch_fields() as $col) {
                    $columnNames[] = $col->name;
                }
                $meta->free();

                $this->_columnNames = $columnNames;
 