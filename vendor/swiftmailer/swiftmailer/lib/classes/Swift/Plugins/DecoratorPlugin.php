<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Wraps an IoBuffer to send/receive SMTP commands/responses.
 *
 * @author Chris Corbyn
 */
interface Swift_Transport_SmtpAgent
{
    /**
     * Get the IoBuffer where read/writes are occurring.
     *
     * @return Swift_Transport_IoBuffer
     */
    public function getBuffer();

    /**
     * Run a command against the buffer, expecting the given response codes.
     *
     * If no response codes are given, the response will not be validated.
     * If codes are given, an exception will be thrown on an invalid response.
     *
     * @param string   $command
     * @param int[]    $codes
     * @param string[] $failures An array of failures by-reference
     */
    public function executeCommand($command, $codes = [], &$failures = null);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of SwiftMailer.
 * (c) 2009 Fabien Potencier <fabien.potencier@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Stores Messages in a queue.
 *
 * @author Fabien Potencier
 */
class Swift_Transport_SpoolTransport implements Swift_Transport
{
    /** The spool instance */
    private $spool;

    /** The event dispatcher from the plugin API */
    private $eventDispatcher;

    /**
     * Constructor.
     */
    public function __construct(Swift_Events_EventDispatcher $eventDispatcher, Swift_Spool $spool = null)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->spool = $spool;
    }

    /**
     * Sets the spool object.
     *
     * @return $this
     */
    public function setSpool(Swift_Spool $spool)
    {
        $this->spool = $spool;

        return $this;
    }

    /**
     * Get the spool object.
     *
     * @return Swift_Spool
     */
    public function getSpool()
    {
        return $this->spool;
    }

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
     * {@inheritdoc}
     */
    public function ping()
    {
        return true;
    }

    /**
     * Sends the given message.
     *
     * @param string[] $failedRecipients An array of failures by-reference
     *
     * @return int The number of sent e-mail's
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        if ($evt = $this->eventDispatcher->createSendEvent($this, $message)) {
            $this->eventDispatcher->dispatchEvent($evt, 'beforeSendPerformed');
            if ($evt->bubbleCancelled()) {
                return 0;
            }
        }

        $success = $this->spool->queueMessage($message);

        if ($evt) {
            $evt->setResult($success ? Swift_Events_SendEvent::RESULT_SPOOLED : Swift_Events_SendEvent::RESULT_FAILED);
            $this->eventDispatcher->dispatchEvent($evt, 'sendPerformed');
        }

        return 1;
    }

    /**
     * Register a plugin.
     */
    public function registerPlugin(Swift_Events_EventListener $plugin)
    {
        $this->eventDispatcher->bindEventListener($plugin);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                     