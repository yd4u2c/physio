<?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use function array_merge;

/**
 * Schema Diff.
 */
class SchemaDiff
{
    /** @var Schema */
    public $fromSchema;

    /**
     * All added namespaces.
     *
     * @var string[]
     */
    public $newNamespaces = [];

    /**
     * All removed namespaces.
     *
     * @var string[]
     */
    public $removedNamespaces = [];

    /**
     * All added tables.
     *
     * @var Table[]
     */
    public $newTables = [];

    /**
     * All changed tables.
     *
     * @var TableDiff[]
     */
    public $changedTables = [];

    /**
     * All removed tables.
     *
     * @var Table[]
     */
    public $removedTables = [];

    /** @var Sequence[] */
    public $newSequences = [];

    /** @var Sequence[] */
    public $changedSequences = [];

    /** @var Sequence[] */
    public $removedSequences = [];

    /** @var ForeignKeyConstraint[] */
    public $orphanedForeignKeys = [];

    /**
     * Constructs an SchemaDiff object.
     *
     * @param Table[]     $newTables
     * @param TableDiff[] $changedTables
     * @param Table[]     $removedTables
     */
    public function __construct($newTables = [], $changedTables = [], $removedTables = [], ?Schema $fromSchema = null)
    {
        $this->newTables     = $newTables;
        $this->changedTables = $changedTables;
        $this->removedTables = $removedTables;
        $this->fromSchema    = $fromSchema;
    }

    /**
     * The to save sql mode ensures that the following things don't happen:
     *
     * 1. Tables are deleted
     * 2. Sequences are deleted
     * 3. Foreign Keys which reference tables that would otherwise be deleted.
     *
     * This way it is ensured that assets are deleted which might not be relevant to the metadata schema at all.
     *
     * @return string[]
     */
    public function toSaveSql(AbstractPlatform $platform)
    {
        return $this->_toSql($platform, true);
    }

    /**
     * @return string[]
     */
    public function toSql(AbstractPlatform $platform)
    {
        return $this->_toSql($platform, false);
    }

    /**
     * @param bool $saveMode
     *
     * @return string[]
     */
    protected function _toSql(AbstractPlatform $platform, $saveMode = false)
    {
        $sql = [];

        if ($platform->supportsSchemas()) {
            foreach ($this->newNamespaces as $newNamespace) {
                $sql[] = $platform->getCreateSchemaSQL($newNamespace);
            }
        }

        if ($platform->supportsForeignKeyConstraints() && $saveMode === false) {
            foreach ($this->orphanedForeignKeys as $orphanedForeignKey) {
                $sql[] = $platform->getDropForeignKeySQL($orphanedForeignKey, $orphanedForeignKey->getLocalTable());
            }
        }

        if ($platform->supportsSequences() === true) {
            foreach ($this->changedSequences as $sequence) {
                $sql[] = $platform->getAlterSequenceSQL($sequence);
            }

            if ($saveMode === false) {
                foreach ($this->removedSequences as $sequence) {
                    $sql[] = $platform->getDropSequenceSQL($sequence);
                }
            }

            foreach ($this->newSequences as $sequence) {
                $sql[] = $platform->getCreateSequenceSQL($sequence);
            }
        }

        $foreignKeySql = [];
        foreach ($this->newTables as $table) {
            $sql = array_merge(
                $sql,
                $platform->getCreateTableSQL($table, AbstractPlatform::CREATE_INDEXES)
            );

            if (! $platform->supportsForeignKeyConstraints()) {
                continue;
            }

            foreach ($table->getForeignKeys() as $foreignKey) {
                $foreignKeySql[] = $platform->getCreateForeignKeySQL($foreignKey, $table);
            }
        }
        $sql = array_merge($sql, $foreignKeySql);

        if ($saveMode === false) {
            foreach ($this->removedTables as $table) {
                $sql[] = $platform->getDropTableSQL($table);
            }
        }

        foreach ($this->changedTables as $tableDiff) {
            $sql = array_merge($sql, $platform->getAlterTableSQL($tableDiff));
        }

        return $sql;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\DBALException;
use function implode;
use function sprintf;

class SchemaException extends DBALException
{
    public const TABLE_DOESNT_EXIST       = 10;
    public const TABLE_ALREADY_EXISTS     = 20;
    public const COLUMN_DOESNT_EXIST      = 30;
    public const COLUMN_ALREADY_EXISTS    = 40;
    public const INDEX_DOESNT_EXIST       = 50;
    public const INDEX_ALREADY_EXISTS     = 60;
    public const SEQUENCE_DOENST_EXIST    = 70;
    public const SEQUENCE_ALREADY_EXISTS  = 80;
    public const INDEX_INVALID_NAME       = 90;
    public const FOREIGNKEY_DOESNT_EXIST  = 100;
    public const NAMESPACE_ALREADY_EXISTS = 110;

    /**
     * @param string $tableName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function tableDoesNotExist($tableName)
    {
        return new self("There is no table with name '" . $tableName . "' in the schema.", self::TABLE_DOESNT_EXIST);
    }

    /**
     * @param string $indexName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function indexNameInvalid($indexName)
    {
        return new self(
            sprintf('Invalid index-name %s given, has to be [a-zA-Z0-9_]', $indexName),
            self::INDEX_INVALID_NAME
        );
    }

    /**
     * @param string $indexName
     * @param string $table
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function indexDoesNotExist($indexName, $table)
    {
        return new self(
            sprintf("Index '%s' does not exist on table '%s'.", $indexName, $table),
            self::INDEX_DOESNT_EXIST
        );
    }

    /**
     * @param string $indexName
     * @param string $table
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function indexAlreadyExists($indexName, $table)
    {
        return new self(
            sprintf("An index with name '%s' was already defined on table '%s'.", $indexName, $table),
            self::INDEX_ALREADY_EXISTS
        );
    }

    /**
     * @param string $columnName
     * @param string $table
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function columnDoesNotExist($columnName, $table)
    {
        return new self(
            sprintf("There is no column with name '%s' on table '%s'.", $columnName, $table),
            self::COLUMN_DOESNT_EXIST
        );
    }

    /**
     * @param string $namespaceName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function namespaceAlreadyExists($namespaceName)
    {
        return new self(
            sprintf("The namespace with name '%s' already exists.", $namespaceName),
            self::NAMESPACE_ALREADY_EXISTS
        );
    }

    /**
     * @param string $tableName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function tableAlreadyExists($tableName)
    {
        return new self("The table with name '" . $tableName . "' already exists.", self::TABLE_ALREADY_EXISTS);
    }

    /**
     * @param string $tableName
     * @param string $columnName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function columnAlreadyExists($tableName, $columnName)
    {
        return new self(
            "The column '" . $columnName . "' on table '" . $tableName . "' already exists.",
            self::COLUMN_ALREADY_EXISTS
        );
    }

    /**
     * @param string $sequenceName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function sequenceAlreadyExists($sequenceName)
    {
        return new self("The sequence '" . $sequenceName . "' already exists.", self::SEQUENCE_ALREADY_EXISTS);
    }

    /**
     * @param string $sequenceName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function sequenceDoesNotExist($sequenceName)
    {
        return new self("There exists no sequence with the name '" . $sequenceName . "'.", self::SEQUENCE_DOENST_EXIST);
    }

    /**
     * @param string $fkName
     * @param string $table
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function foreignKeyDoesNotExist($fkName, $table)
    {
        return new self(
            sprintf("There exists no foreign key with the name '%s' on table '%s'.", $fkName, $table),
            self::FOREIGNKEY_DOESNT_EXIST
        );
    }

    /**
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function namedForeignKeyRequired(Table $localTable, ForeignKeyConstraint $foreignKey)
    {
        return new self(
            'The performed schema operation on ' . $localTable->getName() . ' requires a named foreign key, ' .
            'but the given foreign key from (' . implode(', ', $foreignKey->getColumns()) . ') onto foreign table ' .
            "'" . $foreignKey->getForeignTableName() . "' (" . implode(', ', $foreignKey->getForeignColumns()) . ') is currently ' .
            'unnamed.'
        );
    }

    /**
     * @param string $changeName
     *
     * @return \Doctrine\DBAL\Schema\SchemaException
     */
    public static function alterTableChangeNotSupported($changeName)
    {
        return new self(
            sprintf("Alter table change not supported, given '%s'", $changeName)
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Schema\Visitor\Visitor;
use function count;
use function is_numeric;
use function sprintf;

/**
 * Sequence structure.
 */
class Sequence extends AbstractAsset
{
    /** @var int */
    protected $allocationSize = 1;

    /** @var int */
    protected $initialValue = 1;

    /** @var int|null */
    protected $cache = null;

    /**
     * @param string   $name
     * @param int      $allocationSize
     * @param int      $initialValue
     * @param int|null $cache
     */
    public function __construct($name, $allocationSize = 1, $initialValue = 1, $cache = null)
    {
        $this->_setName($name);
        $this->setAllocationSize($allocationSize);
        $this->setInitialValue($initialValue);
        $this->cache = $cache;
    }

    /**
     * @return int
     */
    public function getAllocationSize()
    {
        return $this->allocationSize;
    }

    /**
     * @return int
     */
    public function getInitialValue()
    {
        return $this->initialValue;
    }

    /**
     * @return int|null
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param int $allocationSize
     *
     * @return \Doctrine\DBAL\Schema\Sequence
     */
    public function setAllocationSize($allocationSize)
    {
        $this->allocationSize = is_numeric($allocationSize) ? (int) $allocationSize : 1;

        return $this;
    }

    /**
     * @param int $initialValue
     *
     * @return \Doctrine\DBAL\Schema\Sequence
     */
    public function setInitialValue($initialValue)
    {
        $this->initialValue = is_numeric($initialValue) ? (int) $initialValue : 1;

        return $this;
    }

    /**
     * @param int $cache
     *
     * @return \Doctrine\DBAL\Schema\Sequence
     */
    public function setCache($cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Checks if this sequence is an autoincrement sequence for a given table.
     *
     * This is used inside the comparator to not report sequences as missing,
     * when the "from" schema implicitly creates the sequences.
     *
     * @return bool
     */
    public function isAutoIncrementsFor(Table $table)
    {
        if (! $table->hasPrimaryKey()) {
            return false;
        }

        $pkColumns = $table->getPrimaryKey()->getColumns();

        if (count($pkColumns) !== 1) {
            return false;
        }

        $column = $table->getColumn($pkColumns[0]);

        if (! $column->getAutoincrement()) {
            return false;
        }

        $sequenceName      = $this->getShortestName($table->getNamespaceName());
        $tableName         = $table->getShortestName($table->getNamespaceName());
        $tableSequenceName = sprintf('%s_%s_seq', $tableName, $column->getShortestName($table->getNamespaceName()));

        return $tableSequenceName === $sequenceName;
    }

    /**
     * @return void
     */
    public function visit(Visitor $visitor)
    {
        $visitor->acceptSequence($this);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Platforms\SQLAnywherePlatform;
use Doctrine\DBAL\Types\Type;
use function assert;
use function preg_replace;

/**
 * SAP Sybase SQL Anywhere schema manager.
 */
class SQLAnywhereSchemaManager extends AbstractSchemaManager
{
    /**
     * {@inheritdoc}
     *
     * Starts a database after creation
     * as SQL Anywhere needs a database to be started
     * before it can be used.
     *
     * @see startDatabase
     */
    public function createDatabase($database)
    {
        parent::createDatabase($database);
        $this->startDatabase($database);
    }

    /**
     * {@inheritdoc}
     *
     * Tries stopping a database before dropping
     * as SQL Anywhere needs a database to be stopped
     * before it can be dropped.
     *
     * @see stopDatabase
     */
    public function dropDatabase($database)
    {
        $this->tryMethod('stopDatabase', $database);
        parent::dropDatabase($database);
    }

    /**
     * Starts a database.
     *
     * @param string $database The name of the database to start.
     */
    public function startDatabase($database)
    {
        assert($this->_platform instanceof SQLAnywherePlatform);
        $this->_execSql($this->_platform->getStartDatabaseSQL($database));
    }

    /**
     * Stops a database.
     *
     * @param string $database The name of the database to stop.
     */
    public function stopDatabase($database)
    {
        assert($this->_platform instanceof SQLAnywherePlatform);
        $this->_execSql($this->_platform->getStopDatabaseSQL($database));
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableDatabaseDefinition($database)
    {
        return $database['name'];
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableSequenceDefinition($sequence)
    {
        return new Sequence($sequence['sequence_name'], $sequence['increment_by'], $sequence['start_with']);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableColumnDefinition($tableColumn)
    {
        $type                   = $this->_platform->getDoctrineTypeMapping($tableColumn['type']);
        $type                   = $this->extractDoctrineTypeFromComment($tableColumn['comment'], $type);
        $tableColumn['comment'] = $this->removeDoctrineTypeFromComment($tableColumn['comment'], $type);
        $precision              = null;
        $scale                  = null;
        $fixed                  = false;
        $default                = null;

        if ($tableColumn['default'] !== null) {
            // Strip quotes from default value.
            $default = preg_replace(["/^'(.*)'$/", "/''/"], ['$1', "'"], $tableColumn['default']);

            if ($default === 'autoincrement') {
                $default = null;
            }
        }

        switch ($tableColumn['type']) {
            case 'binary':
            case 'char':
            case 'nchar':
                $fixed = true;
        }

        switch ($type) {
            case 'decimal':
            case 'float':
                $precision = $tableColumn['length'];
                $scale     = $tableColumn['scale'];
        }

        return new Column(
            $tableColumn['column_name'],
            Type::getType($type),
            [
                'length'        => $type === 'string' ? $tableColumn['length'] : null,
                'precision'     => $precision,
                'scale'         => $scale,
                'unsigned'      => (bool) $tableColumn['unsigned'],
                'fixed'         => $fixed,
                'notnull'       => (bool) $tableColumn['notnull'],
                'default'       => $default,
                'autoincrement' => (bool) $tableColumn['autoincrement'],
                'comment'       => isset($tableColumn['comment']) && $tableColumn['comment'] !== ''
                    ? $tableColumn['comment']
                    : null,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableDefinition($table)
    {
        return $table['table_name'];
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableForeignKeyDefinition($tableForeignKey)
    {
        return new ForeignKeyConstraint(
            $tableForeignKey['local_columns'],
            $tableForeignKey['foreign_table'],
            $tableForeignKey['foreign_columns'],
            $tableForeignKey['name'],
            $tableForeignKey['options']
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableForeignKeysList($tableForeignKeys)
    {
        $foreignKeys = [];

        foreach ($tableForeignKeys as $tableForeignKey) {
            if (! isset($foreignKeys[$tableForeignKey['index_name']])) {
                $foreignKeys[$tableForeignKey['index_name']] = [
                    'local_columns'   => [$tableForeignKey['local_column']],
                    'foreign_table'   => $tableForeignKey['foreign_table'],
                    'foreign_columns' => [$tableForeignKey['foreign_column']],
                    'name'            => $tableForeignKey['index_name'],
                    'options'         => [
                        'notnull'           => $tableForeignKey['notnull'],
                        'match'             => $tableForeignKey['match'],
                        'onUpdate'          => $tableForeignKey['on_update'],
                        'onDelete'          => $tableForeignKey['on_delete'],
                        'check_on_commit'   => $tableForeignKey['check_on_commit'],
                        'clustered'         => $tableForeignKey['clustered'],
                        'for_olap_workload' => $tableForeignKey['for_olap_workload'],
                    ],
                ];
            } else {
                $foreignKeys[$tableForeignKey['index_name']]['local_columns'][]   = $tableForeignKey['local_column'];
                $foreignKeys[$tableForeignKey['index_name']]['foreign_columns'][] = $tableForeignKey['foreign_column'];
            }
        }

        return parent::_getPortableTableForeignKeysList($foreignKeys);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableIndexesList($tableIndexRows, $tableName = null)
    {
        foreach ($tableIndexRows as &$tableIndex) {
            $tableIndex['primary'] = (bool) $tableIndex['primary'];
            $tableIndex['flags']   = [];

            if ($tableIndex['clustered']) {
                $tableIndex['flags'][] = 'clustered';
            }

            if ($tableIndex['with_nulls_not_distinct']) {
                $tableIndex['flags'][] = 'with_nulls_not_distinct';
            }

            if (! $tableIndex['for_olap_workload']) {
                continue;
            }

            $tableIndex['flags'][] = 'for_olap_workload';
        }

        return parent::_getPortableTableIndexesList($tableIndexRows, $tableName);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableViewDefinition($view)
    {
        return new View(
            $view['table_name'],
            preg_replace('/^.*\s+as\s+SELECT(.*)/i', 'SELECT$1', $view['view_def'])
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Types\Type;
use const CASE_LOWER;
use function array_change_key_case;
use function array_map;
use function array_reverse;
use function array_values;
use function explode;
use function file_exists;
use function preg_match;
use function preg_match_all;
use function preg_quote;
use function preg_replace;
use function rtrim;
use function sprintf;
use function str_replace;
use function strpos;
use function strtolower;
use function trim;
use function unlink;
use function usort;

/**
 * Sqlite SchemaManager.
 */
class SqliteSchemaManager extends AbstractSchemaManager
{
    /**
     * {@inheritdoc}
     */
    public function dropDatabase($database)
    {
        if (! file_exists($database)) {
            return;
        }

        unlink($database);
    }

    /**
     * {@inheritdoc}
     */
    public function createDatabase($database)
    {
        $params  = $this->_conn->getParams();
        $driver  = $params['driver'];
        $options = [
            'driver' => $driver,
            'path' => $database,
        ];
        $conn    = DriverManager::getConnection($options);
        $conn->connect();
        $conn->close();
    }

    /**
     * {@inheritdoc}
     */
    public function renameTable($name, $newName)
    {
        $tableDiff            = new TableDiff($name);
        $tableDiff->fromTable = $this->listTableDetails($name);
        $tableDiff->newName   = $newName;
        $this->alterTable($tableDiff);
    }

    /**
     * {@inheritdoc}
     */
    public function createForeignKey(ForeignKeyConstraint $foreignKey, $table)
    {
        $tableDiff                     = $this->getTableDiffForAlterForeignKey($foreignKey, $table);
        $tableDiff->addedForeignKeys[] = $foreignKey;

        $this->alterTable($tableDiff);
    }

    /**
     * {@inheritdoc}
     */
    public function dropAndCreateForeignKey(ForeignKeyConstraint $foreignKey, $table)
    {
        $tableDiff                       = $this->getTableDiffForAlterForeignKey($foreignKey, $table);
        $tableDiff->changedForeignKeys[] = $foreignKey;

        $this->alterTable($tableDiff);
    }

    /**
     * {@inheritdoc}
     */
    public function dropForeignKey($foreignKey, $table)
    {
        $tableDiff                       = $this->getTableDiffForAlterForeignKey($foreignKey, $table);
        $tableDiff->removedForeignKeys[] = $foreignKey;

        $this->alterTable($tableDiff);
    }

    /**
     * {@inheritdoc}
     */
    public function listTableForeignKeys($table, $database = null)
    {
        if ($database === null) {
            $database = $this->_conn->getDatabase();
        }
        $sql              = $this->_platform->getListTableForeignKeysSQL($table, $database);
        $tableForeignKeys = $this->_conn->fetchAll($sql);

        if (! empty($tableForeignKeys)) {
            $createSql = $this->getCreateTableSQL($table);

            if ($createSql !== null && preg_match_all(
                '#
                    (?:CONSTRAINT\s+([^\s]+)\s+)?
                    (?:FOREIGN\s+KEY[^\)]+\)\s*)?
                    REFERENCES\s+[^\s]+\s+(?:\([^\)]+\))?
                    (?:
                        [^,]*?
                        (NOT\s+DEFERRABLE|DEFERRABLE)
                        (?:\s+INITIALLY\s+(DEFERRED|IMMEDIATE))?
                    )?#isx',
                $createSql,
                $match
            )) {
                $names      = array_reverse($match[1]);
                $deferrable = array_reverse($match[2]);
                $deferred   = array_reverse($match[3]);
            } else {
                $names = $deferrable = $deferred = [];
            }

            foreach ($tableForeignKeys as $key => $value) {
                $id                                        = $value['id'];
                $tableForeignKeys[$key]['constraint_name'] = isset($names[$id]) && $names[$id] !== '' ? $names[$id] : $id;
                $tableForeignKeys[$key]['deferrable']      = isset($deferrable[$id]) && strtolower($deferrable[$id]) === 'deferrable';
                $tableForeignKeys[$key]['deferred']        = isset($deferred[$id]) && strtolower($deferred[$id]) === 'deferred';
            }
        }

        return $this->_getPortableTableForeignKeysList($tableForeignKeys);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableDefinition($table)
    {
        return $table['name'];
    }

    /**
     * {@inheritdoc}
     *
     * @link http://ezcomponents.org/docs/api/trunk/DatabaseSchema/ezcDbSchemaPgsqlReader.html
     */
    protected function _getPortableTableIndexesList($tableIndexes, $tableName = null)
    {
        $indexBuffer = [];

        // fetch primary
        $stmt       = $this->_conn->executeQuery(sprintf(
            'PRAGMA TABLE_INFO (%s)',
            $this->_conn->quote($tableName)
        ));
        $indexArray = $stmt->fetchAll(FetchMode::ASSOCIATIVE);

        usort($indexArray, static function ($a, $b) {
            if ($a['pk'] === $b['pk']) {
                return $a['cid'] - $b['cid'];
            }

            return $a['pk'] - $b['pk'];
        });
        foreach ($indexArray as $indexColumnRow) {
            if ($indexColumnRow['pk'] === '0') {
                continue;
            }

            $indexBuffer[] = [
                'key_name' => 'primary',
                'primary' => true,
                'non_unique' => false,
                'column_name' => $indexColumnRow['name'],
            ];
        }

        // fetch regular indexes
        foreach ($tableIndexes as $tableIndex) {
            // Ignore indexes with reserved names, e.g. autoindexes
            if (strpos($tableIndex['name'], 'sqlite_') === 0) {
                continue;
            }

            $keyName           = $tableIndex['name'];
            $idx               = [];
            $idx['key_name']   = $keyName;
            $idx['primary']    = false;
            $idx['non_unique'] = $tableIndex['unique']?false:true;

                $stmt       = $this->_conn->executeQuery(sprintf(
                    'PRAGMA INDEX_INFO (%s)',
                    $this->_conn->quote($keyName)
                ));
                $indexArray = $stmt->fetchAll(FetchMode::ASSOCIATIVE);

            foreach ($indexArray as $indexColumnRow) {
                $idx['column_name'] = $indexColumnRow['name'];
                $indexBuffer[]      = $idx;
            }
        }

        return parent::_getPortableTableIndexesList($indexBuffer, $tableName);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableIndexDefinition($tableIndex)
    {
        return [
            'name' => $tableIndex['name'],
            'unique' => (bool) $tableIndex['unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableColumnList($table, $database, $tableColumns)
    {
        $list = parent::_getPortableTableColumnList($table, $database, $tableColumns);

        // find column with autoincrement
        $autoincrementColumn = null;
        $autoincrementCount  = 0;

        foreach ($tableColumns as $tableColumn) {
            if ($tableColumn['pk'] === '0') {
                continue;
            }

            $autoincrementCount++;
            if ($autoincrementColumn !== null || strtolower($tableColumn['type']) !== 'integer') {
                continue;
            }

            $autoincrementColumn = $tableColumn['name'];
        }

        if ($autoincrementCount === 1 && $autoincrementColumn !== null) {
            foreach ($list as $column) {
                if ($autoincrementColumn !== $column->getName()) {
                    continue;
                }

                $column->setAutoincrement(true);
            }
        }

        // inspect column collation and comments
        $createSql = $this->getCreateTableSQL($table) ?? '';

        foreach ($list as $columnName => $column) {
            $type = $column->getType();

            if ($type instanceof StringType || $type instanceof TextType) {
                $column->setPlatformOption('collation', $this->parseColumnCollationFromSQL($columnName, $createSql) ?: 'BINARY');
            }

            $comment = $this->parseColumnCommentFromSQL($columnName, $createSql);

            if ($comment === null) {
                continue;
            }

            $type = $this->extractDoctrineTypeFromComment($comment, null);

            if ($type !== null) {
                $column->setType(Type::getType($type));

                $comment = $this->removeDoctrineTypeFromComment($comment, $type);
            }

            $column->setComment($comment);
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableColumnDefinition($tableColumn)
    {
        $parts               = explode('(', $tableColumn['type']);
        $tableColumn['type'] = trim($parts[0]);
        if (isset($parts[1])) {
            $length                = trim($parts[1], ')');
            $tableColumn['length'] = $length;
        }

        $dbType   = strtolower($tableColumn['type']);
        $length   = $tableColumn['length'] ?? null;
        $unsigned = false;

        if (strpos($dbType, ' unsigned') !== false) {
            $dbType   = str_replace(' unsigned', '', $dbType);
            $unsigned = true;
        }

        $fixed   = false;
        $type    = $this->_platform->getDoctrineTypeMapping($dbType);
        $default = $tableColumn['dflt_value'];
        if ($default === 'NULL') {
            $default = null;
        }
        if ($default !== null) {
            // SQLite returns strings wrapped in single quotes, so we need to strip them
            $default = preg_replace("/^'(.*)'$/", '\1', $default);
        }
        $notnull = (bool) $tableColumn['notnull'];

        if (! isset($tableColumn['name'])) {
            $tableColumn['name'] = '';
        }

    