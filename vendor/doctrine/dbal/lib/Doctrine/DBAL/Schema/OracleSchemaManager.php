<?php

namespace Doctrine\DBAL\Tools\Console;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Tools\Console\Command\ImportCommand;
use Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand;
use Doctrine\DBAL\Tools\Console\Command\RunSqlCommand;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Version;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\HelperSet;

/**
 * Handles running the Console Tools inside Symfony Console context.
 */
class ConsoleRunner
{
    /**
     * Create a Symfony Console HelperSet
     *
     * @return HelperSet
     */
    public static function createHelperSet(Connection $connection)
    {
        return new HelperSet([
            'db' => new ConnectionHelper($connection),
        ]);
    }

    /**
     * Runs console with the given helperset.
     *
     * @param Command[] $commands
     *
     * @return void
     */
    public static function run(HelperSet $helperSet, $commands = [])
    {
        $cli = new Application('Doctrine Command Line Interface', Version::VERSION);

        $cli->setCatchExceptions(true);
        $cli->setHelperSet($helperSet);

        self::addCommands($cli);

        $cli->addCommands($commands);
        $cli->run();
    }

    /**
     * @return void
     */
    public static function addCommands(Application $cli)
    {
        $cli->addCommands([
            new RunSqlCommand(),
            new ImportCommand(),
            new ReservedWordsCommand(),
        ]);
    }

    /**
     * Prints the instructions to create a configuration file
     */
    public static function printCliConfigTemplate()
    {
        echo <<<'HELP'
You are missing a "cli-config.php" or "config/cli-config.php" file in your
project, which is required to get the Doctrine-DBAL Console working. You can use the
following sample as a template:

<?php
use Doctrine\DBAL\Tools\Console\ConsoleRunner;

// replace with the mechanism to retrieve DBAL connection in your app
$connection = getDBALConnection();

// You can append new commands to $commands array, if needed

return ConsoleRunner::createHelperSet($connection);

HELP;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

namespace Doctrine\DBAL\Tools\Console\Command;

use Doctrine\DBAL\Driver\PDOConnection;
use Doctrine\DBAL\Driver\PDOStatement;
use InvalidArgumentException;
use PDOException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use const PHP_EOL;
use function assert;
use function file_exists;
use function file_get_contents;
use function is_readable;
use function realpath;
use function sprintf;

/**
 * Task for executing arbitrary SQL that can come from a file or directly from
 * the command line.
 *
 * @deprecated Use a database client application instead
 */
class ImportCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
        ->setName('dbal:import')
        ->setDescription('Import SQL file(s) directly to Database.')
        ->setDefinition([new InputArgument(
            'file',
            InputArgument::REQUIRED | InputArgument::IS_ARRAY,
            'File path(s) of SQL to be executed.'
        ),
        ])
        ->setHelp(<<<EOT
Import SQL file(s) directly to Database.
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conn = $this->getHelper('db')->getConnection();

        $fileNames = $input->getArgument('file');

        if ($fileNames === null) {
            return null;
        }

        foreach ((array) $fileNames as $fileName) {
            $filePath = realpath($fileName);

            // Phar compatibility.
            if ($filePath === false) {
                $filePath = $fileName;
            }

            if (! file_exists($filePath)) {
                throw new InvalidArgumentException(
                    sprintf("SQL file '<info>%s</info>' does not exist.", $filePath)
                );
            } elseif (! is_readable($filePath)) {
                throw new InvalidArgumentException(
                    sprintf("SQL file '<info>%s</info>' does not have read permissions.", $filePath)
                );
            }

            $output->write(sprintf("Processing file '<info>%s</info>'... ", $filePath));
            $sql = file_get_contents($filePath);

            if ($conn instanceof PDOConnection) {
                // PDO Drivers
                try {
                    $lines = 0;

                    $stmt = $conn->prepare($sql);
                    assert($stmt instanceof PDOStatement);

                    $stmt->execute();

                    do {
                        // Required due to "MySQL has gone away!" issue
                        $stmt->fetch();
                        $stmt->closeCursor();

                        $lines++;
                    } while ($stmt->nextRowset());

                    $output->write(sprintf('%d statements executed!', $lines) . PHP_EOL);
                } catch (PDOException $e) {
                    $output->write('error!' . PHP_EOL);

                    throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
                }
            } else {
                // Non-PDO Drivers (ie. OCI8 driver)
                $stmt = $conn->prepare($sql);
                $rs   = $stmt->execute();

                if (! $rs) {
                    $error = $stmt->errorInfo();

                    $output->write('error!' . PHP_EOL);

                    throw new RuntimeException($error[2], $error[0]);
                }

                $output->writeln('OK!' . PHP_EOL);

                $stmt->closeCursor();
            }
        }

        return null;
    }
}
                                                                                                                                                                                                                                                                                                                                                          <?php

namespace Doctrine\DBAL\Tools\Console\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Platforms\Keywords\DB2Keywords;
use Doctrine\DBAL\Platforms\Keywords\MySQL57Keywords;
use Doctrine\DBAL\Platforms\Keywords\MySQL80Keywords;
use Doctrine\DBAL\Platforms\Keywords\MySQLKeywords;
use Doctrine\DBAL\Platforms\Keywords\OracleKeywords;
use Doctrine\DBAL\Platforms\Keywords\PostgreSQL91Keywords;
use Doctrine\DBAL\Platforms\Keywords\PostgreSQL92Keywords;
use Doctrine\DBAL\Platforms\Keywords\PostgreSQLKeywords;
use Doctrine\DBAL\Platforms\Keywords\ReservedKeywordsValidator;
use Doctrine\DBAL\Platforms\Keywords\SQLAnywhere11Keywords;
use Doctrine\DBAL\Platforms\Keywords\SQLAnywhere12Keywords;
use Doctrine\DBAL\Platforms\Keywords\SQLAnywhere16Keywords;
use Doctrine\DBAL\Platforms\Keywords\SQLAnywhereKeywords;
use Doctrine\DBAL\Platforms\Keywords\SQLiteKeywords;
use Doctrine\DBAL\Platforms\Keywords\SQLServer2005Keywords;
use Doctrine\DBAL\Platforms\Keywords\SQLServer2008Keywords;
use Doctrine\DBAL\Platforms\Keywords\SQLServer2012Keywords;
use Doctrine\DBAL\Platforms\Keywords\SQLServerKeywords;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function array_keys;
use function count;
use function implode;

class ReservedWordsCommand extends Command
{
    /** @var string[] */
    private $keywordListClasses = [
        'mysql'         => MySQLKeywords::class,
        'mysql57'       => MySQL57Keywords::class,
        'mysql80'       => MySQL80Keywords::class,
        'sqlserver'     => SQLServerKeywords::class,
        'sqlserver2005' => SQLServer2005Keywords::class,
        'sqlserver2008' => SQLServer2008Keywords::class,
        'sqlserver2012' => SQLServer2012Keywords::class,
        'sqlite'        => SQLiteKeywords::class,
        'pgsql'         => PostgreSQLKeywords::class,
        'pgsql91'       => PostgreSQL91Keywords::class,
        'pgsql92'       => PostgreSQL92Keywords::class,
        'oracle'        => OracleKeywords::class,
        'db2'           => DB2Keywords::class,
        'sqlanywhere'   => SQLAnywhereKeywords::class,
        'sqlanywhere11' => SQLAnywhere11Keywords::class,
        'sqlanywhere12' => SQLAnywhere12Keywords::class,
        'sqlanywhere16' => SQLAnywhere16Keywords::class,
    ];

    /**
     * If you want to add or replace a keywords list use this command.
     *
     * @param string $name
     * @param string $class
     *
     * @return void
     */
    public function setKeywordListClass($name, $class)
    {
        $this->keywordListClasses[$name] = $class;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
        ->setName('dbal:reserved-words')
        ->setDescription('Checks if the current database contains identifiers that are reserved.')
        ->setDefinition([new InputOption(
            'list',
            'l',
            InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
            'Keyword-List name.'
        ),
        ])
        ->setHelp(<<<EOT
Checks if the current database contains tables and columns
with names that are identifiers in this dialect or in other SQL dialects.

By default SQLite, MySQL, PostgreSQL, Microsoft SQL Server, Oracle
and SQL Anywhere keywords ar