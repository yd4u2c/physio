      'unsigned'      => $this->_unsigned,
            'autoincrement' => $this->_autoincrement,
            'columnDefinition' => $this->_columnDefinition,
            'comment' => $this->_comment,
        ], $this->_platformOptions, $this->_customSchemaOptions);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Doctrine\DBAL\Schema;

use function in_array;

/**
 * Represents the change of a column.
 */
class ColumnDiff
{
    /** @var string */
    public $oldColumnName;

    /** @var Column */
    public $column;

    /** @var string[] */
    public $changedProperties = [];

    /** @var Column */
    public $fromColumn;

    /**
     * @param string   $oldColumnName
     * @param string[] $changedProperties
     */
    public function __construct($oldColumnName, Column $column, array $changedProperties = [], ?Column $fromColumn = null)
    {
        $this->oldColumnName     = $oldColumnName;
        $this->column            = $column;
        $this->changedProperties = $changedProperties;
        $this->fromColumn        = $fromColumn;
    }

    /**
     * @param string $propertyName
     *
     * @return bool
     */
    public function hasChanged($propertyName)
    {
        return in_array($propertyName, $this->changedProperties);
    }

    /**
     * @return Identifier
     */
    public function getOldColumnName()
    {
        $quote = $this->fromColumn && $this->fromColumn->isQuoted();

        return new Identifier($this->oldColumnName, $quote);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Types;
use function array_intersect_key;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_merge;
use function array_shift;
use function array_unique;
use function count;
use function strtolower;

/**
 * Compares two Schemas and return an instance of SchemaDiff.
 */
class Comparator
{
    /**
     * @return SchemaDiff
     */
    public static function compareSchemas(Schema $fromSchema, Schema $toSchema)
    {
        $c = new self();

        return $c->compare($fromSchema, $toSchema);
    }

    /**
     * Returns a SchemaDiff object containing the differences between the schemas $fromSchema and $toSchema.
     *
     * The returned differences are returned in such a way that they contain the
     * operations to change the schema stored in $fromSchema to the schema that is
     * stored in $toSchema.
     *
     * @return SchemaDiff
     */
    public function compare(Schema $fromSchema, Schema $toSchema)
    {
        $diff             = new SchemaDiff();
        $diff->fromSchema = $fromSchema;

        $foreignKeysToTable = [];

        fo