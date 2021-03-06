<?php

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
use Symfony\Component\VarDumper\Caster\Caster;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CasterTest extends TestCase
{
    use VarDumperTestTrait;

    private $referenceArray = [
        'null' => null,
        'empty' => false,
        'public' => 'pub',
        "\0~\0virtual" => 'virt',
        "\0+\0dynamic" => 'dyn',
        "\0*\0protected" => 'prot',
        "\0Foo\0private" => 'priv',
    ];

    /**
     * @dataProvider provideFilter
     */
    public function testFilter($filter, $expectedDiff, $listedProperties = null)
    {
        if (null === $listedProperties) {
            $filteredArray = Caster::filter($this->referenceArray, $filter);
        } else {
            $filteredArray = Caster::filter($this->referenceArray, $filter, $listedProperties);
        }

        $this->assertSame($expectedDiff, array_diff_assoc($this->referenceArray, $filteredArray));
    }

    public function provideFilter()
    {
        return [
            [
                0,
                [],
            ],
            [
                Caster::EXCLUDE_PUBLIC,
                [
                    'null' => null,
                    'empty' => false,
                    'public' => 'pub',
                ],
            ],
            [
                Caster::EXCLUDE_NULL,
                [
                    'null' => null,
                ],
            ],
            [
                Caster::EXCLUDE_EMPTY,
                [
                    'null' => null,
                    'empty' => false,
                ],
            ],
            [
                Caster::EXCLUDE_VIRTUAL,
                [
                    "\0~\0virtual" => 'virt',
                ],
            ],
            [
                Caster::EXCLUDE_DYNAMIC,
                [
                    "\0+\0dynamic" => 'dyn',
                ],
            ],
            [
                Caster::EXCLUDE_PROTECTED,
                [
                    "\0*\0protected" => 'prot',
                ],
            ],
            [
                Caster::EXCLUDE_PRIVATE,
                [
                    "\0Foo\0private" => 'priv',
                ],
            ],
            [
                Caster::EXCLUDE_VERBOSE,
                [
                    'public' => 'pub',
                    "\0*\0protected" => 'prot',
                ],
                ['public', "\0*\0protected"],
            ],
            [
                Caster::EXCLUDE_NOT_IMPORTANT,
                [
                    'null' => null,
                    'empty' => false,
                    "\0~\0virtual" => 'virt',
                    "\0+\0dynamic" => 'dyn',
                    "\0Foo\0private" => 'priv',
                ],
                ['public', "\0*\0protected"],
            ],
            [
                Caster::EXCLUDE_VIRTUAL | Caster::EXCLUDE_DYNAMIC,
                [
                    "\0~\0virtual" => 'virt',
                    "\0+\0dynamic" => 'dyn',
                ],
            ],
            [
                Caster::EXCLUDE_NOT_IMPORTANT | Caster::EXCLUDE_VERBOSE,
                $this->referenceArray,
                ['public', "\0*\0protected"],
            ],
            [
                Caster::EXCLUDE_NOT_IMPORTANT | Caster::EXCLUDE_EMPTY,
                [
                    'null' => null,
                    'empty' => false,
                    "\0~\0virtual" => 'virt',
                    "\0+\0dynamic" => 'dyn',
                    "\0*\0protected" => 'prot',
                    "\0Foo\0private" => 'priv',
                ],
                ['public', 'empty'],
            ],
            [
                Caster::EXCLUDE_VERBOSE | Caster::EXCLUDE_EMPTY | Caster::EXCLUDE_STRICT,
                [
                    'empty' => false,
                ],
                ['public', 'empty'],
            ],
        ];
    }

    public function testAnonymousClass()
    {
        $c = eval('return new class extends stdClass { private $foo = "foo"; };');

        $this->assertDumpMatchesFormat(
            <<<'EOTXT'
stdClass@anonymous {
  -foo: "foo"
}
EOTXT
            , $c
        );

        $c = eval('return new class { private $foo = "foo"; };');

        $this->assertDumpMatchesFormat(
            <<<'EOTXT'
@anonymous {
  -foo: "foo"
}
EOTXT
            , $c
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

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
use Symfony\Component\VarDumper\Caster\Caster;
use Symfony\Component\VarDumper\Caster\DateCaster;
use Symfony\Component\VarDumper\Cloner\Stub;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

/**
 * @author Dany Maillard <danymaillard93b@gmail.com>
 */
class DateCasterTest extends TestCase
{
    use VarDumperTestTrait;

    /**
     * @dataProvider provideDateTimes
     */
    public function testDumpDateTime($time, $timezone, $xDate, $xTimestamp)
    {
        $date = new \DateTime($time, new \DateTimeZone($timezone));

        $xDump = <<<EODUMP
DateTime @$xTimestamp {
  date: $xDate
}
EODUMP;

        $this->assertDumpEquals($xDump, $date);
    }

    /**
     * @dataProvider provideDateTimes
     */
    public function testCastDateTime($time, $timezone, $xDate, $xTimestamp, $xInfos)
    {
        $stub = new Stub();
        $date = new \DateTime($time, new \DateTimeZone($timezone));
        $cast = DateCaster::castDateTime($date, ['foo' => 'bar'], $stub, false, 0);

        $xDump = <<<EODUMP
array:1 [
  "\\x00~\\x00date" => $xDate
]
EODUMP;

        $this->assertDumpEquals($xDump, $cast);

        $xDump = <<<EODUMP
Symfony\Component\VarDumper\Caster\ConstStub {
  +type: 1
  +class: "$xDate"
  +value: "%A$xInfos%A"
  +cut: 0
  +handle: 0
  +refCount: 0
  +position: 0
  +attr: []
}
EODUMP;

        $this->assertDumpMatchesFormat($xDump, $cast["\0~\0date"]);
    }

    public function provideDateTimes()
    {
        return [
            ['2017-04-30 00:00:00.000000', 'Europe/Zurich', '2017-04-30 00:00:00.0 Europe/Zurich (+02:00)', 1493503200, 'Sunday, April 30, 2017%Afrom now%ADST On'],
            ['2017-12-31 00:00:00.000000', 'Europe/Zurich', '2017-12-31 00:00:00.0 Europe/Zurich (+01:00)', 1514674800, 'Sunday, December 31, 2017%Afrom now%ADST Off'],
            ['2017-04-30 00:00:00.000000', '+02:00', '2017-04-30 00:00:00.0 +02:00', 1493503200, 'Sunday, April 30, 2017%Afrom now'],

            ['2017-04-30 00:00:00.100000', '+00:00', '2017-04-30 00:00:00.100 +00:00', 1493510400, 'Sunday, April 30, 2017%Afrom now'],
            ['2017-04-30 00:00:00.120000', '+00:00', '2017-04-30 00:00:00.120 +00:00', 1493510400, 'Sunday, April 30, 2017%Afrom now'],
            ['2017-04-30 00:00:00.123000', '+00:00', '2017-04-30 00:00:00.123 +00:00', 1493510400, 'Sunday, April 30, 2017%Afrom now'],
            ['2017-04-30 00:00:00.123400', '+00:00', '2017-04-30 00:00:00.123400 +00:00', 1493510400, 'Sunday, April 30, 2017%Afrom now'],
            ['2017-04-30 00:00:00.123450', '+00:00', '2017-04-30 00:00:00.123450 +00:00', 1493510400, 'Sunday, April 30, 2017%Afrom now'],
            ['2017-04-30 00:00:00.123456', '+00:00', '2017-04-30 00:00:00.123456 +00:00', 1493510400, 'Sunday, April 30, 2017%Afrom now'],
        ];
    }

    /**
     * @dataProvider provideIntervals
     */
    public function testDumpInterval($intervalSpec, $ms, $invert, $expected)
    {
        if ($ms && \PHP_VERSION_ID >= 70200 && version_compare(PHP_VERSION, '7.2.0rc3', '<=')) {
            $this->markTestSkipped('Skipped on 7.2 before rc4 because of php bug #75354.');
        }

        $interval = $this->createInterval($intervalSpec, $ms, $invert);

        $xDump = <<<EODUMP
DateInterval {
  interval: $expected
%A}
EODUMP;

        $this->assertDumpMatchesFormat($xDump, $interval);
    }

    /**
     * @dataProvider provideIntervals
     */
    public function testDumpIntervalExcludingVerbosity($intervalSpec, $ms, $invert, $expected)
    {
        if ($ms && \PHP_VERSION_ID >= 70200 && version_compare(PHP_VERSION, '7.2.0rc3', '<=')) {
            $this->markTestSkipped('Skipped on 7.2 before rc4 because of php bug #75354.');
        }

        $interval = $this->createInterval($intervalSpec, $ms, $invert);

        $xDump = <<<EODUMP
DateInterval {
  interval: $expected
}
EODUMP;

        $this->assertDumpEquals($xDump, $interval, Caster::EXCLUDE_VERBOSE);
    }

    /**
     * @dataProvider provideIntervals
     */
    public function testCastInterval($intervalSpec, $ms, $invert, $xInterval, $xSeconds)
    {
        if ($ms && \PHP_VERSION_ID >= 70200 && version_compare(PHP_VERSION, '7.2.0rc3', '<=')) {
            $this->markTestSkipped('Skipped on 7.2 before rc4 because of php bug #75354.');
     