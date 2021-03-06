<?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Schema\Table;

/**
 * Platform to ensure compatibility of Doctrine with SQL Azure
 *
 * On top of SQL Server 2008 the following functionality is added:
 *
 * - Create tables with the FEDERATED ON syntax.
 */
class SQLAzurePlatform extends SQLServer2008Platform
{
    /**
     * {@inheritDoc}
     */
    public function getCreateTableSQL(Table $table, $createFlags = self::CREATE_INDEXES)
    {
        $sql = parent::getCreateTableSQL($table, $createFlags);

        if ($table->hasOption('azure.federatedOnColumnName')) {
            $distributionName = $table->getOption('azure.federatedOnDistributionName');
            $columnName       = $table->getOption('azure.federatedOnColumnName');
            $stmt             = ' FEDERATED ON (' . $distributionName . ' = ' . $columnName . ')';

            $sql[0] .= $stmt;
        }

        return $sql;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\Constraint;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Identifier;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\TransactionIsolationLevel;
use Doctrine\DBAL\Types;
use function array_merge;
use function array_unique;
use function array_values;
use function implode;
use function is_numeric;
use function sprintf;
use function sqrt;
use function str_replace;
use function strlen;
use function strpos;
use function strtolower;

/**
 * The SqlitePlatform class describes the specifics and dialects of the SQLite
 * database platform.
 *
 * @todo   Rename: SQLitePlatform
 */
class SqlitePlatform extends AbstractPlatform
{
    /**
     * {@inheritDoc}
     */
    public function getRegexpExpression()
    {
        return 'REGEXP';
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Use application-generated UUIDs instead
     */
    public function getGuidExpression()
    {
        return "HEX(RANDOMBLOB(4)) || '-' || HEX(RANDOMBLOB(2)) || '-4' || "
            . "SUBSTR(HEX(RANDOMBLOB(2)), 2) || '-' || "
            . "SUBSTR('89AB', 1 + (ABS(RANDOM()) % 4), 1) || "
            . "SUBSTR(HEX(RANDOMBLOB(2)), 2) || '-' || HEX(RANDOMBLOB(6))";
    }

    /**
     * {@inheritDoc}
     */
    public function getNowExpression($type = 'timestamp')
    {
        switch ($type) {
            case 'time':
                return 'time(\'now\')';
            case 'date':
                return 'date(\'now\')';
            case 'timestamp':
            default:
                return 'datetime(\'now\')';
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getTrimExpression($str, $pos = TrimMode::UNSPECIFIED, $char = false)
    {
        $trimChar = $char !== false ? (', ' . $char) : '';

        switch ($pos) {
            case TrimMode::LEADING:
                $trimFn = 'LTRIM';
                break;

            case TrimMode::TRAILING:
                $trimFn = 'RTRIM';
                break;

            default:
                $trimFn = 'TRIM';
        }

        return $trimFn . '(' . $str . $trimChar . ')';
    }

    /**
     * {@inheritDoc}
     *
     * SQLite only supports the 2 parameter variant of this function
     */
    public function getSubstringExpression($value, $position, $length = null)
    {
        if ($length !== null) {
            return 'SUBSTR(' . $value . ', ' . $position . ', ' . $length . ')';
        }

        return 'SUBSTR(' . $value . ', ' . $position . ', LENGTH(' . $value . '))';
    }

    /**
     * {@inheritDoc}
     */
    public function getLocateExpression($str, $substr, $startPos = false)
    {
        if ($startPos === false) {
            return 'LOCATE(' . $str . ', ' . $substr . ')';
        }

        return 'LOCATE(' . $str . ', ' . $substr . ', ' . $startPos . ')';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDateArithmeticIntervalExpression($date, $operator, $interval, $unit)
    {
        switch ($unit) {
            case DateIntervalUnit::SECOND:
            case DateIntervalUnit::MINUTE:
            case DateIntervalUnit::HOUR:
                return 'DATETIME(' . $date . ",'" . $operator . $interval . ' ' . $unit . "')";

            default:
                switch ($unit) {
                    case DateIntervalUnit::WEEK:
                        $interval *= 7;
                        $unit      = DateIntervalUnit::DAY;
                        break;

                    case DateIntervalUnit::QUARTER:
                        $interval *= 3;
                        $unit      = DateIntervalUnit::MONTH;
                        break;
                }

                if (! is_numeric($interval)) {
                    $interval = "' || " . $interval . " || '";
                }

                return 'DATE(' . $date . ",'" . $operator . $interval . ' ' . $unit . "')";
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getDateDiffExpression($date1, $date2)
    {
        return sprintf("JULIANDAY(%s, 'start of day') - JULIANDAY(%s, 'start of day')", $date1, $date2);
    }

    /**
     * {@inheritDoc}
     */
    protected function _getTransactionIsolationLevelSQL($level)
    {
        switch ($level) {
            case TransactionIsolationLevel::READ_UNCOMMITTED:
                return 0;
            case TransactionIsolationLevel::READ_COMMITTED:
            case TransactionIsolationLevel::REPEATABLE_READ:
            case TransactionIsolationLevel::SERIALIZABLE:
                return 1;
            default:
                return parent::_getTransactionIsolationLevelSQL($level);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getSetTransactionIsolationSQL($level)
    {
        return 'PRAGMA read_uncommitted = ' . $this->_getTransactionIsolationLevelSQL($level);
    }

    /**
     * {@inheritDoc}
     */
    public function prefersIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getBooleanTypeDeclarationSQL(array $field)
    {
        return 'BOOLEAN';
    }

    /**
     * {@inheritDoc}
     */
    public function getIntegerTypeDeclarationSQL(array $field)
    {
        return 'INTEGER' . $this->_getCommonIntegerTypeDeclarationSQL($field);
    }

    /**
     * {@inheritDoc}
     */
    public function getBigIntTypeDeclarationSQL(array $field)
    {
        //  SQLite autoincrement is implicit for INTEGER PKs, but not for BIGINT fields.
        if (! empty($field['autoincrement'])) {
            return $this->getIntegerTypeDeclarationSQL($field);
        }

        return 'BIGINT' . $this->_getCommonIntegerTypeDeclarationSQL($field);
    }

    /**
     * {@inheritDoc}
     */
    public function getTinyIntTypeDeclarationSql(array $field)
    {
        //  SQLite autoincrement is implicit for INTEGER PKs, but not for TINYINT fields.
        if (! empty($field['autoincrement'])) {
            return $this->getIntegerTypeDeclarationSQL($field);
        }

        return 'TINYINT' . $this->_getCommonIntegerTypeDeclarationSQL($field);
    }

    /**
     * {@inheritDoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $field)
    {
        //  SQLite autoincrement is implicit for INTEGER PKs, but not for SMALLINT fields.
        if (! empty($field['autoincrement'])) {
            return $this->getIntegerTypeDeclarationSQL($field);
        }

        return 'SMALLINT' . $this->_getCommonIntegerTypeDeclarationSQL($field);
    }

    /**
     * {@inheritDoc}
     */
    public function getMediumIntTypeDeclarationSql(array $field)
    {
        //  SQLite autoincrement is implicit for INTEGER PKs, but not for MEDIUMINT fields.
        if (! empty($field['autoincrement'])) {
            return $this->getIntegerTypeDeclarationSQL($field);
        }

        return 'MEDIUMINT' . $this->_getCommonIntegerTypeDeclarationSQL($field);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATETIME';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATE';
    }

    /**
     * {@inheritDoc}
     */
    public function getTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIME';
    }

    /**
     * {@inheritDoc}
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        // sqlite autoincrement is only possible for the primary key
        if (! empty($columnDef['autoincrement'])) {
            return ' PRIMARY KEY AUTOINCREMENT';
        }

        return ! empty($columnDef['unsigned']) ? ' UNSIGNED' : '';
    }

    /**
     * {@inheritDoc}
     */
    public function getForeignKeyDeclarationSQL(ForeignKeyConstraint $foreignKey)
    {
        return parent::getForeignKeyDeclarationSQL(new ForeignKeyConstraint(
            $foreignKey->getQuotedLocalColumns($this),
            str_replace('.', '__', $foreignKey->getQuotedForeignTableName($this)),
            $foreignKey->getQuotedForeignColumns($this),
            $foreignKey->getName(),
            $foreignKey->getOptions()
        ));
    }

    /**
     * {@inheritDoc}
     */
    protected function _getCreateTableSQL($name, array $columns, array $options = [])
    {
        $name        = str_replace('.', '__', $name);
        $queryFields = $this->getColumnDeclarationListSQL($columns);

        if (isset($options['uniqueConstraints']) && ! empty($options['uniqueConstraints'])) {
            foreach ($options['uniqueConstraints'] as $name => $definition) {
                $queryFields .= ', ' . $this->getUniqueConstraintDeclarationSQL($name, $definition);
            }
        }

        $queryFields .= $this->getNonAutoincrementPrimaryKeyDefinition($columns, $options);

        if (isset($options['foreignKeys'])) {
            foreach ($options['foreignKeys'] as $foreignKey) {
                $queryFields .= ', ' . $this->getForeignKeyDeclarationSQL($foreignKey);
            }
        }

        $query = ['CREATE TABLE ' . $name . ' (' . $queryFields . ')'];

        if (isset($options['alter']) && $options['alter'] === true) {
            return $query;
        }

        if (isset($options['indexes']) && ! empty($options['indexes'])) {
            foreach ($options['indexes'] as $indexDef) {
                $query[] = $this->getCreateIndexSQL($indexDef, $name);
            }
        }

        if (isset($options['unique']) && ! empty($options['unique'])) {
            foreach ($options['unique'] as $indexDef) {
                $query[] = $this->getCreateIndexSQL($indexDef, $name);
            }
        }

        return $query;
    }

    /**
     * Generate a PRIMARY KEY definition if no autoincrement value is used
     *
     * @param string[] $columns
     * @param mixed[]  $options
     */
    private function getNonAutoincrementPrimaryKeyDefinition(array $columns, array $options) : string
    {
        if (empty($options['primary'])) {
            return '';
        }

        $keyColumns = array_unique(array_values($options['primary']));

        foreach ($keyColumns as $keyColumn) {
            if (isset($columns[$keyColumn]['autoincrement']) && ! empty($columns[$keyColumn]['autoincrement'])) {
                return '';
            }
        }

        return ', PRIMARY KEY(' . implode(', ', $keyColumns) . ')';
    }

    /**
     * {@inheritDoc}
     */
    protected function getVarcharTypeDeclarationSQLSnippet($length, $fixed)
    {
        return $fixed ? ($length ? 'CHAR(' . $length . ')' : 'CHAR(255)')
                : ($length ? 'VARCHAR(' . $length . ')' : 'TEXT');
    }

    /**
     * {@inheritdoc}
     */
    protected function getBinaryTypeDeclarationSQLSnippet($length, $fixed)
    {
        return 'BLOB';
    }

    /**
     * {@inheritdoc}
     */
    public function getBinaryMaxLength()
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getBinaryDefaultLength()
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
        return 'CLOB';
    }

    /**
     * {@inheritDoc}
     */
    public function getListTableConstraintsSQL($table)
    {
        $table = str_replace('.', '__', $table);

        return sprintf(
            "SELECT sql FROM sqlite_master WHERE type='index' AND tbl_name = %s AND sql NOT NULL ORDER BY name",
            $this->quoteStringLiteral($table)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getListTableColumnsSQL($table, $currentDatabase = null)
    {
        $table = str_replace('.', '__', $table);

        return sprintf('PRAGMA table_info(%s)', $this->quoteStringLiteral($table));
    }

    /**
     * {@inheritDoc}
     */
    public function getListTableIndexesSQL($table, $currentDatabase = null)
    {
        $table = str_replace('.', '__', $table);

        return sprintf('PRAGMA index_list(%s)', $this->quoteStringLiteral($table));
    }

    /**
     * {@inheritDoc}
     */
    public function getListTablesSQL()
    {
        return "SELECT name FROM sqlite_master WHERE type = 'table' AND name != 'sqlite_sequence' AND name != 'geometry_columns' AND name != 'spatial_ref_sys' "
             . 'UNION ALL SELECT name FROM sqlite_temp_master '
             . "WHERE type = 'table' ORDER BY name";
    }

    /**
     * {@inheritDoc}
     */
    public function getListViewsSQL($database)
    {
        return "SELECT name, sql FROM sqlite_master WHERE type='view' AND sql NOT NULL";
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateViewSQL($name, $sql)
    {
        return 'CREATE VIEW ' . $name . ' AS ' . $sql;
    }

    /**
     * {@inheritDoc}
     */
    public function getDropViewSQL($name)
    {
        return 'DROP VIEW ' . $name;
    }

    /**
     * {@inheritDoc}
     */
    public function getAdvancedForeignKeyOptionsSQL(ForeignKeyConstraint $foreignKey)
    {
        $query = parent::getAdvancedForeignKeyOptionsSQL($foreignKey);

        $query .= ($foreignKey->hasOption('deferrable') && $foreignKey->getOption('deferrable') !== false ? ' ' : ' NOT ') . 'DEFERRABLE';
        $query .= ' INITIALLY ' . ($foreignKey->hasOption('deferred') && $foreignKey->getOption('deferred') !== false ? 'DEFERRED' : 'IMMEDIATE');

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsColumnCollation()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsInlineColumnComments()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'sqlite';
    }

    /**
     * {@inheritDoc}
     */
    public function getTruncateTableSQL($tableName, $cascade = false)
    {
        $tableIdentifier = new Identifier($tableName);
        $tableName       = str_replace('.', '__', $tableIdentifier->getQuotedName($this));

        return 'DELETE FROM ' . $tableName;
    }

    /**
     * User-defined function for Sqlite that is used with PDO::sqliteCreateFunction().
     *
     * @param int|float $value
     *
     * @return float
     */
    public static function udfSqrt($value)
    {
        return sqrt($value);
    }

    /**
     * User-defined function for Sqlite that implements MOD(a, b).
     *
     * @param int $a
     * @param int $b
     *
     * @return int
     */
    public static function udfMod($a, $b)
    {
        return $a % $b;
    }

    /**
     * @param string $str
     * @param string $substr
     * @param int    $offset
     *
     * @return int
     */
    public static function udfLocate($str, $substr, $offset = 0)
    {
        // SQL's LOCATE function works on 1-based positions, while PHP's strpos works on 0-based positions.
        // So we have to make them compatible if an offset is given.
        if ($offset > 0) {
            $offset -= 1;
        }

        $pos = strpos($str, $substr, $offset);

        if ($pos !== false) {
            return $pos + 1;
        }

        return 0;
    }

    /**
     * {@inheritDoc}
     */
    public function getForUpdateSql()
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getInlineColumnCommentSQL($comment)
    {
        return '--' . str_replace("\n", "\n--", $comment) . "\n";
    }

    /**
     * {@inheritDoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        $this->doctrineTypeMapping = [
            'boolean'          => 'boolean',
            'tinyint'          => 'boolean',
            'smallint'         => 'smallint',
            'mediumint'        => 'integer',
            'int'              => 'integer',
            'integer'          => 'integer',
            'serial'           => 'integer',
            'bigint'           => 'bigint',
            'bigserial'        => 'bigint',
            'clob'             => 'text',
            'tinytext'         => 'text',
            'mediumtext'       => 'text',
            'longtext'         => 'text',
            'text'             => 'text',
            'varchar'          => 'string',
            'longvarchar'      => 'string',
            'varchar2'         => 'string',
            'nvarchar'         => 'string',
            'image'            => 'string',
            'ntext'            => 'string',
            'char'             => 'string',
            'date'             => 'date',
            'datetime'         => 'datetime',
            'timestamp'        => 'datetime',
            'time'             => 'time',
            'float'            => 'float',
            'double'           => 'float',
            'double precision' => 'float',
            'real'             => 'float',
            'decimal'          => 'decimal',
            'numeric'          => 'decimal',
            'blob'             => 'blob',
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\SQLiteKeywords::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function getPreAlterTableIndexForeignKeySQL(TableDiff $diff)
    {
        if (! $diff->fromTable instanceof Table) {
            throw new DBALException('Sqlite platform requires for alter table the table diff with reference to original table schema');
        }

        $sql = [];
        foreach ($diff->fromTable->getIndexes() as $index) {
            if ($index->isPrimary()) {
                continue;
            }

            $sql[] = $this->getDropIndexSQL($index, $diff->name);
        }

        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    protected function getPostAlterTableIndexForeignKeySQL(TableDiff $diff)
    {
        if (! $diff->fromTable instanceof Table) {
            throw new DBALException('Sqlite platform requires for alter table the table diff with reference to original table schema');
        }

        $sql       = [];
        $tableName = $diff->newName ? $diff->getNewName(): $diff->getName($this);
        foreach ($this->getIndexesInAlteredTable($diff) as $index) {
            if ($index->isPrimary()) {
                continue;
            }

            $sql[] = $this->getCreateIndexSQL($index, $tableName->getQuotedName($this));
        }

        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    protected function doModifyLimitQuery($query, $limit, $offset)
    {
        if ($limit === null && $offset > 0) {
            return $query . ' LIMIT -1 OFFSET ' . $offset;
        }

        return parent::doModifyLimitQuery($query, $limit, $offset);
    }

    /**
     * {@inheritDoc}
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
        return 'BLOB';
    }

    /**
     * {@inheritDoc}
     */
    public function getTemporaryTableName($tableName)
    {
        $tableName = str_replace('.', '__', $tableName);

        return $tableName;
    }

    /**
     * {@inheritDoc}
     *
     * Sqlite Platform emulates schema by underscoring each dot and generating tables
     * into the default database.
     *
     * This hack is implemented to be able to use SQLite as testdriver when
     * using schema supporting databases.
     */
    public function canEmulateSchemas()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsForeignKeyConstraints()
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatePrimaryKeySQL(Index $index, $table)
    {
        throw new DBALException('Sqlite platform does not support alter primary key.');
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateForeignKeySQL(ForeignKeyConstraint $foreignKey, $table)
    {
        throw new DBALException('Sqlite platform does not support alter foreign key.');
    }

    /**
     * {@inheritdoc}
     */
    public function getDropForeignKeySQL($foreignKey, $table)
    {
        throw new DBALException('Sqlite platform does not support alter foreign key.');
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateConstraintSQL(Constraint $constraint, $table)
    {
        throw new DBALException('Sqlite platform does not support alter constraint.');
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateTableSQL(Table $table