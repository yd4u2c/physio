<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace test\Mockery\Fixtures;

class MethodWithVoidReturnType
{
    public function foo(): void
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Mockery\Fixtures;

class SemiReservedWordsAsMethods 
{
    function callable() {}
    function class() {}
    function trait() {}
    function extends() {}
    function implements() {}
    function static() {}
    function abstract() {}
    function final() {}
    function public() {}
    function protected() {}
    function private() {}
    function const() {}
    function enddeclare() {}
    function endfor() {}
    function endforeach() {}
    function endif() {}
    function endwhile() {}
    function and() {}
    function global() {}
    function goto() {}
    function instanceof() {}
    function insteadof() {}
    function interface() {}
    function namespace() {}
    function new() {}
    function or() {}
    function xor() {}
    function try() {}
    function use() {}
    function var() {}
    function exit() {}
    function list() {}
    function clone() {}
    function include() {}
    function include_once() {}
    function throw() {}
    function array() {}
    function print() {}
    function echo() {}
    function require() {}
    function require_once() {}
    function return() {}
    function else() {}
    function elseif() {}
    function default() {}
    function break() {}
    function continue() {}
    function switch() {}
    function yield() {}
    function function() {}
    function if() {}
    function endswitch() {}
    function finally() {}
    function for() {}
    function foreach() {}
    function declare() {}
    function case() {}
    function do() {}
    function while() {}
    function as() {}
    function catch() {}
    function die() {}
    function self() {}
    function parent() {}
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery;

use Mockery\Generator\DefinedTargetClass;
use PHPUnit\Framework\TestCase;

class DefinedTargetClassTest extends TestCase
{
    /** @test */
    public function it_knows_if_one_of_its_ancestors_is_internal()
    {
        $target = new DefinedTargetClass(new \ReflectionClass("ArrayObject"));
        $this->assertTrue($target->hasInternalAncestor());

        $target = new DefinedTargetClass(new \ReflectionClass("Mockery\MockeryTest_ClassThatExtendsArrayObject"));
        $this->assertTrue($target->hasInternalAncestor());

        $target = new DefinedTargetClass(new \ReflectionClass("Mockery\DefinedTargetClassTest"));
        $this->assertFalse($target->hasInternalAncestor());
    }
}

class MockeryTest_ClassThatExtendsArrayObject extends \ArrayObject
{
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace tests\Mockery\Generator;

use Mockery as m;
use Mockery\Generator\MockConfigurationBuilder;
use PHPUnit\Framework\TestCase;

class MockConfigurationBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function reservedWordsAreBlackListedByDefault()
    {
        $builder = new MockConfigurationBuilder;
        $this->assertContains('__halt_compiler', $builder->getMockConfiguration()->getBlackListedMethods());

        // need a builtin for this
        $this->markTestSkipped("Need a builtin class with a method that is a reserved word");
    }

    /**
     * @test
     */
    public function magicMethodsAreBlackListedByDefault()
    {
        $builder = new MockConfigurationBuilder;
        $builder->addTarget(ClassWithMagicCall::class);
        $methods = $builder->getMockConfiguration()->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /** @test */
    public function xdebugs_debug_info_is_black_listed_by_default()
    {
        $builder = new MockConfigurationBuilder;
        $builder->addTarget(ClassWithDebugInfo::class);
        $methods = $builder->getMockConfiguration()->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }
}

class ClassWithMagicCall
{
    public function foo()
    {
    }

    public function __call($method, $args)
    {
    }
}

class ClassWithDebugInfo
{
    public function foo()
    {
    }

    public function __debugInfo()
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator;

use PHPUnit\Framework\TestCase;

class MockConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function blackListedMethodsShouldNotBeInListToBeMocked()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array("foo"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("bar", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function blackListsAreCaseInsensitive()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array("FOO"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("bar", $methods[0]->getName());
    }


    /**
     * @test
     */
    public function onlyWhiteListedMethodsShouldBeInListToBeMocked()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array(), array('foo'));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function whitelistOverRulesBlackList()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array("foo"), array("foo"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function whiteListsAreCaseInsensitive()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array(), array("FOO"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function finalMethodsAreExcluded()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\ClassWithFinalMethod"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("bar", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function shouldIncludeMethodsFromAllTargets()
    {
        $config = new MockConfiguration(array("Mockery\\Generator\\TestInterface", "Mockery\\Generator\\TestInterface2"));
        $methods = $config->getMethodsToMock();
        $this->assertCount(2, $methods);
    }

    /**
     * @test
     */
    public function shouldThrowIfTargetClassIsFinal()
    {
        $this->expectException(\Mockery\Exception::class);
        $config = new MockConfiguration(array("Mockery\\Generator\\TestFinal"));
        $config->getTargetClass();
    }

    /**
     * @test
     */
    public function shouldTargetIteratorAggregateIfTryingToMockTraversable()
    {
        $config = new MockConfiguration(array("\\Traversable"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(1, $interfaces);
        $first = array_shift($interfaces);
        $this->assertEquals("IteratorAggregate", $first->getName());
    }

    /**
     * @test
     */
    public function shouldTargetIteratorAggregateIfTraversableInTargetsTree()
    {
        $config = new MockConfiguration(array("Mockery\Generator\TestTraversableInterface"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(2, $interfaces);
        $this->assertEquals("IteratorAggregate", $interfaces[0]->getName());
        $this->assertEquals("Mockery\Generator\TestTraversableInterface", $interfaces[1]->getName());
    }

    /**
     * @test
     */
    public function shouldBringIteratorToHeadOfTargetListIfTraversablePresent()
    {
        $config = new MockConfiguration(array("Mockery\Generator\TestTraversableInterface2"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(2, $interfaces);
        $this->assertEquals("Iterator", $interfaces[0]->getName());
        $this->assertEquals("Mockery\Generator\TestTraversableInterface2", $interfaces[1]->getName());
    }

    /**
     * @test
     */
    public function shouldBringIteratorAggregateToHeadOfTargetListIfTraversablePresent()
    {
        $config = new MockConfiguration(array("Mockery\Generator\TestTraversableInterface3"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(2, $interfaces);
        $this->assertEquals("IteratorAggregate", $interfaces[0]->getName());
        $this->assertEquals("Mockery\Generator\TestTraversableInterface3", $interfaces[1]->getName());
    }
}

interface TestTraversableInterface extends \Traversable
{
}
interface TestTraversableInterface2 extends \Traversable, \Iterator
{
}
interface TestTraversableInterface3 extends \Traversable, \IteratorAggregate
{
}

final class TestFinal
{
}

interface TestInterface
{
    public function foo();
}

interface TestInterface2
{
    public function bar();
}

class TestSubject
{
    public function foo()
    {
    }

    public function bar()
    {
    }
}

class ClassWithFinalMethod
{
    final public function foo()
    {
    }

    public function bar()
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Test\Generator\StringManipulation\Pass;

use Mockery as m;
use Mockery\Generator\StringManipulation\Pass\CallTypeHintPass;
use PHPUnit\Framework\TestCase;

class CallTypeHintPassTest extends TestCase
{
    const CODE = ' public function __call($method, array $args) {}
                   public static function __callStatic($method, array $args) {}
    ';

    /**
     * @test
     */
    public function shouldRemoveCallTypeHintIfRequired()
    {
        $pass = new CallTypeHintPass;
        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "requiresCallTypeHintRemoval" => true,
        ))->makePartial();
        $code = $pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, '__call($method, $args)') !== false);
    }

    /**
     * @test
     */
    public function shouldRemoveCallStaticTypeHintIfRequired()
    {
        $pass = new CallTypeHintPass;
        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "requiresCallStaticTypeHintRemoval" => true,
        ))->makePartial();
        $code = $pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, '__callStatic($method, $args)') !== false);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Generator\MockConfiguration;

class ClassNamePassTest extends MockeryTestCase
{
    const CODE = "namespace Mockery; class Mock {}";

    public function mockeryTestSetUp()
    {
        $this->pass = new ClassNamePass();
    }

    /**
     * @test
     */
    public function shouldRemoveNamespaceDefinition()
    {
        $config = new MockConfiguration(array(), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'namespace Mockery;') === false);
    }

    /**
     * @test
     */
    public function shouldReplaceNamespaceIfClassNameIsNamespaced()
    {
        $config = new MockConfiguration(array(), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'namespace Mockery;') === false);
        $this->assertTrue(\mb_strpos($code, 'namespace Dave;') !== false);
    }

    /**
     * @test
     */
    public function shouldReplaceClassNameWithSpecifiedName()
    {
        $config = new MockConfiguration(array(), array(), array(), "Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'class Dave') !== false);
    }

    /**
     * @test
     */
    public function shouldRemoveLeadingBackslashesFromNamespace()
    {
        $config = new MockConfiguration(array(), array(), array(), "\Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'namespace Dave;') !== false);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Generator\MockConfiguration;

class ClassPassTest extends MockeryTestCase
{
    const CODE = "class Mock implements MockInterface {}";

    public function mockeryTestSetUp()
    {
        $this->pass = new ClassPass();
    }

    /**
     * @test
     */
    public function shouldDeclareUnknownClass()
    {
        $config = new MockConfiguration(array("Testing\TestClass"), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'class Mock extends \Testing\TestClass implements MockInterface') !== false);
    }

    /**
     * @test
     */
    public function shouldNotExtendHHVMClass()
    {
        $config = new MockConfiguration(array("\HH\\this"), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        if (\defined('HHVM_VERSION')) {
            $this->assertNotContains('extends \HH\this', $code);
        } else {
            $this->assertSame('class Mock extends \HH\this implements MockInterface {}', $code);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Test\Generator\StringManipulation\Pass;

use Mockery as m;
use Mockery\Generator\MockConfiguration;
use Mockery\Generator\StringManipulation\Pass\ConstantsPass;
use PHPUnit\Framework\TestCase;

class ConstantsPassTest extends TestCase
{
    const CODE = 'class Foo {}';

    /**
     * @test
     */
    public function shouldAddConstants()
    {
        $pass = new ConstantsPass;
        $config = new MockConfiguration(
            array(),
            array(),
            array(),
            "ClassWithConstants",
            false,
            array(),
            false,
            ['ClassWithConstants' => ['FOO' => 'test']]
        );
        $code = $pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, "const FOO = 'test'") !== false);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Test\Generator\StringManipulation\Pass;

use Mockery as m;
use Mockery\Generator\MockConfigurationBuilder;
use Mockery\Generator\StringManipulation\Pass\InstanceMockPass;
use PHPUnit\Framework\TestCase;

class InstanceMockPassTest extends TestCase
{
    /**
     * @test
     */
    public function shouldAppendConstructorAndPropertyForInstanceMock()
    {
        $builder = new MockConfigurationBuilder;
        $builder->setInstanceMock(true);
        $config = $builder->getMockConfiguration();
        $pass = new InstanceMockPass;
        $code = $pass->apply('class Dave { }', $config);
        $this->assertTrue(\mb_strpos($code, 'public function __construct') !== false);
        $this->assertTrue(\mb_strpos($code, 'protected $_mockery_ignoreVerification') !== false);
        $this->assertTrue(\mb_strpos($code, 'this->_mockery_constructorCalled(func_get_args());') !== false);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              INDX( 	 )jy             (   @  �                             �     � r     �     �5�(pk� D�����:m��<��5�(pk�       �               C a l l T y p e H i n t P a s s T e s t . p h p       �     � l     �     � �(pk� D����-�o��<�� �(pk�       Z	               C l a s s N a m e P a s s T e s t . p h p     �     x d     �     "H�(pk� D����-�o��<�"H�(pk�       Z               C l a s s P a s s T e s t . p h p     �     � l     �     #o�(pk� D������q��<�#o�(pk�      �               C o n s t a n t s P a s s T e s t . p h p     �     � r     �     �4�(pk� D����bt��<��4�(pk�       R               I n s t a n c e M o c k P a s s T e s t . p h p       �     � l     �     ���(pk� D����>�v��<����(pk�       �               I n t e r f a c e P a s s T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Test\Generator\StringManipulation\Pass;

use Mockery as m;
use Mockery\Generator\MockConfiguration;
use Mockery\Generator\StringManipulation\Pass\InterfacePass;
use PHPUnit\Framework\TestCase;

class InterfacePassTest extends TestCase
{
    const CODE = "class Mock implements MockInterface";

    /**
     * @test
     */
    public function shouldNotAlterCodeIfNoTargetInterfaces()
    {
        $pass = new InterfacePass;

        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "getTargetInterfaces" => array(),
        ));

        $code = $pass->apply(static::CODE, $config);
        $this->assertEquals(static::CODE, $code);
    }

    /**
     * @test
     */
    public function shouldAddAnyInterfaceNamesToImplementsDefinition()
    {
        $pass = new InterfacePass;

        $config = m::mock("Mockery\Generator\MockConfiguration", array(
            "getTargetInterfaces" => array(
                m::mock(array("getName" => "Dave\Dave")),
                m::mock(array("getName" => "Paddy\Paddy")),
            ),
        ));

        $code = $pass->apply(static::CODE, $config);

        $this->assertTrue(\mb_strpos($code, "implements MockInterface, \Dave\Dave, \Paddy\Paddy") !== false);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Loader;

use Mockery as m;
use Mockery\Loader\EvalLoader;

require_once __DIR__.'/LoaderTestCase.php';

class EvalLoaderTest extends LoaderTestCase
{
    public function getLoader()
    {
        return new EvalLoader();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Loader;

use Mockery\Generator\MockConfiguration;
use Mockery\Generator\MockDefinition;
use PHPUnit\Framework\TestCase;

abstract class LoaderTestCase extends TestCase
{
    /**
     * @test
     */
    public function loadLoadsTheCode()
    {
        $className = 'Mock_' . uniqid();
        $config = new MockConfiguration(array(), array(), array(), $className);
        $code = "<?php class $className { } ";

        $definition = new MockDefinition($config, $code);

        $this->getLoader()->load($definition);

        $this->assertTrue(class_exists($className));
    }

    abstract public function getLoader();
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Loader;

use Mockery as m;
use Mockery\Loader\RequireLoader;

require_once __DIR__.'/LoaderTestCase.php';

class RequireLoaderTest extends LoaderTestCase
{
    public function getLoader()
    {
        return new RequireLoader(sys_get_temp_dir());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Mockery\Matcher\PHPUnitConstraint;

class PHPUnitConstraintTest extends MockeryTestCase
{
    /** @var  PHPUnitConstraint */
    protected $matcher;
    /** @var  PHPUnitConstraint */
    protected $rethrowingMatcher;
    /** @var  MockInterface */
    protected $constraint;

    public function mockeryTestSetUp()
    {
        /*
         * Revise by PHPUnit version
         */
        if (class_exists('\PHPUnit\Framework\AssertionFailedError')) {
            $this->assertionFailedError = '\PHPUnit\Framework\AssertionFailedError';
            $this->frameworkConstraint = '\PHPUnit\Framework\Constraint';
        } else {
            $this->assertionFailedError = '\PHPUnit_Framework_AssertionFailedError';
            $this->frameworkConstraint = '\PHPUnit_Framework_Constraint';
        }

        $this->constraint = \Mockery::mock($this->frameworkConstraint);
        $this->matcher = new PHPUnitConstraint($this->constraint);
        $this->rethrowingMatcher = new PHPUnitConstraint($this->constraint, true);
    }

    public function testMatches()
    {
        $value1 = 'value1';
        $value2 = 'value1';
        $value3 = 'value1';
        $this->constraint
            ->shouldReceive('evaluate')
            ->once()
            ->with($value1)
            ->getMock()
            ->shouldReceive('evaluate')
            ->once()
            ->with($value2)
            ->andThrow($this->assertionFailedError)
            ->getMock()
            ->shouldReceive('evaluate')
            ->once()
            ->with($value3)
            ->getMock()
        ;
        $this->assertTrue($this->matcher->match($value1));
        $this->assertFalse($this->matcher->match($value2));
        $this->assertTrue($this->rethrowingMatcher->match($value3));
    }

    public function testMatchesWhereNotMatchAndRethrowing()
    {
        $this->expectException($this->assertionFailedError);
        $value = 'value';
        $this->constraint
            ->shouldReceive('evaluate')
            ->once()
            ->with($value)
            ->andThrow($this->assertionFailedError)
        ;
        $this->rethrowingMatcher->match($value);
    }

    public function test__toString()
    {
        $this->assertEquals('<Constraint>', $this->matcher);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2017 Dave Marshall
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace tests\Mockery\Matcher;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Matcher\Subset;

class SubsetTest extends MockeryTestCase
{
    /** @test */
    public function it_matches_a_shallow_subset()
    {
        $matcher = Subset::strict(['dave' => 123]);

        $actual = [
            'foo' => 'bar',
            'dave' => 123,
            'bar' => 'baz',
        ];

        $this->assertTrue($matcher->match($actual));
    }

    /** @test */
    public function it_recursively_matches()
    {
        $matcher = Subset::strict(['foo' => ['bar' => ['baz' => 123]]]);

        $actual = [
            'foo' => [
                'bar' => [
                    'baz' => 123,
                ]
            ],
            'dave' => 123,
            'bar' => 'baz',
        ];

        $this->assertTrue($matcher->match($actual));
    }

    /** @test */
    public function it_is_strict_by_default()
    {
        $matcher = new Subset(['dave' => 123]);

        $actual = [
            'foo' => 'bar',
            'dave' => 123.0,
            'bar' => 'baz',
        ];

        $this->assertFalse($matcher->match($actual));
    }

    /** @test */
    public function it_can_run_a_loose_comparison()
    {
        $matcher = Subset::loose(['dave' => 123]);

        $actual = [
            'foo' => 'bar',
            'dave' => 123.0,
            'bar' => 'baz',
        ];

        $this->assertTrue($matcher->match($actual));
    }

    /** @test */
    public function it_returns_false_if_actual_is_not_an_array()
    {
        $matcher = new Subset(['dave' => 123]);

        $actual = null;

        $this->assertFalse($matcher->match($actual));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        