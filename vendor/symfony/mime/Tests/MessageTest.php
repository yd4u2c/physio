itMap = self::getData('translit');
        }

        $i = 0;
        $len = \strlen($str);

        while ($i < $len) {
            if ($str[$i] < "\x80") {
                $uchr = $str[$i++];
            } else {
                $ulen = $str[$i] & "\xF0";
                $ulen = isset($ulenMask[$ulen]) ? $ulenMask[$ulen] : 1;
                $uchr = substr($str, $i, $ulen);

                if ($ignore && (1 === $ulen || !($valid || preg_match('/^.$/us', $uchr)))) {
                    ++$i;
                    continue;
                } else {
                    $i += $ulen;
                }
            }

            if (isset($map[$uchr])) {
                $result .= $map[$uchr];
            } elseif ($translit) {
                if (isset(self::$translitMap[$uchr])) {
                    $uchr = self::$translitMap[$uchr];
                } elseif ($uchr >= "\xC3\x80") {
                    $uchr = \Normalizer::normalize($uchr, \Normalizer::NFD);

                    if ($uchr[0] < "\x80") {
                        $uchr = $uchr[0];
                    } elseif ($ignore) {
                        continue;
                    } else {
                        return false;
                    }
                } elseif ($ignore) {
                    continue;
                } else {
                    return false;
                }

                $str = $uchr.substr($str, $i);
                $len = \strlen($str);
                $i = 0;
            } elseif (!$ignore) {
                return false;
            }
        }

        return true;
    }

    private static function qpByteCallback(array $m)
    {
        return '='.strtoupper(dechex(\ord($m[0])));
    }

    private static function pregOffset($offset)
    {
        $rx = array();
        $offset = (int) $offset;

        while ($offset > 65535) {
            $rx[] = '.{65535}';
            $offset -= 65535;
        }

        return implode('', $rx).'.{'.$offset.'}';
    }

    private static function getData($file)
    {
        if (file_exists($file = __DIR__.'/Resources/charset/'.$file.'.php')) {
            return require $file;
        }

        return false;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   Copyright (c) 2015-2019 Fabien Potencier

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       