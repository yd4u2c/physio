0
            </time>
        </div>
        <div class="row">
    <ul class="tags">
        <li><span class="badge">project dir</span>src/Symfony/</li>
    </ul>
</div>
    </header>
    <section class="body">
        <p class="text-small">
            <a href="phpstorm://open?file=/Users/ogi/symfony/src/Symfony/Component/VarDumper/Tests/Command/Descriptor/CliDescriptorTest.php&line=30">CliDescriptorTest.php on line 30</a>
        </p>
        [DUMPED]
    </section>
</article>
TXT
        ];

        yield 'cli' => [
            [
                'cli' => [
                    'identifier' => 'd8bece1c',
                    'command_line' => 'bin/phpunit',
                ],
            ],
            <<<TXT
<article data-dedup-id="d8bece1c">
    <header>
        <div class="row">
            <h2 class="col"><code>$ </code>bin/phpunit</h2>
            <time class="col text-small" title="2018-12-14T16:17:48+00:00" datetime="2018-12-14T16:17:48+00:00">
                Fri, 14 Dec 2018 16:17:48 +0000
            </time>
        </div>
        
    </header>
    <section class="body">
        <p class="text-small">
            
        </p>
        [DUMPED]
    </section>
</article>
TXT
        ];

        yield 'request' => [
            [
                'request' => [
                    'identifier' => 'd8bece1c',
                    'controller' => new Data([['FooController.php']]),
                    'method' => 'GET',
                    'uri' => 'http://localhost/foo',
                ],
            ],
            <<<TXT
<article data-dedup-id="d8bece1c">
    <header>
        <div class="row">
            <h2 class="col"><code>GET</code> <a href="http://localhost/foo">http://localhost/foo</a></h2>
            <time class="col text-small" title="2018-12-14T16:17:48+00:00" datetime="2018-12-14T16:17:48+00:00">
                Fri, 14 Dec 2018 16:17:48 +0000
            </time>
        </div>
        <div class="row">
    <ul class="tags">
        <li><span class="badge">controller</span><span class='dumped-tag'>[DUMPED]</span></li>
    </ul>
</div>
    </header>
    <section class="body">
        <p class="text-small">
            
        </p>
        [DUMPED]
    </section>
</article>
TXT
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

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
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CliDumperTest extends TestCase
{
    use VarDumperTestTrait;

    public function testGet()
    {
        require __DIR__.'/../Fixtures/dumb-var.php';

        $dumper = new CliDumper('php://output');
        $dumper->setColors(false);
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
        $intMax = PHP_INT_MAX;
        $res = (int) $var['res'];

        $this->assertStringMatchesFormat(
            <<<EOTXT
array:24 [
  "number" => 1
  0 => &1 null
  "const" => 1.1
  1 => true
  2 => false
  3 => NAN
  4 => INF
  5 => -INF
  6 => {$intMax}
  "str" => "déjà\\n"
  7 => b"""
    é\\x00test\\t\\n
    ing
    """
  "[]" => []
  "res" => stream resource {@{$res}
%A  wrapper_type: "plainfile"
    stream_type: "STDIO"
    mode: "r"
    unread_bytes: 0
    seekable: true
%A  options: []
  }
  "obj" => Symfony\Component\VarDumper\Tests\Fixture\DumbFoo {#%d
    +foo: "foo"
    +"bar": "bar"
  }
  "closure" => Closure(\$a, PDO &\$b = null) {#%d
    class: "Symfony\Component\VarDumper\Tests\Dumper\CliDumperTest"
    this: Symfony\Component\VarDumper\Tests\Dumper\CliDumperTest {#%d …}
    parameters: {
      \$a: {}
      &\$b: {
        typeHint: "PDO"
        default: null
      }
    }
    file: "%s%eTests%eFixtures%edumb-var.php"
    line: "{$var['line']} to {$var['line']}"
  }
  "line" => {$var['line']}
  "nobj" => array:1 [
    0 => &3 {#%d}
  ]
  "recurs" => &4 array:1 [
    0 => &4 array:1 [&4]
  ]
  8 => &1 null
  "sobj" => Symfony\Component\VarDumper\Tests\Fixture\DumbFoo {#%d}
  "snobj" => &3 {