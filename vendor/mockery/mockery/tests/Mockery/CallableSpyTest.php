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

use PHPUnit\Framework\TestCase;

class WithFormatterExpectationTest extends TestCase
{
    /**
     * @dataProvider formatObjectsDataProvider
     */
    public function testFormatObjects($args, $expected)
    {
        $this->assertEquals(
            $expected,
            Mockery::formatObjects($args)
        );
    }

    /**
     * Note that without the patch checked in with this test, rather than throwing
     * an exception, the program will go into an infinite recursive loop
     */
    public function testFormatObjectsWithMockCalledInGetterDoesNotLeadToRecursion()
    {
        $mock = Mockery::mock('stdClass');
        $mock->shouldReceive('doBar')->with('foo');
        $obj = new ClassWithGetter($mock);
        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $obj->getFoo();
    }

    public function formatObjectsDataProvider()
    {
        return array(
            array(
                array(null),
                ''
            ),
            array(
                array('a string', 98768, array('a', 'nother', 'array')),
                ''
            ),
        );
    }

    /** @test */
    public function format_objects_should_not_call_getters_with_params()
    {
        $obj = new ClassWithGetterWithParam();
        $string = Mockery::formatObjects(array($obj));

        $this->assertTrue(\mb_strpos($string, 'Missing argument 1 for') === false);
    }

    public function testFormatObjectsExcludesStaticProperties()
    {
        $obj = new ClassWithPublicStaticProperty();
        $string = Mockery::formatObjects(array($obj));

        $this->assertTrue(\mb_strpos($string, 'excludedProperty') === false);
    }

    public function testFormatObjectsExcludesStaticGetters()
    {
        $obj = new ClassWithPublicStaticGetter();
        $string = Mockery::formatObjects(array($obj));

        $this->assertTrue(\mb_strpos($string, 'getExcluded') === false);
    }
}

class ClassWithGetter
{
    private $dep;

    public function __construct($dep)
    {
        $this->dep = $dep;
    }

    public function getFoo()
    {
        return $this->dep->doBar('bar', $this);
    }
}

class ClassWithGetterWithParam
{
    public function getBar($bar)
    {
    }
}

class ClassWithPublicStaticProperty
{
    public static $excludedProperty;
}

class ClassWithPublicStaticGetter
{
    public static function getExcluded()
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               INDX( 	 "yy            (   �  �       p �s                 i     � |     Z     ��'pk� D�������<���'pk�       �               M o c k i n g C l a s s C o n s t a n t s T e s t . p h p     j     � v     Z     _��'pk� D�����e��<�_��'pk�       �               M o c k i n g H H V M M e t h o d s T e s t . p h p   k     � �     Z     |�'pk� D�����e��<�|�'pk�       �              + M o c k i n g M e t h o d s W i t h I t e r a b l e T y p e H i n t s T e s t . p h  l     � �     Z     _��'pk� D����9���<�_��'pk�       T              , M o c k i n g M e t h o d s W i t h N u l l a b l e P a r a m e t e r s T e s t . p h p       m     � ~     Z     ,�'pk� D�����*��<�,�'pk�        '               M o c k i n g N u l l a b l e M e t h o d s T e s t . p h p   n     � �     Z     �y�'pk� D��������<��y�'pk�       �               M o c k