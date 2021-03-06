<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Redundantly and rotationally uses several Transport implementations when sending.
 *
 * @author Chris Corbyn
 */
class Swift_LoadBalancedTransport extends Swift_Transport_LoadBalancedTransport
{
    /**
     * Creates a new LoadBalancedTransport with $transports.
     *
     * @param array $transports
     */
    public function __construct($transports = [])
    {
        call_user_func_array(
            [$this, 'Swift_Transport_LoadBalancedTransport::__construct'],
            Swift_DependencyContainer::getInstance()
                ->createDependenciesFor('transport.loadbalanced')
            );

        $this->setTransports($transports);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Swift Mailer class.
 *
 * @author Chris Corbyn
 */
class Swift_Mailer
{
    /** The Transport used to send messages */
    private $transport;

    /**
     * Create a new Mailer using $transport for delivery.
     */
    public function __construct(Swift_Transport $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Create a new class instance of one of the message services.
     *
     * For example 'mimepart' would create a 'message.mimepart' instance
     *
     * @param string $service
     *
     * @return object
     */
    public function createMessage($service = 'message')
    {
        return Swift_DependencyContainer::getInstance()
            ->lookup('message.'.$service);
    }

    /**
     * Send the given Message like it would be sent in a mail client.
     *
     * All recipients (with the exception of Bcc) will be able to see the other
     * recipients this message was sent to.
     *
     * Recipient/sender data will be retrieved from the Message object.
     *
     * The return value is the number of recipients who were accepted for
     * delivery.
     *
     * @param array $failedRecipients An array of failures by-reference
     *
     * @return int The number of successful recipients. Can be 0 which indicates failure
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $failedRecipients = (array) $failedRecipients;

        // FIXME: to be removed in 7.0 (as transport must now start itself on send)
        if (!$this->transport->isStarted()) {
            $this->transport->start();
        }

        $sent = 0;

        try {
            $sent = $this->transport->send($message, $failedRecipients);
        } catch (Swift_RfcComplianceException $e) {
            foreach ($message->getTo() as $address => $name) {
                $failedRecipients[] = $address;
            }
        }

        return $sent;
    }

    /**
     * Register a plugin using a known unique key (e.g. myPlugin).
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->transport->registerPlugin($plugin);
    }

    /**
     * The Transport used to send messages.
     *
     * @return Swift_Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2011 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Stores Messages in memory.
 *
 * @author Fabien Potencier
 */
class Swift_MemorySpool implements Swift_Spool
{
    protected $messages = [];
    private $flushRetries = 3;

    /**
     * Tests if this Transport mechanism has started.
     *
     * @return bool
     */
    public function isStarted()
    {
        return true;
    }

    /**
     * Starts this Transport mechanism.
     */
    public function start()
    {
    }

    /**
     * Stops this Transport mechanism.
     */
    public function stop()
    {
    }

    /**
     * @param int $retries
     */
    public function setFlushRetries($retries)
    {
        $this->flushRetries = $retries;
    }

    /**
     * Stores a message in the queue.
     *
     * @param Swift_Mime_SimpleMessage $message The message to store
     *
     * @return bool Whether the operation has succeeded
     */
    public function queueMessage(Swift_Mime_SimpleMessage $message)
    {
        //clone the message to make sure it is not changed while in the queue
        $this->messages[] = clone $message;

        return true;
    }

    /**
     * Sends messages using the given transport instance.
     *
     * @param Swift_Transport $transport        A transport instance
     * @param string[]        $failedRecipients An array of failures by-reference
     *
     * @return int The number of sent emails
     */
    public function flushQueue(Swift_Transport $transport, &$failedRecipients = null)
    {
        if (!$this->messages) {
            return 0;
        }

        if (!$transport->isStarted()) {
            $transport->start();
        }

        $count = 0;
        $retries = $this->flushRetries;
        while ($retries--) {
            try {
                while ($message = array_pop($this->messages)) {
                    $count += $transport->send($message, $failedRecipients);
                }
            } catch (Swift_TransportException $exception) {
                if ($retries) {
                    // re-queue the message at the end of the queue to give a chance
                    // to the other messages to be sent, in case the failure was due to
                    // this message and not just the transport failing
                    array_unshift($this->messages, $message);

                    // wait half a second before we try again
                    usleep(500000);
                } else {
                    throw $exception;
                }
            }
        }

        return $count;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * The Message class for building emails.
 *
 * @author Chris Corbyn
 */
class Swift_Message extends Swift_Mime_SimpleMessage
{
    /**
     * @var Swift_Signers_HeaderSigner[]
     */
    private $headerSigners = [];

    /**
     * @var Swift_Signers_BodySigner[]
     */
    private $bodySigners = [];

    /**
     * @var array
     */
    private $savedMessage = [];

    /**
     * Create a new Message.
     *
     * Details may be optionally passed into the constructor.
     *
     * @param string $subject
     * @param string $body
     * @param string $contentType
     * @param string $charset
     */
    public function __construct($subject = null, $body = null, $contentType = null, $charset = null)
    {
        call_user_func_array(
            [$this, 'Swift_Mime_SimpleMessage::__construct'],
            Swift_DependencyContainer::getInstance()
                ->createDependenciesFor('mime.message')
            );

        if (!isset($charset)) {
            $charset = Swift_DependencyContainer::getInstance()
                ->lookup('properties.charset');
        }
        $this->setSubject($subject);
        $this->setBody($body);
        $this->setCharset($charset);
        if ($contentType) {
            $this->setContentType($contentType);
        }
    }

    /**
     * Add a MimePart to this Message.
     *
     * @param string|Swift_OutputByteStream $body
     * @param string                        $contentType
     * @param string                        $charset
     *
     * @return $this
     */
    public function addPart($body, $contentType = null, $charset = null)
    {
        return $this->attach((new Swift_MimePart($body, $contentType, $charset))->setEncoder($this->getEncoder()));
    }

    /**
     * Attach a new signature handler to the message.
     *
     * @return $this
     */
    public function attachSigner(Swift_Signer $signer)
    {
        if ($signer instanceof Swift_Signers_HeaderSigner) {
            $this->headerSigners[] = $signer;
        } elseif ($signer instanceof Swift_Signers_BodySigner) {
            $this->bodySigners[] = $signer;
        }

        return $this;
    }

    /**
     * Detach a signature handler from a message.
     *
     * @return $this
     */
    public function detachSigner(Swift_Signer $signer)
    {
        if ($signer instanceof Swift_Signers_HeaderSigner) {
            foreach ($this->headerSigners as $k => $headerSigner) {
                if ($headerSigner === $signer) {
                    unset($this->headerSigners[$k]);

                    return $this;
                }
            }
        } elseif ($signer instanceof Swift_Signers_BodySigner) {
            foreach ($this->bodySigners as $k => $bodySigner) {
                if ($bodySigner === $signer) {
                    unset($this->bodySigners[$k]);

                    return $this;
                }
            }
        }

        return $this;
    }

    /**
     * Clear all signature handlers attached to the message.
     *
     * @return $this
     */
    public function clearSigners()
    {
        $this->headerSigners = [];
        $this->bodySigners = [];

        return $this;
    }

    /**
     * Get this message as a complete string.
     *
     * @return string
     */
    public function toString()
    {
        if (empty($this->headerSigners) && empty($this->bodySigners)) {
            return parent::toString();
        }

        $this->saveMessage();

        $this->doSign();

        $string = parent::toString();

        $this->restoreMessage();

        return $string;
    }

    /**
     * Write this message to a {@link Swift_InputByteStream}.
     */
    public function toByteStream(Swift_InputByteStream $is)
    {
        if (empty($this->headerSigners) && empty($this->bodySigners)) {
            parent::toByteStream($is);

            return;
        }

        $this->saveMessage();

        $this->doSign();

        parent::toByteStream($is);

        $this->restoreMessage();
    }

    public function __wakeup()
    {
        Swift_DependencyContainer::getInstance()->createDependenciesFor('mime.message');
    }

    /**
     * loops through signers and apply the signatures.
     */
    protected function doSign()
    {
        foreach ($this->bodySigners as $signer) {
            $altered = $signer->getAlteredHeaders();
            $this->saveHeaders($altered);
            $signer->signMessage($this);
        }

        foreach ($this->headerSigners as $signer) {
            $altered = $signer->getAlteredHeaders();
            $this->saveHeaders($altered);
            $signer->reset();

            $signer->setHeaders($this->getHeaders());

            $signer->startBody();
            $this->bodyToByteStream($signer);
            $signer->endBody();

            $signer->addSignature($this->getHeaders());
        }
    }

    /**
     * save the message before any signature is applied.
     */
    protected function saveMessage()
    {
        $this->savedMessage = ['headers' => []];
        $this->savedMessage['body'] = $this->getBody();
        $this->savedMessage['children'] = $this->getChildren();
        if (count($this->savedMessage['children']) > 0 && '' != $this->getBody()) {
            $this->setChildren(array_merge([$this->becomeMimePart()], $this->savedMessage['children']));
            $this->setBody('');
        }
    }

    /**
     * save the original headers.
     */
    protected function saveHeaders(array $altered)
    {
        foreach ($altered as $head) {
            $lc = strtolower($head);

            if (!isset($this->savedMessage['headers'][$lc])) {
                $this->savedMessage['headers'][$lc] = $this->getHeaders()->getAll($head);
            }
        }
    }

    /**
     * Remove or restore altered headers.
     */
    protected function restoreHeaders()
    {
        foreach ($this->savedMessage['headers'] as $name => $savedValue) {
            $headers = $this->getHeaders()->getAll($name);

            foreach ($headers as $key => $value) {
                if (!isset($savedValue[$key])) {
                    $this->getHeaders()->remove($name, $key);
                }
            }
        }
    }

    /**
     * Restore message body.
     */
    protected function restoreMessage()
    {
        $this->setBody($this->savedMessage['body']);
        $this->setChildren($this->savedMessage['children']);

        $this->restoreHeaders();
        $this->savedMessage = [];
    }

    /**
     * Clone Message Signers.
     *
     * @see Swift_Mime_SimpleMimeEntity::__clone()
     */
    public function __clone()
    {
        parent::__clone();
        foreach ($this->bodySigners as $key => $bodySigner) {
            $this->bodySigners[$key] = clone $bodySigner;
        }

        foreach ($this->headerSigners as $key => $headerSigner) {
            $this->headerSigners[$key] = clone $headerSigner;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?ph