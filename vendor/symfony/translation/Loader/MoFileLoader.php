 distinct sets of messages.
         */
        $translator = new Translator('a', null, $this->tmpDir);
        $translator->setFallbackLocales(['b']);

        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', ['foo' => 'foo (a)'], 'a');
        $translator->addResource('array', ['foo' => 'foo (b)'], 'b');
        $translator->addResource('array', ['bar' => 'bar (b)'], 'b');
        $translator->addResource('array', ['baz' => 'baz (b)'], 'b', 'messages+intl-icu');

        $catalogue = $translator->getCatalogue('a');
        $this->assertFalse($catalogue->defines('bar')); // Sure, the "a" catalogue does not contain that message.

        $fallback = $catalogue->getFallbackCatalogue();
        $this->assertTrue($fallback->defines('foo')); // "foo" is present in "a" and "b"

        /*
         * Now, repeat the same test.
         * Behind the scenes, the cache is used. But that should not matter, right?
         */
        $translator = new Translator('a', null, $this->tmpDir);
        $translator->setFallbackLocales(['b']);

        $translator->addLoader('array', new ArrayLoader());
        $translator->addResource('array', ['foo' => 'foo (a)'], 'a');
        $translator->addResource('array', ['foo' => 'foo (b)'], 'b');
        $translator->addResource('array', ['bar' => 'bar (b)'], 'b');
        $translator->addResource('array', ['baz' => 'baz (b)'], 'b', 'messages+intl-icu');

        $catalogue = $translator->getCatalogue('a');
        $this->assertFalse($catalogue->defines('bar'));

        $fallback = $catalogue->getFallbackCatalogue();
        $this->assertTrue($fallback->defines('foo'));
        $this->assertTrue($fallback->defines('baz', 'messages+intl-icu'));
    }

    public function testRefreshCacheWhenResourcesAreNoLongerFresh()
    {
        $resource = $this->getMockBuilder('Symfony\Component\Config\Resource\SelfCheckingResourceInterface')->getMock();
        $loader = $this->getMockBuilder('Symfony\Component\Translation\Loader\LoaderInterface')->getMock();
        $resource->method('isFresh')->will($this->returnValue(false));
        $loader
            ->expects($this->exactly(2))
            ->method('load')
            ->will($this->returnValue($this->getCatalogue('fr', [], [$resource])));

        // prime the cache
        $translator = new Translator('fr', null, $this->tmpDir, true);
        $translator->addLoader('loader', $loader);
        $translator->addResource('loader', 'foo', 'fr');
        $translator->trans('foo');

        // prime the cache second time
        $translator = new Translator('fr', null, $this->tmpDir, true);
        $translator->addLoader('loader', $loader);
        $translator->addResource('loader', 'foo', 'fr');
        $translator->trans('foo');
    }

    protected function getCatalogue($locale, $messages, $resources = [])
    {
        $catalogue = new MessageCatalogue($locale);
        foreach ($messages as $key => $translation) {
            $catalogue->set($key, $translation);
        }
        foreach ($resources as $resource) {
            $catalogue->addResource($resource);
        }

        return $catalogue;
    }

    public function runForDebugAndProduction()
    {
        return [[true], [false]];
    }

    /**
     * @return LoaderInterface
     */
    private function createFailingLoader()
    {
        $loader = $this->getMockBuilder('Symfony\Component\Translation\Loader\LoaderInterface')->getMock();
        $loader
            ->expects($this->never())
            ->method('load');

        return $loader;
    }
}

class StaleResource implements SelfCheckingResourceInterface
{
    public function isFresh($timestamp)
    {
        return false;
    }

    public function getResource()
    {
    }

    public function __toString()
    {
        return '';
    }
}
                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\MessageCatalogue;
use Symfony\Component\Translation\Translator;

class TranslatorTest extends TestCase
{
    /**
     * @