bKit/$saf (KHTML, like Gecko) Version/$ver Safari/$saf",
            '(' . static::randomElement($mobileDevices) . ' ' . mt_rand(7, 8) . '_' . mt_rand(0, 2) . '_' . mt_rand(1, 2) . ' like Mac OS X; ' . static::randomElement(static::$lang) . ") AppleWebKit/$saf (KHTML, like Gecko) Version/" . mt_rand(3, 4) . ".0.5 Mobile/8B" . mt_rand(111, 119) . " Safari/6$saf",
        );

        return "Mozilla/5.0 " . static::randomElement($platforms);
    }

    /**
     * Generate Opera user agent
     *
     * @example 'Opera/8.25 (Windows NT 5.1; en-US) Presto/2.9.188 Version/10.00'
     */
    public static function opera()
    {
        $platforms = array(
            '(' . static::linuxPlatformToken() . '; ' . static::randomElement(static::$lang) . ') Presto/2.' . mt_rand(8, 12) . '.' . mt_rand(160, 355) . ' Version/' . mt_rand(10, 12) . '.00',
            '(' . static::windowsPlatformToken() . '; ' . static::randomElement(static::$lang) . ') Presto/2.' . mt_rand(8, 12) . '.' . mt_rand(160, 355) . ' Version/' . mt_rand(10, 12) . '.00'
        );

        return "Opera/" . mt_rand(8, 9) . '.' . mt_rand(10, 99) . ' ' . static::randomElement($platforms);
    }

    /**
     * Generate Internet Explorer user agent
     *
     * @example 'Mozilla/5.0 (compatible; MSIE 7.0; Windows 98; Win 9x 4.90; Trident/3.0)'
     */
    public static function internetExplorer()
    {
        return 'Mozilla/5.0 (compatible; MSIE ' . mt_rand(5, 11) . '.0; ' . static::windowsPlatformToken() . '; Trident/' . mt_rand(3, 5) . '.' . mt_rand(0, 1) . ')';
    }

    public static function windowsPlatformToken()
    {
        return static::randomElement(static::$windowsPlatformTokens);
    }

    public static function macPlatformToken()
    {
        return 'Macintosh; ' . static::randomElement(static::$macProcessor) . ' Mac OS X 10_' . mt_rand(5, 8) . '_' . mt_rand(0, 9);
    }

    public static function linuxPlatformToken()
    {
        return 'X11; Linux ' . static::randomElement(static::$linuxProcessor);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

namespace Faker\Provider;

class Uuid extends Base
{
    /**
     * Generate name based md5 UUID (version 3).
     * @example '7e57d004-2b97-0e7a-b45f-5387367791cd'
     */
    public static function uuid()
    {
        // fix for compatibility with 32bit architecture; seed range restricted to 62bit
        $seed = mt_rand(0, 2147483647) . '#' . mt_rand(0, 2147483647);

        // Hash the seed and convert to a byte array
        $val = md5($seed, true);
        $byte = array_values(unpack('C16', $val));

        // extract fields from byte array
        $tLo = ($byte[0] << 24) | ($byte[1] << 16) | ($byte[2] << 8) | $byte[3];
        $tMi = ($byte[4] << 8) | $byte[5];
        $tHi = ($byte[6] << 8) | $byte[7];
        $csLo = $byte[9];
        $csHi = $byte[8] & 0x3f | (1 << 7);

        // correct byte order for big edian architecture
        if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
            $tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8)
                | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
            $tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
            $tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
        }

        // apply version number
        $tHi &= 0x0fff;
        $tHi |= (3 << 12);

        // cast to string
        $uuid = sprintf(
            '%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x',
            $tLo,
            $tMi,
            $tHi,
            $csHi,
            $csLo,
            $byte[10],
            $byte[11],
            $byte[12],
            $byte[13],
            $byte[14],
            $byte[15]
        );

        return $uuid;
    }
}
                                                                                                               