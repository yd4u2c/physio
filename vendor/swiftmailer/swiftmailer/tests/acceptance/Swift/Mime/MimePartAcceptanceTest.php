rMoreTimes()
           ->andReturn(false);

        $reader->shouldReceive('getInitialByteSize')
               ->zeroOrMoreTimes()
               ->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with([0xD0], 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with([0xD0], 1)->andReturn(1);
        $reader->shouldReceive('validateByteSequence')->once()->with([0xD0], 1)->andReturn(1);

        $stream->importByteStream($os);

        $this->assertIdenticalBinary(pack('C*', 0xD0, 0x94), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xD0, 0xB6), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xD0, 0xBE), $stream->read(1));

        $this->assertFalse($stream->read(1));
    }

    public function testAlgorithmWithFixedWidthCharsets()
    {
        $reader = $this->getReader();
        $factory = $this->getFactory($reader);

        $reader->shouldReceive('getInitialByteSize')
               ->zeroOrMoreTimes()
               ->andReturn(2);
        $reader->shouldReceive('validateByteSequence')->once()->with([0xD1, 0x8D], 2);
        $reader->shouldReceive('validateByteSequence')->once()->with([0xD0, 0xBB], 2);
        $reader->shouldReceive('validateByteSequence')->once()->with([0xD0, 0xB0], 2);

        $stream = new Swift_CharacterStream_ArrayCharacterStream(
            $factory, 'utf-8'
        );
        $stream->importString(pack('C*', 0xD1, 0x8D, 0xD0, 0xBB, 0xD0, 0xB0));

        $this->assertIdenticalBinary(pack('C*', 0xD1, 0x8D), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xD0, 0xBB), $stream->read(1));
        $this->assertIdenticalBinary(pack('C*', 0xD0, 0xB0), $stream->read(1));

        $this->assertFalse($stream->read(1));
    }

    private function getReader()
    {
        return $this->getMockery('Swift_CharacterReader');
    }

    private function getFactory($reader)
    {
        $factory = $this->getMockery('Swift_CharacterReaderFactory');
        $factory->shouldReceive('getReaderFor')
                ->zeroOrMoreTimes()
                ->with('utf-8')
                ->andReturn($reader);

        return $factory;
    }

    private function getByteStream()
    {
        return $this->getMockery('Swift_OutputByteStream');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

class Swift_Encoder_Base64EncoderTest extends \PHPUnit\Framework\TestCase
