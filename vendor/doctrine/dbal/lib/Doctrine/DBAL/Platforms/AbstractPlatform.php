<?php

namespace Doctrine\DBAL\Platforms;

use function explode;

/**
 * Provides the behavior, features and SQL dialect of the PostgreSQL 9.1 database platform.
 */
class PostgreSQL91Platform extends PostgreSqlPlatform
{
    /**
     * {@inheritDoc}
     */
    public function supportsColumnCollation()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\PostgreSQL91Keywords::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getColumnCollationDeclarationSQL($collation)
    {
        return 'COLLATE ' . $this->quoteSingleIdentifier($collation);
    }

    /**
     * {@inheritDoc}
     */
    public function getListTableColumnsSQL($table, $database = null)
    {
        $sql   = parent::getListTableColumnsSQL($table, $database);
        $parts = explode('AS complete_type,', $sql, 2);

        return $parts[0] . 'AS complete_type, (SELECT tc.collcollate FROM pg_catalog.pg_collation tc WHERE tc.oid = a.attcollation) AS collation,' . $parts[1];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Types\Type;
use function sprintf;

/**
 * Provides the behavior, features and SQL dialect of the PostgreSQL 9.2 database platform.
 */
class PostgreSQL92Platform extends PostgreSQL91Platform
{
    /**
     * {@inheritdoc}
     */
    public function getJsonTypeDeclarationSQL(array $field)
    {
        return 'JSON';
    }

    /**
     * {@inheritdoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $field)
    {
        if (! empty($field['autoincrement'])) {
            return 'SMALLSERIAL';
        }

        return parent::getSmallIntTypeDeclarationSQL($field);
    }

    /**
     * {@inheritdoc}
     */
    public function hasNativeJsonType()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\PostgreSQL92Keywords::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        parent::initializeDoctrineTypeMappings();

        $this->doctrineTypeMapping['json'] = Type::JSON;
    }

    /**
     * {@inheritdoc}
     */
    public function getCloseActiveDatabaseConnectionsSQL($database)
    {
        return sprintf(
            'SELECT pg_terminate_backend(pid) FROM pg_stat_activity WHERE datname = %s',
            $this->quoteStringLiteral($database)
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Types\Type;

/**
 * Provides the behavior, features and SQL dialect of the PostgreSQL 9.4 database platform.
 */
class PostgreSQL94Platform extends PostgreSQL92Platform
{
    /**
     * {@inheritdoc}
     */
    public function getJsonTypeDeclarationSQL(array $field)
    {
        if (! empty($field['jsonb'])) {
            return 'JSONB';
        }

        return 'JSON';
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\PostgreSQL94Keywords::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        parent::initializeDoctrineTypeMappings();

        $this->doctrineTypeMapping['jsonb'] = Type::JSON;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ColumnDiff;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Identifier;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Sequence;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\Types\BigIntType;
use Doctrine\DBAL\Types\BinaryType;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\Type;
use UnexpectedValueException;
use function array_diff;
use function array_merge;
use function array_unique;
use function array_values;
use function count;
use function explode;
use function implode;
use function in_array;
use function is_array;
use function is_bool;
use function is_numeric;
use function is_string;
use function sprintf;
use function strpos;
use function strtolower;
use function trim;

/**
 * PostgreSqlPlatform.
 *
 * @todo   Rename: PostgreSQLPlatform
 */
class PostgreSqlPlatform extends AbstractPlatform
{
    /** @var bool */
    private $useBooleanTrueFalseStrings = true;

    /** @var string[][] PostgreSQL booleans literals */
    private $booleanLiterals = [
        'true' => [
            't',
            'true',
            'y',
            'yes',
            'on',
            '1',
        ],
        'false' => [
            'f',
            'false',
            'n',
            'no',
            'off',
            '0',
        ],
    ];

    /**
     * PostgreSQL has different behavior with some drivers
     * with regard to how booleans have to be handled.
     *
     * Enables use of 'true'/'false' or otherwise 1 and 0 instead.
     *
     * @param bool $flag
     */
    public function setUseBooleanTrueFalseStrings($flag)
    {
        $this->useBooleanTrueFalseStrings = (bool) $flag;
    }

    /**
     * {@inheritDoc}
     */
    public function getSubstringExpression($value, $from, $length = null)
    {
        if ($length === null) {
            return 'SUBSTRING(' . $value . ' FROM ' . $from . ')';
        }

        return 'SUBSTRING(' . $value . ' FROM ' . $from . ' FOR ' . $length . ')';
    }

    /**
     * {@inheritDoc}
     */
    public function getNowExpression()
    {
        return 'LOCALTIMESTAMP(0)';
    }

    /**
     * {@inheritDoc}
     */
    public function getRegexpExpression()
    {
        return 'SIMILAR TO';
    }

    /**
     * {@inheritDoc}
     */
    public function getLocateExpression($str, $substr, $startPos = false)
    {
        if ($startPos !== false) {
            $str = $this->getSubstringExpression($str, $startPos);

            return 'CASE WHEN (POSITION(' . $substr . ' IN ' . $str . ') = 0) THEN 0 ELSE (POSITION(' . $substr . ' IN ' . $str . ') + ' . ($startPos-1) . ') END';
        }

        return 'POSITION(' . $substr . ' IN ' . $str . ')';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDateArithmeticIntervalExpression($date, $operator, $interval, $unit)
    {
        if ($unit === DateIntervalUnit::QUARTER) {
            $interval *= 3;
            $unit      = DateIntervalUnit::MONTH;
        }

        return '(' . $date . ' ' . $operator . ' (' . $interval . " || ' " . $unit . "')::interval)";
    }

    /**
     * {@inheritDoc}
     */
    public function getDateDiffExpression($date1, $date2)
    {
        return '(DATE(' . $date1 . ')-DATE(' . $date2 . '))';
    }

    /**
     * {@inheritDoc}
     */
    public function supportsSequences()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsSchemas()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultSchemaName()
    {
        return 'public';
    }

    /**
     * {@inheritDoc}
     */
    public function supportsIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsPartialIndexes()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function usesSequenceEmulatedIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentitySequenceName($tableName, $columnName)
    {
        return $tableName . '_' . $columnName . '_seq';
    }

    /**
     * {@inheritDoc}
     */
    public function supportsCommentOnStatement()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function prefersSequences()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function hasNativeGuidType()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getListDatabasesSQL()
    {
        return 'SELECT datname FROM pg_database';
    }

    /**
     * {@inheritDoc}
     */
    public function getListNamespacesSQL()
    {
        return "SELECT schema_name AS nspname
                FROM   information_schema.schemata
                WHERE  schema_name NOT LIKE 'pg\_%'
                AND    schema_name != 'information_schema'";
    }

    /**
     * {@inheritDoc}
     */
    public function getListSequencesSQL($database)
    {
        return "SELECT sequence_name AS relname,
                       sequence_schema AS schemaname
                FROM   information_schema.sequences
                WHERE  sequence_schema NOT LIKE 'pg\_%'
                AND    sequence_schema != 'information_schema'";
    }

    /**
     * {@inheritDoc}
     */
    public function getListTablesSQL()
    {
        return "SELECT quote_ident(table_name) AS table_name,
                       table_schema AS schema_name
                FROM   information_schema.tables
                WHERE  table_schema NOT LIKE 'pg\_%'
                AND    table_schema != 'information_schema'
                AND    table_name != 'geometry_columns'
                AND    table_name != 'spatial_ref_sys'
                AND    table_type != 'VIEW'";
    }

    /**
     * {@inheritDoc}
     */
    public function getListViewsSQL($database)
    {
        return 'SELECT quote_ident(table_name) AS viewname,
                       table_schema AS schemaname,
                       view_definition AS definition
                FROM   information_schema.views
                WHERE  view_definition IS NOT NULL';
    }

    /**
     * {@inheritDoc}
     */
    public function getListTableForeignKeysSQL($table, $database = null)
    {
        return 'SELECT quote_ident(r.conname) as conname, pg_catalog.pg_get_constraintdef(r.oid, true) as condef
                  FROM pg_catalog.pg_constraint r
                  WHERE r.conrelid =
                  (
                      SELECT c.oid
                      FROM pg_catalog.pg_class c, pg_catalog.pg_namespace n
                      WHERE ' . $this->getTableWhereClause($table) . " AND n.oid = c.relnamespace
                  )
                  AND r.contype = 'f'";
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
    public function getListTableConstraintsSQL($table)
    {
        $table = new Identifier($table);
        $table = $this->quoteStringLiteral($table->getName());

        return sprintf(
            <<<'SQL'
SELECT
    quote_ident(relname) as relname
FROM
    pg_class
WHERE oid IN (
    SELECT indexrelid
    FROM pg_index, pg_class
    WHERE pg_class.relname = %s
        AND pg_class.oid = pg_index.indrelid
        AND (indisunique = 't' OR indisprimary = 't')
    )
SQL
            ,
            $table
        );
    }

    /**
     * {@inheritDoc}
     *
     * @link http://ezcomponents.org/docs/api/trunk/DatabaseSchema/ezcDbSchemaPgsqlReader.html
     */
    public function getListTableIndexesSQL($table, $currentDatabase = null)
    {
        return 'SELECT quote_ident(relname) as relname, pg_index.indisunique, pg_index.indisprimary,
                       pg_index.indkey, pg_index.indrelid,
                       pg_get_expr(indpred, indrelid) AS where
                 FROM pg_class, pg_index
                 WHERE oid IN (
                    SELECT indexrelid
                    FROM pg_index si, pg_class sc, pg_namespace sn
                    WHERE ' . $this->getTableWhereClause($table, 'sc', 'sn') . ' AND sc.oid=si.indrelid AND sc.relnamespace = sn.oid
                 ) AND pg_index.indexrelid = oid';
    }

    /**
     * @param string $table
     * @param string $classAlias
     * @param string $namespaceAlias
     *
     * @return string
     */
    private function getTableWhereClause($table, $classAlias = 'c', $namespaceAlias = 'n')
    {
        $whereClause = $namespaceAlias . ".nspname NOT IN ('pg_catalog', 'information_schema', 'pg_toast') AND ";
        if (strpos($table, '.') !== false) {
            [$schema, $table] = explode('.', $table);
            $schema           = $this->quoteStringLiteral($schema);
        } else {
            $schema = "ANY(string_to_array((select replace(replace(setting,'\"\$user\"',user),' ','') from pg_catalog.pg_settings where name = 'search_path'),','))";
        }

        $table = new Identifier($table);
        $table = $this->quoteStringLiteral($table->getName());

        return $whereClause . sprintf(
            '%s.relname = %s AND %s.nspname = %s',
            $classAlias,
            $table,
            $namespaceAlias,
            $schema
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getListTableColumnsSQL($table, $database = null)
    {
        return "SELECT
                    a.attnum,
                    quote_ident(a.attname) AS field,
                    t.typname AS type,
                    format_type(a.atttypid, a.atttypmod) AS complete_type,
                    (SELECT t1.typname FROM pg_catalog.pg_type t1 WHERE t1.oid = t.typbasetype) AS domain_type,
                    (SELECT format_type(t2.typbasetype, t2.typtypmod) FROM
                      pg_catalog.pg_type t2 WHERE t2.typtype = 'd' AND t2.oid = a.atttypid) AS domain_complete_type,
                    a.attnotnull AS isnotnull,
                    (SELECT 't'
                     FROM pg_index
                     WHERE c.oid = pg_index.indrelid
                        AND pg_index.indkey[0] = a.attnum
                        AND pg_index.indisprimary = 't'
                    ) AS pri,
                    (SELECT pg_get_expr(adbin, adrelid)
                     FROM pg_attrdef
                     WHERE c.oid = pg_attrdef.adrelid
                        AND pg_attrdef.adnum=a.attnum
                    ) AS default,
                    (SELECT pg_description.description
                        FROM pg_description WHERE pg_description.objoid = c.oid AND a.attnum = pg_description.objsubid
                    ) AS comment
                    FROM pg_attribute a, pg_class c, pg_type t, pg_namespace n
                    WHERE " . $this->getTableWhereClause($table, 'c', 'n') . '
                        AND a.attnum > 0
                        AND a.attrelid = c.oid
                        AND a.atttypid = t.oid
                        AND n.oid = c.relnamespace
                    ORDER BY a.attnum';
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateDatabaseSQL($name)
    {
        return 'CREATE DATABASE ' . $name;
    }

    /**
     * Returns the SQL statement for disallowing new connections on the given database.
     *
     * This is useful to force DROP DATABASE operations which could fail because of active connections.
     *
     * @param string $database The name of the database to disallow new connections for.
     *
     * @return string
     */
    public function getDisallowDatabaseConnectionsSQL($database)
    {
        return "UPDATE pg_database SET datallowconn = 'false' WHERE datname = " . $this->quoteStringLiteral($database);
    }

    /**
     * Returns the SQL statement for closing currently active connections on the given database.
     *
     * This is useful to force DROP DATABASE operations which could fail because of active connections.
     *
     * @param string $database The name of the database to close currently active connections for.
     *
     * @return string
     */
    public function getCloseActiveDatabaseConnectionsSQL($database)
    {
        return 'SELECT pg_terminate_backend(procpid) FROM pg_stat_activity WHERE datname = '
            . $this->quoteStringLiteral($database);
    }

    /**
     * {@inheritDoc}
     */
    public function getAdvancedForeignKeyOptionsSQL(ForeignKeyConstraint $foreignKey)
    {
        $query = '';

        if ($foreignKey->hasOption('match')) {
            $query .= ' MATCH ' . $foreignKey->getOption('match');
        }

        $query .= parent::getAdvancedForeignKeyOptionsSQL($foreignKey);

        if ($foreignKey->hasOption('deferrable') && $foreignKey->getOption('deferrable') !== false) {
            $query .= ' DEFERRABLE';
        } else {
            $query .= ' NOT DEFERRABLE';
        }

        if (($foreignKey->hasOption('feferred') && $foreignKey->getOption('feferred') !== false)
            || ($foreignKey->hasOption('deferred') && $foreignKey->getOption('deferred') !== false)
        ) {
            $query .= ' INITIALLY DEFERRED';
        } else {
            $query .= ' INITIALLY IMMEDIATE';
        }

        return $query;
    }

    /**
     * {@inheritDoc}
     */
    public function getAlterTableSQL(TableDiff $diff)
    {
        $sql         = [];
        $commentsSQL = [];
        $columnSql   = [];

        foreach ($diff->addedColumns as $column) {
            if ($this->onSchemaAlterTableAddColumn($column, $diff, $columnSql)) {
                continue;
            }

            $query = 'ADD ' . $this->getColumnDeclarationSQL($column->getQuotedName($this), $column->toArray());
            $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;

            $comment = $this->getColumnComment($column);

            if ($comment === null || $comment === '') {
                continue;
            }

            $commentsSQL[] = $this->getCommentOnColumnSQL(
                $diff->getName($this)->getQuotedName($this),
                $column->getQuotedName($this),
                $comment
            );
        }

        foreach ($diff->removedColumns as $column) {
            if ($this->onSchemaAlterTableRemoveColumn($column, $diff, $columnSql)) {
                continue;
            }

            $query = 'DROP ' . $column->getQuotedName($this);
            $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;
        }

        foreach ($diff->changedColumns as $columnDiff) {
            /** @var $columnDiff \Doctrine\DBAL\Schema\ColumnDiff */
            if ($this->onSchemaAlterTableChangeColumn($columnDiff, $diff, $columnSql)) {
                continue;
            }

            if ($this->isUnchangedBinaryColumn($columnDiff)) {
                continue;
            }

            $oldColumnName = $columnDiff->getOldColumnName()->getQuotedName($this);
            $column        = $columnDiff->column;

            if ($columnDiff->hasChanged('type') || $columnDiff->hasChanged('precision') || $columnDiff->hasChanged('scale') || $columnDiff->hasChanged('fixed')) {
                $type = $column->getType();

                // SERIAL/BIGSERIAL are not "real" types and we can't alter a column to that type
                $columnDefinition                  = $column->toArray();
                $columnDefinition['autoincrement'] = false;

                // here was a server version check before, but DBAL API does not support this anymore.
                $query = 'ALTER ' . $oldColumnName . ' TYPE ' . $type->getSQLDeclaration($columnDefinition, $this);
                $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;
            }

            if ($columnDiff->hasChanged('default') || $this->typeChangeBreaksDefaultValue($columnDiff)) {
                $defaultClause = $column->getDefault() === null
                    ? ' DROP DEFAULT'
                    : ' SET' . $this->getDefaultValueDeclarationSQL($column->toArray());
                $query         = 'ALTER ' . $oldColumnName . $defaultClause;
                $sql[]         = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;
            }

            if ($columnDiff->hasChanged('notnull')) {
                $query = 'ALTER ' . $oldColumnName . ' ' . ($column->getNotnull() ? 'SET' : 'DROP') . ' NOT NULL';
                $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;
            }

            if ($columnDiff->hasChanged('autoincrement')) {
                if ($column->getAutoincrement()) {
                    // add autoincrement
                    $seqName = $this->getIdentitySequenceName($diff->name, $oldColumnName);

                    $sql[] = 'CREATE SEQUENCE ' . $seqName;
                    $sql[] = "SELECT setval('" . $seqName . "', (SELECT MAX(" . $oldColumnName . ') FROM ' . $diff->getName($this)->getQuotedName($this) . '))';
                    $query = 'ALTER ' . $oldColumnName . " SET DEFAULT nextval('" . $seqName . "')";
                    $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;
                } else {
                    // Drop autoincrement, but do NOT drop the sequence. It might be re-used by other tables or have
                    $query = 'ALTER ' . $oldColumnName . ' DROP DEFAULT';
                    $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;
                }
            }

            $newComment = $this->getColumnComment($column);
            $oldComment = $this->getOldColumnComment($columnDiff);

            if ($columnDiff->hasChanged('comment') || ($columnDiff->fromColumn !== null && $oldComment !== $newComment)) {
                $commentsSQL[] = $this->getCommentOnColumnSQL(
                    $diff->getName($this)->getQuotedName($this),
                    $column->getQuotedName($this),
                    $newComment
                );
            }

            if (! $columnDiff->hasChanged('length')) {
                continue;
            }

            $query = 'ALTER ' . $oldColumnName . ' TYPE ' . $column->getType()->getSQLDeclaration($column->toArray(), $this);
            $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' ' . $query;
        }

        foreach ($diff->renamedColumns as $oldColumnName => $column) {
            if ($this->onSchemaAlterTableRenameColumn($oldColumnName, $column, $diff, $columnSql)) {
                continue;
            }

            $oldColumnName = new Identifier($oldColumnName);

            $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) .
                ' RENAME COLUMN ' . $oldColumnName->getQuotedName($this) . ' TO ' . $column->getQuotedName($this);
        }

        $tableSql = [];

        if (! $this->onSchemaAlterTable($diff, $tableSql)) {
            $sql = array_merge($sql, $commentsSQL);

            if ($diff->newName !== false) {
                $sql[] = 'ALTER TABLE ' . $diff->getName($this)->getQuotedName($this) . ' RENAME TO ' . $diff->getNewName()->getQuotedName($this);
            }

            $sql = array_merge(
                $this->getPreAlterTableIndexForeignKeySQL($diff),
                $sql,
                $this->getPostAlterTableIndexForeignKeySQL($diff)
            );
        }

        return array_merge($sql, $tableSql, $columnSql);
    }

    /**
     * Checks whether a given column diff is a logically unchanged binary type column.
     *
     * Used to determine whether a column alteration for a binary type column can be skipped.
     * Doctrine's {@link \Doctrine\DBAL\Types\BinaryType} and {@link \Doctrine\DBAL\Types\BlobType}
     * are mapped to the same database column type on this platform as this platform
     * does not have a native VARBINARY/BINARY column type. Therefore the {@link \Doctrine\DBAL\Schema\Comparator}
     * might detect differences for binary type columns which do not have to be propagated
     * to database as there actually is no difference at database level.
     *
     * @param ColumnDiff $columnDiff The column diff to check against.
     *
     * @return bool True if the given column diff is an unchanged binary type column, false otherwise.
     */
    private function isUnchangedBinaryColumn(ColumnDiff $columnDiff)
    {
        $columnType = $columnDiff->column->getType();

        if (! $columnType instanceof BinaryType && ! $columnType instanceof BlobType) {
            return false;
        }

        $fromColumn = $columnDiff->fromColumn instanceof Column ? $columnDiff->fromColumn : null;

        if ($fromColumn) {
            $fromColumnType = $fromColumn->getType();

            if (! $fromColumnType instanceof BinaryType && ! $fromColumnType instanceof BlobType) {
                return false;
            }

            return count(array_diff($columnDiff->changedProperties, ['type', 'length', 'fixed'])) === 0;
        }

        if ($columnDiff->hasChanged('type')) {
            return false;
        }

        return count(array_diff($columnDiff->changedProperties, ['length', 'fixed'])) === 0;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRenameIndexSQL($oldIndexName, Index $index, $tableName)
    {
        if (strpos($tableName, '.') !== false) {
            [$schema]     = explode('.', $tableName);
            $oldIndexName = $schema . '.' . $oldIndexName;
        }

        return ['ALTER INDEX ' . $oldIndexName . ' RENAME TO ' . $index->getQuotedName($this)];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommentOnColumnSQL($tableName, $columnName, $comment)
    {
        $tableName  = new Identifier($tableName);
        $columnName = new Identifier($columnName);
        $comment    = $comment === null ? 'NULL' : $this->quoteStringLiteral($comment);

        return sprintf(
            'COMMENT ON COLUMN %s.%s IS %s',
            $tableName->getQuotedName($this),
            $columnName->getQuotedName($this),
            $comment
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateSequenceSQL(Sequence $sequence)
    {
        return 'CREATE SEQUENCE ' . $sequence->getQuotedName($this) .
            ' INCREMENT BY ' . $sequence->getAllocationSize() .
            ' MINVALUE ' . $sequence->getInitialValue() .
            ' START ' . $sequence->getInitialValue() .
            $this->getSequenceCacheSQL($sequence);
    }

    /**
     * {@inheritDoc}
     */
    public function getAlterSequenceSQL(Sequence $sequence)
    {
        return 'ALTER SEQUENCE ' . $sequence->getQuotedName($this) .
            ' INCREMENT BY ' . $sequence->getAllocationSize() .
            $this->getSequenceCacheSQL($sequence);
    }

    /**
     * Cache definition for sequences
     *
     * @return string
     */
    private function getSequenceCacheSQL(Sequence $sequence)
    {
        if ($sequence->getCache() > 1) {
            return ' CACHE ' . $sequence->getCache();
        }

        return '';
    }

    /**
     * {@inheritDoc}
     */
    public function getDropSequenceSQL($sequence)
    {
        if ($sequence instanceof Sequence) {
            $sequence = $sequence->getQuotedName($this);
        }

        return 'DROP SEQUENCE ' . $sequence . ' CASCADE';
    }

    /**
     * {@inheritDoc}
     */
    public function getCreateSchemaSQL($schemaName)
    {
        return 'CREATE SCHEMA ' . $schemaName;
    }

    /**
     * {@inheritDoc}
     */
    public function getDropForeignKeySQL($foreignKey, $table)
    {
        return $this->getDropConstraintSQL($foreignKey, $table);
    }

    /**
     * {@inheritDoc}
     */
    protected function _getCreateTableSQL($tableName, array $columns, array $options = [])
    {
        $queryFields = $this->getColumnDeclarationListSQL($columns);

        if (isset($options['primary']) && ! empty($options['primary'])) {
            $keyColumns   = array_unique(array_values($options['primary']));
            $queryFields .= ', PRIMARY KEY(' . implode(', ', $keyColumns) . ')';
        }

        $query = 'CREATE TABLE ' . $tableName . ' (' . $queryFields . ')';

        $sql = [$query];

        if (isset($options['indexes']) && ! empty($options['indexes'])) {
            foreach ($options['indexes'] as $index) {
                $sql[] = $this->getCreateIndexSQL($index, $tableName);
            }
        }

        if (isset($options['foreignKeys'])) {
            foreach ((array) $options['foreignKeys'] as $definition) {
                $sql[] = $this->getCreateForeignKeySQL($definition, $tableName);
            }
        }

        return $sql;
    }

    /**
     * Converts a single boolean value.
     *
     * First converts the value to its native PHP boolean type
     * and passes it to the given callback function to be reconverted
     * into any custom representation.
     *
     * @param mixed    $value    The value to convert.
     * @param callable $callback The callback function to use for converting the real boolean value.
     *
     * @return mixed
     *
     * @throws UnexpectedValueException
     */
    private function convertSingleBooleanValue($value, $callback)
    {
        if ($value === null) {
            return $callback(null);
        }

        if (is_bool($value) || is_numeric($value)) {
            return $callback($value ? true : false);
        }

        if (! is_string($value)) {
            return $callback(true);
        }

        /**
         * Better safe than sorry: http://php.net/in_array#106319
         */
        if (in_array(strtolower(trim($value)), $this->booleanLiterals['false'], true)) {
            return $callback(false);
        }

        if (in_array(strtolower(trim($value)), $this->booleanLiterals['true'], true)) {
            return $callback(true);
        }

        throw new UnexpectedValueException("Unrecognized boolean literal '${value}'");
    }

    /**
     * Converts one or multiple boolean values.
     *
     * First converts the value(s) to their native PHP boolean type
     * and passes them to the given callback function to be reconverted
     * into any custom representation.
     *
     * @param mixed    $item     The value(s) to convert.
     * @param callable $callback The callback function to use for converting the real boolean value(s).
     *
     * @return mixed
     */
    private function doConvertBooleans($item, $callback)
    {
        if (is_array($item)) {
            foreach ($item as $key => $value) {
                $item[$key] = $this->convertSingleBooleanValue($value, $callback);
            }

            return $item;
        }

        return $this->convertSingleBooleanValue($item, $callback);
    }

    /**
     * {@inheritDoc}
     *
     * Postgres wants boolean values converted to the strings 'true'/'false'.
     */
    public function convertBooleans($item)
    {
        if (! $this->useBooleanTrueFalseStrings) {
            return parent::convertBooleans($item);
        }

        return $this->doConvertBooleans(
            $item,
            static function ($boolean) {
                if ($boolean === null) {
                    return 'NULL';
                }

                return $boolean === true ? 'true' : 'false';
            }
        );
    }

    /**
     * {@inheritDoc}
     */
    public function convertBooleansToDatabaseValue($item)
    {
        if (! $this->useBooleanTrueFalseStrings) {
            return parent::convertBooleansToDatabaseValue($item);
        }

        return $this->doConvertBooleans(
            $item,
            static function ($boolean) {
                return $boolean === null ? null : (int) $boolean;
            }
        );
    }

    /**
     * {@inheritDoc}
     */
    public function convertFromBoolean($item)
    {
        if (in_array(strtolower($item), $this->booleanLiterals['false'], true)) {
            return false;
        }

        return parent::convertFromBoolean($item);
    }

    /**
     * {@inheritDoc}
     */
    public function getSequenceNextValSQL($sequenceName)
    {
        return "SELECT NEXTVAL('" . $sequenceName . "')";
    }

    /**
     * {@inheritDoc}
     */
    public function getSetTransactionIsolationSQL($level)
    {
        return 'SET SESSION CHARACTERISTICS AS TRANSACTION ISOLATION LEVEL '
            . $this->_getTransactionIsolationLevelSQL($level);
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
        if (! empty($field['autoincrement'])) {
            return 'SERIAL';
        }

        return 'INT';
    }

    /**
     * {@inheritDoc}
     */
    public function getBigIntTypeDeclarationSQL(array $field)
    {
        if (! empty($field['autoincrement'])) {
            return 'BIGSERIAL';
        }

        return 'BIGINT';
    }

    /**
     * {@inheritDoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $field)
    {
        return 'SMALLINT';
    }

    /**
     * {@inheritDoc}
     */
    public function getGuidTypeDeclarationSQL(array $field)
    {
        return 'UUID';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIMESTAMP(0) WITHOUT TIME ZONE';
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTzTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIMESTAMP(0) WITH TIME ZONE';
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
        return 'TIME(0) WITHOUT TIME ZONE';
    }

    /**
     * {@inheritDoc}
     *
     * @deprecated Use application-generated UUIDs instead
     */
    public function getGuidExpression()
    {
        return 'UUID_GENERATE_V4()';
    }

    /**
     * {@inheritDoc}
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        return '';
    }

    /**
     * {@inheritDoc}
     */
    protected function getVarcharTypeDeclarationSQLSnippet($length, $fixed)
    {
        return $fixed ? ($length ? 'CHAR(' . $length . ')' : 'CHAR(255)')
            : ($length ? 'VARCHAR(' . $length . ')' : 'VARCHAR(255)');
    }

    /**
     * {@inheritdoc}
     */
    protected function getBinaryTypeDeclarationSQLSnippet($length, $fixed)
    {
        return 'BYTEA';
    }

    /**
     * {@inheritDoc}
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
        return 'TEXT';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'postgresql';
    }

    /**
     * {@inheritDoc}
     *
     * PostgreSQL returns all column names in SQL result sets in lowercase.
     */
    public function getSQLResultCasing($column)
    {
        return strtolower($column);
    }

    /**
     * {@inheritDoc}
     */
    public function getDateTimeTzFormatString()
    {
        return 'Y-m-d H:i:sO';
    }

    /**
     * {@inheritDoc}
     */
    public function getEmptyIdentityInsertSQL($quotedTableName, $quotedIdentifierColumnName)
    {
        return 'INSERT INTO ' . $quotedTableName . ' (' . $quotedIdentifierColumnName . ') VALUES (DEFAULT)';
    }

    /**
     * {@inheritDoc}
     */
    public function getTruncateTableSQL($tableName, $cascade = false)
    {
        $tableIdentifier = new Identifier($tableName);
        $sql             = 'TRUNCATE ' . $tableIdentifier->getQuotedName($this);

        if ($cascade) {
            $sql .= ' CASCADE';
        }

        return $sql;
    }

    /**
     * {@inheritDoc}
     */
    public function getReadLockSQL()
    {
        return 'FOR SHARE';
    }

    /**
     * {@inheritDoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        $this->doctrineTypeMapping = [
            'smallint'      => 'smallint',
            'int2'          => 'smallint',
            'serial'        => 'integer',
            'serial4'       => 'integer',
            'int'           => 'integer',
            'int4'          => 'integer',
            'integer'       => 'integer',
            'bigserial'     => 'bigint',
            'serial8'       => 'bigint',
            'bigint'        => 'bigint',
            'int8'          => 'bigint',
            'bool'          => 'boolean',
            'boolean'       => 'boolean',
            'text'          => 'text',
            'tsvector'      => 'text',
            'varchar'       => 'string',
            'interval'      => 'string',
            '_varchar'      => 'string',
            'char'          => 'string',
            'bpchar'        => 'string',
            'inet'          => 'string',
            'date'          => 'date',
            'datetime'      => 'datetime',
            'timestamp'     => 'datetime',
            'timestamptz'   => 'datetimetz',
            'time'          => 'time',
            'timetz'        => 'time',
            'float'         => 'float',
            'float4'        => 'float',
            'float8'        => 'float',
            'double'        => 'float',
            'double precision' => 'float',
            'real'          => 'float',
            'decimal'       => 'decimal',
            'money'         => 'decimal',
            'numeric'       => 'decimal',
            'year'          => 'date',
            'uuid'          => 'guid',
            'bytea'         => 'blob',
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getVarcharMaxLength()
    {
        return 65535;
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
    protected function getReservedKeywordsClass()
    {
        return Keywords\PostgreSQLKeywords::class;
    }

    /**
     * {@inheritDoc}
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
        return 'BYTEA';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultValueDeclarationSQL($field)
    {
        if ($this->isSerialField($field)) {
            return '';
        }

        return parent::getDefaultValueDeclarationSQL($field);
    }

    /**
     * @param mixed[] $field
     */
    private function isSerialField(array $field) : bool
    {
        return $field['autoincrement'] ?? false === true && isset($field['type'])
            && $this->isNumericType($field['type']);
    }

    /**
     * Check whether the type of a column is changed in a way that invalidates the default value for the column
     */
    private function typeChangeBreaksDefaultValue(ColumnDiff $columnDiff) : bool
    {
        if (! $columnDiff->fromColumn) {
            return $columnDiff->hasChanged('type');
        }

        $oldTypeIsNumeric = $this->isNumericType($columnDiff->fromColumn->getType());
        $newTypeIsNumeric = $this->isNumericType($columnDiff->column->getType());

        // default should not be changed when switching between numeric types and the default comes from a sequence
        return $columnDiff->hasChanged('type')
            && ! ($oldTypeIsNumeric && $newTypeIsNumeric && $columnDiff->column->getAutoincrement());
    }

    private function isNumericType(Type $type) : bool
    {
        return $type instanceof IntegerType || $type instanceof BigIntType;
    }

    private function getOldColumnComment(ColumnDiff $columnDiff) : ?string
    {
        return $columnDiff->fromColumn ? $this->getColumnComment($columnDiff->fromColumn) : null;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Sequence;

/**
 * The SQLAnywhere12Platform provides the behavior, features and SQL dialect of the
 * SAP Sybase SQL Anywhere 12 database platform.
 */
class SQLAnywhere12Platform extends SQLAnywhere11Platform
{
    /**
     * {@inheritdoc}
     */
    public function getCreateSequenceSQL(Sequence $sequence)
    {
        return 'CREATE SEQUENCE ' . $sequence->getQuotedName($this) .
            ' INCREMENT BY ' . $sequence->getAllocationSize() .
            ' START WITH ' . $sequence->getInitialValue() .
            ' MINVALUE ' . $sequence->getInitialValue();
    }

    /**
     * {@inheritdoc}
     */
    public function getAlterSequenceSQL(Sequence $sequence)
    {
        return 'ALTER SEQUENCE ' . $sequence->getQuotedName($this) .
            ' INCREMENT BY ' . $sequence->getAllocationSize();
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTzFormatString()
    {
        return 'Y-m-d H:i:s.uP';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTzTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIMESTAMP WITH TIME ZONE';
    }

    /**
     * {@inheritdoc}
     */
    public function getDropSequenceSQL($sequence)
    {
        if ($sequence instanceof Sequence) {
            $sequence = $sequence->getQuotedName($this);
        }

        return 'DROP SEQUENCE ' . $sequence;
    }

    /**
     * {@inheritdoc}
     */
    public function getListSequencesSQL($database)
    {
        return 'SELECT sequence_name, increment_by, start_with, min_value FROM SYS.SYSSEQUENCE';
    }

    /**
     * {@inheritdoc}
     */
    public function getSequenceNextValSQL($sequenceName)
    {
        return 'SELECT ' . $sequenceName . '.NEXTVAL';
    }

    /**
     * {@inheritdoc}
     */
    public function supportsSequences()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAdvancedIndexOptionsSQL(Index $index)
    {
        if (! $index->isPrimary() && $index->isUnique() && $index->hasFlag('with_nulls_not_distinct')) {
            return ' WITH NULLS NOT DISTINCT' . parent::getAdvancedIndexOptionsSQL($index);
        }

        return parent::getAdvancedIndexOptionsSQL($index);
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\SQLAnywhere12Keywords::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        parent::initializeDoctrineTypeMappings();
        $this->doctrineTypeMapping['timestamp with time zone'] = 'datetime';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\Schema\Index;
use UnexpectedValueException;

/**
 * The SQLAnywhere16Platform provides the behavior, features and SQL dialect of the
 * SAP Sybase SQL Anywhere 16 database platform.
 */
class SQLAnywhere16Platform extends SQLAnywhere12Platform
{
    /**
     * {@inheritdoc}
     */
    protected function getAdvancedIndexOptionsSQL(Index $index)
    {
        if ($index->hasFlag('with_nulls_distinct') && $index->hasFlag('with_nulls_not_distinct')) {
            throw new UnexpectedValueException(
                'An Index can either have a "with_nulls_distinct" or "with_nulls_not_distinct" flag but not both.'
            );
        }

        if (! $index->isPrimary() && $index->isUnique() && $index->hasFlag('with_nulls_distinct')) {
            return ' WITH NULLS DISTINCT' . parent::getAdvancedIndexOptionsSQL($index);
        }

        return parent::getAdvancedIndexOptionsSQL($index);
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\SQLAnywhere16Keywords::class;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Doctrine\DBAL\Platforms;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\LockMode;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\ColumnDiff;
use Doctrine\DBAL\Schema\Constraint;
use Doctrine\DBAL\Schema\ForeignKeyConstraint;
use Doctrine\DBAL\Schema\Identifier;
use Doctrine\DBAL\Schema\Index;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\TableDiff;
use Doctrine\DBAL\TransactionIsolationLevel;
use InvalidArgumentException;
use function array_merge;
use function array_unique;
use function array_values;
use function count;
use function explode;
use function func_get_args;
use function get_class;
use function implode;
use function is_string;
use function preg_replace;
use function sprintf;
use function strlen;
use function strpos;
use function strtoupper;
use function substr;

/**
 * The SQLAnywherePlatform provides the behavior, features and SQL dialect of the
 * SAP Sybase SQL Anywhere 10 database platform.
 */
class SQLAnywherePlatform extends AbstractPlatform
{
    public const FOREIGN_KEY_MATCH_SIMPLE        = 1;
    public const FOREIGN_KEY_MATCH_FULL          = 2;
    public const FOREIGN_KEY_MATCH_SIMPLE_UNIQUE = 129;
    public const FOREIGN_KEY_MATCH_FULL_UNIQUE   = 130;

    /**
     * {@inheritdoc}
     */
    public function appendLockHint($fromClause, $lockMode)
    {
        switch (true) {
            case $lockMode === LockMode::NONE:
                return $fromClause . ' WITH (NOLOCK)';

            case $lockMode === LockMode::PESSIMISTIC_READ:
                return $fromClause . ' WITH (UPDLOCK)';

            case $lockMode === LockMode::PESSIMISTIC_WRITE:
                return $fromClause . ' WITH (XLOCK)';

            default:
                return $fromClause;
        }
    }

    /**
     * {@inheritdoc}
     *
     * SQL Anywhere supports a maximum length of 128 bytes for identifiers.
     */
    public function fixSchemaElementName($schemaElementName)
    {
        $maxIdentifierLength = $this->getMaxIdentifierLength();

        if (strlen($schemaElementName) > $maxIdentifierLength) {
            return substr($schemaElementName, 0, $maxIdentifierLength);
        }

        return $schemaElementName;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdvancedForeignKeyOptionsSQL(ForeignKeyConstraint $foreignKey)
    {
        $query = '';

        if ($foreignKey->hasOption('match')) {
            $query = ' MATCH ' . $this->getForeignKeyMatchClauseSQL($foreignKey->getOption('match'));
        }

        $query .= parent::getAdvancedForeignKeyOptionsSQL($foreignKey);

        if ($foreignKey->hasOption('check_on_commit') && (bool) $foreignKey->getOption('check_on_commit')) {
            $query .= ' CHECK ON COMMIT';
        }

        if ($foreignKey->hasOption('clustered') && (bool) $foreignKey->getOption('clustered')) {
            $query .= ' CLUSTERED';
        }

        if ($foreignKey->hasOption('for_olap_workload') && (bool) $foreignKey->getOption('for_olap_workload')) {
            $query .= ' FOR OLAP WORKLOAD';
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlterTableSQL(TableDiff $diff)
    {
        $sql          = [];
        $columnSql    = [];
        $commentsSQL  = [];
        $tableSql     = [];
        $alterClauses = [];

        foreach ($diff->addedColumns as $column) {
            if ($this->onSchemaAlterTableAddColumn($column, $diff, $columnSql)) {
                continue;
            }

            $alterClauses[] = $this->getAlterTableAddColumnClause($column);

            $comment = $this->getColumnComment($column);

            if ($comment === null || $comment === '') {
                continue;
            }

            $commentsSQL[] = $this->getCommentOnColumnSQL(
                $diff->getName($this)->getQuotedName($this),
                $column->getQuotedName($this),
                $comment
            );
        }

        foreach ($diff->removedColumns as $column) {
            if ($this->onSchemaAlterTableRemoveColumn($column, $diff, $columnSql)) {
                continue;
            }

            $alterClauses[] = $this->getAlterTableRemoveColumnClause($column);
        }

        foreach ($diff->changedColumns as $columnDiff) {
            if ($this->onSchemaAlterTableChangeColumn($columnDiff, $diff, $columnSql)) {
                continue;
            }

            $alterClause = $this->getAlterTableChangeColumnClause($columnDiff);

            if ($alterClause !== null) {
                $alterClauses[] = $alterClause;
            }

            if (! $columnDiff->hasChanged('comment')) {
                continue;
            }

            $column = $columnDiff->column;

            $commentsSQL[] = $this->getCommentOnColumnSQL(
                $diff->getName($this)->getQuotedName($this),
                $column->getQuotedName($this),
                $this->getColumnComment($column)
            );
        }

        foreach ($diff->renamedColumns as $oldColumnName => $column) {
            if ($this->onSchemaAlterTableRenameColumn($oldColumnName, $column, $diff, $columnSql)) {
                continue;
            }

            $sql[] = $this->getAlterTableClause($diff->getName($this)) . ' ' .
                $this->getAlterTableRenameColumnClause($oldColumnName, $column);
        }

        if (! $this->onSchemaAlterTable($diff, $tableSql)) {
            if (! empty($alterClauses)) {
                $sql[] = $this->getAlterTableClause($diff->getName($this)) . ' ' . implode(', ', $alterClauses);
            }

            $sql = array_merge($sql, $commentsSQL);

            if ($diff->newName !== false) {
                $sql[] = $this->getAlterTableClause($diff->getName($this)) . ' ' .
                    $this->getAlterTableRenameTableClause($diff->getNewName());
            }

            $sql = array_merge(
                $this->getPreAlterTableIndexForeignKeySQL($diff),
                $sql,
                $this->getPostAlterTableIndexForeignKeySQL($diff)
            );
        }

        return array_merge($sql, $tableSql, $columnSql);
    }

    /**
     * Returns the SQL clause for creating a column in a table alteration.
     *
     * @param Column $column The column to add.
     *
     * @return string
     */
    protected function getAlterTableAddColumnClause(Column $column)
    {
        return 'ADD ' . $this->getColumnDeclarationSQL($column->getQuotedName($this), $column->toArray());
    }

    /**
     * Returns the SQL clause for altering a table.
     *
     * @param Identifier $tableName The quoted name of the table to alter.
     *
     * @return string
     */
    protected function getAlterTableClause(Identifier $tableName)
    {
        return 'ALTER TABLE ' . $tableName->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for dropping a column in a table alteration.
     *
     * @param Column $column The column to drop.
     *
     * @return string
     */
    protected function getAlterTableRemoveColumnClause(Column $column)
    {
        return 'DROP ' . $column->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for renaming a column in a table alteration.
     *
     * @param string $oldColumnName The quoted name of the column to rename.
     * @param Column $column        The column to rename to.
     *
     * @return string
     */
    protected function getAlterTableRenameColumnClause($oldColumnName, Column $column)
    {
        $oldColumnName = new Identifier($oldColumnName);

        return 'RENAME ' . $oldColumnName->getQuotedName($this) . ' TO ' . $column->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for renaming a table in a table alteration.
     *
     * @param Identifier $newTableName The quoted name of the table to rename to.
     *
     * @return string
     */
    protected function getAlterTableRenameTableClause(Identifier $newTableName)
    {
        return 'RENAME ' . $newTableName->getQuotedName($this);
    }

    /**
     * Returns the SQL clause for altering a column in a table alteration.
     *
     * This method returns null in case that only the column comment has changed.
     * Changes in column comments have to be handled differently.
     *
     * @param ColumnDiff $columnDiff The diff of the column to alter.
     *
     * @return string|null
     */
    protected function getAlterTableChangeColumnClause(ColumnDiff $columnDiff)
    {
        $column = $columnDiff->column;

        // Do not return alter clause if only comment has changed.
        if (! ($columnDiff->hasChanged('comment') && count($columnDiff->changedProperties) === 1)) {
            $columnAlterationClause = 'ALTER ' .
                $this->getColumnDeclarationSQL($column->getQuotedName($this), $column->toArray());

            if ($columnDiff->hasChanged('default') && $column->getDefault() === null) {
                $columnAlterationClause .= ', ALTER ' . $column->getQuotedName($this) . ' DROP DEFAULT';
            }

            return $columnAlterationClause;
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getBigIntTypeDeclarationSQL(array $columnDef)
    {
        $columnDef['integer_type'] = 'BIGINT';

        return $this->_getCommonIntegerTypeDeclarationSQL($columnDef);
    }

    /**
     * {@inheritdoc}
     */
    public function getBinaryDefaultLength()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getBinaryMaxLength()
    {
        return 32767;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlobTypeDeclarationSQL(array $field)
    {
        return 'LONG BINARY';
    }

    /**
     * {@inheritdoc}
     *
     * BIT type columns require an explicit NULL declaration
     * in SQL Anywhere if they shall be nullable.
     * Otherwise by just omitting the NOT NULL clause,
     * SQL Anywhere will declare them NOT NULL nonetheless.
     */
    public function getBooleanTypeDeclarationSQL(array $columnDef)
    {
        $nullClause = isset($columnDef['notnull']) && (bool) $columnDef['notnull'] === false ? ' NULL' : '';

        return 'BIT' . $nullClause;
    }

    /**
     * {@inheritdoc}
     */
    public function getClobTypeDeclarationSQL(array $field)
    {
        return 'TEXT';
    }

    /**
     * {@inheritdoc}
     */
    public function getCommentOnColumnSQL($tableName, $columnName, $comment)
    {
        $tableName  = new Identifier($tableName);
        $columnName = new Identifier($columnName);
        $comment    = $comment === null ? 'NULL' : $this->quoteStringLiteral($comment);

        return sprintf(
            'COMMENT ON COLUMN %s.%s IS %s',
            $tableName->getQuotedName($this),
            $columnName->getQuotedName($this),
            $comment
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConcatExpression()
    {
        return 'STRING(' . implode(', ', (array) func_get_args()) . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateConstraintSQL(Constraint $constraint, $table)
    {
        if ($constraint instanceof ForeignKeyConstraint) {
            return $this->getCreateForeignKeySQL($constraint, $table);
        }

        if ($table instanceof Table) {
            $table = $table->getQuotedName($this);
        }

        return 'ALTER TABLE ' . $table .
               ' ADD ' . $this->getTableConstraintDeclarationSQL($constraint, $constraint->getQuotedName($this));
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return "CREATE DATABASE '" . $database->getName() . "'";
    }

    /**
     * {@inheritdoc}
     *
     * Appends SQL Anywhere specific flags if given.
     */
    public function getCreateIndexSQL(Index $index, $table)
    {
        return parent::getCreateIndexSQL($index, $table) . $this->getAdvancedIndexOptionsSQL($index);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreatePrimaryKeySQL(Index $index, $table)
    {
        if ($table instanceof Table) {
            $table = $table->getQuotedName($this);
        }

        return 'ALTER TABLE ' . $table . ' ADD ' . $this->getPrimaryKeyDeclarationSQL($index);
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateTemporaryTableSnippetSQL()
    {
        return 'CREATE ' . $this->getTemporaryTableSQL() . ' TABLE';
    }

    /**
     * {@inheritdoc}
     */
    public function getCreateViewSQL($name, $sql)
    {
        return 'CREATE VIEW ' . $name . ' AS ' . $sql;
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentDateSQL()
    {
        return 'CURRENT DATE';
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTimeSQL()
    {
        return 'CURRENT TIME';
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentTimestampSQL()
    {
        return 'CURRENT TIMESTAMP';
    }

    /**
     * {@inheritdoc}
     */
    protected function getDateArithmeticIntervalExpression($date, $operator, $interval, $unit)
    {
        $factorClause = '';

        if ($operator === '-') {
            $factorClause = '-1 * ';
        }

        return 'DATEADD(' . $unit . ', ' . $factorClause . $interval . ', ' . $date . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateDiffExpression($date1, $date2)
    {
        return 'DATEDIFF(day, ' . $date2 . ', ' . $date1 . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeFormatString()
    {
        return 'Y-m-d H:i:s.u';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATETIME';
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTimeTzFormatString()
    {
        return $this->getDateTimeFormatString();
    }

    /**
     * {@inheritdoc}
     */
    public function getDateTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'DATE';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultTransactionIsolationLevel()
    {
        return TransactionIsolationLevel::READ_UNCOMMITTED;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return "DROP DATABASE '" . $database->getName() . "'";
    }

    /**
     * {@inheritdoc}
     */
    public function getDropIndexSQL($index, $table = null)
    {
        if ($index instanceof Index) {
            $index = $index->getQuotedName($this);
        }

        if (! is_string($index)) {
            throw new InvalidArgumentException(
                'SQLAnywherePlatform::getDropIndexSQL() expects $index parameter to be string or ' . Index::class . '.'
            );
        }

        if (! isset($table)) {
            return 'DROP INDEX ' . $index;
        }

        if ($table instanceof Table) {
            $table = $table->getQuotedName($this);
        }

        if (! is_string($table)) {
            throw new InvalidArgumentException(
                'SQLAnywherePlatform::getDropIndexSQL() expects $table parameter to be string or ' . Index::class . '.'
            );
        }

        return 'DROP INDEX ' . $table . '.' . $index;
    }

    /**
     * {@inheritdoc}
     */
    public function getDropViewSQL($name)
    {
        return 'DROP VIEW ' . $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKeyBaseDeclarationSQL(ForeignKeyConstraint $foreignKey)
    {
        $sql              = '';
        $foreignKeyName   = $foreignKey->getName();
        $localColumns     = $foreignKey->getQuotedLocalColumns($this);
        $foreignColumns   = $foreignKey->getQuotedForeignColumns($this);
        $foreignTableName = $foreignKey->getQuotedForeignTableName($this);

        if (! empty($foreignKeyName)) {
            $sql .= 'CONSTRAINT ' . $foreignKey->getQuotedName($this) . ' ';
        }

        if (empty($localColumns)) {
            throw new InvalidArgumentException("Incomplete definition. 'local' required.");
        }

        if (empty($foreignColumns)) {
            throw new InvalidArgumentException("Incomplete definition. 'foreign' required.");
        }

        if (empty($foreignTableName)) {
            throw new InvalidArgumentException("Incomplete definition. 'foreignTable' required.");
        }

        if ($foreignKey->hasOption('notnull') && (bool) $foreignKey->getOption('notnull')) {
            $sql .= 'NOT NULL ';
        }

        return $sql .
            'FOREIGN KEY (' . $this->getIndexFieldDeclarationListSQL($localColumns) . ') ' .
            'REFERENCES ' . $foreignKey->getQuotedForeignTableName($this) .
            ' (' . $this->getIndexFieldDeclarationListSQL($foreignColumns) . ')';
    }

    /**
     * Returns foreign key MATCH clause for given type.
     *
     * @param int $type The foreign key match type
     *
     * @return string
     *
     * @throws InvalidArgumentException If unknown match type given.
     */
    public function getForeignKeyMatchClauseSQL($type)
    {
        switch ((int) $type) {
            case self::FOREIGN_KEY_MATCH_SIMPLE:
                return 'SIMPLE';
                break;
            case self::FOREIGN_KEY_MATCH_FULL:
                return 'FULL';
                break;
            case self::FOREIGN_KEY_MATCH_SIMPLE_UNIQUE:
                return 'UNIQUE SIMPLE';
                break;
            case self::FOREIGN_KEY_MATCH_FULL_UNIQUE:
                return 'UNIQUE FULL';
            default:
                throw new InvalidArgumentException('Invalid foreign key match type: ' . $type);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getForeignKeyReferentialActionSQL($action)
    {
        // NO ACTION is not supported, therefore falling back to RESTRICT.
        if (strtoupper($action) === 'NO ACTION') {
            return 'RESTRICT';
        }

        return parent::getForeignKeyReferentialActionSQL($action);
    }

    /**
     * {@inheritdoc}
     */
    public function getForUpdateSQL()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated Use application-generated UUIDs instead
     */
    public function getGuidExpression()
    {
        return 'NEWID()';
    }

    /**
     * {@inheritdoc}
     */
    public function getGuidTypeDeclarationSQL(array $field)
    {
        return 'UNIQUEIDENTIFIER';
    }

    /**
     * {@inheritdoc}
     */
    public function getIndexDeclarationSQL($name, Index $index)
    {
        // Index declaration in statements like CREATE TABLE is not supported.
        throw DBALException::notSupported(__METHOD__);
    }

    /**
     * {@inheritdoc}
     */
    public function getIntegerTypeDeclarationSQL(array $columnDef)
    {
        $columnDef['integer_type'] = 'INT';

        return $this->_getCommonIntegerTypeDeclarationSQL($columnDef);
    }

    /**
     * {@inheritdoc}
     */
    public function getListDatabasesSQL()
    {
        return 'SELECT db_name(number) AS name FROM sa_db_list()';
    }

    /**
     * {@inheritdoc}
     */
    public function getListTableColumnsSQL($table, $database = null)
    {
        $user = 'USER_NAME()';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
        }

        return sprintf(
            <<<'SQL'
SELECT    col.column_name,
          COALESCE(def.user_type_name, def.domain_name) AS 'type',
          def.declared_width AS 'length',
          def.scale,
          CHARINDEX('unsigned', def.domain_name) AS 'unsigned',
          IF col.nulls = 'Y' THEN 0 ELSE 1 ENDIF AS 'notnull',
          col."default",
          def.is_autoincrement AS 'autoincrement',
          rem.remarks AS 'comment'
FROM      sa_describe_query('SELECT * FROM "%s"') AS def
JOIN      SYS.SYSTABCOL AS col
ON        col.table_id = def.base_table_id AND col.column_id = def.base_column_id
LEFT JOIN SYS.SYSREMARK AS rem
ON        col.object_id = rem.object_id
WHERE     def.base_owner_name = %s
ORDER BY  def.base_column_id ASC
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     *
     * @todo Where is this used? Which information should be retrieved?
     */
    public function getListTableConstraintsSQL($table)
    {
        $user = '';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
            $table          = $this->quoteStringLiteral($table);
        } else {
            $table = $this->quoteStringLiteral($table);
        }

        return sprintf(
            <<<'SQL'
SELECT con.*
FROM   SYS.SYSCONSTRAINT AS con
JOIN   SYS.SYSTAB AS tab ON con.table_object_id = tab.object_id
WHERE  tab.table_name = %s
AND    tab.creator = USER_ID(%s)
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getListTableForeignKeysSQL($table)
    {
        $user = '';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
            $table          = $this->quoteStringLiteral($table);
        } else {
            $table = $this->quoteStringLiteral($table);
        }

        return sprintf(
            <<<'SQL'
SELECT    fcol.column_name AS local_column,
          ptbl.table_name AS foreign_table,
          pcol.column_name AS foreign_column,
          idx.index_name,
          IF fk.nulls = 'N'
              THEN 1
              ELSE NULL
          ENDIF AS notnull,
          CASE ut.referential_action
              WHEN 'C' THEN 'CASCADE'
              WHEN 'D' THEN 'SET DEFAULT'
              WHEN 'N' THEN 'SET NULL'
              WHEN 'R' THEN 'RESTRICT'
              ELSE NULL
          END AS  on_update,
          CASE dt.referential_action
              WHEN 'C' THEN 'CASCADE'
              WHEN 'D' THEN 'SET DEFAULT'
              WHEN 'N' THEN 'SET NULL'
              WHEN 'R' THEN 'RESTRICT'
              ELSE NULL
          END AS on_delete,
          IF fk.check_on_commit = 'Y'
              THEN 1
              ELSE NULL
          ENDIF AS check_on_commit, -- check_on_commit flag
          IF ftbl.clustered_index_id = idx.index_id
              THEN 1
              ELSE NULL
          ENDIF AS 'clustered', -- clustered flag
          IF fk.match_type = 0
              THEN NULL
              ELSE fk.match_type
          ENDIF AS 'match', -- match option
          IF pidx.max_key_distance = 1
              THEN 1
              ELSE NULL
          ENDIF AS for_olap_workload -- for_olap_workload flag
FROM      SYS.SYSFKEY AS fk
JOIN      SYS.SYSIDX AS idx
ON        fk.foreign_table_id = idx.table_id
AND       fk.foreign_index_id = idx.index_id
JOIN      SYS.SYSPHYSIDX pidx
ON        idx.table_id = pidx.table_id
AND       idx.phys_index_id = pidx.phys_index_id
JOIN      SYS.SYSTAB AS ptbl
ON        fk.primary_table_id = ptbl.table_id
JOIN      SYS.SYSTAB AS ftbl
ON        fk.foreign_table_id = ftbl.table_id
JOIN      SYS.SYSIDXCOL AS idxcol
ON        idx.table_id = idxcol.table_id
AND       idx.index_id = idxcol.index_id
JOIN      SYS.SYSTABCOL AS pcol
ON        ptbl.table_id = pcol.table_id
AND       idxcol.primary_column_id = pcol.column_id
JOIN      SYS.SYSTABCOL AS fcol
ON        ftbl.table_id = fcol.table_id
AND       idxcol.column_id = fcol.column_id
LEFT JOIN SYS.SYSTRIGGER ut
ON        fk.foreign_table_id = ut.foreign_table_id
AND       fk.foreign_index_id = ut.foreign_key_id
AND       ut.event = 'C'
LEFT JOIN SYS.SYSTRIGGER dt
ON        fk.foreign_table_id = dt.foreign_table_id
AND       fk.foreign_index_id = dt.foreign_key_id
AND       dt.event = 'D'
WHERE     ftbl.table_name = %s
AND       ftbl.creator = USER_ID(%s)
ORDER BY  fk.foreign_index_id ASC, idxcol.sequence ASC
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getListTableIndexesSQL($table, $currentDatabase = null)
    {
        $user = '';

        if (strpos($table, '.') !== false) {
            [$user, $table] = explode('.', $table);
            $user           = $this->quoteStringLiteral($user);
            $table          = $this->quoteStringLiteral($table);
        } else {
            $table = $this->quoteStringLiteral($table);
        }

        return sprintf(
            <<<'SQL'
SELECT   idx.index_name AS key_name,
         IF idx.index_category = 1
             THEN 1
             ELSE 0
         ENDIF AS 'primary',
         col.column_name,
         IF idx."unique" IN(1, 2, 5)
             THEN 0
             ELSE 1
         ENDIF AS non_unique,
         IF tbl.clustered_index_id = idx.index_id
             THEN 1
             ELSE NULL
         ENDIF AS 'clustered', -- clustered flag
         IF idx."unique" = 5
             THEN 1
             ELSE NULL
         ENDIF AS with_nulls_not_distinct, -- with_nulls_not_distinct flag
         IF pidx.max_key_distance = 1
              THEN 1
              ELSE NULL
          ENDIF AS for_olap_workload -- for_olap_workload flag
FROM     SYS.SYSIDX AS idx
JOIN     SYS.SYSPHYSIDX pidx
ON       idx.table_id = pidx.table_id
AND      idx.phys_index_id = pidx.phys_index_id
JOIN     SYS.SYSIDXCOL AS idxcol
ON       idx.table_id = idxcol.table_id AND idx.index_id = idxcol.index_id
JOIN     SYS.SYSTABCOL AS col
ON       idxcol.table_id = col.table_id AND idxcol.column_id = col.column_id
JOIN     SYS.SYSTAB AS tbl
ON       idx.table_id = tbl.table_id
WHERE    tbl.table_name = %s
AND      tbl.creator = USER_ID(%s)
AND      idx.index_category != 2 -- exclude indexes implicitly created by foreign key constraints
ORDER BY idx.index_id ASC, idxcol.sequence ASC
SQL
            ,
            $table,
            $user
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getListTablesSQL()
    {
        return "SELECT   tbl.table_name
                FROM     SYS.SYSTAB AS tbl
                JOIN     SYS.SYSUSER AS usr ON tbl.creator = usr.user_id
                JOIN     dbo.SYSOBJECTS AS obj ON tbl.object_id = obj.id
                WHERE    tbl.table_type IN(1, 3) -- 'BASE', 'GBL TEMP'
                AND      usr.user_name NOT IN('SYS', 'dbo', 'rs_systabgroup') -- exclude system users
                AND      obj.type = 'U' -- user created tables only
                ORDER BY tbl.table_name ASC";
    }

    /**
     * {@inheritdoc}
     *
     * @todo Where is this used? Which information should be retrieved?
     */
    public function getListUsersSQL()
    {
        return 'SELECT * FROM SYS.SYSUSER ORDER BY user_name ASC';
    }

    /**
     * {@inheritdoc}
     */
    public function getListViewsSQL($database)
    {
        return "SELECT   tbl.table_name, v.view_def
                FROM     SYS.SYSVIEW v
                JOIN     SYS.SYSTAB tbl ON v.view_object_id = tbl.object_id
                JOIN     SYS.SYSUSER usr ON tbl.creator = usr.user_id
                JOIN     dbo.SYSOBJECTS obj ON tbl.object_id = obj.id
                WHERE    usr.user_name NOT IN('SYS', 'dbo', 'rs_systabgroup') -- exclude system users
                ORDER BY tbl.table_name ASC";
    }

    /**
     * {@inheritdoc}
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
    public function getMaxIdentifierLength()
    {
        return 128;
    }

    /**
     * {@inheritdoc}
     */
    public function getMd5Expression($column)
    {
        return 'HASH(' . $column . ", 'MD5')";
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sqlanywhere';
    }

    /**
     * Obtain DBMS specific SQL code portion needed to set a primary key
     * declaration to be used in statements like ALTER TABLE.
     *
     * @param Index  $index Index definition
     * @param string $name  Name of the primary key
     *
     * @return string DBMS specific SQL code portion needed to set a primary key
     *
     * @throws InvalidArgumentException If the given index is not a primary key.
     */
    public function getPrimaryKeyDeclarationSQL(Index $index, $name = null)
    {
        if (! $index->isPrimary()) {
            throw new InvalidArgumentException(
                'Can only create primary key declarations with getPrimaryKeyDeclarationSQL()'
            );
        }

        return $this->getTableConstraintDeclarationSQL($index, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getSetTransactionIsolationSQL($level)
    {
        return 'SET TEMPORARY OPTION isolation_level = ' . $this->_getTransactionIsolationLevelSQL($level);
    }

    /**
     * {@inheritdoc}
     */
    public function getSmallIntTypeDeclarationSQL(array $columnDef)
    {
        $columnDef['integer_type'] = 'SMALLINT';

        return $this->_getCommonIntegerTypeDeclarationSQL($columnDef);
    }

    /**
     * Returns the SQL statement for starting an existing database.
     *
     * In SQL Anywhere you can start and stop databases on a
     * database server instance.
     * This is a required statement after having created a new database
     * as it has to be explicitly started to be usable.
     * SQL Anywhere does not automatically start a database after creation!
     *
     * @param string $database Name of the database to start.
     *
     * @return string
     */
    public function getStartDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return "START DATABASE '" . $database->getName() . "' AUTOSTOP OFF";
    }

    /**
     * Returns the SQL statement for stopping a running database.
     *
     * In SQL Anywhere you can start and stop databases on a
     * database server instance.
     * This is a required statement before dropping an existing database
     * as it has to be explicitly stopped before it can be dropped.
     *
     * @param string $database Name of the database to stop.
     *
     * @return string
     */
    public function getStopDatabaseSQL($database)
    {
        $database = new Identifier($database);

        return 'STOP DATABASE "' . $database->getName() . '" UNCONDITIONALLY';
    }

    /**
     * {@inheritdoc}
     */
    public function getSubstringExpression($value, $from, $length = null)
    {
        if ($length === null) {
            return 'SUBSTRING(' . $value . ', ' . $from . ')';
        }

        return 'SUBSTRING(' . $value . ', ' . $from . ', ' . $length . ')';
    }

    /**
     * {@inheritdoc}
     */
    public function getTemporaryTableSQL()
    {
        return 'GLOBAL TEMPORARY';
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeFormatString()
    {
        return 'H:i:s.u';
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeTypeDeclarationSQL(array $fieldDeclaration)
    {
        return 'TIME';
    }

    /**
     * {@inheritdoc}
     */
    public function getTrimExpression($str, $pos = TrimMode::UNSPECIFIED, $char = false)
    {
        if (! $char) {
            switch ($pos) {
                case TrimMode::LEADING:
                    return $this->getLtrimExpression($str);
                case TrimMode::TRAILING:
                    return $this->getRtrimExpression($str);
                default:
                    return 'TRIM(' . $str . ')';
            }
        }

        $pattern = "'%[^' + " . $char . " + ']%'";

        switch ($pos) {
            case TrimMode::LEADING:
                return 'SUBSTR(' . $str . ', PATINDEX(' . $pattern . ', ' . $str . '))';
            case TrimMode::TRAILING:
                return 'REVERSE(SUBSTR(REVERSE(' . $str . '), PATINDEX(' . $pattern . ', REVERSE(' . $str . '))))';
            default:
                return 'REVERSE(SUBSTR(REVERSE(SUBSTR(' . $str . ', PATINDEX(' . $pattern . ', ' . $str . '))), ' .
                    'PATINDEX(' . $pattern . ', REVERSE(SUBSTR(' . $str . ', PATINDEX(' . $pattern . ', ' . $str . '))))))';
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTruncateTableSQL($tableName, $cascade = false)
    {
        $tableIdentifier = new Identifier($tableName);

        return 'TRUNCATE TABLE ' . $tableIdentifier->getQuotedName($this);
    }

    /**
     * {@inheritdoc}
     */
    public function getUniqueConstraintDeclarationSQL($name, Index $index)
    {
        if ($index->isPrimary()) {
            throw new InvalidArgumentException(
                'Cannot create primary key constraint declarations with getUniqueConstraintDeclarationSQL().'
            );
        }

        if (! $index->isUnique()) {
            throw new InvalidArgumentException(
                'Can only create unique constraint declarations, no common index declarations with ' .
                'getUniqueConstraintDeclarationSQL().'
            );
        }

        return $this->getTableConstraintDeclarationSQL($index, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getVarcharDefaultLength()
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getVarcharMaxLength()
    {
        return 32767;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNativeGuidType()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function prefersIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsCommentOnStatement()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsIdentityColumns()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getCommonIntegerTypeDeclarationSQL(array $columnDef)
    {
        $unsigned      = ! empty($columnDef['unsigned']) ? 'UNSIGNED ' : '';
        $autoincrement = ! empty($columnDef['autoincrement']) ? ' IDENTITY' : '';

        return $unsigned . $columnDef['integer_type'] . $autoincrement;
    }

    /**
     * {@inheritdoc}
     */
    protected function _getCreateTableSQL($tableName, array $columns, array $options = [])
    {
        $columnListSql = $this->getColumnDeclarationListSQL($columns);
        $indexSql      = [];

        if (! empty($options['uniqueConstraints'])) {
            foreach ((array) $options['uniqueConstraints'] as $name => $definition) {
                $columnListSql .= ', ' . $this->getUniqueConstraintDeclarationSQL($name, $definition);
            }
        }

        if (! empty($options['indexes'])) {
            /** @var Index $index */
            foreach ((array) $options['indexes'] as $index) {
                $indexSql[] = $this->getCreateIndexSQL($index, $tableName);
            }
        }

        if (! empty($options['primary'])) {
            $flags = '';

            if (isset($options['primary_index']) && $options['primary_index']->hasFlag('clustered')) {
                $flags = ' CLUSTERED ';
            }

            $columnListSql .= ', PRIMARY KEY' . $flags . ' (' . implode(', ', array_unique(array_values((array) $options['primary']))) . ')';
        }

        if (! empty($options['foreignKeys'])) {
            foreach ((array) $options['foreignKeys'] as $definition) {
                $columnListSql .= ', ' . $this->getForeignKeyDeclarationSQL($definition);
            }
        }

        $query = 'CREATE TABLE ' . $tableName . ' (' . $columnListSql;
        $check = $this->getCheckDeclarationSQL($columns);

        if (! empty($check)) {
            $query .= ', ' . $check;
        }

        $query .= ')';

        return array_merge([$query], $indexSql);
    }

    /**
     * {@inheritdoc}
     */
    protected function _getTransactionIsolationLevelSQL($level)
    {
        switch ($level) {
            case TransactionIsolationLevel::READ_UNCOMMITTED:
                return 0;
            case TransactionIsolationLevel::READ_COMMITTED:
                return 1;
            case TransactionIsolationLevel::REPEATABLE_READ:
                return 2;
            case TransactionIsolationLevel::SERIALIZABLE:
                return 3;
            default:
                throw new InvalidArgumentException('Invalid isolation level:' . $level);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function doModifyLimitQuery($query, $limit, $offset)
    {
        $limitOffsetClause = $this->getTopClauseSQL($limit, $offset);

        return $limitOffsetClause === ''
            ? $query
            : preg_replace('/^\s*(SELECT\s+(DISTINCT\s+)?)/i', '\1' . $limitOffsetClause . ' ', $query);
    }

    private function getTopClauseSQL(?int $limit, ?int $offset) : string
    {
        if ($offset > 0) {
            return sprintf('TOP %s START AT %d', $limit ?? 'ALL', $offset + 1);
        }

        return $limit === null ? '' : 'TOP ' . $limit;
    }

    /**
     * Return the INDEX query section dealing with non-standard
     * SQL Anywhere options.
     *
     * @param Index $index Index definition
     *
     * @return string
     */
    protected function getAdvancedIndexOptionsSQL(Index $index)
    {
        $sql = '';

        if (! $index->isPrimary() && $index->hasFlag('for_olap_workload')) {
            $sql .= ' FOR OLAP WORKLOAD';
        }

        return $sql;
    }

    /**
     * {@inheritdoc}
     */
    protected function getBinaryTypeDeclarationSQLSnippet($length, $fixed)
    {
        return $fixed
            ? 'BINARY(' . ($length ?: $this->getBinaryDefaultLength()) . ')'
            : 'VARBINARY(' . ($length ?: $this->getBinaryDefaultLength()) . ')';
    }

    /**
     * Returns the SQL snippet for creating a table constraint.
     *
     * @param Constraint  $constraint The table constraint to create the SQL snippet for.
     * @param string|null $name       The table constraint name to use if any.
     *
     * @return string
     *
     * @throws InvalidArgumentException If the given table constraint type is not supported by this method.
     */
    protected function getTableConstraintDeclarationSQL(Constraint $constraint, $name = null)
    {
        if ($constraint instanceof ForeignKeyConstraint) {
            return $this->getForeignKeyDeclarationSQL($constraint);
        }

        if (! $constraint instanceof Index) {
            throw new InvalidArgumentException('Unsupported constraint type: ' . get_class($constraint));
        }

        if (! $constraint->isPrimary() && ! $constraint->isUnique()) {
            throw new InvalidArgumentException(
                'Can only create primary, unique or foreign key constraint declarations, no common index declarations ' .
                'with getTableConstraintDeclarationSQL().'
            );
        }

        $constraintColumns = $constraint->getQuotedColumns($this);

        if (empty($constraintColumns)) {
            throw new InvalidArgumentException("Incomplete definition. 'columns' required.");
        }

        $sql   = '';
        $flags = '';

        if (! empty($name)) {
            $name = new Identifier($name);
            $sql .= 'CONSTRAINT ' . $name->getQuotedName($this) . ' ';
        }

        if ($constraint->hasFlag('clustered')) {
            $flags = 'CLUSTERED ';
        }

        if ($constraint->isPrimary()) {
            return $sql . 'PRIMARY KEY ' . $flags . '(' . $this->getIndexFieldDeclarationListSQL($constraintColumns) . ')';
        }

        return $sql . 'UNIQUE ' . $flags . '(' . $this->getIndexFieldDeclarationListSQL($constraintColumns) . ')';
    }

    /**
     * {@inheritdoc}
     */
    protected function getCreateIndexSQLFlags(Index $index)
    {
        $type = '';
        if ($index->hasFlag('virtual')) {
            $type .= 'VIRTUAL ';
        }

        if ($index->isUnique()) {
            $type .= 'UNIQUE ';
        }

        if ($index->hasFlag('clustered')) {
            $type .= 'CLUSTERED ';
        }

        return $type;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRenameIndexSQL($oldIndexName, Index $index, $tableName)
    {
        return ['ALTER INDEX ' . $oldIndexName . ' ON ' . $tableName . ' RENAME TO ' . $index->getQuotedName($this)];
    }

    /**
     * {@inheritdoc}
     */
    protected function getReservedKeywordsClass()
    {
        return Keywords\SQLAnywhereKeywords::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function getVarcharTypeDeclarationSQLSnippet($length, $fixed)
    {
        return $fixed
            ? ($length ? 'CHAR(' . $length . ')' : 'CHAR(' . $this->getVarcharDefaultLength() . ')')
            : ($length ? 'VARCHAR(' . $length . ')' : 'VARCHAR(' . $this->getVarcharDefaultLength() . ')');
    }

    /**
     * {@inheritdoc}
     */
    protected function initializeDoctrineTypeMappings()
    {
        $this->doctrineTypeMapping = [
            'char' => 'string',
            'long nvarchar' => 'text',
            'long varchar' => 'text',
            'nchar' => 'string',
            'ntext' => 'text',
            'nvarchar' => 'string',
            'text' => 'text',
            'uniqueidentifierstr' => 'guid',
            'varchar' => 'string',
            'xml' => 'text',
            'bigint' => 'bigint',
            'unsigned bigint' => 'bigint',
            'bit' => 'boolean',
            'decimal' => 'decimal',
            'double' => 'float',
            'float' => 'float',
            'int' => 'integer',
            'integer' => 'integer',
            'unsigned int' => 'integer',
            'numeric' => 'decimal',
            'smallint' => 'smallint',
            'unsigned smallint' => 'smallint',
            'tinyint' => 'smallint',
            'unsigned tinyint' => 'smallint',
            'money' => 'decimal',
            'smallmoney' => 'decimal',
            'long varbit' => 'text',
            'varbit' => 'string',
            'date' => 'date',
            'datetime' => 'datetime',
            'smalldatetime' => 'datetime',
            'time' => 'time',
            'timestamp' => 'datetime',
            'binary' => 'binary',
            'image' => 'blob',
            'long binary' => 'blob',
            'uniqueidentifier' => 'guid',
            'varbinary' => 'binary',
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            