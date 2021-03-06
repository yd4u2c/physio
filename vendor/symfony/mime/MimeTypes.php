INDX( 	 ���             (   P  �       �                    1     � x     1     �$�
qk��%�� %��%�� %��$�
qk��      �               A d d r e s s E n c o d e r E x c e p t i o n . p h p 1     � n     1     ZLqk�갣 %�갣 %�ZLqk��      �               E x c e p t i o n I n t e r f a c e . p h p   1     � z     1     S�qk�vL�� %�vL�� %�S�qk��      �               I n v a l i d A r g u m e n t E x c e p t i o n . p h p       	1     x f     1     (s	qk�vL�� % vL�� %�(s	qk��      �               L o g i c E x c e p t i o n . p h p   
1     � v     1     �qk�)�� %�)�� %��qk��      �               R f c C o m p l i a n c e E x c e p t i o n . p h p   1     � j     1     _qk�)�� %�)�� %�_qk��      �               R u n t i m e E x c e p t i o n . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

use Symfony\Component\Mime\Encoder\QpMimeHeaderEncoder;

/**
 * An abstract base MIME Header.
 *
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
abstract class AbstractHeader implements HeaderInterface
{
    const PHRASE_PATTERN = '(?:(?:(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?[a-zA-Z0-9!#\$%&\'\*\+\-\/=\?\^_`\{\}\|~]+(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?)|(?:(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?"((?:(?:[ \t]*(?:\r\n))?[ \t])?(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21\x23-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])))*(?:(?:[ \t]*(?:\r\n))?[ \t])?"(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))*(?:(?:(?:(?:[ \t]*(?:\r\n))?[ \t])?(\((?:(?:(?:[ \t]*(?:\r\n))?[ \t])|(?:(?:[\x01-\x08\x0B\x0C\x0E-\x19\x7F]|[\x21-\x27\x2A-\x5B\x5D-\x7E])|(?:\\[\x00-\x08\x0B\x0C\x0E-\x7F])|(?1)))*(?:(?:[ \t]*(?:\r\n))?[ \t])?\)))|(?:(?:[ \t]*(?:\r\n))?[ \t])))?))+?)';

    private static $encoder;

    private $name;
    private $lineLength = 76;
    private $lang;
    private $charset = 'utf-8';

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function setCharset(string $charset)
    {
        $this->charset = $charset;
    }

    public function getCharset(): ?string
    {
        return $this->charset;
    }

    /**
     * Set the language used in this Header.
     *
     * For example, for US English, 'en-us'.
     */
    public function setLanguage(string $lang)
    {
        $this->lang = $lang;
    }

    public function getLanguage(): ?string
    {
        return $this->lang;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setMaxLineLength(int $lineLength)
    {
        $this->lineLength = $lineLength;
    }

    public function getMaxLineLength(): int
    {
        return $this->lineLength;
    }

    public function toString(): string
    {
        return $this->tokensToString($this->toTokens());
    }

    /**
     * Produces a compliant, formatted RFC 2822 'phrase' based on the string given.
     *
     * @param string $string  as displayed
     * @param bool   $shorten the first line to make remove for header name
     */
    protected function createPhrase(HeaderInterface $header, string $string, string $charset, bool $shorten = false): string
    {
        // Treat token as exactly what was given
        $phraseStr = $string;

        // If it's not valid
        if (!preg_match('/^'.self::PHRASE_PATTERN.'$/D', $phraseStr)) {
            // .. but it is just ascii text, try escaping some characters
            // and make it a quoted-string
            if (preg_match('/^[\x00-\x08\x0B\x0C\x0E-\x7F]*$/D', $phraseStr)) {
                foreach (['\\', '"'] as $char) {
                    $phraseStr = str_replace($char, '\\'.$char, $phraseStr);
                }
                $phraseStr = '"'.$phraseStr.'"';
            } else {
                // ... otherwise it needs encoding
                // Determine space remaining on line if first line
                if ($shorten) {
                    $usedLength = \strlen($header->getName().': ');
                } else {
                    $usedLength = 0;
                }
                $phraseStr = $this->encodeWords($header, $string, $usedLength);
            }
        }

        return $phraseStr;
    }

    /**
     * Encode needed word tokens within a string of input.
     */
    protected function encodeWords(HeaderInterface $header, string $input, int $usedLength = -1): string
    {
        $value = '';
        $tokens = $this->getEncodableWordTokens($input);
        foreach ($tokens as $token) {
            // See RFC 2822, Sect 2.2 (really 2.2 ??)
            if ($this->tokenNeedsEncoding($token)) {
                // Don't encode starting WSP
                $firstChar = substr($token, 0, 1);
                switch ($firstChar) {
                    case ' ':
                    case "\t":
                        $value .= $firstChar;
                        $token = substr($token, 1);
                }

                if (-1 == $usedLength) {
                    $usedLength = \strlen($header->getName().': ') + \strlen($value);
                }
                $value .= $this->getTokenAsEncodedWord($token, $usedLength);
            } else {
                $value .= $token;
            }
        }

        return $value;
    }

    protected function tokenNeedsEncoding(string $token): bool
    {
        return (bool) preg_match('~[\x00-\x08\x10-\x19\x7F-\xFF\r\n]~', $token);
    }

    /**
     * Splits a string into tokens in blocks of words which can be encoded quickly.
     *
     * @return string[]
     */
    protected function getEncodableWordTokens(string $string): array
    {
        $tokens = [];
        $encodedToken = '';
        // Split at all whitespace boundaries
        foreach (preg_split('~(?=[\t ])~', $string) as $token) {
            if ($this->tokenNeedsEncoding($token)) {
                $encodedToken .= $token;
            } else {
                if (\strlen($encodedToken) > 0) {
                    $tokens[] = $encodedToken;
                    $encodedToken = '';
                }
                $tokens[] = $token;
            }
        }
        if (\strlen($encodedToken)) {
            $tokens[] = $encodedToken;
        }

        return $tokens;
    }

    /**
     * Get a token as an encoded word for safe insertion into headers.
     */
    protected function getTokenAsEncodedWord(string $token, int $firstLineOffset = 0): string
    {
        if (null === self::$encoder) {
            self::$encoder = new QpMimeHeaderEncoder();
        }

        // Adjust $firstLineOffset to account for space needed for syntax
        $charsetDecl = $this->charset;
        if (null !== $this->lang) {
            $charsetDecl .= '*'.$this->lang;
        }
        $encodingWrapperLength = \strlen('=?'.$charsetDecl.'?'.self::$encoder->getName().'??=');

        if ($firstLineOffset >= 75) {
            //Does this logic need to be here?
            $firstLineOffset = 0;
        }

        $encodedTextLines = explode("\r\n",
            self::$encoder->encodeString($token, $this->charset, $firstLineOffset, 75 - $encodingWrapperLength)
        );

        if ('iso-2022-jp' !== strtolower($this->charset)) {
            // special encoding for iso-2022-jp using mb_encode_mimeheader
            foreach ($encodedTextLines as $lineNum => $line) {
                $encodedTextLines[$lineNum] = '=?'.$charsetDecl.'?'.self::$encoder->getName().'?'.$line.'?=';
            }
        }

        return implode("\r\n ", $encodedTextLines);
    }

    /**
     * Generates tokens from the given string which include CRLF as individual tokens.
     *
     * @return string[]
     */
    protected function generateTokenLines(string $token): array
    {
        return preg_split('~(\r\n)~', $token, -1, PREG_SPLIT_DELIM_CAPTURE);
    }

    /**
     * Generate a list of all tokens in the final header.
     */
    protected function toTokens(string $string = null): array
    {
        if (null === $string) {
            $string = $this->getBodyAsString();
        }

        $tokens = [];
        // Generate atoms; split at all invisible boundaries followed by WSP
        foreach (preg_split('~(?=[ \t])~', $string) as $token) {
            $newTokens = $this->generateTokenLines($token);
            foreach ($newTokens as $newToken) {
                $tokens[] = $newToken;
            }
        }

        return $tokens;
    }

    /**
     * Takes an array of tokens which appear in the header and turns them into
     * an RFC 2822 compliant string, adding FWSP where needed.
     *
     * @param string[] $tokens
     */
    private function tokensToString(array $tokens): string
    {
        $lineCount = 0;
        $headerLines = [];
        $headerLines[] = $this->name.': ';
        $currentLine = &$headerLines[$lineCount++];

        // Build all tokens back into compliant header
        foreach ($tokens as $i => $token) {
            // Line longer than specified maximum or token was just a new line
            if (("\r\n" === $token) ||
                ($i > 0 && \strlen($currentLine.$token) > $this->lineLength)
                && 0 < \strlen($currentLine)) {
                $headerLines[] = '';
                $currentLine = &$headerLines[$lineCount++];
            }

            // Append token to the line
            if ("\r\n" !== $token) {
                $currentLine .= $token;
            }
        }

        // Implode with FWS (RFC 2822, 2.2.3)
        return implode("\r\n", $headerLines);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

/**
 * A Date MIME Header.
 *
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
final class DateHeader extends AbstractHeader
{
    private $dateTime;

    public function __construct(string $name, \DateTimeInterface $date)
    {
        parent::__construct($name);

        $this->setDateTime($date);
    }

    /**
     * @param \DateTimeInterface $body
     */
    public function setBody($body)
    {
        $this->setDateTime($body);
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getBody()
    {
        return $this->getDateTime();
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    /**
     * Set the date-time of the Date in this Header.
     *
     * If a DateTime instance is provided, it is converted to DateTimeImmutable.
     */
    public function setDateTime(\DateTimeInterface $dateTime)
    {
        if ($dateTime instanceof \DateTime) {
            $immutable = new \DateTimeImmutable('@'.$dateTime->getTimestamp());
            $dateTime = $immutable->setTimezone($dateTime->getTimezone());
        }
        $this->dateTime = $dateTime;
    }

    public function getBodyAsString(): string
    {
        return $this->dateTime->format(\DateTime::RFC2822);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

/**
 * A MIME Header.
 *
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
interface HeaderInterface
{
    /**
     * Sets the body.
     *
     * The type depends on the Header concrete class.
     *
     * @param mixed $body
     */
    public function setBody($body);

    /**
     * Gets the body.
     *
     * The return type depends on the Header concrete class.
     *
     * @return mixed
     */
    public function getBody();

    public function setCharset(string $charset);

    public function getCharset(): ?string;

    public function setLanguage(string $lang);

    public function getLanguage(): ?string;

    public function getName(): string;

    public function setMaxLineLength(int $lineLength);

    public function getMaxLineLength(): int;

    /**
     * Gets this Header rendered as a compliant string.
     */
    public function toString(): string;

    /**
     * Gets the header's body, prepared for folding into a final header value.
     *
     * This is not necessarily RFC 2822 compliant since folding white space is
     * not added at this stage (see {@link toString()} for that).
     */
    public function getBodyAsString(): string;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Exception\LogicException;
use Symfony\Component\Mime\NamedAddress;

/**
 * A collection of headers.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
final class Headers
{
    private static $uniqueHeaders = [
        'date', 'from', 'sender', 'reply-to', 'to', 'cc', 'bcc',
        'message-id', 'in-reply-to', 'references', 'subject',
    ];

    private $headers = [];
    private $lineLength = 76;

    public function __construct(HeaderInterface ...$headers)
    {
        foreach ($headers as $header) {
            $this->add($header);
        }
    }

    public function __clone()
    {
        foreach ($this->headers as $name => $collection) {
            foreach ($collection as $i => $header) {
                $this->headers[$name][$i] = clone $header;
            }
        }
    }

    public function setMaxLineLength(int $lineLength)
    {
        $this->lineLength = $lineLength;
        foreach ($this->getAll() as $header) {
            $header->setMaxLineLength($lineLength);
        }
    }

    public function getMaxLineLength(): int
    {
        return $this->lineLength;
    }

    /**
     * @param (NamedAddress|Address|string)[] $addresses
     *
     * @return $this
     */
    public function addMailboxListHeader(string $name, array $addresses)
    {
        return $this->add(new MailboxListHeader($name, Address::createArray($addresses)));
    }

    /**
     * @param NamedAddress|Address|string $address
     *
     * @return $this
     */
    public function addMailboxHeader(string $name, $address)
    {
        return $this->add(new MailboxHeader($name, Address::create($address)));
    }

    /**
     * @param string|array $ids
     *
     * @return $this
     */
    public function addIdHeader(string $name, $ids)
    {
        return $this->add(new IdentificationHeader($name, $ids));
    }

    /**
     * @param Address|string $path
     *
     * @return $this
     */
    public function addPathHeader(string $name, $path)
    {
        return $this->add(new PathHeader($name, $path instanceof Address ? $path : new Address($path)));
    }

    /**
     * @return $this
     */
    public function addDateHeader(string $name, \DateTimeInterface $dateTime)
    {
        return $this->add(new DateHeader($name, $dateTime));
    }

    /**
     * @return $this
     */
    public function addTextHeader(string $name, string $value)
    {
        return $this->add(new UnstructuredHeader($name, $value));
    }

    /**
     * @return $this
     */
    public function addParameterizedHeader(string $name, string $value, array $params = [])
    {
        return $this->add(new ParameterizedHeader($name, $value, $params));
    }

    public function has(string $name): bool
    {
        return isset($this->headers[strtolower($name)]);
    }

    /**
     * @return $this
     */
    public function add(HeaderInterface $header)
    {
        static $map = [
            'date' => DateHeader::class,
            'from' => MailboxListHeader::class,
            'sender' => MailboxHeader::class,
            'reply-to' => MailboxListHeader::class,
            'to' => MailboxListHeader::class,
            'cc' => MailboxListHeader::class,
            'bcc' => MailboxListHeader::class,
            'message-id' => IdentificationHeader::class,
            'in-reply-to' => IdentificationHeader::class,
            'references' => IdentificationHeader::class,
            'return-path' => PathHeader::class,
        ];

        $header->setMaxLineLength($this->lineLength);
        $name = strtolower($header->getName());

        if (isset($map[$name]) && !$header instanceof $map[$name]) {
            throw new LogicException(sprintf('The "%s" header must be an instance of "%s" (got "%s").', $header->getName(), $map[$name], \get_class($header)));
        }

        if (\in_array($name, self::$uniqueHeaders, true) && isset($this->headers[$name]) && \count($this->headers[$name]) > 0) {
            throw new LogicException(sprintf('Impossible to set header "%s" as it\'s already defined and must be unique.', $header->getName()));
        }

        $this->headers[$name][] = $header;

        return $this;
    }

    public function get(string $name): ?HeaderInterface
    {
        $name = strtolower($name);
        if (!isset($this->headers[$name])) {
            return null;
        }

        $values = array_values($this->headers[$name]);

        return array_shift($values);
    }

    public function getAll(string $name = null): iterable
    {
        if (null === $name) {
            foreach ($this->headers as $name => $collection) {
                foreach ($collection as $header) {
                    yield $name => $header;
                }
            }
        } elseif (isset($this->headers[strtolower($name)])) {
            foreach ($this->headers[strtolower($name)] as $header) {
                yield $header;
            }
        }
    }

    public function getNames(): array
    {
        return array_keys($this->headers);
    }

    public function remove(string $name): void
    {
        unset($this->headers[strtolower($name)]);
    }

    public static function isUniqueHeader(string $name): bool
    {
        return \in_array($name, self::$uniqueHeaders, true);
    }

    public function toString(): string
    {
        $string = '';
        foreach ($this->toArray() as $str) {
            $string .= $str."\r\n";
        }

        return $string;
    }

    public function toArray(): array
    {
        $arr = [];
        foreach ($this->getAll() as $header) {
            if ('' !== $header->getBodyAsString()) {
                $arr[] = $header->toString();
            }
        }

        return $arr;
    }

    /**
     * @internal
     */
    public function getHeaderBody($name)
    {
        return $this->has($name) ? $this->get($name)->getBody() : null;
    }

    /**
     * @internal
     */
    public function setHeaderBody(string $type, string $name, $body): void
    {
        if ($this->has($name)) {
            $this->get($name)->setBody($body);
        } else {
            $this->{'add'.$type.'Header'}($name, $body);
        }
    }

    /**
     * @internal
     */
    public function getHeaderParameter(string $name, string $parameter): ?string
    {
        if (!$this->has($name)) {
            return null;
        }

        $header = $this->get($name);
        if (!$header instanceof ParameterizedHeader) {
            throw new LogicException(sprintf('Unable to get parameter "%s" on header "%s" as the header is not of class "%s".', $parameter, $name, ParameterizedHeader::class));
        }

        return $header->getParameter($parameter);
    }

    /**
     * @internal
     */
    public function setHeaderParameter(string $name, string $parameter, $value): void
    {
        if (!$this->has($name)) {
            throw new LogicException(sprintf('Unable to set parameter "%s" on header "%s" as the header is not defined.', $parameter, $name));
        }

        $header = $this->get($name);
        if (!$header instanceof ParameterizedHeader) {
            throw new LogicException(sprintf('Unable to set parameter "%s" on header "%s" as the header is not of class "%s".', $parameter, $name, ParameterizedHeader::class));
        }

        $header->setParameter($parameter, $value);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Exception\RfcComplianceException;

/**
 * An ID MIME Header for something like Message-ID or Content-ID (one or more addresses).
 *
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
final class IdentificationHeader extends AbstractHeader
{
    private $ids = [];
    private $idsAsAddresses = [];

    /**
     * @param string|array $ids
     */
    public function __construct(string $name, $ids)
    {
        parent::__construct($name);

        $this->setId($ids);
    }

    /**
     * @param string|array $body a string ID or an array of IDs
     *
     * @throws RfcComplianceException
     */
    public function setBody($body)
    {
        $this->setId($body);
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->getIds();
    }

    /**
     * Set the ID used in the value of this header.
     *
     * @param string|array $id
     *
     * @throws RfcComplianceException
     */
    public function setId($id)
    {
        $this->setIds(\is_array($id) ? $id : [$id]);
    }

    /**
     * Get the ID used in the value of this Header.
     *
     * If multiple IDs are set only the first is returned.
     */
    public function getId(): ?string
    {
        return $this->ids[0] ?? null;
    }

    /**
     * Set a collection of IDs to use in the value of this Header.
     *
     * @param string[] $ids
     *
     * @throws RfcComplianceException
     */
    public function setIds(array $ids)
    {
        $this->ids = [];
        $this->idsAsAddresses = [];
        foreach ($ids as $id) {
            $this->idsAsAddresses[] = new Address($id);
            $this->ids[] = $id;
        }
    }

    /**
     * Get the list of IDs used in this Header.
     *
     * @return string[]
     */
    public function getIds(): array
    {
        return $this->ids;
    }

    public function getBodyAsString(): string
    {
        $addrs = [];
        foreach ($this->idsAsAddresses as $address) {
            $addrs[] = '<'.$address->toString().'>';
        }

        return implode(' ', $addrs);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           INDX( 	 ���             (   �  �       s r                   1     x f     1     �J!qk��ã %��ã %��J!qk� 0      y(               A b s t r a c t H e a d e r . p h p   1     p ^     1     �q(qk�U_ƣ %�U_ƣ %��q(qk�                      D a t e H e a d e r . p h p   1     x h     1     ��*qk���ȣ %���ȣ %���*qk�       �               H e a d e r I n t e r f a c e . p h p 1     h X     1     ��1qk���ͣ %���ͣ %���1qk�                        H e a d e r  . p h p 1     � r     1     �;qk�ޙ� %�ޙ� %��;qk�       u	               I d e n t i f i c a t i o n H e a d e r . p h p       1     x d     1     "I@qk�^� %�^� %�"I@qk�       @               M a i l b o x H e a d e r . p h p     1     � l     1     �Bqk�N#� %�N#� %��Bqk�                      M a i l b o x L i s t H e a d e r . p h p     1     � p     1     ��Iqk�l�� %�l�� %���Iqk�        �               P a r a m e t e r i z e d H e a d e  . p h p 1     p ^     1     C�Nqk�H]� %�H]� %�C�Nqk�                      P a t h H e a d e r . p h p   1     � n     1     �\Sqk�u!	� %�u!	� %��\Sqk�                      U n s t r u c t u r e d H e a d e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Exception\RfcComplianceException;
use Symfony\Component\Mime\NamedAddress;

/**
 * A Mailbox MIME Header for something like Sender (one named address).
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
final class MailboxHeader extends AbstractHeader
{
    private $address;

    public function __construct(string $name, Address $address)
    {
        parent::__construct($name);

        $this->setAddress($address);
    }

    /**
     * @param Address $body
     *
     * @throws RfcComplianceException
     */
    public function setBody($body)
    {
        $this->setAddress($body);
    }

    /**
     * @throws RfcComplianceException
     *
     * @return Address
     */
    public function getBody()
    {
        return $this->getAddress();
    }

    /**
     * @throws RfcComplianceException
     */
    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getBodyAsString(): string
    {
        $str = $this->address->getEncodedAddress();
        if ($this->address instanceof NamedAddress && $name = $this->address->getName()) {
            $str = $this->createPhrase($this, $name, $this->getCharset(), true).' <'.$str.'>';
        }

        return $str;
    }

    /**
     * Redefine the encoding requirements for an address.
     *
     * All "specials" must be encoded as the full header value will not be quoted
     *
     * @see RFC 2822 3.2.1
     */
    protected function tokenNeedsEncoding(string $token): bool
    {
        return preg_match('/[()<>\[\]:;@\,."]/', $token) || parent::tokenNeedsEncoding($token);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Exception\RfcComplianceException;
use Symfony\Component\Mime\NamedAddress;

/**
 * A Mailbox list MIME Header for something like From, To, Cc, and Bcc (one or more named addresses).
 *
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
final class MailboxListHeader extends AbstractHeader
{
    private $addresses = [];

    /**
     * @param (NamedAddress|Address)[] $addresses
     */
    public function __construct(string $name, array $addresses)
    {
        parent::__construct($name);

        $this->setAddresses($addresses);
    }

    /**
     * @param (NamedAddress|Address)[] $body
     *
     * @throws RfcComplianceException
     */
    public function setBody($body)
    {
        $this->setAddresses($body);
    }

    /**
     * @throws RfcComplianceException
     *
     * @return (NamedAddress|Address)[]
     */
    public function getBody()
    {
        return $this->getAddresses();
    }

    /**
     * Sets a list of addresses to be shown in this Header.
     *
     * @param (NamedAddress|Address)[] $addresses
     *
     * @throws RfcComplianceException
     */
    public function setAddresses(array $addresses)
    {
        $this->addresses = [];
        $this->addAddresses($addresses);
    }

    /**
     * Sets a list of addresses to be shown in this Header.
     *
     * @param (NamedAddress|Address)[] $addresses
     *
     * @throws RfcComplianceException
     */
    public function addAddresses(array $addresses)
    {
        foreach ($addresses as $address) {
            $this->addAddress($address);
        }
    }

    /**
     * @throws RfcComplianceException
     */
    public function addAddress(Address $address)
    {
        $this->addresses[] = $address;
    }

    /**
     * @return (NamedAddress|Address)[]
     */
    public function getAddresses(): array
    {
        return $this->addresses;
    }

    /**
     * Gets the full mailbox list of this Header as an array of valid RFC 2822 strings.
     *
     * @throws RfcComplianceException
     *
     * @return string[]
     */
    public function getAddressStrings(): array
    {
        $strings = [];
        foreach ($this->addresses as $address) {
            $str = $address->getEncodedAddress();
            if ($address instanceof NamedAddress && $name = $address->getName()) {
                $str = $this->createPhrase($this, $name, $this->getCharset(), empty($strings)).' <'.$str.'>';
            }
            $strings[] = $str;
        }

        return $strings;
    }

    public function getBodyAsString(): string
    {
        return implode(', ', $this->getAddressStrings());
    }

    /**
     * Redefine the encoding requirements for addresses.
     *
     * All "specials" must be encoded as the full header value will not be quoted
     *
     * @see RFC 2822 3.2.1
     */
    protected function tokenNeedsEncoding(string $token): bool
    {
        return preg_match('/[()<>\[\]:;@\,."]/', $token) || parent::tokenNeedsEncoding($token);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

use Symfony\Component\Mime\Encoder\Rfc2231Encoder;

/**
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
final class ParameterizedHeader extends UnstructuredHeader
{
    /**
     * RFC 2231's definition of a token.
     *
     * @var string
     */
    const TOKEN_REGEX = '(?:[\x21\x23-\x27\x2A\x2B\x2D\x2E\x30-\x39\x41-\x5A\x5E-\x7E]+)';

    private $encoder;
    private $parameters = [];

    public function __construct(string $name, string $value, array $parameters = [])
    {
        parent::__construct($name, $value);

        foreach ($parameters as $k => $v) {
            $this->setParameter($k, $v);
        }

        if ('content-disposition' === strtolower($name)) {
            $this->encoder = new Rfc2231Encoder();
        }
    }

    public function setParameter(string $parameter, ?string $value)
    {
        $this->setParameters(array_merge($this->getParameters(), [$parameter => $value]));
    }

    public function getParameter(string $parameter): string
    {
        return $this->getParameters()[$parameter] ?? '';
    }

    /**
     * @param string[] $parameters
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return string[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getBodyAsString(): string
    {
        $body = parent::getBodyAsString();
        foreach ($this->parameters as $name => $value) {
            if (null !== $value) {
                $body .= '; '.$this->createParameter($name, $value);
            }
        }

        return $body;
    }

    /**
     * Generate a list of all tokens in the final header.
     *
     * This doesn't need to be overridden in theory, but it is for implementation
     * reasons to prevent potential breakage of attributes.
     */
    protected function toTokens(string $string = null): array
    {
        $tokens = parent::toTokens(parent::getBodyAsString());

        // Try creating any parameters
        foreach ($this->parameters as $name => $value) {
            if (null !== $value) {
                // Add the semi-colon separator
                $tokens[\count($tokens) - 1] .= ';';
                $tokens = array_merge($tokens, $this->generateTokenLines(' '.$this->createParameter($name, $value)));
            }
        }

        return $tokens;
    }

    /**
     * Render a RFC 2047 compliant header parameter from the $name and $value.
     */
    private function createParameter(string $name, string $value): string
    {
        $origValue = $value;

        $encoded = false;
        // Allow room for parameter name, indices, "=" and DQUOTEs
        $maxValueLength = $this->getMaxLineLength() - \strlen($name.'=*N"";') - 1;
        $firstLineOffset = 0;

        // If it's not already a valid parameter value...
        if (!preg_match('/^'.self::TOKEN_REGEX.'$/D', $value)) {
            // TODO: text, or something else??
            // ... and it's not ascii
            if (!preg_match('/^[\x00-\x08\x0B\x0C\x0E-\x7F]*$/D', $value)) {
                $encoded = true;
                // Allow space for the indices, charset and language
                $maxValueLength = $this->getMaxLineLength() - \strlen($name.'*N*="";') - 1;
                $firstLineOffset = \strlen($this->getCharset()."'".$this->getLanguage()."'");
            }
        }

        // Encode if we need to
        if ($encoded || \strlen($value) > $maxValueLength) {
            if (null !== $this->encoder) {
                $value = $this->encoder->encodeString($origValue, $this->getCharset(), $firstLineOffset, $maxValueLength);
            } else {
                // We have to go against RFC 2183/2231 in some areas for interoperability
                $value = $this->getTokenAsEncodedWord($origValue);
                $encoded = false;
            }
        }

        $valueLines = $this->encoder ? explode("\r\n", $value) : [$value];

        // Need to add indices
        if (\count($valueLines) > 1) {
            $paramLines = [];
            foreach ($valueLines as $i => $line) {
                $paramLines[] = $name.'*'.$i.$this->getEndOfParameterValue($line, true, 0 === $i);
            }

            return implode(";\r\n ", $paramLines);
        } else {
            return $name.$this->getEndOfParameterValue($valueLines[0], $encoded, true);
        }
    }

    /**
     * Returns the parameter value from the "=" and beyond.
     *
     * @param string $value to append
     */
    private function getEndOfParameterValue(string $value, bool $encoded = false, bool $firstLine = false): string
    {
        if (!preg_match('/^'.self::TOKEN_REGEX.'$/D', $value)) {
            $value = '"'.$value.'"';
        }
        $prepend = '=';
        if ($encoded) {
            $prepend = '*=';
            if ($firstLine) {
                $prepend = '*='.$this->getCharset()."'".$this->getLanguage()."'";
            }
        }

        return $prepend.$value;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Exception\RfcComplianceException;

/**
 * A Path Header, such a Return-Path (one address).
 *
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
final class PathHeader extends AbstractHeader
{
    private $address;

    public function __construct(string $name, Address $address)
    {
        parent::__construct($name);

        $this->setAddress($address);
    }

    /**
     * @param Address $body
     *
     * @throws RfcComplianceException
     */
    public function setBody($body)
    {
        $this->setAddress($body);
    }

    /**
     * @return Address
     */
    public function getBody()
    {
        return $this->getAddress();
    }

    public function setAddress(Address $address)
    {
        $this->address = $address;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getBodyAsString(): string
    {
        return '<'.$this->address->toString().'>';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Header;

/**
 * A Simple MIME Header.
 *
 * @author Chris Corbyn
 *
 * @experimental in 4.3
 */
class UnstructuredHeader extends AbstractHeader
{
    private $value;

    public function __construct(string $name, string $value)
    {
        parent::__construct($name);

        $this->setValue($value);
    }

    /**
     * @param string $body
     */
    public function setBody($body)
    {
        $this->setValue($body);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->getValue();
    }

    /**
     * Get the (unencoded) value of this header.
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Set the (unencoded) value of this header.
     */
    public function setValue(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of this header prepared for rendering.
     */
    public function getBodyAsString(): string
    {
        return $this->encodeWords($this, $this->value);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part;

use Symfony\Component\Mime\Header\Headers;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
abstract class AbstractMultipartPart extends AbstractPart
{
    private $boundary;
    private $parts = [];

    public function __construct(AbstractPart ...$parts)
    {
        parent::__construct();

        foreach ($parts as $part) {
            $this->parts[] = $part;
        }
    }

    /**
     * @return AbstractPart[]
     */
    public function getParts(): array
    {
        return $this->parts;
    }

    public function getMediaType(): string
    {
        return 'multipart';
    }

    public function getPreparedHeaders(): Headers
    {
        $headers = parent::getPreparedHeaders();
        $headers->setHeaderParameter('Content-Type', 'boundary', $this->getBoundary());

        return $headers;
    }

    public function bodyToString(): string
    {
        $parts = $this->getParts();
        $string = '';
        foreach ($parts as $part) {
            $string .= '--'.$this->getBoundary()."\r\n".$part->toString()."\r\n";
        }
        $string .= '--'.$this->getBoundary()."--\r\n";

        return $string;
    }

    public function bodyToIterable(): iterable
    {
        $parts = $this->getParts();
        foreach ($parts as $part) {
            yield '--'.$this->getBoundary()."\r\n";
            yield from $part->toIterable();
            yield "\r\n";
        }
        yield '--'.$this->getBoundary()."--\r\n";
    }

    private function getBoundary(): string
    {
        if (null === $this->boundary) {
            $this->boundary = '_=_symfony_'.time().'_'.bin2hex(random_bytes(16)).'_=_';
        }

        return $this->boundary;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part;

use Symfony\Component\Mime\Header\Headers;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
abstract class AbstractPart
{
    private $headers;

    public function __construct()
    {
        $this->headers = new Headers();
    }

    public function getHeaders(): Headers
    {
        return $this->headers;
    }

    public function getPreparedHeaders(): Headers
    {
        $headers = clone $this->headers;
        $headers->setHeaderBody('Parameterized', 'Content-Type', $this->getMediaType().'/'.$this->getMediaSubtype());

        return $headers;
    }

    public function toString(): string
    {
        return $this->getPreparedHeaders()->toString()."\r\n".$this->bodyToString();
    }

    public function toIterable(): iterable
    {
        yield $this->getPreparedHeaders()->toString();
        yield "\r\n";
        yield from $this->bodyToIterable();
    }

    abstract public function bodyToString(): string;

    abstract public function bodyToIterable(): iterable;

    abstract public function getMediaType(): string;

    abstract public function getMediaSubtype(): string;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part;

use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\MimeTypes;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
class DataPart extends TextPart
{
    private static $mimeTypes;

    private $filename;
    private $mediaType;
    private $cid;
    private $handle;

    /**
     * @param resource|string $body
     */
    public function __construct($body, string $filename = null, string $contentType = null, string $encoding = null)
    {
        if (null === $contentType) {
            $contentType = 'application/octet-stream';
        }
        list($this->mediaType, $subtype) = explode('/', $contentType);

        parent::__construct($body, null, $subtype, $encoding);

        $this->filename = $filename;
        $this->setName($filename);
        $this->setDisposition('attachment');
    }

    public static function fromPath(string $path, string $name = null, string $contentType = null): self
    {
        // FIXME: if file is not readable, exception?

        if (null === $contentType) {
            $ext = strtolower(substr($path, strrpos($path, '.') + 1));
            if (null === self::$mimeTypes) {
                self::$mimeTypes = new MimeTypes();
            }
            $contentType = self::$mimeTypes->getMimeTypes($ext)[0] ?? 'application/octet-stream';
        }

        if (false === $handle = @fopen($path, 'r', false)) {
            throw new InvalidArgumentException(sprintf('Unable to open path "%s"', $path));
        }
        $p = new self($handle, $name ?: basename($path), $contentType);
        $p->handle = $handle;

        return $p;
    }

    /**
     * @return $this
     */
    public function asInline()
    {
        return $this->setDisposition('inline');
    }

    public function getContentId(): string
    {
        return $this->cid ?: $this->cid = $this->generateContentId();
    }

    public function hasContentId(): bool
    {
        return null !== $this->cid;
    }

    public function getMediaType(): string
    {
        return $this->mediaType;
    }

    public function getPreparedHeaders(): Headers
    {
        $headers = parent::getPreparedHeaders();

        if (null !== $this->cid) {
            $headers->setHeaderBody('Id', 'Content-ID', $this->cid);
        }

        if (null !== $this->filename) {
            $headers->setHeaderParameter('Content-Disposition', 'filename', $this->filename);
        }

        return $headers;
    }

    private function generateContentId(): string
    {
        return bin2hex(random_bytes(16)).'@symfony';
    }

    public function __destruct()
    {
        if (null !== $this->handle && \is_resource($this->handle)) {
            fclose($this->handle);
        }
    }

    public function __sleep()
    {
        // converts the body to a string
        parent::__sleep();

        $this->_parent = [];
        foreach (['body', 'charset', 'subtype', 'disposition', 'name', 'encoding'] as $name) {
            $r = new \ReflectionProperty(TextPart::class, $name);
            $r->setAccessible(true);
            $this->_parent[$name] = $r->getValue($this);
        }
        $this->_headers = $this->getHeaders();

        return ['_headers', '_parent', 'filename', 'mediaType'];
    }

    public function __wakeup()
    {
        $r = new \ReflectionProperty(AbstractPart::class, 'headers');
        $r->setAccessible(true);
        $r->setValue($this, $this->_headers);
        unset($this->_headers);

        foreach (['body', 'charset', 'subtype', 'disposition', 'name', 'encoding'] as $name) {
            $r = new \ReflectionProperty(TextPart::class, $name);
            $r->setAccessible(true);
            $r->setValue($this, $this->_parent[$name]);
        }
        unset($this->_parent);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part;

use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\RawMessage;

/**
 * @final
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
class MessagePart extends DataPart
{
    private $message;

    public function __construct(RawMessage $message)
    {
        if ($message instanceof Message) {
            $name = $message->getHeaders()->getHeaderBody('Subject').'.eml';
        } else {
            $name = 'email.eml';
        }
        parent::__construct('', $name);

        $this->message = $message;
    }

    public function getMediaType(): string
    {
        return 'message';
    }

    public function getMediaSubtype(): string
    {
        return 'rfc822';
    }

    public function getBody(): string
    {
        return $this->message->toString();
    }

    public function bodyToString(): string
    {
        return $this->getBody();
    }

    public function bodyToIterable(): iterable
    {
        return $this->message->toIterable();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part;

use Symfony\Component\Mime\Encoder\Base64ContentEncoder;
use Symfony\Component\Mime\Encoder\ContentEncoderInterface;
use Symfony\Component\Mime\Encoder\EightBitContentEncoder;
use Symfony\Component\Mime\Encoder\QpContentEncoder;
use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Header\Headers;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
class TextPart extends AbstractPart
{
    private static $encoders = [];

    private $body;
    private $charset;
    private $subtype;
    private $disposition;
    private $name;
    private $encoding;

    /**
     * @param resource|string $body
     */
    public function __construct($body, ?string $charset = 'utf-8', $subtype = 'plain', string $encoding = null)
    {
        parent::__construct();

        if (!\is_string($body) && !\is_resource($body)) {
            throw new \TypeError(sprintf('The body of "%s" must be a string or a resource (got "%s").', self::class, \is_object($body) ? \get_class($body) : \gettype($body)));
        }

        $this->body = $body;
        $this->charset = $charset;
        $this->subtype = $subtype;

        if (null === $encoding) {
            $this->encoding = $this->chooseEncoding();
        } else {
            if ('quoted-printable' !== $encoding && 'base64' !== $encoding && '8bit' !== $encoding) {
                throw new InvalidArgumentException(sprintf('The encoding must be one of "quoted-printable", "base64", or "8bit" ("%s" given).', $encoding));
            }
            $this->encoding = $encoding;
        }
    }

    public function getMediaType(): string
    {
        return 'text';
    }

    public function getMediaSubtype(): string
    {
        return $this->subtype;
    }

    /**
     * @param string $disposition one of attachment, inline, or form-data
     *
     * @return $this
     */
    public function setDisposition(string $disposition)
    {
        $this->disposition = $disposition;

        return $this;
    }

    /**
     * Sets the name of the file (used by FormDataPart).
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getBody(): string
    {
        if (!\is_resource($this->body)) {
            return $this->body;
        }

        if (stream_get_meta_data($this->body)['seekable'] ?? false) {
            rewind($this->body);
        }

        return stream_get_contents($this->body) ?: '';
    }

    public function bodyToString(): string
    {
        return $this->getEncoder()->encodeString($this->getBody(), $this->charset);
    }

    public function bodyToIterable(): iterable
    {
        if (\is_resource($this->body)) {
            if (stream_get_meta_data($this->body)['seekable'] ?? false) {
                rewind($this->body);
            }
            yield from $this->getEncoder()->encodeByteStream($this->body);
        } else {
            yield $this->getEncoder()->encodeString($this->body);
        }
    }

    public function getPreparedHeaders(): Headers
    {
        $headers = parent::getPreparedHeaders();

        $headers->setHeaderBody('Parameterized', 'Content-Type', $this->getMediaType().'/'.$this->getMediaSubtype());
        if ($this->charset) {
            $headers->setHeaderParameter('Content-Type', 'charset', $this->charset);
        }
        if ($this->name) {
            $headers->setHeaderParameter('Content-Type', 'name', $this->name);
        }
        $headers->setHeaderBody('Text', 'Content-Transfer-Encoding', $this->encoding);

        if (!$headers->has('Content-Disposition') && null !== $this->disposition) {
            $headers->setHeaderBody('Parameterized', 'Content-Disposition', $this->disposition);
            if ($this->name) {
                $headers->setHeaderParameter('Content-Disposition', 'name', $this->name);
            }
        }

        return $headers;
    }

    private function getEncoder(): ContentEncoderInterface
    {
        if ('8bit' === $this->encoding) {
            return self::$encoders[$this->encoding] ?? (self::$encoders[$this->encoding] = new EightBitContentEncoder());
        }

        if ('quoted-printable' === $this->encoding) {
            return self::$encoders[$this->encoding] ?? (self::$encoders[$this->encoding] = new QpContentEncoder());
        }

        return self::$encoders[$this->encoding] ?? (self::$encoders[$this->encoding] = new Base64ContentEncoder());
    }

    private function chooseEncoding(): string
    {
        if (null === $this->charset) {
            return 'base64';
        }

        return 'quoted-printable';
    }

    public function __sleep()
    {
        // convert resources to strings for serialization
        if (\is_resource($this->body)) {
            $this->body = $this->getBody();
        }

        $this->_headers = $this->getHeaders();

        return ['_headers', 'body', 'charset', 'subtype', 'disposition', 'name', 'encoding'];
    }

    public function __wakeup()
    {
        $r = new \ReflectionProperty(AbstractPart::class, 'headers');
        $r->setAccessible(true);
        $r->setValue($this, $this->_headers);
        unset($this->_headers);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 T��             (   �  �                             1     � t     1     ӃZqk�v�*� %�v�*� %�ӃZqk�       �               A b s t r a c t M u l t i p a r t P a r t . p h p     1     x b     1     _�aqk�#G/� %�#G/� %�_�aqk�       �               A b s t r a c t P a r t . p h p       1     p Z     1     <�mqk��4� %��4� %�<�mqk�        #               D a t a P a r t . p h p       1     p `     1     �tqk�Nn6� %�Nn6� %��tqk�                     M e s s a g e P a r t . p h p 1     h T     1     :�qk���?� %�:�qk�:�qk�                       	 M u l t i p a r t p h 1     p Z     1     ܨ�qk�jFN� %�jFN� %�ܨ�qk�        �               T e x t P a r t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part\Multipart;

use Symfony\Component\Mime\Part\AbstractMultipartPart;
use Symfony\Component\Mime\Part\MessagePart;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
final class DigestPart extends AbstractMultipartPart
{
    public function __construct(MessagePart ...$parts)
    {
        parent::__construct(...$parts);
    }

    public function getMediaSubtype(): string
    {
        return 'digest';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part\Multipart;

use Symfony\Component\Mime\Exception\InvalidArgumentException;
use Symfony\Component\Mime\Part\AbstractMultipartPart;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\TextPart;

/**
 * Implements RFC 7578.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
final class FormDataPart extends AbstractMultipartPart
{
    private $fields = [];

    /**
     * @param (string|array|DataPart)[] $fields
     */
    public function __construct(array $fields = [])
    {
        parent::__construct();

        foreach ($fields as $name => $value) {
            if (!\is_string($value) && !\is_array($value) && !$value instanceof TextPart) {
                throw new InvalidArgumentException(sprintf('A form field value can only be a string, an array, or an instance of TextPart ("%s" given).', \is_object($value) ? \get_class($value) : \gettype($value)));
            }

            $this->fields[$name] = $value;
        }
        // HTTP does not support \r\n in header values
        $this->getHeaders()->setMaxLineLength(PHP_INT_MAX);
    }

    public function getMediaSubtype(): string
    {
        return 'form-data';
    }

    public function getParts(): array
    {
        return $this->prepareFields($this->fields);
    }

    private function prepareFields(array $fields): array
    {
        $values = [];
        array_walk_recursive($fields, function ($item, $key) use (&$values) {
            if (!\is_array($item)) {
                $values[] = $this->preparePart($key, $item);
            }
        });

        return $values;
    }

    private function preparePart($name, $value): TextPart
    {
        if (\is_string($value)) {
            return $this->configurePart($name, new TextPart($value, 'utf-8', 'plain', '8bit'));
        }

        return $this->configurePart($name, $value);
    }

    private function configurePart(string $name, TextPart $part): TextPart
    {
        static $r;

        if (null === $r) {
            $r = new \ReflectionProperty(TextPart::class, 'encoding');
            $r->setAccessible(true);
        }

        $part->setDisposition('form-data');
        $part->setName($name);
        // HTTP does not support \r\n in header values
        $part->getHeaders()->setMaxLineLength(PHP_INT_MAX);
        $r->setValue($part, '8bit');

        return $part;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Part\Multipart;

use Symfony\Component\Mime\Part\AbstractMultipartPart;
use Symfony\Component\Mime\Part\AbstractPart;

/**
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @experimental in 4.3
 */
final class RelatedPart extends AbstractMultipartPart
{
    private $mainPart;

    public function __construct(AbstractPart $mainPart, AbstractPart $part, AbstractPart ...$parts)
    {
        $this->mainPart = $mainPart;
        $this->prepareParts($part, ...$parts);

        parent::__construct($part, ...$parts);
    }

    public function getParts(): array
    {
        return array_merge([$this->mainPart], parent::getParts());
    }

    public function getMediaSubtype(): string
    {
        return 'related';
    }

    private function generateContentId(): string
    {
        return bin2hex(random_bytes(16)).'@symfony';
    }

    private function prepareParts(AbstractPart ...$parts): void
    {
        foreach ($parts as $part) {
            if (!$part->getHeaders()->has('Content-ID')) {
                $part->getHeaders()->setHeaderBody('Id', 'Content-ID', $this->generateContentId());
            }
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// load new map
$data = file_get_contents('https://svn.apache.org/repos/asf/httpd/httpd/trunk/docs/conf/mime.types');
$new = [];
foreach (explode("\n", $data) as $line) {
    if (!$line || '#' == $line[0]) {
        continue;
    }
    $mimeType = substr($line, 0, strpos($line, "\t"));
    $extensions = explode(' ', substr($line, strrpos($line, "\t") + 1));
    $new[$mimeType] = $extensions;
}

$xml = simplexml_load_string(file_get_contents('https://raw.github.com/minad/mimemagic/master/script/freedesktop.org.xml'));
foreach ($xml as $node) {
    $exts = [];
    foreach ($node->glob as $glob) {
        $pattern = (string) $glob['pattern'];
        if ('*' != $pattern[0] || '.' != $pattern[1]) {
            continue;
        }

        $exts[] = substr($pattern, 2);
    }

    if (!$exts) {
        continue;
    }

    $mt = strtolower((string) $node['type']);
    $new[$mt] = array_merge($new[$mt] ?? [], $exts);
    foreach ($node->alias as $alias) {
        $mt = strtolower((string) $alias['type']);
        $new[$mt] = array_merge($new[$mt] ?? [], $exts);
    }
}

// load current map
$data = file_get_contents($output = __DIR__.'/../../MimeTypes.php');
$current = [];
$pre = '';
$post = '';
foreach (explode("\n", $data) as $line) {
    if (!preg_match("{^        '([^']+/[^']+)' => \['(.+)'\],$}", $line, $matches)) {
        if (!$current) {
            $pre .= $line."\n";
        } else {
            $post .= $line."\n";
        }
        continue;
    }
    $current[$matches[1]] = explode("', '", $matches[2]);
}

// we merge the 2 maps (we never remove old mime types)
$map = array_replace_recursive($current, $new);
ksort($map);

$data = $pre;
foreach ($map as $mimeType => $exts) {
    $data .= sprintf("        '%s' => ['%s'],\n", $mimeType, implode("', '", array_unique($exts)));
}
$data .= $post;

// reverse map
// we prefill the extensions with some preferences for content-types
$exts = [
    'aif' => ['audio/x-aiff'],
    'aiff' => ['audio/x-aiff'],
    'aps' => ['application/postscript'],
    'avi' => ['video/avi'],
    'bmp' => ['image/bmp'],
    'bz2' => ['application/x-bz2'],
    'css' => ['text/css'],
    'csv' => ['text/csv'],
    'dmg' => ['application/x-apple-diskimage'],
    'doc' => ['application/msword'],
    'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document'],
    'eml' => ['message/rfc822'],
    'exe' => ['application/x-ms-dos-executable'],
    'flv' => ['video/x-flv'],
    'gif' => ['image/gif'],
    'gz' => ['application/x-gzip'],
    'hqx' => ['application/stuffit'],
    'htm' => ['text/html'],
    'html' => ['text/html'],
    'jar' => ['application/x-java-archive'],
    'jpeg' => ['image/jpeg'],
    'jpg' => ['image/jpeg'],
    'js' => ['text/javascript'],
    'm3u' => ['audio/x-mpegurl'],
    'm4a' => ['audio/mp4'],
    'mdb' => ['application/x-msaccess'],
    'mid' => ['audio/midi'],
    'midi' => ['audio/midi'],
    'mov' => ['video/quicktime'],
    'mp3' => ['audio/mpeg'],
    'mp4' => ['video/mp4'],
    'mpeg' => ['video/mpeg'],
    'mpg' => ['video/mpeg'],
    'odg' => ['vnd.oasis.opendocument.graphics'],
    'odp' => ['vnd.oasis.opendocument.presentation'],
    'ods' => ['vnd.oasis.opendocument.spreadsheet'],
    'odt' => ['vnd.oasis.opendocument.text'],
    'ogg' => ['audio/ogg'],
    'pdf' => ['application/pdf'],
    'php' => ['application/x-php'],
    'php3' => ['application/x-php'],
    'php4' => ['application/x-php'],
    'php5' => ['application/x-php'],
    'png' => ['image/png'],
    'ppt' => ['application/vnd.ms-powerpoint'],
    'pptx' => ['application/vnd.openxmlformats-officedocument.presentationml.presentation'],
    'ps' => ['application/postscript'],
    'rar' => ['application/x-rar-compressed'],
    'rtf' => ['application/rtf'],
    'sit' => ['application/x-stuffit'],
    'svg' => ['image/svg+xml'],
    'tar' => ['application/x-tar'],
    'tif' => ['image/tiff'],
    'tiff' => ['image/tiff'],
    'ttf' => ['application/x-font-truetype'],
    'txt' => ['text/plain'],
    'vcf' => ['text/x-vcard'],
    'wav' => ['audio/wav'],
    'wma' => ['audio/x-ms-wma'],
    'wmv' => ['audio/x-ms-wmv'],
    'xls' => ['application/vnd.ms-excel'],
    'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
    'xml' => ['application/xml'],
    'zip' => ['application/zip'],
];
foreach ($map as $mimeType => $extensions) {
    foreach ($extensions as $extension) {
        $exts[$extension][] = $mimeType;
    }
}
ksort($exts);

$updated = '';
$state = 0;
foreach (explode("\n", $data) as $line) {
    if (!preg_match("{^        '([^'/]+)' => \['(.+)'\],$}", $line, $matches)) {
        if (1 === $state) {
            $state = 2;
            foreach ($exts as $ext => $mimeTypes) {
                $updated .= sprintf("        '%s' => ['%s'],\n", $ext, implode("', '", array_unique($mimeTypes)));
            }
        }
        $updated .= $line."\n";
        continue;
    }
    $state = 1;
}

$updated = preg_replace('{Updated from upstream on .+?\.}', 'Updated from upstream on '.date('Y-m-d'), $updated, -1);

file_put_contents($output, rtrim($updated, "\n")."\n");

echo "Done.\n";
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\MimeTypeGuesserInterface;

abstract class AbstractMimeTypeGuesserTest extends TestCase
{
    public static function tearDownAfterClass()
    {
        $path = __DIR__.'/Fixtures/mimetypes/to_delete';
        if (file_exists($path)) {
            @chmod($path, 0666);
            @unlink($path);
        }
    }

    abstract protected function getGuesser(): MimeTypeGuesserInterface;

    public function testGuessImageWithoutExtension()
    {
        if (!$this->getGuesser()->isGuesserSupported()) {
            $this->markTestSkipped('Guesser is not supported');
        }

        $this->assertEquals('image/gif', $this->getGuesser()->guessMimeType(__DIR__.'/Fixtures/mimetypes/test'));
    }

    public function testGuessImageWithDirectory()
    {
        if (!$this->getGuesser()->isGuesserSupported()) {
            $this->markTestSkipped('Guesser is not supported');
        }

        $this->expectException('\InvalidArgumentException');
        $this->getGuesser()->guessMimeType(__DIR__.'/Fixtures/mimetypes/directory');
    }

    public function testGuessImageWithKnownExtension()
    {
        if (!$this->getGuesser()->isGuesserSupported()) {
            $this->markTestSkipped('Guesser is not supported');
        }

        $this->assertEquals('image/gif', $this->getGuesser()->guessMimeType(__DIR__.'/Fixtures/mimetypes/test.gif'));
    }

    public function testGuessFileWithUnknownExtension()
    {
        if (!$this->getGuesser()->isGuesserSupported()) {
            $this->markTestSkipped('Guesser is not supported');
        }

        $this->assertEquals('application/octet-stream', $this->getGuesser()->guessMimeType(__DIR__.'/Fixtures/mimetypes/.unknownextension'));
    }

    public function testGuessWithIncorrectPath()
    {
        if (!$this->getGuesser()->isGuesserSupported()) {
            $this->markTestSkipped('Guesser is not supported');
        }

        $this->expectException('\InvalidArgumentException');
        $this->getGuesser()->guessMimeType(__DIR__.'/Fixtures/mimetypes/not_here');
    }

    public function testGuessWithNonReadablePath()
    {
        if (!$this->getGuesser()->isGuesserSupported()) {
            $this->markTestSkipped('Guesser is not supported');
        }

        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('Can not verify chmod operations on Windows');
        }

        if (!getenv('USER') || 'root' === getenv('USER')) {
            $this->markTestSkipped('This test will fail if run under superuser');
        }

        $path = __DIR__.'/Fixtures/mimetypes/to_delete';
        touch($path);
        @chmod($path, 0333);

        if ('0333' == substr(sprintf('%o', fileperms($path)), -4)) {
            $this->expectException('\InvalidArgumentException');
            $this->getGuesser()->guessMimeType($path);
        } else {
            $this->markTestSkipped('Can not verify chmod operations, change of file permissions failed');
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\NamedAddress;

class AddressTest extends TestCase
{
    public function testConstructor()
    {
        $a = new Address('fabien@symfonï.com');
        $this->assertEquals('fabien@symfonï.com', $a->getAddress());
        $this->assertEquals('fabien@xn--symfon-nwa.com', $a->toString());
        $this->assertEquals('fabien@xn--symfon-nwa.com', $a->getEncodedAddress());
    }

    public function testConstructorWithInvalidAddress()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Address('fab   pot@symfony.com');
    }

    public function testCreate()
    {
        $this->assertSame($a = new Address('fabien@symfony.com'), Address::create($a));
        $this->assertSame($b = new NamedAddress('helene@symfony.com', 'Helene'), Address::create($b));
        $this->assertEquals($a, Address::create('fabien@symfony.com'));
    }

    public function testCreateWrongArg()
    {
        $this->expectException(\InvalidArgumentException::class);
        Address::create(new \stdClass());
    }

    public function testCreateArray()
    {
        $fabien = new Address('fabien@symfony.com');
        $helene = new NamedAddress('helene@symfony.com', 'Helene');
        $this->assertSame([$fabien, $helene], Address::createArray([$fabien, $helene]));

        $this->assertEquals([$fabien], Address::createArray(['fabien@symfony.com']));
    }

    public function testCreateArrayWrongArg()
    {
        $this->expectException(\InvalidArgumentException::class);
        Address::createArray([new \stdClass()]);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\CharacterStream;

class CharacterStreamTest extends TestCase
{
    public function testReadCharactersAreInTact()
    {
        $stream = new CharacterStream(pack('C*', 0xD0, 0x94, 0xD0, 0xB6, 0xD0, 0xBE));
        $stream->write(pack('C*',
            0xD0, 0xBB,
            0xD1, 0x8E,
            0xD0, 0xB1,
            0xD1, 0x8B,
            0xD1, 0x85
        ));
        $this->assertSame(pack('C*', 0xD0, 0x94), $stream->read(1));
        $this->assertSame(pack('C*', 0xD0, 0xB6, 0xD0, 0xBE), $stream->read(2));
        $this->assertSame(pack('C*', 0xD0, 0xBB), $stream->read(1));
        $this->assertSame(pack('C*', 0xD1, 0x8E, 0xD0, 0xB1, 0xD1, 0x8B), $stream->read(3));
        $this->assertSame(pack('C*', 0xD1, 0x85), $stream->read(1));
        $this->assertNull($stream->read(1));
    }

    public function testCharactersCanBeReadAsByteArrays()
    {
        $stream = new CharacterStream(pack('C*', 0xD0, 0x94, 0xD0, 0xB6, 0xD0, 0xBE));
        $stream->write(pack('C*',
            0xD0, 0xBB,
            0xD1, 0x8E,
            0xD0, 0xB1,
            0xD1, 0x8B,
            0xD1, 0x85
        ));
        $this->assertEquals([0xD0, 0x94], $stream->readBytes(1));
        $this->assertEquals([0xD0, 0xB6, 0xD0, 0xBE], $stream->readBytes(2));
        $this->assertEquals([0xD0, 0xBB], $stream->readBytes(1));
        $this->assertEquals([0xD1, 0x8E, 0xD0, 0xB1, 0xD1, 0x8B], $stream->readBytes(3));
        $this->assertEquals([0xD1, 0x85], $stream->readBytes(1));
        $this->assertNull($stream->readBytes(1));
    }

    public function testRequestingLargeCharCountPastEndOfStream()
    {
        $stream = new CharacterStream(pack('C*', 0xD0, 0x94, 0xD0, 0xB6, 0xD0, 0xBE));
        $this->assertSame(pack('C*', 0xD0, 0x94, 0xD0, 0xB6, 0xD0, 0xBE), $stream->read(100));
        $this->assertNull($stream->read(1));
    }

    public function testRequestingByteArrayCountPastEndOfStream()
    {
        $stream = new CharacterStream(pack('C*', 0xD0, 0x94, 0xD0, 0xB6, 0xD0, 0xBE));
        $this->assertEquals([0xD0, 0x94, 0xD0, 0xB6, 0xD0, 0xBE], $stream->readBytes(100));
        $this->assertNull($stream->readBytes(1));
    }

    public function testPointerOffsetCanBeSet()
    {
        $stream = new CharacterStream(pack('C*', 0xD0, 0x94, 0xD0, 0xB6, 0xD0, 0xBE));
        $this->assertSame(pack('C*', 0xD0, 0x94), $stream->read(1));
        $stream->setPointer(0);
        $this->assertSame(pack('C*', 0xD0, 0x94), $stream->read(1));
        $stream->setPointer(2);
        $this->assertSame(pack('C*', 0xD0, 0xBE), $stream->read(1));
    }

    public function testAlgorithmWithFixedWidthCharsets()
    {
        $stream = new CharacterStream(pack('C*', 0xD1, 0x8D, 0xD0, 0xBB, 0xD0, 0xB0));
        $this->assertSame(pack('C*', 0xD1, 0x8D), $stream->read(1));
        $this->assertSame(pack('C*', 0xD0, 0xBB), $stream->read(1));
        $this->assertSame(pack('C*', 0xD0, 0xB0), $stream->read(1));
        $this->assertNull($stream->read(1));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\AlternativePart;
use Symfony\Component\Mime\Part\Multipart\MixedPart;
use Symfony\Component\Mime\Part\Multipart\RelatedPart;
use Symfony\Component\Mime\Part\TextPart;

class EmailTest extends TestCase
{
    public function testSubject()
    {
        $e = new Email();
        $e->subject('Subject');
        $this->assertEquals('Subject', $e->getSubject());
    }

    public function testDate()
    {
        $e = new Email();
        $e->date($d = new \DateTimeImmutable());
        $this->assertSame($d, $e->getDate());
    }

    public function testReturnPath()
    {
        $e = new Email();
        $e->returnPath('fabien@symfony.com');
        $this->assertEquals(new Address('fabien@symfony.com'), $e->getReturnPath());
    }

    public function testSender()
    {
        $e = new Email();
        $e->sender('fabien@symfony.com');
        $this->assertEquals(new Address('fabien@symfony.com'), $e->getSender());

        $e->sender($fabien = new Address('fabien@symfony.com'));
        $this->assertSame($fabien, $e->getSender());
    }

    public function testFrom()
    {
        $e = new Email();
        $helene = new Address('helene@symfony.com');
        $thomas = new NamedAddress('thomas@symfony.com', 'Thomas');
        $caramel = new Address('caramel@symfony.com');

        $this->assertSame($e, $e->from('fabien@symfony.com', $helene, $thomas));
        $v = $e->getFrom();
        $this->assertCount(3, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);

        $this->assertSame($e, $e->addFrom('lucas@symfony.com', $caramel));
        $v = $e->getFrom();
        $this->assertCount(5, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);
        $this->assertEquals(new Address('lucas@symfony.com'), $v[3]);
        $this->assertSame($caramel, $v[4]);

        $e = new Email();
        $e->addFrom('lucas@symfony.com', $caramel);
        $this->assertCount(2, $e->getFrom());

        $e = new Email();
        $e->from('lucas@symfony.com');
        $e->from($caramel);
        $this->assertSame([$caramel], $e->getFrom());
    }

    public function testReplyTo()
    {
        $e = new Email();
        $helene = new Address('helene@symfony.com');
        $thomas = new NamedAddress('thomas@symfony.com', 'Thomas');
        $caramel = new Address('caramel@symfony.com');

        $this->assertSame($e, $e->replyTo('fabien@symfony.com', $helene, $thomas));
        $v = $e->getReplyTo();
        $this->assertCount(3, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);

        $this->assertSame($e, $e->addReplyTo('lucas@symfony.com', $caramel));
        $v = $e->getReplyTo();
        $this->assertCount(5, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);
        $this->assertEquals(new Address('lucas@symfony.com'), $v[3]);
        $this->assertSame($caramel, $v[4]);

        $e = new Email();
        $e->addReplyTo('lucas@symfony.com', $caramel);
        $this->assertCount(2, $e->getReplyTo());

        $e = new Email();
        $e->replyTo('lucas@symfony.com');
        $e->replyTo($caramel);
        $this->assertSame([$caramel], $e->getReplyTo());
    }

    public function testTo()
    {
        $e = new Email();
        $helene = new Address('helene@symfony.com');
        $thomas = new NamedAddress('thomas@symfony.com', 'Thomas');
        $caramel = new Address('caramel@symfony.com');

        $this->assertSame($e, $e->to('fabien@symfony.com', $helene, $thomas));
        $v = $e->getTo();
        $this->assertCount(3, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);

        $this->assertSame($e, $e->addTo('lucas@symfony.com', $caramel));
        $v = $e->getTo();
        $this->assertCount(5, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);
        $this->assertEquals(new Address('lucas@symfony.com'), $v[3]);
        $this->assertSame($caramel, $v[4]);

        $e = new Email();
        $e->addTo('lucas@symfony.com', $caramel);
        $this->assertCount(2, $e->getTo());

        $e = new Email();
        $e->to('lucas@symfony.com');
        $e->to($caramel);
        $this->assertSame([$caramel], $e->getTo());
    }

    public function testCc()
    {
        $e = new Email();
        $helene = new Address('helene@symfony.com');
        $thomas = new NamedAddress('thomas@symfony.com', 'Thomas');
        $caramel = new Address('caramel@symfony.com');

        $this->assertSame($e, $e->cc('fabien@symfony.com', $helene, $thomas));
        $v = $e->getCc();
        $this->assertCount(3, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);

        $this->assertSame($e, $e->addCc('lucas@symfony.com', $caramel));
        $v = $e->getCc();
        $this->assertCount(5, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);
        $this->assertEquals(new Address('lucas@symfony.com'), $v[3]);
        $this->assertSame($caramel, $v[4]);

        $e = new Email();
        $e->addCc('lucas@symfony.com', $caramel);
        $this->assertCount(2, $e->getCc());

        $e = new Email();
        $e->cc('lucas@symfony.com');
        $e->cc($caramel);
        $this->assertSame([$caramel], $e->getCc());
    }

    public function testBcc()
    {
        $e = new Email();
        $helene = new Address('helene@symfony.com');
        $thomas = new NamedAddress('thomas@symfony.com', 'Thomas');
        $caramel = new Address('caramel@symfony.com');

        $this->assertSame($e, $e->bcc('fabien@symfony.com', $helene, $thomas));
        $v = $e->getBcc();
        $this->assertCount(3, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);

        $this->assertSame($e, $e->addBcc('lucas@symfony.com', $caramel));
        $v = $e->getBcc();
        $this->assertCount(5, $v);
        $this->assertEquals(new Address('fabien@symfony.com'), $v[0]);
        $this->assertSame($helene, $v[1]);
        $this->assertSame($thomas, $v[2]);
        $this->assertEquals(new Address('lucas@symfony.com'), $v[3]);
        $this->assertSame($caramel, $v[4]);

        $e = new Email();
        $e->addBcc('lucas@symfony.com', $caramel);
        $this->assertCount(2, $e->getBcc());

        $e = new Email();
        $e->bcc('lucas@symfony.com');
        $e->bcc($caramel);
        $this->assertSame([$caramel], $e->getBcc());
    }

    public function testPriority()
    {
        $e = new Email();
        $this->assertEquals(3, $e->getPriority());

        $e->priority(1);
        $this->assertEquals(1, $e->getPriority());
        $e->priority(10);
        $this->assertEquals(5, $e->getPriority());
        $e->priority(-10);
        $this->assertEquals(1, $e->getPriority());
    }

    public function testGenerateBodyThrowsWhenEmptyBody()
    {
        $this->expectException(\LogicException::class);
        (new Email())->getBody();
    }

    public function testGetBody()
    {
        $e = new Email();
        $e->setBody($text = new TextPart('text content'));
        $this->assertEquals($text, $e->getBody());
    }

    public function testGenerateBody()
    {
        $text = new TextPart('text content');
        $html = new TextPart('html content', 'utf-8', 'html');
        $att = new DataPart($file = fopen(__DIR__.'/Fixtures/mimetypes/test', 'r'));
        $img = new DataPart($image = fopen(__DIR__.'/Fixtures/mimetypes/test.gif', 'r'), 'test.gif');

        $e = new Email();
        $e->text('text content');
        $this->assertEquals($text, $e->getBody());
        $this->assertEquals('text content', $e->getTextBody());

        $e = new Email();
        $e->html('html content');
        $this->assertEquals($html, $e->getBody());
        $this->assertEquals('html content', $e->getHtmlBody());

        $e = new Email();
        $e->html('html content');
        $e->text('text content');
        $this->assertEquals(new AlternativePart($text, $html), $e->getBody());

        $e = new Email();
        $e->html('html content', 'iso-8859-1');
        $e->text('text content', 'iso-8859-1');
        $this->assertEquals('iso-8859-1', $e->getTextCharset());
        $this->assertEquals('iso-8859-1', $e->getHtmlCharset());
        $this->assertEquals(new AlternativePart(new TextPart('text content', 'iso-8859-1'), new TextPart('html content', 'iso-8859-1', 'html')), $e->getBody());

        $e = new Email();
        $e->attach($file);
        $e->text('text content');
        $this->assertEquals(new MixedPart($text, $att), $e->getBody());

        $e = new Email();
        $e->attach($file);
        $e->html('html content');
        $this->assertEquals(new MixedPart($html, $att), $e->getBody());

        $e = new Email();
        $e->html('html content');
        $e->text('text content');
        $e->attach($file);
        $this->assertEquals(new MixedPart(new AlternativePart($text, $html), $att), $e->getBody());

        $e = new Email();
        $e->html('html content');
        $e->text('text content');
        $e->attach($file);
        $e->attach($image, 'test.gif');
        $this->assertEquals(new MixedPart(new AlternativePart($text, $html), $att, $img), $e->getBody());

        $e = new Email();
        $e->text('text content');
        $e->attach($file);
        $e->attach($image, 'test.gif');
        $this->assertEquals(new MixedPart($text, $att, $img), $e->getBody());

        $e = new Email();
        $e->html($content = 'html content <img src="test.gif">');
        $e->text('text content');
        $e->attach($file);
        $e->attach($image, 'test.gif');
        $fullhtml = new TextPart($content, 'utf-8', 'html');
        $this->assertEquals(new MixedPart(new AlternativePart($text, $fullhtml), $att, $img), $e->getBody());

        $e = new Email();
        $e->html($content = 'html content <img src="cid:test.gif">');
        $e->text('text content');
        $e->attach($file);
        $e->attach($image, 'test.gif');
        $fullhtml = new TextPart($content, 'utf-8', 'html');
        $inlinedimg = (new DataPart($image, 'test.gif'))->asInline();
        $body = $e->getBody();
        $this->assertInstanceOf(MixedPart::class, $body);
        $this->assertCount(2, $related = $body->getParts());
        $this->assertInstanceOf(RelatedPart::class, $related[0]);
        $this->assertEquals($att, $related[1]);
        $this->assertCount(2, $parts = $related[0]->getParts());
        $this->assertInstanceOf(AlternativePart::class, $parts[0]);
        $generatedHtml = $parts[0]->getParts()[1];
        $this->assertContains('cid:'.$parts[1]->getContentId(), $generatedHtml->getBody());

        $content = 'html content <img src="cid:test.gif">';
        $r = fopen('php://memory', 'r+', false);
        fwrite($r, $content);
        rewind($r);

        $e = new Email();
        $e->html($r);
        // embedding the same image twice results in one image only in the email
        $e->embed($image, 'test.gif');
        $e->embed($image, 'test.gif');
        $body = $e->getBody();
        $this->assertInstanceOf(RelatedPart::class, $body);
        // 2 parts only, not 3 (text + embedded image once)
        $this->assertCount(2, $parts = $body->getParts());
        $this->assertStringMatchesFormat('html content <img src=3D"cid:%s@symfony">', $parts[0]->bodyToString());
    }

    public function testAttachments()
    {
        $contents = file_get_contents($name = __DIR__.'/Fixtures/mimetypes/test', 'r');
        $att = new DataPart($file = fopen($name, 'r'), 'test');
        $inline = (new DataPart($contents, 'test'))->asInline();
        $e = new Email();
        $e->attach($file, 'test');
        $e->embed($contents, 'test');
        $this->assertEquals([$att, $inline], $e->getAttachments());

        $att = DataPart::fromPath($name, 'test');
        $inline = DataPart::fromPath($name, 'test')->asInline();
        $e = new Email();
        $e->attachFromPath($name);
        $e->embedFromPath($name);
        $this->assertEquals([$att->bodyToString(), $inline->bodyToString()], array_map(function (DataPart $a) { return $a->bodyToString(); }, $e->getAttachments()));
        $this->assertEquals([$att->getPreparedHeaders(), $inline->getPreparedHeaders()], array_map(function (DataPart $a) { return $a->getPreparedHeaders(); }, $e->getAttachments()));
    }

    public function testSerialize()
    {
        $r = fopen('php://memory', 'r+', false);
        fwrite($r, 'Text content');
        rewind($r);

        $e = new Email();
        $e->from('fabien@symfony.com');
        $e->text($r);
        $e->html($r);
        $contents = file_get_contents($name = __DIR__.'/Fixtures/mimetypes/test', 'r');
        $file = fopen($name, 'r');
        $e->attach($file, 'test');
        $expected = clone $e;
        $n = unserialize(serialize($e));
        $this->assertEquals($expected->getHeaders(), $n->getHeaders());
        $this->assertEquals($e->getBody(), $n->getBody());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          INDX( 	 ��             (   �  �         f                   '1     � �     &1     ) �qk���W� %���W� %�) �qk�       �               A b s t r a c t M i m e T y p e G u e s s e r T e s t . p h p (1     p `     &1     ڈ�qk�!�c� %�!�c� %�ڈ�qk�       �               A d d r e s s T e s t . p h p )1     � p     &1     �qk�
f� %�
f� %��qk�       �               C h a r a c t e r S t r e a m T e s t . p h p 21     x h     &1     2��qk�
f� %�2��qk�2��qk�                       D e p e n d e n c y I n j e c t i o n *1     p \     &1     ���qk��Dm� %��Dm� %����qk� @      �7               E m a i l T e s t . p h p     41     ` P     &1     *��qk�O0y� %�*��qk�*��qk�                        E n c o d e r +1     � �     &1     C��qk���}� %���}� %�C��qk�P      I              ! F i l e B i n a r y M i m e T y p e G u e s s e r T e s t . p h p     ,1     � �     &1     ��qk�eW�� %�eW�� %���qk�p      k               F i l e i n  o M i m e T y p e G u e s s e r T e s t . p h p :1     h R     &1     $qk��qk��qk��qk�                        F i x t u r e s o n v L1     ` N     &1     s�8qk�(}�� %�s�8qk�s�8qk�                        H e a d e r e -1     � r     &1     ޸�qk�9��� %�9��� %�޸�qk�       �               M e s s a g e C o n v e r t e r T e s t . p h p       .1     p `     &1     =A�qk��� %��� %�=A�qk�        �               M e s s a g e T e s t . p h p /1     x d    &1     i�qk�O˴� %�O˴� %�i�qk�       �               M i m e T y p e s T e s t . p h p     01     � j     &1     z��qk�O˴� %�O˴� %�z��qk�       !               N a m e d A d d r e s s T e s t . p h p       U1     ` J     &1     �`�qk�fՕqk�fՕqk�fՕqk�                        P a r t e s s 11     x f     &1     �?�qk���ؤ %���ؤ %��?�qk�                      R a w M e s s a g e T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\MessageConverter;

class MessageConverterTest extends TestCase
{
    public function testToEmail()
    {
        $file = file_get_contents(__DIR__.'/Fixtures/mimetypes/test.gif');
        $email = (new Email())->from('fabien@symfony.com');
        $this->assertSame($email, MessageConverter::toEmail($email));

        $this->assertConversion((clone $email)->text('text content'));
        $this->assertConversion((clone $email)->html('HTML content <img src="cid:test.jpg" />'));
        $this->assertConversion((clone $email)
            ->text('text content')
            ->html('HTML content <img src="cid:test.jpg" />')
        );
        $this->assertConversion((clone $email)
            ->text('text content')
            ->html('HTML content <img src="cid:test.jpg" />')
            ->embed($file, 'test.jpg', 'image/gif')
        );
        $this->assertConversion((clone $email)
            ->text('text content')
            ->html('HTML content <img src="cid:test.jpg" />')
            ->attach($file, 'test_attached.jpg', 'image/gif')
        );
        $this->assertConversion((clone $email)
            ->text('text content')
            ->html('HTML content <img src="cid:test.jpg" />')
            ->embed($file, 'test.jpg', 'image/gif')
            ->attach($file, 'test_attached.jpg', 'image/gif')
        );
        $this->assertConversion((clone $email)
            ->text('text content')
            ->attach($file, 'test_attached.jpg', 'image/gif')
        );
        $this->assertConversion((clone $email)
            ->html('HTML content <img src="cid:test.jpg" />')
            ->attach($file, 'test_attached.jpg', 'image/gif')
        );
        $this->assertConversion((clone $email)
            ->html('HTML content <img src="cid:test.jpg" />')
            ->embed($file, 'test.jpg', 'image/gif')
        );
        $this->assertConversion((clone $email)
            ->text('text content')
            ->embed($file, 'test_attached.jpg', 'image/gif')
        );
    }

    private function assertConversion(Email $expected)
    {
        $r = new \ReflectionMethod($expected, 'generateBody');
        $r->setAccessible(true);

        $message = new Message($expected->getHeaders(), $r->invoke($expected));
        $converted = MessageConverter::toEmail($message);
        if ($expected->getHtmlBody()) {
            $this->assertStringMatchesFormat(str_replace('cid:test.jpg', 'cid:%s', $expected->getHtmlBody()), $converted->getHtmlBody());
            $expected->html('HTML content');
            $converted->html('HTML content');
        }
        $this->assertEquals($expected, $converted);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Mime\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Header\MailboxListHeader;
use Symfony\Component\Mime\Header\UnstructuredHeader;
use Symfony\Component\Mime\Message;
use Symfony\Component\Mime\NamedAddress;
use Symfony\Component\Mime\Part\TextPart;

class MessageTest extends TestCase
{
    public function testConstruct()
    {
        $m = new Message();
        $this->assertNull($m->getBody());
        $this->assertEquals(new Headers(), $m->getHeaders());

        $m = new Message($h = (new Headers())->addDateHeader('Date', new \DateTime()), $b = new TextPart('content'));
        $this->assertSame($b, $m->getBody());
        $this->assertEquals($h, $m->getHeaders());

        $m = new Message();
        $m->setBody($b);
        $m->setHeaders($h);
        $this->assertSame($b, $m->getBody());
        $this->assertSame($h, $m->getHeaders());
    }

    public function testGetPreparedHeadersThrowsWhenNoFrom()
    {
        $this->expectException(\LogicException::class);
        (new Message())->getPreparedHeaders();
    }

    public function testGetPreparedHeadersCloneHeaders()
    {
        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $this->assertNotSame($message->getPreparedHeaders(), $message->getHeaders());
    }

    public function testGetPreparedHeadersSetRequiredHeaders()
    {
        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $headers = $message->getPreparedHeaders();
        $this->assertTrue($headers->has('MIME-Version'));
        $this->assertTrue($headers->has('Message-ID'));
        $this->assertTrue($headers->has('Date'));
        $this->assertFalse($headers->has('Bcc'));
    }

    public function testGetPreparedHeaders()
    {
        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $h = $message->getPreparedHeaders();
        $this->assertCount(4, iterator_to_array($h->getAll()));
        $this->assertEquals(new MailboxListHeader('From', [new Address('fabien@symfony.com')]), $h->get('From'));
        $this->assertEquals(new UnstructuredHeader('MIME-Version', '1.0'), $h->get('mime-version'));
        $this->assertTrue($h->has('Message-Id'));
        $this->assertTrue($h->has('Date'));

        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $message->getHeaders()->addDateHeader('Date', $n = new \DateTimeImmutable());
        $this->assertEquals($n, $message->getPreparedHeaders()->get('Date')->getDateTime());

        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $message->getHeaders()->addMailboxListHeader('Bcc', ['fabien@symfony.com']);
        $this->assertNull($message->getPreparedHeaders()->get('Bcc'));
    }

    public function testGetPreparedHeadersWithNoFrom()
    {
        $this->expectException(\LogicException::class);
        (new Message())->getPreparedHeaders();
    }

    public function testGetPreparedHeadersWithNamedFrom()
    {
        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', [new NamedAddress('fabien@symfony.com', 'Fabien')]);
        $h = $message->getPreparedHeaders();
        $this->assertEquals(new MailboxListHeader('From', [new NamedAddress('fabien@symfony.com', 'Fabien')]), $h->get('From'));
        $this->assertTrue($h->has('Message-Id'));
    }

    public function testGetPreparedHeadersHasSenderWhenNeeded()
    {
        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $this->assertNull($message->getPreparedHeaders()->get('Sender'));

        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com', 'lucas@symfony.com']);
        $this->assertEquals('fabien@symfony.com', $message->getPreparedHeaders()->get('Sender')->getAddress()->getAddress());

        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com', 'lucas@symfony.com']);
        $message->getHeaders()->addMailboxHeader('Sender', 'thomas@symfony.com');
        $this->assertEquals('thomas@symfony.com', $message->getPreparedHeaders()->get('Sender')->getAddress()->getAddress());
    }

    public function testToString()
    {
        $message = new Message();
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $expected = <<<EOF
From: fabien@symfony.com
MIME-Version: 1.0
Date: %s
Message-ID: <%s@symfony.com>
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: quoted-printable


EOF;
        $this->assertStringMatchesFormat($expected, str_replace("\r\n", "\n", $message->toString()));
        $this->assertStringMatchesFormat($expected, str_replace("\r\n", "\n", implode('', iterator_to_array($message->toIterable(), false))));

        $message = new Message(null, new TextPart('content'));
        $message->getHeaders()->addMailboxListHeader('From', ['fabien@symfony.com']);
        $expected = <<<EOF
From: fabien@symfony.com
MIME-Version: 1.0
Date: %s
Message-ID: <%s@symfony.com>
Content-Type: text/plain; charset=utf-8
Content-Transfer-Encoding: quoted-printable

content
EOF;
        $this->assertSt