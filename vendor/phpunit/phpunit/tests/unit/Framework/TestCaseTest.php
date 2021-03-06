         );

            return;
        }

        $this->fail();
    }

    public function testConstraintTraversableStdClassForFailSplObjectStorageWithCustomMessage(): void
    {
        $object     = new \stdClass;
        $constraint = new TraversableContains($object);

        try {
            $constraint->evaluate(new \SplObjectStorage, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertStringMatchesFormat(
                <<<EOF
custom message
Failed asserting that a traversable contains stdClass Object &%x ().

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\MockObject\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers \PHPUnit\Framework\MockObject\Generator
 *
 * @uses \PHPUnit\Framework\MockObject\InvocationMocker
 * @uses \PHPUnit\Framework\MockObject\Builder\InvocationMocker
 * @uses \PHPUnit\Framework\MockObject\Invocation\ObjectInvocation
 * @uses \PHPUnit\Framework\MockObject\Invocation\StaticInvocation
 * @uses \PHPUnit\Framework\MockObject\Matcher
 * @uses \PHPUnit\Framework\MockObject\Matcher\InvokedRecorder
 * @uses \PHPUnit\Framework\MockObject\Matcher\MethodName
 * @uses \PHPUnit\Framework\MockObject\Stub\ReturnStub
 * @uses \PHPUnit\Framework\MockObject\Matcher\InvokedCount
 */
class GeneratorTest extends TestCase
{
    /**
     * @var Generator
     */
    private $generator;

    protected function setUp(): void
    {
        $this->generator = new Generator;
    }

    public function testGetMockFailsWhenInvalidFunctionNameIsPassedInAsAFunctionToMock(): void
    {
        $this->expectException(\PHPUnit\Framework\MockObject\RuntimeException::class);

        $this->generator->getMock(stdClass::class, [0]);
    }

    public function testGetMockCanCreateNonExistingFunctions(): void
    {
        $mock = $this->generator->getMock(stdClass::class, ['testFunction']);

        $this->assertTrue(\method_exists($mock, 'testFunction'));
    }

    public function testGetMockGeneratorFails(): void
    {
        $this->expectException(\PHPUnit\Framework\MockObject\RuntimeException::class);
        $this->expectExceptionMessage('duplicates: "foo, bar, foo" (duplicate: "foo")');

        $this->generator->getMock(stdClass::class, ['foo', 'bar', 'foo']);
    }

    public function testGetMockBlacklistedMethodNamesPhp7(): void
    {
        $mock = $this->generator->getMock(InterfaceWithSemiReservedMethodName::class);

        $this->assertTrue(\method_exists($mock, 'unset'));
        $this->assertInstanceOf(InterfaceWithSemiReservedMethodName::class, $mock);
    }

    public function testGetMockForAbstractClassDoesNotFailWhenFakingInterfaces(): void
    {
        $mock = $this->generator->getMockForAbstractClass(Countable::class);

        $this->assertTrue(\method_exists($mock, 'count'));
    }

    public function testGetMockForAbstractClassStubbingAbstractClass(): void
    {
        $mock = $this->generator->getMockForAbstractClass(AbstractMockTestClass::class);

        $this->assertTrue(\method_exists($mock, 'doSomething'));
    }

    public function testGetMockForAbstractClassWithNonExistentMethods(): void
    {
        $mock = $this->generator->getMockForAbstractClass(
            AbstractMockTestClass::class,
            [],
            '',
            true,
            true,
            true,
            ['nonexistentMethod']
        );

        $this->assertTrue(\method_exists($mock, 'nonexistentMethod'));
        $this->assertTrue(\method_exists($mock, 'doSomething'));
    }

    public function testGetMockForAbstractClassShouldCreateStubsOnlyForAbstractMethodWhenNoMethodsWereInformed(): void
    {
        $mock = $this->generator->getMockForAbstractClass(AbstractMockTestClass::class);

        $mock->expects($this->any())
             ->method('doSomething')
             ->willReturn('testing');

        $this->assertEquals('testing', $mock->doSomething());
        $this->assertEquals(1, $mock->returnAnything());
    }

    /**
     * @dataProvider getMockForAbstractClassExpectsInvalidArgumentExceptionDataprovider
     */
    public function testGetMockForAbstractClassExpectingInvalidArgumentException($className, $mockClassName): void
    {
        $this->expectException(PHPUnit\Framework\Exception::class);

        $this->generator->getMockForAbstractClass($className, [], $mockClassName);
    }

    public function testGetMockForAbstractClassAbstractClassDoesNotExist(): void
    {
        $this->expectException(\PHPUnit\Framework\MockObject\RuntimeException::class);

        $this->generator->getMockForAbstractClass('Tux');
    }

    public function getMockForAbstractClassExpectsInvalidArgumentExceptionDataprovider(): array
    {
        return [
            'className not a string'     => [[], ''],
            'mockClassName not a string' => [Countable::class, new stdClass],
        ];
    }

    public function testGetMockForTraitWithNonExistentMethodsAndNonAbstractMethods(): void
    {
        $mock = $this->generator->getMockForTrait(
            AbstractTrait::class,
            [],
            '',
            true,
            true,
            true,
            ['nonexistentMethod']
        );

        $this->assertTrue(\method_exists($mock, 'nonexistentMethod'));
        $this->assertTrue(\method_exists($mock, 'doSomething'));
        $this->assertTrue($mock->mockableMethod());
        $this->assertTrue($mock->anotherMockableMethod());
    }

    public function testGetMockForTraitStubbingAbstractMethod(): void
    {
        $mock = $this->generator->getMockForTrait(AbstractTrait::class);

        $this->assertTrue(\method_exists($mock, 'doSomething'));
    }

    public function testGetMockForSingletonWithReflectionSuccess(): void
    {
        $mock = $this->generator->getMock(SingletonClass::class, ['doSomething'], [], '', false);

        $this->assertInstanceOf('SingletonClass', $mock);
    }

    public function testExceptionIsRaisedForMutuallyExclusiveOptions(): void
    {
        $this->expectException(\PHPUnit\Framework\MockObject\RuntimeException::class);

        $this->generator->getMock(stdClass::class, [], [], '', false, true, true, true, true);
    }

    public function testCanImplementInterfacesThatHaveMethodsWithReturnTypes(): void
    {
        $stub = $this->generator->getMock([AnInterfaceWithReturnType::class, AnInterface::class]);

        $this->assertInstanceOf(AnInterfaceWithReturnType::class, $stub);
        $this->assertInstanceOf(AnInterface::class, $stub);
        $this->assertInstanceOf(MockObject::class, $stub);
    }

    public function testCanConfigureMethodsForDoubleOfNonExistentClass(): void
    {
        $className = 'X' . \md5(\microtime());

        $mock = $this->generator->getMock($className, ['someMethod']);

        $this->assertInstanceOf($className, $mock);
    }

    public function testCanInvokeMethodsOfNonExistentClass(): void
    {
        $className = 'X' . \md5(\microtime());

        $mock = $this->generator->getMock($className, ['someMethod']);

        $mock->expects($this->once())->method('someMethod');

        $this->assertNull($mock->someMethod());
    }

    public function testMockingOfThrowable(): void
    {
        $stub = $this->generator->getMock(ExceptionWithThrowable::class);

        $this->assertInstanceOf(ExceptionWithThrowable::class, $stub);
        $this->assertInstanceOf(Exception::class, $stub);
        $this->assertInstanceOf(MockObject::class, $stub);
    }

    public function testVariadicArgumentsArePassedToOriginalMethod()
    {
        /** @var ClassWithVariadicArgumentMethod|MockObject $mock */
        $mock = $this->generator->getMock(
            ClassWithVariadicArgumentMethod::class,
            [],
            [],
            '',
            true,
            false,
            true,
            false,
            true
        );

        $arguments = [1, 'foo', false];
        $this->assertSame($arguments, $mock->foo(...$arguments));
    }

    public function testVariadicArgumentsArePassedToMockedMethod()
    {
        /** @var ClassWithVariadicArgumentMethod|MockObject $mock */
        $mock = $this->createMock(ClassWithVariadicArgumentMethod::class);

        $arguments = [1, 'foo', false];
        $mock->expects($this->once())
            ->method('foo')
            ->with(...$arguments);

        $mock->foo(...$arguments);
    }
}
                                                                                                                                                  <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;

class MockBuilderTest extends TestCase
{
    public function testMockBuilderRequiresClassName(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)->getMock();

        $this->assertInstanceOf(Mockable::class, $mock);
    }

    public function testByDefaultMocksAllMethods(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)->getMock();

        $this->assertNull($mock->mockableMethod());
        $this->assertNull($mock->anotherMockableMethod());
    }

    public function testMethodsToMockCanBeSpecified(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
                     ->setMethods(['mockableMethod'])
                     ->getMock();

        $this->assertNull($mock->mockableMethod());
        $this->assertTrue($mock->anotherMockableMethod());
    }

    public function testMethodExceptionsToMockCanBeSpecified(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
            ->setMethodsExcept(['mockableMethod'])
            ->getMock();

        $this->assertTrue($mock->mockableMethod());
        $this->assertNull($mock->anotherMockableMethod());
    }

    public function testEmptyMethodExceptionsToMockCanBeSpecified(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
            ->setMethodsExcept()
            ->getMock();

        $this->assertNull($mock->mockableMethod());
        $this->assertNull($mock->anotherMockableMethod());
    }

    public function testByDefaultDoesNotPassArgumentsToTheConstructor(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)->getMock();

        $this->assertEquals([null, null], $mock->constructorArgs);
    }

    public function testMockClassNameCanBeSpecified(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
                     ->setMockClassName('ACustomClassName')
                     ->getMock();

        $this->assertInstanceOf(ACustomClassName::class, $mock);
    }

    public function testConstructorArgumentsCanBeSpecified(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
                     ->setConstructorArgs([23, 42])
                     ->getMock();

        $this->assertEquals([23, 42], $mock->constructorArgs);
    }

    public function testOriginalConstructorCanBeDisabled(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
                     ->disableOriginalConstructor()
                     ->getMock();

        $this->assertNull($mock->constructorArgs);
    }

    public function testByDefaultOriginalCloneIsPreserved(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
                     ->getMock();

        $cloned = clone $mock;

        $this->assertTrue($cloned->cloned);
    }

    public function testOriginalCloneCanBeDisabled(): void
    {
        $mock = $this->getMockBuilder(Mockable::class)
                     ->disableOriginalClone()
                     ->getMock();

        $mock->cloned = false;
        $cloned       = clone $mock;

        $this->assertFalse($cloned->cloned);
    }

    public function testProvidesAFluentInterface(): void
    {
        $spec = $this->getMockBuilder(Mockable::class)
                     ->setMethods(['mockableMethod'])
                     ->setConstructorArgs([])
                     ->setMockClassName('DummyClassName')
                     ->disableOriginalConstructor()
                     ->disableOriginalClone()
                     ->disableAutoload();

        $this->assertInstanceOf(MockBuilder::class, $spec);
    }
}
                                                                                                                                                                                                                    <?php
declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\MockObject;

use PHPUnit\Framework\TestCase;

class MockMethodTest extends TestCase
{
    public function testGetNameReturnsMethodName()
    {
        $method = new MockMethod(
            'ClassName',
            'methodName',
            false,
            '',
            '',
            '',
            '',
            '',
            false,
            false,
            null,
            false
        );
        $this->assertEquals('methodName', $method->getName());
    }

    public function testFailWhenReturnTypeIsParentButThereIsNoParentClass()
    {
        $method = new MockMethod(
            \stdClass::class,
            'methodName',
            false,
            '',
            '',
            '',
            'parent',
            '',
            false,
            false,
            null,
            false
        );
        $this->expectException(\RuntimeException::class);
        $method->generateCode();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class MockObjectTest extends TestCase
{
    public function testMockedMethodIsNeverCalled(): void
    {
        $mock = $this->getMockBuilder(AnInterface::class)
                     ->getMock();

        $mock->expects($this->never())
             ->method('doSomething');
    }

    public function testMockedMethodIsNeverCalledWithParameter(): void
    {
        $mock = $this->getMockBuilder(SomeClass::class)
                     ->getMock();

        $mock->expects($this->never())
             ->method('doSomething')
             ->with('someArg');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMockedMethodIsNotCalledWhenExpectsAnyWithParameter(): void
    {
        $mock = $this->getMockBuilder(SomeClass::class)
                     ->getMock();

        $mock->expects($this->any())
             ->method('doSomethingElse')
             ->with('someArg');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testMockedMethodIsNotCalledWhenMethodSpecifiedDirectlyWithParameter(): void
    {
        $mock = $this->getMockBuilder(SomeClass::class)
                     ->getMock();

        $mock->method('doSomethingElse')
             ->with('someArg');
    }

    public function testMockedMethodIsCalledAtLeastOnce(): void
    {
        $mock = $this->getMockBuilder(AnInterface::class)
                     ->getMock();

        $mock->expects($this->atLeastOnce())
             ->method('doSomething');

        $mock->doSomething();
    }

    public function testMockedMethodIsCalledAtLeastOnce2(): void
    {
        $mock = $this->getMockBuilder(AnInterface::class)
                     ->getMock();

        $mock->expects($this->atLeastOnce())
             ->method('doSomething');

        $mock->doSomething();
        $mock->doSomething();
    }

    public function testMockedMethodIsCalledAtLeastTwice(): void
    {
        $mock = $this->getMockBuilder(AnInterface::class)
                     ->getMock();

        $mock->expects($this->atLeast(2))
             ->method('doSomething');

        $mock->doSomething();
        $mock->doSomething();
    }

    public function testMockedMethodIsCalledAtLeastTwice2(): void
    {
        $mock = $this->getMockBuilder(AnInterface::class)
                     ->getMock();

        $mock->expects($this->atLeast(2))
             ->method('doSomething');

        $mock->doSomething();
        $mock->doSomething();
        $mock->doSomething();
    }

    public function testMockedMethodIsCalledAtMostTwice(): void
    {
        $mock = $this->getMockBuilder(AnInterface::class)
                     ->getMock();

        $mock->expects($this->atMost(2))
             ->method('doSomething');

        $mock->doSomething();
        $mock->doSomething();
    }

    public function testMockedMethodIsCalledAtMosttTwice2(): void
    {
        $mock = $this->getMockBuilder(AnInterface::class)
                     ->getMock();

        $mock->expects($this->atMost(2))
             ->method('doSomething');

        $mock->doSomething();
    }

    public function testMockedMethodIsCalledOnce(): void
    {
        $mock 