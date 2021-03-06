<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Buffers input and output to a resource.
 *
 * @author Chris Corbyn
 */
interface Swift_Transport_IoBuffer extends Swift_InputByteStream, Swift_OutputByteStream
{
    /** A socket buffer over TCP */
    const TYPE_SOCKET = 0x0001;

    /** A process buffer with I/O support */
    const TYPE_PROCESS = 0x0010;

    /**
     * Perform any initialization needed, using the given $params.
     *
     * Parameters will vary depending upon the type of IoBuffer used.
     *
     * @param array $params
     */
    public function initialize(array $params);

    /**
     * Set an individual param on the buffer (e.g. switching to SSL).
     *
     * @param string $param
     * @param mixed  $value
     */
    public function setParam($param, $value);

    /**
     * Perform any shutdown logic needed.
     */
    public function terminate();

    /**
     * Set an array of string replacements which should be made on data written
     * to the buffer.
     *
     * This could replace LF with CRLF for example.
     *
     * @param string[] $replacements
     */
    public function setWriteTranslations(array $replacements);

    /**
     * Get a line of output (including any CRLF).
     *
     * The $sequence number comes from any writes and may or may not be used
     * depending upon the implementation.
     *
     * @param int $sequence of last write to scan from
     *
     * @return string
     */
    public function readLine($sequence);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Redundantly and rotationally uses several Transports when sending.
 *
 * @author Chris Corbyn
 */
class Swift_Transport_LoadBalancedTransport implements Swift_Transport
{
    /**
     * Transports which are deemed useless.
     *
     * @var Swift_Transport[]
     */
    private $deadTransports = [];

    /**
     * The Transports which are used in rotation.
     *
     * @var Swift_Transport[]
     */
    protected $transports = [];

    /**
     * The Transport used in the last successful send operation.
     *
     * @var Swift_Transport
     */
    protected $lastUsedTransport = null;

    // needed as __construct is called from elsewhere explicitly
    public function __construct()
    {
    }

    /**
     * Set $transports to delegate to.
     *
     * @param Swift_Transport[] $transports
     */
    public function setTransports(array $transports)
    {
        $this->transports = $transports;
        $this->deadTransports = [];
    }

    /**
     * Get $transports to delegate to.
     *
     * @return Swift_Transport[]
     */
    public function getTransports()
    {
        return array_merge($this->transports, $this->deadTransports);
    }

    /**
     * Get the Transport used in the last successful send operation.
     *
     * @return Swift_Transport
     */
    public function getLastUsedTransport()
    {
        return $this->lastUsedTransport;
    }

    /**
     * Test if this Transport mechanism has started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return count($this->transports) > 0;
    }

    /**
     * Start this Transport mechanism.
     */
    public function start()
    {
        $this->transports = array_merge($this->transports, $this->deadTransports);
    }

    /**
     * Stop this Transport mechanism.
     */
    public function stop()
    {
        foreach ($this->transports as $transport) {
            $transport->stop();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function ping()
    {
        foreach ($this->transports as $transport) {
            if (!$transport->ping()) {
                $this->killCurrentTransport();
            }
        }

        return count($this->transports) > 0;
    }

    /**
     * Send the given Message.
     *
     * Recipient/sender data will be retrieved from the Message API.
     * The return value is the number of recipients who were accepted for delivery.
     *
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $maxTransports = count($this->transports);
        $sent = 0;
        $this->lastUsedTr