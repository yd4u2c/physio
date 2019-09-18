<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Formatter;

use Monolog\Logger;
use Gelf\Message;

/**
 * Serializes a log message to GELF
 * @see http://www.graylog2.org/about/gelf
 *
 * @author Matt Lehner <mlehner@gmail.com>
 */
class GelfMessageFormatter extends NormalizerFormatter
{
    const DEFAULT_MAX_LENGTH = 32766;

    /**
     * @var string the name of the system for the Gelf log message
     */
    protected $systemName;

    /**
     * @var string a prefix for 'extra' fields from the Monolog record (optional)
     */
    protected $extraPrefix;

    /**
     * @var string a prefix for 'context' fields from the Monolog record (optional)
     */
    protected $contextPrefix;

    /**
     * @var int max length per field
     */
    protected $maxLength;

    /**
     * Translates Monolog log levels to Graylog2 log priorities.
     */
    private $logLevels = array(
        Logger::DEBUG     => 7,
        Logger::INFO      => 6,
        Logger::NOTICE    => 5,
        Logger::WARNING   => 4,
        Logger::ERROR     => 3,
        Logger::CRITICAL  => 2,
        Logger::ALERT     => 1,
        Logger::EMERGENCY => 0,
    );

    public function __construct($systemName = null, $extraPrefix = null, $contextPrefix = 'ctxt_', $maxLength = null)
    {
        parent::__construct('U.u');

        $this->systemName = $systemName ?: gethostname();

        $this->extraPrefix = $extraPrefix;
        $this->contextPrefix = $contextPrefix;
        $this->maxLength = is_null($maxLength) ? self::DEFAULT_MAX_LENGTH : $maxLength;
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $record = parent::format($record);

        if (!isset($record['datetime'], $record['message'], $record['level'])) {
            throw new \InvalidArgumentException('The record should at least contain datetime, message and level keys, '.var_export($record, true).' given');
        }

        $message = new Message();
        $message
            ->setTimestamp($record['datetime'])
            ->setShortMessage((string) $record['message'])
            ->setHost($this->systemName)
            ->setLevel($this->logLevels[$record['lev