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

/**
 * Logical AND.
 */
class LogicalAnd extends Constraint
{
    /**
     * @var Constraint[]
     */
    private $constraints = [];

    public static function fromConstraints(Constraint ...$constraints): self
    {
        $constraint = new self;

        $constraint->constraints = \array_values($constraints);

        return $constraint;
    }

    /**
     * @param Constraint[] $constraints
     *
     * @throws \PHPUnit\Framework\Exception
     */
    public function setConstraints(array $constraints): void
    {
        $this->constraints = [];

        foreach ($constraints as $constraint) {
            if (!($constraint instanceof Constraint)) {
                throw new \PHPUnit\Framework\Exception(
                    'All parameters to ' . __CLASS__ .
                    ' must be a constraint object.'
                );
            }

            $this->constraints[] = $constraint;
        }
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * If $returnResult is set to false (the default), an exception is thrown
     * in case of a failure. null is returned otherwise.
     *
     * If $returnResult is true, the result of the evaluation is returned as
     * a boolean value instead: true in case of success, false in case of a
     * failure.
     *
     * @param mixed  $other        value or object to evaluate
     * @param string $description  Additional information about the test
     * @param bool   $returnResult Whether to return a result or throw an exception
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function evaluate($other, $description = '', $returnResult = false)
    {
        $success = true;

        foreach ($this->constraints as $constraint) {
            if (!$constraint->evaluate($other, $description, true)) {
                $success = false;

                break;
            }
        }

        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            $this->fail($other, $description);
        }
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        $text = '';

        foreach ($this->constraints as $key => $constraint) {
            if ($key > 0) {
                $text .= ' and ';
            }

            $text .= $constraint->toString();
        }

        return $text;
    }

    /**
     * Counts the number of constraint elements.
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->constraints as $constraint) {
            $count += \count($constraint);
        }

        return $count;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php
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

/**
 * Logical NOT.
 */
class LogicalNot extends Constraint
{
    /**
     * @var Constraint
     */
    private $constraint;

    public static function negate(string $string): string
    {
        $positives = [
            'contains ',
            'exists',
            'has ',
            'is ',
            'are ',
            'matches ',
            'starts with ',
            'ends with ',
            'reference ',
            'not not ',
        ];

        $negatives = [
            'does not contain ',
            'does not exist',
            'does not have ',
            'is not ',
            'are not ',
            'does not match ',
            'starts not with ',
            'ends not with ',
            'don\'t reference ',
            'not ',
        ];

        \preg_match('/(\'[\w\W]*\')([\w\W]*)("[\w\W]*")/i', $string, $matches);

        if (\count($matches) > 0) {
            $nonInput = $matches[2];

            $negatedString = \str_replace(
                $nonInput,
                \str_replace(
                    $positives,
                    $negatives,
                    $nonInput
                ),
                $string
            );
        } else {
            $negatedString = \str_replace(
                $positives,
                $negatives,
                $string
            );
        }

        return $negatedString;
    }

    /**
     * @param Constraint|mixed $constraint
     */
    public function __construct($constraint)
    {
        parent::__construct();

        if (!($constraint instanceof Constraint)) {
            $constraint = new IsEqual($constraint);
        }

        $this->constraint = $constraint;
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * If $returnResult is set to false (the default), an exception is thrown
     * in case of a failure. null is returned otherwise.
     *
     * If $returnResult is true, the result of the evaluation is returned as
     * a boolean value instead: true in case of success, false in case of a
     * failure.
     *
     * @param mixed  $other        value or object to evaluate
     * @param string $description  Additional information about the test
     * @param bool   $returnResult Whether to return a result or throw an exception
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function evaluate($other, $description = '', $returnResult = false)
    {
        $success = !$this->constraint->evaluate($other, $description, true);

        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            $this->fail($other, $description);
        }
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        switch (\get_class($this->constraint)) {
            case LogicalAnd::class:
            case self::class:
            case LogicalOr::class:
                return 'not( ' . $this->constraint->toString() . ' )';

            default:
                return self::negate(
                    $this->constraint->toString()
                );
        }
    }

    /**
     * Counts the number of constraint elements.
     */
    public function count(): int
    {
        return \count($this->constraint);
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param mixed $other evaluated value or object
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    protected function failureDescription($other): string
    {
        switch (\get_class($this->constraint)) {
            case LogicalAnd::class:
            case self::class:
            case LogicalOr::class:
                return 'not( ' . $this->constraint->failureDescription($other) . ' )';

            default:
                return self::negate(
                    $this->constraint->failureDescription($other)
                );
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    INDX( 	 ��            (   �  �        N   l �            w!     h X     e!     �wpk� O�
���6���<��wpk�       �               I s E m p t y . p h p x!     h X     e!     }2wpk� O�
��j����<�}2wpk�       �               I s E q u a l . p h p y!     h X     e!     ܔwpk� O�
�������<�ܔwpk�                      I s F a l s e . p h p z!     p Z     e!     5�!wpk� O�
��,^���<�5�!wpk�                      I s F i n i t e . p h p       {!     p `     e!     �)wpk� O�
��,^���<��)wpk�        W               I s I d e n t i c a l . p h p |!     p ^     e!     �-wpk� O�
�������<��-wpk�                      I s I n f i n i t e . p h p   }!     x b     e!     �2wpk� O�
���#���<��2wpk�       �               I s I n s t a n c e O f . p h p       ~!     h V     e!     �
5wpk� O�
���#���<��
5wpk�       �              
 I s J s o n . p h p   !     h T     e!     ��9wpk� O�
�������<���9wpk�                     	 I s  a n . p h p     �!     h V     e!     �1<wpk� O�
��^竪�<��1<wpk�                     
 I s N u l l . p h p   �!     p ^     e!     E�>wpk� O�
���J���<�E�>wpk�       E               I s R e a d a b l e . p h p   �!     h V     e!     ��@wpk� O�
���J���<���@wpk�                     
 I s T r u e . p h p   �!     h V     e!     ��Ewpk� O�
������<���Ewpk�       �              
 I s T y p e . p h p   �!     p ^     e!     Hwpk� O�
��u���<�Hwpk�       E              I s W r i t a b l e . p h p   �!     p `     e!     �Jwpk� O�
��u���<��Jwpk�       m               J s o n M a t c h e s . p h p �!     � �     e!     �DOwpk� O�
���q���<��DOwpk�       !              # J s o n M a t c h e s E r r o r M e s s a g e P r o v i d e r . p h p �!     p Z     e!     �Qwpk� O�
��'Է��<��Qwpk�       �               L e s s T h a n . p h p       �!     p ^     e!     h	Twpk� O�
���5���<�h	Twpk�                      L o g i c a  A n d . p h p   �!     p ^     e!     8�]wpk� O�
��阼��<�8�]wpk�        �               L o g i c a l N o t . p h p   �!     p \     e!     ��_wpk� O�
��阼��<���_wpk�       �               L o g i c a l O r . p h p     �!     p ^     e!     ��dwpk� O�
��Q����<���dwpk�       �               L o g i c a l X o r . p h p   �!     � n     e!     ��kwpk� O�
���\���<���kwpk�       ]               O b j e c t H a s A t t r i b u t e . p h p   �!     � l     e!     E�pwpk  O�
���ê�<�E�pwpk�       <               R e g u l a r E x p r e s s i o n . p h p     �!     p Z     e!     i�wwpk� O�
��c"ƪ�<�i�wwpk��      �               S a m e S i z e . p h p       �!     x f     e!     ��|wpk� O�
��c"ƪ�<���|wpk�       �               S t r i n g C o n t a i n s . p h p   �!     x f     e!     ��wpk� O�
����Ȫ�<���wpk�       P               S t r i n g E n d s W i t h . p h p   �!     � �     e!     *�wpk� O�
���ʪ�<�*�wpk�      `
              " S t r i n g M a t c h e s F o r m a t D e s c r i p t i o n . p h p   �!     � j     e!     �A�wpk� O�
���ʪ�<��A�wpk�       =               S t r i n g S t a r t s W i t h . p h p       �!     � p     e!     w�wpk� O�
��ZIͪ�<�w�wpk�       _               T r a v e r s a b l e C o n t a i n s . p h p �!     � x     e!     ���wpk� O�
��ªϪ�<����wpk�       [	               T r a v e r s a b l e C o n t a i n s O n l y . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
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

/**
 * Logical OR.
 */
class LogicalOr extends Constraint
{
    /**
     * @var Constraint[]
     */
    private $constraints = [];

    public static function fromConstraints(Constraint ...$constraints): self
    {
        $constraint = new self;

        $constraint->constraints = \array_values($constraints);

        return $constraint;
    }

    /**
     * @param Constraint[] $constraints
     */
    public function setConstraints(array $constraints): void
    {
        $this->constraints = [];

        foreach ($constraints as $constraint) {
            if (!($constraint instanceof Constraint)) {
                $constraint = new IsEqual(
                    $constraint
                );
            }

            $this->constraints[] = $constraint;
        }
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * If $returnResult is set to false (the default), an exception is thrown
     * in case of a failure. null is returned otherwise.
     *
     * If $returnResult is true, the result of the evaluation is returned as
     * a boolean value instead: true in case of success, false in case of a
     * failure.
     *
     * @param mixed  $other        value or object to evaluate
     * @param string $description  Additional information about the test
     * @param bool   $returnResult Whether to return a result or throw an exception
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function evaluate($other, $description = '', $returnResult = false)
    {
        $success = false;

        foreach ($this->constraints as $constraint) {
            if ($constraint->evaluate($other, $description, true)) {
                $success = true;

                break;
            }
        }

        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            $this->fail($other, $description);
        }
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        $text = '';

        foreach ($this->constraints as $key => $constraint) {
            if ($key > 0) {
                $text .= ' or ';
            }

            $text .= $constraint->toString();
        }

        return $text;
    }

    /**
     * Counts the number of constraint elements.
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->constraints as $constraint) {
            $count += \count($constraint);
        }

        return $count;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php
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

/**
 * Logical XOR.
 */
class LogicalXor extends Constraint
{
    /**
     * @var Constraint[]
     */
    private $constraints = [];

    public static function fromConstraints(Constraint ...$constraints): self
    {
        $constraint = new self;

        $constraint->constraints = \array_values($constraints);

        return $constraint;
    }

    /**
     * @param Constraint[] $constraints
     */
    public function setConstraints(array $constraints): void
    {
        $this->constraints = [];

        foreach ($constraints as $constraint) {
            if (!($constraint instanceof Constraint)) {
                $constraint = new IsEqual(
                    $constraint
                );
            }

            $this->constraints[] = $constraint;
        }
    }

    /**
     * Evaluates the constraint for parameter $other
     *
     * If $returnResult is set to false (the default), an exception is thrown
     * in case of a failure. null is returned otherwise.
     *
     * If $returnResult is true, the result of the evaluation is returned as
     * a boolean value instead: true in case of success, false in case of a
     * failure.
     *
     * @param mixed  $other        value or object to evaluate
     * @param string $description  Additional information about the test
     * @param bool   $returnResult Whether to return a result or throw an exception
     *
     * @throws ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function evaluate($other, $description = '', $returnResult = false)
    {
        $success    = true;
        $lastResult = null;

        foreach ($this->constraints as $constraint) {
            $result = $constraint->evaluate($other, $description, true);

            if ($result === $lastResult) {
                $success = false;

                break;
            }

            $lastResult = $result;
        }

        if ($returnResult) {
            return $success;
        }

        if (!$success) {
            $this->fail($other, $description);
        }
    }

    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        $text = '';

        foreach ($this->constraints as $key => $constraint) {
            if ($key > 0) {
                $text .= ' xor ';
            }

            $text .= $constraint->toString();
        }

        return $text;
    }

    /**
     * Counts the number of constraint elements.
     */
    public function count(): int
    {
        $count = 0;

        foreach ($this->constraints as $constraint) {
            $count += \count($constraint);
        }

        return $count;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\Constraint;

use ReflectionObject;

/**
 * Constraint that asserts that the object it is evaluated for has a given
 * attribute.
 *
 * The attribute name is passed in the constructor.
 */
class ObjectHasAttribute extends ClassHasAttribute
{
    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        $object = new ReflectionObject($other);

        return $object->hasProperty($this->attributeName());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  