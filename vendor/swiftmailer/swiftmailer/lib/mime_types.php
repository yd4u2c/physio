 */
    public function getInitialByteSize()
    {
        return 1;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Standard factory for creating CharacterReaders.
 *
 * @author Chris Corbyn
 */
class Swift_CharacterReaderFactory_SimpleCharacterReaderFactory implements Swift_CharacterReaderFactory
{
    /**
     * A map of charset patterns to their implementation classes.
     *
     * @var array
     */
    private static $map = [];

    /**
     * Factories which have already been loaded.
     *
     * @var Swift_CharacterReaderFactory[]
     */
    private static $loaded = [];

    /**
     * Creates a new CharacterReaderFactory.
     */
    public function __construct()
    {
        $this->init();
    }

    public function __wakeup()
    {
        $this->init();
    }

    public function init()
    {
        if (count(self::$map) > 0) {
            return;
        }

        $prefix = 'Swift_CharacterReader_';

        $singleByte = [
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => [1],
            ];

        $doubleByte = [
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => [2],
            ];

        $fourBytes = [
            'class' => $prefix.'GenericFixedWidthReader',
            'constructor' => [4],
            ];

        // Utf-8
        self::$map['utf-?8'] = [
            'class' => $prefix.'Utf8Reader',
            'constructor' => [],
            ];

        //7-8 bit charsets
        self::$map['(us-)?ascii'] = $singleByte;
        self::$map['(iso|iec)-?8859-?[0-9]+'] = $singleByte;
        self::$map['windows-?125[0-9]'] = $singleByte;
        self::$map['cp-?[0-9]+'] = $singleByte;
        self::$map['ansi'] = $singleByte;
        self::$map['macintosh'] = $singleByte;
        self::$map['koi-?7'] = $singleByte;
        self::$map['koi-?8-?.+'] = $singleByte;
        self::$map['mik'] = $singleByte;
        self::$map['(cork|t1)'] = $singleByte;
        self::$map['v?iscii'] = $singleByte;

        //16 bits
        self::$map['(ucs-?2|utf-?16)'] = $doubleByte;

        //32 bits
        self::$map['(ucs-?4|utf-?32)'] = $fourBytes;

        // Fallback
        self::$map['.*'] = $singleByte;
    }

    /**
     * Returns a CharacterReader suitable for the charset applied.
     *
     * @param string $charset
     *
     * @return Swift_CharacterReader
     */
    public function getReaderFor($charset)
    {
        $charset = strtolower(trim($charset));
        foreach (self::$map as $pattern => $spec) {
            $re = '/^'.$pattern.'$/D';
            if (preg_match($re, $charset)) {
                if (!array_key_exists($pattern, self::$loaded)) {
                    $reflector = new ReflectionClass($spec['class']);
                    if ($reflector->getConstructor()) {
                        $reader = $reflector->newInstanceArgs($spec['constructor']);
                    } else {
                        $reader = $reflector->newInstance();
                    }
                    self::$loaded[$pattern] = $reader;
                }

                return self::$loaded[$pattern];
            }
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A CharacterStream implementation which stores characters in an internal array.
 *
 * @author Chris Corbyn
 */
class Swift_CharacterStream_ArrayCharacterStream implements Swift_CharacterStream
{
    /** A map of byte values and their respective characters */
    private static $charMap;

    /** A map of characters and their derivative byte values */
    private static $byteMap;

    /** The char reader (lazy-loaded) for the current charset */
    private $charReader;

    /** A factory for creating CharacterReader instances */
    private $charReaderFactory;

    /** The character set this stream is using */
    private $charset;

    /** Array of characters */
    private $array = [];

    /** Size of the array of character */
    private $array_size = [];

    /** The current character offset in the stream */
    private $offset = 0;

    /**
     * Create a new CharacterStream with the given $chars, if set.
     *
     * @param Swift_CharacterReaderFactory $factory for loading validators
     * @param string                       $charset used in the stream
     */
    public function __construct(Swift_CharacterReaderFactory $factory, $charset)
    {
        self::initializeMaps();
        $this->setCharacterReaderFactory($factory);
        $this->setCharacterSet($charset);
    }

    /**
     * Set the character set used in this CharacterStream.
     *
     * @param string $charset
     */
    public function setCharacterSet($charset)
    {
        $this->charset = $charset;
        $this->charReader = null;
    }

    /**
     * Set the CharacterReaderFactory for multi charset support.
     */
    public function setCharacterReaderFactory(Swift_CharacterReaderFactory $factory)
    {
        $this->charReaderFactory = $factory;
    }

    /**
     * Overwrite this character stream using the byte sequence in the byte stream.
     *
     * @param Swift_OutputByteStream $os output stream to read from
     */
    public function importByteStream(Swift_OutputByteStream $os)
    {
        if (!isset($this->charReader)) {
            $this->charReader = $this->charReaderFactory
                ->getReaderFor($this->charset);
        }

        $startLength = $this->charReader->getInitialByteSize();
        while (false !== $bytes = $os->read($startLength)) {
            $c = [];
            for ($i = 0, $len = strlen($bytes); $i < $len; ++$i) {
                $c[] = self::$byteMap[$bytes[$i]];
            }
            $size = count($c);
            $need = $this->charReader
                ->validateByteSequence($c, $size);
            if ($need > 0 &&
                false !== $bytes = $os->read($need)) {
                for ($i = 0, $len = strlen($bytes); $i < $len; ++$i) {
                    $c[] = self::$byteMap[$bytes[$i]];
                }
            }
            $this->array[] = $c;
            ++$this->array_size;
        }
    }

    /**
     * Import a string a bytes into this CharacterStream, overwriting any existing
     * data in the stream.
     *
     * @param string $string
     */
    public function importString($string)
    {
        $this->flushContents();
        $this->write($string);
    }

    /**
     * Read $length characters from the stream and move the internal pointer
     * $length further into the stream.
     *
     * @param int $length
     *
     * @return string
     */
    public function read($length)
    {
        if ($this->offset == $this->array_size) {
            return false;
        }

        // Don't use array slice
        $arrays = [];
        $end = $length + $this->offset;
        for ($i = $this->offset; $i < $end; ++$i) {
            if (!isset($this->array[$i])) {
                break;
            }
            $arrays[] = $this->array[$i];
        }
        $this->offset += $i - $this->offset; // Limit function calls
        $chars = false;
        foreach ($arrays as $array) {
            $chars .= implode('', array_map('chr', $array));
        }

        return $chars;
    }

    /**
     * Read $length characters from the stream and return a 1-dimensional array
     * containing there octet values.
     *
     * @param int $length
     *
     * @return int[]
     */
    public function readBytes($length)
    {
        if ($this->offset == $this->array_size) {
            return false;
        }
        $arrays = [];
        $end = $length + $this->offset;
        for ($i = $this->offset; $i < $end; ++$i) {
            if (!isset($this->array[$i])) {
                break;
            }
            $arrays[] = $this->array[$i];
        }
        $this->offset += ($i - $this->offset); // Limit function calls

        return array_merge(...$arrays);
    }

    /**
     * Write $chars to the end of the stream.
     *
     * @param string $chars
     */
    public function write($chars)
    {
        if (!isset($this->charReader)) {
            $this->charReader = $this->charReaderFactory->getReaderFor(
                $this->charset);
        }

        $startLength = $this->charReader->getInitialByteSize();

        $fp = fopen('php://memory', 'w+b');
        fwrite($fp, $chars);
        unset($chars);
        fseek($fp, 0, SEEK_SET);

        $buffer = [0];
        $buf_pos = 1;
        $buf_len = 1;
        $has_datas = true;
        do {
            $bytes = [];
            // Buffer Filing
            if ($buf_len - $buf_pos < $startLength) {
                $buf = array_splice($buffer, $buf_pos);
                $new = $this->reloadBuffer($fp, 100);
                if ($new) {
                    $buffer = array_merge($buf, $new);
                    $buf_len = count($buffer);
                    $buf_pos = 0;
                } else {
                    $has_datas = false;
                }
            }
            if ($buf_len - $buf_pos > 0) {
                $size = 0;
                for ($i = 0; $i < $startLength && isset($buffer[$buf_pos]); ++$i) {
                    ++$size;
                    $bytes[] = $buffer[$buf_pos++];
                }
                $need = $this->charReader->validateByteSequence(
                    $bytes, $size);
                if ($need > 0) {
                    if ($buf_len - $buf_pos < $need) {
                        $new = $this->reloadBuffer($fp, $need);

                        if ($new) {
                            $buffer = array_merge($buffer, $new);
                            $buf_len = count($buffer);
                        }
                    }
                    for ($i = 0; $i < $need && isset($buffer[$buf_pos]); ++$i) {
                        $bytes[] = $buffer[$buf_pos++];
                    }
                }
                $this->array[] = $bytes;
                ++$this->array_size;
            }
        } while ($has_datas);

        fclose($fp);
    }

    /**
     * Move the internal pointer to $charOffset in the stream.
     *
     * @param int $charOffset
     */
    public function setPointer($charOffset)
    {
        if ($charOffset > $this->array_size) {
            $charOffset = $this->array_size;
        } elseif ($charOffset < 0) {
            $charOffset = 0;
        }
        $this->offset = $charOffset;
    }

    /**
     * Empty the stream and reset the internal pointer.
     */
    public function flushContents()
    {
        $this->offset = 0;
        $this->array = [];
        $this->array_size = 0;
    }

    private function reloadBuffer($fp, $len)
    {
        if (!feof($fp) && false !== ($bytes = fread($fp, $len))) {
            $buf = [];
            for ($i = 0, $len = strlen($bytes); $i < $len; ++$i) {
                $buf[] = self::$byteMap[$bytes[$i]];
            }

            return $buf;
        }

        return false;
    }

    private static function initializeMaps()
    {
        if (!isset(self::$charMap)) {
            self::$charMap = [];
            for ($byte = 0; $byte < 256; ++$byte) {
                self::$charMap[$byte] = chr($byte);
            }
            self::$byteMap = array_flip(self::$charMap);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * A CharacterStream implementation which stores characters in an internal array.
 *
 * @author     Xavier De Cock <xdecock@gmail.com>
 */
class Swift_CharacterStream_NgCharacterStream implements Swift_CharacterStream
{
    /**
     * The char reader (lazy-loaded) for the current charset.
     *
     * @var Swift_CharacterReader
     */
    private $charReader;

    /**
     * A factory for creating CharacterReader instances.
     *
     * @var Swift_CharacterReaderFactory
     */
    private $charReaderFactory;

    /**
     * The character set this stream is using.
     *
     * @var string
     */
    private $charset;

    /**
     * The data's stored as-is.
     *
     * @var string
     */
    private $datas = '';

    /**
     * Number of bytes in the stream.
     *
     * @var int
     */
    private $datasSize = 0;

    /**
     * Map.
     *
     * @var mixed
     */
    private $map;

    /**
     * Map Type.
     *
     * @var int
     */
    private $mapType = 0;

    /**
     * Number of characters in the stream.
     *
     * @var int
     */
    private $charCount = 0;

    /**
     * Position in the stream.
     *
     * @var int
     */
    private $currentPos = 0;

    /**
     * Constructor.
     *
     * @param string $charset
     */
    public function __construct(Swift_CharacterReaderFactory $factory, $charset)
    {
        $this->setCharacterReaderFactory($factory);
        $this->setCharacterSet($charset);
    }

    /* -- Changing parameters of the stream -- */

    /**
     * Set the character set used in this CharacterStream.
     *
     * @param string $charset
     */
    public function setCharacterSet($charset)
    {
        $this->charset = $charset;
        $this->charReader = null;
        $this->mapType = 0;
    }

    /**
     * Set the CharacterReaderFactory for multi charset support.
     */
    public function setCharacterReaderFactory(Swift_CharacterReaderFactory $factory)
    {
        $this->charReaderFactory = $factory;
    }

    /**
     * @see Swift_CharacterStream::flushContents()
     */
    public function flushContents()
    {
        $this->datas = null;
        $this->map = null;
        $this->charCount = 0;
        $this->currentPos = 0;
        $this->datasSize = 0;
    }

    /**
     * @see Swift_CharacterStream::importByteStream()
     */
    public function importByteStream(Swift_OutputByteStream $os)
    {
        $this->flushContents();
        $blocks = 512;
        $os->setReadPointer(0);
        while (false !== ($read = $os->read($blocks))) {
            $this->write($read);
        }
    }

    /**
     * @see Swift_CharacterStream::importString()
     *
     * @param string $string
     */
    public function importString($string)
    {
        $this->flushContents();
        $this->write($string);
    }

    /**
     * @see Swift_CharacterStream::read()
     *
     * @param int $length
     *
     * @return string
     */
    public function read($length)
    {
        if ($this->currentPos >= $this->charCount) {
            return false;
        }
        $ret = false;
        $length = ($this->currentPos + $length > $this->charCount) ? $this->charCount - $this->currentPos : $length;
        switch ($this->mapType) {
            case Swift_CharacterReader::MAP_TYPE_FIXED_LEN:
                $len = $length * $this->map;
                $ret = substr($this->datas,
                        $this->currentPos * $this->map,
                        $len);
                $this->currentPos += $length;
                break;

            case Swift_CharacterReader::MAP_TYPE_INVALID:
                $ret = '';
                for (; $this->currentPos < $length; ++$this->currentPos) {
                    if (isset($this->map[$this->currentPos])) {
                        $ret .= '?';
                    } else {
                        $ret .= $this->datas[$this->currentPos];
                    }
                }
                break;

            case Swift_CharacterReader::MAP_TYPE_POSITIONS:
                $end = $this->currentPos + $length;
                $end = $end > $this->charCount ? $this->charCount : $end;
                $ret = '';
                $start = 0;
                if ($this->currentPos > 0) {
                    $start = $this->map['p'][$this->currentPos - 1];
                }
                $to = $start;
                for (; $this->currentPos < $end; ++$this->currentPos) {
                    if (isset($this->map['i'][$this->currentPos])) {
                        $ret .= substr($this->datas, $start, $to - $start).'?';
                        $start = $this->map['p'][$this->currentPos];
                    } else {
                        $to = $this->map['p'][$this->currentPos];
                    }
                }
                $ret .= substr($this->datas, $start, $to - $start);
                break;
        }

        return $ret;
    }

    /**
     * @see Swift_CharacterStream::readBytes()
     *
     * @param int $length
     *
     * @return int[]
     */
    public function readBytes($length)
    {
        $read = $this->read($length);
        if (false !== $read) {
            $ret = array_map('ord', str_split($read, 1));

            return $ret;
        }

        return false;
    }

    /**
     * @see Swift_CharacterStream::setPointer()
     *
     * @param int $charOffset
     */
    public function setPointer($charOffset)
    {
        if ($this->charCount < $charOffset) {
            $charOffset = $this->charCount;
        }
        $this->currentPos = $charOffset;
    }

    /**
     * @see Swift_CharacterStream::write()
     *
     * @param string $chars
     */
    public function write($chars)
    {
        if (!isset($this->charReader)) {
            $this->charReader = $this->charReaderFactory->getReaderFor(
                $this->charset);
            $this->map = [];
            $this->mapType = $this->charReader->getMapType();
        }
        $ignored = '';
        $this->datas .= $chars;
        $this->charCount += $this->charReader->getCharPositions(substr($this->datas, $this->datasSize), $this->datasSize, $this->map, $ignored);
        if (false !== $ignored) {
            $this->datasSize = strlen($this->datas) - strlen($ignored);
        } else {
            $this->datasSize = strlen($this->datas);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles Base 64 Encoding in Swift Mailer.
 *
 * @author Chris Corbyn
 */
class Swift_Encoder_Base64Encoder implements Swift_Encoder
{
    /**
     * Takes an unencoded string and produces a Base64 encoded string from it.
     *
     * Base64 encoded strings have a maximum line length of 76 characters.
     * If the first line needs to be shorter, indicate the difference with
     * $firstLineOffset.
     *
     * @param string $string          to encode
     * @param int    $firstLineOffset
     * @param int    $maxLineLength   optional, 0 indicates the default of 76 bytes
     *
     * @return string
     */
    public function encodeString($string, $firstLineOffset = 0, $maxLineLength = 0)
    {
        if (0 >= $maxLineLength || 76 < $maxLineLength) {
            $maxLineLength = 76;
        }

        $encodedString = base64_encode($string);
        $firstLine = '';

        if (0 != $firstLineOffset) {
            $firstLine = substr(
                $encodedString, 0, $maxLineLength - $firstLineOffset
                )."\r\n";
            $encodedString = substr(
                $encodedString, $maxLineLength - $firstLineOffset
                );
        }

        return $firstLine.trim(chunk_split($encodedString, $maxLineLength, "\r\n"));
    }

    /**
     * Does nothing.
     */
    public function charsetChanged($charset)
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Handles Quoted Printable (QP) Encoding in Swift Mailer.
 *
 * Possibly the most accurate RFC 2045 QP implementation found in PHP.
 *
 * @author     Chris Corbyn
 */
class Swift_Encoder_QpEncoder implements Swift_Encoder
{
    /**
     * The CharacterStream used for reading characters (as opposed to bytes).
     *
     * @var Swift_CharacterStream
     */
    protected $charStream;

    /**
     * A filter used if input should be canonicalized.
     *
     * @var Swift_StreamFilter
     */
    protected $filter;

    /**
     * Pre-computed QP for HUGE optimization.
     *
     * @var string[]
     */
    protected static $qpMap = [
        0 => '=00', 1 => '=01', 2 => '=02', 3 => '=03', 4 => '=04',
        5 => '=05', 6 => '=06', 7 => '=07', 8 => '=08', 9 => '=09',
        10 => '=0A', 11 => '=0B', 12 => '=0C', 13 => '=0D', 14 => '=0E',
        15 => '=0F', 16 => '=10', 17 => '=11', 18 => '=12', 19 => '=13',
        20 => '=14', 21 => '=15', 22 => '=16', 23 => '=17', 24 => '=18',
        25 => '=19', 26 => '=1A', 27 => '=1B', 28 => '=1C', 29 => '=1D',
        30 => '=1E', 31 => '=1F', 32 => '=20', 33 => '=21', 34 => '=22',
        35 => '=23', 36 => '=24', 37 => '=25', 38 => '=26', 39 => '=27',
        40 => '=28', 41 => '=29', 42 => '=2A', 43 => '=2B', 44 => '=2C',
        45 => '=2D', 46 => '=2E', 47 => '=2F', 48 => '=30', 49 => '=31',
        50 => '=32', 51 => '=33', 52 => '=34', 53 => '=35', 54 => '=36',
        55 => '=37', 56 => '=38', 57 => '=39', 58 => '=3A', 59 => '=3B',
        60 => '=3C', 61 => '=3D', 62 => '=3E', 63 => '=3F', 64 => '=40',
        65 => '=41', 66 => '=42', 67 => '=43', 68 => '=44', 69 => '=45',
        70 => '=46', 71 => '=47', 72 => '=48', 73 => '=49', 74 => '=4A',
        75 => '=4B', 76 => '=4C', 77 => '=4D', 78 => '=4E', 79 => '=4F',
        80 => '=50', 81 => '=51', 82 => '=52', 83 => '=53', 84 => '=54',
        85 => '=55', 86 => '=56', 87 => '=57', 88 => '=58', 89 => '=59',
        90 => '=5A', 91 => '=5B', 92 => '=5C', 93 => '=5D', 94 => '=5E',
        95 => '=5F', 96 => '=60', 97 => '=61', 98 => '=62', 99 => '=63',
        100 => '=64', 101 => '=65', 102 => '=66', 103 => '=67', 104 => '=68',
        105 => '=69', 106 => '=6A', 107 => '=6B', 108 => '=6C', 109 => '=6D',
        110 => '=6E', 111 => '=6F', 112 => '=70', 113 => '=71', 114 => '=72',
        115 => '=73', 116 => '=74', 117 => '=75', 118 => '=76', 119 => '=77',
        120 => '=78', 121 => '=79', 122 => '=7A', 123 => '=7B', 124 => '=7C',
        125 => '=7D', 126 => '=7E', 127 => '=7F', 128 => '=80', 129 => '=81',
        130 => '=82', 131 => '=83', 132 => '=84', 133 => '=85', 134 => '=86',
        135 => '=87', 136 => '=88', 137 => '=89', 138 => '=8A', 139 => '=8B',
        140 => '=8C', 141 => '=8D', 142 => '=8E', 143 => '=8F', 144 => '=90',
        145 => '=91', 146 => '=92', 147 => '=93', 148 => '=94', 149 => '=95',
        150 => '=96', 151 => '=97', 152 => '=98', 153 => '=99', 154 => '=9A',
        155 => '=9B', 156 => '=9C', 157 => '=9D', 158 => '=9E', 159 => '=9F',
        160 => '=A0', 161 => '=A1', 162 => '=A2', 163 => '=A3', 164 => '=A4',
        165 => '=A5', 166 => '=A6', 167 => '=A7', 168 => '=A8', 169 => '=A9',
        170 => '=AA', 171 => '=AB', 172 => '=AC', 173 => '=AD', 174 => '=AE',
        175 => '=AF', 176 => '=B0', 177 => '=B1', 178 => '=B2', 179 => '=B3',
        180 => '=B4', 181 => '=B5', 182 => '=B6', 183 => '=B7', 184 => '=B8',
        185 => '=B9', 186 => '=BA', 187 => '=BB', 188 => '=BC', 189 => '=BD',
        190 => '=BE', 191 => '=BF', 192 => '=C0', 193 => '=C1', 194 => '=C2',
        195 => '=C3', 196 => '=C4', 197 => '=C5', 198 => '=C6', 199 => '=C7',
        200 => '=C8', 201 => '=C9', 202 => '=CA', 203 => '=CB', 204 => '=CC',
        205 => '=CD', 206 => '=CE', 207 => '=CF', 208 => '=D0', 209 => '=D1',
        210 => '=D2', 211 => '=D3', 212 => '=D4', 213 => '=D5', 214 => '=D6',
        215 => '=D7', 216 => '=D8', 217 => '=D9', 218 => '=DA', 219 => '=DB',
        220 => '=DC', 221 => '=DD', 222 => '=DE', 223 => '=DF', 224 => '=E0',
        225 => '=E1', 226 => '=E2', 227 => '=E3', 228 => '=E4', 229 => '=E5',
        230 => '=E6', 231 => '=E7', 232 => '=E8', 233 => '=E9', 234 => '=EA',
        235 => '=EB', 236 => '=EC', 237 => '=ED', 238 => '=EE', 239 => '=EF',
        240 => '=F0', 241 => '=F1', 242 => '=F2', 243 => '=F3', 244 => '=F4',
        245 => '=F5', 246 => '=F6', 247 => '=F7', 248 => '=F8', 249 => '=F9',
        250 => '=FA', 251 => '=FB', 252 => '=FC', 253 => '=FD', 254 => '=FE',
        255 => '=FF',
        ];

    protected static $safeMapShare = [];

    /**
     * A map of non-encoded ascii characters.
     *
     * @var string[]
     */
    protected $safeMap = [];

    /**
     * Creates a new QpEncoder for the given CharacterStream.
     *
     * @param Swift_CharacterStream $charStream to use for reading characters
     * @param Swift_StreamFilter    $filter     if input should be canonicalized
     */
    public function __construct(Swift_CharacterStream $charStream, Swift_StreamFilter $filter = null)
    {
        $this->charStream = $charStream;
        if (!isset(self::$safeMapShare[$this->getSafeMapShareId()])) {
            $this->initSafeMap();
            self::$safeMapShare[$this->getSafeMapShareId()] = $this->safeMap;
        } else {
            $this->safeMap = self::$safeMapShare[$this->getSafeMapShareId()];
        }
        $this->filter = $filter;
    }

    public function __sleep()
    {
        return ['charStream', 'filter'];
    }

    public function __wakeup()
    {
        if (!isset(self::$safeMapShare[$this->getSafeMapShareId()])) {
            $this->initSafeMap();
            self::$safeMapShare[$this->getSafeMapShareId()] = $this->safeMap;
        } else {
            $this->safeMap = self::$safeMapShare[$this->getSafeMapShareId()];
        }
    }

    protected function getSafeMapShareId()
    {
        return get_class($this);
    }

    protected function initSafeMap()
    {
        foreach (array_merge(
            [0x09, 0x20], range(0x21, 0x3C), range(0x3E, 0x7E)) as $byte) {
            $this->safeMap[$byte] = chr($byte);
        }
    }

    /**
     * Takes an unencoded string and produces a QP encoded string from it.
     *
     * QP encoded strings have a maximum line length of 76 characters.
     * If the first line needs to be shorter, indicate the difference with
     * $firstLineOffset.
     *
     * @param string $string          to encode
     * @param int    $firstLineOffset optional
     * @param int    $maxLineLength   optional 0 indicates the default of 76 chars
     *
     * @return string
     */
    public function encodeString($string, $firstLineOffset = 0, $maxLineLength = 0)
    {
        if ($maxLineLength > 76 || $maxLineLength <= 0) {
            $maxLineLength = 76;
        }

        $thisLineLength = $maxLineLength - $firstLineOffset;

        $lines = [];
        $lNo = 0;
        $lines[$lNo] = '';
        $currentLine = &$lines[$lNo++];
        $size = $lineLen = 0;

        $this->charStream->flushContents();
        $this->charStream->importString($string);

        // Fetching more than 4 chars at one is slower, as is fetching fewer bytes
        // Conveniently 4 chars is the UTF-8 safe number since UTF-8 has up to 6
        // bytes per char and (6 * 4 * 3 = 72 chars per line) * =NN is 3 bytes
        while (false !== $bytes = $this->nextSequence()) {
            // If we're filtering the input
            if (isset($this->filter)) {
                // If we can't filter because we need more bytes
                while ($this->filter->shouldBuffer($bytes)) {
                    // Then collect bytes into the buffer
                    if (false === $moreBytes = $this->nextSequence(1)) {
                        break;
                    }

                    foreach ($moreBytes as $b) {
                        $bytes[] = $b;
                    }
                }
                // And filter them
                $bytes = 