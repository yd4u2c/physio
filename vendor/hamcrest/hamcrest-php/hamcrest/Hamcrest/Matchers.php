tMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', 0.0);
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', array());
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals('identifier', $ex->getMessage());
        }
        self::assertEquals(6, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithActualValueAndMatcherArgsThatMatchPasses()
    {
        \Hamcrest\MatcherAssert::assertThat(true, is(true));
        self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithActualValueAndMatcherArgsThatDontMatchFails()
    {
        $expected = 'expected';
        $actual = 'actual';

        $expectedMessage =
            'Expected: "expected"' . PHP_EOL .
            '     but: was "actual"';

        try {
            \Hamcrest\MatcherAssert::assertThat($actual, equalTo($expected));
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals($expectedMessage, $ex->getMessage());
            self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }

    public function testAssertThatWithIdentifierAndActualValueAndMatcherArgsThatMatchPasses()
    {
        \Hamcrest\MatcherAssert::assertThat('identifier', true, is(true));
        self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
    }

    public function testAssertThatWithIdentifierAndActualValueAndMatcherArgsThatDontMatchFails()
    {
        $expected = 'expected';
        $actual = 'actual';

        $expectedMessage =
            'identifier' . PHP_EOL .
            'Expected: "expected"' . PHP_EOL .
            '     but: was "actual"';

        try {
            \Hamcrest\MatcherAssert::assertThat('identifier', $actual, equalTo($expected));
            self::fail('expected assertion failure');
        } catch (\Hamcrest\AssertionError $ex) {
            self::assertEquals($expectedMessage, $ex->getMessage());
            self::assertEquals(1, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }

    public function testAssertThatWithNoArgsThrowsErrorAndDoesntIncrementCount()
    {
        try {
            \Hamcrest\MatcherAssert::assertThat();
            self::fail('expected invalid argument exception');
        } catch (\InvalidArgumentException $ex) {
            self::assertEquals(0, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }

    public function testAssertThatWithFourArgsThrowsErrorAndDoesntIncrementCount()
    {
        try {
            \Hamcrest\MatcherAssert::assertThat(1, 2, 3, 4);
            self::fail('expected invalid argument exception');
        } catch (\InvalidArgumentException $ex) {
            self::assertEquals(0, \Hamcrest\MatcherAssert::getCount(), 'assertion count');
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php
namespace Hamcrest;

class SampleSelfDescriber implements \Hamcrest\SelfDescribing
{
    private $_text;

    public function __construct($text)
    {
        $this->_text = $text;
    }

    public function describeTo(\Hamcrest\Description $description)
    {
        $description->appendText($this->_text);
    }
}

class StringDescriptionTest extends \PhpUnit_Framework_TestCase
{

    private $_description;

    public function setUp()
    {
        $this->_description = new \Hamcrest\StringDescription();
    }

    public function testAppendTextAppendsTextInformation()
    {
        $this->_description->appendText('foo')->appendText('bar');
        $this->assertEquals('foobar', (string) $this->_description);
    }

    public function testAppendValueCanAppendTextTypes()
    {
        $this->_description->appendValue('foo');
        $this->assertEquals('"foo"', (string) $this->_description);
    }

    public function testSpecialCharactersAreEscapedForStringTypes()
    {
        $this->_description->appendValue("foo\\bar\"zip\r\n");
        $this->assertEquals('"foo\\bar\\"zip\r\n"', (string) $this->_description);
    }

    public function testIntegerValuesCanBeAppended()
    {
        $this->_description->appendValue(42);
        $this->assertEquals('<42>', (string) $this->_description);
    }

    public function testFloatValuesCanBeAppended()
    {
        $this->_description->appendValue(42.78);
        $this->assertEquals('<42.78F>', (string) $this->_description);
    }

    public function testNullValuesCanBeAppended()
    {
        $this->_description->appendValue(null);
        $this->assertEquals('null', (string) $this->_description);
    }

    public function testArraysCanBeAppended()
    {
        $this->_description->appendValue(array('foo', 42.78));
        $this->assertEquals('["foo", <42.78F>]', (string) $this->_description);
    }

    public function testObjectsCanBeAppended()
    {
        $this->_description->appendValue(new \stdClass());
        $this->assertEquals('<stdClass>', (string) $this->_description);
    }

    public function testBooleanValuesCanBeAppended()
    {
        $this->_description->appendValue(false);
        $this->assertEquals('<false>', (string) $this->_description);
    }

    public function testListsOfvaluesCanBeAppended()
    {
        $this->_description->appendValue(array('foo', 42.78));
        $this->assertEquals('["foo", <42.78F>]', (string) $this->_description);
    }

    public function testIterableOfvaluesCanBeAppended()
    {
        $items = new \ArrayObject(array('foo', 42.78));
        $this->_description->appendValue($items);
        $this->assertEquals('["foo", <42.78F>]', (string) $this->_description);
    }

    public function testIteratorOfvaluesCanBeAppended()
    {
        $items = new \ArrayObject(array('foo', 42.78));
        $this->_description->appendValue($items->getIterator());
        $this->assertEquals('["foo", <42.78F>]', (string) $this->_description);
    }

    public function testListsOfvaluesCanBeAppendedManually()
    {
        $this->_description->appendValueList('@start@', '@sep@ ', '@end@', array('foo', 42.78));
        $this->assertEquals('@start@"foo"@sep@ <42.78F>@end@', (string) $this->_description);
    }

    public function testIterableOfvaluesCanBeAppendedManually()
    {
        $items = new \ArrayObject(array('foo', 42.78));
        $this->_description->appendValueList('@start@', '@sep@ ', '@end@', $items);
        $this->assertEquals('@start@"foo"@sep@ <42.78F>@end@', (string) $this->_description);
    }

    public function testIteratorOfvaluesCanBeAppendedManually()
    {
        $items = new \ArrayObject(array('foo', 42.78));
        $this->_description->appendValueList('@start@', '@sep@ ', '@end@', $items->getIterator());
        $this->assertEquals('@start@"foo"@sep@ <42.78F>@end@', (string) $this->_description);
    }

    public function testSelfDescribingObjectsCanBeAppended()
    {
        $this->_description
            ->appendDescriptionOf(new \Hamcrest\SampleSelfDescriber('foo'))
            ->appendDescriptionOf(new \Hamcrest\SampleSelfDescriber('bar'))
            ;
        $this->assertEquals('foobar', (string) $this->_description);
    }

    public function testSelfDescribingObjectsCanBeAppendedAsLists()
    {
        $this->_description->appendList('@start@', '@sep@ ', '@end@', array(
            new \Hamcrest\SampleSelfDescriber('foo'),
            new \Hamcrest\SampleSelfDescriber('bar')
        ));
        $this->assertEquals('@start@foo@sep@ bar@end@', (string) $this->_description);
    }

    public function testSelfDescribingObjectsCanBeAppendedAsIteratedLists()
    {
        $items = new \ArrayObject(array(
            new \Hamcrest\SampleSelfDescriber('foo'),
            new \Hamcrest\SampleSelfDescriber('bar')
        ));
        $this->_description->appendList('@start@', '@sep@ ', '@end@', $items);
        $this->assertEquals('@start@foo@sep@ bar@end@', (string) $this->_description);
    }

    public function testSelfDescribingObjectsCanBeAppendedAsIterators()
    {
        $items = new \ArrayObject(array(
            new \Hamcrest\SampleSelfDescriber('foo'),
            new \Hamcrest\SampleSelfDescriber('bar')
        ));
        $this->_description->appendList('@start@', '@sep@ ', '@end@', $items->getIterator());
        $this->assertEquals('@start@foo@sep@ bar@end@', (string) $this->_description);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           INDX( 	 �`o             (   �  �       c                          � p          /�i�ok� V��S�=�(��<�/�i�ok�       q               A b s t r a c t M a t c h e r T e s t . p h p      ` L          dX��ok��B��ok��B��ok�dX��ok�                        A r r a y a t      x h          )nn�ok� V��S���*��<�)nn�ok�                     B a s e M a t c h e r T e s t . p h p "     h V          ����ok�}t��ok�}t��ok�����ok�                       
 C o l l e c t i o n  %     ` J          �չ�ok���z�ok���z�ok��չ�ok�                        C o r e u r e      � n          [�w�ok� V��S���*��<�[�w�ok�       z               F e a t u r e M a t c h e r T e s t . p h p        � l          #��ok� V��S��b-��<�#��ok�        �               M a t c h e r A s s e r t T e s t . p h p     9     ` N          !W}�ok�r��ok�r��ok�!W}�ok�                        N u m b e r D      � t          �l��ok� V��S�I�/��<��l��ok�       E               S t r i n g D e s c r i p t i o n T e s t . p h p     <     ` J          F~��ok�R���ok�R���ok�F~��ok�                        T e x t T e s F     ` J          ���ok��x �ok��x �ok����ok�                        T y p e T e s      p Z          ���ok� V��S�I�/��<����ok�       8
               U t i l T e s t . p h p       Q     X H          �x �ok����ok����ok��x �ok�                        X m l                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php
namespace Hamcrest;

class UtilTest extends \PhpUnit_Framework_TestCase
{

    public function testWrapValueWithIsEqualLeavesMatchersUntouched()
    {
        $matcher = new \Hamcrest\Text\MatchesPattern('/fo+/');
        $newMatcher = \Hamcrest\Util::wrapValueWithIsEqual($matcher);
        $this->assertSame($matcher, $newMatcher);
    }

    public function testWrapValueWithIsEqualWrapsPrimitive()
    {
        $matcher = \Hamcrest\Util::wrapValueWithIsEqual('foo');
        $this->assertInstanceOf('Hamcrest\Core\IsEqual', $matcher);
        $this->assertTrue($matcher->matches('foo'));
    }

    public function testCheckAllAreMatchersAcceptsMatchers()
    {
        \Hamcrest\Util::checkAllAreMatchers(array(
            new \Hamcrest\Text\MatchesPattern('/fo+/'),
            new \Hamcrest\Core\IsEqual('foo'),
        ));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCheckAllAreMatchersFailsForPrimitive()
    {
        \Hamcrest\Util::checkAllAreMatchers(array(
            new \Hamcrest\Text\MatchesPattern('/fo+/'),
            'foo',
        ));
    }

    private function callAndAssertCreateMatcherArray($items)
    {
        $matchers = \Hamcrest\Util::createMatcherArray($items);
        $this->assertInternalType('array', $matchers);
        $this->assertSameSize($items, $matchers);
        foreach ($matchers as $matcher) {
            $this->assertInstanceOf('\Hamcrest\Matcher', $matcher);
        }

        return $matchers;
    }

    public function testCreateMatcherArrayLeavesMatchersUntouched()
    {
        $matcher = new \Hamcrest\Text\MatchesPattern('/fo+/');
        $items = array($matcher);
        $matchers = $this->callAndAssertCreateMatcherArray($items);
        $this->assertSame($matcher, $matchers[0]);
    }

    public function testCreateMatcherArrayWrapsPrimitiveWithIsEqualMatcher()
    {
        $matchers = $this->callAndAssertCreateMatcherArray(array('foo'));
        $this->assertInstanceOf('Hamcrest\Core\IsEqual', $matchers[0]);
        $this->assertTrue($matchers[0]->matches('foo'));
    }

    public function testCreateMatcherArrayDoesntModifyOriginalArray()
    {
        $items = array('foo');
        $this->callAndAssertCreateMatcherArray($items);
        $this->assertSame('foo', $items[0]);
    }

    public function testCreateMatcherArrayUnwrapsSingleArrayElement()
    {
        $matchers = $this->callAndAssertCreateMatcherArray(array(array('foo')));
        $this->assertInstanceOf('Hamcrest\Core\IsEqual', $matchers[0]);
        $this->assertTrue(