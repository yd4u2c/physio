Dumper::DUMP_COMMA_SEPARATOR];

        $expected = <<<'EOTXT'
array:3 [
  "array" => array:2 [
    0 => "a",
    1 => "b",
  ],
  "string" => "hello",
  "multiline string" => """
    this\n
    is\n
    a\multiline\n
    string
    """,
]

EOTXT;

        yield [$expected, CliDumper::DUMP_TRAILING_COMMA];
    }

    /**
     * @requires extension xml
     */
    public function testXmlResource()
    {
        $var = xml_parser_create();

        $this->assertDumpMatchesFormat(
            <<<'EOTXT'
xml resource {
  current_byte_index: %i
  current_column_number: %i
  current_line_number: 1
  error_code: XML_ERROR_NONE
}
EOTXT
            ,
            $var
        );
    }

    public function testJsonCast()
    {
        $var = (array) json_decode('{"0":{},"1":null}');
        foreach ($var as &$v) {
        }
        $var[] = &$v;
        $var[''] = 2;

        if (\PHP_VERSION_ID >= 70200) {
            $this->assertDumpMatchesFormat(
                <<<'EOTXT'
array:4 [
  0 => {}
  1 => &1 null
  2 => &1 null
  "" => 2
]
EOTXT
                ,
                $var
            );
        } else {
            $this->assertDumpMatchesFormat(
                <<<'EOTXT'
array:4 [
  "0" => {}
  "1" => &1 null
  0 => &1 null
  "" => 2
]
EOTXT
                ,
                $var
            );
        }
    }

    public function testObjectCast()
    {
        $var = (object) [1 => 1];
        $var->{1} = 2;

        if (\PHP_VERSION_ID >= 70200) {
            $this->assertDumpMatchesFormat(
                <<<'EOTXT'
{
  +"1": 2
}
EOTXT
                ,
                $var
            );
        } else {
            $this->assertDumpMatchesFormat(
                <<<'EOTXT'
{
  +1: 1
  +"1": 2
}
EOTXT
                ,
                $var
            );
        }
    }

    public function testClosedResource()
    {
        $var = fopen(__FILE__, 'r');
        fclose($var);

        $dumper = new CliDumper('php://output');
        $dumper->setColors(false);
        $cloner = new VarCloner();
        $data = $cloner->cloneVar($var);

        ob_start();
        $dumper->dump($data);
        $out = ob_get_clean();
        $res = (int) $var;

        $this->assertStringMatchesFormat(
            <<<EOTXT
Closed resource @{$res}

EOTXT
            ,
            $out
        );
    }

    public function testFlags()
    {
        putenv('DUMP_LIGHT_ARRAY=1');
        putenv('DUMP_STRING_LENGTH=1');

        $var = [
            range(1, 3),
            ['foo', 2 => 'bar'],
        ];

        $this->assertDumpEquals(
            <<<EOTXT
[
  [
    1
    2
    3
  ]
  [
    0 => (3) "foo"
    2 => (3) "bar"
  ]
]
EOTXT
            ,
            $var
        );

        putenv('DUMP_LIGHT_ARRAY=');
        putenv('DUMP_STRING_LENGTH=');
    }

    /**
     * @requires function Twig\Template::getSourceContext
     */
    public function testThrowingCaster()
    {
        $out = fopen('php://memory', 'r+b');

        require_once __DIR__.'/../Fixtures/Twig.php';
        $twig = new \__TwigTemplate_VarDumperFixture_u75a09(new Environment(new FilesystemLoader()));

        $dumper = new CliDumper();
        $dumper->setColors(false);
        $cloner = new VarCloner();
        $cloner->addCasters([
            ':stream' => function ($res, $a) {
                unset($a['wrapper_data']);

                return $a;
            },
        ]);
        $cloner->addCasters([
            ':stream' => eval('return function () use ($twig) {
                try {
                    $twig->render([]);
                } catch (\Twig\Error\RuntimeError $e) {
                    throw $e->getPrevious();
                }
            };'),
        ]);
        $ref = (int) $out;

        $data = $cloner->cloneVar($out);
        $dumper->dump($data, $out);
        $out = stream_get_contents($out, -1, 0);

        $this->assertStringMatchesFormat(
            <<<EOTXT
stream resource {@{$ref}
  ⚠: Symfony\Component\VarDumper\Exception\ThrowingCasterException {#%d
    #message: "Unexpected Exception thrown from a caster: Foobar"
    trace: {
      %sTwig.php:2 {
        › foo bar
        ›   twig source
        › 
      }
      %s%eTemplate.php:%d { …}
      %s%eTemplate.php:%d { …}
      %s%eTemplate.php:%d { …}
      %s%eTests%eDumper%eCliDumperTest.php:%d { …}
%A  }
  }
%Awrapper_type: "PHP"
  stream_type: "MEMORY"
  mode: "%s+b"
  unread_bytes: 0
  seekable: true
  uri: "php://memory"
%Aoptions: []
}

EOTXT
            ,
            $out
        );
    }

    public function testRefsInProperties()
    {
        $var = (object) ['foo' => 'foo'];
        $var->bar = &$var->foo;

        $dumper = new CliDumper();
        $dumper->setColors(false);
        $cloner = new VarCloner();

        $data = $cloner->cloneVar($var);
        $out = $dumper->dump($data, true);

        $this->assertStringMatchesFormat(
            <<<EOTXT
{#%d
  +"foo": &1 "foo"
  +"bar": &1 "foo"
}

EOTXT
            ,
            $out
        );
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testSpecialVars56()
    {
        $var = $this->getSpecialVars();

        $this->assertDumpEquals(
            <<<'EOTXT'
array:3 [
  0 => array:1 [
    0 => &1 array:1 [
      0 => &1 array:1 [&1]
    ]
  ]
  1 => array:1 [
    "GLOBALS" => &2 array:1 [
      "GLOBALS" => &2 array:1 [&2]
    ]
  ]
  2 => &2 array:1 [&2]
]
EOTXT
            ,
            $var
        );
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testGlobals()
    {
        $var = $this->getSpecialVars();
        unset($var[0]);
        $out = '';

        $dumper = new CliDumper(function ($line, $depth) use (&$out) {
            if ($depth >= 0) {
                $out .= str_repeat('  ', $depth).$line."\n";
            }
        });
        $dumper->setColors(false);
        $cloner = new VarCloner();

        $data = $cloner->cloneVar($var);
        $dumper->dump($data);

        $this->assertSame(
            <<<'EOTXT'
array:2 [
  1 => array:1 [
    "GLOBALS" => &1 array:1 [
      "GLOBALS" => &1 array:1 [&1]
    ]
  ]
  2 => &1 array:1 [&1]
]

EOTXT
            ,
            $out
        );
    }

    public function testIncompleteClass()
    {
        $unserializeCallbackHandler = ini_set('unserialize_callback_func', null);
        $var = unserialize('O:8:"Foo\Buzz":0:{}');
        ini_set('unserialize_callback_func', $unserializeCallbackHandler);

        $this->assertDumpMatchesFormat(
            <<<EOTXT
__PHP_Incomplete_Class(Foo\Buzz) {}
EOTXT
            ,
            $var
        );
    }

    private function getSpecialVars()
    {
        foreach (array_keys($GLOBALS) as $var) {
            if ('GLOBALS' !== $var) {
                unset($GLOBALS[$var]);
            }
        }

        $var = function &() {
            $var = [];
            $var[] = &$var;

            return $var;
        };

        return [$var(), $GLOBALS, &$GLOBALS];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Tests\Dumper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\VarDumper;

class FunctionsTest extends TestCase
{
    public function testDumpReturnsFirstArg()
    {
        $this->setupVarDumper();

        $var1 = 'a';

        ob_start();
        $return = dump($var1);
        $out = ob_get_clean();

        $this->assertEquals($var1, $return);
    }

    public function testDumpReturnsAllArgsInArray()
    {
        $this->setupVarDumper();

        $var1 = 'a';
        $var2 = 'b';
        $var3 = 'c';

        ob_start();
        $return = dump($var1, $var2, $var3);
        $out = ob_get_clean();

        $this->assertEquals([$var1, $var2, $var3], $return);
    }

    protected function setupVarDumper()
    {
        $cloner = new VarCloner();
        $dumper = new CliDumper('php://output');
        VarDumper::setHandler(function ($var) use ($cloner, $dumper) {
            $dumper->dump($cloner->cloneVar($var));
        });
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Tests\Dumper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class HtmlDumperTest extends TestCase
{
    public function testGet()
    {
        if (ini_get('xdebug.file_link_format') || get_cfg_var('xdebug.file_link_format')) {
            $this->markTestSkipped('A custom file_link_format is defined.');
        }

        require __DIR__.'/../Fixtures/dumb-var.php';

        $dumper = new HtmlDumper('php://output');
        $dumper->setDumpHeader('<foo></foo>');
        $dumper->setDumpBoundaries('<bar>', '</bar>');
        $cloner = new VarCloner();
        $cloner->addCasters([
            ':stream' => function ($res, $a) {
                unset($a['uri'], $a['wrapper_data']);

                return $a;
            },
        ]);
        $data = $cloner->cloneVar($var);

        ob_start();
        $dumper->dump($data);
        $out = ob_get_clean();
        $out = preg_replace('/[ \t]+$/m', '', $out);
        $var['file'] = htmlspecialchars($var['file'], ENT_QUOTES, 'UTF-8');
        $intMax = PHP_INT_MAX;
        preg_match('/sf-dump-\d+/', $out, $dumpId);
        $dumpId = $dumpId[0];
        $res = (int) $var['res'];

        $this->assertStringMatchesFormat(
            <<<EOTXT
<foo></foo><bar><span class=sf-dump-note>array:24</span> [<samp>
  "<span class=sf-dump-key>number</span>" => <span class=sf-dump-num>1</span>
  <span class=sf-dump-key>0</span> => <a class=sf-dump-ref href=#{$dumpId}-ref01 title="2 occurrences">&amp;1</a> <span class=sf-dump-const>null</span>
  "<span class=sf-dump-key>const</span>" => <span class=sf-dump-num>1.1</span>
  <span class=sf-dump-key>1</span> => <span class=sf-dump-const>true</span>
  <span class=sf-dump-key>2</span> => <span class=sf-dump-const>false</span>
  <span class=sf-dump-key>3</span> => <span class=sf-dump-num>NAN</span>
  <span class=sf-dump-key>4</span> => <span class=sf-dump-num>INF</span>
  <span class=sf-dump-key>5</span> => <span class=sf-dump-num>-INF</span>
  <span class=sf-dump-key>6</span> => <span class=sf-dump-num>{$intMax}</span>
  "<span class=sf-dump-key>str</span>" => "<span class=sf-dump-str title="5 characters">d&%s;j&%s;<span class="sf-dump-default sf-dump-ns">\\n</span></span>"
  <span class=sf-dump-key>7</span> => b"""
    <span class=sf-dump-str title="11 binary or non-UTF-8 characters">&eacute;<span class="sf-dump-default">\\x00</span>test<span class="sf-dump-default">\\t</span><span class="sf-dump-default sf-dump-ns">\\n</span></span>
    <span class=sf-dump-str title="11 binary or non-UTF-8 characters">ing</span>
    """
  "<span class=sf-dump-key>[]</span>" => []
  "<span class=sf-dump-key>res</span>" => <span class=sf-dump-note>stream resource</span> <a class=sf-dump-ref>@{$res}</a><samp>
%A  <span class=sf-dump-meta>wrapper_type</span>: "<span class=sf-dump-str title="9 characters">plainfile</span>"
    <span class=sf-dump-meta>stream_type</span>: "<span class=sf-dump-str title="5 characters">STDIO</span>"
    <span class=sf-dump-meta>mode</span>: "<span class=sf-dump-str>r</span>"
    <span class=sf-dump-meta>unread_bytes</span>: <span class=sf-dump-num>0</span>
    <span class=sf-dump-meta>seekable</span>: <span class=sf-dump-const>true</span>
%A  <span class=sf-dump-meta>options</span>: []
  </samp>}
  "<span class=sf-dump-key>obj</span>" => <abbr title="Symfony\Component\VarDumper\Tests\Fixture\DumbFoo" class=sf-dump-note>DumbFoo</abbr> {<a class=sf-dump-ref href=#{$dumpId}-ref2%d title="2 occurrences">#%d</a><samp id={$dumpId}-ref2%d>
    +<span class=sf-dump-public title="Public property">foo</span>: "<span class=sf-dump-str title="3 characters">foo</span>"
    +"<span class=sf-dump-public title="Runtime added dynamic property">bar</span>": "<span class=sf-dump-str title="3 characters">bar</span>"
  </samp>}
  "<span class=sf-dump-key>closure</span>" => <span class=sf-dump-note>Closure(\$a, PDO &amp;\$b = null)</span> {<a class=sf-dump-ref>#%d</a><samp>
    <span class=sf-dump-meta>class</span>: "<span class=sf-dump-str title="Symfony\Component\VarDumper\Tests\Dumper\HtmlDumperTest
55 characters"><span class="sf-dump-ellipsis sf-dump-ellipsis-class">Symfony\Component\VarDumper\Tests\Dumper</span><span class=sf-dump-ellipsis>\</span>HtmlDumperTest</span>"
    <span class=sf-dump-meta>this</span>: <abbr title="Symfony\Component\VarDumper\Tests\Dumper\HtmlDumperTest" class=sf-dump-note>HtmlDumperTest</abbr> {<a class=sf-dump-ref>#%d</a> &%s;}
    <span class=sf-dump-meta>parameters</span>: {<samp>
      <span class=sf-dump-meta>\$a</span>: {}
      <span class=sf-dump-meta>&amp;\$b</span>: {<samp>
        <span class=sf-dump-meta>typeHint</span>: "<span class=sf-dump-str title="3 characters">PDO</span>"
        <span class=sf-dump-meta>default</span>: <span class=sf-dump-const>null</span>
      </samp>}
    </samp>}
    <span class=sf-dump-meta>file</span>: "<span class=sf-dump-str title="{$var['file']}
%d characters"><span class="sf-dump-ellipsis sf-dump-ellipsis-path">%s%eVarDumper</span><span class=sf-dump-ellipsis>%e</span>Tests%eFixtures%edumb-var.php</span>"
    <span class=sf-dump-meta>line</span>: "<span class=sf-dump-str title="%d characters">{$var['line']} to {$var['line']}</span>"
  </samp>}
  "<span class=sf-dump-key>line</span>" => <span class=sf-dump-num>{$var['line']}</span>
  "<span class=sf-dump-key>nobj</span>" => <span class=sf-dump-note>array:1</span> [<samp>
    <span class=sf-dump-index>0</span> => <a class=sf-dump-ref href=#{$dumpId}-ref03 title="2 occurrences">&amp;3</a> {<a class=sf-dump-ref href=#{$dumpId}-ref2%d title="3 occurrences">#%d</a>}
  </samp>]
  "<span class=sf-dump-key>recurs</span>" => <a class=sf-dump-ref href=#{$dumpId}-ref04 title="2 occurrences">&amp;4</a> <span class=sf-dump-note>array:1</span> [<samp id={$dumpId}-ref04>
    <span class=sf-dump-index>0</span> => <a class=sf-dump-ref href=#{$dumpId}-ref04 title="2 occurrences">&amp;4</a> <span class=sf-dump-note>array:1</span> [<a class=sf-dump-ref href=#{$dumpId}-ref04 title="2 occurrences">&amp;4</a>]
  </samp>]
  <span class=sf-dump-key>8</span> => <a class=sf-dump-ref href=#{$dumpId}-ref01 title="2 occurrences">&amp;1</a> <span class=sf-dump-const>null</span>
  "<span class=sf-dump-key>sobj</span>" => <abbr title="Symfony\Component\VarDumper\Tests\Fixture\DumbFoo" class=sf-dump-note>DumbFoo</abbr> {<a class=sf-dump-ref href=#{$dumpId}-ref2%d title="2 occurrences">#%d</a>}
  "<span class=sf-dump-key>snobj</span>" => <a class=sf-dump-ref href=#{$dumpId}-ref03 title="2 occurrences">&amp;3</a> {<a class=sf-dump-ref href=#{$dumpId}-ref2%d title="3 occurrences">#%d</a>}
  "<span class=sf-dump-key>snobj2</span>" => {<a class=sf-dump-ref href=#{$dumpId}-ref2%d title="3 occurrences">#%d</a>}
  "<span class=sf-dump-key>file</span>" => "<span class=sf-dump-str title="%d characters">{$var['file']}</span>"
  b"<span class=sf-dump-key>bin-key-&%s;</span>" => ""
</samp>]
</bar>

EOTXT
            ,

            $out
        );
    }

    public function testCharset()
    {
        $var = mb_convert_encoding('Словарь', 'CP1251', 'UTF-8');

        $dumper = new HtmlDumper('php://output', 'CP1251');
        $dumper->setDumpHeader('<foo></foo>');
        $dumper->setDumpBoundaries('<bar>', '</bar>');
        