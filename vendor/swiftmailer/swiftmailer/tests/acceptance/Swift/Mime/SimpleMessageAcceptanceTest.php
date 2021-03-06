    $output =
        'YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXpBQk'.//38
        'NERUZHSElKS0xNTk9QUVJTVFVWV1hZWjEyMzQ1'."\r\n".//76 *
        'Njc4OTBhYmNkZWZnaGlqa2xtbm9wcXJzdHV2d3'.//38
        'h5ekFCQ0RFRkdISUpLTE1OT1BRUlNUVVZXWFla'."\r\n".//76 *
        'MTIzNDU2Nzg5MEFCQ0RFRkdISUpLTE1OT1BRUl'.//38
        'NUVVZXWFla';                                       //48

        $this->assertEquals(
            $output, $this->encoder->encodeString($input),
            '%s: Lines should be no more than 76 characters'
            );
    }

    public function testMaximumLineLengthCanBeSpecified()
    {
        $input =
        'abcdefghijklmnopqrstuvwxyz'.
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.
        '1234567890'.
        'abcdefghijklmnopqrstuvwxyz'.
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.
        '1234567890'.
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $output =
        'YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXpBQk'.//38
        'NERUZHSElKS0'."\r\n".//50 *
        'xNTk9QUVJTVFVWV1hZWjEyMzQ1Njc4OTBhYmNk'.//38
        'ZWZnaGlqa2xt'."\r\n".//50 *
        'bm9wcXJzdHV2d3h5ekFCQ0RFRkdISUpLTE1OT1'.//38
        'BRUlNUVVZXWF'."\r\n".//50 *
        'laMTIzNDU2Nzg5MEFCQ0RFRkdISUpLTE1OT1BR'.//38
        'UlNUVVZXWFla';                                     //50 *

        $this->assertEquals(
            $output, $this->encoder->encodeString($input, 0, 50),
            '%s: Lines should be no more than 100 characters'
            );
    }

    public function testFirstLineLengthCanBeDifferent()
    {
        $input =
        'abcdefghijklmnopqrstuvwxyz'.
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.
        '1234567890'.
        'abcdefghijklmnopqrstuvwxyz'.
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.
        '1234567890'.
        'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $output =
        'YWJjZGVmZ2hpamtsbW5vcHFyc3R1dnd4eXpBQk'.//38
        'NERUZHSElKS0xNTk9QU'."\r\n".//57 *
        'VJTVFVWV1hZWjEyMzQ1Njc4OTBhYmNkZWZnaGl'.//38
        'qa2xtbm9wcXJzdHV2d3h5ekFCQ0RFRkdISUpLT'."\r\n".//76 *
        'E1OT1BRUlNUVVZXWFlaMTIzNDU2Nzg5MEFCQ0R'.//38
        'FRkdISUpLTE1OT1BRUlNUVVZXWFla';                    //67

        $this->assertEquals(
            $output, $this->encoder->encodeString($input, 19),
            '%s: First line offset is 19 so first line should be 57 chars long'
            );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

class Swift_Encoder_QpEncoderTest extends \SwiftMailerTestCase
{
    /* -- RFC 2045, 6.7 --
    (1)   (General 8bit representation) Any octet, except a CR or
                    LF that is part of a CRLF line break of the canonical
                    (standard) form of the data being encoded, may be
                    represented by an "=" followed by a two digit
                    hexadecimal representation of the octet's value.  The
                    digits of the hexadecimal alphabet, for this purpose,
                    are "0123456789ABCDEF".  Uppercase letters must be
                    used; lowercase letters are not allowed.  Thus, for
                    example, the decimal value 12 (US-ASCII form feed) can
                    be represented by "=0C", and the decimal value 61 (US-
                    ASCII EQUAL SIGN) can be represented by "=3D".  This
                    rule must be followed except when the following rules
                    allow an alternative encoding.
                    */

    public function testPermittedCharactersAreNotEncoded()
    {
        /* -- RFC 2045, 6.7 --
        (2)   (Literal representation) Octets with decimal values of
                    33 through 60 inclusive, and 62 through 126, inclusive,
                    MAY be represented as the US-ASCII characters which
                    correspond to those octets (EXCLAMATION POINT through
                    LESS THAN, and GREATER THAN through TILDE,
                    respectively).
                    */

        foreach (array_merge(range(33, 60), range(62, 126)) as $ordinal) {
            $char = chr($ordinal);

            $charStream = $this->createCharStream();
            $charStream->shouldReceive('flushContents')
                       ->once();
            $charStream->shouldReceive('importString')
                       ->once()
                       ->with($char);
            $charStream->shouldReceive('readBytes')
                       ->once()
                       ->andReturn([$ordinal]);
            $charStream->shouldReceive('readBytes')
                       ->atLeast()->times(1)
                       ->andReturn(false);

            $encoder = new Swift_Encoder_QpEncoder($charStream);

            $this->assertIdenticalBinary($char, $encoder->encodeString($char));
        }
    }

    public function testWhiteSpaceAtLineEndingIsEncoded()
    {
        /* -- RFC 2045, 6.7 --
        (3)   (White Space) Octets with values of 9 and 32 MAY be
                    represented as US-ASCII TAB (HT) and SPACE characters,
                    respectively, but MUST NOT be so represented at the end
                    of an encoded line.  Any TAB (HT) or SPACE characters
                    on an encoded line MUST thus be followed on that line
                    by a printable character.  In particular, an "=" at the
                    end of an encoded line, indicating a soft line break
                    (see rule #5) may follow one or more TAB (HT) or SPACE
                    characters.  It follows that an octet with decimal
                    value 9 or 32 appearing at the end of an encoded line
                    must be represented according to Rule #1.  This rule is
                    necessary because some MTAs (Message Transport Agents,
                    programs which transport messages from one user to
                    another, or perform a portion of such transfers) are
                    known to pad lines of text with SPACEs, and others are
                    known to remove "white space" characters from the end
                    of a line.  Therefore, when decoding a Quoted-Printable
                    body, any trailing white space on a line must be
                    deleted, as it will necessarily have been added by
                    intermediate transport agents.
                    */

        $HT = chr(0x09); //9
        $SPACE = chr(0x20); //32

        //HT
        $string = 'a'.$HT.$HT."\r\n".'b';

        $charStream = $this->createCharStream();
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($string);

        $charStream->shouldReceive('readBytes')->once()->andReturn([ord('a')]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x09]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x09]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0D]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0A]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([ord('b')]);
        $charStream->shouldReceive('readBytes')->once()->andReturn(false);

        $encoder = new Swift_Encoder_QpEncoder($charStream);
        $this->assertEquals(
            'a'.$HT.'=09'."\r\n".'b',
            $encoder->encodeString($string)
            );

        //SPACE
        $string = 'a'.$SPACE.$SPACE."\r\n".'b';

        $charStream = $this->createCharStream();
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($string);

        $charStream->shouldReceive('readBytes')->once()->andReturn([ord('a')]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x20]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x20]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0D]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0A]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([ord('b')]);
        $charStream->shouldReceive('readBytes')->once()->andReturn(false);

        $encoder = new Swift_Encoder_QpEncoder($charStream);
        $this->assertEquals(
            'a'.$SPACE.'=20'."\r\n".'b',
            $encoder->encodeString($string)
            );
    }

    public function testCRLFIsLeftAlone()
    {
        /*
        (4)   (Line Breaks) A line break in a text body, represented
                    as a CRLF sequence in the text canonical form, must be
                    represented by a (RFC 822) line break, which is also a
                    CRLF sequence, in the Quoted-Printable encoding.  Since
                    the canonical representation of media types other than
                    text do not generally include the representation of
                    line breaks as CRLF sequences, no hard line breaks
                    (i.e. line breaks that are intended to be meaningful
                    and to be displayed to the user) can occur in the
                    quoted-printable encoding of such types.  Sequences
                    like "=0D", "=0A", "=0A=0D" and "=0D=0A" will routinely
                    appear in non-text data represented in quoted-
                    printable, of course.

                    Note that many implementations may elect to encode the
                    local representation of various content types directly
                    rather than converting to canonical form first,
                    encoding, and then converting back to local
                    representation.  In particular, this may apply to plain
                    text material on systems that use newline conventions
                    other than a CRLF terminator sequence.  Such an
                    implementation optimization is permissible, but only
                    when the combined canonicalization-encoding step is
                    equivalent to performing the three steps separately.
                    */

        $string = 'a'."\r\n".'b'."\r\n".'c'."\r\n";

        $charStream = $this->createCharStream();
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($string);

        $charStream->shouldReceive('readBytes')->once()->andReturn([ord('a')]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0D]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0A]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([ord('b')]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0D]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0A]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([ord('c')]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0D]);
        $charStream->shouldReceive('readBytes')->once()->andReturn([0x0A]);
        $charStream->shouldReceive('readBytes')->once()->andReturn(false);

        $encoder = new Swift_Encoder_QpEncoder($charStream);
        $this->assertEquals($string, $encoder->encodeString($string));
    }

    public function testLinesLongerThan76CharactersAreSoftBroken()
    {
        /*
        (5)   (Soft Line Breaks) The Quoted-Printable encoding
                    REQUIRES that encoded lines be no more than 76
                    characters long.  If longer lines are to be encoded
                    with the Quoted-Printable encoding, "soft" line breaks
                    must be used.  An equal sign as the last character on a
                    encoded line indicates such a non-significant ("soft")
                    line break in the encoded text.
                    */

        $input = str_repeat('a', 140);

        $charStream = $this->createCharStream();
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($input);

        $output = '';
        for ($i = 0; $i < 140; ++$i) {
            $charStream->shouldReceive('readBytes')
                       ->once()
                       ->andReturn([ord('a')]);

            if (75 == $i) {
                $output .= "=\r\n";
            }
            $output .= 'a';
        }

        $charStream->shouldReceive('readBytes')
                    ->once()
                    ->andReturn(false);

        $encoder = new Swift_Encoder_QpEncoder($charStream);
        $this->assertEquals($output, $encoder->encodeString($input));
    }

    public function testMaxLineLengthCanBeSpecified()
    {
        $input = str_repeat('a', 100);

        $charStream = $this->createCharStream();
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($input);

        $output = '';
        for ($i = 0; $i < 100; ++$i) {
            $charStream->shouldReceive('readBytes')
                       ->once()
                       ->andReturn([ord('a')]);

            if (53 == $i) {
                $output .= "=\r\n";
            }
            $output .= 'a';
        }
        $charStream->shouldReceive('readBytes')
                    ->once()
                    ->andReturn(false);

        $encoder = new Swift_Encoder_QpEncoder($charStream);
        $this->assertEquals($output, $encoder->encodeString($input, 0, 54));
    }

    public function testBytesBelowPermittedRangeAreEncoded()
    {
        /*
        According to Rule (1 & 2)
        */

        foreach (range(0, 32) as $ordinal) {
            $char = chr($ordinal);

            $charStream = $this->createCharStream();
            $charStream->shouldReceive('flushContents')
                       ->once();
            $charStream->shouldReceive('importString')
                       ->once()
                       ->with($char);
            $charStream->shouldReceive('readBytes')
                       ->once()
                       ->andReturn([$ordinal]);
            $charStream->shouldReceive('readBytes')
                       ->atLeast()->times(1)
                       ->andReturn(false);

            $encoder = new Swift_Encoder_QpEncoder($charStream);

            $this->assertEquals(
                sprintf('=%02X', $ordinal), $encoder->encodeString($char)
                );
        }
    }

    public function testDecimalByte61IsEncoded()
    {
        /*
        According to Rule (1 & 2)
        */

        $char = '=';

        $charStream = $this->createCharStream();
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($char);
        $charStream->shouldReceive('readBytes')
                    ->once()
                    ->andReturn([61]);
        $charStream->shouldReceive('readBytes')
                    ->atLeast()->times(1)
                    ->andReturn(false);

        $encoder = new Swift_Encoder_QpEncoder($charStream);

        $this->assertEquals('=3D', $encoder->encodeString('='));
    }

    public function testBytesAbovePermittedRangeAreEncoded()
    {
        /*
        According to Rule (1 & 2)
        */

        foreach (range(127, 255) as $ordinal) {
            $char = chr($ordinal);

            $charStream = $this->createCharStream();
            $charStream->shouldReceive('flushContents')
                       ->once();
            $charStream->shouldReceive('importString')
                       ->once()
                       ->with($char);
            $charStream->shouldReceive('readBytes')
                       ->once()
                       ->andReturn([$ordinal]);
            $charStream->shouldReceive('readBytes')
                       ->atLeast()->times(1)
                       ->andReturn(false);

            $encoder = new Swift_Encoder_QpEncoder($charStream);

            $this->assertEquals(
                sprintf('=%02X', $ordinal), $encoder->encodeString($char)
                );
        }
    }

    public function testFirstLineLengthCanBeDifferent()
    {
        $input = str_repeat('a', 140);

        $charStream = $this->createCharStream();
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($input);

        $output = '';
        for ($i = 0; $i < 140; ++$i) {
            $charStream->shouldReceive('readBytes')
                       ->once()
                       ->andReturn([ord('a')]);

            if (53 == $i || 53 + 75 == $i) {
                $output .= "=\r\n";
            }
            $output .= 'a';
        }

        $charStream->shouldReceive('readBytes')
                    ->once()
                    ->andReturn(false);

        $encoder = new Swift_Encoder_QpEncoder($charStream);
        $this->assertEquals(
            $output, $encoder->encodeString($input, 22),
            '%s: First line should start at offset 22 so can only have max length 54'
            );
    }

    public function testTextIsPreWrapped()
    {
        $encoder = $this->createEncoder();

        $input = str_repeat('a', 70)."\r\n".
                 str_repeat('a', 70)."\r\n".
                 str_repeat('a', 70);

        $this->assertEquals(
            $input, $encoder->encodeString($input)
            );
    }

    private function createCharStream()
    {
        return $this->getMockery('Swift_CharacterStream')->shouldIgnoreMissing();
    }

    private function createEncoder()
    {
        $factory = new Swift_CharacterReaderFactory_SimpleCharacterReaderFactory();
        $charStream = new Swift_CharacterStream_NgCharacterStream($factory, 'utf-8');

        return new Swift_Encoder_QpEncoder($charStream);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

class Swift_Encoder_Rfc2231EncoderTest extends \SwiftMailerTestCase
{
    private $rfc2045Token = '/^[\x21\x23-\x27\x2A\x2B\x2D\x2E\x30-\x39\x41-\x5A\x5E-\x7E]+$/D';

    /* --
    This algorithm is described in RFC 2231, but is barely touched upon except
    for mentioning bytes can be represented as their octet values (e.g. %20 for
    the SPACE character).

    The tests here focus on how to use that representation to always generate text
    which matches RFC 2045's definition of "token".
    */

    public function testEncodingAsciiCharactersProducesValidToken()
    {
        $charStream = $this->getMockery('Swift_CharacterStream');

        $string = '';
        foreach (range(0x00, 0x7F) as $octet) {
            $char = pack('C', $octet);
            $string .= $char;
            $charStream->shouldReceive('read')
                       ->once()
                       ->andReturn($char);
        }

        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($string);
        $charStream->shouldReceive('read')
                    ->atLeast()->times(1)
                    ->andReturn(false);

        $encoder = new Swift_Encoder_Rfc2231Encoder($charStream);
        $encoded = $encoder->encodeString($string);

        foreach (explode("\r\n", $encoded) as $line) {
            $this->assertRegExp($this->rfc2045Token, $line,
                '%s: Encoder should always return a valid RFC 2045 token.');
        }
    }

    public function testEncodingNonAsciiCharactersProducesValidToken()
    {
        $charStream = $this->getMockery('Swift_CharacterStream');

        $string = '';
        foreach (range(0x80, 0xFF) as $octet) {
            $char = pack('C', $octet);
            $string .= $char;
            $charStream->shouldReceive('read')
                       ->once()
                       ->andReturn($char);
        }
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($string);
        $charStream->shouldReceive('read')
                    ->atLeast()->times(1)
                    ->andReturn(false);
        $encoder = new Swift_Encoder_Rfc2231Encoder($charStream);

        $encoded = $encoder->encodeString($string);

        foreach (explode("\r\n", $encoded) as $line) {
            $this->assertRegExp($this->rfc2045Token, $line,
                '%s: Encoder should always return a valid RFC 2045 token.');
        }
    }

    public function testMaximumLineLengthCanBeSet()
    {
        $charStream = $this->getMockery('Swift_CharacterStream');

        $string = '';
        for ($x = 0; $x < 200; ++$x) {
            $char = 'a';
            $string .= $char;
            $charStream->shouldReceive('read')
                       ->once()
                       ->andReturn($char);
        }
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($string);
        $charStream->shouldReceive('read')
                    ->atLeast()->times(1)
                    ->andReturn(false);
        $encoder = new Swift_Encoder_Rfc2231Encoder($charStream);

        $encoded = $encoder->encodeString($string, 0, 75);

        $this->assertEquals(
            str_repeat('a', 75)."\r\n".
            str_repeat('a', 75)."\r\n".
            str_repeat('a', 50),
            $encoded,
            '%s: Lines should be wrapped at each 75 characters'
            );
    }

    public function testFirstLineCanHaveShorterLength()
    {
        $charStream = $this->getMockery('Swift_CharacterStream');

        $string = '';
        for ($x = 0; $x < 200; ++$x) {
            $char = 'a';
            $string .= $char;
            $charStream->shouldReceive('read')
                       ->once()
                       ->andReturn($char);
        }
        $charStream->shouldReceive('flushContents')
                    ->once();
        $charStream->shouldReceive('importString')
                    ->once()
                    ->with($string);
        $charStream->shouldReceive('read')
                    ->atLeast()->times(1)
                    ->andReturn(false);
        $encoder = new Swift_Encoder_Rfc2231Encoder($charStream);
        $encoded = $encoder->encodeString($string, 25, 75);

        $this->assertEquals(
            str_repeat('a', 50)."\r\n".
            str_repeat('a', 75)."\r\n".
            str_repeat('a', 75),
            $encoded,
            '%s: First line should be 25 bytes shorter than the others.'
            );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

class Swift_Events_CommandEventTest extends \PHPUnit\Framework\TestCase
{
    public function testCommandCanBeFetchedByGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "FOO\r\n");
        $this->assertEquals("FOO\r\n", $evt->getCommand());
    }

    public function testSuccessCodesCanBeFetchedViaGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "FOO\r\n", [250]);
        $this->assertEquals([250], $evt->getSuccessCodes());
    }

    public function testSourceIsBuffer()
    {
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport, "FOO\r\n");
        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref);
    }

    private function createEvent(Swift_Transport $source, $command, $successCodes = [])
    {
        return new Swift_Events_CommandEvent($source, $command, $successCodes);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

class Swift_Events_EventObjectTest extends \PHPUnit\Framework\TestCase
{
    public function testEventSourceCanBeReturnedViaGetter()
    {
        $source = new stdClass();
        $evt = $this->createEvent($source);
        $ref = $evt->getSource();
        $this->assertEquals($source, $ref);
    }

    public function testEventDoesNotHaveCancelledBubbleWhenNew()
    {
        $source = new stdClass();
        $evt = $this->createEvent($source);
        $this->assertFalse($evt->bubbleCancelled());
    }

    public function testBubbleCanBeCancelledInEvent()
    {
        $source = new stdClass();
        $evt = $this->createEvent($source);
        $evt->cancelBubble();
        $this->assertTrue($evt->bubbleCancelled());
    }

    private function createEvent($source)
    {
        return new Swift_Events_EventObject($source);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

class Swift_Events_ResponseEventTest extends \PHPUnit\Framework\TestCase
{
    public function testResponseCanBeFetchViaGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "250 Ok\r\n", true);
        $this->assertEquals("250 Ok\r\n", $evt->getResponse(),
            '%s: Response should be available via getResponse()'
            );
    }

    public function testResultCanBeFetchedViaGetter()
    {
        $evt = $this->createEvent($this->createTransport(), "250 Ok\r\n", false);
        $this->assertFalse($evt->isValid(),
            '%s: Result should be checkable via isValid()'
            );
    }

    public function testSourceIsBuffer()
    {
        $transport = $this->createTransport();
        $evt = $this->createEvent($transport, "250 Ok\r\n", true);
        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref);
    }

    private function createEvent(Swift_Transport $source, $response, $result)
    {
        return new Swift_Events_ResponseEvent($source, $response, $result);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

class Swift_Events_SendEventTest extends \PHPUnit\Framework\TestCase
{
    public function testMessageCanBeFetchedViaGetter()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $ref = $evt->getMessage();
        $this->assertEquals($message, $ref,
            '%s: Message should be returned from getMessage()'
            );
    }

    public function testTransportCanBeFetchViaGetter()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $ref = $evt->getTransport();
        $this->assertEquals($transport, $ref,
            '%s: Transport should be returned from getTransport()'
            );
    }

    public function testTransportCanBeFetchViaGetSource()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $ref = $evt->getSource();
        $this->assertEquals($transport, $ref,
            '%s: Transport should be returned from getSource()'
            );
    }

    public function testResultCanBeSetAndGet()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $evt->setResult(
            Swift_Events_SendEvent::RESULT_SUCCESS | Swift_Events_SendEvent::RESULT_TENTATIVE
            );

        $this->assertTrue((bool) ($evt->getResult() & Swift_Events_SendEvent::RESULT_SUCCESS));
        $this->assertTrue((bool) ($evt->getResult() & Swift_Events_SendEvent::RESULT_TENTATIVE));
    }

    public function testFailedRecipientsCanBeSetAndGet()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);

        $evt->setFailedRecipients(['foo@bar', 'zip@button']);

        $this->assertEquals(['foo@bar', 'zip@button'], $evt->getFailedRecipients(),
            '%s: FailedRecipients should be returned from getter'
            );
    }

    public function testFailedRecipientsGetsPickedUpCorrectly()
    {
        $message = $this->createMessage();
        $transport = $this->createTransport();

        $evt = $this->createEvent($transport, $message);
        $this->assertEquals([], $evt->getFailedRecipients());
    }

    private function createEvent(Swift_Transport $source, Swift_Mime_SimpleMessage $message)
    {
        return new Swift_Events_SendEvent($source, $message);
    }

    private function createTransport()
    {
        return $this->getMockBuilder('Swift_Transport')->getMock();
    }

    private function createMessage()
    {
        return $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

class Swift_Events_SimpleEventDispatcherTest extends \PHPUnit\Framework\TestCase
{
    private $dispatcher;

    protected function setUp()
    {
        $this->dispatcher = new Swift_Events_SimpleEventDispatcher();
    }

    public function testSendEventCanBeCreated()
    {
        $transport = $this->getMockBuilder('Swift_Transport')->getMock();
        $message = $this->getMockBuilder('Swift_Mime_SimpleMessage')->disableOriginalConstructor()->getMock();
        $evt = $this->dispatcher->createSendEvent($transport, $message);
        $this->assertInstanceOf('Swift_Events_SendEvent', $evt);
        $this->assertSame($message, $evt->getMessage());
        $this->assertSame($transport, $evt->getTransport());
    }

    public function testCommandEventCanBeCreated()
    {
        $buf = $this->getMockBuilder('Swift_Transport')->getMock();
        $evt = $this->dispatcher->createCommandEvent($buf, "FOO\r\n", [250]);
        $this->assertInstanceOf('Swift_Events_CommandEvent', $evt);
        $this->assertSame($buf, $evt->getSource());
        $this->assertEquals("FOO\r\n", $evt->getCommand());
        $this->assertEquals([250], $evt->getSuccessCodes());
    }

    public function testResponseEventCanBeCreated()
    {
        $buf = $this->getMockBuilder