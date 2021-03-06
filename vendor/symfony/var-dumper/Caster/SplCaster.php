time/s', '1) 2017-01-01 00:00:00.0%a2) 2017-01-02 01:00:00.0'],

            ['2017-01-01', 'P1D', '2017-01-04', \DatePeriod::EXCLUDE_START_DATE, 'every + 1d, from 2017-01-01 00:00:00.0 (excluded) to 2017-01-04 00:00:00.0', '1) 2017-01-02%a2) 2017-01-03'],
            ['2017-01-01', 'P1D', 2, \DatePeriod::EXCLUDE_START_DATE, 'every + 1d, from 2017-01-01 00:00:00.0 (excluded) recurring 2 time/s', '1) 2017-01-02%a2) 2017-01-03'],
        ];

        if (\PHP_VERSION_ID < 70107) {
            array_walk($periods, function (&$i) { $i[5] = ''; });
        }

        return $periods;
    }

    private function createInterval($intervalSpec, $ms, $invert)
    {
        $interval = new \DateInterval($intervalSpec);
        $interval->f = $ms;
        $interval->invert = $invert;

        return $interval;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

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
use Symfony\Component\VarDumper\Caster\ExceptionCaster;
use Symfony\Component\VarDumper\Caster\FrameStub;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Test\VarDumperTestTrait;

class ExceptionCasterTest extends TestCase
{
    use VarDumperTestTrait;

    private function getTestException($msg, &$ref = null)
    {
        return new \Exception(''.$msg);
    }

    protected function tearDown()
    {
        ExceptionCaster::$srcContext = 1;
        ExceptionCaster::$traceArgs = true;
    }

    public function testDefaultSettings()
    {
        $ref = ['foo'];
        $e = $this->getTestException('foo', $ref);

        $expectedDump = <<<'EODUMP'
Exception {
  #message: "foo"
  #code: 0
  #file: "%sExceptionCasterTest.php"
  #line: 28
  trace: {
    %s%eTests%eCaster%eExceptionCasterTest.php:28 {
      › {
      ›     return new \Exception(''.$msg);
      › }
    }
    %s%eTests%eCaster%eExceptionCasterTest.php:40 { …}
    Symfony\Component\VarDumper\Tests\Caster\ExceptionCasterTest->testDefaultSettings() {}
%A
EODUMP;

        $this->assertDumpMatchesFormat($expectedDump, $e);
        $this->assertSame(['foo'], $ref);
    }

    public function testSeek()
    {
        $e = $this->getTestException(2);

        $expectedDump = <<<'EODUMP'
{
  %s%eTests%eCaster%eExceptionCasterTest.php:28 {
    › {
    ›     return new \Exception(''.$msg);
    › }
  }
  %s%eTests%eCaster%eExceptionCasterTest.php:65 { …}
  Symfony\Component\VarDumper\Tests\Caster\ExceptionCasterTest->testSeek() {}
%A
EODUMP;

        $this->assertStringMatchesFormat($expectedDump, $this->getDump($e, 'trace'));
    }

    public function testNoArgs()
    {
        $e = $this->getTestException(1);
        ExceptionCaster::$traceArgs = false;

        $expectedDump = <<<'EODUMP'
Exception {
  #message: "1"
  #code: 0
  #file: "%sExceptionCasterTest.php"
  #line: 28
  trace: {
    %sExceptionCasterTest.php:28 {
      › {
      ›     return new \Exception(''.$msg);
      › }
    }
    %s%eTests%eCaster%eExceptionCasterTest.php:84 { …}
    Symfony\Component