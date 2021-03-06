<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\Helper;

class HelperTest extends TestCase
{
    public function formatTimeProvider()
    {
        return [
            [0,      '< 1 sec'],
            [1,      '1 sec'],
            [2,      '2 secs'],
            [59,     '59 secs'],
            [60,     '1 min'],
            [61,     '1 min'],
            [119,    '1 min'],
            [120,    '2 mins'],
            [121,    '2 mins'],
            [3599,   '59 mins'],
            [3600,   '1 hr'],
            [7199,   '1 hr'],
            [7200,   '2 hrs'],
            [7201,   '2 hrs'],
            [86399,  '23 hrs'],
            [86400,  '1 day'],
            [86401,  '1 day'],
            [172799, '1 day'],
            [172800, '2 days'],
            [172801, '2 days'],
        ];
    }

    /**
     * @dataProvider formatTimeProvider
     *
     * @param int    $secs
     * @param string $expectedFormat
     */
    public function testFormatTime($secs, $expectedFormat)
    {
        $this->assertEquals($expectedFormat, Helper::formatTime($secs));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Console\Tests\Helper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\ProcessHelper;
use Symfony\Component\Console\Output\StreamOutput;
use Symfony\Component\Process\Process;

class ProcessHelperTest extends TestCase
{
    /**
     * @dataProvider provideCommandsAndOutput
     */
    public function testVariousProcessRuns($expected, $cmd, $verbosity, $error)
    {
        if (\is_string($cmd)) {
            $cmd = \method_exists(Process::class, 'fromShellCommandline') ? Process::fromShellCommandline($cmd) : new Process($cmd);
        }

        $helper = new ProcessHelper();
        $helper->setHelperSet(new HelperSet([new DebugFormatterHelper()]));
        $output = $this->getOutputStream($verbosity);
        $helper->run($output, $cmd, $error);
        $this->assertEquals($expected, $this->getOutput($output));
    }

    public function testPassedCallbackIsExecuted()
    {
        $helper = new ProcessHelper();
        $helper->setHelperSet(new HelperSet([new DebugFormatterHelper()]));
        $output = $this->getOutputStream(StreamOutput::VERBOSITY_NORMAL);

        $executed = false;
        $callback = function () use (&$executed) { $executed = true; };

        $helper->run($output, ['php', '-r', 'echo 42;'], null, $callback);
        $this->assertTrue($executed);
    }

    public function provideCommandsAndOutput()
    {
        $successOutputVerbose = <<<'EOT'
  RUN  php -r "echo 42;"
  RES  Command ran successfully

EOT;
        $successOutputDebug = <<<'EOT'
  RUN  php -r "echo 42;"
  OUT  42
  RES  Command ran successfully

EOT;
        $successOutputDebugWithTags = <<<'EOT'
  RUN  php -r "echo '<info>42</info>';"
  OUT  <info>42</info>
  RES  Command ran successfully

EOT;
        $successOutputProcessDebug = <<<'EOT'
  RUN  'php' '-r' 'echo 42;'
  OUT  42
  RES  Command ran successfully

EOT;
        $syntaxErrorOutputVerbose = <<<'EOT'
  RUN  php -r "fwrite(STDERR, 'error message');usleep(50000);fwrite(STDOUT, 'out message');exit(252);"
  RES  252 Command did not run successfully

EOT;
        $syntaxErrorOutputDebug = <<<'EOT'
  RUN  php -r "fwrite(STDERR, 'error message');usleep(500000);fwrite(STDOUT, 'out message');exit(252);"
  ERR  error message
  OUT  out message
  RES  252 Command did not run successfully

EOT;

        $P