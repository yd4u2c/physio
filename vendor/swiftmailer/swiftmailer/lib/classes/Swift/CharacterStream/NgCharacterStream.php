INDX( 	 �A�             (   �  �       �                    �*     � r     �*     �d��pk� D��f��;x���<��d��pk�                      B a s e 6 4 C o n t e n t E n c o d e r . p h p       �*     � v     �*     f*��pk� D��f����ѽ�<�f*��pk�       u               N a t i v e Q p C o n t e n t E n c o d e r . p h p   �*     � n     �*     A���pk� D��f������<�A���pk�       9               N u l l C o n t e n t E n c o d e r . p h p   �*     � p     �*     9��pk� D��f��~N��< 9��pk�        �               P l a i n C o n t e n t E n c o d e r . p h p �*     � j     �*     c�pk� D��f������<�c�pk�        n               Q p C o n t e n t E n c o d e r . p h p       �*     � t     �*     0��pk� D��f������<�0��pk�       2	               Q p C o n t e n t E n c o d e r P r o x y . p h p     �*     � l     �*     �M�pk� D��f�����<��M�pk�                      R a w C o n t e n t E n c o d e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Proxy for quoted-printable content encoders.
 *
 * Switches on the best QP encoder implementation for current charset.
 *
 * @author Jean-François Simon <jeanfrancois.simon@sensiolabs.com>
 */
class Swift_Mime_ContentEncoder_QpContentEncoderProxy implements Swift_Mime_ContentEncoder
{
    /**
     * @var Swift_Mime_ContentEncoder_QpContentEncoder
     */
    private $safeEncoder;

    /**
     * @var Swift_Mime_ContentEncoder_NativeQpContentEncoder
     */
    private $nativeEncoder;

    /**
     * @var null|string
     */
    private $charset;

    /**
     * Constructor.
     *
     * @param string|null $charset
     */
    public function __construct(Swift_Mime_ContentEncoder_QpContentEncoder $safeEncoder, Swift_Mime_ContentEncoder_NativeQpContentEncoder $nativeEncoder, $charset)
    {
        $this->safeEncoder = $safeEncoder;
        $this->nativeEncoder = $nativeEncoder;
        $this->charset = $charset;
    }

    /**
     * Make a deep copy of object.
     */
    public function __clone()
    {
        $this->safeEncoder = clone $this->safeEncoder;
        $this->nativeEncoder = clone $this->nativeEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function charsetChanged($charset)
    {
        $this->charset = $charset;
        $this->safeEncoder->charsetChanged($charset);
    }

    /**
     * {@inheritdoc}
     */
    public function encodeByteStream(Swift_OutputByteStream $os, Swift_InputByteStream $is, $firstLineOffset = 0, $maxLineLength = 0)
    {
        $this->getEncoder()->encodeByteStream($os, $is, $firstLineOffset, $maxLineLength);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'quoted-printable';
    }

    /**
     * {@inheritdoc}
     */
    public function encodeString($string, $firstLineOffset = 0, $maxLineLength = 0)
    {
        return $this->getEncoder()->encodeString($string, $firstLineOffset, $maxLineLength);
    }

    /**
     * @return Swift_Mime_ContentEncoder
     */
    private function getEncoder()
    {
        return 'utf-8' === $this->charset ? $this->nativeEncoder : $this->safeEncoder;
    }
}
                                                                                                                                    