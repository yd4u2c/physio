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

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestFailure;

class ObjectHasAttributeTest extends ConstraintTestCase
{
    public function testConstraintObjectHasAttribute(): void
    {
        $constraint = new ObjectHasAttribute('privateAttribute');

        $this->assertTrue($constraint->evaluate(new \ClassWithNonPublicAttributes, '', true));
        $this->assertFalse($constraint->evaluate(new \stdClass, '', true));
        $this->assertEquals('has attribute "privateAttribute"', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate(new \stdClass);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that object of class "stdClass" has attribute "privateAttribute".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintObjectHasAttribute2(): void
    {
        $constraint = new ObjectHasAttribute('privateAttribute');

        try {
            $constraint->evaluate(new \stdClass, 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that object of class "stdClass" has attribute "privateAttribute".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          <?php
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

class RegularExpressionTest extends ConstraintTestCase
{
    public function testConstraintRegularExpression(): void
    {
        $constraint = new RegularExpression('/foo/');

        $this->assertFalse($constraint->evaluate('barbazbar', '', true));
        $this->assertTrue($constraint->evaluate('barfoobar', '', true));
        $this->assertEquals('matches PCRE pattern "/foo/"', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate('barbazbar');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 'barbazbar' matches PCRE pattern "/foo/".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintRegularExpression2(): void
    {
        $constraint = new RegularExpression('/foo/');

        try {
            $constraint->evaluate('barbazbar', 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 'barbazbar' matches PCRE pattern "/foo/".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
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

class SameSizeTest extends ConstraintTestCase
{
    public function testConstraintSameSizeWithAnArray(): void
    {
        $constraint = new SameSize([1, 2, 3, 4, 5]);

        $this->assertTrue($constraint->evaluate([6, 7, 8, 9, 10], '', true));
        $this->assertFalse($constraint->evaluate([1, 2, 3, 4], '', true));
    }

    public function testConstraintSameSizeWithAnIteratorWhichDoesNotImplementCountable(): void
    {
        $constraint = new SameSize(new \TestIterator([1, 2, 3, 4, 5]));

        $this->assertTrue($constraint->evaluate(new \TestIterator([6, 7, 8, 9, 10]), '', true));
        $this->assertFalse($constraint->evaluate(new \TestIterator([1, 2, 3, 4]), '', true));
    }

    public function testConstraintSameSizeWithAnObjectImplementingCountable(): void
    {
        $constraint = new SameSize(new \ArrayObject([1, 2, 3, 4, 5]));

        $this->assertTrue($constraint->evaluate(new \ArrayObject([6, 7, 8, 9, 10]), '', true));
        $this->assertFalse($constraint->evaluate(new \ArrayObject([1, 2, 3, 4]), '', true));
    }

    public function testConstraintSameSizeFailing(): void
    {
        $constraint = new SameSize([1, 2, 3, 4, 5]);

        try {
            $constraint->evaluate([1, 2]);
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that actual size 2 matches expected size 5.

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
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

class StringContainsTest extends ConstraintTestCase
{
    public function testConstraintStringContains(): void
    {
        $constraint = new StringContains('foo');

        $this->assertFalse($constraint->evaluate('barbazbar', '', true));
        $this->assertTrue($constraint->evaluate('barfoobar', '', true));
        $this->assertEquals('contains "foo"', $constraint->toString());
        $this->assertCount(1, $constraint);

        try {
            $constraint->evaluate('barbazbar');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 'barbazbar' contains "foo".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintStringContainsWhenIgnoreCase(): void
    {
        $constraint = new StringContains('oryginał', true);

        $this->assertFalse($constraint->evaluate('oryginal', '', true));
        $this->assertTrue($constraint->evaluate('ORYGINAŁ', '', true));
        $this->assertTrue($constraint->evaluate('oryginał', '', true));
        $this->assertEquals('contains "oryginał"', $constraint->toString());
        $this->assertCount(1, $constraint);

        $this->expectException(ExpectationFailedException::class);

        $constraint->evaluate('oryginal');
    }

    public function testConstraintStringContainsForUtf8StringWhenNotIgnoreCase(): void
    {
        $constraint = new StringContains('oryginał', false);

        $this->assertFalse($constraint->evaluate('oryginal', '', true));
        $this->assertFalse($constraint->evaluate('ORYGINAŁ', '', true));
        $this->assertTrue($constraint->evaluate('oryginał', '', true));
        $this->assertEquals('contains "oryginał"', $constraint->toString());
        $this->assertCount(1, $constraint);

        $this->expectException(ExpectationFailedException::class);

        $constraint->evaluate('oryginal');
    }

    public function testConstraintStringContains2(): void
    {
        $constraint = new StringContains('foo');

        try {
            $constraint->evaluate('barbazbar', 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 'barbazbar' contains "foo".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 ��            (   �	  �       . s                   �#     p ^     �#     `��pk� O�
��b��<�`��pk�       �               I s J s o n T e s t . p h p   �#     p ^     �#     }O�pk� O�
��h��<�}O�pk�                      I s N u l l T e s t . p h p   �#     x f     �#     X�pk� O�
��M���<�X�pk�                      I s R e a d a b l e T e s t . p h p   �#     p ^     �#     9��pk� O�
���-��<�9��pk�       )               I s T y p e T e s t  p h p   �#     x f     �#     ��	�pk� O�
���-��<���	�pk�                      I s W r i t a b l e T e s t . p h p   �#     � �     �#     ٰ�pk� O�
��܏��<�ٰ�pk�       �
              ' J s o n M a t c h e s E r r o r M e s s a g e P r o v i d e r T e s t . p h p �#     x h     �#     f9�pk� O�
��:�!��<�f9�pk�                       J s o n M a t c h e s T e s t . p h p �#     x b     �#      %$�pk� O�
���S$��<� %$�pk�       &               L e s s T h a n T e  t . p h p       �#     x f     �#     �0�pk� O�
���S$��<��0�pk�        n               L o g i c a l A n d T e s t . p h p   �#     x d     �#     k�9�pk� O�
��%�&��<�k�9�pk�        �               L o g i c a l O r T e s t . p h p     �#     x f     �#     �#C�pk� O�
��P)��<��#C�pk�       �               L o g i c a l X o r T e s t . p h p   �#     � v     �#     �L�pk� O�
��P)��<��L�pk�       &               O b j e c t H a s A t t r i b u t e T e s t . p h p  �#     � t     �#     &�S�pk� O�
���z+��<�&�S�pk�       �               R e g u l a r E x p r e s s i o n T e s t . p h p     �#     x b     �#     ��X�pk� O�
���-��<���X�pk�       u               S a m e S i z e T e s t . p h p       �#     � n     �#     �_�pk� O�
��f?0��<��_�pk�       H               S t r i n g C o n t a i n s T e s t . p h p   �#     � n     �#     ��k�pk� O�
��f?0��<���k�pk�       �
               S t r i n g E n d s W i t h T e s t . p h p  �#     � �     �#     ��r�pk� O�
��١2��<���r�pk� 0      �.              & S t r i n g M a t c h e s F o r m a t D e s c r i p t i o n T e s t . p h p   �#     � r     �#     ��y�pk� O�
��B5��<���y�pk�       �
               S t r i n g S t a r t s W i t h T e s t . p h p       �#     � x     �#     ��~�pk� O�
���g7��<���~�pk�        �               T r a v e r s a b l e C o n t a i n s T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
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

class StringEndsWithTest extends ConstraintTestCase
{
    public function testConstraintStringEndsWithCorrectValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertTrue($constraint->evaluate('foosuffix', '', true));
    }

    public function testConstraintStringEndsWithNotCorrectValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertFalse($constraint->evaluate('suffixerror', '', true));
    }

    public function testConstraintStringEndsWithCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('0E1');

        $this->assertTrue($constraint->evaluate('zzz0E1', '', true));
    }

    public function testConstraintStringEndsWithNotCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringEndsWith('0E1');

        $this->assertFalse($constraint->evaluate('zzz0E2', '', true));
    }

    public function testConstraintStringEndsWithToStringMethod(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertEquals('ends with "suffix"', $constraint->toString());
    }

    public function testConstraintStringEndsWithCountMethod(): void
    {
        $constraint = new StringEndsWith('suffix');

        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringEndsWithNotCorrectValueAndExpectation(): void
    {
        $constraint = new StringEndsWith('suffix');

        try {
            $constraint->evaluate('error');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 'error' ends with "suffix".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintStringEndsWithNotCorrectValueExceptionAndCustomMessage(): void
    {
        $constraint = new StringEndsWith('suffix');

        try {
            $constraint->evaluate('error', 'custom message');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
custom message
Failed asserting that 'error' ends with "suffix".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
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

class StringMatchesFormatDescriptionTest extends ConstraintTestCase
{
    public function testConstraintStringMatchesDirectorySeparator(): void
    {
        $constraint = new StringMatchesFormatDescription('*%e*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));

        $this->assertTrue($constraint->evaluate('*' . \DIRECTORY_SEPARATOR . '*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*\\' . \DIRECTORY_SEPARATOR . '\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesString(): void
    {
        $constraint = new StringMatchesFormatDescription('*%s*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate("*\n*", '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[^\r\n]+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesOptionalString(): void
    {
        $constraint = new StringMatchesFormatDescription('*%S*');

        $this->assertFalse($constraint->evaluate('*', '', true));
        $this->assertFalse($constraint->evaluate("*\n*", '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));
        $this->assertTrue($constraint->evaluate('**', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[^\r\n]*\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesAnything(): void
    {
        $constraint = new StringMatchesFormatDescription('*%a*');

        $this->assertFalse($constraint->evaluate('**', '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));
        $this->assertTrue($constraint->evaluate("*\n*", '', true));

        $this->assertEquals('matches PCRE pattern "/^\*.+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesOptionalAnything(): void
    {
        $constraint = new StringMatchesFormatDescription('*%A*');

        $this->assertFalse($constraint->evaluate('*', '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*foo 123 bar*', '', true));
        $this->assertTrue($constraint->evaluate("*\n*", '', true));
        $this->assertTrue($constraint->evaluate('**', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*.*\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesWhitespace(): void
    {
        $constraint = new StringMatchesFormatDescription('*%w*');

        $this->assertFalse($constraint->evaluate('*', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));

        $this->assertTrue($constraint->evaluate('* *', '', true));
        $this->assertTrue($constraint->evaluate("*\t\n*", '', true));
        $this->assertTrue($constraint->evaluate('**', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*\s*\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesInteger(): void
    {
        $constraint = new StringMatchesFormatDescription('*%i*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));
        $this->assertFalse($constraint->evaluate('*1.0*', '', true));

        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));
        $this->assertTrue($constraint->evaluate('*-1*', '', true));
        $this->assertTrue($constraint->evaluate('*+2*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[+-]?\d+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesUnsignedInt(): void
    {
        $constraint = new StringMatchesFormatDescription('*%d*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));
        $this->assertFalse($constraint->evaluate('*1.0*', '', true));
        $this->assertFalse($constraint->evaluate('*-1*', '', true));
        $this->assertFalse($constraint->evaluate('*+2*', '', true));

        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*\d+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesHexadecimal(): void
    {
        $constraint = new StringMatchesFormatDescription('*%x*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('***', '', true));
        $this->assertFalse($constraint->evaluate('*g*', '', true));
        $this->assertFalse($constraint->evaluate('*1.0*', '', true));
        $this->assertFalse($constraint->evaluate('*-1*', '', true));
        $this->assertFalse($constraint->evaluate('*+2*', '', true));

        $this->assertTrue($constraint->evaluate('*0f0f0f*', '', true));
        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));
        $this->assertTrue($constraint->evaluate('*a*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[0-9a-fA-F]+\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesFloat(): void
    {
        $constraint = new StringMatchesFormatDescription('*%f*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('***', '', true));
        $this->assertFalse($constraint->evaluate('*a*', '', true));

        $this->assertTrue($constraint->evaluate('*1.0*', '', true));
        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*12*', '', true));
        $this->assertTrue($constraint->evaluate('*.1*', '', true));
        $this->assertTrue($constraint->evaluate('*1.*', '', true));
        $this->assertTrue($constraint->evaluate('*2e3*', '', true));
        $this->assertTrue($constraint->evaluate('*-2.34e-56*', '', true));
        $this->assertTrue($constraint->evaluate('*+2.34e+56*', '', true));

        $this->assertEquals('matches PCRE pattern "/^\*[+-]?\.?\d+\.?\d*(?:[Ee][+-]?\d+)?\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesCharacter(): void
    {
        $constraint = new StringMatchesFormatDescription('*%c*');

        $this->assertFalse($constraint->evaluate('**', '', true));
        $this->assertFalse($constraint->evaluate('*ab*', '', true));

        $this->assertTrue($constraint->evaluate('***', '', true));
        $this->assertTrue($constraint->evaluate('*a*', '', true));
        $this->assertTrue($constraint->evaluate('*g*', '', true));
        $this->assertTrue($constraint->evaluate('*0*', '', true));
        $this->assertTrue($constraint->evaluate('*2*', '', true));
        $this->assertTrue($constraint->evaluate('* *', '', true));
        $this->assertTrue($constraint->evaluate("*\n*", '', true));

        $this->assertEquals('matches PCRE pattern "/^\*.\*$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesEscapedPercent(): void
    {
        $constraint = new StringMatchesFormatDescription('%%,%%e,%%s,%%S,%%a,%%A,%%w,%%i,%%d,%%x,%%f,%%c,%%Z,%%%%,%%');

        $this->assertFalse($constraint->evaluate('%%,%' . \DIRECTORY_SEPARATOR . ',%*,%*,%*,%*,% ,%0,%0,%0f0f0f,%1.0,%*,%%Z,%%%%,%%', '', true));
        $this->assertTrue($constraint->evaluate('%,%e,%s,%S,%a,%A,%w,%i,%d,%x,%f,%c,%Z,%%,%', '', true));
        $this->assertEquals('matches PCRE pattern "/^%,%e,%s,%S,%a,%A,%w,%i,%d,%x,%f,%c,%Z,%%,%$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesEscapedPercentThenPlaceholder(): void
    {
        $constraint = new StringMatchesFormatDescription('%%%e,%%%s,%%%S,%%%a,%%%A,%%%w,%%%i,%%%d,%%%x,%%%f,%%%c');

        $this->assertFalse($constraint->evaluate('%%e,%%s,%%S,%%a,%%A,%%w,%%i,%%d,%%x,%%f,%%c', '', true));
        $this->assertTrue($constraint->evaluate('%' . \DIRECTORY_SEPARATOR . ',%*,%*,%*,%*,% ,%0,%0,%0f0f0f,%1.0,%*', '', true));
        $this->assertEquals('matches PCRE pattern "/^%\\' . \DIRECTORY_SEPARATOR . ',%[^\r\n]+,%[^\r\n]*,%.+,%.*,%\s*,%[+-]?\d+,%\d+,%[0-9a-fA-F]+,%[+-]?\.?\d+\.?\d*(?:[Ee][+-]?\d+)?,%.$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesSlash(): void
    {
        $constraint = new StringMatchesFormatDescription('/');

        $this->assertFalse($constraint->evaluate('\\/', '', true));
        $this->assertTrue($constraint->evaluate('/', '', true));
        $this->assertEquals('matches PCRE pattern "/^\\/$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesBackslash(): void
    {
        $constraint = new StringMatchesFormatDescription('\\');

        $this->assertFalse($constraint->evaluate('\\\\', '', true));
        $this->assertTrue($constraint->evaluate('\\', '', true));
        $this->assertEquals('matches PCRE pattern "/^\\\\$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesBackslashSlash(): void
    {
        $constraint = new StringMatchesFormatDescription('\\/');

        $this->assertFalse($constraint->evaluate('/', '', true));
        $this->assertTrue($constraint->evaluate('\\/', '', true));
        $this->assertEquals('matches PCRE pattern "/^\\\\\\/$/s"', $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringMatchesNewline(): void
    {
        $constraint = new StringMatchesFormatDescription("\r\n");

        $this->assertFalse($constraint->evaluate("*\r\n", '', true));
        $this->assertTrue($constraint->evaluate("\r\n", '', true));
        $this->assertEquals("matches PCRE pattern \"/^\n$/s\"", $constraint->toString());
        $this->assertCount(1, $constraint);
    }

    public function testFailureMessageWithNewlines(): void
    {
        $constraint = new StringMatchesFormatDescription("%c\nfoo\n%c");

        try {
            $constraint->evaluate("*\nbar\n*");
            $this->fail('Expected ExpectationFailedException, but it was not thrown.');
        } catch (ExpectationFailedException $e) {
            $expected = <<<EOD
Failed asserting that string matches format description.
--- Expected
+++ Actual
@@ @@
 *
-foo
+bar
 *

EOD;
            $this->assertEquals($expected, $e->getMessage());
        }
    }
}
                                                                                                                                                                                                                                                                                                                   <?php
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

class StringStartsWithTest extends ConstraintTestCase
{
    public function testConstraintStringStartsWithCorrectValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertTrue($constraint->evaluate('prefixfoo', '', true));
    }

    public function testConstraintStringStartsWithNotCorrectValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertFalse($constraint->evaluate('error', '', true));
    }

    public function testConstraintStringStartsWithCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('0E1');

        $this->assertTrue($constraint->evaluate('0E1zzz', '', true));
    }

    public function testConstraintStringStartsWithNotCorrectNumericValueAndReturnResult(): void
    {
        $constraint = new StringStartsWith('0E1');

        $this->assertFalse($constraint->evaluate('0E2zzz', '', true));
    }

    public function testConstraintStringStartsWithToStringMethod(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertEquals('starts with "prefix"', $constraint->toString());
    }

    public function testConstraintStringStartsWitCountMethod(): void
    {
        $constraint = new StringStartsWith('prefix');

        $this->assertCount(1, $constraint);
    }

    public function testConstraintStringStartsWithNotCorrectValueAndExpectation(): void
    {
        $constraint = new StringStartsWith('prefix');

        try {
            $constraint->evaluate('error');
        } catch (ExpectationFailedException $e) {
            $this->assertEquals(
                <<<EOF
Failed asserting that 'error' starts with "prefix".

EOF
                ,
                TestFailure::exceptionToString($e)
            );

            return;
        }

        $this->fail();
    }

    public function testConstraintStringStartsWithN