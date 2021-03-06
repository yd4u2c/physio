<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Tests\Writer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\Dumper\DumperInterface;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Writer\TranslationWriter;

class TranslationWriterTest extends TestCase
{
    public function testWrite()
    {
        $dumper = $this->getMockBuilder('Symfony\Component\Translation\Dumper\DumperInterface')->getMock();
        $dumper
            ->expects($this->once())
            ->method('dump');

        $writer = new TranslationWriter();
        $writer->addDumper('test', $dumper);
        $writer->write(new MessageCatalogue('en'), 'test');
    }

    /**
     * @group legacy
     */
    public function testDisableBackup()
    {
        $nonBackupDumper = new NonBackupDumper();
        $backupDumper = new BackupDumper();

        $writer = new TranslationWriter();
        $writer->addDumper('non_backup', $nonBackupDumper);
        $writer->addDumper('backup', $backupDumper);
        $writer->disableBackup();

        $this->assertFalse($backupDumper->backup, 'backup can be disabled if setBackup() method does exist');
    }
}

class NonBackupDumper implements DumperInterface
{
    public function dump(MessageCatalogue $messages, $options = [])
    {
    }
}

class BackupDumper implements DumperInterface
{
    public $backup = true;

    public function dump(MessageCatalogue $messages, $options = [])
    {
    }

    public function setBackup($backup)
    {
        $this->backup = $backup;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Util;

/**
 * ArrayConverter generates tree like structure from a message catalogue.
 * e.g. this
 *   'foo.bar1' => 'test1',
 *   'foo.bar2' => 'test2'
 * converts to follows:
 *   foo:
 *     bar1: test1
 *     bar2: test2.
 *
 * @author Gennady Telegin <gtelegin@gmail.com>
 */
class ArrayConverter
{
    /**
     * Converts linear messages array to tree-like array.
     * For example this array('foo.bar' => 'value') will be converted to ['foo' => ['bar' => 'value']].
     *
     * @param array $messages Linear messages array
     *
     * @return array Tree-like messages array
     */
    public static function expandToTree(array $messages)
    {
        $tree = [];

        foreach ($messages as $id => $value) {
            $referenceToElement = &self::getElementByPath($tree, explode('.', $id));

            $referenceToElement = $value;

            unset($referenceToElement);
        }

        return $tree;
    }

    private static function &getElementByPath(array &$tree, array $parts)
    {
        $elem = &$tree;
        $parentOfElem = null;

        foreach ($parts as $i => $part) {
            if (isset($elem[$part]) && \is_string($elem[$part])) {
                /* Process next case:
                 *    'foo': 'test1',
                 *    'foo.bar': 'test2'
                 *
                 * $tree['foo'] was string before we found array {bar: test2}.
                 *  Treat new element as string too, e.g. add $tree['foo.bar'] = 'test2';
                 */
                $elem = &$elem[implode('.', \array_slice($parts, $i))];
                break;
            }
            $parentOfElem = &$elem;
            $elem = &$elem[$part];
        }

        if ($elem && \is_array($elem) && $parentOfElem) {
            /* Process next case:
             *    'foo.bar': 'test1'
             *    'foo': 'test2'
             *
             * $tree['foo'] was array = {bar: 'test1'} before we found string constant `foo`.
             * Cancel treating $tree['foo'] as array and cancel back it expansion,
             *  e.g. make it $tree['foo.bar'] = 'test1' again.
             */
            self::cancelExpand($parentOfElem, $part, $elem);
        }

        return $elem;
    }

    private static function cancelExpand(array &$tree, $prefix, array $node)
    {
        $prefix .= '.';

        foreach ($node as $id => $value) {
            if (\is_string($value)) {
                $tree[$prefix.$id] = $value;
            } else {
                self::cancelExpand($tree, $prefix.$id, $value);
            }
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Util;

use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\Exception\InvalidResourceException;

/**
 * Provides some utility methods for XLIFF translation files, such as validating
 * their contents according to the XSD schema.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class XliffUtils
{
    /**
     * Gets xliff file version based on the root "version" attribute.
     *
     * Defaults to 1.2 for backwards compatibility.
     *
     * @throws InvalidArgumentException
     */
    public static function getVersionNumber(\DOMDocument $dom): string
    {
        /** @var \DOMNode $xliff */
        foreach ($dom->getElementsByTagName('xliff') as $xliff) {
            $version = $xliff->attributes->getNamedItem('version');
            if ($version) {
                return $version->nodeValue;
            }

            $namespace = $xliff->attributes->getNamedItem('xmlns');
            if ($namespace) {
                if (0 !== substr_compare('urn:oasis:names:tc:xliff:document:', $namespace->nodeValue, 0, 34)) {
                    throw new InvalidArgumentException(sprintf('Not a valid XLIFF namespace "%s"', $namespace));
                }

                return substr($namespace, 34);
            }
        }

        // Falls back to v1.2
        return '1.2';
    }

    /**
     * Validates and parses the given file into a DOMDocument.
     *
     * @throws InvalidResourceException
     */
    public static function validateSchema(\DOMDocument $dom): array
    {
        $xliffVersion = static::getVersionNumber($dom);
        $internalErrors = libxml_use_internal_errors(true);
        $disableEntities = libxml_disable_entity_loader(false);

        $isValid = @$dom->schemaValidateSource(self::getSchema($xliffVersion));
        if (!$isValid) {
            libxml_disable_entity_loader($disableEntities);

            return self::getXmlErrors($internalErrors);
        }

        libxml_disable_entity_loader($disableEntities);

        $dom->normalizeDocument();

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return [];
    }

    public static function getErrorsAsString(array $xmlErrors): string
    {
        $errorsAsString = '';

        foreach ($xmlErrors as $error) {
            $errorsAsString .= sprintf("[%s %s] %s (in %s - line %d, column %d)\n",
                LIBXML_ERR_WARNING === $error['level'] ? 'WARNING' : 'ERROR',
                $error['code'],
                $error['message'],
                $error['file'],
                $error['line'],
                $error['column']
            );
        }

        return $errorsAsString;
    }

    private static function getSchema(string $xliffVersion): string
    {
        if ('1.2' === $xliffVersion) {
            $schemaSource = file_get_contents(__DIR__.'/../Resources/schemas/xliff-core-1.2-strict.xsd');
            $xmlUri = 'http://www.w3.org/2001/xml.xsd';
        } elseif ('2.0' === $xliffVersion) {
            $schemaSource = file_get_contents(__DIR__.'/../Resources/schemas/xliff-core-2.0.xsd');
            $xmlUri = 'informativeCopiesOf3rdPartySchemas/w3c/xml.xsd';
        } else {
            throw new InvalidArgumentException(sprintf('No support implemented for loading XLIFF version "%s".', $xliffVersion));
        }

        return self::fixXmlLocation($schemaSource, $xmlUri);
    }

    /**
     * Internally changes the URI of a dependent xsd to be loaded locally.
     */
    private static function fixXmlLocation(string $schemaSource, string $xmlUri): string
    {
        $newPath = str_replace('\\', '/', __DIR__).'/../Resources/schemas/xml.xsd';
        $parts = explode('/', $newPath);
        $locationstart = 'file:///';
        if (0 === stripos($newPath, 'phar://')) {
            $tmpfile = tempnam(sys_get_temp_dir(), 'symfony');
            if ($tmpfile) {
                copy($newPath, $tmpfile);
                $parts = explode('/', str_replace('\\', '/', $tmpfile));
            } else {
                array_shift($parts);
                $locationstart = 'phar:///';
            }
        }

        $drive = '\\' === \DIRECTORY_SEPARATOR ? array_shift($parts).'/' : '';
        $newPath = $locationstart.$drive.implode('/', array_map('rawurlencode', $parts));

        return str_replace($xmlUri, $newPath, $schemaSource);
    }

    /**
     * Returns the XML errors of the internal XML parser.
     */
    private static function getXmlErrors(bool $internalErrors): array
    {
        $errors = [];
        foreach (libxml_get_errors() as $error) {
            $errors[] = [
                'level' => LIBXML_ERR_WARNING == $error->level ? 'WARNING' : 'ERROR',
                'code' => $error->code,
                'message' => trim($error->message),
                'file' => $error->file ?: 'n/a',
                'line' => $error->line,
                'column' => $error->column,
            ];
        }

        libxml_clear_errors();
        libxml_use_internal_errors($internalErrors);

        return $errors;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Writer;

use Symfony\Component\Translation\Dumper\DumperInterface;
use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\Exception\RuntimeException;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * TranslationWriter writes translation messages.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
class TranslationWriter implements TranslationWriterInterface
{
    private $dumpers = [];

    /**
     * Adds a dumper to the writer.
     *
     * @param string          $format The format of the dumper
     * @param DumperInterface $dumper The dumper
     */
    public function addDumper($format, DumperInterface $dumper)
    {
        $this->dumpers[$format] = $dumper;
    }

    /**
     * Disables dumper backup.
     *
     * @deprecated since Symfony 4.1
     */
    public function disableBackup()
    {
        @trigger_error(sprintf('The "%s()" method is deprecated since Symfony 4.1.', __METHOD__), E_USER_DEPRECATED);

        foreach ($this->dumpers as $dumper) {
            if (method_exists($dumper, 'setBackup')) {
                $dumper->setBackup(false);
            }
        }
    }

    /**
     * Obtains the list of supported formats.
     *
     * @return array
     */
    public function getFormats()
    {
        return array_keys($this->dumpers);
    }

    /**
     * Writes translation from the catalogue according to the selected format.
     *
     * @param MessageCatalogue $catalogue The message catalogue to write
     * @param string           $format    The format to use to dump the messages
     * @param array            $options   Options that are passed to the dumper
     *
     * @throws InvalidArgumentException
     */
    public function write(MessageCatalogue $catalogue, $format, $options = [])
    {
        if (!isset($this->dumpers[$format])) {
            throw new InvalidArgumentException(sprintf('There is no dumper associated with format "%s".', $format));
        }

        // get the right dumper
        $dumper = $this->dumpers[$format];

        if (isset($options['path']) && !is_dir($options['path']) && !@mkdir($options['path'], 0777, true) && !is_dir($options['path'])) {
            throw new RuntimeException(sprintf('Translation Writer was not able to create directory "%s"', $options['path']));
        }

        // save
        $dumper->dump($catalogue, $options);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Writer;

use Symfony\Component\Translation\Exception\InvalidArgumentException;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * TranslationWriter writes translation messages.
 *
 * @author Michel Salib <michelsalib@hotmail.com>
 */
interface TranslationWriterInterface
{
    /**
     * Writes translation from the catalogue according to the selected format.
     *
     * @param MessageCatalogue $catalogue The message catalogue to write
     * @param string           $format    The format to use to dump the messages
     * @param array            $options   Options that are passed to the dumper
     *
     * @throws InvalidArgumentException
     */
    public function write(MessageCatalogue $catalogue, $format, $options = []);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              