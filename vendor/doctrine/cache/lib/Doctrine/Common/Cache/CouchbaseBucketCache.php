egularDatabaseUrlPath(array $url, array $params) : array
    {
        $params['dbname'] = $url['path'];

        return $params;
    }

    /**
     * Parses the given SQLite connection URL and resolves the given connection parameters.
     *
     * Assumes that the "path" URL part is already normalized via {@link normalizeDatabaseUrlPath}.
     *
     * @see normalizeDatabaseUrlPath
     *
     * @param mixed[] $url    The SQLite connection URL parts to evaluate.
     * @param mixed[] $params The connection parameters to resolve.
     *
     * @return mixed[] The resolved connection parameters.
     */
    private static function parseSqliteDatabaseUrlPath(array $url, array $params) : array
    {
        if ($url['path'] === ':memory:') {
            $params['memory'] = true;

            return $params;
        }

        $params['path'] = $url['path']; // pdo_sqlite driver uses 'path' instead of 'dbname' key

        return $params;
    }

    /**
     * Parses the scheme part from given connection URL and resolves the given connection parameters.
     *
     * @param mixed[] $url    The connection URL parts to evaluate.
     * @param mixed[] $params The connection parameters to resolve.
     *
     * @return mixed[] The resolved connection parameters.
     *
     * @throws DBALException If parsing failed or resolution is not possible.
     */
    private static function parseDatabaseUrlScheme(array $url, array $params) : array
    {
        if (isset($url['scheme'])) {
            // The requested driver from the URL scheme takes precedence
            // over the default custom driver from the connection parameters (if any).
            unset($params['driverClass']);

            // URL schemes must not contain underscores, but dashes are ok
            $driver = str_replace('-', '_', $url['scheme']);

            // The requested driver from the URL scheme takes precedence over the
            // default driver from the connection parameters. If the driver is
            // an alias (e.g. "postgres"), map it to the actual name ("pdo-pgsql").
            // Otherwise, let checkParams decide later if the driver exists.
            $params['driver'] = self::$driverSchemeAliases[$driver] ?? $driver;

            return $params;
        }

        // If a schemeless connection URL is given, we require a default driver or default custom driver
        // as connection parameter.
        if (! isset($params['driverClass']) && ! isset($params['driver'])) {
            throw DBALException::driverRequired($params['url']);
        }

        return $params;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Doctrine\DBAL;

/**
 * Container for all DBAL events.
 *
 * This class cannot be instantiated.
 */
final class Events
{
    /**
     * Private constructor. This class cannot be instantiated.
     */
    private function __construct()
    {
    }

    public const postConnect = 'postConnect';

    public const onSchemaCreateTable            = 'onSchemaCreateTable';
    public const onSchemaCreateTableColumn      = 'onSchemaCreateTableColumn';
    public const onSchemaDropTable              = 'onSchemaDropTable';
    public const 