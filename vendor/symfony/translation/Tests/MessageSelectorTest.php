<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Translation\Loader\PoFileLoader;

class PoFileLoaderTest extends TestCase
{
    public function testLoad()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/resources.po';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $catalogue->all('domain1'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    public function testLoadPlurals()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/plurals.po';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $this->assertEquals(['foo' => 'bar', 'foos' => 'bar|bars'], $catalogue->all('domain1'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    public function testLoadDoesNothingIfEmpty()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/empty.po';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $this->assertEquals([], $catalogue->all('domain1'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function testLoadNonExistingResource()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/non-existing.po';
        $loader->load($resource, 'en', 'domain1');
    }

    public function testLoadEmptyTranslation()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/empty-translation.po';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $this->assertEquals(['foo' => ''], $catalogue->all('domain1'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    public function testEscapedId()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/escaped-id.po';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $messages = $catalogue->all('domain1');
        $this->assertArrayHasKey('escaped "foo"', $messages);
        $this->assertEquals('escaped "bar"', $messages['escaped "foo"']);
    }

    public function testEscapedIdPlurals()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/escaped-id-plurals.po';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $messages = $catalogue->all('domain1');
        $this->assertArrayHasKey('escaped "foo"', $messages);
        $this->assertArrayHasKey('escaped "foos"', $messages);
        $this->assertEquals('escaped "bar"', $messages['escaped "foo"']);
        $this->assertEquals('escaped "bar"|escaped "bars"', $messages['escaped "foos"']);
    }

    public function testSkipFuzzyTranslations()
    {
        $loader = new PoFileLoader();
        $resource = __DIR__.'/../fixtures/fuzzy-translations.po';
        $catalogue = $loader->load($resource, 'en', 'domain1');

        $messages = $catalogue->all('domain1');
        $this->assertArrayHasKey('foo1', $messages);
        $this->assertArrayNotHasKey('foo2', $messages);
        $this->assertArrayHasKey('foo3', $messages);
    }
}
                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Translation\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Translation\Loader\QtFileLoader;

class QtFileLoaderTest extends TestCase
{
    public function testLoad()
    {
        $loader = new QtFileLoader();
        $resource = __DIR__.'/../fixtures/resources.ts';
        $catalogue = $loader->load($resource, 'en', 'resources');

        $this->assertEquals(['foo' => 'bar'], $catalogue->all('resources'));
        $this->assertEquals('en', $catalogue->getLocale());
        $this->assertEquals([new FileResource($resource)], $catalogue->getResources());
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\NotFoundResourceException
     */
    public function testLoadNonExistingResource()
    {
        $loader = new QtFileLoader();
        $resource = __DIR__.'/../fixtures/non-existing.ts';
        $loader->load($resource, 'en', 'domain1');
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\InvalidResourceException
     */
    public function testLoadNonLocalResource()
    {
        $loader = new QtFileLoader();
        $resource = 'http://domain1.com/resources.ts';
        $loader->load($resource, 'en', 'domain1');
    }

    /**
     * @expectedException \Symfony\Component\Translation\Exception\InvalidResourceException
     */
    public function testLoadInvalidResource()
    {
        $loader = new QtFileLoader();
        $resource = __DIR__.'/../fixtures/invalid-xml-resources.xlf';
        $loader->load($resource, 'en', 'domain1');
    }

    public function testLoadEmptyResource()
    {
        $loader = new QtFileLoader();
        $resource = __DIR__.'/../fixtures/empty.xlf';

        if (method_exists($this, 'expectException')) {
            $this->expectException('Symfony\Component\Translation\Exception\InvalidResourceException');
            $this->expectExceptionMessage(sprintf('Unable to load "%s".', $resource));
        } else {
            $this->setExpectedException('Symfony\Component\Translation\Exception\InvalidResourceException', sprintf('Unable to load "%s".', $resource));
        }

        $loader->load($resource, 'en', 'domain1');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            