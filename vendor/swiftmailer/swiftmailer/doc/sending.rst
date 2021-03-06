         fclose($this->reader);
            $this->reader = null;
        }
    }

    /** Check if ReadOnly Stream is seekable */
    private function getReadStreamSeekableStatus()
    {
        $metas = stream_get_meta_data($this->reader);
        $this->seekable = $metas['seekable'];
    }

    /** Streams in a readOnly stream ensuring copy if needed */
    private function seekReadStreamToPosition($offset)
    {
        if (null === $this->seekable) {
            $this->getReadStreamSeekableStatus();
        }
        if (false === $this->seekable) {
            $currentPos = ftell($this->reader);
            if ($currentPos < $offset) {
                $toDiscard = $offset - $currentPos;
                fread($this->reader, $toDiscard);

                return;
            }
            $this->copyReadStream();
        }
        fseek($this->reader, $offset, SEEK_SET);
    }

    /** Copy a readOnly Stream to ensure seekability */
    private function copyReadStream()
    {
        if ($tmpFile = fopen('php://temp/maxmemory:4096', 'w+b')) {
            /* We have opened a php:// Stream Should work without problem */
        } elseif (function_exists('sys_get_temp_dir') && is_writable(sys_get_temp_dir()) && ($tmpFile = tmpfile())) {
            /* We have opened a tmpfile */
        } else {
            throw new Swift_IoException('Unable to copy the file to make it seekable, sys_temp_dir is not writable, php://memory not available');
        }
        $currentPos = ftell($this->reader);
        fclose($this->reader);
        $source = fopen($this->path, 'rb');
        if (!$source) {
            throw new Swift_IoException('Unable to open file for copying ['.$this->path.']');
        }
        fseek($tmpFile, 0, SEEK_SET);
        while (!feof($source)) {
            fwrite($tmpFile, fread($source, 4096));
        }
        fseek($tmpFile, $currentPos, SEEK_SET);
        fclose($source);
        $this->reader = $tmpFile;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
* This file is part of SwiftMailer.
* (c) 2004-2009 Chris Corbyn
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

/**
 * @author Romain-Geissler
 */
class Swift_ByteStream_TemporaryFileByteStream extends Swift_ByteStream_FileByteStream
{
    public function __construct()
    {
        $filePath = tempnam(sys_get_temp_dir(), 'FileByteStream');

        if (false === $filePath) {
            throw new Swift_IoException('Failed to retrieve temporary file name.');
        }

        parent::__construct($filePath, true);
    }

    public function getContent()
    {
        if (false === ($content = file_get_contents($this->getPath()))) {
            throw new Swift_IoException('Failed to get temporary file content.');
        }

        return $content;
    }

    public function __destruct()
    {
        if (file_exists($this->getPath())) {
            @unlink($this->getPath());
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Provides fixed-width byte sizes for reading fixed-width character sets.
 *
 * @author     Chris Corbyn
 * @author     Xavier De Cock <xdecock@gmail.com>
 */
class Swift_CharacterReader_GenericFixedWidthReader implements Swift_CharacterReader
{
    /**
     * The number of bytes in a single character.
     *
     * @var int
     */
    private $width;

    /**
     * Creates a new GenericFixedWidthReader using $width bytes per character.
     *
     * @param int $width
     */
    public function __construct($width)
    {
        $this->width = $width;
    }

    /**
     * Returns the complete character map.
     *
     * @param string $string
     * @param int    $startOffset
     * @param array  $currentMap
     * @param mixed  $ignoredChars
     *
     * @return int
     */
    public function getCharPositions($string, $startOffset, &$currentMap, &$ignoredChars)
    {
        $strlen = strlen($string);
        // % and / are CPU intensive, so, maybe find a better way
        $ignored = $strlen % $this->width;
        $ignoredChars = $ignored ? substr($string, -$ignored) : '';
        $currentMap = $this->width;

        return ($strlen - $ignored) / $this->width;
    }

    /**
     * Returns the mapType.
     *
     * @return int
     */
    public function getMapType()
    {
        return self::MAP_TYPE_FIXED_LEN;
    }

    /**
     * Returns an integer which specifies how many more bytes to read.
     *
     * A positive integer indicates the number of more bytes to fetch before invoking
     * this method again.
     *
     * A value of zero means this is already a valid character.
     * A value of -1 means this cannot possibly be a valid character.
     *
     * @param string $bytes
     * @param int    $size
     *
     * @return int
     */
    public function validateByteSequence($bytes, $size)
    {
        $needed = $this->width - $size;

        return $needed > -1 ? $needed : -1;
    }

    /**
     * Returns the number of bytes which should be read to start each character.
     *
     * @return int
     */
    public function getInitialByteSize()
    {
        return $this->width;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Analyzes US-ASCII characters.
 *
 * @author Chris Corbyn
 */
class Swift_CharacterReader_UsAsciiReader implements Swift_CharacterReader
{
    /**
     * Returns the complete character map.
     *
     * @param string $string
     * @param int    $startOffset
     * @param array  $currentMap
     * @param string $ignoredChars
     *
     * @return int
     */
    public function getCharPositions($string, $startOffset, &$currentMap, &$ignoredChars)
    {
        $strlen = strlen($string);
        $ignoredChars = '';
        for ($i = 0; $i < $strlen; ++$i) {
            if ($string[$i] > "\x07F") {
                // Invalid char
                $currentMap[$i + $startOffset] = $string[$i];
            }
        }

        return $strlen;
    }

    /**
     * Returns mapType.
     *
     * @return int mapType
     */
    public function getMapType()
    {
        return self::MAP_TYPE_INVALID;
    }

    /**
     * Returns an integer which specifies how many more bytes to read.
     *
     * A positive integer indicates the number of more bytes to fetch before invoking
     * this method again.
     * A value of zero means this is already a valid character.
     * A value of -1 means this cannot possibly be a valid character.
     *
     * @param string $bytes
     * @param int    $size
     *
     * @return int
     */
    public function validateByteSequence($bytes, $size)
    {
        $byte = reset($bytes);
        if (1 == count($bytes) && $byte >= 0x00 && $byte <= 0x7F) {
            return 0;
        }

        return -1;
    }

    /**
     * Returns the number of bytes which should be read to start each character.
     *
     * @return int
     */
    public function getInitialByteSize()
    {
        return 1;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Analyzes UTF-8 characters.
 *
 * @author Chris Corbyn
 * @author Xavier De Cock <xdecock@gmail.com>
 */
class Swift_CharacterReader_Utf8Reader implements Swift_CharacterReader
{
    /** Pre-computed for optimization */
    private static $length_map = [
        // N=0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,
        1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 