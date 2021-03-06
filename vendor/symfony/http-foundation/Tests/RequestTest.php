+</param>
            </data>
          </attribute>
        </group>
      </choice>
      <text/>
    </element>
  </define>

  <define name="references">
    <zeroOrMore>
      <ref name="xref"/>
    </zeroOrMore>
  </define>

  <define name="text_with_references">
    <interleave>
      <zeroOrMore>
        <text/>
        <optional><ref name="xref"/></optional>
      </zeroOrMore>
    </interleave>
  </define>

  <define name="richText">
    <zeroOrMore>
      <choice>
        <interleave>
          <ref name="text_with_references"/>
          <optional><element name="br"><empty/></element></optional>
        </interleave>
        <element name="paragraph">
          <interleave>
            <ref name="text_with_references"/>
            <optional><element name="br"><empty/></element></optional>
          </interleave>
        </element>
        <element name="artwork"><text/></element>
      </choice>
    </zeroOrMore>
  </define>

  <define name="genericRange">
    <data type="string">
      <param name="pattern">(\d+|0x[\da-fA-F]+)(\s*-\s*(\d+|0x[\da-fA-F]+))?</param>
    </data>
  </define>

  <define name="genericDate">
    <choice>
      <data type="date"/>
      <data type="gYearMonth"/>
    </choice>
  </define>

  <define name="hex32">
    <data type="string">
      <param name="pattern">0x[0-9]{8}</param>
    </data>
  </define>

  <define name="binary">
    <data type="string">
      <param name="pattern">[0-1]+</param>
    </data>
  </define>

  <define name="footnotes">
    <zeroOrMore>
      <element name="footnote">
        <attribute name="anchor"><data type="positiveInteger"/></attribute>
        <interleave>
          <zeroOrMore>
            <text/>
            <optional><ref name="xref"/></optional>
          </zeroOrMore>
        </interleave>
      </element>
    </zeroOrMore>
  </define>

  <define name="file">
    <element name="file">
      <attribute name="type">
        <choice>
          <value>legacy</value>
          <value>mib</value>
          <value>template</value>
          <value>json</value>
        </choice>
      </attribute>
      <optional>
        <attribute name="name"/>
      </optional>
      <data type="anyURI"/>
    </element>
  </define>

</grammar>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * SessionTest.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Robert Schönthal <seroscho@googlemail.com>
 * @author Drak <drak@zikula.org>
 */
class SessionTest extends TestCase
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Storage\SessionStorageInterface
     */
    protected $storage;

    /**
     * @var \Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    protected $session;

    protected function setUp()
    {
        $this->storage = new MockArraySessionStorage();
        $this->session = new Session($this->storage, new AttributeBag(), new FlashBag());
    }

    protected function tearDown()
    {
        $this->storage = null;
        $this->session = null;
    }

    public function testStart()
    {
        $this->assertEquals('', $this->session->getId());
        $this->assertTrue($this->session->start());
        $this->assertNotEquals('', $this->session->getId());
    }

    public function testIsStarted()
    {
        $this->assertFalse($this->session->isStarted());
        $this->session->start();
        $this->assertTrue($this->session->isStarted());
    }

    public function testSetId()
    {
        $this->assertEquals('', $this->session->getId());
        $this->session->setId('0123456789abcdef');
        $this->session->start();
        $this->assertEquals('0123456789abcdef', $this->session->getId());
    }

    public function testSetIdAfterStart()
    {
        $this->session->start();
        $id = $this->session->getId();

        $e = null;
        try {
            $this->session->setId($id);
        } catch (\Exception $e) {
        }

        $this->assertNull($e);

        try {
            $this->session->setId('different');
        } catch (\Exception $e) {
        }

        $this->assertInstanceOf('\LogicException', $e);
    }

    public function testSetName()
    {
        $this->assertEquals('MOCKSESSID', $this->session->getName());
        $this->session->setName('session.test.com');
        $this->session->start();
        $this->assertEquals('session.test.com', $this->session->getName());
    }

    public function testGet()
    {
        // tests defaults
        $this->assertNull($this->session->get('foo'));
        $this->assertEquals(1, $this->session->get('foo', 1));
    }

    /**
     * @dataProvider setProvider
     */
    public function testSet($key, $value)
    {
        $this->session->set($key, $value);
        $this->assertEquals($value, $this->session->get($key));
    }

    /**
     * @dataProvider setProvider
     */
    public function testHas($key, $value)
    {
        $this->session->set($key, $value);
        $this->assertTrue($this->session->has($key));
        $this->assertFalse($this->session->has($key.'non_value'));
    }

    public function testReplace()
    {
        $this->session->replace(['happiness' => 'be good', 'symfony' => 'awesome']);
        $this->assertEquals(['happiness' => 'be good', 'symfony' => 'awesome'], $this->session->all());
        $this->session->replace([]);
        $this->assertEquals([], $this->session->all());
    }

    /**
     * @dataProvider setProvider
     */
    public function testAll($key, $value, $result)
    {
        $this->session->set($key, $value);
        $this->assertEquals($result, $this->session->all());
    }

    /**
     * @dataProvider setProvider
     */
    public function testClear($key, $value)
    {
        $this->session->set('hi', 'fabien');
        $this->session->set($key, $value);
        $this->session->clear();
        $this->assertEquals([], $this->session->all());
    }

    public function setProvider()
    {
        return [
            ['foo', 'bar', ['foo' => 'bar']],
            ['foo.bar', 'too much beer', ['foo.bar' => 'too much beer']],
            ['great', 'symfony is great', ['great' => 'symfony is great']],
        ];
    }

    /**
     * @dataProvider setProvider
     */
    public function testRemove($key, $value)
    {
        $this->session->set('hi.world', 'have a nice day');
        $this->session->set($key, $value);
        $this->session->remove($key);
        $this->assertEquals(['hi.world' => 'have a nice day'], $this->session->all());
    }

    public function testInvalidate()
    {
        $this->session->set('invalidate', 123);
        $this->session->invalidate();
        $this->assertEquals([], $this->session->all());
    }

    public function testMigrate()
    {
        $this->session->set('migrate', 321);
        $this->session->migrate();
        $this->assertEquals(321, $this->session->get('migrate'));
    }

    public function testMigrateDestroy()
    {
        $this->session->set('migrate', 333);
        $this->session->migrate(true);
        $this->assertEquals(333, $this->session->get('migrate'));
    }

    public function testSave()
    {
        $this->session->start();
        $this->session->save();

        $this->assertFalse($this->session->isStarted());
    }

    public function testGetId()
    {
        $this->assertEquals('', $this->session->getId());
        $this->session->start();
        $this->assertNotEquals('', $this->session->getId());
    }

    public function testGetFlashBag()
    {
        $this->assertInstanceOf('Symfony\\Component\\HttpFoundation\\Session\\Flash\\FlashBagInterface', $this->session->getFlashBag());
    }

    public function testGetIterator()
    {
        $attributes = ['hello' => 'world', 'symfony' => 'rocks'];
        foreach ($attributes as $key => $val) {
            $this->session->set($key, $val);
        }

        $i = 0;
        foreach ($this->session as $key => $val) {
            $this->assertEquals($attributes[$key], $val);
            ++$i;
        }

        $this->assertEquals(\count($attributes), $i);
    }

    public function testGetCount()
    {
        $this->session->set('hello', 'world');
        $this->session->set('symfony', 'rocks');

        $this->assertCount(2, $this->session);
    }

    public function testGetMeta()
    {
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Storage\MetadataBag', $this->session->getMetadataBag());
    }

    public function testIsEmpty()
    {
        $this->assertTrue($this->session->isEmpty());

        $this->session->set('hello', 'world');
        $this->assertFalse($this->session->isEmpty());

        $this->session->remove('hello');
        $this->assertTrue($this->session->isEmpty());

        $flash = $this->session->getFlashBag();
        $flash->set('hello', 'world');
        $this->assertFalse($this->session->isEmpty());

        $flash->get('hello');
        $this->assertTrue($this->session->isEmpty());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Attribute;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;

/**
 * Tests AttributeBag.
 *
 * @author Drak <drak@zikula.org>
 */
class AttributeBagTest extends TestCase
{
    private $array = [];

    /**
     * @var AttributeBag
     */
    private $bag;

    protected function setUp()
    {
        $this->array = [
            'hello' => 'world',
            'always' => 'be happy',
            'user.login' => 'drak',
            'csrf.token' => [
                'a' => '1234',
                'b' => '4321',
            ],
            'category' => [
                'fishing' => [
                    'first' => 'cod',
                    'second' => 'sole',
                ],
            ],
        ];
        $this->bag = new AttributeBag('_sf');
        $this->bag->initialize($this->array);
    }

    protected function tearDown()
    {
        $this->bag = null;
        $this->array = [];
    }

    public function testInitialize()
    {
        $bag = new AttributeBag();
        $bag->initialize($this->array);
        $this->assertEquals($this->array, $bag->all());
        $array = ['should' => 'change'];
        $bag->initialize($array);
        $this->assertEquals($array, $bag->all());
    }

    public function testGetStorageKey()
    {
        $this->assertEquals('_sf', $this->bag->getStorageKey());
        $attributeBag = new AttributeBag('test');
        $this->assertEquals('test', $attributeBag->getStorageKey());
    }

    public function testGetSetName()
    {
        $this->assertEquals('attributes', $this->bag->getName());
        $this->bag->setName('foo');
        $this->assertEquals('foo', $this->bag->getName());
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testHas($key, $value, $exists)
    {
        $this->assertEquals($exists, $this->bag->has($key));
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testGet($key, $value, $expected)
    {
        $this->assertEquals($value, $this->bag->get($key));
    }

    public function testGetDefaults()
    {
        $this->assertNull($this->bag->get('user2.login'));
        $this->assertEquals('default', $this->bag->get('user2.login', 'default'));
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testSet($key, $value, $expected)
    {
        $this->bag->set($key, $value);
        $this->assertEquals($value, $this->bag->get($key));
    }

    public function testAll()
    {
        $this->assertEquals($this->array, $this->bag->all());

        $this->bag->set('hello', 'fabien');
        $array = $this->array;
        $array['hello'] = 'fabien';
        $this->assertEquals($array, $this->bag->all());
    }

    public function testReplace()
    {
        $array = [];
        $array['name'] = 'jack';
        $array['foo.bar'] = 'beep';
        $this->bag->replace($array);
        $this->assertEquals($array, $this->bag->all());
        $this->assertNull($this->bag->get('hello'));
        $this->assertNull($this->bag->get('always'));
        $this->assertNull($this->bag->get('user.login'));
    }

    public function testRemove()
    {
        $this->assertEquals('world', $this->bag->get('hello'));
        $this->bag->remove('hello');
        $this->assertNull($this->bag->get('hello'));

        $this->assertEquals('be happy', $this->bag->get('always'));
        $this->bag->remove('always');
        $this->assertNull($this->bag->get('always'));

        $this->assertEquals('drak', $this->bag->get('user.login'));
        $this->bag->remove('user.login');
        $this->assertNull($this->bag->get('user.login'));
    }

    public function testClear()
    {
        $this->bag->clear();
        $this->assertEquals([], $this->bag->all());
    }

    public function attributesProvider()
    {
        return [
            ['hello', 'world', true],
            ['always', 'be happy', true],
            ['user.login', 'drak', true],
            ['csrf.token', ['a' => '1234', 'b' => '4321'], true],
            ['category', ['fishing' => ['first' => 'cod', 'second' => 'sole']], true],
            ['user2.login', null, false],
            ['never', null, false],
            ['bye', null, false],
            ['bye/for/now', null, false],
        ];
    }

    public function testGetIterator()
    {
        $i = 0;
        foreach ($this->bag as $key => $val) {
            $this->assertEquals($this->array[$key], $val);
            ++$i;
        }

        $this->assertEquals(\count($this->array), $i);
    }

    public function testCount()
    {
        $this->assertCount(\count($this->array), $this->bag);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Attribute;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;

/**
 * Tests NamespacedAttributeBag.
 *
 * @author Drak <drak@zikula.org>
 */
class NamespacedAttributeBagTest extends TestCase
{
    private $array = [];

    /**
     * @var NamespacedAttributeBag
     */
    private $bag;

    protected function setUp()
    {
        $this->array = [
            'hello' => 'world',
            'always' => 'be happy',
            'user.login' => 'drak',
            'csrf.token' => [
                'a' => '1234',
                'b' => '4321',
            ],
            'category' => [
                'fishing' => [
                    'first' => 'cod',
                    'second' => 'sole',
                ],
            ],
        ];
        $this->bag = new NamespacedAttributeBag('_sf2', '/');
        $this->bag->initialize($this->array);
    }

    protected function tearDown()
    {
        $this->bag = null;
        $this->array = [];
    }

    public function testInitialize()
    {
        $bag = new NamespacedAttributeBag();
        $bag->initialize($this->array);
        $this->assertEquals($this->array, $this->bag->all());
        $array = ['should' => 'not stick'];
        $bag->initialize($array);

        // should have remained the same
        $this->assertEquals($this->array, $this->bag->all());
    }

    public function testGetStorageKey()
    {
        $this->assertEquals('_sf2', $this->bag->getStorageKey());
        $attributeBag = new NamespacedAttributeBag('test');
        $this->assertEquals('test', $attributeBag->getStorageKey());
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testHas($key, $value, $exists)
    {
        $this->assertEquals($exists, $this->bag->has($key));
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testHasNoSideEffect($key, $value, $expected)
    {
        $expected = json_encode($this->bag->all());
        $this->bag->has($key);

        $this->assertEquals($expected, json_encode($this->bag->all()));
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testGet($key, $value, $expected)
    {
        $this->assertEquals($value, $this->bag->get($key));
    }

    public function testGetDefaults()
    {
        $this->assertNull($this->bag->get('user2.login'));
        $this->assertEquals('default', $this->bag->get('user2.login', 'default'));
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testGetNoSideEffect($key, $value, $expected)
    {
        $expected = json_encode($this->bag->all());
        $this->bag->get($key);

        $this->assertEquals($expected, json_encode($this->bag->all()));
    }

    /**
     * @dataProvider attributesProvider
     */
    public function testSet($key, $value, $expected)
    {
        $this->bag->set($key, $value);
        $this->assertEquals($value, $this->bag->get($key));
    }

    public function testAll()
    {
        $this->assertEquals($this->array, $this->bag->all());

        $this->bag->set('hello', 'fabien');
        $array = $this->array;
        $array['hello'] = 'fabien';
        $this->assertEquals($array, $this->bag->all());
    }

    public function testReplace()
    {
        $array = [];
        $array['name'] = 'jack';
        $array['foo.bar'] = 'beep';
        $this->bag->replace($array);
        $this->assertEquals($array, $this->bag->all());
        $this->assertNull($this->bag->get('hello'));
        $this->assertNull($this->bag->get('always'));
        $this->assertNull($this->bag->get('user.login'));
    }

    public function testRemove()
    {
        $this->assertEquals('world', $this->bag->get('hello'));
        $this->bag->remove('hello');
        $this->assertNull($this->bag->get('hello'));

        $this->assertEquals('be happy', $this->bag->get('always'));
        $this->bag->remove('always');
        $this->assertNull($this->bag->get('always'));

        $this->assertEquals('drak', $this->bag->get('user.login'));
        $this->bag->remove('user.login');
        $this->assertNull($this->bag->get('user.login'));
    }

    public function testRemoveExistingNamespacedAttribute()
    {
        $this->assertSame('cod', $this->bag->remove('category/fishing/first'));
    }

    public function testRemoveNonexistingNamespacedAttribute()
    {
        $this->assertNull($this->bag->remove('foo/bar/baz'));
    }

    public function testClear()
    {
        $this->bag->clear();
        $this->assertEquals([], $this->bag->all());
    }

    public function attributesProvider()
    {
        return [
            ['hello', 'world', true],
            ['always', 'be happy', true],
            ['user.login', 'drak', true],
            ['csrf.token', ['a' => '1234', 'b' => '4321'], true],
            ['csrf.token/a', '1234', true],
            ['csrf.token/b', '4321', true],
            ['category', ['fishing' => ['first' => 'cod', 'second' => 'sole']], true],
            ['category/fishing', ['first' => 'cod', 'second' => 'sole'], true],
            ['category/fishing/missing/first', null, false],
            ['category/fishing/first', 'cod', true],
            ['category/fishing/second', 'sole', true],
            ['category/fishing/missing/second', null, false],
            ['user2.login', null, false],
            ['never', null, false],
            ['bye', null, false],
            ['bye/for/now', null, false],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Flash;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag as FlashBag;

/**
 * AutoExpireFlashBagTest.
 *
 * @author Drak <drak@zikula.org>
 */
class AutoExpireFlashBagTest extends TestCase
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag
     */
    private $bag;

    protected $array = [];

    protected function setUp()
    {
        parent::setUp();
        $this->bag = new FlashBag();
        $this->array = ['new' => ['notice' => ['A previous flash message']]];
        $this->bag->initialize($this->array);
    }

    protected function tearDown()
    {
        $this->bag = null;
        parent::tearDown();
    }

    public function testInitialize()
    {
        $bag = new FlashBag();
        $array = ['new' => ['notice' => ['A previous flash message']]];
        $bag->initialize($array);
        $this->assertEquals(['A previous flash message'], $bag->peek('notice'));
        $array = ['new' => [
                'notice' => ['Something else'],
                'error' => ['a'],
            ]];
        $bag->initialize($array);
        $this->assertEquals(['Something else'], $bag->peek('notice'));
        $this->assertEquals(['a'], $bag->peek('error'));
    }

    public function testGetStorageKey()
    {
        $this->assertEquals('_symfony_flashes', $this->bag->getStorageKey());
        $attributeBag = new FlashBag('test');
        $this->assertEquals('test', $attributeBag->getStorageKey());
    }

    public function testGetSetName()
    {
        $this->assertEquals('flashes', $this->bag->getName());
        $this->bag->setName('foo');
        $this->assertEquals('foo', $this->bag->getName());
    }

    public function testPeek()
    {
        $this->assertEquals([], $this->bag->peek('non_existing'));
        $this->assertEquals(['default'], $this->bag->peek('non_existing', ['default']));
        $this->assertEquals(['A previous flash message'], $this->bag->peek('notice'));
        $this->assertEquals(['A previous flash message'], $this->bag->peek('notice'));
    }

    public function testSet()
    {
        $this->bag->set('notice', 'Foo');
        $this->assertEquals(['A previous flash message'], $this->bag->peek('notice'));
    }

    public function testHas()
    {
        $this->assertFalse($this->bag->has('nothing'));
        $this->assertTrue($this->bag->has('notice'));
    }

    public function testKeys()
    {
        $this->assertEquals(['notice'], $this->bag->keys());
    }

    public function testPeekAll()
    {
        $array = [
            'new' => [
                'notice' => 'Foo',
                'error' => 'Bar',
            ],
        ];

        $this->bag->initialize($array);
        $this->assertEquals([
            'notice' => 'Foo',
            'error' => 'Bar',
            ], $this->bag->peekAll()
        );

        $this->assertEquals([
            'notice' => 'Foo',
            'error' => 'Bar',
            ], $this->bag->peekAll()
        );
    }

    public function testGet()
    {
        $this->assertEquals([], $this->bag->get('non_existing'));
        $this->assertEquals(['default'], $this->bag->get('non_existing', ['default']));
        $this->assertEquals(['A previous flash message'], $this->bag->get('notice'));
        $this->assertEquals([], $this->bag->get('notice'));
    }

    public function testSetAll()
    {
        $this->bag->setAll(['a' => 'first', 'b' => 'second']);
        $this->assertFalse($this->bag->has('a'));
        $this->assertFalse($this->bag->has('b'));
    }

    public function testAll()
    {
        $this->bag->set('notice', 'Foo');
        $this->bag->set('error', 'Bar');
        $this->assertEquals([
            'notice' => ['A previous flash message'],
            ], $this->bag->all()
        );

        $this->assertEquals([], $this->bag->all());
    }

    public function testClear()
    {
        $this->assertEquals(['notice' => ['A previous flash message']], $this->bag->clear());
    }

    public function testDoNotRemoveTheNewFlashesWhenDisplayingTheExistingOnes()
    {
        $this->bag->add('success', 'Something');
        $this->bag->all();

        $this->assertEquals(['new' => ['success' => ['Something']], 'display' => []], $this->array);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Flash;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

/**
 * FlashBagTest.
 *
 * @author Drak <drak@zikula.org>
 */
class FlashBagTest extends TestCase
{
    /**
     * @var \Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface
     */
    private $bag;

    protected $array = [];

    protected function setUp()
    {
        parent::setUp();
        $this->bag = new FlashBag();
        $this->array = ['notice' => ['A previous flash message']];
        $this->bag->initialize($this->array);
    }

    protected function tearDown()
    {
        $this->bag = null;
        parent::tearDown();
    }

    public function testInitialize()
    {
        $bag = new FlashBag();
        $bag->initialize($this->array);
        $this->assertEquals($this->array, $bag->peekAll());
        $array = ['should' => ['change']];
        $bag->initialize($array);
        $this->assertEquals($array, $bag->peekAll());
    }

    public function testGetStorageKey()
    {
        $this->assertEquals('_symfony_flashes', $this->bag->getStorageKey());
        $attributeBag = new FlashBag('test');
        $this->assertEquals('test', $attributeBag->getStorageKey());
    }

    public function testGetSetName()
    {
        $this->assertEquals('flashes', $this->bag->getName());
        $this->bag->setName('foo');
        $this->assertEquals('foo', $this->bag->getName());
    }

    public function testPeek()
    {
        $this->assertEquals([], $this->bag->peek('non_existing'));
        $this->assertEquals(['default'], $this->bag->peek('not_existing', ['default']));
        $this->assertEquals(['A previous flash message'], $this->bag->peek('notice'));
        $this->assertEquals(['A previous flash message'], $this->bag->peek('notice'));
    }

    public function testAdd()
    {
        $tab = ['bar' => 'baz'];
        $this->bag->add('string_message', 'lorem');
        $this->bag->add('object_message', new \stdClass());
        $this->bag->add('array_message', $tab);

        $this->assertEquals(['lorem'], $this->bag->get('string_message'));
        $this->assertEquals([new \stdClass()], $this->bag->get('object_message'));
        $this->assertEquals([$tab], $this->bag->get('array_message'));
    }

    public function testGet()
    {
        $this->assertEquals([], $this->bag->get('non_existing'));
        $this->assertEquals(['default'], $this->bag->get('not_existing', ['default']));
        $this->assertEquals(['A previous flash message'], $this->bag->get('notice'));
        $this->assertEquals([], $this->bag->get('notice'));
    }

    public function testAll()
    {
        $this->bag->set('notice', 'Foo');
        $this->bag->set('error', 'Bar');
        $this->assertEquals([
            'notice' => ['Foo'],
            'error' => ['Bar'], ], $this->bag->all()
        );

        $this->assertEquals([], $this->bag->all());
    }

    public function testSet()
    {
        $this->bag->set('notice', 'Foo');
        $this->bag->set('notice', 'Bar');
        $this->assertEquals(['Bar'], $this->bag->peek('notice'));
    }

    public function testHas()
    {
        $this->assertFalse($this->bag->has('nothing'));
        $this->assertTrue($this->bag->has('notice'));
    }

    public function testKeys()
    {
        $this->assertEquals(['notice'], $this->bag->keys());
    }

    public function testSetAll()
    {
        $this->bag->add('one_flash', 'Foo');
        $this->bag->add('another_flash', 'Bar');
        $this->assertTrue($this->bag->has('one_flash'));
        $this->assertTrue($this->bag->has('another_flash'));
        $this->bag->setAll(['unique_flash' => 'FooBar']);
        $this->assertFalse($this->bag->has('one_flash'));
        $this->assertFalse($this->bag->has('another_flash'));
        $this->assertSame(['unique_flash' => 'FooBar'], $this->bag->all());
        $this->assertSame([], $this->bag->all());
    }

    public function testPeekAll()
    {
        $this->bag->set('notice', 'Foo');
        $this->bag->set('error', 'Bar');
        $this->assertEquals([
            'notice' => ['Foo'],
            'error' => ['Bar'],
            ], $this->bag->peekAll()
        );
        $this->assertTrue($this->bag->has('notice'));
        $this->assertTrue($this->bag->has('error'));
        $this->assertEquals([
            'notice' => ['Foo'],
            'error' => ['Bar'],
            ], $this->bag->peekAll()
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\MetadataBag;

/**
 * Test class for MetadataBag.
 *
 * @group time-sensitive
 */
class MetadataBagTest extends TestCase
{
    /**
     * @var MetadataBag
     */
    protected $bag;

    protected $array = [];

    protected function setUp()
    {
        parent::setUp();
        $this->bag = new MetadataBag();
        $this->array = [MetadataBag::CREATED => 1234567, MetadataBag::UPDATED => 12345678, MetadataBag::LIFETIME => 0];
        $this->bag->initialize($this->array);
    }

    protected function tearDown()
    {
        $this->array = [];
        $this->bag = null;
        parent::tearDown();
    }

    public function testInitialize()
    {
        $sessionMetadata = [];

        $bag1 = new MetadataBag();
        $bag1->initialize($sessionMetadata);
        $this->assertGreaterThanOrEqual(time(), $bag1->getCreated());
        $this->assertEquals($bag1->getCreated(), $bag1->getLastUsed());

        sleep(1);
        $bag2 = new MetadataBag();
        $bag2->initialize($sessionMetadata);
        $this->assertEquals($bag1->getCreated(), $bag2->getCreated());
        $this->assertEquals($bag1->getLastUsed(), $bag2->getLastUsed());
        $this->assertEquals($bag2->getCreated(), $bag2->getLastUsed());

        sleep(1);
        $bag3 = new MetadataBag();
        $bag3->initialize($sessionMetadata);
        $this->assertEquals($bag1->getCreated(), $bag3->getCreated());
        $this->assertGreaterThan($bag2->getLastUsed(), $bag3->getLastUsed());
        $this->assertNotEquals($bag3->getCreated(), $bag3->getLastUsed());
    }

    public function testGetSetName()
    {
        $this->assertEquals('__metadata', $this->bag->getName());
        $this->bag->setName('foo');
        $this->assertEquals('foo', $this->bag->getName());
    }

    public function testGetStorageKey()
    {
        $this->assertEquals('_sf2_meta', $this->bag->getStorageKey());
    }

    public function testGetLifetime()
    {
        $bag = new MetadataBag();
        $array = [MetadataBag::CREATED => 1234567, MetadataBag::UPDATED => 12345678, MetadataBag::LIFETIME => 1000];
        $bag->initialize($array);
        $this->assertEquals(1000, $bag->getLifetime());
    }

    public function testGetCreated()
    {
        $this->assertEquals(1234567, $this->bag->getCreated());
    }

    public function testGetLastUsed()
    {
        $this->assertLessThanOrEqual(time(), $this->bag->getLastUsed());
    }

    public function testClear()
    {
        $this->bag->clear();

        // the clear method has no side effects, we just want to ensure it doesn't trigger any exceptions
        $this->addToAssertionCount(1);
    }

    public function testSkipLastUsedUpdate()
    {
        $bag = new MetadataBag('', 30);
        $timeStamp = time();

        $created = $timeStamp - 15;
        $sessionMetadata = [
            MetadataBag::CREATED => $created,
            MetadataBag::UPDATED => $created,
            MetadataBag::LIFETIME => 1000,
        ];
        $bag->initialize($sessionMetadata);

        $this->assertEquals($created, $sessionMetadata[MetadataBag::UPDATED]);
    }

    public function testDoesNotSkipLastUsedUpdate()
    {
        $bag = new MetadataBag('', 30);
        $timeStamp = time();

        $created = $timeStamp - 45;
        $sessionMetadata = [
            MetadataBag::CREATED => $created,
            MetadataBag::UPDATED => $created,
            MetadataBag::LIFETIME => 1000,
        ];
        $bag->initialize($sessionMetadata);

        $this->assertEquals($timeStamp, $sessionMetadata[MetadataBag::UPDATED]);
    }
}
                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

/**
 * Test class for MockArraySessionStorage.
 *
 * @author Drak <drak@zikula.org>
 */
class MockArraySessionStorageTest extends TestCase
{
    /**
     * @var MockArraySessionStorage
     */
    private $storage;

    /**
     * @var AttributeBag
     */
    private $attributes;

    /**
     * @var FlashBag
     */
    private $flashes;

    private $data;

    protected function setUp()
    {
        $this->attributes = new AttributeBag();
        $this->flashes = new FlashBag();

        $this->data = [
            $this->attributes->getStorageKey() => ['foo' => 'bar'],
            $this->flashes->getStorageKey() => ['notice' => 'hello'],
        ];

        $this->storage = new MockArraySessionStorage();
        $this->storage->registerBag($this->flashes);
        $this->storage->registerBag($this->attributes);
        $this->storage->setSessionData($this->data);
    }

    protected function tearDown()
    {
        $this->data = null;
        $this->flashes = null;
        $this->attributes = null;
        $this->storage = null;
    }

    public function testStart()
    {
        $this->assertEquals('', $this->storage->getId());
        $this->storage->start();
        $id = $this->storage->getId();
        $this->assertNotEquals('', $id);
        $this->storage->start();
        $this->assertEquals($id, $this->storage->getId());
    }

    public function testRegenerate()
    {
        $this->storage->start();
        $id = $this->storage->getId();
        $this->storage->regenerate();
        $this->assertNotEquals($id, $this->storage->getId());
        $this->assertEquals(['foo' => 'bar'], $this->storage->getBag('attributes')->all());
        $this->assertEquals(['notice' => 'hello'], $this->storage->getBag('flashes')->peekAll());

        $id = $this->storage->getId();
        $this->storage->regenerate(true);
        $this->assertNotEquals($id, $this->storage->getId());
        $this->assertEquals(['foo' => 'bar'], $this->storage->getBag('attributes')->all());
        $this->assertEquals(['notice' => 'hello'], $this->storage->getBag('flashes')->peekAll());
    }

    public function testGetId()
    {
        $this->assertEquals('', $this->storage->getId());
        $this->storage->start();
        $this->assertNotEquals('', $this->storage->getId());
    }

    public function testClearClearsBags()
    {
        $this->storage->clear();

        $this->assertSame([], $this->storage->getBag('attributes')->all());
        $this->assertSame([], $this->storage->getBag('flashes')->peekAll());
    }

    public function testClearStartsSession()
    {
        $this->storage->clear();

        $this->assertTrue($this->storage->isStarted());
    }

    public function testClearWithNoBagsStartsSession()
    {
        $storage = new MockArraySessionStorage();

        $storage->clear();

        $this->assertTrue($storage->isStarted());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testUnstartedSave()
    {
        $this->storage->save();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

/**
 * Test class for MockFileSessionStorage.
 *
 * @author Drak <drak@zikula.org>
 */
class MockFileSessionStorageTest extends TestCase
{
    /**
     * @var string
     */
    private $sessionDir;

    /**
     * @var MockFileSessionStorage
     */
    protected $storage;

    protected function setUp()
    {
        $this->sessionDir = sys_get_temp_dir().'/sftest';
        $this->storage = $this->getStorage();
    }

    protected function tearDown()
    {
        $this->sessionDir = null;
        $this->storage = null;
        array_map('unlink', glob($this->sessionDir.'/*.session'));
        if (is_dir($this->sessionDir)) {
            rmdir($this->sessionDir);
        }
    }

    public function testStart()
    {
        $this->assertEquals('', $this->storage->getId());
        $this->assertTrue($this->storage->start());
        $id = $this->storage->getId();
        $this->assertNotEquals('', $this->storage->getId());
        $this->assertTrue($this->storage->start());
        $this->assertEquals($id, $this->storage->getId());
    }

    public function testRegenerate()
    {
        $this->storage->start();
        $this->storage->getBag('attributes')->set('regenerate', 1234);
        $this->storage->regenerate();
        $this->assertEquals(1234, $this->storage->getBag('attributes')->get('regenerate'));
        $this->storage->regenerate(true);
        $this->assertEquals(1234, $this->storage->getBag('attributes')->get('regenerate'));
    }

    public function testGetId()
    {
        $this->assertEquals('', $this->storage->getId());
        $this->storage->start();
        $this->assertNotEquals('', $this->storage->getId());
    }

    public function testSave()
    {
        $this->storage->start();
        $id = $this->storage->getId();
        $this->assertNotEquals('108', $this->storage->getBag('attributes')->get('new'));
        $this->assertFalse($this->storage->getBag('flashes')->has('newkey'));
        $this->storage->getBag('attributes')->set('new', '108');
        $this->storage->getBag('flashes')->set('newkey', 'test');
        $this->storage->save();

        $storage = $this->getStorage();
        $storage->setId($id);
        $storage->start();
        $this->assertEquals('108', $storage->getBag('attributes')->get('new'));
        $this->assertTrue($storage->getBag('flashes')->has('newkey'));
        $this->assertEquals(['test'], $storage->getBag('flashes')->peek('newkey'));
    }

    public function testMultipleInstances()
    {
        $storage1 = $this->getStorage();
        $storage1->start();
        $storage1->getBag('attributes')->set('foo', 'bar');
        $storage1->save();

        $storage2 = $this->getStorage();
        $storage2->setId($storage1->getId());
        $storage2->start();
        $this->assertEquals('bar', $storage2->getBag('attributes')->get('foo'), 'values persist between instances');
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSaveWithoutStart()
    {
        $storage1 = $this->getStorage();
        $storage1->save();
    }

    private function getStorage()
    {
        $storage = new MockFileSessionStorage($this->sessionDir);
        $storage->registerBag(new FlashBag());
        $storage->registerBag(new AttributeBag());

        return $storage;
    }
}
                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy;

/**
 * Test class for NativeSessionStorage.
 *
 * @author Drak <drak@zikula.org>
 *
 * These tests require separate processes.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class NativeSessionStorageTest extends TestCase
{
    private $savePath;

    protected function setUp()
    {
        $this->iniSet('session.save_handler', 'files');
        $this->iniSet('session.save_path', $this->savePath = sys_get_temp_dir().'/sftest');
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath);
        }
    }

    protected function tearDown()
    {
        session_write_close();
        array_map('unlink', glob($this->savePath.'/*'));
        if (is_dir($this->savePath)) {
            rmdir($this->savePath);
        }

        $this->savePath = null;
    }

    /**
     * @return NativeSessionStorage
     */
    protected function getStorage(array $options = [])
    {
        $storage = new NativeSessionStorage($options);
        $storage->registerBag(new AttributeBag());

        return $storage;
    }

    public function testBag()
    {
        $storage = $this->getStorage();
        $bag = new FlashBag();
        $storage->registerBag($bag);
        $this->assertSame($bag, $storage->getBag($bag->getName()));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRegisterBagException()
    {
        $storage = $this->getStorage();
        $storage->getBag('non_existing');
    }

    /**
     * @expectedException \LogicException
     */
    public function testRegisterBagForAStartedSessionThrowsException()
    {
        $storage = $this->getStorage();
        $storage->start();
        $storage->registerBag(new AttributeBag());
    }

    public function testGetId()
    {
        $storage = $this->getStorage();
        $this->assertSame('', $storage->getId(), 'Empty ID before starting session');

        $storage->start();
        $id = $storage->getId();
        $this->assertInternalType('string', $id);
        $this->assertNotSame('', $id);

        $storage->save();
        $this->assertSame($id, $storage->getId(), 'ID stays after saving session');
    }

    public function testRegenerate()
    {
        $storage = $this->getStorage();
        $storage->start();
        $id = $storage->getId();
        $storage->getBag('attributes')->set('lucky', 7);
        $storage->regenerate();
        $this->assertNotEquals($id, $storage->getId());
        $this->assertEquals(7, $storage->getBag('attributes')->get('lucky'));
    }

    public function testRegenerateDestroy()
    {
        $storage = $this->getStorage();
        $storage->start();
        $id = $storage->getId();
        $storage->getBag('attributes')->set('legs', 11);
        $storage->regenerate(true);
        $this->assertNotEquals($id, $storage->getId());
        $this->assertEquals(11, $storage->getBag('attributes')->get('legs'));
    }

    public function testSessionGlobalIsUpToDateAfterIdRegeneration()
    {
        $storage = $this->getStorage();
        $storage->start();
        $storage->getBag('attributes')->set('lucky', 7);
        $storage->regenerate();
        $storage->getBag('attributes')->set('lucky', 42);

        $this->assertEquals(42, $_SESSION['_sf2_attributes']['lucky']);
    }

    public function testRegenerationFailureDoesNotFlagStorageAsStarted()
    {
        $storage = $this->getStorage();
        $this->assertFalse($storage->regenerate());
        $this->assertFalse($storage->isStarted());
    }

    public function testDefaultSessionCacheLimiter()
    {
        $this->iniSet('session.cache_limiter', 'nocache');

        $storage = new NativeSessionStorage();
        $this->assertEquals('', ini_get('session.cache_limiter'));
    }

    public function testExplicitSessionCacheLimiter()
    {
        $this->iniSet('session.cache_limiter', 'nocache');

        $storage = new NativeSessionStorage(['cache_limiter' => 'public']);
        $this->assertEquals('public', ini_get('session.cache_limiter'));
    }

    public function testCookieOptions()
    {
        $options = [
            'cookie_lifetime' => 123456,
            'cookie_path' => '/my/cookie/path',
            'cookie_domain' => 'symfony.example.com',
            'cookie_secure' => true,
            'cookie_httponly' => false,
        ];

        if (\PHP_VERSION_ID >= 70300) {
            $options['cookie_samesite'] = 'lax';
        }

        $this->getStorage($options);
        $temp = session_get_cookie_params();
        $gco = [];

        foreach ($temp as $key => $value) {
            $gco['cookie_'.$key] = $value;
        }

        $this->assertEquals($options, $gco);
    }

    public function testSessionOptions()
    {
        if (\defined('HHVM_VERSION')) {
            $this->markTestSkipped('HHVM is not handled in this test case.');
        }

        $options = [
            'url_rewriter.tags' => 'a=href',
            'cache_expire' => '200',
        ];

        $this->getStorage($options);

        $this->assertSame('a=href', ini_get('url_rewriter.tags'));
        $this->assertSame('200', ini_get('session.cache_expire'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetSaveHandlerException()
    {
        $storage = $this->getStorage();
        $storage->setSaveHandler(new \stdClass());
    }

    public function testSetSaveHandler()
    {
        $this->iniSet('session.save_handler', 'files');
        $storage = $this->getStorage();
        $storage->setSaveHandler();
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy', $storage->getSaveHandler());
        $storage->setSaveHandler(null);
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy', $storage->getSaveHandler());
        $storage->setSaveHandler(new SessionHandlerProxy(new NativeFileSessionHandler()));
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy', $storage->getSaveHandler());
        $storage->setSaveHandler(new NativeFileSessionHandler());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy', $storage->getSaveHandler());
        $storage->setSaveHandler(new SessionHandlerProxy(new NullSessionHandler()));
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy', $storage->getSaveHandler());
        $storage->setSaveHandler(new NullSessionHandler());
        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Session\Storage\Proxy\SessionHandlerProxy', $storage->getSaveHandler());
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testStarted()
    {
        $storage = $this->getStorage();

        $this->assertFalse($storage->getSaveHandler()->isActive());
        $this->assertFalse($storage->isStarted());

        session_start();
        $this->assertTrue(isset($_SESSION));
        $this->assertTrue($storage->getSaveHandler()->isActive());

        // PHP session might have started, but the storage driver has not, so false is correct here
        $this->assertFalse($storage->isStarted());

        $key = $storage->getMetadataBag()->getStorageKey();
        $this->assertArrayNotHasKey($key, $_SESSION);
        $storage->start();
    }

    public function testRestart()
    {
        $storage = $this->getStorage();
        $storage->start();
        $id = $storage->getId();
        $storage->getBag('attributes')->set('lucky', 7);
        $storage->save();
        $storage->start();
        $this->assertSame($id, $storage->getId(), 'Same session ID after restarting');
        $this->assertSame(7, $storage->getBag('attributes')->get('lucky'), 'Data still available');
    }

    public function testCanCreateNativeSessionStorageWhenSessionAlreadyStarted()
    {
        session_start();
        $this->getStorage();

        // Assert no exception has been thrown by `getStorage()`
        $this->addToAssertionCount(1);
    }

    public function testSetSessionOptionsOnceSessionStartedIsIgnored()
    {
        session_start();
        $this->getStorage([
            'name' => 'something-else',
        ]);

        // Assert no exception has been thrown by `getStorage()`
        $this->addToAssertionCount(1);
    }

    public function testGetBagsOnceSessionStartedIsIgnored()
    {
        session_start();
        $bag = new AttributeBag();
        $bag->setName('flashes');

        $storage = $this->getStorage();
        $storage->registerBag($bag);

        $this->assertEquals($storage->getBag('flashes'), $bag);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      INDX( 	 ���             (   �  �       c                     Z/     ` P     T/     ���pk����pk����pk����pk�                        H a n d l e r U/     x h     T/     ���pk� ;n< �/����<����pk�       �               M e t a d a t a B a g T e s t . p h p V/     � �     T/     ����pk� ;n< ��E���<�����pk�                      M o c k A r r a y S e s s i o n S t o r a g e T e s t . p h p W/     � ~     T/     ����pk� ;n< �����<�����pk�                      M o  k F i l e S e s s i o n S t o r a g e T e s t . p h p   X/     � z     T/     F���pk� ;n< �����<�F���pk� 0      J%               N a t i v e S e s s i o n S t o r a g e T e s t . p h p       Y/     � �     T/     ���pk� ;n< �6���<����pk�       �
               P h p B r i d g e S e s s i o n S t o r a g e T e s t . p h p {/     ` L     T/     ��<�pk�Z+� %���<�pk���<�pk�                        P r o x y                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

/**
 * Test class for PhpSessionStorage.
 *
 * @author Drak <drak@zikula.org>
 *
 * These tests require separate processes.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class PhpBridgeSessionStorageTest extends TestCase
{
    private $savePath;

    protected function setUp()
    {
        $this->iniSet('session.save_handler', 'files');
        $this->iniSet('session.save_path', $this->savePath = sys_get_temp_dir().'/sftest');
        if (!is_dir($this->savePath)) {
            mkdir($this->savePath);
        }
    }

    protected function tearDown()
    {
        session_write_close();
        array_map('unlink', glob($this->savePath.'/*'));
        if (is_dir($this->savePath)) {
            rmdir($this->savePath);
        }

        $this->savePath = null;
    }

    /**
     * @return PhpBridgeSessionStorage
     */
    protected function getStorage()
    {
        $storage = new PhpBridgeSessionStorage();
        $storage->registerBag(new AttributeBag());

        return $storage;
    }

    public function testPhpSession()
    {
        $storage = $this->getStorage();

        $this->assertNotSame(\PHP_SESSION_ACTIVE, session_status());
        $this->assertFalse($storage->isStarted());

        session_start();
        $this->assertTrue(isset($_SESSION));
        $this->assertSame(\PHP_SESSION_ACTIVE, session_status());
        // PHP session might have started, but the storage driver has not, so false is correct here
        $this->assertFalse($storage->isStarted());

        $key = $storage->getMetadataBag()->getStorageKey();
        $this->assertArrayNotHasKey($key, $_SESSION);
        $storage->start();
        $this->assertArrayHasKey($key, $_SESSION);
    }

    public function testClear()
    {
        $storage = $this->getStorage();
        session_start();
        $_SESSION['drak'] = 'loves symfony';
        $storage->getBag('attributes')->set('symfony', 'greatness');
        $key = $storage->getBag('attributes')->getStorageKey();
        $this->assertEquals($_SESSION[$key], ['symfony' => 'greatness']);
        $this->assertEquals($_SESSION['drak'], 'loves symfony');
        $storage->clear();
        $this->assertEquals($_SESSION[$key], []);
        $this->assertEquals($_SESSION['drak'], 'loves symfony');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\RedisSessionHandler;

/**
 * @requires extension redis
 * @group time-sensitive
 */
abstract class AbstractRedisSessionHandlerTestCase extends TestCase
{
    protected const PREFIX = 'prefix_';

    /**
     * @var RedisSessionHandler
     */
    protected $storage;

    /**
     * @var \Redis|\RedisArray|\RedisCluster|\Predis\Client
     */
    protected $redisClient;

    /**
     * @return \Redis|\RedisArray|\RedisCluster|\Predis\Client
     */
    abstract protected function createRedisClient(string $host);

    protected function setUp()
    {
        parent::setUp();

        if (!\extension_loaded('redis')) {
            self::markTestSkipped('Extension redis required.');
        }

        $host = getenv('REDIS_HOST') ?: 'localhost';

        $this->redisClient = $this->createRedisClient($host);
        $this->storage = new RedisSessionHandler(
            $this->redisClient,
            ['prefix' => self::PREFIX]
        );
    }

    protected function tearDown()
    {
        $this->redisClient = null;
        $this->storage = null;

        parent::tearDown();
    }

    public function testOpenSession()
    {
        $this->assertTrue($this->storage->open('', ''));
    }

    public function testCloseSession()
    {
        $this->assertTrue($this->storage->close());
    }

    public function testReadSession()
    {
        $this->redisClient->set(self::PREFIX.'id1', null);
        $this->redisClient->set(self::PREFIX.'id2', 'abc123');

        $this->assertEquals('', $this->storage->read('id1'));
        $this->assertEquals('abc123', $this->storage->read('id2'));
    }

    public function testWriteSession()
    {
        $this->assertTrue($this->storage->write('id', 'data'));

        $this->assertTrue((bool) $this->redisClient->exists(self::PREFIX.'id'));
        $this->assertEquals('data', $this->redisClient->get(self::PREFIX.'id'));
    }

    public function testUseSessionGcMaxLifetimeAsTimeToLive()
    {
        $this->storage->write('id', 'data');
        $ttl = $this->redisClient->ttl(self::PREFIX.'id');

        $this->assertLessThanOrEqual(ini_get('session.gc_maxlifetime'), $ttl);
        $this->assertGreaterThanOrEqual(0, $ttl);
    }

    public function testDestroySession()
    {
        $this->redisClient->set(self::PREFIX.'id', 'foo');

        $this->assertTrue((bool) $this->redisClient->exists(self::PREFIX.'id'));
        $this->assertTrue($this->storage->destroy('id'));
        $this->assertFalse((bool) $this->redisClient->exists(self::PREFIX.'id'));
    }

    public function testGcSession()
    {
        $this->assertTrue($this->storage->gc(123));
    }

    public function testUpdateTimestamp()
    {
        $lowTtl = 10;

        $this->redisClient->setex(self::PREFIX.'id', $lowTtl, 'foo');
        $this->storage->updateTimestamp('id', []);

        $this->assertGreaterThan($lowTtl, $this->redisClient->ttl(self::PREFIX.'id'));
    }

    /**
     * @dataProvider getOptionFixtures
     */
    public function testSupportedParam(array $options, bool $supported)
    {
        try {
            new RedisSessionHandler($this->redisClient, $options);
            $this->assertTrue($supported);
        } catch (\InvalidArgumentException $e) {
            $this->assertFalse($supported);
        }
    }

    public function getOptionFixtures(): array
    {
        return [
            [['prefix' => 'session'], true],
            [['prefix' => 'sfs', 'foo' => 'bar'], false],
        ];
    }
}
                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

use PHPUnit\Framework\TestCase;

class AbstractSessionHandlerTest extends TestCase
{
    private static $server;

    public static function setUpBeforeClass()
    {
        $spec = [
            1 => ['file', '/dev/null', 'w'],
            2 => ['file', '/dev/null', 'w'],
        ];
        if (!self::$server = @proc_open('exec php -S localhost:8053', $spec, $pipes, __DIR__.'/Fixtures')) {
            self::markTestSkipped('PHP server unable to start.');
        }
        sleep(1);
    }

    public static function tearDownAfterClass()
    {
        if (self::$server) {
            proc_terminate(self::$server);
            proc_close(self::$server);
        }
    }

    /**
     * @dataProvider provideSession
     */
    public function testSession($fixture)
    {
        $context = ['http' => ['header' => "Cookie: sid=123abc\r\n"]];
        $context = stream_context_create($context);
        $result = file_get_contents(sprintf('http://localhost:8053/%s.php', $fixture), false, $context);

        $this->assertStringEqualsFile(__DIR__.sprintf('/Fixtures/%s.expected', $fixture), $result);
    }

    public function provideSession()
    {
        foreach (glob(__DIR__.'/Fixtures/*.php') as $file) {
            yield [pathinfo($file, PATHINFO_FILENAME)];
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MemcachedSessionHandler;

/**
 * @requires extension memcached
 * @group time-sensitive
 */
class MemcachedSessionHandlerTest extends TestCase
{
    const PREFIX = 'prefix_';
    const TTL = 1000;

    /**
     * @var MemcachedSessionHandler
     */
    protected $storage;

    protected $memcached;

    protected function setUp()
    {
        parent::setUp();

        if (version_compare(phpversion('memcached'), '2.2.0', '>=') && version_compare(phpversion('memcached'), '3.0.0b1', '<')) {
            $this->markTestSkipped('Tests can only be run with memcached extension 2.1.0 or lower, or 3.0.0b1 or higher');
        }

        $this->memcached = $this->getMockBuilder('Memcached')->getMock();
        $this->storage = new MemcachedSessionHandler(
            $this->memcached,
            ['prefix' => self::PREFIX, 'expiretime' => self::TTL]
        );
    }

    protected function tearDown()
    {
        $this->memcached = null;
        $this->storage = null;
        parent::tearDown();
    }

    public function testOpenSession()
    {
        $this->assertTrue($this->storage->open('', ''));
    }

    public function testCloseSession()
    {
        $this->memcached
            ->expects($this->once())
            ->method('quit')
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->storage->close());
    }

    public function testReadSession()
    {
        $this->memcached
            ->expects($this->once())
            ->method('get')
            ->with(self::PREFIX.'id')
        ;

        $this->assertEquals('', $this->storage->read('id'));
    }

    public function testWriteSession()
    {
        $this->memcached
            ->expects($this->once())
            ->method('set')
            ->with(self::PREFIX.'id', 'data', $this->equalTo(time() + self::TTL, 2))
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->storage->write('id', 'data'));
    }

    public function testDestroySession()
    {
        $this->memcached
            ->expects($this->once())
            ->method('delete')
            ->with(self::PREFIX.'id')
            ->will($this->returnValue(true))
        ;

        $this->assertTrue($this->storage->destroy('id'));
    }

    public function testGcSession()
    {
        $this->assertTrue($this->storage->gc(123));
    }

    /**
     * @dataProvider getOptionFixtures
     */
    public function testSupportedOptions($options, $supported)
    {
        try {
            new MemcachedSessionHandler($this->memcached, $options);
            $this->assertTrue($supported);
        } catch (\InvalidArgumentException $e) {
            $this->assertFalse($supported);
        }
    }

    public function getOptionFixtures()
    {
        return [
            [['prefix' => 'session'], true],
            [['expiretime' => 100], true],
            [['prefix' => 'session', 'expiretime' => 200], true],
            [['expiretime' => 100, 'foo' => 'bar'], false],
        ];
    }

    public function testGetConnection()
    {
        $method = new \ReflectionMethod($this->storage, 'getMemcached');
        $method->setAccessible(true);

        $this->assertInstanceOf('\Memcached', $method->invoke($this->storage));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpFoundation\Tests\Session\Storage\Handler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\MigratingSessionHandler;

class MigratingSessionHandlerTest extends TestCase
{
    private $dualHandler;
    private $currentHandler;
    private $writeOnlyHandler;

    protected function setUp()
    {
        $this->currentHandler = $this->createMock(\SessionHandlerInterface::class);
        $this->writeOnlyHandler = $this->createMock(\SessionHandlerInterface::class);

        $this->dualHandler = new MigratingSessionHandler($this->currentHandler, $this->writeOnlyHandler);
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(\SessionHandlerInterface::class, $this->dualHandler);
        $this->assertInstanceOf(\SessionUpdateTimestampHandlerInterface::class, $this->dualHandler);
    }

    public function testClose()
    {
        $this->currentHandler->expects($this->once())
            ->method('close')
            ->will($this->returnValue(true));

        $this->writeOnlyHandler->expects($this->once())
            ->method('close')
            ->will($this->returnValue(false));

        $result = $this->dualHandler->close();

        $this->assertTrue($result);
    }

    public function testDestroy()
    {
        $sessionId = 'xyz';

        $this->currentHandler->expects($this->once())
            ->method('destroy')
            ->with($sessionId)
            ->will($this->returnValue(true));

        $this->writeOnlyHandler->expects($this->once())
            ->method('destroy')
            ->with($sessionId)
            ->will($this->returnValue(false));

        $result = $this->dualHandler->destroy($sessionId);

        $this->assertTrue($result);
    }

    public function testGc()
    {
        $maxlifetime = 357;

        $this->currentHandler->expects($this->once())
            ->method('gc')
            ->with($maxlifetime)
            ->will($this->returnValue(true));

        $this->writeOnlyHandler->expects($this->once())
            ->method('gc')
            ->with($maxlifetime)
            ->will($this->returnValue(false));

        $result = $this->dualHandler->gc($maxlifetime);
        $this->assertTrue($result);
    }

    public function testOpen()
    {
        $savePath = '/path/to/save/location';
        $sessionName = 'xyz';

        $this->currentHandler->expects($this->once())
            ->method('open')
            ->with($savePath, $sessionName)
            ->will($this->returnValue(true));

        $this->writeOnlyHandler->expects($this->once())
            ->method('open')
            ->with($savePath, $sessionName)
            ->will($this->returnValue(false));

        $result = $this->dualHandler->open($savePath, $sessionName);

        $this->assertTrue($result);
    }

    public function testRead()
    {
        $sessionId = 'xyz';
        $readValue = 'something';

        $this->currentHandler->expects($this->once())
            ->method('read')
            ->with($sessionId)
            ->will($this->returnValue($readValue));

        $this->writeOnlyHandler->expects($this->never())
            ->method('read')
            ->with($this->any());

        $result = $this->dualHandler->read($sessionId);

        $this->assertSame($readValue, $result);
    }

    public function testWrite()
    {
        $sessionId = 'xyz';
        $data = 'my-serialized-data';

        $this->currentHandler->expects($this->once())
            ->method('write')
            ->with($sessionId, $data)
            ->will($this->returnValue(true));

        $this->writeOnlyHandler->expects($this->once())
            ->method('write')
            ->with($sessionId, $data)
            ->will($this->returnValue(false));

        $result = $this->dualHandler->write($sessionId, $data);

        $this->assertTrue($result);
    }

    public function testValidateId()
    {
        $sessionId = 'xyz';
        $readValue = 'something';

        $this->currentHandler->expects($this->once())
            ->method('read')
            ->with($sessionId)
            ->will($this->returnValue($readValue));

        $this->writeOnlyHandler->expects($this->never())
            ->method('read')
            ->with($this->any());

        $result = $this->dualHandler->validateId($sessionId);

        $this->assertTrue($result);
    }

    public function testUpdateTimestamp()
    {
        $sessionId = 'xyz';
        $data = 'my-serialized-data';

        $this->currentHandler->expects($this->once())
            ->method('write')
            ->with($sessionId, $data)
            ->will($this->returnValue(true));

        $this->writeOnlyHandler->expects($this->once())
            ->method('write')
            ->with($sessionId, $data)
            ->will($this->returnValue(false));

        $result = $this->dualHandler->updateTimestamp($sessionId, $data);

        $this->assertTrue($result);
    }
}
                                                                                                                                                             