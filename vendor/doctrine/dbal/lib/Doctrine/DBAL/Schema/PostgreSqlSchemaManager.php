put)
    {
        /** @var Connection $conn */
        $conn = $this->getHelper('db')->getConnection();

        $keywordLists = (array) $input->getOption('list');
        if (! $keywordLists) {
            $keywordLists = [
                'mysql',
                'mysql57',
                'mysql80',
                'pgsql',
                'pgsql92',
                'sqlite',
                'oracle',
                'sqlserver',
                'sqlserver2005',
                'sqlserver2008',
                'sqlserver2012',
                'sqlanywhere',
                'sqlanywhere11',
                'sqlanywhere12',
                'sqlanywhere16',
            ];
        }

        $keywords = [];
        foreach ($keywordLists as $keywordList) {
            if (! isset($this->keywordListClasses[$keywordList])) {
                throw new InvalidArgumentException(
                    "There exists no keyword list with name '" . $keywordList . "'. " .
                    'Known lists: ' . implode(', ', array_keys($this->keywordListClasses))
                );
            }
            $class      = $this->keywordListClasses[$keywordList];
            $keywords[] = new $class();
        }

        $output->write('Checking keyword violations for <comment>' . implode(', ', $keywordLists) . '</comment>...', true);

        $schema  = $conn->getSchemaManager()->createSchema();
        $visitor = new ReservedKeywordsValidator($keywords);
        $schema->visit($visitor);

        $violations = $visitor->getViolations();
        if (count($violations) !== 0) {
            $output->write('There are <error>' . count($violations) . '</error> reserved keyword violations in your database schema:', true);
            foreach ($violations as $violation) {
                $output->write('  - ' . $violation, true);
            }

            return 1;
        }

        $output->write('No reserved keywords violations have been found!', true);

        return 0;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Doctrine\DBAL\Tools\Console\Command;

use Doctrine\DBAL\Tools\Dumper;
use LogicException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function is_numeric;
use function stripos;

/**
 * Task for executing arbitrary SQL that can come from a file or directly from
 * the command line.
 */
class RunSqlCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
        ->setName('dbal:run-sql')
        ->setDescription('Executes arbitrary SQL directly from the command line.')
        ->setDefinition([
            new InputArgument('sql', InputArgument::REQUIRED, 'The SQL statement to execute.'),
            new InputOption('depth', null, InputOption::VALUE_REQUIRED, 'Dumping depth of result set.', 7),
            new InputOption('force-fetch', null, InputOption::VALUE_NONE, 'Forces fetching the result.'),
        ])
        ->setHelp(<<<EOT
Executes arbitrary SQL directly from the command line.
EOT
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $conn = $this->getHelper('db')->getConnection();

        $sql = $input->getArgument('sql');

        if ($sql === null) {
            throw new RuntimeException("Argument 'SQL' is required in order to execute this command correctly.");
        }

        $depth = $input->getOption('depth');

        if (! is_numeric($depth)) {
            throw new LogicException("Option 'depth' must contains an integer value");
        }

        if (stripos($sql, 'select') === 0 || $input->getOption('force-fetch')) {
            $resultSet = $conn->fetchAll($sql);
        } else {
            $resultSet = $conn->executeUpdate($sql);
        }

        $output->write(Dumper::dump($resultSet, (int) $depth));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

namespace Doctrine\DBAL\Tools\Console\Helper;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Helper\Helper;

/**
 * Doctrine CLI Connection Helper.
 */
class ConnectionHelper extends Helper
{
    /**
     * The Doctrine database Connection.
     *
     * @var Connection
     */
    protected $_connection;

    /**
     * @param Connection $connection The Doctrine database Connection.
     */
    public function __construct(Connection $connection)
    {
        $this->_connection = $connection;
    }

    /**
     * Retrieves the Doctrine database Connection.
     *
     * @return Connection
     */
    public function getConnection()
    {
        return $this->_connection;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'connection';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

namespace Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use function is_resource;
use function restore_error_handler;
use function serialize;
use function set_error_handler;
use function stream_get_contents;
use function unserialize;

/**
 * Type that maps a PHP array to a clob SQL type.
 */
class ArrayType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getClobTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        // @todo 3.0 - $value === null check to save real NULL in database
        return serialize($value);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $value = is_resource($value) ? stream_get_contents($value) : $value;

        set_error_handler(function (int $code, string $message) : void {
            throw ConversionException::conversionFailedUnserialization($this->getName(), $message);
        });

        try {
            return unserialize($value);
        } finally {
            restore_error_handler();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return Type::TARRAY;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                