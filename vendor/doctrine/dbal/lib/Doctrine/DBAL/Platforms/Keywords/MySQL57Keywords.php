<?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Platforms\AbstractPlatform;

/**
 * Marker interface for constraints.
 */
interface Constraint
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getQuotedName(AbstractPlatform $platform);

    /**
     * Returns the names of the referencing table columns
     * the constraint is associated with.
     *
     * @return string[]
     */
    public function getColumns();

    /**
     * Returns the quoted representation of the column names
     * the constraint is associated with.
     *
     * But only if they were defined with one or a column name
     * is a keyword reserved by the platform.
     * Otherwise the plain unquoted value as inserted is returned.
     *
     * @param AbstractPlatform $platform The platform to use for quotation.
     *
     * @return string[]
     */
    public function getQuotedColumns(AbstractPlatform $platform);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

namespace Doctrine\DBAL\Schema;

use Doctrine\DBAL\Types\Type;
use const CASE_LOWER;
use function array_change_key_case;
use function is_resource;
use function strpos;
use function strtolower;
use function substr;
use function trim;

/**
 * IBM Db2 Schema Manager.
 */
class DB2SchemaManager extends AbstractSchemaManager
{
    /**
     * {@inheritdoc}
     *
     * Apparently creator is the schema not the user who created it:
     * {@link http://publib.boulder.ibm.com/infocenter/dzichelp/v2r2/index.jsp?topic=/com.ibm.db29.doc.sqlref/db2z_sysibmsystablestable.htm}
     */
    public function listTableNames()
    {
        $sql  = $this->_platform->getListTablesSQL();
        $sql .= ' AND CREATOR = UPPER(' . $this->_conn->quote($this->_conn->getUsername()) . ')';

        $tables = $this->_conn->fetchAll($sql);

        return $this->filterAssetNames($this->_getPortableTablesList($tables));
    }

    /**
     * {@inheritdoc}
     */
    protected function _getPortableTableColumnDefinition($tableColumn)
    {
        $tableColumn = array_change_key_case($tableColumn, CASE_LOWER);

        $length    = null;
        $fixed     = null;
        $unsigned  = false;
        $scale     = false;
        $precision = false;

        $default = null;

        if ($tableColumn['default'] !== null && $tableColumn['default'] !== 'NULL') {
            $default = trim($tableColumn['default'], "'");
        }

        $type = $this->_platform->getDoctrineTypeMapping($tableColumn['typename']);

        if (isset($tableColumn['comment'])) {
            $type                   = $this->extractDoctrineTypeFromComment($tableColumn['comment'], $type);
            $tableColumn['comment'] = $this->removeDoctrineTypeFromComment($tableColumn['comment'], $type);
        }

        sw