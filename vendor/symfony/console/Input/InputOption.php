ertEquals(2, $command->getDefinition()->getArgumentCount(), '->mergeApplicationDefinition() does not try to merge twice the application arguments');
    }

    public function testRunInteractive()
    {
        $tester = new CommandTester(new \TestCommand());

        $tester->execute([], ['interactive' => true]);

        $this->assertEquals('interact called'.PHP_EOL.'execute called'.PHP_EOL, $tester->getDisplay(), '->run() calls the interact() method if the input is interactive');
    }

    public function testRunNonInteractive()
    {
        $tester = new CommandTester(new \TestCommand());

        $tester->execute([], ['interactive' => false]);

        $this->assertEquals('execute called'.PHP_EOL, $tester->getDisplay(), '->run() does not call the interact() method if the input is not interactive');
    }

    /**
     * @expectedException        \LogicException
     * @expectedExceptionMessage You must override the execute() method in the concrete command class.
     */
    public function testExecuteMethodNeedsToBeOverridden()
    {
        $command = new Command('foo');
        $command->run(new StringInput(''), new NullOutput());
    }

    /**
     * @expectedException        \Symfony\Component\Console\Exception\InvalidOptionException
     * @expectedExceptionMessage The "--bar" option does not exist.
     */
    public function testRunWithInvalidOption()
    {
        $command = new \TestCommand();
        $tester = new CommandTester($command);
        $tester->execute(['--bar' => true]);
    }

    public function testRunReturnsIntegerExitCode()
    {
        $command = new \TestCommand();
        $exitCode = $command->run(new StringInput(''), new NullOutput());
        $this->assertSame(0, $exitCode, '->run() returns integer exit code (treats null as 0)');

        $command = $this->getMockBuilder('TestCommand')->setMethods(['execute'])->getMock();
        $command->expects($this->once())
            ->method('execute')
            ->will($this->returnValue('2.3'));
        $exitCode = $command->run(new StringInput(''), new NullOutput());
        $this->assertSame(2, $exitCode, '->run() returns integer exit code (casts numeric to int)');
    }

    public function testRunWithApplication()
    {
        $command = new \TestCommand();
        $command->setApplication(new Application());
        $exitCode = $command->run(new StringInput(''), new NullOutput());

        $this->assertSame(0, $exitCode, '->run() returns an integer exit code');
    }

    public function testRunReturnsAlwaysInteger()
    {
        $command = new \TestCommand();

        $this->assertSame(0, $command->run(new StringInput(''), new NullOutput()));
    }

    public function testRunWithProcessTitle()
    {
        $command = new \TestCommand();
        $command->setApplication(new Application());
        $command->setProcessTitle('foo');
        $this->assertSame(0, $command->run(new StringInput(''), new NullOutput()));
        if (\function_exists('cli_set_process_title')) {
            if (null === @cli_get_process_title() && 'Darwin' === PHP_OS) {
                $this->markTestSkipped('Running "cli_get_process_title" as an unprivileged user is not supported on MacOS.');
            }
            $this->assertEquals('foo', cli_get_process_title());
        }
    }

    public function testSetCode()
    {
        $command = new \TestCommand();
        $ret = $command->setCode(function (InputInterface $input, OutputInterface $output) {
            $output->writeln('from the code...');
        });
        $this->assertEquals($command, $ret, '->setCode() implements a fluent interface');
        $tester = new CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called'.PHP_EOL.'from the code...'.PHP_EOL, $tester->getDisplay());
    }

    public function getSetCodeBindToClosureTests()
    {
        return [
            [true, 'not bound to the command'],
            [false, 'bound to the command'],
        ];
    }

    /**
     * @dataProvider getSetCodeBindToClosureTests
     */
    public function testSetCodeBindToClosure($previouslyBound, $expected)
    {
        $code = createClosure();
        if ($previouslyBound) {
            $code = $code->bindTo($this);
        }

        $command = new \TestCommand();
        $command->setCode($code);
        $tester = new CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called'.PHP_EOL.$expected.PHP_EOL, $tester->getDisplay());
    }

    public function testSetCodeWithStaticClosure()
    {
        $command = new \TestCommand();
        $command->setCode(self::createClosure());
        $tester = new CommandTester($command);
        $tester->execute([]);

        $this->assertEquals('interact called'.PHP_EOL.'bound'.PHP_EOL, $tester->getDisplay());
    }

    private static function createClosure()
    {
        return function (InputInterface $input, OutputInterface $output) {
            $output->writeln(isset($this) ? 'bound' : 'not bound');
        };
    }

    public function testSetCodeWithNonClosureCallable()
    {
        $command = new \TestCommand();
        $ret = $command->setCode([$this, 'callableMethodCommand']);
        $this->assertEquals($command, $ret, '->setCode() implements a fluent interface');
        $tester = new CommandTester($command);
        $tester->execute([]);
        $this->assertEquals('interact called'.PHP_EOL.'from the code...'.PHP_EOL, $tester->getDisplay());
    }

    public function callableMethodCommand(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('from the code...');
    }
}

// In order to get an unbound closure, we should create it outside a class
// scope.
function createClosure()
{
    return function (InputInterface $input, OutputInterface $output) {
        $output->writeln($this instanceof Command ? 'bound to the command' : 'not bound to the command');
    };
}
                                                                                  