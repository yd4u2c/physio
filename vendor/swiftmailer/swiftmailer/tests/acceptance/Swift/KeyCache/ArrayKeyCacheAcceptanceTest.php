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

        $bs->bind($is1);
        $bs->bind($is2);

        $bs->write('x');
        $bs->write('y');
    }

    public function testBindingOtherStreamsMirrorsFlushOperations()
    {
        $bs = $this->createArrayStream('');
        $is1 = $this->getMockBuilder('Swift_InputByteStream')->getMock();
        $is2 = $this->getMockBuilder('Swift_InputByteStream')->getMock();

        $is1->expects($this->once())
            ->method('flushBuffers');
        $is2->expects($this->once())
            ->method('flushBuffers');

        $bs->bind($is1);
        $bs->bind($is2);

        $bs->flushBuffers();
    }

    public function testUnbindingStreamPreventsFurtherWrites()
    {
        $bs = $this->createArrayStream('');
        $is1 = $this->getMockBuilder('Swift_InputByteStream')->getMock();
        $is2 = $this->getMockBuilder('Swift_InputByteStream')->getMock();

        $is1->expects($this->at(0))
            ->method('write')
            ->with('x');
        $is1->expects($this->at(1))
            ->method('write')
            ->with('y');
        $is2->expects($this->once())
            ->method('write')
            ->with('x');

        $bs->bind($is1);
        $bs->bind($is2);

        $bs->write('x');

        $bs->unbind($is2);

        $bs->write('y');
    }

    private function createArrayStream($input)
    {
        return new Swift_ByteStream_ArrayByteStream($input);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

class Swift_CharacterReader_GenericFixedWidthReaderTest extends \PHPUnit\Framework\TestCase
{
    public function testInitialByteSizeMatchesWidth()
    {
        $reader = new Swift_CharacterReader_GenericFixedWidthReader(1);
        $this->assertSame(1, $reader->getInitialByteSize());

        $reader = new Swift_CharacterReader_GenericFixedWidthReader(4);
        $this->assertSame(4, $reader->getInitialByteSize());
    }

    public function testValidationValueIsBasedOnOctetCount()
    {
        $reader = new Swift_CharacterReader_GenericFixedWidthReader(4);

        $this->assertSame(
            1, $reader->validateByteSequence([0x01, 0x02, 0x03], 3)
            ); //3 octets

        $this->assertSame(
            2, $reader->validateByteSequence([0x01, 0x0A], 2)
            ); //2 octets

        $this->assertSame(
            3, $reader->validateByteSequence([0xFE], 1)
            ); //1 octet

        $this->assertSame(
            0, $reader->validateByteSequence([0xFE, 0x03, 0x67, 0x9A], 4)
            ); //All 4 octets
    }

    public function testValidationFailsIfTooManyOctets()
    {
        $reader = new Swift_CharacterReader_GenericFixedWidthReader(6);

        $this->assertSame(-1, $reader->validateByteSequence(
            [0xFE, 0x03, 0x67, 0x9A, 0x10, 0x09, 0x85], 7
            )); //7 octets
    }
}
                                                                                                                                                                                                                                                                                    