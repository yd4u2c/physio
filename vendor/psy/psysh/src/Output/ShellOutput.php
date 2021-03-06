     $this->assertNull($shell->flushCode());
        $this->assertTrue($shell->hasCode());

        $shell->addCode('+ 1 \\');
        $this->assertNull($shell->flushCode());
        $this->assertTrue($shell->hasCode());

        $shell->addCode('+ 1');
        $code = $shell->flushCode();
        $this->assertFalse($shell->hasCode());
        $code = \preg_replace('/\s+/', ' ', $code);
        $this->assertNotNull($code);
        $this->assertSame('return 1 + 1 + 1;', $code);
    }

    /**
     * @expectedException \Psy\Exception\ParseErrorException
     */
    public function testCodeBufferThrowsParseExceptions()
    {
        $shell = new Shell($this->getConfig());
        $shell->addCode('this is not valid');
        $shell->flushCode();
    }

    public function testClosuresSupport()
    {
        $shell = new Shell($this->getConfig());
        $code = '$test = function () {}';
        $shell->addCode($code);
        $shell->flushCode();
        $code = '$test()';
        $shell->addCode($code);
        $this->assertSame($shell->flushCode(), 'return $test();');
    }

    public function testWriteStdout()
    {
        $output = $this->getOutput();
        $stream = $output->getStream();
        $shell  = new Shell($this->getConfig());
        $shell->setOutput($output);

        $shell->writeStdout("{{stdout}}\n");

        \rewind($stream);
        $streamContents = \stream_get_contents($stream);

        $this->assertSame('{{stdout}}' . PHP_EOL, $streamContents);
    }

    public function testWriteStdoutWithoutNewline()
    {
        $output = $this->getOutput();
        $stream = $output->getStream();
        $shell  = new Shell($this->getConfig());
        $shell->setOutput($output);

        $shell->writeStdout('{{stdout}}');

        \rewind($stream);
        $streamContents = \stream_get_contents($stream);

        $this->assertSame('{{stdout}}<aside>⏎</aside>' . PHP_EOL, $streamContents);
    }

    /**
     * @dataProvider getReturnValues
     */
    public function testWriteReturnValue($input, $expected)
    {
        $output = $this->getOutput();
        $stream = $output->getStream();
        $shell  = new Shell($this->getConfig());
        $shell->setOutput($output);

        $shell->writeReturnValue($input);
        \rewind($stream);
        $this->assertEquals($expected, \stream_get_contents($stream));
    }

    public function getReturnValues()
    {
        return [
            ['{{return value}}', "=> \"\033[32m{{return value}}\033[39m\"" . PHP_EOL],
            [1, "=> \033[35m1\033[39m" . PHP_EOL],
        ];
    }

    /**
     * @dataProvider getRenderedExceptions
     */
    public function testWriteException($exception, $expected)
    {
        $output = $this->getOutput();
        $stream = $output->getStream();
        $shell  = new Shell($this->getConfig());
        $shell->setOutput($output);

        $shell->writeException($exception);
        \rewind($stream);
        $this->assertSame($expected, \stream_get_contents($stream));
    }

    public function getRenderedExceptions()
    {
        return [
            [new \Exception('{{message}}'), "Exception with message '{{message}}'" . PHP_EOL],
        ];
    }

    /**
     * @dataProvider getExecuteValues
     */
    public function testShellExecute($input, $expected)
    {
        $output = $this->getOutput();
        $stream = $output->getStream();
        $shell  = new Shell($this->getConfig());
        $shell->setOutput($output);
        $this->assertEquals($expected, $shell->execute($input));
        \rewind($stream);
        $this->assertSame('', \stream_get_contents($stream));
    }

    public function getExecuteValues()
    {
        return [
            ['return 12', 12],
            ['"{{return value}}"', '{{return value}}'],
            ['1', '1'],
        ];
    }

    /**
     * @dataProvider commandsToHas
     */
    public function testHasCommand($command, $has)
    {
        $shell = new Shell($this->getConfig());

        // :-/
        $refl = new \ReflectionClass('Psy\\Shell');
        $method = $refl->getMethod('hasCommand');
        $method->setAccessible(true);

        $this->assertEquals($method->invokeArgs($shell, [$command]), $has);
    }

    public function commandsToHas()
    {
        return [
            ['help', true],
            ['help help', true],
            ['"help"', false],
            ['"help help"', false],
            ['ls -al ', true],
            ['ls "-al" ', true],
            ['ls"-al"', false],
            [' q', true],
            ['   q  --help', true],
            ['"q"', false],
            ['"q",', false],
        ];
    }

    private function getOutput()
    {
        $stream = \fopen('php://memory', 'w+');
        $this->streams[] = $stream;

        $output = new StreamOutput($stream, StreamOutput::VERBOSITY_NORMAL, false);

        return $output;
    }

    private function getConfig(array $config = [])
    {
        // Mebbe there's a better way than this?
        $dir = \tempnam(\sys_get_temp_dir(), 'psysh_shell_test_');
        \unlink($dir);

        $defaults = [
            'configDir'  => $dir,
            'dataDir'    => $dir,
            'runtimeDir' => $dir,
        ];

        return new Configuration(\array_merge($defaults, $config));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  