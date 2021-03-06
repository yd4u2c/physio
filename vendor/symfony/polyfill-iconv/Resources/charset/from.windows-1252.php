on_exists('posix_isatty') && @posix_isatty($stream);
    }

    private static function initHashMask()
    {
        $obj = (object) array();
        self::$hashMask = -1;

        // check if we are nested in an output buffering handler to prevent a fatal error with ob_start() below
        $obFuncs = array('ob_clean', 'ob_end_clean', 'ob_flush', 'ob_end_flush', 'ob_get_contents', 'ob_get_flush');
        foreach (debug_backtrace(\PHP_VERSION_ID >= 50400 ? DEBUG_BACKTRACE_IGNORE_ARGS : false) as $frame) {
            if (isset($frame['function'][0]) && !isset($frame['class']) && 'o' === $frame['function'][0] && \in_array($frame['function'], $obFuncs)) {
                $frame['line'] = 0;
                break;
            }
        }
        if (!empty($frame['line'])) {
            ob_start();
            debug_zval_dump($obj);
            self::$hashMask = (int) substr(ob_get_clean(), 17);
        }

        self::$hashMask ^= hexdec(substr(spl_object_hash($obj), 16 - \PHP_INT_SIZE, \PHP_INT_SIZE));
    }

    public static function mb_chr($code, $encoding = null)
    {
        if (0x80 > $code %= 0x200000) {
            $s = \chr($code);
        } elseif (0x800 > $code) {
            $s = \chr(0xC0 | $code >> 6).\chr(0x80 | $code & 0x3F);
        } elseif (0x10000 > $code) {
            $s = \chr(0xE0 | $code >> 12).\chr(0x80 | $code >> 6 & 0x3F).\chr(0x80 | $code & 0x3F);
        } else {
            $s = \chr(0xF0 | $code >> 18).\chr(0x80 | $code >> 12 & 0x3F).\chr(0x80 | $code >> 6 & 0x3F).\chr(0x80 | $code & 0x3F);
        }

        if ('UTF-8' !== $encoding) {
            $s = mb_convert_encoding($s, $encoding, 'UTF-8');
        }

        return $s;
    }

    public static function mb_ord($s, $encoding = null)
    {
        if (null == $encoding) {
            $s = mb_convert_encoding($s, 'UTF-8');
        } elseif ('UTF-8' !== $encoding) {
            $s = mb_convert_encoding($s, 'UTF-8', $encoding);
        }

        if (1 === \strlen($s)) {
            return \ord($s);
        }

        $code = ($s = unpack('C*', substr($s, 0, 4))) ? $s[1] : 0;
        if (0xF0 <= $code) {
            return (($code - 0xF0) << 18) + (($s[2] - 0x80) << 12) + (($s[3] - 0x80) << 6) + $s[4] - 0x80;
        }
        if (0xE0 <= $code) {
            return (($code - 0xE0) << 12) + (($s[2] - 0x80) << 6) + $s[3] - 0x80;
        }
        if (0xC0 <= $code) {
            return (($code - 0xC0) << 6) + $s[2] - 0x80;
        }

        return $code;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            