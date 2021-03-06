<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;

/**
 * Common syslog functionality
 */
abstract class AbstractSyslogHandler extends AbstractProcessingHandler
{
    protected $facility;

    /**
     * Translates Monolog log levels to syslog log priorities.
     */
    protected $logLevels = array(
        Logger::DEBUG     => LOG_DEBUG,
        Logger::INFO      => LOG_INFO,
        Logger::NOTICE    => LOG_NOTICE,
        Logger::WARNING   => LOG_WARNING,
        Logger::ERROR     => LOG_ERR,
        Logger::CRITICAL  => LOG_CRIT,
        Logger::ALERT     => LOG_ALERT,
        Logger::EMERGENCY => LOG_EMERG,
    );

    /**
     * List of valid log facility names.
     */
    protected $facilities = array(
        'auth'     => LOG_AUTH,
        'authpriv' => LOG_AUTHPRIV,
        'cron'     => LOG_CRON,
        'daemon'   => LOG_DAEMON,
        'kern'     => LOG_KERN,
        'lpr'      => LOG_LPR,
        'mail'     => LOG_MAIL,
        'news'     => LOG_NEWS,
        'syslog'   => LOG_SYSLOG,
        'user'     => LOG_USER,
        'uucp'     => LOG_UUCP,
    );

    /**
     * @param mixed $facility
     * @param int   $level The minimum logging level at which this handler will be triggered
     * @param bool  $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($facility = LOG_USER, $level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);

        if (!defined('PHP_WINDOWS_VERSION_BUILD')) {
            $this->facilities['local0'] = LOG_LOCAL0;
            $this->facilities['local1'] = LOG_LOCAL1;
            $this->facilities['local2'] = LOG_LOCAL2;
            $this->facilities['local3'] = LOG_LOCAL3;
            $this->facilities['local4'] = LOG_LOCAL4;
            $this->facilities['local5'] = LOG_LOCAL5;
            $this->facilities['local6'] = LOG_LOCAL6;
            $this->facilities['local7'] = LOG_LOCAL7;
        } else {
            $this->facilities['local0'] = 128; // LOG_LOCAL0
            $this->facilities['local1'] = 136; // LOG_LOCAL1
            $this->facilities['local2'] = 144; // LOG_LOCAL2
            $this->facilities['local3'] = 152; // LOG_LOCAL3
            $this->facilities['local4'] = 160; // LOG_LOCAL4
            $this->facilities['local5'] = 168; // LOG_LOCAL5
            $this->facilities['local6'] = 176; // LOG_LOCAL6
            $this->facilities['local7'] = 184; // LOG_LOCAL7
        }

        // convert textual description of facility to syslog constant
        if (array_key_exists(strtolower($facility), $this->facilities)) {
            $facility = $this->facilities[strtolower($facility)];
        } elseif (!in_array($facility, array_values($this->facilities), true)) {
            throw new \UnexpectedValueException('Unknown facility value "'.$facility.'" given');
        }

        $this->facility = $facility;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter('%channel%.%level_name%: %message% %context% %extra%');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\Logger;
use Monolog\Formatter\JsonFormatter;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;
use AMQPExchange;

class AmqpHandler extends AbstractProcessingHandler
{
    /**
     * @var AMQPExchange|AMQPChannel $exchange
     */
    protected $exchange;

    /**
     * @var string
     */
    protected $exchangeName;

    /**
     * @param AMQPExchange|AMQPChannel $exchange     AMQPExchange (php AMQP ext) or PHP AMQP lib channel, ready for use
     * @param string                   $exchangeName
     * @param int                      $level
     * @param bool                     $bubble       Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct($exchange, $exchangeName = 'log', $level = Logger::DEBUG, $bubble = true)
    {
        if ($exchange instanceof AMQPExchange) {
            $exchange->setName($exchangeName);
        } elseif ($exchange instanceof AMQPChannel) {
            $this->exchangeName = $exchangeName;
        } else {
            throw new \InvalidArgumentException('PhpAmqpLib\Channel\AMQPChannel or AMQPExchange instance required');
        }
        $this->exchange = $exchange;

        parent::__construct($level, $bubble);
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        $data = $record["formatted"];
        $routingKey = $this->getRoutingKey($record);

        if ($this->exchange instanceof AMQPExchange) {
            $this->exchange->publish(
                $data,
                $routingKey,
                0,
                array(
                    'delivery_mode' => 2,
                    'content_type' => 'application/json',
                )
            );
        } else {
            $this->exchange->basic_publish(
                $this->createAmqpMessage($data),
                $this->exchangeName,
                $routingKey
            );
        }
    }

    /**
     * {@inheritDoc}
     */
    public function handleBatch(array $records)
    {
        if ($this->exchange instanceof AMQPExchange) {
            parent::handleBatch($records);

            return;
        }

        foreach ($records as $record) {
            if (!$this->isHandling($record)) {
                continue;
            }

            $record = $this->processRecord($record);
            $data = $this->getFormatter()->format($record);

            $this->exchange->batch_basic_publish(
                $this->createAmqpMessage($data),
                $this->exchangeName,
                $this->getRoutingKey($record)
            );
        }

        $this->exchange->publish_batch();
    }

    /**
     * Gets the routing key for the AMQP exchange
     *
     * @param  array  $record
     * @return string
     */
    protected function getRoutingKey(array $record)
    {
        $routingKey = sprintf(
            '%s.%s',
            // TODO 2.0 remove substr call
            substr($record['level_name'], 0, 4),
            $record['channel']
        );

        return strtolower($routingKey);
    }

    /**
     * @param  string      $data
     * @return AMQPMessage
     */
    private function createAmqpMessage($data)
    {
        return new AMQPMessage(
            (string) $data,
            array(
                'delivery_mode' => 2,
                'content_type' => 'application/json',
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new JsonFormatter(JsonFormatter::BATCH_MODE_JSON, false);
    }
}
                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\Formatter\LineFormatter;

/**
 * Handler sending logs to browser's javascript console with no browser extension required
 *
 * @author Olivier Poitrey <rs@dailymotion.com>
 */
class BrowserConsoleHandler extends AbstractProcessingHandler
{
    protected static $initialized = false;
    protected static $records = array();

    /**
     * {@inheritDoc}
     *
     * Formatted output may contain some formatting markers to be transferred to `console.log` using the %c format.
     *
     * Example of formatted string:
     *
     *     You can do [[blue text]]{color: blue} or [[green background]]{background-color: green; color: white}
     */
    protected function getDefaultFormatter()
    {
        return new LineFormatter('[[%channel%]]{macro: autolabel} [[%level_name%]]{font-weight: bold} %message%');
    }

    /**
     * {@inheritDoc}
     */
    protected function write(array $record)
    {
        // Accumulate records
        static::$records[] = $record;

        // Register shutdown handler if not already done
        if (!static::$initialized) {
            static::$initialized = true;
            $this->registerShutdownFunction();
        }
    }

    /**
     * Convert records to javascript console commands and send it to the browser.
     * This method is automatically called on PHP shutdown if output is HTML or Javascript.
     */
    public static function send()
    {
        $format = static::getResponseFormat();
        if ($format === 'unknown') {
            return;
        }

        if (count(static::$records)) {
            if ($format === 'html') {
                static::writeOutput('<script>' . static::generateScript() . '</script>');
            } elseif ($format === 'js') {
                static::writeOutput(static::generateScript());
            }
            static::resetStatic();
        }
    }

    public function close()
    {
        self::resetStatic();
    }

    public function reset()
    {
        self::resetStatic();
    }

    /**
     * Forget all logged records
     */
    public static function resetStatic()
    {
        static::$records = array();
    }

    /**
     * Wrapper for register_shutdown_function to allow overriding
     */
    protected function registerShutdownFunction()
    {
        if (PHP_SAPI !== 'cli') {
            register_shutdown_function(array('Monolog\Handler\BrowserConsoleHandler', 'send'));
        }
    }

    /**
     * Wrapper for echo to allow overriding
     *
     * @param string $str
     */
    protected static function writeOutput($str)
    {
        echo $str;
    }

    /**
     * Checks the format of the response
     *
     * If Content-Type is set to application/javascript or text/javascript -> js
     * If Content-Type is set to text/html, or is unset -> html
     * If Content-Type is anything else -> unknown
     *
     * @return string One of 'js', 'html' or 'unknown'
     */
    protected static function getResponseFormat()
    {
        // Check content type
        foreach (headers_list() as $header) {
            if (stripos($header, 'content-type:') === 0) {
                // This handler only works with HTML and javascript outputs
                // text/javascript is obsolete in favour of application/javascript, but still used
                if (stripos($header, 'application/javascript') !== false || stripos($header, 'text/javascript') !== false) {
                    return 'js';
                }
                if (stripos($header, 'text/html') === false) {
                    return 'unknown';
                }
                break;
            }
        }

        return 'html';
    }

    private static function generateScript()
    {
        $script = array();
        foreach (static::$records as $record) {
            $context = static::dump('Context', $record['context']);
            $extra = static::dump('Extra', $record['extra']);

            if (empty($context) && empty($extra)) {
                $script[] = static::call_array('log', static::handleStyles($record['formatted']));
            } else {
                $script = array_merge($script,
                    array(static::call_array('groupCollapsed', static::handleStyles($record['formatted']))),
                    $context,
                    $extra,
                    array(static::call('groupEnd'))
                );
            }
        }

        return "(function (c) {if (c && c.groupCollapsed) {\n" . implode("\n", $script) . "\n}})(console);";
    }

    private static function handleStyles($formatted)
    {
        $args = array(static::quote('font-weight: normal'));
        $format = '%c' . $formatted;
        preg_match_all('/\[\[(.*?)\]\]\{([^}]*)\}/s', $format, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        foreach (array_reverse($matches) as $match) {
            $args[] = static::quote(static::handleCustomStyles($match[2][0], $match[1][0]));
            $args[] = '"font-weight: normal"';

            $pos = $match[0][1];
            $format = substr($format, 0, $pos) . '%c' . $match[1][0] . '%c' . substr($format, $pos + strlen($match[0][0]));
        }

        array_unshift($args, static::quote($format));

        return $args;
    }

    private static function handleCustomStyles($style, $string)
    {
        static $colors = array('blue', 'green', 'red', 'magenta', 'orange', 'black', 'grey');
        static $labels = array();

        return preg_replace_callback('/macro\s*:(.*?)(?:;|$)/', function ($m) use ($string, &$colors, &$labels) {
            if (trim($m[1]) === 'autolabel') {
                // Format the string as a label with consistent auto assigned background color
                if (!isset($labels[$string])) {
                    $labels[$string] = $colors[count($labels) % count($colors)];
                }
                $color = $labels[$string];

                return "background-color: $color; color: white; border-radius: 3px; padding: 0 2px 0 2px";
            }

            return $m[1];
        }, $style);
    }

    private static function dump($title, array $dict)
    {
        $script = array();
        $dict = array_filter($dict);
        if (empty($dict)) {
            return $script;
        }
        $script[] = static::call('log', static::quote('%c%s'), static::quote('font-weight: bold'), static::quote($title));
        foreach ($dict as $key => $value) {
            $value = json_encode($value);
            if (empty($value)) {
                $value = static::quote('');
            }
            $script[] = static::call('log', static::quote('%s: %o'), static::quote($key), $value);
        }

        return $script;
    }

    private static function quote($arg)
    {
        return '"' . addcslashes($arg, "\"\n\\") . '"';
    }

    private static function call()
    {
        $args = func_get_args();
        $method = array_shift($args);

        return static::call_array($method, $args);
    }

    private static function call_array($method, array $args)
    {
        return 'c.' . $method . '(' . implode(', ', $args) . ');';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              INDX( 	 �'z             (   p  �       �  B p n           �     x h     �     ��*pk� I�)u��Ö�<���*pk�                       A b s t r a c t H a n d l e r . p h p �     � |     �     �0�*pk� I�)u�sŖ�<��0�*pk�       �               A b s t r a c t P r o c e s s i n g H a n d l e r . p h p     �     � t     �     ג�*pk� I�)u���ǖ�<�ג�*pk�       +               A b s t r a c t S y s l o g H a n d l e r . p h p     �     p `     �     �V�*pk� I�)u���ǖ�< �V�*pk�                      A m q p H a n d l e r . p h p �     � t     �     A�*pk� I�)u��7ʖ�<�A�*pk�        �               B r o w s e r C o n s o l e H a n d l e r . p h p     �     x d     �     ��*pk� I�)u�.�̖�<���*pk�       U               B u f f e r H a n d l e r . p h p     �     � j     �     k�*pk� I�)u���Ζ�<�k�*pk�        �               C h r o m e P H P H a n d l e r . p h p       �     x f     �     �U+pk� I�)u���Ζ�<��U+pk�      �               C o u c h D B H a n d l e r . p h p   �     p `     �     xB+pk� I�)u��^і�<�xB+pk�                       C u b e H a n d l e r . p h p 
     ` J     �     %��,pk���,pk���,pk�%��,pk�                        C u r l p l i �     � r     �     C+pk� I�)u�4�Ӗ�<�C+pk�        g               D e d u p l i c a t i o n H a n d l e r . p h p       �     � v     �     �-+pk� I�)u��"֖�<��-+pk�       �               D o c t r i n e C o u c h D  H a n d l e r . p h p   �     x h     �     ��+pk� I�)u��"֖�<���+pk�       �	               D y n a m o D b H a n d l e r . p h p �     � r     �     �'+pk� I�)u��ؖ�<��'+pk�       U               E l a s t i c S e a r c h H a n d l e r . p h p       �     x h     �     ,:+pk� I�)u���ږ�<�,:+pk�       @	               E r r o r L o g H a n d l e r . p h p �     x d     �     TA+pk� I�)u���ږ�<�TA+pk�        F               F i l t e r H a n d l e r .  h p          p ^     �     {�s-pk��M�-pk��M�-pk�{�s-pk�                        F i n g e r s C r o s s e d                 e P H P H a n d l e r . p h p   �     � j     �     <�+pk� I�)u����<�<�+pk�       #               F l e e p H o o k H a n d l e r . p h p       �     x h     �     ,c�+pk� I�)u����<�,c�+pk�                      F l o w d o c k H a n d l e r . p h p �     p `     �     �'�+pk� I�)u��q��<��'�+pk�       �               G e l f H a  d l e r . p h p �     x b     �     <O�+pk� I�)u�#���<�<O�+pk�       �
               G r o u p H a n d l e r . p h p       �     � j     �     }ا+pk� I�)u�#���<�}ا+pk�       
               H a n d l e r I n t e r f a c e . p h p       �     x f     �     L;�+pk� I�)u�q5��<�L;�+pk�       >	               H a n d l e r W r a p p e r . p h p   �     x f     �     ]b�+pk� I�)u�З��<�]b�+pk� 0      *               H i p C h a t H a n d l e r . p h p   �     x b     �     f&�+pk� I�)u�\���<�f&�+pk�       B               I F T T T H a n d l e r . p h p       �     � l     �     -�+pk� I�)u�\���<�-�+pk�       R               I n s i g h t O p s H a n d l e r . p h p     �     � l     �     %N�+pk� I�)u��]��<�%N�+pk�       O               L o g E n t r i e s H a n d l e r . p h p     �     x d     �     ��+pk� I�)u����<���+pk�       ;
               L o g g l y H a n d l e r . p h p     �     p `     �     1u�+pk� I�)u�?!���<�1u�+pk�       V               M a i l H a n d l e r . p h p �     x h     �     :�+pk� I�)u������<�:�+pk�       l               M a n d r i l l H a n d l e r . p h p �     � |     �     ���+pk� I�)u������<����+pk��      �               M i s s i n g E x t e n s i o n E x c e p t i o n . p h p     �     x f     �     ��+pk� I�)u������<���+pk�       F               M o n g o D B H a n d l e r . p h p                                        <?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Monolog\Handler;

use Monolog\Logger;
use Monolog\ResettableInterface;

/**
 * Buffers all records until closing the handler and then pass them as batch.
 *
 * This is useful for a MailHandler to send only one mail per request instead of
 * sending one per log message.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class BufferHandler extends AbstractHandler
{
    protected $handler;
    protected $bufferSize = 0;
    protected $bufferLimit;
    protected $flushOnOverflow;
    protected $buffer = array();
    protected $initialized = false;

    /**
  