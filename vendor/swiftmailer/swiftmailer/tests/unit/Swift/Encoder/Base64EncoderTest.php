        $encoder = $this->getEncoder('7bit', true);

        $os = $this->createOutputByteStream();
        $is = $this->createInputByteStream();
        $collection = new Swift_StreamCollector();

        $is->shouldReceive('write')
           ->zeroOrMoreTimes()
           ->andReturnUsing($collection);
        $os->shouldReceive('read')
           ->once()
           ->andReturn('a');
        $os->shouldReceive('read')
           ->once()
           ->andReturn($test);
        $os->shouldReceive('read')
           ->once()
           ->andReturn('b');
        $os->shouldReceive('read')
           ->zeroOrMoreTimes()
           ->andReturn(false);

        $encoder->encodeByteStream($os, $is);
        $this->assertEquals($expected, $collection->content);
    }

    private function getEncoder($name, $canonical = false)
    {
        return new Swift_Mime_ContentEncoder_PlainContentEncoder($name, $canonical);
    }

    private function createOutputByteStream($stub = false)
    {
        return $this->getMockery('Swift_OutputByteStream')->shouldIgnoreMissing();
    }

    private function createInputByteStream($stub = false)
    {
        return $this->getMockery('Swift_InputByteStream')->shouldIgnoreMissing();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

class Swift_Mime_ContentEncoder_QpContentEncoderTest extends \SwiftMailerTestCase
{
    public function testNameIsQuotedPrintable()
    {
        $encoder = new Swift_Mime_ContentEncoder_QpContentEncoder(
            $this->createCharacterStream(true)
            );
        $this->assertEquals('quoted-printable', $encoder->getName());
    }

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

            $os = $this->createOutputByteStream(true);
            $charStream = $this->createCharacterStream();
            $is = $this->createInputByteStream();
            $collection = new Swift_StreamCollector();

            $is->shouldReceive('write')
               ->zeroOrMoreTimes()
               ->andReturnUsing($collection);
            $charStream->shouldR