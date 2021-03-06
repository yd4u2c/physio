INDX( 	 )mh             (     �       �   I   ��        ;	     � l     :	     ���ok� ������Z\F|�<����ok�                      A b s t r a c t D B 2 D r i v e r . p h p     <	     � x     :	     ����ok� ������½H|�<�����ok�       �               A b s t r a c t D r i v e r E x c e p t i o n . p h p =	     � p     :	     �߬�ok� ������i K|�<��߬�ok�        W               A b s t r a c t M y S Q L D r i v e r . p h p N	     � j     :	     ����ok�����ok�����ok�����ok                         A b s t r a c t O r a c l e D r i v e r . p h >	     � r     :	     A���ok� ������i K|�<�A���ok�       �
               A b s t r a c t O r a c l e D r i v e r . p h p       ?	     � z     :	     ���ok� ������v�M|�<����ok�        �               A b s t r a c t P o s t g r e S Q L D r i v e r . p h p       @	     � |     :	     �T��ok� �������O|�<��T��ok�        �               A b s t r a c t S Q L A n y w h e r e D r i v e r . p h p     A	     � r    :	     ���ok� �������O|�<����ok�       �               A b s t r a c t S Q L i t e D r i v e r . p h p       B	     � x     :	     /���ok� ������#HR|�<�/���ok�       �	               A b s t r a c t S Q L S e r v e r D r i v e r . p h p C	     p ^     :	     �@��ok� ��������T|�<��@��ok�       R               C o n n e c t i o n . p h p   D	     x h     :	     ���ok� ������"W|�<����ok�       �               D r i v e r E x c e p t i o n . p h p P	     p `     :	     ,��ok���ok���ok�,��ok�                        D r i z z l e P D O M y S q l E	     � z     :	     d��ok� ������"W|�<�d��ok�       D               E x c e p t i o n C o n v e r t e r D r i v e r . p h p       S	     ` N     :	     �y�ok�֋9�ok�֋9�ok��y�ok�                        I B M D B 2 n X	     ` N     :	     r�;�ok���S�ok���S�ok�r�;�ok�                        M y s q l i n ]	     ` J     :	     �&V�ok�/օ�ok�/օ�ok��&V�ok�                        O C  8 o n n F	     x d     :	     �g��ok� �������nY|�<��g��ok�       F               P D O C o n n e c t i o n . p h p     G	     x b     :	     k,��ok� ��������[|�<�k,��ok�       }               P D O E x c e p t i o n . p h p       b	     ` N     :	     ��ok��_��ok��_��ok���ok�                        P D O I b m t d	     h R     :	     T�ok�Ɇ��ok�Ɇ��ok�T�ok�                        P D O M y S q l m e n f	     h T     :	     ��ok�����ok�����ok���ok�                      	 P D O O r a c l e e n h	     h R     :	     �r��ok��Ԥ�ok��Ԥ�ok��r��ok�                        P D O P g S q l m e n j	     h T     :	     ]7��ok�'���ok�'���ok�]7��ok�                       	 P D O S q l i t e e n l	     h T     :	     ����ok�UJ��ok�UJ��ok�����ok�                       	 P D O S q l s r v e n H	     x b     :	     Y���ok� ������83^|�<�Y���ok�                       P D O S t a t e m e n t . p h p       I	     � n     :	     ���ok� ����� 83^|�<����ok�x      s               P i n g a b l e C o n n e c t i o n . p h p   J	     x h     :	     ���ok� ������Y�`|�<����ok�        �               R e s u l t S t a t e m e n t . p h p K	     � |     :	     T��ok� ��������b|�<�T��ok�h      d               S e r v e r I n f o A w a r e C o n n e c t i o n . p h p     p	     h X     :	     9���ok�z��ok�z��ok�9���ok�                        S Q L A n y w h e r e u	     ` N     :	     �o��ok�L4�ok�L4�ok��o��ok                         S Q L S r v e L	     p \     :	     T��ok� ��������b|�<�T��ok�        P               S t a t e m e n t . p h p     M	     � l     :	     }z��ok� ������Ze|�<�}z��ok��      �               S t a t e m e n t I t e r a t o r . p h p                                                                                                                                                                                                                                          <?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Doctrine\DBAL\Schema\SqliteSchemaManager;
use function strpos;

/**
 * Abstract base implementation of the {@link Doctrine\DBAL\Driver} interface for SQLite based drivers.
 */
abstract class AbstractSQLiteDriver implements Driver, ExceptionConverterDriver
{
    /**
     * {@inheritdoc}
     *
     * @link http://www.sqlite.org/c3ref/c_abort.html
     */
    public function convertException($message, DriverException $exception)
    {
        if (strpos($exception->getMessage(), 'database is locked') !== false) {
            return new Exception\LockWaitTimeoutException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'must be unique') !== false ||
            strpos($exception->getMessage(), 'is not unique') !== false ||
            strpos($exception->getMessage(), 'are not unique') !== false ||
            strpos($exception->getMessage(), 'UNIQUE constraint failed') !== false
        ) {
            return new Exception\UniqueConstraintViolationException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'may not be NULL') !== false ||
            strpos($exception->getMessage(), 'NOT NULL constraint failed') !== false
        ) {
            return new Exception\NotNullConstraintViolationException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'no such table:') !== false) {
            return new Exception\TableNotFoundException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'already exists') !== false) {
            return new Exception\TableExistsException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'has no column named') !== false) {
            return new Exception\InvalidFieldNameException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'ambiguous column name') !== false) {
            return new Exception\NonUniqueFieldNameException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'syntax error') !== false) {
            return new Exception\SyntaxErrorException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'attempt to write a readonly database') !== false) {
            return new Exception\ReadOnlyException($message, $exception);
        }

        if (strpos($exception->getMessage(), 'unable to open database file') !== false) {
            return new Exception\ConnectionException($message, $exception);
        }

        return new Exception\DriverException($message, $exception);
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();

        return $params['path'] ?? null;
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new SqlitePlatform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn)
    {
        return new SqliteSchemaManager($conn);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\SQLServer2005Platform;
use Doctrine\DBAL\Platforms\SQLServer2008Platform;
use Doctrine\DBAL\Platforms\SQLServer2012Platform;
use Doctrine\DBAL\Platforms\SQLServerPlatform;
use Doctrine\DBAL\Schema\SQLServerSchemaManager;
use Doctrine\DBAL\VersionAwarePlatformDriver;
use function preg_match;
use function version_compare;

/**
 * Abstract base implementation of the {@link Doctrine\DBAL\Driver} interface for Microsoft SQL Server based drivers.
 */
abstract class AbstractSQLServerDriver implements Driver, VersionAwarePlatformDriver
{
    /**
     * {@inheritdoc}
     */
    public function createDatabasePlatformForVersion($version)
    {
        if (! preg_match(
            '/^(?P<major>\d+)(?:\.(?P<minor>\d+)(?:\.(?P<patch>\d+)(?:\.(?P<build>\d+))?)?)?/',
            $version,
            $versionParts
        )) {
            throw DBALException::invalidPlatformVersionSpecified(
                $version,
                '<major_version>.<minor_version>.<patch_version>.<build_version>'
            );
        }

        $majorVersion = $versionParts['major'];
        $minorVersion = $versionParts['minor'] ?? 0;
        $patchVersion = $versionParts['patch'] ?? 0;
        $buildVersion = $versionParts['build'] ?? 0;
        $version      = $majorVersion . '.' . $minorVersion . '.' . $patchVersion . '.' . $buildVersion;

        switch (true) {
            case version_compare($version, '11.00.2100', '>='):
                return new SQLServer2012Platform();
            case version_compare($version, '10.00.1600', '>='):
                return new SQLServer2008Platform();
            case version_compare($version, '9.00.1399', '>='):
                return new SQLServer2005Platform();
            default:
                return new SQLServerPlatform();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabase(Connection $conn)
    {
        $params = $conn->getParams();

        return $params['dbname'] ?? $conn->query('SELECT DB_NAME()')->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    public function getDatabasePlatform()
    {
        return new SQLServer2008Platform();
    }

    /**
     * {@inheritdoc}
     */
    public function getSchemaManager(Connection $conn)
    {
        return new SQLServerSchemaManager($conn);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Doctrine\DBAL\Driver;

use Doctrine\DBAL\ParameterType;

/**
 * Connection interface.
 * Driver connections must implement this interface.
 *
 * This resembles (a subset of) the PDO interface.
 */
interface Connection
{
    /**
     * Prepares a statement for execution and returns a Statement object.
     *
     * @param string $prepareString
     *
     * @return Statement
     */
    public function prepare($prepareString);

    /**
     * Executes an SQL statement, returning a result set as a Statement object.
     *
     * @return Statement
     */
    public function query();

    /**
     * Quotes a string for use in a query.
     *
     * @param mixed $input
     * @param int   $type
     *
     * @return mixed
     */
    public function quote($input, $type = ParameterType::STRING);

    /**
     * Executes an SQL statement and return the number of affected rows.
     *
     * @param string $statement
     *
     * @return int
     */
    public function exec($statement);

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @param string|null $name
     *
     * @return string
     */
    public function lastInsertId($name = null);

    /**
     * Initiates a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function beginTransaction();

    /**
     * Commits a transaction.
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function commit();

    /**
     * Rolls back the current transaction, as initiated by beginTransaction().
     *
     * @return bool TRUE on success or FALSE on failure.
     */
    public function rollBack();

    /**
     * Returns the error code associated with the last operation on the database handle.
     *
     * @return string|null The error code, or null if no operation has been run on the database handle.
     */
    public function errorCode();

    /**
     * Returns extended error information associated with the last operation on the database handle.
     *
     * @return mixed[]
     */
    public function errorInfo();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Doctrine\DBAL\Driver;

use Throwable;

/**
 * Contract for a driver exception.
 *
 * Driver exceptions provide the SQLSTATE 