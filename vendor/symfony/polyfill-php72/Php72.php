$expectedOutput, $output);

        $input->write(345);

        foreach ($process as $type => $data) {
            $output[] = [$type, $data];
        }

        $this->assertSame('', $process->getOutput());
        $this->assertFalse($process->isRunning());

        $expectedOutput = [
            [$process::OUT, '123'],
            [$process::ERR, '234'],
            [$process::OUT, '345'],
            [$process::ERR, '456'],
        ];
        $this->assertSame($expectedOutput, $output);
    }

    public function testNonBlockingNorClearingIteratorOutput()
    {
        $input = new InputStream();

        $process = $this->getProcessForCode('fwrite(STDOUT, fread(STDIN, 3));');
        $process->setInput($input);
        $process->start();
        $output = [];

        foreach ($process->getIterator($process::ITER_NON_BLOCKING | $process::ITER_KEEP_OUTPUT) as $type => $data) {
            $output[] = [$type, $data];
            break;
        }
        $expectedOutput = [
            [$process::OUT, ''],
        ];
        $this->assertSame($expectedOutput, $output);

        $input->write(123);

        foreach ($process->getIterator($process::ITER_NON_BLOCKING | $process::ITER_KEEP_OUTPUT) as $type => $data) {
            if ('' !== $data) {
                $output[] = [$type, $data];
            }
        }

        $this->assertSame('123', $process->getOutput());
        $this->assertFalse($process->isRunning());

        $expectedOutput = [
            [$process::OUT, ''],
            [$process::OUT, '123'],
        ];
        $this->assertSame($expectedOutput, $output);
    }

    public function testChainedProcesses()
    {
        $p1 = $this->getProcessForCode('fwrite(STDERR, 123); fwrite(STDOUT, 456);');
        $p2 = $this->getProcessForCode('stream_copy_to_stream(STDIN, STDOUT);');
        $p2->setInput($p1);

        $p1->start();
        $p2->run();

        $this->assertSame('123', $p1->getErrorOutput());
        $this->assertSame('', $p1->getOutput());
        $this->assertSame('', $p2->getErrorOutput());
        $this->assertSame('456', $p2->getOutput());
    }

    public function testSetBadEnv()
    {
        $process = $this->getProcess('echo hello');
        $process->setEnv(['bad%%' => '123']);
        $process->inheritEnvironmentVariables(true);

        $process->run();

        $this->assertSame('hello'.PHP_EOL, $process->getOutput());
        $this->assertSame('', $process->getErrorOutput());
    }

    public function testEnvBackupDoesNotDeleteExistingVars()
    {
        putenv('existing_var=foo');
        $_ENV['existing_var'] = 'foo';
        $process = $this->getProcess('php -r "echo getenv(\'new_test_var\');"');
        $process->setEnv(['existing_var' => 'bar', 'new_test_var' => 'foo']);
        $process->inheritEnvironmentVariables();

        $process->run();

        $this->assertSame('foo', $process->getOutput());
        $this->assertSame('foo', getenv('existing_var'));
        $this->assertFalse(getenv('new_test_var'));

        putenv('existing_var');
        unset($_ENV['existing_var']);
    }

    public function testEnvIsInherited()
    {
        $process = $this->getProcessForCode('echo serialize($_SERVER);', null, ['BAR' => 'BAZ', 'EMPTY' => '']);

        putenv('FOO=BAR');
        $_ENV['FOO'] = 'BAR';

        $process->run();

        $expected = ['BAR' => 'BAZ', 'EMPTY' => '', 'FOO' => 'BAR'];
        $env = array_intersect_key(unserialize($process->getOutput()), $expected);

        $this->assertEquals($expected, $env);

        putenv('FOO');
        unset($_ENV['FOO']);
    }

    public function testGetCommandLine()
    {
        $p = new Process(['/usr/bin/php']);

        $expected = '\\' === \DIRECTORY_SEPARATOR ? '"/usr/bin/php"' : "'/usr/bin/php'";
        $this->assertSame($expected, $p->getCommandLine());
    }

    /**
     * @dataProvider provideEscapeArgument
     */
    public function testEscapeArgument($arg)
    {
        $p = new Process([self::$phpBin, '-r', 'echo $argv[1];', $arg]);
        $p->run();

        $this->assertSame((string) $arg, $p->getOutput());
    }

    public function testRawCommandLine()
    {
        $p = Process::fromShellCommandline(sprintf('"%s" -r %s "a" "" "b"', self::$phpBin, escapeshellarg('print_r($argv);')));
        $p->run();

        $expected = <<<EOTXT
Array
(
    [0] => -
    [1] => a
    [2] => 
    [3] => b
)

EOTXT;
        $this->assertSame($expected, str_replace('Standard input code', '-', $p->getOutput()));
    }

    public function provideEscapeArgument()
    {
        yield ['a"b%c%'];
        yield ['a"b^c^'];
        yield ["a\nb'c"];
        yield ['a^b c!'];
        yield ["a!b\tc"];
        yield ['a\\\\"\\"'];
        yield ['éÉèÈàÀöä'];
        yield [null];
        yield [1];
        yield [1.1];
    }

    public function testEnvArgument()
    {
        $env = ['FOO' => 'Foo', 'BAR' => 'Bar'];
        $cmd = '\\' === \DIRECTORY_SEPARATOR ? 'echo !FOO! !BAR! !BAZ!' : 'echo $FOO $BAR $BAZ';
        $p = Process::fromShellCommandline($cmd, null, $env);
        $p->run(null, ['BAR' => 'baR', 'BAZ' => 'baZ']);

        $this->assertSame('Foo baR baZ', rtrim($p->getOutput()));
        $this->assertSame($env, $p->getEnv());
    }

    private function getProcess($commandline, string $cwd = null, array $env = null, $input = null, ?int $timeout = 60): Process
    {
        if (\is_string($commandline)) {
            $process = Process::fromShellCommandline($commandline, $cwd, $env, $input, $timeout);
        } else {
            $process = new Process($commandline, $cwd, $env, $input, $timeout);
        }
        $process->inheritEnvironmentVariables();

        if (self::$process) {
            self::$process->stop(0);
        }

        return self::$process = $process;
    }

    private function getProcessForCode(string $code, string $cwd = null, array $env = null, $input = null, ?int $timeout = 60): Process
    {
        return $this->getProcess([self::$phpBin, '-r', $code], $cwd, $env, $input, $timeout);
    }
}

class NonStringifiable
{
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       