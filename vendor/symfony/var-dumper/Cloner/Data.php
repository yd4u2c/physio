xtension_loaded('xdebug')) {
            $this->markTestSkipped('xdebug is active');
        }

        $generator = new GeneratorDemo();
        $generator = $generator->baz();

        $expectedDump = <<<'EODUMP'
Generator {
  this: Symfony\Component\VarDumper\Tests\Fixtures\GeneratorDemo { …}
  executing: {
    Symfony\Component\VarDumper\Tests\Fixtures\GeneratorDemo->baz() {
      %sGeneratorDemo.php:14 {
        › {
        ›     yield from bar();
        › }
      }
    }
  }
  closed: false
}
EODUMP;

        $this->assertDumpMatchesFormat($expectedDump, $generator);

        foreach ($generator as $v) {
            break;
        }

        $expectedDump = <<<'EODUMP'
array:2 [
  0 => ReflectionGenerator {
    this: Symfony\Component\VarDumper\Tests\Fixtures\GeneratorDemo { …}
    trace: {
      %s%eTests%eFixtures%eGeneratorDemo.php:9 {
        › {
        ›     yield 1;
        › }
      }
      %s%eTests%eFixtures%eGeneratorDemo.php:20 { …}
      %s%eTests%eFixtures%eGeneratorDemo.php:14 { …}
    }
    closed: false
  }
  1 => Generator {
    executing: {
      Symfony\Component\VarDumper\Tests\Fixtures\GeneratorDemo::foo() {
        %sGeneratorDemo.php:10 {
          ›     yield 1;
          › }
          › 
        }
      }
    }
    closed: false
  }
]
EODUMP;

        $r = new \ReflectionGenerator($generator);
        $this->assertDumpMatchesFormat($expectedDump, [$r, $r->getExecutingGenerator()]);

        foreach ($generator as $v) {
        }

        $expectedDump = <<<'EODUMP'
Generator {
  closed: true
}
EODUMP;
        $this->assertDumpMatchesFormat($expectedDump, $generator);
    }
}

function reflectionParameterFixture(NotLoadableClass $arg1 = null, $arg2)
{
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Tests\Caster;

use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

/**
 * @author Grégoire Pineau <lyrixx@lyrixx.info>
 */
class SplCasterTest extends TestCase
{
    use VarDumperTestTrait;

    public function getCastFileInfoTests()
    {
        return [
            [__FILE__, <<<'EOTXT'
SplFileInfo {
%Apath: "%sCaster"
  filename: "SplCasterTest.php"
  basename: "SplCasterTest.php"
  pathname: "%sSplCasterTest.php"
  extension: "php"
  realPath: "%sSplCasterTest.php"
  aTime: %s-%s-%d %d:%d:%d
  mTime: %s-%s-%d %d:%d:%d
  cTime: %s-%s-%d %d:%d:%d
  inode: %i
  size: %d
  perms: 0%d
  owner: %d
  group: %d
  type: "file"
  writable: true
  readable: true
  executable: false
  file: true
  dir: false
  link: false
%A}
EOTXT
            ],
            ['https://google.com/about', <<<'EOTXT'
SplFileInfo {
%Apath: "https://google.com"
  filename: "about"
  basename: "about"
  pathname: "https://google.com/about"
  extension: ""
  realPath: false
%A}
EOTXT
            ],
        ];
    }

    /** @dataProvider getCastFileInfoTests */
    public function testCastFileInfo($file, $dump)
    {
        $this->assertDumpMatchesFormat($dump, new \SplFileInfo($file));
    }

    public function testCastFileObject()
    {
        $var = new \SplFileObject(__FILE__);
        $var->setFlags(\SplFileObject::DROP_NEW_LINE | \SplFileObject::SKIP_EMPTY);
        $dump = <<<'EOTXT'
SplFileObject {
%Apath: "%sCaster"
  filename: "SplCasterTest.php"
  basename: "SplCasterTest.php"
  pathname: "%sSplCasterTest.php"
  extension: "php"
  realPath: "%sSplCasterTest.php"
  aTime: %s-%s-%d %d:%d:%d
  mTime: %s-%s-%d %d:%d:%d
  cTime: %s-%s-%d %d:%d:%d
  inode: %i
  size: %d
  perms: 0%d
  owner: %d
  group: %d
  type: "file"
  writable: true
  readable: true
  executable: false
  file: true
  dir: false
  link: false
%AcsvControl: array:%d [
    0 => ","
    1 => """
%A]
  flags: DROP_NEW_LINE|SKIP_EMPTY
  maxLineLen: 0
  fstat: array:26 [
    "dev" => %d
    "ino" => %i
    "nlink" => %d
    "rdev" => 0
    "blksize" => %i
    "blocks" => %i
     …20
  ]
  eof: false
  key: 0
}
EOTXT;
        $this->assertDumpMatchesFormat($dump, $var);
    }

    /**
     * @dataProvider provideCastSplDoublyLinkedList
     */
    public function testCastSplDoublyLinkedList($modeValue, $modeDump)
    {
        $var = new \SplDoublyLinkedList();
        $var->setIteratorMode($modeValue);
        $dump = <<<EOTXT
SplDoublyLinkedList {
%Amode: $modeDump
  dllist: []
}
EOTXT;
        $this->assertDumpMatchesFormat($dump, $var);
    }

    public function provideCastSplDoublyLinkedList()
    {
        return [
            [\SplDoublyLinkedList::IT_MODE_FIFO, 'IT_MODE_FIFO | IT_MODE_KEEP'],
            [\SplDoublyLinkedList::IT_MODE_LIFO, 'IT_MODE_LIFO | IT_MODE_KEEP'],
            [\SplDoublyLinkedList::IT_MODE_FIFO | \SplDoublyLinkedList::IT_MODE_DELETE, 'IT_MODE_FIFO | IT_MODE_DELETE'],
            [\SplDoublyLinkedList::IT_MODE_LIFO | \SplDoublyLinkedList::IT_MODE_DELETE, 'IT_MODE_LIFO | IT_MODE_DELETE'],
        ];
    }

    public function testCastObjectStorageIsntModified()
    {
        $var = new \SplObjectStorage();
        $var->attach(new \stdClass());
        $var->rewind();
        $current = $var->current();

        $this->assertDumpMatchesFormat('%A', $var);
        $this->assertSame($current, $var->current());
    }

    public function testCastObjectStorageDumpsInfo()
    {
        $var = new \SplObjectStorage();
        $var->attach(new \stdClass(), new \DateTime());

        $this->assertDumpMatchesFormat('%ADateTime%A', $var);
    }

    public function testCastArrayObject()
    {
        $var = new \ArrayObject([123]);
        $var->foo = 234;

        $expected = <<<EOTXT
ArrayObject {
  +"foo": 234
  flag::STD_PROP_LIST: false
  flag::ARRAY_AS_PROPS: false
  iteratorClass: "ArrayIterator"
  storage: array:1 [
    0 => 123
  ]
}
EOTXT;
        $this->assertDumpEquals($expected, $var);
    }

    public function testArrayIterator()
    {
        $var = new MyArrayIterator([234]);

        $expected = <<<EOTXT
Symfony\Component\VarDumper\Tests\Caster\MyArrayIterator {
  -foo: 123
  flag::STD_PROP_LIST: false
  flag::ARRAY_AS_PROPS: false
  storage: array:1 [
    0 => 234
  ]
}
EOTXT;
        $this->assertDumpEquals($expected, $var);
    }
}

class MyArrayIterator extends \ArrayIterator
{
    private $foo = 123;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Tests\Caster;

use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Caster\ArgsStub;
use Symfony\Component\VarDumper\Caster\ClassStub;
use Symfony\Component\VarDumper\Caster\LinkStub;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;
use Symfony\Component\VarDumper\Tests\Fixtures\FooInterface;

class StubCasterTest extends TestCase
{
    use VarDumperTestTrait;

    public function testArgsStubWithDefaults($foo = 234, $bar = 456)
    {
        $args = [new ArgsStub([123], __FUNCTION__, __CLASS__)];

        $expectedDump = <<<'EODUMP'
array:1 [
  0 => {
    $foo: 123
  }
]
EODUMP;

        $this->assertDumpMatchesFormat($expectedDump, $args);
    }

    public function testArgsStubWithExtraArgs($foo = 234)
    {
        $args = [new ArgsStub([123, 456], __FUNCTION__, __CLASS__)];

        $expectedDump = <<<'EODUMP'
array:1 [
  0 => {
    $foo: 123
    ...: {
      456
    }
  }
]
EODUMP;

        