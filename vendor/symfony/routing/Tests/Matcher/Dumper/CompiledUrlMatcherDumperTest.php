<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\AbstractRecursivePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class TranslatorPathsPass extends AbstractRecursivePass
{
    private $translatorServiceId;
    private $debugCommandServiceId;
    private $updateCommandServiceId;
    private $resolverServiceId;
    private $level = 0;
    private $paths = [];
    private $definitions = [];
    private $controllers = [];

    public function __construct(string $translatorServiceId = 'translator', string $debugCommandServiceId = 'console.command.translation_debug', string $updateCommandServiceId = 'console.command.translation_update', string $resolverServiceId = 'argument_resolver.service')
    {
        $this->translatorServiceId = $translatorServiceId;
        $this->debugCommandServiceId = $debugCommandServiceId;
        $this->updateCommandServiceId = $updateCommandServiceId;
        $this->resolverServiceId = $resolverServiceId;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->translatorServiceId)) {
            return;
        }

        foreach ($this->findControllerArguments($container) as $controller => $argument) {
            $id = \substr($controller, 0, \strpos($controller, ':') ?: \strlen($controller));
            if ($container->hasDefinition($id)) {
                list($locatorRef) = $argument->getValues();
                $this->controllers[(string) $locatorRef][$container->getDefinition($id)->getClass()] = true;
            }
        }

        try {
            parent::process($container);

            $paths = [];
            foreach ($this->paths as $class => $_) {
                if (($r = $container->getReflectionClass($class)) && !$r->isInterface()) {
                    $paths[] = $r->getFileName();
                }
            }
            if ($paths) {
                if ($container->hasDefinition($this->debugCommandServiceId)) {
                    $definition = $container->getDefinition($this->debugCommandServiceId);
                    $definition->replaceArgument(6, array_merge($definition->getArgument(6), $paths));
                }
                if ($container->hasDefinition($this->updateCommandServiceId)) {
                    $definition = $container->getDefinition($this->updateCommandServiceId);
                    $definition->replaceArgument(7, array_merge($definition->getArgument(7), $paths));
                }
            }
        } finally {
            $this->level = 0;
            $this->paths = [];
            $this->definitions = [];
        }
    }

    protected function processValue($value, $isRoot = false)
    {
        if ($value instanceof Reference) {
            if ((string) $value === $this->translatorServiceId) {
                for ($i = $this->level - 1; $i >= 0; --$i) {
                    $class = $this->definitions[$i]->getClass();

                    if (ServiceLocator::class === $class) {
                        if (!isset($this->controllers[$this->currentId])) {
                            continue;
                        }
                        foreach ($this->controllers[$this->currentId] as $class => $_) {
                            $this->paths[$class] = true;
                        }
                    } else {
                        $this->paths[$class] = true;
                    }

                    break;
                }
            }

            return $value;
        }

        if ($value instanceof Definition) {
            $this->definitions[$this->level++] = $value;
            $value = parent::processValue($value, $isRoot);
            unset($this->definitions[--$this->level]);

            return $value;
        }

        return parent::processValue($value, $isRoot);
    }

    private function findControllerArguments(ContainerBuilder $container): array
    {
        if ($container->hasDefinition($this->resolverServiceId)) {
            $argument = $container->getDefinition($this->resolverServiceId)->getArgument(0);
            if ($argument instanceof Reference) {
                $argument = $container->getDefinition($argument);
            }

            return $argument->getArgument(0);
        }

        if ($container->hasDefinition('debug.'.$this->resolverServiceId)) {
            $argument = $container->getDefinition('debug.'.$this->resolverServiceId)->getArgument(0);
            if ($argument instanceof Reference) {
                $argument = $container->getDefinition($argument);
            }
            $argument = $argument->getArgument(0);
            if ($argument instanceof Reference) {
                $argument = $container->getDefinition($argument);
            }

            return $argument->getArgument(0);
        }

        return [];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Dumper;

use Symfony\Component\Translation\MessageCatalogue;

/**
 * CsvFileDumper generates a csv formatted string representation of a message catalogue.
 *
 * @author Stealth35
 */
class CsvFileDumper extends FileDumper
{
    private $delimiter = ';';
    private $enclosure = '"';

    /**
     * {@inheritdoc}
     */
    public function formatCatalogue(MessageCatalogue $messages, $domain, array $options = [])
    {
        $handle = fopen('php://memory', 'r+b');

        foreach ($messages->all($domain) as $source => $target) {
            fputcsv($handle, [$source, $target], $this->delimiter, $this->enclosure);
        }

        rewind($handle);
        $output = stream_get_contents($handle);
        fclose($handle);

        return $output;
    }

    /**
     * Sets the delimiter and escape character for CSV.
     *
     * @param string $delimiter Delimiter character
     * @param string $enclosure Enclosure character
     */
    public function setCsvControl($delimiter = ';', $enclosure = '"')
    {
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExtension()
    {
        return 'csv';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Dumper;

use Symfony\Component\Translation\MessageCatalogue;

/**
 * DumperInterface is the interface implemented by all translation dumpers.
 * There is no common option.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
interface DumperInterface
{
    /**
     * Dumps the message catalogue.
     *
     * @param MessageCatalogue $messages The message catalogue
     * @param array            $options  Options that are used by the dumper
     */
    public function dump(MessageCatalogue $messages, $options = []);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Dumper;

use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\Exception\RuntimeException;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * FileDumper is an implementation of DumperInterface that dump a message catalogue to file(s).
 *
 * Options:
 * - path (mandatory): the directory where the files should be saved
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
abstract class FileDumper implements DumperInterface
{
    /**
     * A template for the relative paths to files.
     *
     * @var string
     */
    protected $relativePathTemplate = '%domain%.%locale%.%extension%';

    /**
     * Sets the template for the relative paths to files.
     *
     * @param string $relativePathTemplate A template for the relative paths to files
     */
    public function setRelativePathTemplate($relativePathTemplate)
    {
        $this->relativePathTemplate = $relativePathTemplate;
    }

    /**
     * Sets backup flag.
     *
     * @param bool $backup
     *
     * @deprecated since Symfony 4.1
     */
    public function setBackup($backup)
    {
        @trigger_error(sprintf('The "%s()" method is deprecated since Symfony 4.1.', __METHOD__), E_USER_DEPRECATED);

        if (false !== $backup) {
            throw new \LogicException('The backup feature is no longer supported.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function dump(MessageCatalogue $messages, $options = [])
    {
        if (!\array_key_exists('path', $options)) {
            throw new InvalidArgumentException('The file dumper needs a path option.');
        }

        // save a file for each domain
        foreach ($messages->getDomains() as $domain) {
            $fullpath = $options['path'].'/'.$this->getRelativePath($domain, $messages->getLocale());
            if (!file_exists($fullpath)) {
                $directory = \dirname($fullpath);
                if (!file_exists($directory) && !@mkdir($directory, 0777, true)) {
                    throw new RuntimeException(sprintf('Unable to create directory "%s".', $directory));
                }
            }

            $intlDomain = $domain.MessageCatalogue::INTL_DOMAIN_SUFFIX;
            $intlMessages = $messages->all($intlDomain);

            if ($intlMessages) {
                $intlPath = $options['path'].'/'.$this->getRelativePath($intlDomain, $messages->getLocale());
                file_put_contents($intlPath, $this->formatCatalogue($messages, $intlDomain, $options));

                $messages->replace([], $intlDomain);

                try {
                    if ($messages->all($domain)) {
                        file_put_contents($fullpath, $this->formatCatalogue($messages, $domain, $options));
                    }
                    continue;
                } finally {
                    $messages->replace($intlMessages, $intlDomain);
                }
            }

            file_put_contents($fullpath, $this->formatCatalogue($messages, $domain, $options));
        }
    }

    /**
     * Transforms a domain of a messa