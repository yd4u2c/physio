tion createTable($tableName)
    {
        $table = new Table($tableName);
        $this->_addTable($table);

        foreach ($this->_schemaConfig->getDefaultTableOptions() as $name => $value) {
            $table->addOption($name, $value);
        }

        return $table;
    }

    /**
     * Renames a table.
     *
     * @param string $oldTableName
     * @param string $newTableName
     *
     * @return \Doctrine\DBAL\Schema\Schema
     */
    public function renameTable($oldTableName, $newTableName)
    {
        $table = $this->getTable($oldTableName);
        $table->_setName($newTableName);

        $this->dropTable($oldTableName);
        $this->_addTable($table);

        return $this;
    }

    /**
     * Drops a table from the schema.
     *
     * @param string $tableName
     *
     * @return \Doctrine\DBAL\Schema\Schema
     */
    public function dropTable($tableName)
    {
        $tableName = $this->getFullQualifiedAssetName($tableName);
        $this->getTable($tableName);
        unset($this->_tables[$tableName]);

        return $this;
    }

    /**
     * Creates a new sequence.
     *
     * @param string $sequenceName
     * @param int    $allocationSize
     * @param int    $initialValue
     *
     * @return Sequence
     */
    public function createSequence($sequenceName, $allocationSize = 1, $initialValue = 1)
    {
        $seq = new Sequence($sequenceName, $allocationSize, $initialValue);
        $this->_addSequence($seq);

        return $seq;
    }

    /**
     * @param string $sequenceName
     *
     * @return \Doctrine\DBAL\Schema\Schema
     */
    public function dropSequence($sequenceName)
    {
        $sequenceName = $this->getFullQualifiedAssetName($sequenceName);
        unset($this->_sequences[$sequenceName]);

        return $this;
    }

    /**
     * Returns an array of necessary SQL queries to create the schema on the given platform.
     *
     * @return string[]
     */
    public function toSql(AbstractPlatform $platform)
    {
        $sqlCollector = new CreateSchemaSqlCollector($platform);
        $this->visit($sqlCollector);

        return $sqlCollector->getQueries();
    }

    /**
     * Return an array of necessary SQL queries to drop the schema on the given platform.
     *
     * @return string[]
     */
    public function toDropSql(AbstractPlatform $platform)
    {
        $dropSqlCollector = new DropSchemaSqlCollector($platform);
        $this->visit($dropSqlCollector);

        return $dropSqlCollector->getQueries();
    }

    /**
     * @return string[]
     */
    public function getMigrateToSql(Schema $toSchema, AbstractPlatform $platform)
    {
        $comparator = new Comparator();
        $schemaDiff = $comparator->compare($this, $toSchema);

        return $schemaDiff->toSql($platform);
    }

    /**
     * @return string[]
     */
    public function getMigrateFromSql(Schema $fromSchema, AbstractPlatform $platform)
    {
        $comparator = new Comparator();
        $schemaDiff = $comparator->compare($fromSchema, $this);

        return $schemaDiff->toSql($platform);
    }

    /**
     * @return void
     */
    public function visit(Visitor $visitor)
    {
        $visitor->acceptSchema($this);

        if ($visitor instanceof NamespaceVisitor) {
            foreach ($this->namespaces as $namespace) {
                $visitor->acceptNamespace($namespace);
            }
        }

        foreach ($this->_tables as $table) {
            $table->visit($visitor);
        }

        foreach ($this->_sequences as $sequence) {
            $sequence->visit($visitor);
        }
    }

    /**
     * Cloning a Schema triggers a deep clone of all related assets.
     *
     * @return void
     */
    public function __clone()
    {
        foreach ($this->_tables as $k => $table) {
            $this->_tables[$k] = clone $table;
        }
        foreach ($this->_sequences as $k => $sequence) {
            $this->_sequences[$k] = clone $sequence;
        }
    }
}
                                                                                    <?php

namespace Doctrine\DBAL\Schema;

/**
 * Configuration for a Schema.
 */
class SchemaConfig
{
    /** @var bool */
    protected $hasExplicitForeignKeyIndexes = false;

    /** @var int */
    protected $maxIdentifierLength = 63;

    /** @var string */
    protected $name;

    /** @var mixed[] */
    protected $defaultTableOptions = [];

    /**
     * @return bool
     */
    public function hasExplicitForeignKeyIndexes()
    {
        return $this->hasExplicitForeignKeyIndexes;
    }

    /**
     * @param bool $flag
     *
     * @return void
     */
    public function setExplicitForeignKeyIndexes($flag)
    {
        $this->hasExplicitForeignKeyIndexes = (bool) $flag;
    }

    /**
     * @param int $length
     *
     * @return void
     */
    public function setMaxIdentifierLength($length)
    {
        $this->maxIdentifierLength = (int) $length;
    }

    /**
     * @return int
     */
    public function getMaxIdentifierLength()
    {
        return $this->maxIdentifierLength;
    }

    /**
     * Gets the default namespace of schema objects.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the default namespace name of schema objects.
     *
     * @param string $name The value to set.
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Gets the default options that are passed to Table instances created with
     * Schema#createTable().
     *
     * @return mixed[]
     */
    public function getDefaultTableOptions()
    {
        return $this->defaultTableOptions;
    }

 