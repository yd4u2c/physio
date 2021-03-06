                   return static::$defaultColors = true;

                        case '--no-ansi':
                        case '--color=no':
                        case '--color=none':
                        case '--color=never':
                            return static::$defaultColors = false;
                    }
                }
            }
        }

        $h = stream_get_meta_data($this->outputStream) + ['wrapper_type' => null];
        $h = 'Output' === $h['stream_type'] && 'PHP' === $h['wrapper_type'] ? fopen('php://stdout', 'wb') : $this->outputStream;

        return static::$defaultColors = $this->hasColorSupport($h);
    }

    /**
     * {@inheritdoc}
     */
    protected function dumpLine($depth, $endOfValue = false)
    {
        if ($this->colors) {
            $this->line = sprintf("\033[%sm%s\033[m", $this->styles['default'], $this->line);
        }
        parent::dumpLine($depth);
    }

    protected function endValue(Cursor $cursor)
    {
        if (Stub::ARRAY_INDEXED === $cursor->hashType || Stub::ARRAY_ASSOC === $cursor->hashType) {
            if (self::DUMP_TRAILING_COMMA & $this->flags && 0 < $cursor->depth) {
                $this->line .= ',';
            } elseif (self::DUMP_COMMA_SEPARATOR & $this->flags && 1 < $cursor->hashLength - $cursor->hashIndex) {
                $this->line .= ',';
            }
        }

        $this->dumpLine($cursor->depth, true);
    }

    /**
     * Returns true if the stream supports colorization.
     *
     * Reference: Composer\XdebugHandler\Process::supportsColor
     * https://github.com/composer/xdebug-handler
     *
     * @param mixed $stream A CLI output stream
     *
     * @return bool
     */
    private function hasColorSupport($stream)
    {
        if (!\is_resource($stream) || 'stream' !== get_resource_type($stream)) {
            return false;
        }

        if ('Hyper' === getenv('TERM_PROGRAM')) {
            return true;
        }

        if (\DIRECTORY_SEPARATOR === '\\') {
            return (\function_exists('sapi_windows_vt100_support')
                && @sapi_windows_vt100_support($stream))
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        if (\function_exists('stream_isatty')) {
            return @stream_isatty($stream);
        }

        if (\function_exists('posix_isatty')) {
            return @posix_isatty($stream);
        }

        $stat = @fstat($stream);
        // Check if formatted mode is S_IFCHR
        return $stat ? 0020000 === ($stat['mode'] & 0170000) : false;
    }

    /**
     * Returns true if the Windows terminal supports true color.
     *
     * Note that this does not check an output stream, but relies on environment
     * variables from known implementations, or a PHP and Windows version that
     * supports true color.
     *
     * @return bool
     */
    private function isWindowsTrueColor()
    {
        $result = 183 <= getenv('ANSICON_VER')
            || 'ON' === getenv('ConEmuANSI')
            || 'xterm' === getenv('TERM')
            || 'Hyper' === getenv('TERM_PROGRAM');

        if (!$result && \PHP_VERSION_ID >= 70200) {
            $version = sprintf(
                '%s.%s.%s',
                PHP_WINDOWS_VERSION_MAJOR,
                PHP_WINDOWS_VERSION_MINOR,
                PHP_WINDOWS_VERSION_BUILD
            );
            $result = $version >= '10.0.15063';
        }

        return $result;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Dumper;

use Symfony\Component\VarDumper\Cloner\Cursor;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * HtmlDumper dumps variables as HTML.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class HtmlDumper extends CliDumper
{
    public static $defaultOutput = 'php://output';

    protected static $themes = [
        'dark' => [
            'default' => 'background-color:#18171B; color:#FF8400; line-height:1.2em; font:12px Menlo, Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:99999; word-break: break-all',
            'num' => 'font-weight:bold; color:#1299DA',
            'const' => 'font-weight:bold',
            'str' => 'font-weight:bold; color:#56DB3A',
            'note' => 'color:#1299DA',
            'ref' => 'color:#A0A0A0',
            'public' => 'color:#FFFFFF',
            'protected' => 'color:#FFFFFF',
            'private' => 'color:#FFFFFF',
            'meta' => 'color:#B729D9',
            'key' => 'color:#56DB3A',
            'index' => 'color:#1299DA',
            'ellipsis' => 'color:#FF8400',
            'ns' => 'user-select:none;',
        ],
        'light' => [
            'default' => 'background:none; color:#CC7832; line-height:1.2em; font:12px Menlo, Monaco, Consolas, monospace; word-wrap: break-word; white-space: pre-wrap; position:relative; z-index:99999; word-break: break-all',
            'num' => 'font-weight:bold; color:#1299DA',
            'const' => 'font-weight:bold',
            'str' => 'font-weight:bold; color:#629755;',
            'note' => 'color:#6897BB',
            'ref' => 'color:#6E6E6E',
            'public' => 'color:#262626',
            'protected' => 'color:#262626',
            'private' => 'color:#262626',
            'meta' => 'color:#B729D9',
            'key' => 'color:#789339',
            'index' => 'color:#1299DA',
            'ellipsis' => 'color:#CC7832',
            'ns' => 'user-select:none;',
        ],
    ];

    protected $dumpHeader;
    protected $dumpPrefix = '<pre class=sf-dump id=%s data-indent-pad="%s">';
    protected $dumpSuffix = '</pre><script>Sfdump(%s)</script>';
    protected $dumpId = 'sf-dump';
    protected $colors = true;
    protected $headerIsDumped = false;
    protected $lastDepth = -1;
    protected $styles;

    private $displayOptions = [
        'maxDepth' => 1,
        'maxStringLength' => 160,
        'fileLinkFormat' => null,
    ];
    private $extraDisplayOptions = [];

    /**
     * {@inheritdoc}
     */
    public function __construct($output = null, string $charset = null, int $flags = 0)
    {
        AbstractDumper::__construct($output, $charset, $flags);
        $this->dumpId = 'sf-dump-'.mt_rand();
        $this->displayOptions['fileLinkFormat'] = ini_get('xdebug.file_link_format') ?: get_cfg_var('xdebug.file_link_format');
        $this->styles = static::$themes['dark'] ?? self::$themes['dark'];
    }

    /**
     * {@inheritdoc}
     */
    public function setStyles(array $styles)
    {
        $this->headerIsDumped = false;
        $this->styles = $styles + $this->styles;
    }

    public function setTheme(string $themeName)
    {
        if (!isset(static::$themes[$themeName])) {
            throw new \InvalidArgumentException(sprintf('Theme "%s" does not exist in class "%s".', $themeName, static::class));
        }

        $this->setStyles(static::$themes[$themeName]);
    }

    /**
     * Configures display options.
     *
     * @param array $displayOptions A map of display options to customize the behavior
     */
    public function setDisplayOptions(array $displayOptions)
    {
        $this->headerIsDumped = false;
        $this->displayOptions = $displayOptions + $this->displayOptions;
    }

    /**
     * Sets an HTML header that will be dumped once in the output stream.
     *
     * @param string $header An HTML string
     */
    public function setDumpHeader($header)
    {
        $this->dumpHeader = $header;
    }

    /**
     * Sets an HTML prefix and suffix that will encapse every single dump.
     *
     * @param string $prefix The prepended HTML string
     * @param string $suffix The appended HTML string
     */
    public function setDumpBoundaries($prefix, $suffix)
    {
        $this->dumpPrefix = $prefix;
        $this->dumpSuffix = $suffix;
    }

    /**
     * {@inheritdoc}
     */
    public function dump(Data $data, $output = null, array $extraDisplayOptions = [])
    {
        $this->extraDisplayOptions = $extraDisplayOptions;
        $result = parent::dump($data, $output);
        $this->dumpId = 'sf-dump-'.mt_rand();

        return $result;
    }

    /**
     * Dumps the HTML header.
     */
    protected function getDumpHeader()
    {
        $this->headerIsDumped = null !== $this->outputStream ? $this->outputStream : $this->lineDumper;

        if (null !== $this->dumpHeader) {
            return $this->dumpHeader;
        }

        $line = str_replace('{$options}', json_encode($this->displayOptions, JSON_FORCE_OBJECT), <<<'EOHTML'
<script>
Sfdump = window.Sfdump || (function (doc) {

var refStyle = doc.createElement('style'),
    rxEsc = /([.*+?^${}()|\[\]\/\\])/g,
    idRx = /\bsf-dump-\d+-ref[012]\w+\b/,
    keyHint = 0 <= navigator.platform.toUpperCase().indexOf('MAC') ? 'Cmd' : 'Ctrl',
    addEventListener = function (e, n, cb) {
        e.addEventListener(n, cb, false);
    };

(doc.documentElement.firstElementChild || doc.documentElement.children[0]).appendChild(refStyle);

if (!doc.addEventListener) {
    addEventListener = function (element, eventName, callback) 