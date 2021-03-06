        $response = JsonResponse::create('foo');
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $response);
        $this->assertSame('"foo"', $response->getContent());

        $response = JsonResponse::create(0);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $response);
        $this->assertSame('0', $response->getContent());

        $response = JsonResponse::create(0.1);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $response);
        $this->assertSame('0.1', $response->getContent());

        $response = JsonResponse::create(true);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\JsonResponse', $response);
        $this->assertSame('true', $response->getContent());
    }

    public function testStaticCreateWithCustomStatus()
    {
        $response = JsonResponse::create([], 202);
        $this->assertSame(202, $response->getStatusCode());
    }

    public function testStaticCreateAddsContentTypeHeader()
    {
        $response = JsonResponse::create();
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
    }

    public function testStaticCreateWithCustomHeaders()
    {
        $response = JsonResponse::create([], 200, ['ETag' => 'foo']);
        $this->assertSame('application/json', $response->headers->get('Content-Type'));
        $this->assertSame('foo', $response->headers->get('ETag'));
    }

    public function testStaticCreateWithCustomContentType()
    {
        $headers = ['Content-Type' => 'application/vnd.acme.blog-v1+json'];

        $response = JsonResponse::create([], 200, $headers);
        $this->assertSame('application/vnd.acme.blog-v1+json', $response->headers->get('Content-Type'));
    }

    public function testSetCallback()
    {
        $response = JsonResponse::create(['foo' => 'bar'])->setCallback('callback');

        $this->assertEquals('/**/callback({"foo":"bar"});', $response->getContent());
        $this->assertEquals('text/javascript', $response->headers->get('Content-Type'));
    }

    public function testJsonEncodeFlags()
    {
        $response = new JsonResponse('<>\'&"');

        $this->assertEquals('"\u003C\u003E\u0027\u0026\u0022"', $response->getContent());
    }

    public function testGetEncodingOptions()
    {
        $response = new JsonResponse();

        $this->assertEquals(JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT, $response->getEncodingOptions());
    }

    public function testSetEncodingOptions()
    {
        $response = new JsonResponse();
        $response->setData([[1, 2, 3]]);

        $this->assertEquals('[[1,2,3]]', $response->getContent());

        $response->setEncodingOptions(JSON_FORCE_OBJECT);

        $this->assertEquals('{"0":{"0":1,"1":2,"2":3}}', $response->getContent());
    }

    public function testItAcceptsJsonAsString()
    {
        $response = JsonResponse::fromJsonString('{"foo":"bar"}');
        $this->assertSame('{"foo":"bar"}', $response->getContent());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetCallbackInvalidIdentifier()
    {
        $response = new JsonResponse('foo');
        $response->setCallback('+invalid');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetContent()
    {
        JsonResponse::create("\xB1\x31");
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage This error is expected
     */
    public function testSetContentJsonSerializeError()
    {
        if (!interface_exists('JsonSerializable', false)) {
            $this->markTestSkipped('JsonSerializable is required.');
        }

        $serializable = new JsonSerializableObject();

        JsonResponse::create($serializable);
    }

    public function testSetComplexCallback()
    {
        $response = JsonResponse::create(['foo' => 'bar']);
        $response->setCallback('ಠ_ಠ["foo"].bar[0]');

        $this->assertEquals('/**/ಠ_ಠ["foo"].bar[0]({"foo":"bar"});', $response->getContent());
    }
}

if (interface_exists('JsonSerializable', false)) {
    class JsonSerializableObject implements \JsonSerializable
    {
        public function jsonSerialize()
        {
            throw new \Exception('This error is expected');
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;

class ParameterBagTest extends TestCase
{
    public function testConstructor()
    {
        $this->testAll();
    }

    public function testAll()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $bag->all(), '->all() gets all the input');
    }

    public function testKeys()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        $this->assertEquals(['foo'], $bag->keys());
    }

    public function testAdd()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        $bag->add(['bar' => 'bas']);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'bas'], $bag->all());
    }

    public function testRemove()
    {
        $bag = new ParameterBag(['foo' => 'bar']);
        $bag->add(['bar' => 'bas']);
        $this->assertEquals(['foo' => 'bar', 'bar' => 'bas'], $bag->all());
        $bag->remove('bar');
        $this->assertEquals(['foo' => 'bar'], $bag->all());
    }

    public function testReplace()
    {
        $bag = new ParameterBag(['foo' => 'bar']);

        $bag->replace(['FOO' => 'BAR']);
        $this->assertEquals(['FOO' => 'BAR'], $bag->all(), '->replace() replaces the input with the argument');
        $this->assertFalse($bag->has('foo'), '->replace() overrides previously set the input');
    }

    public function testGet()
    {
        $bag = new ParameterBag(['foo' => 'bar', 'null' => null]);

        $this->assertEquals('bar', $bag->get('foo'), '->get() gets the value of a parameter');
        $this->assertEquals('default', $bag->get('unknown', 'default'), '->get() returns second argument as default if a parameter is not defined');
        $this->assertNull($bag->get('null', 'default'), '->get() returns null if null is set');
    }

    public function testGetDoesNotUseDeepByDefault()
    {
        $bag = new ParameterBag(['foo' => ['bar' => 'moo']]);

        $this->assertNull($bag->get('foo[bar]'));
    }

    public function testSet()
    {
        $bag = new ParameterBag([]);

        $bag->set('foo', 'bar');
        $this->assertEquals('bar', $bag->get('foo'), '->set() sets the value of parameter');

        $bag->set('foo', 'baz');
        $this->assertEquals('baz', $bag->get('foo'), '->set() overrides previously set parameter');
    }

    public function testHas()
    {
        $bag = new ParameterBag(['foo' => 'bar']);

        $this->assertTrue($bag->has('foo'), '->has() returns true if a parameter is defined');
        $this->assertFalse($bag->has('unknown'), '->has() return false if a parameter is not defined');
    }

    public function testGetAlpha()
    {
        $bag = new ParameterBag(['word' => 'foo_BAR_012']);

        $this->assertEquals('fooBAR', $bag->getAlpha('word'), '->getAlpha() gets only alphabetic characters');
        $this->assertEquals('', $bag->getAlpha('unknown'), '->getAlpha() returns empty string if a parameter is not defined');
    }

    public function testGetAlnum()
    {
        $bag = new ParameterBag(['word' => 'foo_BAR_012']);

        $this->assertEquals('fooBAR012', $bag->getAlnum('word'), '->getAlnum() gets only alphanumeric characters');
        $this->assertEquals('', $bag->getAlnum('unknown'), '->getAlnum() returns empty string if a parameter is not defined');
    }

    public function testGetDigits()
    {
        $bag = new ParameterBag(['word' => 'foo_BAR_012']);

        $this->assertEquals('012', $bag->getDigits('word'), '->getDigits() gets only digits as string');
        $this->assertEquals('', $bag->getDigits('unknown'), '->getDigits() returns empty string if a parameter is not defined');
    }

    public function testGetInt()
    {
        $bag = new ParameterBag(['digits' => '0123']);

        $this->assertEquals(123, $bag->getInt('digits'), '->getInt() gets a value of parameter as integer');
        $this->assertEquals(0, $bag->getInt('unknown'), '->getInt() returns zero if a parameter is not defined');
    }

    public function testFilter()
    {
        $bag = new ParameterBag([
            'digits' => '0123ab',
            'email' => 'example@example.com',
            'url' => 'http://example.com/foo',
            'dec' => '256',
            'hex' => '0x100',
            'array' => ['bang'],
            ]);

        $this->assertEmpty($bag->filter('nokey'), '->filter() should return empty by default if no key is found');

        $this->assertEquals('0123', $bag->filter('digits', '', FILTER_SANITIZE_NUMBER_INT), '->filter() gets a value of parameter as integer filtering out invalid characters');

        $this->assertEquals('example@example.com', $bag->filter('email', '', FILTER_VALIDATE_EMAIL), '->filter() gets a value of parameter as email');

        $this->assertEquals('http://example.com/foo', $bag->filter('url', '', FILTER_VALIDATE_URL, ['flags' => FILTER_FLAG_PATH_REQUIRED]), '->filter() gets a value of parameter as URL with a path');

        // This test is repeated for code-coverage
        $this->assertEquals('http://example.com/foo', $bag->filter('url', '', FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED), '->filter() gets a value of parameter as URL with a path');

        $this->assertFalse($bag->filter('dec', '', FILTER_VALIDATE_INT, [
            'flags' => FILTER_FLAG_ALLOW_HEX,
            'options' => ['mi