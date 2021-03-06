<?php

namespace Doctrine\DBAL\Driver\SQLSrv;

use Doctrine\DBAL\Driver\AbstractDriverException;
use const SQLSRV_ERR_ERRORS;
use function rtrim;
use function sqlsrv_errors;

class SQLSrvException extends AbstractDriverException
{
    /**
     * Helper method to turn sql server errors into exception.
     *
     * @return \Doctrine\DBAL\Driver\SQLSrv\SQLSrvException
     */
    public static function fromSqlSrvErrors()
    {
        $errors    = sqlsrv_errors(SQLSRV_ERR_ERRORS);
        $message   = '';
        $sqlState  = null;
        $errorCode = null;

        foreach ($errors as $error) {
            $message .= 'SQLSTATE [' . $error['SQLSTATE'] . ', ' . $error['code'] . ']: ' . $error['message'] . "\n";

            if ($sqlState === null) {
                $sqlState = $error['SQLSTATE'];
            }

            if ($errorCode !== null) {
                continue;
            }

            $errorCode = $error['code'];
        }
        if (! $message) {
            $message = 'SQL Server error occurred but no error message was retrieved from driver.';
        }

        return new self(rtrim($message), $sqlState, $errorCode);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

namespace Doctrine\DBAL\Driver\SQLSrv;

use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Driver\StatementIterator;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\ParameterType;
use IteratorAggregate;
use PDO;
use const SQLSRV_ENC_BINARY;
use const SQLSRV_ERR_ERRORS;
use const SQLSRV_FETCH_ASSOC;
use const SQLSRV_FETCH_BOTH;
use const SQLSRV_FETCH_NUMERIC;
use const SQLSRV_PARAM_IN;
use function array_key_exists;
use function count;
use function func_get_args;
use function in_array;
use function is_numeric;
use function sqlsrv_errors;
use function sqlsrv_execute;
use function sqlsrv_fetch;
use function sqlsrv_fetch_array;
use function sqlsrv_fetch_object;
use function sqlsrv_get_field;
use function sqlsrv_next_result;
use function sqlsrv_num_fields;
use function SQLSRV_PHPTYPE_STREAM;
use function SQLSRV_PHPTYPE_STRING;
use function sqlsrv_prepare;
use function sqlsrv_rows_affected;
use function SQLSRV_SQLTYPE_VARBINARY;
use function stripos;

/**
 * SQL Server Statement.
 */
class SQLSrvStatement implements IteratorAggregate, Statement
{
    /**
     * The SQLSRV Resource.
     *
     * @var resource
     */
    private $conn;

    /**
     * The SQL statement to execute.
     *
     * @var string
     */
    private $sql;

    /**
     * The SQLSRV statement resource.
     *
     * @var resource|null
     */
    private $stmt;

    /**
     * References to the variables bound as statement parameters.
     *
     * @var mixed
     */
    private $variables = [];

    /**
     * Bound parameter types.
     *
     * @var int[]
     */
    private $types = [];

    /**
     * Translations.
     *
     * @var int[]
     */
    private static $fetchMap = [
        FetchMode::MIXED       => SQLSRV_FETCH_BOTH,
        FetchMode::ASSOCIATIVE => SQLSRV_FETCH_ASSOC,
        FetchMode::NUMERIC     => SQLSRV_FETCH_NUMERIC,
    ];

    /**
     * The name of the default class to instantiate when fetching class instances.
     *
     * @var string
     */
    private $defaultFetchClass = '\stdClass';

    /**
     * The constructor arguments for the default class to instantiate when fetching class instances.
     *
     * @var mixed[]
     */
    private $defaultFetchClassCtorArgs = [];

    /**
     * The fetch style.
     *
     * @var int
     */
    private $defaultFetchMode = FetchMode::MIXED;

    /**
     * The last insert ID.
     *
     * @var LastInsertId|null
     */
    private $lastInsertId;

    /**
     * Indicates whether the statement is in the state when fetching results is possible
     *
     * @var bool
     */
    private $result = false;

    /**
     * Append to any INSERT query