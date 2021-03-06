<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Cache;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * An implementation of CacheInterface for PSR-6 CacheItemPoolInterface classes.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait CacheTrait
{
    /**
     * {@inheritdoc}
     */
    public function get(string $key, callable $callback, float $beta = null, array &$metadata = null)
    {
        return $this->doGet($this, $key, $callback, $beta, $metadata);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $key): bool
    {
        return $this->deleteItem($key);
    }

    private function doGet(CacheItemPoolInterface $pool, string $key, callable $callback, ?float $beta, array &$metadata = null)
    {
        if (0 > $beta = $beta ?? 1.0) {
            throw new class(sprintf('Argument "$beta" provided to "%s::get()" must be a positive number, %f given.', \get_class($this), $beta)) extends \InvalidArgumentException implements InvalidArgumentException {
            };
        }

        $item = $pool->getItem($key);
        $recompute = !$item->isHit() || INF === $beta;
        $metadata = $item instanceof ItemInterface ? $item->getMetadata() : array();

        if (!$recompute && $metadata) {
            $expiry = $metadata[ItemInterface::METADATA_EXPIRY] ?? false;
            $ctime = $metadata[ItemInterface::METADATA_CTIME] ?? false;

            if ($recompute = $ctime && $expiry && $expiry <= microtime(true) - $ctime / 1000 * $beta * log(random_int(1, PHP_INT_MAX) / PHP_INT_MAX)) {
                // force applying defaultLifetime to expiry
                $item->expiresAt(null);
            }
        }

        if ($recompute) {
            $save = true;
            $item->set($callback($item, $save));
            if ($save) {
                $pool->save($item);
            }
        }

        return $item->get();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Cache;

use Psr\Cache\CacheItemInterface;

/**
 * Computes and returns the cached value of an item.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface CallbackInterface
{
    /**
     * @param CacheItemInterface|ItemInterface $item  The item to compute the value for
     * @param bool                             &$save Should be set to false when the value should not be saved in the pool
     *
     * @return mixed The computed value for the passed item
     */
    public function __invoke(CacheItemInterface $item, bool &$save);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Cache;

use Psr\Cache\CacheException;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * Augments PSR-6's CacheItemInterface with support for tags and metadata.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface ItemInterface extends CacheItemInterface
{
    /**
     * References the Unix timestamp stating when the item will expire.
     */
    const METADATA_EXPIRY = 'expiry';

    /**
     * References the time the item took to be created, in milliseconds.
     */
    const METADATA_CTIME = 'ctime';

    /**
     * References the list of tags that were assigned to the item, as string[].
     */
    const METADATA_TAGS = 'tags';

    /**
     * Adds a tag to a cache item.
     *
     * Tags are strings that follow the same validation rules as keys.
     *
     * @param string|string[] $tags A tag or array of tags
     *
     * @return $this
     *
     * @throws InvalidArgumentException When $tag is not valid
     * @throws CacheException           When the item comes from a pool that is not tag-aware
     */
    public function tag($tags): self;

    /**
     * Returns a list of metadata info that were saved alongside with the cached value.
     *
     * See ItemInterface::METADATA_* consts for keys potentially found in the returned array.
     */
    public function getMetadata(): array;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Cache;

use Psr\Cache\InvalidArgumentException;

/**
 * Allows invalidating cached items using tags.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface TagAwareCacheInterface extends CacheInterface
{
    /**
     * Invalidates cached items using tags.
     *
     * When implemented on a PSR-6 pool, invalidation should not apply
     * to deferred items. Instead, they should be committed as usual.
     * This allows replacing old tagged values by new ones without
     * race conditions.
     *
     * @param string[] $tags An array of tags to invalidate
     *
     * @return bool True on success
     *
     * @throws InvalidArgumentException When $tags is not valid
     */
    public function invalidateTags(array $tags);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Service;

/**
 * Provides a way to reset an object to its initial state.
 *
 * When calling the "reset()" method on an object, it should be put back to its
 * initial state. This usually means clearing any internal buffers and forwarding
 * the call to internal dependencies. All properties of the object should be put
 * back to the same state it had when it was first ready to use.
 *
 * This method could be called, for example, to recycle objects that are used as
 * services, so that they can be used to handle several requests in the same
 * process loop (note that we advise making your services stateless instead of
 * implementing this interface when possible.)
 */
interface ResetInterface
{
    public function reset();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Service;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * A trait to help implement PSR-11 service locators.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
trait ServiceLocatorTrait
{
    private $factories;
    private $loading = array();

    /**
     * @param callable[] $factories
     */
    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return isset($this->factories[$id]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (!isset($this->factories[$id])) {
            throw $this->createNotFoundException($id);
        }

        if (isset($this->loading[$id])) {
            $ids = array_values($this->loading);
            $ids = \array_slice($this->loading, array_search($id, $ids));
            $ids[] = $id;

            throw $this->createCircularReferenceException($id, $ids);
        }

        $this->loading[$id] = $id;
        try {
            return $this->factories[$id]($this);
        } finally {
            unset($this->loading[$id]);
        }
    }

    private function createNotFoundException(string $id): NotFoundExceptionInterface
    {
        if (!$alternatives = array_keys($this->factories)) {
            $message = 'is empty...';
        } else {
            $last = array_pop($alternatives);
            if ($alternatives) {
                $message = sprintf('only knows about the "%s" and "%s" services.', implode('", "', $alternatives), $last);
            } else {
                $message = sprintf('only knows about the "%s" service.', $last);
            }
        }

        if ($this->loading) {
            $message = sprintf('The service "%s" has a dependency on a non-existent service "%s". This locator %s', end($this->loading), $id, $message);
        } else {
            $message = sprintf('Service "%s" not found: the current service locator %s', $id, $message);
        }

        return new class($message) extends \InvalidArgumentException implements NotFoundExceptionInterface {
        };
    }

    private function createCircularReferenceException(string $id, array $path): ContainerExceptionInterface
    {
        return new class(sprintf('Circular reference detected for service "%s", path: "%s".', $id, implode(' -> ', $path))) extends \RuntimeException implements ContainerExceptionInterface {
        };
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Service;

/**
 * A ServiceSubscriber exposes its dependencies via the static {@link getSubscribedServices} method.
 *
 * The getSubscribedServices method returns an array of service types required by such instances,
 * optionally keyed by the service names used internally. Service types that start with an interrogation
 * mark "?" are optional, while the other ones are mandatory service dependencies.
 *
 * The injected service locators SHOULD NOT allow access to any other services not specified by the method.
 *
 * It is expected that ServiceSubscriber instances consume PSR-11-based service locators internally.
 * This interface does not dictate any injection method for these service locators, although constructor
 * injection is recommended.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
interface ServiceSubscriberInterface
{
    /**
     * Returns an array of service types required by such instances, optionally keyed by the service names used internally.
     *
     * For mandatory dependencies:
     *
     *  * array('logger' => 'Psr\Log\LoggerInterface') means the objects use the "logger" name
     *    internally to fetch a service which must implement Psr\Log\LoggerInterface.
     *  * array('loggers' => 'Psr\Log\LoggerInterface[]') means the objects use the "loggers" name
     *    internally to fetch an iterable of Psr\Log\LoggerInterface instances.
     *  * array('Psr\Log\LoggerInterface') is a shortcut for
     *  * array('Psr\Log\LoggerInterface' => 'Psr\Log\LoggerInterface')
     *
     * otherwise:
     *
     *  * array('logger' => '?Psr\Log\LoggerInterface') denotes an optional dependency
     *  * array('loggers' => '?Psr\Log\LoggerInterface[]') denotes an optional iterable dependency
     *  * array('?Psr\Log\LoggerInterface') is a shortcut for
     *  * array('Psr\Log\LoggerInterface' => '?Psr\Log\LoggerInterface')
     *
     * @return array The required service types, optionally keyed by service names
     */
    public static function getSubscribedServices();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Service;

use Psr\Container\ContainerInterface;

/**
 * Implementation of ServiceSubscriberInterface that determines subscribed services from
 * private method return types. Service ids are available as "ClassName::methodName".
 *
 * @author Kevin Bond <kevinbond@gmail.com>
 */
trait ServiceSubscriberTrait
{
    /** @var ContainerInterface */
    private $container;

    public static function getSubscribedServices(): array
    {
        static $services;

        if (null !== $services) {
            return $services;
        }

        $services = \is_callable(array('parent', __FUNCTION__)) ? parent::getSubscribedServices() : array();

        foreach ((new \ReflectionClass(self::class))->getMethods() as $method) {
            if ($method->isStatic() || $method->isAbstract() || $method->isGenerator() || $method->isInternal() || $method->getNumberOfRequiredParameters()) {
                continue;
            }

            if (self::class === $method->getDeclaringClass()->name && ($returnType = $method->getReturnType()) && !$returnType->isBuiltin()) {
                $services[self::class.'::'.$method->name] = '?'.$returnType->getName();
            }
        }

        return $services;
    }

    /**
     * @required
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        if (\is_callable(array('parent', __FUNCTION__))) {
            return parent::setContainer($container);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Tests\Cache;

use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\CacheTrait;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CacheTraitTest extends TestCase
{
    public function testSave()
    {
        $item = $this->getMockBuilder(CacheItemInterface::class)->getMock();
        $item->method('set')
            ->willReturn($item);
        $item->method('isHit')
            ->willReturn(false);

        $item->expects($this->once())
            ->method('set')
            ->with('computed data');

        $cache = $this->getMockBuilder(TestPool::class)
            ->setMethods(array('getItem', 'save'))
            ->getMock();
        $cache->expects($this->once())
            ->method('getItem')
            ->with('key')
            ->willReturn($item);
        $cache->expects($this->once())
            ->method('save');

        $callback = function (CacheItemInterface $item) {
            return 'computed data';
        };

        $cache->get('key', $callback);
    }

    public function testNoCallbackCallOnHit()
    {
        $item = $this->getMockBuilder(CacheItemInterface::class)->getMock();
        $item->method('isHit')
            ->willReturn(true);

        $item->expects($this->never())
            ->method('set');

        $cache = $this->getMockBuilder(TestPool::class)
            ->setMethods(array('getItem', 'save'))
            ->getMock();

        $cache->expects($this->once())
            ->method('getItem')
            ->with('key')
            ->willReturn($item);
        $cache->expects($this->never())
            ->method('save');

        $callback = function (CacheItemInterface $item) {
            $this->assertTrue(false, 'This code should never be reached');
        };

        $cache->get('key', $callback);
    }

    public function testRecomputeOnBetaInf()
    {
        $item = $this->getMockBuilder(CacheItemInterface::class)->getMock();
        $item->method('set')
            ->willReturn($item);
        $item->method('isHit')
            // We want to recompute even if it is a hit
            ->willReturn(true);

        $item->expects($this->once())
            ->method('set')
            ->with('computed data');

        $cache = $this->getMockBuilder(TestPool::class)
            ->setMethods(array('getItem', 'save'))
            ->getMock();

        $cache->expects($this->once())
            ->method('getItem')
            ->with('key')
            ->willReturn($item);
        $cache->expects($this->once())
            ->method('save');

        $callback = function (CacheItemInterface $item) {
            return 'computed data';
        };

        $cache->get('key', $callback, INF);
    }

    public function testExceptionOnNegativeBeta()
    {
        $cache = $this->getMockBuilder(TestPool::class)
            ->setMethods(array('getItem', 'save'))
            ->getMock();

        $callback = function (CacheItemInterface $item) {
            return 'computed data';
        };

        $this->expectException(\InvalidArgumentException::class);
        $cache->get('key', $callback, -2);
    }
}

class TestPool implements CacheItemPoolInterface
{
    use CacheTrait;

    public function hasItem($key)
    {
    }

    public function deleteItem($key)
    {
    }

    public function deleteItems(array $keys = array())
    {
    }

    public function getItem($key)
    {
    }

    public function getItems(array $key = array())
    {
    }

    public function saveDeferred(CacheItemInterface $item)
    {
    }

    public function save(CacheItemInterface $item)
    {
    }

    public function commit()
    {
    }

    public function clear()
    {
    }
}
                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Tests\Service;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceLocatorTrait;

class ServiceLocatorTest extends TestCase
{
    public function getServiceLocator(array $factories)
    {
        return new class($factories) implements ContainerInterface {
            use ServiceLocatorTrait;
        };
    }

    public function testHas()
    {
        $locator = $this->getServiceLocator(array(
            'foo' => function () { return 'bar'; },
            'bar' => function () { return 'baz'; },
            function () { return 'dummy'; },
        ));

        $this->assertTrue($locator->has('foo'));
        $this->assertTrue($locator->has('bar'));
        $this->assertFalse($locator->has('dummy'));
    }

    public function testGet()
    {
        $locator = $this->getServiceLocator(array(
            'foo' => function () { return 'bar'; },
            'bar' => function () { return 'baz'; },
        ));

        $this->assertSame('bar', $locator->get('foo'));
        $this->assertSame('baz', $locator->get('bar'));
    }

    public function testGetDoesNotMemoize()
    {
        $i = 0;
        $locator = $this->getServiceLocator(array(
            'foo' => function () use (&$i) {
                ++$i;

                return 'bar';
            },
        ));

        $this->assertSame('bar', $locator->get('foo'));
        $this->assertSame('bar', $locator->get('foo'));
        $this->assertSame(2, $i);
    }

    /**
     * @expectedException        \Psr\Container\NotFoundExceptionInterface
     * @expectedExceptionMessage The service "foo" has a dependency on a non-existent service "bar". This locator only knows about the "foo" service.
     */
    public function testThrowsOnUndefinedInternalService()
    {
        $locator = $this->getServiceLocator(array(
            'foo' => function () use (&$locator) { return $locator->get('bar'); },
        ));

        $locator->get('foo');
    }

    /**
     * @expectedException        \Psr\Container\ContainerExceptionInterface
     * @expectedExceptionMessage Circular reference detected for service "bar", path: "bar -> baz -> bar".
     */
    public function testThrowsOnCircularReference()
    {
        $locator = $this->getServiceLocator(array(
            'foo' => function () use (&$locator) { return $locator->get('bar'); },
            'bar' => function () use (&$locator) { return $locator->get('baz'); },
            'baz' => function () use (&$locator) { return $locator->get('bar'); },
        ));

        $locator->get('foo');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Tests\Service;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceLocatorTrait;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Symfony\Contracts\Service\ServiceSubscriberTrait;

class ServiceSubscriberTraitTest extends TestCase
{
    public function testMethodsOnParentsAndChildrenAreIgnoredInGetSubscribedServices()
    {
        $expected = array(TestService::class.'::aService' => '?Symfony\Contracts\Tests\Service\Service2');

        $this->assertEquals($expected, ChildTestService::getSubscribedServices());
    }

    public function testSetContainerIsCalledOnParent()
    {
        $container = new class(array()) implements ContainerInterface {
            use ServiceLocatorTrait;
        };

        $this->assertSame($container, (new TestService())->setContainer($container));
    }
}

class ParentTestService
{
    public function aParentService(): Service1
    {
    }

    public function setContainer(ContainerInterface $container)
    {
        return $container;
    }
}

class TestService extends ParentTestService implements ServiceSubscriberInterface
{
    use ServiceSubscriberTrait;

    public function aService(): Service2
    {
    }
}

class ChildTestService extends TestService
{
    public function aChildService(): Service3
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Contracts\Tests\Translation;

use PHPUnit\Framework\TestCase;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Contracts\Translation\TranslatorTrait;

/**
 * Test should cover all languages mentioned on http://translate.sourceforge.net/wiki/l10n/pluralforms
 * and Plural forms mentioned on http://www.gnu.org/software/gettext/manual/gettext.html#Plural-forms.
 *
 * See also https://developer.mozilla.org/en/Localization_and_Plurals which mentions