_reader.xml"
   …9
}
EODUMP
            ],
            [22, <<<'EODUMP'
XMLReader {
  +localName: "foo"
  +nodeType: END_ELEMENT
  +baseURI: "%sxml_reader.xml"
   …11
}
EODUMP
            ],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Tests\Cloner;

use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Caster\Caster;
use Symfony\Component\VarDumper\Caster\ClassStub;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Cloner\VarCloner;

class DataTest extends TestCase
{
    public function testBasicData()
    {
        $values = [1 => 123, 4.5, 'abc', null, false];
        $data = $this->cloneVar($values);
        $clonedValues = [];

        $this->assertInstanceOf(Data::class, $data);
        $this->assertCount(\count($values), $data);
        $this->assertFalse(isset($data->{0}));
        $this->assertFalse(isset($data[0]));

        foreach ($data as $k => $v) {
            $this->assertTrue(isset($data->{$k}));
            $this->assertTrue(isset($data[$k]));
            $this->assertSame(\gettype($values[$k]), $data->seek($k)->getType());
            $this->assertSame($values[$k], $data->seek($k)->getValue());
            $this->assertSame($values[$k], $data->{$k});
            $this->assertSame($values[$k], $data[$k]);
            $this->assertSame((string) $values[$k], (string) $data->seek($k));

            $clonedValues[$k] = $v->getValue();
        }

        $this->assertSame($values, $clonedValues);
    }

    public function testObject()
    {
        $data = $this->cloneVar(new \Exception('foo'));

        $this->assertSame('Exception', $data->getType());

        $this->assertSame('foo', $data->message);
        $this->assertSame('foo', $data->{Caster::PREFIX_PROTECTED.'message'});

        $this->assertSame('foo', $data['message']);
        $this->assertSame('foo', $data[Caster::PREFIX_PROTECTED.'message']);

        $this->assertStringMatchesFormat('Exception (count=%d)', (string) $data);
    }

    public function testArray()
    {
        $values = [[], [123]];
        $data = $this->cloneVar($values);

        $this->assertSame($values, $data->getValue(true));

        $children = $data->getValue();

        $this->assertInternalType('array', $children);

        $this->assertInstanceOf(Data::class, $children[0]);
        $this->assertInstanceOf(Data::class, $children[1]);

        $this->assertEquals($children[0], $data[0]);
        $this->assertEquals($children[1], $data[1]);

        $this->assertSame($values[0], $children[0]->getValue(true));
        $this->assertSame($values[1], $children[1]->getValue(true));
    }

    public function testStub()
    {
        $data = $this->cloneVar([new ClassStub('stdClass')]);
        $data = $data[0];

        $this->assertSame('string', $data->getType());
        $this->assertSame('stdClass', $data->getValue());
        $this->assertSame('stdClass', (string) $data);
    }

    public function testHardRefs()
    {
        $values = [[]];
        $values[1] = &$values[0];
        $values[2][0] = &$values[2];

        $data = $this->cloneVar($values);

        $this->assertSame([], $data[0]->getValue());
        $this->assertSame([], $data[1]->getValue());
        $this->assertEquals([$data[2]->getValue()], $data[2]->getValue(true));

        $this->assertSame('array (count=3)', (string) $data);
    }

    private function cloneVar($value)
    {
        $cloner = new VarCloner();

        return $cloner->cloneVar($value);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Tests\Cloner;

use PHPUnit\Framework\TestCase;
use Symfony\Component\VarDumper\Cloner\VarCloner;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class VarClonerTest extends TestCase
{
    public function testMaxIntBoundary()
    {
        $data = [PHP_INT_MAX => 123];

        $cloner = new VarCloner();
        $clone = $cloner->cloneVar($data);

        $expected = <<<EOTXT
Symfony\Component\VarDumper\Cloner\Data Object
(
    [data:Symfony\Component\VarDumper\Cloner\Data:private] => Array
        (
            [0] => Array
                (
                    [0] => Array
                        (
                            [1] => 1
                        )

                )

            [1] => Array
                (
                    [%s] => 123
                )

        )

    [position:Symfony\Component\VarDumper\Cloner\Data:private] => 0
    [key:Symfony\Component\VarDumper\Cloner\Data:private] => 0
    [maxDepth:Symfony\Component\VarDumper\Cloner\Data:private] => 20
    [maxItemsPerDepth:Symfony\Component\VarDumper\Cloner\Data:private] => -1
    [useRefHandles:Symfony\Component\VarDumper\Cloner\Data:private] => -1
)

EOTXT;
        $this->assertSame(sprintf($expected, PHP_INT_MAX), print_r($clone, true));
    }

    public function testClone()
    {
        $json = json_decode('{"1":{"var":"val"},"2":{"var":"val"}}');

        $cloner = new VarCloner();
        $clone = $cloner->cloneVar($json);

        $expected = <<<EOTXT
Symfony\Component\VarDumper\Cloner\Data Object
(
    [data:Symfony\Component\VarDumper\Cloner\Data:private] => Array
        (
            [0] => Array
                (
                    [0] => Symfony\Component\VarDumper\Cloner\Stub Object
                        (
                            [type] => 4
                            [class] => stdClass
                            [value] => 
                            [cut] => 0
                            [handle] => %i
                            [refCount] => 0
                            [position] => 1
                            [attr] => Array
                                (
                                )

                        )

                )

            [1] => Array
                (
                    [\000+\0001] => Symfony\Component\VarDumper\Cloner\Stub Object
                        (
                            [type] => 4
                            [class] => stdClass
                            [value] => 
                            [cut] => 0
                            [handle] => %i
                            [refCount] => 0
                            [position] => 2
                            [attr] => Array
                                (
                                )

                        )

                    [\000+\0002] => Symfony\Component\VarDumper\Cloner\Stub Object
                        (
                            [type] => 4
                            [class] => stdClass
                            [value] => 
                            [cut] => 0
                            [handle] => %i
                            [refCount] => 0
                            [position] => 3
                            [attr] => Array
                                (
                                )

                        )

                )

            [2] => Array
                (
                    [\000+\000var] => val
                )

            [3] => Array
                (
                    [\000+\000var] => val
                )

        )

    [position:Symfony\Component\VarDumper\Cloner\Data:private] => 0
    [key:Symfony\Component\VarDumper\Cloner\Data:private] => 0
    [maxDepth:Symfony\Component\VarDumper\Cloner\Data:private] => 20
    [maxItemsPerDepth:Symfony\Component\VarDumper\Cloner\Data:private] => -1
    [useRefHandles:Symfony\Component\VarDumper\Cloner\Data:private] => -1
)

EOTXT;
        $this->assertStringMatchesFormat($expected, print_r($clone, true));
    }

    public function testLimits()
    {
        // Level 0:
        $data = [
            // Level 1:
            [
                // Level 2:
                [
                    // Level 3:
                    'Level 3 Item 0',
                    'Level 3 Item 1',
                    'Level 3 Item 2',
                    'Level 3 Item 3',
                ],
                [
                    'Level 3 Item 4',
    