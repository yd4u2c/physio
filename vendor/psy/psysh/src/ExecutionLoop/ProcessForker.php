<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\VarDumper;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\VarDumper\Cloner\Cursor;
use Symfony\Component\VarDumper\Dumper\CliDumper;

/**
 * A PsySH-specialized CliDumper.
 */
class Dumper extends CliDumper
{
    private $formatter;
    private $forceArrayIndexes;

    protected static $onlyControlCharsRx = '/^[\x00-\x1F\x7F]+$/';
    protected static $controlCharsRx     = '/([\x00-\x1F\x7F]+)/';
    protected static $controlCharsMap    = [
        "\0"   => '\0',
        "\t"   => '\t',
        "\n"   => '\n',
        "\v"   => '\v',
        "\f"   => '\f',
        "\r"   => '\r',
        "\033" => '\e',
    ];

    public function __construct(OutputFormatter $formatter, $forceArrayIndexes = false)
    {
        $this->formatter = $formatter;
        $this->forceArrayIndexes = $forceArrayIndexes;
        parent::__construct();
        $this->setColors(false);
    }

    /**
     * {@inheritdoc}
     */
    public function enterHash(Cursor $cursor, $type, $class, $hasChild)
    {
        if (Cursor::HASH_INDEXED === $type || Cursor::HASH_ASSOC === $type) {
            $class = 0;
        }
        parent::enterHash($cursor, $type, $class, $hasChild);
    }

    /**
     * {@inheritdoc}
     */
    protected function dumpKey(Cursor $cursor)
    {
        if ($this->forceArrayIndexes || Cursor::HASH_INDEXED !== $cursor->hashType) {
            parent::dumpKey($cursor);
        }
    }

    protected function style($style, $value, $attr = [])
    {
        if ('ref' === $style) {
            $value = \strtr($value, '@', '#');
        }

        $styled = '';
        $map = self::$controlCharsMap;
        $cchr = $this->styles['cchr'];

        $chunks = \preg_split(self::$controlCharsRx, $value, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        foreach ($chunks as $chunk) {
            if (\preg_match(self::$onlyControlCharsRx, $chunk)) {
                $chars = '';
                $i = 0;
                do {
                    $chars .= isset($map[$chunk[$i]]) ? $map[$chunk[$i]] : \sprintf('\x%02X', \ord($chunk[$i]));
                } while (isset($chunk[++$i]));

                $chars = $this->formatter->escape($chars);
                $styled .= "<{$cchr}>{$chars}</{$cchr}>";
            } else {
                $styled .= $this->formatter->escape($chunk);
            }
        }

        $style = $this->styles[$style];

        return "<{$style}>{$styled}</{$style}>";
    }

    /**
     * {@inheritdoc}
     */
    protected function dumpLine($depth, $endOfValue = false)
    {
        if ($endOfValue && 0 < $depth) {
            $this->line .= ',';
        }
        $this->line = $this->formatter->format($this->line);
        parent::dumpLine($depth, $endOfValue);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\VarDumper;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\VarDumper\Caster\Caster;
use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * A Presenter service.
 */
class Presenter
{
    const VERBOSE = 1;

    private $cloner;
    private $dumper;
    private $exceptionsImportants = [
        "\0*\0message",
        "\0*\0code",
        "\0*\0file",
        "\0*\0line",
        "\0Exception\0previous",
    ];
    private $styles = [
        'num'       => 'number',
        'const'     => 'const',
        'str'       => 'string',
        'cchr'      => 'default',
        'note'      => 'class',
        'ref'       => 'default',
        'public'    => 'public',
        'protected' => 'protected',
        'private'   => 'private',
        'meta'      => 'comment',
        'key'       => 'comment',
        'index'     => 'number',
    ];

    public function __construct(OutputFormatter $formatter, $forceArrayIndexes = false)
    {
        // Work around https://github.com/symfony/symfony/issues/23572
        $oldLocale = \setlocale(LC_NUMERIC, 0);
        \setlocale(LC_NUMERIC, 'C');

        $this->dumper = new Dumper($formatter, $forceArrayIndexes);
        $this->dumper->setStyles($this->styles);

        // Now put the locale back
        \setlocale(LC_NUMERIC, $oldLocale);

        $this->cloner = new Cloner();
        $this->cloner->addCasters(['*' => function ($obj, array $a, Stub $stub, $isNested, $filter = 0) {
            if ($filter || $isNested) {
                if ($obj instanceof \Exception) {
                    $a = Caster::filter($a, Caster::EXCLUDE_NOT_IMPORTANT | Caster::EXCLUDE_EMPTY, $this->exceptionsImportants);
                } else {
                    $a = Caster::filter($a, Caster::EXCLUDE_PROTECTED | Caster::EXCLUDE_PRIVATE);
                }
            }

            return $a;
        }]);
    }

    /**
     * Register casters.
     *
     * @see http://symfony.com/doc/current/components/var_dumper/advanced.html#casters
     *
     * @param callable[] $casters A map of casters
     */
    public function addCasters(array $casters)
    {
        $this->cloner->addCasters($casters);
    }

    /**
     * Present a reference to t