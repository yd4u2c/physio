<?php

namespace Doctrine\DBAL\Logging;

/**
 * Chains multiple SQLLogger.
 */
class LoggerChain implements SQLLogger
{
    /** @var SQLLogger[] */
    private $loggers = [];

    /**
     * Adds a logger in the chain.
     *
     * @return void
     */
    public function addLogger(SQLLogger $logger)
    {
        $this->loggers[] = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function startQuery($sql, ?array $params = null, ?array $types = null)
    {
        foreach ($this->loggers as $logger) {
            $logger->startQuery($sql, $params, $types);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function stopQuery()
    {
        foreach ($this->loggers as $logger) {
            $logger->stopQuery();
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\Common\EventManager;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Event\SchemaAlterTableAddColumnEventArgs;
use Doctrine\DBAL\Event\SchemaAlterTableChangeColumnEventArgs;
use Doctrine\DBAL\Event\SchemaAlterTableEventArgs;
use Doctrine\DBAL\Event\SchemaAlterTableRemoveColumnEventArgs;
use Doctrine\DBAL\Event\SchemaAlterTableRenameColumnEventArgs;
use Doctrine\DBAL\Event\SchemaCreateTableColumnEventArgs;
use Doctrine\DBAL\Event\SchemaCreateTableEventArgs;
use Doctrine\DBAL\Event\SchemaDropTableEventArgs;
use Doctrine\DBAL\Events;
use Doctrine\DBAL\Platforms\Keywords\KeywordList;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ColumnDiff;
use Doctrine\DBAL\Schema\Constraint;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Identifier;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\TransactionIsolationLevel;
use Doctrine\DBAL\Types;
use Doctrine\DBAL\Types\Type;
use InvalidArgumentException;
use const E_USER_DEPRECATED;
use function addcslashes;
use function array_map;
use function array_merge;
use function array_unique;
use function array_values;
use function count;
use function explode;
use function func_get_arg;
use function func_get_args;
use function func_num_args;
use function implode;
use function in_array;
use function is_array;
use function is_bool;
use function is_int;
use function is_string;
use function preg_quote;
use function preg_replace;
use function sprintf;
use function str_replace;
use function strlen;
use function strpos;
use function strtolower;
use function strtoupper;
use function trigger_error;

/**
 * Base class for all DatabasePlatforms. The DatabasePlatforms are the central
 * point of abstraction of platform-specific behaviors, features and SQL dialects.
 * They are a passive source of information.
 *
 * @todo Remove any unnecessary methods.
 */
abstract class AbstractPlatform
{
    public const CREATE_INDEXES = 1;

    public const CREATE_FOREIGNKEYS = 2;

    /**
     * @deprecated Use DateIntervalUnit::INTERVAL_UNIT_SECOND.
     */
    public const DATE_INTERVAL_UNIT_SECOND = DateIntervalUnit::SECOND;

    /**
     * @deprecated Use DateIntervalUnit::MINUTE.
     */
    public const DATE_INTERVAL_UNIT_MINUTE = DateIntervalUnit::MINUTE;

    /**
     * @deprecated Use DateIntervalUnit::HOUR.
     */
    public const DATE_INTERVAL_UNIT_HOUR = DateIntervalUnit::HOUR;

    /**
     * @deprecated Use DateIntervalUnit::DAY.
     */
    public const DATE_INTERVAL_UNIT_DAY = DateIntervalUnit::DAY;

    /**
     * @deprecated Use DateIntervalUnit::WEEK.
     */
    public const DATE_INTERVAL_UNIT_WEEK = DateIntervalUnit::WEEK;

    /**
     * @deprecated Use DateIntervalUnit::MONTH.
     */
    public const DATE_INTERVAL_UNIT_MONTH = DateIntervalUnit::MONTH;

    /**
     * @deprecated Use DateIntervalUnit::QUARTER.
     */
    public const DATE_INTERVAL_UNIT_QUARTER = DateIntervalUnit::QUARTER;

    /**
     * @deprecated Use DateIntervalUnit::QUARTER.
     */
    public const DATE_INTERVAL_UNIT_YEAR = DateIntervalUnit::YEAR;

    /**
     * @deprecated Use TrimMode::UNSPECIFIED.
     */
    public const TRIM_UNSPECIFIED = TrimMode::UNSPECIFIED;

    /**
     * @deprecated Use TrimMode::LEADING.
     */
    public const TRIM_LEADING = TrimMode::LEADING;

    /**
     * @deprecated Use TrimMode::TRAILING.
     */
    public const TRIM_TRAILING = TrimMode::TRAILING;

    /**
     * @deprecated Use TrimMode::BOTH.
     */
    public const TRIM_BOTH = TrimMode::BOTH;

    /** @var string[]|null */
    protected $doctrineTypeMapping = null;

    /**
     * Contains a list of all columns that should generate parseable column comments for type-detection
     * in reverse engineering scenarios.
     *
     * @var string[]|null
     */
    protected $doctrineTypeComments = null;

    /** @var EventManager */
    protected $_eventManager;

    /**
     * Holds the KeywordList instance for the current platform.
     *
     * @var KeywordList
     */
    protected $_keywords;

    public function __construct()
    {
    }

    /**
     * Sets the EventManager used by the Platform.
     */
    public function setEventManager(EventManager $eventManager)
    {
        $this->_eventManager = $eventManager;
    }

    /**
     * Gets the EventManager used by the Platform.
     *
     * @return EventManager
     */
    public function getEventManager()
    {
        return $this->_eventManager;
    }

    /**
     * Returns the SQL snippet that declares a boolean column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    abstract public function getBooleanTypeDeclarationSQL(array $columnDef);

    /**
     * Returns the SQL snippet that declares a 4 byte integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    abstract public function getIntegerTypeDeclarationSQL(array $columnDef);

    /**
     * Returns the SQL snippet that declares an 8 byte integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    abstract public function getBigIntTypeDeclarationSQL(array $columnDef);

    /**
     * Returns the SQL snippet that declares a 2 byte integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    abstract public function getSmallIntTypeDeclarationSQL(array $columnDef);

    /**
     * Returns the SQL snippet that declares common properties of an integer column.
     *
     * @param mixed[] $columnDef
     *
     * @return string
     */
    abstract protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef);

    /**
     * Lazy load Doctrine Type Mappings.
     *
     * @return void
     */
    abstract protected function initializeDoctrineTypeMappings();

    /**
     * Initializes Doctrine Type Mappings with the platform defaults
     * and with all additional type mappings.
     *
     * @return void
     */
    private function initializeAllDoctrineTypeMappings()
    {
        $this->initializeDoctrineTypeMappings();

        foreach (Type::getTypesMap() as $typeName => $className) {
            foreach (Type::getType($typeName)->getMappedDatabaseTypes($this) as $dbType) {
                $this->doctrineTypeMapping[$dbType] = $typeName;
            }
        }
    }

    /**
     * Returns the SQL snippet used to declare a VARCHAR column type.
     *
     * @param mixed[] $field
     *
     * @return string
     */
    public function getVarcharTypeDeclarationSQL(array $field)
    {
        if (! isset($field['length'])) {
            $field['length'] = $this->getVarcharDefaultLength();
        }

        $fixed = $field['fixed'] ?? false;

        $maxLength = $fixed
            ? $this->getCharMaxLength()
            : $this->getVarcharMaxLength();

        if ($field['length'] > $maxLength) {
            return $this->getClobTypeDeclarationSQL($field);
        }

        return $this->getVarcharTypeDeclarationSQLSnippet($field['length'], $fixed);
    }

    /**
     * Returns the SQL snippet used to declare a BINARY/VARBINARY column type.
     *
     * @param mixed[] $field The column definition.
     *
     * @return string
     */
    public function getBinaryTypeDeclarationSQL(array $field)
    {
        if (! isset($field['length'])) {
            $field['length'] = $this->getBinaryDefaultLength();
        }

        $fixed = $field['fixed'] ?? false;

        $maxLength = $this->getBinaryMaxLength();

        if ($field['length'] > $maxLength) {
            if ($maxLength > 0) {
                @trigger_error(sprintf(
                    'Binary field length %d is greater than supported by the platform (%d). Reduce the field length or use a BLOB field instead.',
                    $field['length'],
                    $maxLength
                ), E_USER_DEPRECATED);
            }

            return $this->getBlobTypeDeclarationSQL($field);
        }

        return $this->getBinaryTypeDeclarationSQLSnippet($field['length'], $fixed);
    }

    /**
     * Returns the SQL snippet to declare a GUID/UUID field.
     *
     * By default this maps directly to a CHAR(36) and only maps to more
     * special datatypes when the underlying databases support this datatype.
     *
     * @param mixed[] $field
     *
     * @return string
     */
    public functi