<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Util;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\TestCase;

class JsonTest extends TestCase
{
    /**
     * @dataProvider canonicalizeProvider
     *
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testCanonicalize($actual, $expected, $expectError): void
    {
        [$error, $canonicalized] = Json::canonicalize($actual);
        $this->assertEquals($expectError, $error);

        if (!$expectError) {
            $this->assertEquals($expected, $canonicalized);
        }
    }

    public function canonicalizeProvider(): array
    {
        return [
            ['{"name":"John","age":"35"}', '{"age":"35","name":"John"}', false],
            ['{"name":"John","age":"35","kids":[{"name":"Petr","age":"5"}]}', '{"age":"35","kids":[{"age":"5","name":"Petr"}],"name":"John"}', false],
            ['"name":"John","age":"35"}', '{"age":"35","name":"John"}', true],
        ];
    }

    /**
     * @dataProvider prettifyProvider
     *
     * @throws \PHPUnit\Framework\Exception
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testPrettify($actual, $expected): void
    {
        $this->assertEquals($expected, Json::prettify($actual));
    }

    public function prettifyProvider(): array
    {
        return [
            ['{"name":"John","age": "5"}', "{\n    \"name\": \"John\",\n    \"age\": \"5\"\n}"],
            ['{"url":"https://www.example.com/"}', "{\n    \"url\": \"https://www.example.com/\"\n}"],
        ];
    }

    /**
     * @dataProvider prettifyExceptionProvider
     */
    public function testPrettifyException($json): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Cannot prettify invalid json');

        Json::prettify($json);
    }

    public function prettifyExceptionProvider(): array
    {
        return [
            ['"name":"John","age": "5"}'],
            [''],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              INDX( 	 �             (   X  �         e                  $     � ~     $     ��pk� O�
��g�Q��<���pk�       �               C o n f i g u r a t i o n G e n e r a t o r T e s t . p h p   $     � l     $     ���pk� O�
���T��<����pk� p      Tc               C o n f i g u r a t i o n T e s t . p h p     $     p ^     $     ��pk� O�
���T��<���pk�        7               G e t o p t T e s t . p h p   $     x h     $     _��pk� O�
��fV��<�_��pk�      ,               G l o b a l S t a t e T e s t . p h p $     p Z     $     ��pk� O�
��}�X��<���pk�       B	               J s o n T e s t . p h p       $     � x     $     �� �pk� O�
��}�X��<��� �pk�       �               N u l l T e s t R e s u l t C a c h e T e s t . p h p $     X H     $     e�R�pk�CZ�pk�CZ�pk�e�R�pk�                        P H P $     � t     $     �A#�pk� O�
���*[��<��A#�pk�       �               R e g u l a r E x p r e s s i o n T  s t . p h p     $     ` P     $     �y\�pk���j�pk���j�pk��y\�pk�                        T e s t D o x $     � p     $     ��,�pk� O�
��*�]��<���,�pk�       �               T e s t R e s u l t C a c h e T e s t . p h p $     p Z     $     �@B�pk� O�
����_��<��@B�pk� �      ϑ               T e s t T e s t . p h p       $     � �     $     ~G�pk� O�
����_��<�~G�pk�       w	              # X D e b u g F i l t e r S c r i p t G e n e r a t o r T e s t . p h p $     h X     $     !�P�pk� O�
���Qb��<�!�P�pk�       3               X m l T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                          