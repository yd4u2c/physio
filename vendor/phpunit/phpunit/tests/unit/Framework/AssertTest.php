<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\TestCase;

class ExceptionMessageRegExpTest extends TestCase
{
    public function testRegexMessage(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('/^A polymorphic \w+ message/');

        throw new \Exception('A polymorphic exception message');
    }

    public function testRegexMessageExtreme(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('/^a poly[a-z]+ [a-zA-Z0-9_]+ me(s){2}age$/i');

        throw new \Exception('A polymorphic exception message');
    }

    /**
     * @runInSeparateProcess
     * @requires extension xdebug
     */
    public function testMessageXdebugScreamCompatibility(): void
    {
        \ini_set('xdebug.scream', '1');

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('#Screaming preg_match#');

        throw new \Exception('Screaming preg_match');
    }

    public function testSimultaneousLiteralAndRegExpExceptionMessage(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('/^A variadic \w+ message/');

        throw new \Exception('A variadic exception message');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\TestCase;

class ExceptionMessageTest extends TestCase
{
    public function testLiteralMessage(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A literal exception message');

        throw new \Exception('A literal exception message');
    }

    public function testPartialMessageBegin(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('A partial');

        throw new \Exception('A partial exception message');
    }

    public function testPartialMessageMiddle(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('partial exception');

        throw new \Exception('A partial exception message');
    }

    public function testPartialMessageEnd(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('exception message');

        throw new \Exception('A partial exception message');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class FileExistsTest extends ConstraintTestCase
{
    public function testConstraintFileExists(): void
    {
        $constraint = new FileExists;

        $this->assertFalse($constraint->evaluate('foo', '', true));
        $this->assertEquals('file exists', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate('foo');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that file "foo" exists.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintFileExists2(): void
    {
        $constraint = new FileExists;

        try {
            $constraint->evaluate('foo', 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that file "foo" exists.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class GreaterThanTest extends ConstraintTestCase
{
    public function testConstraintGreaterThan(): void
    {
        $constraint = new GreaterThan(1);

        $this->assertFalse($constraint->evaluate(0, '', true));
        $this->assertTrue($constraint->evaluate(2, '', true));
        $this->assertEquals('is greater than 1', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(0);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 0 is greater than 1.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintGreaterThan2(): void
    {
        $constraint = new GreaterThan(1);

        try {
            $constraint->evaluate(0, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 0 is greater than 1.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class IsEmptyTest extends ConstraintTestCase
{
    public function testConstraintIsEmpty(): void
    {
        $constraint = new IsEmpty;

        $this->assertFalse($constraint->evaluate(['foo'], '', true));
        $this->assertTrue($constraint->evaluate([], '', true));
        $this->assertFalse($constraint->evaluate(new \ArrayObject(['foo']), '', true));
        $this->assertTrue($constraint->evaluate(new \ArrayObject([]), '', true));
        $this->assertEquals('is empty', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(['foo']);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that an array is empty.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsEmpty2(): void
    {
        $constraint = new IsEmpty;

        try {
            $constraint->evaluate(['foo'], 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message\nFailed asserting that an array is empty.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class IsEqualTest extends ConstraintTestCase
{
    public function testConstraintIsEqual(): void
    {
        $constraint = new IsEqual(1);

        $this->assertTrue($constraint->evaluate(1, '', true));
        $this->assertFalse($constraint->evaluate(0, '', true));
        $this->assertEquals('is equal to 1', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(0);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 0 matches expected 1.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider isEqualProvider
     */
    public function testConstraintIsEqual2($expected, $actual, $message): void
    {
        $constraint = new IsEqual($expected);

        try {
            $constraint->evaluate($actual, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                "custom message\n$message",
                $this->trimnl(TestFailure::exceptionToString($e))
            );

            return;
        }

        $this->fail();
    }

    public function isEqualProvider(): array
    {
        $a      = new \stdClass;
        $a->foo = 'bar';
        $b      = new \stdClass;
        $ahash  = \spl_object_hash($a);
        $bhash  = \spl_object_hash($b);

        $c               = new \stdClass;
        $c->foo          = 'bar';
        $c->int          = 1;
        $c->array        = [0, [1], [2], 3];
        $c->related      = new \stdClass;
        $c->related->foo = "a\nb\nc\nd\ne\nf\ng\nh\ni\nj\nk";
        $c->self         = $c;
        $c->c            = $c;
        $d               = new \stdClass;
        $d->foo          = 'bar';
        $d->int          = 2;
        $d->array        = [0, [4], [2], 3];
        $d->related      = new \stdClass;
        $d->related->foo = "a\np\nc\nd\ne\nf\ng\nh\ni\nw\nk";
        $d->self         = $d;
        $d->c            = $c;

        $storage1 = new \SplObjectStorage;
        $storage1->attach($a);
        $storage1->attach($b);
        $storage2 = new \SplObjectStorage;
        $storage2->attach($b);
        $storage1hash = \spl_object_hash($storage1);
        $storage2hash = \spl_object_hash($storage2);

        $dom1                     = new \DOMDocument;
        $dom1->preserveWhiteSpace = false;
        $dom1->loadXML('<root></root>');
        $dom2                     = new \DOMDocument;
        $dom2->preserveWhiteSpace = false;
        $dom2->loadXML('<root><foo/></root>');

        return [
            [1, 0, <<<EOF
Failed asserting that 0 matches expected 1.

EOF
            ],
            [1.1, 0, <<<EOF
Failed asserting that 0 matches expected 1.1.

EOF
            ],
            ['a', 'b', <<<EOF
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
-'a'
+'b'

EOF
            ],
            ["a\nb\nc\nd\ne\nf\ng\nh\ni\nj\nk", "a\np\nc\nd\ne\nf\ng\nh\ni\nw\nk", <<<EOF
Failed asserting that two strings are equal.
--- Expected
+++ Actual
@@ @@
 'a\\n
-b\\n
+p\\n
 c\\n
 d\\n
 e\\n
@@ @@
 g\\n
 h\\n
 i\\n
-j\\n
+w\\n
 k'

EOF
            ],
            [1, [0], <<<EOF
Array (...) does not match expected type "integer".

EOF
            ],
            [[0], 1, <<<EOF
1 does not match expected type "array".

EOF
            ],
            [[0], [1], <<<EOF
Failed asserting that two arrays are equal.
--- Expected
+++ Actual
@@ @@
 Array (
-    0 => 0
+    0 => 1
 )

EOF
            ],
            [[true], ['true'], <<<EOF
Failed asserting that two arrays are equal.
--- Expected
+++ Actual
@@ @@
 Array (
-    0 => true
+    0 => 'true'
 )

EOF
            ],
            [[0, [1], [2], 3], [0, [4], [2], 3], <<<EOF
Failed asserting that two arrays are equal.
--- Expected
+++ Actual
@@ @@
 Array (
     0 => 0
     1 => Array (
-        0 => 1
+        0 => 4
     )
     2 => Array (...)
     3 => 3
 )

EOF
            ],
            [$a, [0], <<<EOF
Array (...) does not match expected type "object".

EOF
            ],
            [[0], $a, <<<EOF
stdClass Object (...) does not match expected type "array".

EOF
            ],
            [$a, $b, <<<EOF
Failed asserting that two objects are equal.
--- Expected
+++ Actual
@@ @@
 stdClass Object (
-    'foo' => 'bar'
 )

EOF
            ],
            [$c, $d, <<<EOF
Failed asserting that two objects are equal.
--- Expected
+++ Actual
@@ @@
 stdClass Object (
     'foo' => 'bar'
-    'int' => 1
+    'int' => 2
     'array' => Array (
         0 => 0
         1 => Array (
-            0 => 1
+            0 => 4
         )
         2 => Array (...)
         3 => 3
@@ @@
     )
     'related' => stdClass Object (
         'foo' => 'a\\n
-        b\\n
+        p\\n
         c\\n
         d\\n
         e\\n
@@ @@
         g\\n
         h\\n
         i\\n
-        j\\n
+        w\\n
         k'
     )
     'self' => stdClass Object (...)
     'c' => stdClass Object (...)
 )

EOF
            ],
            [$dom1, $dom2, <<<EOF
Failed asserting that two DOM documents are equal.
--- Expected
+++ Actual
@@ @@
 <?xml version="1.0"?>
-<root/>
+<root>
+  <foo/>
+</root>

EOF
            ],
            [
                new \DateTime('2013-03-29 04:13:35', new \DateTimeZone('America/New_York')),
                new \DateTime('2013-03-29 04:13:35', new \DateTimeZone('America/Chicago')),
                <<<EOF
Failed asserting that two DateTime objects are equal.
--- Expected
+++ Actual
@@ @@
-2013-03-29T04:13:35.000000-0400
+2013-03-29T04:13:35.000000-0500

EOF
            ],
            [$storage1, $storage2, <<<EOF
Failed asserting that two objects are equal.
--- Expected
+++ Actual
@@ @@
-SplObjectStorage Object &$storage1hash (
-    '$ahash' => Array &0 (
-        'obj' => stdClass Object &$ahash (
-            'foo' => 'bar'
-        )
-        'inf' => null
-    )
-    '$bhash' => Array &1 (
+SplObjectStorage Object &$storage2hash (
+    '$bhash' => Array &0 (
         'obj' => stdClass Object &$bhash ()
         'inf' => null
     )
 )

EOF
            ],
        ];
    }

    /**
     * Removes spaces in front of newlines
     *
     * @param string $string
     *
     * @return string
     */
    private function trimnl($string)
    {
        return \preg_replace('/[ ]*\n/', "\n", $string);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class IsIdenticalTest extends ConstraintTestCase
{
    public function testConstraintIsIdentical(): void
    {
        $a = new \stdClass;
        $b = new \stdClass;

        $constraint = new IsIdentical($a);

        $this->assertFalse($constraint->evaluate($b, '', true));
        $this->assertTrue($constraint->evaluate($a, '', true));
        $this->assertEquals('is identical to an object of class "stdClass"', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate($b);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that two variables reference the same object.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsIdentical2(): void
    {
        $a = new \stdClass;
        $b = new \stdClass;

        $constraint = new IsIdentical($a);

        try {
            $constraint->evaluate($b, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that two variables reference the same object.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsIdentical3(): void
    {
        $constraint = new IsIdentical('a');

        try {
            $constraint->evaluate('b', 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that two strings are identical.
--- Expected
+++ Actual
@@ @@
-'a'
+'b'

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsIdenticalArrayDiff(): void
    {
        $expected = [1, 2, 3, 4, 5, 6];
        $actual   = [1, 2, 33, 4, 5, 6];

        $constraint = new IsIdentical($expected);

        try {
            $constraint->evaluate($actual, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertSame(
                <<<EOF
custom message
Failed asserting that two arrays are identical.
--- Expected
+++ Actual
@@ @@
 Array &0 (
     0 => 1
     1 => 2
-    2 => 3
+    2 => 33
     3 => 4
     4 => 5
     5 => 6
 )

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsIdenticalNestedArrayDiff(): void
    {
        $expected = [
            ['A' => 'B'],
            [
                'C' => [
                    'D',
                    'E',
                ],
            ],
        ];
        $actual = [
            ['A' => 'C'],
            [
                'C' => [
                    'C',
                    'E',
                    'F',
                ],
            ],
        ];
        $constraint = new IsIdentical($expected);

        try {
            $constraint->evaluate($actual, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that two arrays are identical.
--- Expected
+++ Actual
@@ @@
 Array &0 (
     0 => Array &1 (
-        'A' => 'B'
+        'A' => 'C'
     )
     1 => Array &2 (
         'C' => Array &3 (
-            0 => 'D'
+            0 => 'C'
             1 => 'E'
+            2 => 'F'
         )
     )
 )

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php declare(strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

final class IsInstanceOfTest extends ConstraintTestCase
{
    public function testConstraintInstanceOf(): void
    {
        $constraint = new IsInstanceOf(\stdClass::class);

        self::assertTrue($constraint->evaluate(new \stdClass, '', true));
    }

    public function testConstraintFailsOnString(): void
    {
        $constraint = new IsInstanceOf(\stdClass::class);

        try {
            $constraint->evaluate('stdClass');
        } catch (ExpectationFailedException $e) {
            self::assertSame(
                <<<EOT
Failed asserting that 'stdClass' is an instance of class "stdClass".

EOT
                ,
                TestFailure::exceptionToString($e)
            );
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

class IsJsonTest extends ConstraintTestCase
{
    public static function evaluateDataprovider(): array
    {
        return [
            'valid JSON'                                     => [true, '{}'],
            'empty string should be treated as invalid JSON' => [false, ''],
        ];
    }

    /**
     * @dataProvider evaluateDataprovider
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testEvaluate($expected, $jsonOther): void
    {
        $constraint = new IsJson;

        $this->assertEquals($expected, $constraint->evaluate($jsonOther, '', true));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class IsNullTest extends ConstraintTestCase
{
    public function testConstraintIsNull(): void
    {
        $constraint = new IsNull;

        $this->assertFalse($constraint->evaluate(0, '', true));
        $this->assertTrue($constraint->evaluate(null, '', true));
        $this->assertEquals('is null', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(0);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 0 is null.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsNull2(): void
    {
        $constraint = new IsNull;

        try {
            $constraint->evaluate(0, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 0 is null.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class IsReadableTest extends ConstraintTestCase
{
    public function testConstraintIsReadable(): void
    {
        $constraint = new IsReadable;

        $this->assertFalse($constraint->evaluate('foo', '', true));
        $this->assertEquals('is readable', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate('foo');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that "foo" is readable.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class IsTypeTest extends ConstraintTestCase
{
    public function testConstraintIsType(): void
    {
        $constraint = Assert::isType('string');

        $this->assertFalse($constraint->evaluate(0, '', true));
        $this->assertTrue($constraint->evaluate('', '', true));
        $this->assertEquals('is of type "string"', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(new \stdClass);
        } catch (ExpectationFailedException $e) {
            $this->assertStringMatchesFormat(
                <<<EOF
Failed asserting that stdClass Object &%x () is of type "string".

EOF
                ,
                $this->trimnl(TestFailure::exceptionToString($e))
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintIsType2(): void
    {
        $constraint = Assert::isType('string');

        try {
            $constraint->evaluate(new \stdClass, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertStringMatchesFormat(
                <<<EOF
custom message
Failed asserting that stdClass Object &%x () is of type "string".

EOF
                ,
                $this->trimnl(TestFailure::exceptionToString($e))
            );

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider resources
     */
    public function testConstraintIsResourceTypeEvaluatesCorrectlyWithResources($resource): void
    {
        $constraint = Assert::isType('resource');

        $this->assertTrue($constraint->evaluate($resource, '', true));

        @\fclose($resource);
    }

    public function resources()
    {
        $fh = \fopen(__FILE__, 'r');
        \fclose($fh);

        return [
            'open resource'     => [\fopen(__FILE__, 'r')],
            'closed resource'   => [$fh],
        ];
    }

    public function testIterableTypeIsSupported(): void
    {
        $constraint = Assert::isType('iterable');

        $this->assertFalse($constraint->evaluate('', '', true));
        $this->assertTrue($constraint->evaluate([], '', true));
        $this->assertEquals('is of type "iterable"', $constraint->toString());
    }

    /**
     * Removes spaces in front of newlines
     *
     * @param string $string
     *
     * @return string
     */
    private function trimnl($string)
    {
        return \preg_replace('/[ ]*\n/', "\n", $string);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class IsWritableTest extends ConstraintTestCase
{
    public function testConstraintIsWritable(): void
    {
        $constraint = new IsWritable;

        $this->assertFalse($constraint->evaluate('foo', '', true));
        $this->assertEquals('is writable', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate('foo');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that "foo" is writable.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\TestCase;

class JsonMatchesErrorMessageProviderTest extends TestCase
{
    public static function determineJsonErrorDataprovider(): array
    {
        return [
            'JSON_ERROR_NONE'  => [
                null, 'json_error_none', '',
            ],
            'JSON_ERROR_DEPTH' => [
                'Maximum stack depth exceeded', \JSON_ERROR_DEPTH, '',
            ],
            'prefixed JSON_ERROR_DEPTH' => [
                'TUX: Maximum stack depth exceeded', \JSON_ERROR_DEPTH, 'TUX: ',
            ],
            'JSON_ERROR_STATE_MISMatch' => [
                'Underflow or the modes mismatch', \JSON_ERROR_STATE_MISMATCH, '',
            ],
            'JSON_ERROR_CTRL_CHAR' => [
                'Unexpected control character found', \JSON_ERROR_CTRL_CHAR, '',
            ],
            'JSON_ERROR_SYNTAX' => [
                'Syntax error, malformed JSON', \JSON_ERROR_SYNTAX, '',
            ],
            'JSON_ERROR_UTF8`' => [
                'Malformed UTF-8 characters, possibly incorrectly encoded',
                \JSON_ERROR_UTF8,
                '',
            ],
            'Invalid error indicator' => [
                'Unknown error', 55, '',
            ],
        ];
    }

    public static function translateTypeToPrefixDataprovider(): array
    {
        return [
            'expected' => ['Expected value JSON decode error - ', 'expected'],
            'actual'   => ['Actual value JSON decode error - ', 'actual'],
            'default'  => ['', ''],
        ];
    }

    /**
     * @dataProvider translateTypeToPrefixDataprovider
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testTranslateTypeToPrefix($expected, $type): void
    {
        $this->assertEquals(
            $expected,
            JsonMatchesErrorMessageProvider::translateTypeToPrefix($type)
        );
    }

    /**
     * @dataProvider determineJsonErrorDataprovider
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testDetermineJsonError($expected, $error, $prefix): void
    {
        $this->assertEquals(
            $expected,
            JsonMatchesErrorMessageProvider::determineJsonError(
                $error,
                $prefix
            )
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Util\Json;

class JsonMatchesTest extends ConstraintTestCase
{
    public static function evaluateDataprovider(): array
    {
        return [
            'valid JSON'                              => [true, \json_encode(['Mascott'                           => 'Tux']), \json_encode(['Mascott'                           => 'Tux'])],
            'error syntax'                            => [false, '{"Mascott"::}', \json_encode(['Mascott'         => 'Tux'])],
            'error UTF-8'                             => [false, \json_encode('\xB1\x31'), \json_encode(['Mascott' => 'Tux'])],
            'invalid JSON in class instantiation'     => [false, \json_encode(['Mascott'                          => 'Tux']), '{"Mascott"::}'],
            'string type not equals number'           => [false, '{"age": "5"}', '{"age": 5}'],
            'string type not equals boolean'          => [false, '{"age": "true"}', '{"age": true}'],
            'string type not equals null'             => [false, '{"age": "null"}', '{"age": null}'],
            'object fields are unordered'             => [true, '{"first":1, "second":"2"}', '{"second":"2", "first":1}'],
            'child object fields are unordered'       => [true, '{"Mascott": {"name":"Tux", "age":5}}', '{"Mascott": {"age":5, "name":"Tux"}}'],
            'null field different from missing field' => [false, '{"present": true, "missing": null}', '{"present": true}'],
            'array elements are ordered'              => [false, '["first", "second"]', '["second", "first"]'],
            'single boolean valid json'               => [true, 'true', 'true'],
            'single number valid json'                => [true, '5.3', '5.3'],
            'single null valid json'                  => [true, 'null', 'null'],
            'objects are not arrays'                  => [false, '{}', '[]'],
        ];
    }

    public static function evaluateThrowsExpectationFailedExceptionWhenJsonIsValidButDoesNotMatchDataprovider(): array
    {
        return [
            'error UTF-8'                             => [\json_encode('\xB1\x31'), \json_encode(['Mascott' => 'Tux'])],
            'string type not equals number'           => ['{"age": "5"}', '{"age": 5}'],
            'string type not equals boolean'          => ['{"age": "true"}', '{"age": true}'],
            'string type not equals null'             => ['{"age": "null"}', '{"age": null}'],
            'null field different from missing field' => ['{"present": true, "missing": null}', '{"present": true}'],
            'array elements are ordered'              => ['["first", "second"]', '["second", "first"]'],
        ];
    }

    /**
     * @dataProvider evaluateDataprovider
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testEvaluate($expected, $jsonOther, $jsonValue): void
    {
        $constraint = new JsonMatches($jsonValue);

        $this->assertEquals($expected, $constraint->evaluate($jsonOther, '', true));
    }

    /**
     * @dataProvider evaluateThrowsExpectationFailedExceptionWhenJsonIsValidButDoesNotMatchDataprovider
     *
     * @throws ExpectationFailedException
     * @throws \PHPUnit\Framework\AssertionFailedError
     * @throws \PHPUnit\Framework\Exception
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testEvaluateThrowsExpectationFailedExceptionWhenJsonIsValidButDoesNotMatch($jsonOther, $jsonValue): void
    {
        $constraint = new JsonMatches($jsonValue);

        try {
            $constraint->evaluate($jsonOther, '', false);
            $this->fail(\sprintf('Expected %s to be thrown.', ExpectationFailedException::class));
        } catch (ExpectationFailedException $expectedException) {
            $comparisonFailure = $expectedException->getComparisonFailure();
            $this->assertNotNull($comparisonFailure);
            $this->assertSame(Json::prettify($jsonOther), $comparisonFailure->getActualAsString());
            $this->assertSame(Json::prettify($jsonValue), $comparisonFailure->getExpectedAsString());
            $this->assertSame('Failed asserting that two json values are equal.', $comparisonFailure->getMessage());
        }
    }

    public function testToString(): void
    {
        $jsonValue  = \json_encode(['Mascott' => 'Tux']);
        $constraint = new JsonMatches($jsonValue);

        $this->assertEquals('matches JSON string "' . $jsonValue . '"', $constraint->toString());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class LessThanTest extends ConstraintTestCase
{
    public function testConstraintLessThan(): void
    {
        $constraint = new LessThan(1);

        $this->assertTrue($constraint->evaluate(0, '', true));
        $this->assertFalse($constraint->evaluate(1, '', true));
        $this->assertEquals('is less than 1', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(1);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 1 is less than 1.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintLessThan2(): void
    {
        $constraint = new LessThan(1);

        try {
            $constraint->evaluate(1, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 1 is less than 1.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

final class LogicalAndTest extends ConstraintTestCase
{
    public function testSetConstraintsRejectsInvalidConstraint(): void
    {
        $constraints = [
            new \TruthyConstraint,
            new \FalsyConstraint,
            new \stdClass,
        ];

        $constraint = new LogicalAnd;

        $this->expectException(Exception::class);
        $this->expectExceptionMessage(\sprintf(
            'All parameters to %s must be a constraint object.',
            LogicalAnd::class
        ));

        $constraint->setConstraints($constraints);
    }

    public function testCountReturnsCountOfComposedConstraints(): void
    {
        $counts = [
            3,
            5,
            8,
        ];

        $constraints = \array_map(function (int $count) {
            return \CountConstraint::fromCount($count);
        }, $counts);

        $constraint = new LogicalAnd;

        $constraint->setConstraints($constraints);

        $expected = \array_sum($counts);

        $this->assertSame($expected, $constraint->count());
    }

    public function testToStringReturnsImplodedStringRepresentationOfComposedConstraintsGluedWithAnd(): void
    {
        $names = [
            'is healthy',
            'is rich in amino acids',
            'is rich in unsaturated fats',
        ];

        $constraints = \array_map(function (string $name) {
            return \NamedConstraint::fromName($name);
        }, $names);

        $constraint = new LogicalAnd;

        $constraint->setConstraints($constraints);

        $expected = \implode(' and ', $names);

        $this->assertSame($expected, $constraint->toString());
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsFalseIfAnyOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $constraint = new LogicalAnd;

        $constraint->setConstraints($constraints);

        $this->assertFalse($constraint->evaluate('whatever', '', true));
    }

    /**
     * @dataProvider providerSucceedingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsTrueIfAllOfTheComposedConstraintsEvaluateToTrue(array $constraints): void
    {
        $constraint = new LogicalAnd;

        $constraint->setConstraints($constraints);

        $this->assertTrue($constraint->evaluate('whatever', '', true));
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateThrowsExceptionIfAnyOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $other = 'whatever';

        $constraint = new LogicalAnd;

        $constraint->setConstraints($constraints);

        try {
            $constraint->evaluate($other);
        } catch (ExpectationFailedException $exception) {
            $toString = $this->stringify($constraints);

            $expectedDescription = <<<EOF
Failed asserting that '$other' $toString.

EOF;

            $this->assertEquals($expectedDescription, TestFailure::exceptionToString($exception));

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateThrowsExceptionWithCustomMessageIfAnyOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $other             = 'whatever';
        $customDescription = 'Not very happy about the results at this point in time, I have to admit!';

        $constraint = new LogicalAnd;

        $constraint->setConstraints($constraints);

        try {
            $constraint->evaluate(
                $other,
                $customDescription
            );
        } catch (ExpectationFailedException $exception) {
            $toString = $this->stringify($constraints);

            $expectedDescription = <<<EOF
$customDescription
Failed asserting that '$other' $toString.

EOF;

            $this->assertEquals($expectedDescription, TestFailure::exceptionToString($exception));

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider providerSucceedingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsNothingIfAllOfTheComposedConstraintsEvaluateToTrue(array $constraints): void
    {
        $constraint = new LogicalAnd;

        $constraint->setConstraints($constraints);

        $this->assertNull($constraint->evaluate('whatever'));
    }

    public function providerFailingConstraints(): \Generator
    {
        $values = [
            'single' => [
                new \FalsyConstraint,
            ],
            'multiple' => [
                new \TruthyConstraint,
                new \FalsyConstraint,
                new \TruthyConstraint,
            ],
        ];

        foreach ($values as $key => $constraints) {
            yield $key => [
                $constraints,
            ];
        }
    }

    public function providerSucceedingConstraints(): \Generator
    {
        $values = [
            'single' => [
                new \TruthyConstraint,
            ],
            'multiple' => [
                new \TruthyConstraint,
                new \TruthyConstraint,
                new \TruthyConstraint,
            ],
        ];

        foreach ($values as $key => $constraints) {
            yield $key => [
                $constraints,
            ];
        }
    }

    private function stringify(array $constraints): string
    {
        return \implode(
            ' and ',
            \array_map(function (Constraint $constraint) {
                return $constraint->toString();
            }, $constraints)
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

final class LogicalOrTest extends ConstraintTestCase
{
    public function testSetConstraintsDecoratesNonConstraintWithIsEqual(): void
    {
        $constraints = [
            new \stdClass,
        ];

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $this->assertTrue($constraint->evaluate(new \stdClass, '', true));
    }

    public function testCountReturnsCountOfComposedConstraints(): void
    {
        $counts = [
            3,
            5,
            8,
        ];

        $constraints = \array_map(function (int $count) {
            return \CountConstraint::fromCount($count);
        }, $counts);

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $expected = \array_sum($counts);

        $this->assertSame($expected, $constraint->count());
    }

    public function testToStringReturnsImplodedStringRepresentationOfComposedConstraintsGluedWithOr(): void
    {
        $names = [
            'is healthy',
            'is rich in amino acids',
            'is rich in unsaturated fats',
        ];

        $constraints = \array_map(function (string $name) {
            return \NamedConstraint::fromName($name);
        }, $names);

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $expected = \implode(' or ', $names);

        $this->assertSame($expected, $constraint->toString());
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsFalseIfAllOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $this->assertFalse($constraint->evaluate('whatever', '', true));
    }

    /**
     * @dataProvider providerSucceedingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsTrueIfAnyOfTheComposedConstraintsEvaluateToTrue(array $constraints): void
    {
        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $this->assertTrue($constraint->evaluate('whatever', '', true));
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateThrowsExceptionIfAllOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $other = 'whatever';

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        try {
            $constraint->evaluate($other);
        } catch (ExpectationFailedException $exception) {
            $toString = $this->stringify($constraints);

            $expectedDescription = <<<EOF
Failed asserting that '$other' $toString.

EOF;

            $this->assertEquals($expectedDescription, TestFailure::exceptionToString($exception));

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider providerFailingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateThrowsExceptionWithCustomMessageIfAllOfTheComposedConstraintsEvaluateToFalse(array $constraints): void
    {
        $other             = 'whatever';
        $customDescription = 'Not very happy about the results at this point in time, I have to admit!';

        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        try {
            $constraint->evaluate(
                $other,
                $customDescription
            );
        } catch (ExpectationFailedException $exception) {
            $toString = $this->stringify($constraints);

            $expectedDescription = <<<EOF
$customDescription
Failed asserting that '$other' $toString.

EOF;

            $this->assertEquals($expectedDescription, TestFailure::exceptionToString($exception));

            return;
        }

        $this->fail();
    }

    /**
     * @dataProvider providerSucceedingConstraints
     *
     * @param Constraint[] $constraints
     */
    public function testEvaluateReturnsNothingIfAnyOfTheComposedConstraintsEvaluateToTrue(array $constraints): void
    {
        $constraint = new LogicalOr;

        $constraint->setConstraints($constraints);

        $this->assertNull($constraint->evaluate('whatever'));
    }

    public function providerFailingConstraints(): \Generator
    {
        $values = [
            'single' => [
                new \FalsyConstraint,
                new \FalsyConstraint,
                new \FalsyConstraint,
            ],
            'multiple' => [
                new \FalsyConstraint,
                new \FalsyConstraint,
                new \FalsyConstraint,
            ],
        ];

        foreach ($values as $key => $constraints) {
            yield $key => [
                $constraints,
            ];
        }
    }

    public function providerSucceedingConstraints(): \Generator
    {
        $values = [
            'single' => [
                new \TruthyConstraint,
            ],
            'multiple' => [
                new \FalsyConstraint,
                new \TruthyConstraint,
                new \FalsyConstraint,
            ],
        ];

        foreach ($values as $key => $constraints) {
            yield $key => [
                $constraints,
            ];
        }
    }

    private function stringify(array $constraints): string
    {
        return \implode(
            ' or ',
            \array_map(function (Constraint $constraint) {
                return $constraint->toString();
            }, $constraints)
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Framework\Constraint;

use PHPUnit\Framework\Constraint\Constraint;
use PHPUnit\Framework\Constraint\LogicalXor;
use PHPUnit\Framework\TestCase;

final class LogicalXorTest extends TestCase
{
    public function testFromConstraintsReturnsConstraint(): void
    {
        $other = 'Foo';
        $count = 5;

        $constraints = \array_map(function () use ($other) {
            static $count = 0;

            $constraint = $this->getMockBuilder(Constraint::class)->getMock();

            $constraint
                ->expects($this->once())
                ->method('evaluate')
                ->with($this->identical