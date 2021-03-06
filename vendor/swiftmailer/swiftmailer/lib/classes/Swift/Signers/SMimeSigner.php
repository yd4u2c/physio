<?php

class Swift_ByteStream_FileByteStreamAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $_testFile;

    protected function setUp()
    {
        $this->testFile = sys_get_temp_dir().'/swift-test-file'.__CLASS__;
        file_put_contents($this->testFile, 'abcdefghijklm');
    }

    protected function tearDown()
    {
        unlink($this->testFile);
    }

    public function testFileDataCanBeRead()
    {
        $file = $this->createFileStream($this->testFile);
        $str = '';
        while (false !== $bytes = $file->read(8192)) {
            $str .= $bytes;
        }
        $this->assertEquals('abcdefghijklm', $str);
    }

    public function testFileDataCanBeReadSequentially()
    {
        $file = $this->createFileStream($this->testFile);
        $this->assertEquals('abcde', $file->read(5));
        $this->assertEquals('fghijklm', $file->read(8));
        $this->assertFalse($file->read(1));
    }

    public function testFilenameIsReturned()
    {
        $file = $this->createFileStream($this->testFile);
        $this->assertEquals($this->testFile, $file->getPath());
    }

    public function testFileCanBeWrittenTo()
    {
        $file = $this->createFileStream($this->testFile, true);
        $file->write('foobar');
        $this->assertEquals('foobar', $file->read(8192));
    }

    public function testReadingFromThenWritingToFile()
    {
        $file = $this->createFileStream($this->testFile, true);
        $file->write('foobar');
        $this->assertEquals('foobar', $file->read(8192));
        $file->write('zipbutton');
        $this->assertEquals('zipbutton', $file->read(8192));
    }

    public function testWritingToFileWithCanonicalization()
    {
        $file = $this->createFileStream($this->testFile, true);
        $file->addFilter($this->createFilter(["\r\n", "\r"], "\n"), 'allToLF');
        $file->write("foo\r\nbar\r");
        $file->write("\nzip\r\ntest\r");
        $file->flushBuffers();
        $this->assertEquals("foo\nbar\nzip\ntest\n", file_get_contents($this->testFile));
    }

    public function testWritingWithFulleMessageLengthOfAMultipleOf8192()
    {
        $file = $this->createFileStream($this->testFile, true);
        $file->addFilter($this->createFilter(["\r\n", "\r"], "\n"), 'allToLF');
        $file->write('');
        $file->flushBuffers();
        $this->assertEquals('', file_get_contents($this->testFile));
    }

    public function testBindingOtherStreamsMirrorsWriteOperations()
    {
        $file = $this->createFileStream($this->testFile, true);
        $is1 = $this->createMockInputStream();
        $is2 = $this->createMockInputStream();

        $is1->expects($this->at(0))
            ->method('write')
            ->with('x');
        $is1->expects($this->at(1))
            ->method('write')
            ->with('y');
        $is2->expects($this->at(0))
            ->method('write')
            ->with('x');
        $is2->expects($this->at(1))
            ->method('write')
            ->with('y');

        $file->bind($is1);
        $file->bind($is2);

        $file->write('x');
        $file->write('y');
    }

    public function testBindingOtherStreamsMirrorsFlushOperations()
    {
        $file = $this->createFileStream(
            $this->testFile, true
            );
        $is1 = $this->createMockInputStream();
        $is2 = $this->createMockInputStream();

        $is1->expects($this->once())
            ->method('flushBuffers');
        $is2->expects($this->once())
            ->method('flushBuffers');

        $file->bind($is1);
        $file->bind($is2);

        $file->flushBuffers();
    }

    public function testUnbindingStreamPreventsFurtherWrites()
    {
        $file = $this->createFileStream($this->testFile, true);
        $is1 = $this->createMockInputStream();
        $is2 = $this->createMockInputStream();

        $is1->expects($this->at(0))
            ->method('write')
            ->with('x');
        $is1->expects($this->at(1))
            ->method('write')
            ->with('y');
        $is2->expects($this->once())
            ->method('write')
            ->with('x');

        $file->bind($is1);
        $file->bind($is2);

        $file->write('x');

        $file->unbind($is2);

        $file->write('y');
    }

    private function createFilter($search, $replace)
    {
        return new Swift_StreamFilters_StringReplacementFilter($search, $replace);
    }

    private function createMockInputStream()
    {
        return $this->getMockBuilder('Swift_InputByteStream')->getMock();
    }

    private function createFileStream($file, $writable = false)
    {
        return new Swift_ByteStream_FileByteStream($file, $writable);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

class Swift_CharacterReaderFactory_SimpleCharacterReaderFactoryAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $factory;
    private $prefix = 'Swift_CharacterReader_';

    protected function setUp()
    {
        $this->factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
    }

    public function testCreatingUtf8Reader()
    {
        foreach (['utf8', 'utf-8', 'UTF-8', 'UTF8'] as $utf8) {
            $reader = $this->factory->getReaderFor($utf8);
            $this->assertInstanceOf($this->prefix.'Utf8Reader', $reader);
        }
    }

    public function testCreatingIso8859XReaders()
    {
        $charsets = [];
        foreach (range(1, 16) as $number) {
            foreach (['iso', 'iec'] as $body) {
                $charsets[] = $body.'-8859-'.$number;
                $charsets[] = $body.'8859-'.$number;
                $charsets[] = strtoupper($body).'-8859-'.$number;
                $charsets[] = strtoupper($body).'8859-'.$number;
            }
        }

        foreach ($charsets as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingWindows125XReaders()
    {
        $charsets = [];
        foreach (range(0, 8) as $number) {
            $charsets[] = 'windows-125'.$number;
            $charsets[] = 'windows125'.$number;
            $charsets[] = 'WINDOWS-125'.$number;
            $charsets[] = 'WINDOWS125'.$number;
        }

        foreach ($charsets as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingCodePageReaders()
    {
        $charsets = [];
        foreach (range(0, 8) as $number) {
            $charsets[] = 'cp-125'.$number;
            $charsets[] = 'cp125'.$number;
            $charsets[] = 'CP-125'.$number;
            $charsets[] = 'CP125'.$number;
        }

        foreach ([437, 737, 850, 855, 857, 858, 860,
            861, 863, 865, 866, 869, ] as $number) {
            $charsets[] = 'cp-'.$number;
            $charsets[] = 'cp'.$number;
            $charsets[] = 'CP-'.$number;
            $charsets[] = 'CP'.$number;
        }

        foreach ($charsets as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingAnsiReader()
    {
        foreach (['ansi', 'ANSI'] as $ansi) {
            $reader = $this->factory->getReaderFor($ansi);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingMacintoshReader()
    {
        foreach (['macintosh', 'MACINTOSH'] as $mac) {
            $reader = $this->factory->getReaderFor($mac);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingKOIReaders()
    {
        $charsets = [];
        foreach (['7', '8-r', '8-u', '8u', '8r'] as $end) {
            $charsets[] = 'koi-'.$end;
            $charsets[] = 'koi'.$end;
            $charsets[] = 'KOI-'.$end;
            $charsets[] = 'KOI'.$end;
        }

        foreach ($charsets as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingIsciiReaders()
    {
        foreach (['iscii', 'ISCII', 'viscii', 'VISCII'] as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingMIKReader()
    {
        foreach (['mik', 'MIK'] as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingCorkReader()
    {
        foreach (['cork', 'CORK', 't1', 'T1'] as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(1, $reader->getInitialByteSize());
        }
    }

    public function testCreatingUcs2Reader()
    {
        foreach (['ucs-2', 'UCS-2', 'ucs2', 'UCS2'] as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(2, $reader->getInitialByteSize());
        }
    }

    public function testCreatingUtf16Reader()
    {
        foreach (['utf-16', 'UTF-16', 'utf16', 'UTF16'] as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(2, $reader->getInitialByteSize());
        }
    }

    public function testCreatingUcs4Reader()
    {
        foreach (['ucs-4', 'UCS-4', 'ucs4', 'UCS4'] as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(4, $reader->getInitialByteSize());
        }
    }

    public function testCreatingUtf32Reader()
    {
        foreach (['utf-32', 'UTF-32', 'utf32', 'UTF32'] as $charset) {
            $reader = $this->factory->getReaderFor($charset);
            $this->assertInstanceOf($this->prefix.'GenericFixedWidthReader', $reader);
            $this->assertEquals(4, $reader->getInitialByteSize());
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

class Swift_Encoder_Base64EncoderAcceptanceTest extends \PHPUnit\Framework\TestCase
{
    private $samplesDir;
    private $encoder;

    protected function setUp()
    {
        $this->samplesDir = realpath(__DIR__.'/../../../_samples/charsets');
        $this->encoder = new Swift_Encoder_Base64Encoder();
    }

    public function testEncodingAndDecodingSamples()
    {
        $sampleFp = opendir($this->samplesDir);
        while (false !== $encodingDir = readdir($sampleFp)) {
            if ('.' == substr($encodingDir, 0, 1)) {
                continue;
            }

            $sampleDir = $this->samplesDir.'/'.$encodingDir;

            if (is_dir($sampleDir)) {
                $fileFp = opendir($sampleDir);
                while (false !== $sampleFile = readdir($fileFp)) {
                    if ('.' == substr($sampleFile, 0, 1)) {
                        continue;
                    }

                    $text = file_get_contents($sampleDir.'/'.$sampleFile);
                    $encodedText = $this->encoder->encodeString($text);

                    $this->assertEquals(
                        base64_decode($encodedText), $text,
                        '%s: Encoded string should decode back to original string for sample '.
                        $sampleDir.'/'.$sampleFile
                        );
                }
                closedir($fileFp);
            }
        }
        closedir($sampleFp);
    }
}
             