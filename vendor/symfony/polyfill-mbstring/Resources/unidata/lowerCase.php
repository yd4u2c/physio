INDX( 	 n֫             (   p  �       �p                   �1     � t     �1     q��qk�PT4� %�PT4� %�q��qk�       �               E r r o r P r o c e s s I n i t i a t o r . p h p     �1     � r     �1     ���qk� �Cb���;�z��<����qk�                       E x e c u t a b l e F i n d e r T e s t . p h p       �1     � |     �1     R}�qk� �Cb����D}��<�R}�qk�                       K i l l a b l e P r o c e s s W i t h O u t p u t . p h p     �1     � n     �1     ���qk  �Cb������<����qk�       %               N o n S t o p a b l e P r o c e s s . p h p   �1     � x     �1     	B�qk� �Cb������<�	B�qk�       <               P h p E x e c u t a b l e F i n d e r T e s t . p h p �1     x f     �1     ��qk� �Cb���L
���<���qk�       �               P h p P r o c e s s T e s t . p h p   �1     � �     �1     �i�qk� �Cb����k���<��i�qk�       �              ' P i p e S t d i n I n S t d o u t S t d E r r S t r e a m S e l e c t . p h  �1     � ~     �1     � qk� �Cb���	φ��<�� qk�        �               P r o c e s s F a i l e d E x c e p t i o n T e s t . p h p   �1     p `     �1     �|qk� �Cb���	φ��<��|qk� �      Ʒ               P r o c e s s T e s t . p h p �1     x f     �1     �qk� �Cb����0���<��qk��      �               S i g n a l L i s t e n e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\PhpProcess;

class PhpProcessTest extends TestCase
{
    public function testNonBlockingWorks()
    {
        $expected = 'hello world!';
        $process = new PhpProcess(<<<PHP
<?php echo '$expected';
PHP
        );
        $process->start();
        $process->wait();
        $this->assertEquals($expected, $process->getOutput());
    }

    public function testCommandLine()
    {
        $process = new PhpProcess(<<<'PHP'
<?php echo phpversion().PHP_SAPI;
PHP
        );

        $commandLine = $process->getCommandLine();

        $process->start();
        $this->assertContains($commandLine, $process->getCommandLine(), '::getCommandLine() returns the command line of PHP after start');

        $process->wait();
        $this->assertContains($commandLine, $process->getCommandLine(), '::getCommandLine() returns the command line of PHP after wait');

        $this->assertSame(PHP_VERSION.\PHP_SAPI, $process->getOutput());
    }

    public function testPassingPhpExplicitly()
    {
        $finder = new PhpExecutableFinder();
        $php = array_merge([$finder->find(false)], $finder->findArguments());

        $expected = 'hello world!';
        $script = <<<PHP
<?php echo '$expected';
PHP;
        $process = new PhpProcess($script, null, null, 60, $php);
        $process->run();
        $this->assertEquals($expected, $process->getOutput());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

define('ERR_SELECT_FAILED', 1);
define('ERR_TIMEOUT', 2);
define('ERR_READ_FAILED', 3);
define('ERR_WRITE_FAILED', 4);

$read = [STDIN];
$write = [STDOUT, STDERR];

stream_set_blocking(STDIN, 0);
stream_set_blocking(STDOUT, 0);
stream_set_blocking(STDERR, 0);

$out = $err = '';
while ($read || $write) {
    $r = $read;
    $w = $write;
    $e = null;
    $n = stream_select($r, $w, $e, 5);

    if (false === $n) {
        die(ERR_SELECT_FAILED);
    } elseif ($n < 1) {
        die(ERR_TIMEOUT);
    }

    if (in_array(STDOUT, $w) && strlen($out) > 0) {
        $written = fwrite(STDOUT, (string) $out, 32768);
        if (false === $written) {
            die(ERR_WRITE_FAILED);
        }
        $out = (string) substr($out, $written);
    }
    if (null === $read && '' === $out) {
        $write = array_diff($write, [STDOUT]);
    }

    if (in_array(STDERR, $w) && strlen($err) > 0) {
        $written = fwrite(STDERR, (string) $err, 32768);
        if (false === $written) {
            die(ERR_WRITE_FAILED);
        }
        $err = (string) substr($err, $written);
    }
    if (null === $read && '' === $err) {
        $write = array_diff($write, [STDERR]);
    }

    if ($r) {
        $str = fread(STDIN, 32768);
        if (false !== $str) {
            $out .= $str;
            $err .= $str;
        }
        if (false === $str || feof(STDIN)) {
            $read = null;
            if (!feof(STDIN)) {
                die(ERR_READ_FAILED);
            }
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Process\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Exception\ProcessFailedException;

/**
 * @author Sebastian Marek <proofek@gmail.com>
 */
class ProcessFailedExceptionTest extends TestCase
{
    /**
     * tests ProcessFailedException throws exception if the process was successful.
     */
    public function testProcessFailedExceptionThrowsException()
    {
        $process = $this->getMockBuilder('Symfony\Component\Process\Process')->setMethods(['isSuccessful'])->setConstructorArgs([['php']])->getMock();
        $process->expects($this->once())
            ->method('isSuccessful')
            ->will($this->returnValue(true));

        if (method_exists($this, 'expectException')) {
            $this->expectException(\InvalidArgumentException::class);
            $this->expectExceptionMessage('Expected a failed process, but the given process was successful.');
        } else {
            $this->setExpectedException(\InvalidArgumentException::class, 'Expected a failed process, but the given process was successful.');
        }

        new ProcessFailedException($process);
    }

    /**
     * tests ProcessFailedException uses information from process output
     * to generate exception message.
     */
    public function testProcessFailedExceptionPopulatesInformationFromProcessOutput()
    {
        $cmd = 'php';
        $exitCode = 1;
        $exitText = 'General error';
        $output = 'Command output';
        $errorOutput = 'FATAL: Unexpected error';
        $workingDirectory = getcwd();

        $process = $this->getMockBuilder('Symfony\Component\Process\Process')->setMethods(['isSuccessful', 'getOutput', 'getErrorOutput', 'getExitCode', 'getExitCodeText', 'isOutputDisabled', 'getWorkingDirectory'])->setConstructorArgs([[$cmd]])->getMock();
        $process->expects($this->once())
            ->method('isSuccessful')
            ->will($this->returnValue(false));

        $process->expects($this->once())
            ->method('getOutput')
            ->will($this->returnValue($output));

        $process->expects($this->once())
            ->method('getErrorOutput')
            ->will($this->returnValue($errorOutput));

        $process->expects($this->once())
            ->method('getExitCode')
            ->will($this->returnValue($exitCode));

        $process->expects($this->once())
            ->method('getExitCodeText')
            ->will($this->returnValue($exitText));

        $process->expects($this->once())
            ->method('isOutputDisabled')
            ->will($this->returnValue(false));

        $process->expects($this->once())
            ->method('getWorkingDirectory')
            ->will($this->returnValue($workingDirectory));

        $exception = new ProcessFailedException($process);

        $this->assertEquals(
            "The command \"$cmd\" failed.\n\nExit Code: $exitCode($exitText)\n\nWorking directory: {$workingDirectory}\n\nOutput:\n================\n{$output}\n\nError Output:\n================\n{$errorOutput}",
            str_replace("'php'", 'php', $exception->getMessage())
        );
    }

    /**
     * Tests that ProcessFailedException does not extract information from
     * process output if it was previously disabled.
     */
    public function testDisabledOutputInFailedExceptionDoesNotPopulateOutput()
    {
        $cmd = 'php';
        $exitCode = 1;
        $exitText = 'General error';
        $workingDirectory = getcwd();

        $process = $this->getMockBuilder('Symfony\Component\Process\Process')->setMethods(['isSuccessful', 'isOutputDisabled', 'getExitCode', 'getExitCodeText', 'getOutput', 'getErrorOutput', 'getWorkingDirectory'])->setConstructorArgs([[$cmd]])->getMock();
        $process->expects($this->once())
            ->method('isSuccessful')
            ->will($this->returnValue(false));

        $process->expects($this->never())
            ->method('getOutput');

        $process->expects($this->never())
            ->method('getErrorOutput');

        $process->expects($this->once())
            ->method('getExitCode')
            ->will($this->returnValue($exitCode));

        $process->expects($this->once())
            ->method('getExitCodeText')
            ->will($this->returnValue($exitText));

        $process->expects($this->once())
            ->method('isOutputDisabled')
            ->will($this->returnValue(true));

        $process->expects($this->once())
            ->method('getWorkingDirectory')
            ->will($this->returnValue($workingDirectory));

        $exception = new ProcessFailedException($process);

        $this->assertEquals(
            "The command \"$cmd\" failed.\n\nExit Code: $exitCode($exitText)\n\nWorking directory: {$workingDirectory}",
            str_replace("'php'", 'php', $exception->getMessage())
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         