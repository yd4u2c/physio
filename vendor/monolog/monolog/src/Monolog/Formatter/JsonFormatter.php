whether the NewRelic extension is enabled in the system.
     *
     * @return bool
     */
    protected function isNewRelicEnabled()
    {
        return extension_loaded('newrelic');
    }

    /**
     * Returns the appname where this log should be sent. Each log can override the default appname, set in this
     * handler's constructor, by providing the appname in it's context.
     *
     * @param  array       $context
     * @return null|string
     */
    protected function getAppName(array $context)
    {
        if (isset($context['appname'])) {
            return $context['appname'];
        }

        return $this->appName;
    }

    /**
     * Returns the name of the current transaction. Each log can override the default transaction name, set in this
     * handler's constructor, by providing the transaction_name in it's context
     *
     * @param array $context
     *
     * @return null|string
     */
    protected function getTransactionName(array $context)
    {
        if (isset($context['transaction_name'])) {
            return $context['transaction_name'];
        }

        return $this->transactionName;
    }

    /**
     * Sets the NewRelic application that should receive this log.
     *
     * @param string $appName
     */
    protected function setNewRelicAppName($appName)
    {
        newrelic_set_appname($appName);
    }

    /**
     * Overwrites the name of the current transaction
     *
     * @param string $transactionName
     */
    protected function setNewRelicTransactionName($transactionName)
    {
        newrelic_name_transaction($transactionName);
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    protected function setNewRelicParameter($key, $value)
    {
        if (null === $value || is_scalar($value)) {
            newrelic_add_custom_parameter($key, $value);
        } else {
            newrelic_add_custom_parameter($key, @json_encode($value));
        }
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter()
    {
        return new NormalizerFormatter();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

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

/**
 * Blackhole
 *
 * Any record it can handle will be thrown away. This can be used
 * to put on top of an existing stack to override it temporarily.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class NullHandler extends AbstractHandler
{
    /**
     * @param int $level The minimum logging level at which this handler will be triggered
     */
    public function __construct($level = Logger::DEBUG)
    {
        parent::__construct($level, false);
    }

    /**
     * {@inheritdoc}
     */
    public function handle(array $record)
    {
        if ($record['level'] < $this->level) {
            return false;
        }

        return true;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     