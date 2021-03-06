              0,
                ],
            ],
        ];
        $this->assertEquals($expectedCalls, $definition->getMethodCalls());
    }

    public function testHotPathEvents()
    {
        $container = new ContainerBuilder();

        $container->register('foo', SubscriberService::class)->addTag('kernel.event_subscriber', []);
        $container->register('event_dispatcher', 'stdClass');

        (new RegisterListenersPass())->setHotPathEvents(['event'])->process($container);

        $this->assertTrue($container->getDefinition('foo')->hasTag('container.hot_path'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You have requested a non-existent parameter "subscriber.class"
     */
    public function testEventSubscriberUnresolvableClassName()
    {
        $container = new ContainerBuilder();
        $container->register('foo', '%subscriber.class%')->addTag('kernel.event_subscriber', []);
        $container->register('event_dispatcher', 'stdClass');

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);
    }

    public function testInvokableEventListener()
    {
        $container = new ContainerBuilder();
        $container->register('foo', \stdClass::class)->addTag('kernel.event_listener', ['event' => 'foo.bar']);
        $container->register('bar', InvokableListenerService::class)->addTag('kernel.event_listener', ['event' => 'foo.bar']);
        $container->register('baz', InvokableListenerService::class)->addTag('kernel.event_listener', ['event' => 'event']);
        $container->register('event_dispatcher', \stdClass::class);

        $registerListenersPass = new RegisterListenersPass();
        $registerListenersPass->process($container);

        $definition = $container->getDefinition('event_dispatcher');
        $expectedCalls = [
            [
                'addListener',
                [
                    'foo.bar',
                    [new ServiceClosureArgument(new Reference('foo')), 'onFooBar'],
                    0,
                ],
            ],
            [
                'addListener',
                [
                    'foo.bar',
                    [new ServiceClosureArgument(new Reference('bar')), '__invoke'],
                    0,
                ],
            ],
            [
                'addListener',
                [
                    'event',
                    [new ServiceClosureArgument(new Reference('baz')), 'onEvent'],
                    0,
                ],
            ],
        ];
        $this->assertEquals($expectedCalls, $definition->getMethodCalls());
    }
}

class SubscriberService implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            'event' => 'onEvent',
        ];
    }
}

class InvokableListenerService
{
    public function __invoke()
    {
    }

    public function onEvent()
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  {
    "name": "symfony/event-dispatcher-contracts",
    "type": "library",
    "description": "Generic abstractions related to dispatching event",
    "keywords": ["abstractions", "contracts", "decoupling", "interfaces", "interoperability", "standards"],
    "homepage": "https://symfony.com",
    "license": "MIT",
    "authors": [
        {
            "name": "Nicolas Grekas",
            "email": "p@tchwork.com"
        },
        {
            "name": "Symfony Community",
            "homepage": "https://symfony.com/contributors"
        }
    ],
    "require": {
        "php": "^7.1.3"
    },
    "suggest": {
        "psr/event-dispatcher": "",
        "symfony/event-dispatcher-implementation": ""
    },
    "autoload": {
        "psr-4": { "Symfony\\Contracts\\EventDispatcher\\": "" }
    },
    "minimum-stability": "dev",
    "extra": {
        "branch-alias": {
            "dev-master": "1.1-dev"
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\EventDispatcher;

use Psr\EventDispatcher\StoppableEventInterface;

if (interface_exists(StoppableEventInterface::class)) {
    /**
     * Event is the base class for classes containing event data.
     *
     * This class contains no event data. It is used by events that do not pass
     * state information to an event handler when an event is raised.
     *
     * You can call the method stopPropagation() to abort the execution of
     * further listeners in your event listener.
     *
     * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
     * @author Jonathan Wage <jonwage@gmail.com>
     * @author Roman Borschel <roman@code-factory.org>
     * @author Bernhard Schussek <bschussek@gmail.com>
     * @author Nicolas Grekas <p@tchwork.com>
     */
    class Event implements StoppableEventInterface
    {
        private $propagationStopped = false;

        /**
         * Returns whether further event listeners should be triggered.
         */
        public function isPropagationStopped(): bool
        {
            return $this->propagationStopped;
        }

        /**
         * Stops the propagation of the event to further event listeners.
         *
         * If multiple event listeners are connected to the same event, no
         * further event listener will be triggered once any trigger calls
         * stopPropagation().
         */
        public function stopPropagation(): void
        {
            $this->propagationStopped = true;
        }
    }
} else {
    /**
     * Event is the base class for classes containing event data.
     *
     * This class contains no event data. It is used by events that do not pass
     * state information to an event handler when an event is raised.
     *
     * You can call the method stopPropagation() to abort the execution of
     * further listeners in your event listener.
     *
     * @author Guilherme Blanco <guilhermeblanco@hotmail.com>
     * @author Jonathan Wage <jonwage@gmail.com>
     * @author Roman Borschel <roman@code-factory.org>
     * @author Bernhard Schussek <bschussek@gmail.com>
     * @author Nicolas Grekas <p@tchwork.com>
     */
    class Event
    {
        private $propagationStopped = false;

        /**
         * Returns whether further event listeners should be triggered.
         */
        public function isPropagationStopped(): bool
        {
            return $this->propagationStopped;
        }

        /**
         * Stops the propagation of the event to further event listeners.
         *
         * If multiple event listeners are connected to the same event, no
         * further event listener will be triggered once any trigger calls
         * stopPropagation().
         */
        public function stopPropagation(): void
        {
            $this->propagationStopped = true;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\EventDispatcher;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

if (interface_exists(PsrEventDispatcherInterface::class)) {
    /**
     * Allows providing hooks on domain-specific lifecycles by dispatching events.
     */
    interface EventDispatcherInterface extends PsrEventDispatcherInterface
    {
        /**
         * Dispatches an event to all registered listeners.
         *
         * For BC with Symfony 4, the $eventName argument is not declared explicitly on the
         * signature of the method. Implementations that are not bound by this BC contraint
         * MUST declare it explicitly, as allowed by PHP.
         *
         * @param object      $event     The event to pass to the event handlers/listeners
         * @param string|null $eventName The name of the event to dispatch. If not supplied,
         *                               the class of $event should be used instead.
         *
         * @return object The passed $event MUST be returned
         */
        public function dispatch($event/*, string $eventName = null*/);
    }
} else {
    /**
     * Allows providing hooks on domain-specific lifecycles by dispatching events.
     */
    interface EventDispatcherInterface
    {
        /**
         * Dispatches an event to all registered listeners.
         *
         * For BC with Symfony 4, the $eventName argument is not declared explicitly on the
         * signature of the method. Implementations that are not bound by this BC contraint
         * MUST declare it explicitly, as allowed by PHP.
         *
         * @param object      $event     The event to pass to the event handlers/listeners
         * @param string|null $eventName The name of the event to dispatch. If not supplied,
         *                               the class of $event should be used instead.
         *
         * @return object The passed $event MUST be returned
         */
        public function dispatch($event/*, string $eventName = null*/);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         Copyright (c) 2018-2019 Fabien Potencier

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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        