$ex) {
        $pdoException = $ex->getPrevious();
        // ...
    }

## Doctrine\DBAL\Connection#setCharsetSQL() removed

This method only worked on MySQL and it is considered unsafe on MySQL to use SET NAMES UTF-8 instead
of setting the charset directly on connection already. Replace this behavior with the
connection charset option:

Before:

    $conn = DriverManager::getConnection(array(..));
    $conn->setCharset('UTF8');

After:

    $conn = DriverManager::getConnection(array('charset' => 'UTF8', ..));

## Doctrine\DBAL\Schema\Table#renameColumn() removed

Doctrine\DBAL\Schema\Table#renameColumn() was removed, because it drops and recreates
the column instead. There is no fix available, because a schema diff
cannot reliably detect if a column was renamed or one column was created
and another one dropped.

You should use explicit SQL ALTER TABLE statements to change columns names.

## Schema Filter paths

The Filter Schema assets expression is not wrapped in () anymore for the regexp automatically.

Before:

    $config->setFilterSchemaAssetsExpression('foo');

After:

    $config->setFilterSchemaAssetsExpression('(foo)');

## Creating MySQL Tables now defaults to UTF-8

If you are creating a new MySQL Table through the Doctrine API, charset/collate are
now set to 'utf8'/'utf8_unicode_ci' by default. Previously the MySQL server defaults were used.

# Upgrade to 2.2

## Doctrine\DBAL\Connection#insert and Doctrine\DBAL\Connection#update

Both methods now accept an optional last parameter $types with binding types of the values passed.
This can potentially break child classes that have overwritten one of these methods.

## Doctrine\DBAL\Connection#executeQuery

Doctrine\DBAL\Connection#executeQuery() got a new last parameter "QueryCacheProfile $qcp"

## Doctrine\DBAL\Driver\Statement split

The Driver statement was split into a ResultStatement and the normal statement extending from it.
This separates the configuration and the retrieval API from a statement.

## MsSql Platform/SchemaManager renamed

The MsSqlPlatform was renamed to SQLServerPlatform, the MsSqlSchemaManager was renamed
to SQLServerSchemaManager.

## Cleanup SQLServer Platform version mess

DBAL 2.1 and before were actually only compatible to SQL Server 2008, not earlier versions.
Still other parts of the platform did use old features instead of newly introduced datatypes
in SQL Server 2005. Starting with DBAL 2.2 you can pick the Doctrine abstraction exactly
matching your SQL Server version.

The PDO SqlSrv driver now uses the new `SQLServer2008Platform` as default platform.
This platform uses new features of SQL Server as of version 2008. This also includes a switch
in the used fields for "text" and "blob" field types to:

    "text" => "VARCHAR(MAX)"
    "blob" => "VARBINARY(MAX)"

Additionally `SQLServerPlatform` in DBAL 2.1 and before used "DATE", "TIME" and "DATETIME2" for dates.
This types are only available since version 2008 and the introduction of an explicit
SQLServer 2008 platform makes this dependency explicit.

An `SQLServer2005Platform` was also introduced to differentiate the features between
versions 2003, earlier and 2005.

With this change the `SQLServerPlatform` now throws an exception for using limit queries
with an offset, since SQLServer 2003 a