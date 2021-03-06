<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles Base 64 Transfer Encoding in Swift Mailer.
 *
 * @author Chris Corbyn
 */
class Swift_Mime_ContentEncoder_Base64ContentEncoder extends Swift_Encoder_Base64Encoder implements Swift_Mime_ContentEncoder
{
    /**
     * Encode stream $in to stream $out.
     *
     * @param int $firstLineOffset
     */
    public function encodeByteStream(Swift_OutputByteStream $os, Swift_InputByteStream $is, $firstLineOffset = 0, $maxLineLength = 0)
    {
        if (0 >= $maxLineLength || 76 < $maxLineLength) {
            $maxLineLength = 76;
        }

        $remainder = 0;
        $base64ReadBufferRemainderBytes = null;

        // To reduce memory usage, the output buffer is streamed to the input buffer like so:
        //   Output Stream => base64encode => wrap line length => Input Stream
        // HOWEVER it's important to note that base64_encode() should only be passed whole triplets of data (except for the final chunk of data)
        // otherwise it will assume the input data has *ended* and it will incorrectly pad/terminate the base64 data mid-stream.
        // We use $base64ReadBufferRemainderBytes to carry over 1-2 "remainder" bytes from the each chunk from OutputStream and pre-pend those onto the
        // chunk of bytes read in the next iteration.
        // When the OutputStream is empty, we must flush any remainder bytes.
        while (true) {
            $readBytes = $os->read(8192);
            $atEOF = (false === $readBytes);

            if ($atEOF) {
                $streamTheseBytes = $base64ReadBufferRemainderBytes;
            } else {
                $streamTheseBytes = $base64ReadBufferRemainderBytes.$readBytes;
            }
            $base64ReadBufferRemainderBytes = null;
            $bytesLength = strlen($streamTheseBytes);

            if (0 === $bytesLength) { // no data left to encode
                break;
            }

            // if we're not on the last block of the ouput stream, make sure $streamTheseBytes ends with a complete triplet of data
            // and carry over remainder 1-2 bytes to the next loop iteration
            if (!$atEOF) {
                $excessBytes = $bytesLength % 3;
                if (0 !== $excessBytes) {
                    $base64ReadBufferRemainderBytes = substr($streamTheseBytes, -$excessBytes);
                    $streamTheseBytes = substr($streamTheseBytes, 0, $bytesLength - $excessBytes);
                }
            }

            $encoded = base64_encode($streamTheseBytes);
            $encodedTransformed = '';
            $thisMaxLineLength = $maxLineLength - $remainder - $firstLineOffset;

            while ($thisMaxLineLength < strlen($encoded)) {
                $encodedTransformed .= substr($encoded, 0, $thisMaxLineLength)."\r\n";
                $firstLineOffset = 0;
                $encoded = substr($encoded, $thisMaxLineLength);
                $thisMaxLineLength = $maxLineLength;
                $remainder = 0;
            }

            if (0 < $remainingLength = strlen($encoded)) {
                $remainder += $remainingLength;
                $encodedTransformed .= $encoded;
                $encoded = null;
            }

            $is->write($encodedTransformed);

            if ($atEOF) {
                break;
            }
        }
    }

    /**
     * Get the name of this encoding scheme.
     * Returns the string 'base64'.
     *
     * @return string
     */
    public function getName()
    {
        return 'base64';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles Quoted Printable (QP) Transfer Encoding in Swift Mailer using the PHP core function.
 *
 * @author Lars Strojny
 */
class Swift_Mime_ContentEncoder_NativeQpContentEncoder implements Swift_Mime_ContentEncoder
{
    /**
     * @var null|string
     */
    private $charset;

    /**
     * @param null|string $charset
     */
    public function __construct($charset = null)
    {
        $this->charset = $charset ? $charset : 'utf-8';
    }

    /**
     * Notify this observer that the entity's charset has changed.
     *
     * @param string $charset
     */
    public function charsetChanged($charset)
    {
        $this->charset = $charset;
    }

    /**
     * Encode $in to $out.
     *
     * @param Swift_OutputByteStream $os              to read from
     * @param Swift_InputByteStream  $is              to write to
     * @param int                    $firstLineOffset
     * @param int                    $maxLineLength   0 indicates the default length for this encoding
     *
     * @throws RuntimeException
     */
    public function encodeByteStream(Swift_OutputByteStream $os, Swift_InputByteStream $is, $firstLineOffset = 0, $maxLineLength = 0)
    {
        if ('utf-8' !== $this->charset) {
            throw new RuntimeException(
                sprintf('Charset "%s" not supported. NativeQpContentEncoder only supports "utf-8"', $this->charset));
        }

        $string = '';

        while (false !== $bytes = $os->read(8192)) {
            $string .= $bytes;
        }

        $is->write($this->encodeString($string));
    }

    /**
     * Get the MIME name of this content encoding scheme.
     *
     * @return string
     */
    public function getName()
    {
        return 'quoted-printable';
    }

    /**
     * Encode a given string to produce an encoded string.
     *
     * @param string $string
     * @param int    $firstLineOffset if first line needs to be shorter
     * @param int    $maxLineLength   0 indicates the default length for this encoding
     *
     * @throws RuntimeException
     *
     * @return string
     */
    public function encodeString($string, $firstLineOffset = 0, $maxLineLength = 0)
    {
        if ('utf-8' !== $this->charset) {
            throw new RuntimeException(
                sprintf('Charset "%s" not supported. NativeQpContentEncoder only supports "utf-8"', $this->charset));
        }

        return $this->standardize(quoted_printable_encode($string));
    }

    /**
     * Make sure CRLF is correct and HT/SPACE are in valid places.
     *
     * @param string $string
     *
     * @return string
     */
    protected function standardize($string)
    {
        // transform CR or LF to CRLF
        $string = preg_replace('~=0D(?!=0A)|(?<!=0D)=0A~', '=0D=0A', $string);
        // transform =0D=0A to CRLF
        $string = str_replace(["\t=0D=0A", ' =0D=0A', '=0D=0A'], ["=09\r\n", "=20\r\n", "\r\n"], $string);

        switch (ord(substr($string, -1))) {
            case 0x09:
                $string = substr_replace($string, '=09', -1);
                break;
            case 0x20:
                $string = substr_replace($string, '=20', -1);
                break;
        }

        return $string;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
