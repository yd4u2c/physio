   ->method('runJob')
             ->with($skipifSection)
             ->will($this->returnValue(['stdout' => '', 'stderr' => '']));

        $this->testCase->run();
    }

    public function testShouldNotRunTestSectionIfSkipifSectionReturnsOutputWithSkipWord(): void
    {
        $skipifSection = '<?php echo "skip: Reason"; ?>' . \PHP_EOL;

        $phptContent = self::EXPECT_CONTENT . \PHP_EOL;
        $phptContent .= '--SKIPIF--' . \PHP_EOL;
        $phptContent .= $skipifSection;

        $this->setPhpContent($phptContent);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with($skipifSection)
             ->will($this->returnValue(['stdout' => 'skip: Reason', 'stderr' => '']));

        $this->testCase->run();
    }

    public function testShouldRunCleanSectionWhenDefined(): void
    {
        $cleanSection = '<?php unlink("/tmp/something"); ?>' . \PHP_EOL;

        $phptContent = self::EXPECT_CONTENT . \PHP_EOL;
        $phptContent .= '--CLEAN--' . \PHP_EOL;
        $phptContent .= $cleanSection;

        $this->setPhpContent($phptContent);

        $this->phpProcess
             ->expects($this->at(1))
             ->method('runJob')
             ->with($cleanSection);

        $this->testCase->run();
    }

    public function testShouldSkipTestWhenPhptFileIsEmpty(): void
    {
        $this->setPhpContent('');

        $result = $this->testCase->run();
        $this->assertCount(1, $result->skipped());
        $this->assertSame('Invalid PHPT file', $result->skipped()[0]->thrownException()->getMessage());
    }

    public function testShouldSkipTestWhenFileSectionIsMissing(): void
    {
        $this->setPhpContent(
            <<<EOF
--TEST--
Something to describe it
--EXPECT--
Something
EOF
        );

        $result = $this->testCase->run();

        $this->assertCount(1, $result->skipped());
        $this->assertSame('Invalid PHPT file', $result->skipped()[0]->thrownException()->getMessage());
    }

    public function testShouldSkipTestWhenThereIsNoExpecOrExpectifOrExpecregexSectionInPhptFile(): void
    {
        $this->setPhpContent(
            <<<EOF
--TEST--
Something to describe it
--FILE--
<?php
echo "Hello world!\n";
?>
EOF
        );

        $result = $this->testCase->run();

        $this->assertCount(1, $result->skipped());
        $skipMessage = $result->skipped()[0]->thrownException()->getMessage();
        $this->assertSame('Invalid PHPT file', $skipMessage);
    }

    public function testShouldSkipTestWhenSectionHeaderIsMalformed(): void
    {
        $this->setPhpContent(
            <<<EOF
----
--TEST--
This is not going to work out
--EXPECT--
Tears and misery
EOF
        );

        $result = $this->testCase->run();

        $this->assertCount(1, $result->skipped());
        $skipMessage = $result->skipped()[0]->thrownException()->getMessage();
        $this->assertSame('Invalid PHPT file: empty section header', $skipMessage);
    }

    public function testShouldValidateExpectSession(): void
    {
        $this->setPhpContent(self::EXPECT_CONTENT);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with(self::FILE_SECTION)
             ->will($this->returnValue(['stdout' => 'Hello PHPUnit!', 'stderr' => '']));

        $result = $this->testCase->run();

        $this->assertTrue($result->wasSuccessful());
    }

    public function testShouldValidateExpectfSession(): void
    {
        $this->setPhpContent(self::EXPECTF_CONTENT);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with(self::FILE_SECTION)
             ->will($this->returnValue(['stdout' => 'Hello PHPUnit!', 'stderr' => '']));

        $result = $this->testCase->run();

        $this->assertTrue($result->wasSuccessful());
    }

    public function testShouldValidateExpectregexSession(): void
    {
        $this->setPhpContent(self::EXPECTREGEX_CONTENT);

        $this->phpProcess
             ->expects($this->once())
             ->method('runJob')
             ->with(self::FILE_SECTION)
             ->will($this->returnValue(['stdout' => 'Hello PHPUnit!', 'stderr' => '']));

        $result = $this->testCase->run();

        $this->assertTrue($result->wasSuccessful());
    }

    /**
     * Defines the content of the current PHPT test.
     *
     * @param string $content
     */
    private function setPhpContent($content): void
    {
        \file_put_contents($this->filename, $content);
    }

    /**
     * Ensures the correct line ending is used for comparison
     *
     * @param string $content
     *
     * @return string
     */
    private function ensureCorrectEndOfLine($content)
    {
        return \strtr(
            $content,
            [
                "\r\n" => \PHP_EOL,
                "\r"   => \PHP_EOL,
                "\n"   => \PHP_EOL,
            ]
        );
    }
}
              