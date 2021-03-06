EB', 236 => '=EC', 237 => '=ED', 238 => '=EE', 239 => '=EF',
        240 => '=F0', 241 => '=F1', 242 => '=F2', 243 => '=F3', 244 => '=F4',
        245 => '=F5', 246 => '=F6', 247 => '=F7', 248 => '=F8', 249 => '=F9',
        250 => '=FA', 251 => '=FB', 252 => '=FC', 253 => '=FD', 254 => '=FE',
        255 => '=FF',
    ];

    private static $safeMapShare = [];

    /**
     * A map of non-encoded ascii characters.
     *
     * @var string[]
     *
     * @internal
     */
    protected $safeMap = [];

    public function __construct()
    {
        $id = \get_class($this);
        if (!isset(self::$safeMapShare[$id])) {
            $this->initSafeMap();
            self::$safeMapShare[$id] = $this->safeMap;
        } else {
            $this->safeMap = self::$safeMapShare[$id];
        }
    }

    protected function initSafeMap(): void
    {
        foreach (array_merge([0x09, 0x20], range(0x21, 0x3C), range(0x3E, 0x7E)) as $byte) {
            $this->safeMap[$byte] = \chr($byte);
        }
    }

    /**
     * {@inheritdoc}
     *
     * Takes an unencoded string and produces a QP encoded string from it.
     *
     * QP encoded strings have a maximum line length of 76 characters.
     * If the first line needs to be shorter, indicate the difference with
     * $firstLineOffset.
     */
    public function encodeString(string $string, ?string $charset = 'utf-8', int $firstLineOffset = 0, int $maxLineLength = 0): string
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
        $charStream = new CharacterStream($string, $charset);

        // Fetching more than 4 chars at one is slower, as is fetching fewer bytes
        // Conveniently 4 chars is the UTF-8 safe number since UTF-8 has up to 6
        // bytes per char and (6 * 4 * 3 = 72 chars per line) * =NN is 3 bytes
        while (null !== $bytes = $charStream->readBytes(4)) {
            $enc = $this->encodeByteSequence($bytes, $size);

            $i = strpos($enc, '=0D=0A');
            $newLineLength = $lineLen + (false === $i ? $size : $i);

            if ($currentLine && $newLineLength >= $thisLineLength) {
                $lines[$lNo] = '';
                $currentLine = &$lines[$lNo++];
                $thisLineLength = $maxLineLength;
                $lineLen = 0;
            }

            $currentLine .= $enc;

            if (false === $i) {
                $lineLen += $size;
            } else {
                // 6 is the length of '=0D=0A'.
                $lineLen = $size - strrpos($enc, '=0D=0A') - 6;
            }
        }

        return $this->standardize(implode("=\r\n", $lines));
    }

    /**
     * Encode the given byte array into a verbatim QP form.
     */
    private function encodeByteSequence(array $bytes, int &$size): string
    {
        $ret = '';
        $size = 0;
        foreach ($bytes as $b) {
            if (isset($this->safeMap[$b])) {
                $ret .= $this->safeMap[$b];
                ++$size;
            } else {
                $ret .= self::$qpMap[$b];
                $size += 3;
            }
        }

        return $ret;
    }

    /**
     * Make sure CRLF is correct and HT/SPACE are in valid places.
     */
    private function standardize(string $string): string
    {
        $string = str_replace(["\t=0D=0A", ' =0D=0A', '=0D=0A'], ["=09\r\n", "=20\r\n", "\r\n"], $string);
        switch ($end = \ord(substr($string, -1))) {
            case 0x09:
            case 0x20:
                $string = substr_replace($string, self::$qpMap[$end], -1);
        }

        return $string;
    }
}
                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Encoder;

/**
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
final class QpMimeHeaderEncoder extends QpEncoder implements MimeHeaderEncoderInterface
{
    protected function initSafeMap(): void
    {
        foreach (array_merge(
            range(0x61, 0x7A), range(0x41, 0x5A),
            range(0x30, 0x39), [0x20, 0x21, 0x2A, 0x2B, 0x2D, 0x2F]
        ) as $byte) {
            $this->safeMap[$byte] = \chr($byte);
        }
    }

    public function getName(): string
    {
        return 'Q';
    }

    public function encodeString(string $string, ?string $charset = 'utf-8', int $firstLineOffset = 0, int $maxLineLength = 0): string
    {
        return str_replace([' ', '=20', "=\r\n"], ['_', '_', "\r\n"],
            parent::encodeString($string, $charset, $firstLineOffset, $maxLineLength)
        );
    }
}
                                                                                                                                                                                                                                                                                         