<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Catalogue;

use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * Represents an operation on catalogue(s).
 *
 * An instance of this interface performs an operation on one or more catalogues and
 * stores intermediate and final results of the operation.
 *
 * The first catalogue in its argument(s) is called the 'source catalogue' or 'source' and
 * the following results are stored:
 *
 * Messages: also called 'all', are valid messages for the given domain after the operation is performed.
 *
 * New Messages: also called 'new' (new = all ∖ source = {x: x ∈ all ∧ x ∉ source}).
 *
 * Obsolete Messages: also called 'obsolete' (obsolete = source ∖ all = {x: x ∈ source ∧ x ∉ all}).
 *
 * Result: also called 'result', is the resulting catalogue for the given domain that holds the same messages as 'all'.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
interface OperationInterface
{
    /**
     * Returns domains affected by operation.
     *
     * @return array
     */
    public function getDomains();

    /**
     * Returns all valid messages ('all') after operation.
     *
     * @param string $domain
     *
     * @return array
     */
    public function getMessages($domain);

    /**
     * Returns new messages ('new') after operation.
     *
     * @param string $domain
     *
     * @return array
     */
    public function getNewMessages($domain);

    /**
     * Returns obsolete messages ('obsolete') after operation.
     *
     * @param string $domain
     *
     * @return array
     */
    public function getObsoleteMessages($domain);

    /**
     * Returns resulting catalogue ('result').
     *
     * @return MessageCatalogueInterface
     */
    public function getResult();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Catalogue;

use Symfony\Component\Translation\MessageCatalogueInterface;

/**
 * Target operation between two catalogues:
 * intersection = source ∩ target = {x: x ∈ source ∧ x ∈ target}
 * all = intersection ∪ (target ∖ intersection) = target
 * new = all ∖ source = {x: x ∈ target ∧ x ∉ source}
 * obsolete = source ∖ all = source ∖ target = {x: x ∈ source ∧ x ∉ target}
 * Basically, the result contains messages from the target catalogue.
 *
 * @author Michael Lee <michael.lee@zerustech.com>
 */
class TargetOperation extends AbstractOperation
{
    /**
     * {@inheritdoc}
     */
    protected function processDomain($domain)
    {
        $this->messages[$domain] = [
            'all' => [],
            'new' => [],
            'obsolete' => [],
        ];
        $intlDomain = $domain.MessageCatalogueInterface::INTL_DOMAIN_SUFFIX;

        // For 'all' messages, the code can't be simplified as ``$this->messages[$domain]['all'] = $target->all($domain);``,
        // because doing so will drop messages like {x: x ∈ source ∧ x ∉ target.all ∧ x ∈ target.fallback}
        //
        // For 'new' messages, the code can't be simplified as ``array_diff_assoc($this->target->all($domain), $this->source->all($domain));``
        // because doing so will not exclude messages like {x: x ∈ target ∧ x ∉ source.all ∧ x ∈ source.fallback}
        //
        // For 'obsolete' messages, the code can't be simplified as ``array_diff_assoc($this->source->all($domain), $this->target->all($domain))``
        // because doing so will not exclude messages like {x: x ∈ source ∧ x ∉ target.all ∧ x ∈ target.fallback}

        foreach ($this->source->all($domain) as $id => $message) {
            if ($this->target->has($id, $domain)) {
                $this->messages[$domain]['all'][$id] = $message;
                $this->result->add([$id => $message], $this->target->defines($id, $intlDomain) ? $intlDomain : $domain);
                if (null !== $keyMetadata = $this->source->getMetadata($id, $domain)) {
                    $this->result->setMetadata($id, $keyMetadata, $domain);
                }
            } else {
                $this->messages[$domain]['obsolete'][$id] = $message;
            }
        }

        foreach ($this->target->all($domain) as $id => $message) {
            if (!$this->source->has($id, $domain)) {
                $this->messages[$domain]['all'][$id] = $message;
                $this->messages[$domain]['new'][$id] = $message;
                $this->result->add([$id => $message], $this->target->defines($id, $intlDomain) ? $intlDomain : $domain);
                if (null !== $keyMetadata = $this->target->getMetadata($id, $domain)) {
                    $this->result->setMetadata($id, $keyMetadata, $domain);
                }
            }
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Translation\Util\XliffUtils;

/**
 * Validates XLIFF files syntax and outputs encountered errors.
 *
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 * @author Robin Chalas <robin.chalas@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class XliffLintCommand extends Command
{
    protected static $defaultName = 'lint:xliff';

    private $format;
    private $displayCorrectFiles;
    private $directoryIteratorProvider;
    private $isReadableProvider;
    private $requireStrictFileNames;

    public function __construct(string $name = null, callable $directoryIteratorProvider = null, callable $isReadableProvider = null, bool $requireStrictFileNames = true)
    {
        parent::__construct($name);

        $this->directoryIteratorProvider = $directoryIteratorProvider;
        $this->isReadableProvider = $isReadableProvider;
        $this->requireStrictFileNames = $requireStrictFileNames;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Lints a XLIFF file and outputs encountered errors')
            ->addArgument('filename', InputArgument::IS_ARRAY, 'A file or a directory or STDIN')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'The output format', 'txt')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command lints a XLIFF file and outputs to STDOUT
the first encountered syntax error.

You can validates XLIFF contents passed from STDIN:

  <info>cat filename | php %command.full_name%</info>

You can also validate the syntax of a file:

  <info>php %command.full_name% filename</info>

Or of a whole directory:

  <info>php %command.full_name% dirname</info>
  <info>php %command.full_name% dirname --format=json</info>

EOF
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $filenames = (array) $input->getArgument('filename');
        $this->format = $input->getOption('format');
        $this->displayCorrectFiles = $output->isVerbose();

        if (0 === \count($filenames)) {
            if (!$stdin = $this->getStdin()) {
                throw new RuntimeException('Please provide a filename or pipe file content to STDIN.');
            }

            return $this->display($io, [$this->validate($stdin)]);
        }

        $filesInfo = [];
        foreach ($filenames as $filename) {
            if (!$this->isReadable($filename)) {
                throw new RuntimeException(sprintf('File or directory "%s" is not readable.', $filename));
            }

            foreach ($this->getFiles($filename) as $file) {
                $filesInfo[] = $this->validate(file_get_contents($file), $file);
            }
        }

        return $this->display($io, $filesInfo);
    }

    private function validate($content, $file = null)
    {
        $errors = [];

        // Avoid: Warning DOMDocument::loadXML(): Empty string supplied as input
        if ('' === trim($content)) {
            return ['file' => $file, 'valid' => true];
        }

        $internal = libxml_use_internal_errors(true);

        $document = new \DOMDocument();
        $document->loadXML($content);

        if (null !== $targetLanguage = $this->getTargetLanguageFromFile($document)) {
            $normalizedLocale = preg_quote(str_replace('-', '_', $targetLanguage), '/');
            // strict file names require translation files to be named '____.locale.xlf'
            // otherwise, both '____.locale.xlf' and 'locale.____.xlf' are allowed
            $expectedFilenamePattern = $this->requireStrictFileNames ? sprintf('/^.*\.%s\.xlf/', $normalizedLocale) : sprintf('/^(.*\.%s\.xlf|%s\..*\.xlf)/', $normalizedLocale, $normalizedLocale);

            if (0 === preg_match($expectedFilenamePattern, basename($file))) {
                $errors[] = [
                    'line' => -1,
                    'column' => -1,
                    'message' => sprintf('There is a mismatch between the language included in the file name ("%s") and the "%s" value used in the "target-language" attribute of the file.', basename($file), $targetLanguage),
                ];
            }
        }

        foreach (XliffUtils::validateSchema($document) as $xmlError) {
            $errors[] = [
                'line' => $xmlError['line'],
                'column' => $xmlError['column'],
                'message' => $xmlError['message'],
            ];
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internal);

        return ['file' => $file, 'valid' => 0 === \count($errors), 'messages' => $errors];
    }

    private function display(SymfonyStyle $io, array $files)
    {
        switch ($this->format) {
            case 'txt':
                return $this->displayTxt($io, $files);
            case 'json':
                return $this->displayJson($io, $files);
            default:
                throw new InvalidArgumentException(sprintf('The format "%s" is not supported.', $this->format));
        }
    }

    private function displayTxt(SymfonyStyle $io, array $filesInfo)
    {
        $countFiles = \count($filesInfo);
        $erroredFiles = 0;

        foreach ($filesInfo as $info) {
            if ($info['valid'] && $this->displayCorrectFiles) {
                $io->comment('<info>OK</info>'.($info['file'] ? sprintf(' in %s', $info['file']) : ''));
            } elseif (!$info['valid']) {
                ++$erroredFiles;
                $io->text('<error> ERROR </error>'.($info['file'] ? sprintf(' in %s', $info['file']) : ''));
                $io->listing(array_map(function ($error) {
                    // general document errors have a '-1' line number
                    return -1 === $error['line'] ? $error['message'] : sprintf('Line %d, Column %d: %s', $error['line'], $error['column'], $error['message']);
                }, $info['messages']));
            }
        }

        if (0 === $erroredFiles) {
            $io->success(sprintf('All %d XLIFF files contain valid syntax.', $countFiles));
        } else {
            $io->warning(sprintf('%d XLIFF files have valid syntax and %d contain errors.', $countFiles - $erroredFiles, $erroredFiles));
        }

        return min($erroredFiles, 1);
    }

    private function displayJson(SymfonyStyle $io, array $filesInfo)
    {
        $errors = 0;

        array_walk($filesInfo, function (&$v) use (&$errors) {
            $v['file'] = (string) $v['file'];
            if (!$v['valid']) {
                ++$errors;
            }
        });

        $io->writeln(json_encode($filesInfo, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return min($errors, 1);
    }

    private function getFiles($fileOrDirectory)
    {
        if (is_file($fileOrDirectory)) {
            yield new \SplFileInfo($fileOrDirectory);

            return;
        }

        foreach ($this->getDirectoryIterator($fileOrDirectory) as $file) {
            if (!\in_array($file->getExtension(), ['xlf', 'xliff'])) {
                continue;
            }

            yield $file;
        }
    }

    private function getStdin()
    {
        if (0 !== ftell(STDIN)) {
            return;
        }

        $inputs = '';
        while (!feof(STDIN)) {
            $inputs .= fread(STDIN, 1024);
        }

        return $inputs;
    }

    private function getDirectoryIterator($directory)
    {
        $default = function ($directory) {
            return new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($directory, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS),
                \RecursiveIteratorIterator::LEAVES_ONLY
            );
        };

        if (null !== $this->directoryIteratorProvider) {
            return ($this->directoryIteratorProvider)($directory, $default);
        }

        return $default($directory);
    }

    private function isReadable($fileOrDirectory)
    {
        $default = function ($fileOrDirectory) {
            return is_readable($fileOrDirectory);
        };

        if (null !== $this->isReadableProvider) {
            return ($this->isReadableProvider)($fileOrDirectory, $default);
        }

        return $default($fileOrDirectory);
    }

    private function getTargetLanguageFromFile(\DOMDocument $xliffContents): ?string
    {
        foreach ($xliffContents->getElementsByTagName('file')[0]->attributes ?? [] as $attribute) {
            if ('target-language' === $attribute->nodeName) {
                return $attribute->nodeValue;
            }
        }

        return null;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\DataCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\DataCollector\LateDataCollectorInterface;
use Symfony\Component\Translation\DataCollectorTranslator;

/**
 * @author Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class TranslationDataCollector extends DataCollector implements LateDataCollectorInterface
{
    private $translator;

    public function __construct(DataCollectorTranslator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function lateCollect()
    {
        $messages = $this->sanitizeCollectedMessages($this->translator->getCollectedMessages());

        $this->data = $this->computeCount($messages);
        $this->data['messages'] = $messages;

        $this->data['locale'] = $this->translator->getLocale();
        $this->data['fallback_locales'] = $this->translator->getFallbackLocales();

        $this->data = $this->cloneVar($this->data);
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function reset()
    {
        $this->data = [];
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return isset($this->data['messages']) ? $this->data['messages'] : [];
    }

    /**
     * @return int
     */
    public function getCountMissings()
    {
        return isset($this->data[DataCollectorTranslator::MESSAGE_MISSING]) ? $this->data[DataCollectorTranslator::MESSAGE_MISSING] : 0;
    }

    /**
     * @return int
     */
    public function getCountFallbacks()
    {
        return isset($this->data[DataCollectorTranslator::MESSAGE_EQUALS_FALLBACK]) ? $this->data[DataCollectorTranslator::MESSAGE_EQUALS_FALLBACK] : 0;
    }

    /**
     * @return int
     */
    public function getCountDefines()
    {
        return isset($this->data[DataCollectorTranslator::MESSAGE_DEFINED]) ? $this->data[DataCollectorTranslator::MESSAGE_DEFINED] : 0;
    }

    public function getLocale()
    {
        return !empty($this->data['locale']) ? $this->data['locale'] : null;
    }

    /**
     * @internal since Symfony 4.2
     */
    public function getFallbackLocales()
    {
        return (isset($this->data['fallback_locales']) && \count($this->data['fallback_locales']) > 0) ? $this->data['fallback_locales'] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'translation';
    }

    private function sanitizeCollectedMessages($messages)
    {
        $result = [];
        foreach ($messages as $key => $message) {
            $messageId = $message['locale'].$message['domain'].$message['id'];

            if (!isset($result[$messageId])) {
                $message['count'] = 1;
                $message['parameters'] = !empty($message['parameters']) ? [$message['parameters']] : [];
                $messages[$key]['translation'] = $this->sanitizeString($message['translation']);
                $result[$messageId] = $message;
            } else {
                if (!empty($message['parameters'])) {
                    $result[$messageId]['parameters'][] = $message['parameters'];
                }

                ++$result[$messageId]['count'];
            }

            unset($messages[$key]);
        }

        return $result;
    }

    private function computeCount($messages)
    {
        $count = [
            DataCollectorTranslator::MESSAGE_DEFINED => 0,
            DataCollectorTranslator::MESSAGE_MISSING => 0,
            DataCollectorTranslator::MESSAGE_EQUALS_FALLBACK => 0,
        ];

        foreach ($messages as $message) {
            ++$count[$message['state']];
        }

        return $count;
    }

    private function sanitizeString($string, $length = 80)
    {
        $string = trim(preg_replace('/\s+/', ' ', $string));

        if (false !== $encoding = mb_detect_encoding($string, null, true)) {
            if (mb_strlen($string, $encoding) > $length) {
                return mb_substr($string, 0, $length - 3, $encoding).'...';
            }
        } elseif (\strlen($string) > $length) {
            return substr($string, 0, $length - 3).'...';
        }

        return $string;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Adds tagged translation.formatter services to translation writer.
 */
class TranslationDumperPass implements CompilerPassInterface
{
    private $writerServiceId;
    private $dumperTag;

    public function __construct(string $writerServiceId = 'translation.writer', string $dumperTag = 'translation.dumper')
    {
        $this->writerServiceId = $writerServiceId;
        $this->dumperTag = $dumperTag;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->writerServiceId)) {
            return;
        }

        $definition = $container->getDefinition($this->writerServiceId);

        foreach ($container->findTaggedServiceIds($this->dumperTag, true) as $id => $attributes) {
            $definition->addMethodCall('addDumper', [$attributes[0]['alias'], new Reference($id)]);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Adds tagged translation.extractor services to translation extractor.
 */
class TranslationExtractorPass implements CompilerPassInterface
{
    private $extractorServiceId;
    private $extractorTag;

    public function __construct(string $extractorServiceId = 'translation.extractor', string $extractorTag = 'translation.extractor')
    {
        $this->extractorServiceId = $extractorServiceId;
        $this->extractorTag = $extractorTag;
    }

    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition($this->extractorServiceId)) {
            return;
        }

        $definition = $container->getDefinition($this->extractorServiceId);

        foreach ($container->findTaggedServiceIds($this->extractorTag, true) as $id => $attributes) {
            if (!isset($attributes[0]['alias'])) {
                throw new RuntimeException(sprintf('The alias for the tag "translation.extractor" of service "%s" must be set.', $id));
            }

            $definition->addMethodCall('addExtractor', [$attributes[0]['alias'], new Reference($id)]);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class TranslatorPass implements CompilerPassInterface
{
    private $translatorServiceId;
    private $readerServiceId;
    private $loaderTag;
    private $debugCommandServiceId;
    private $updateCommandServiceId;

    public function __construct(string $translatorServiceId = 'translator.default', string $readerServi