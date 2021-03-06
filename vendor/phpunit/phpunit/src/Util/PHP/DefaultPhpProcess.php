--TEST--
phpunit --configuration _files/hooks.xml HookTest _files/HookTest.php
--FILE--
<?php
$_SERVER['argv'][1] = '--configuration';
$_SERVER['argv'][2] = __DIR__ . '/_files/hooks.xml';
$_SERVER['argv'][3] = 'HookTest';
$_SERVER['argv'][4] = __DIR__ . '/_files/HookTest.php';

require __DIR__ . '/../bootstrap.php';
PHPUnit\TextUI\Command::main();
--EXPECTF--
PHPUnit %s by Sebastian Bergmann and contributors.

PHPUnit\Test\Extension::tellAmountOfInjectedArguments: %d
PHPUnit\Test\Extension::executeBeforeFirstTest
PHPUnit\Test\Extension::executeBeforeTest: PHPUnit\Test\HookTest::testSuccess
PHPUnit\Test\Extension::executeAfterSuccessfulTest: PHPUnit\Test\HookTest::testSuccess
PHPUnit\Test\Extension::executeAfterTest: PHPUnit\Test\HookTest::testSuccess
PHPUnit\Test\Extension::executeBeforeTest: PHPUnit\Test\HookTest::testFailure
PHPUnit\Test\Extension::executeAfterTestFailure: PHPUnit\Test\HookTest::testFailure: Failed asserting that false is true.
PHPUnit\Test\Extension::executeAfterTest: PHPUnit\Test\HookTest::testFailure
PHPUnit\Test\Extension::executeBeforeTest: PHPUnit\Test\HookTest::testError
PHPUnit\Test\Extension::executeAfterTestError: PHPUnit\Test\HookTest::testError: message
PHPUnit\Test\Extension::executeAfterTest: PHPUnit\Test\HookTest::testError
PHPUnit\Test\Extension::executeBeforeTest: PHPUnit\Test\HookTest::testIncomplete
PHPUnit\Test\Extension::executeAfterIncompleteTest: PHPUnit\Test\HookTest::testIncomplete: message
PHPUnit\Test\Extension::executeAfterTest: PHPUnit\Test\HookTest::testIncomplete
PHPUnit\Test\Extension::executeBeforeTest: PHPUnit\Test\HookTest::testRisky
PHPUnit\Test\Extension::executeAfterRiskyTest: PHPUnit\Test\HookTest::testRisky: message
PHPUnit\Test\Extension::executeAfterTest: PHPUnit\Test\HookTest::testRisky
PHPUnit\Test\Extension::executeBeforeTest: PHPUnit\Test\HookTest::testSkipped
PHPUnit\Test\Extension::executeAfterSkippedTest: PHPUnit\Test\HookTest::testSkipped: message
PHPUnit\Test\Extension::executeAfterTest: PHPUnit\Test\HookTest::testSkipped
PHPUnit\Test\Extension::executeBeforeTest: PHPUnit\Test\HookTest::testWarning
PHPUnit\Test\Extension::executeAfterTestWarning: PHPUnit\Test\HookTest::testWarning: message
PHPUnit\Test\Extension::executeAfterTest: PHPUnit\Test\HookTest::testWarning
PHPUnit\Test\Extension::executeAfterLastTest
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 INDX( 	 �ݎ            (   �  �       n n   s g             h"     � �     -"     E�2pk� O�
��7`��<�E�2pk�p      i              # f i l t e r - m e t h o d - c a s e - i n s e n s i t i v e . p h p t i"     � �     -"     �5pk� O�
����b��<��5pk�                    + f i l t e r - m e t h o d - c a s e - s e n s i t i v e - n o - r e s u l t . p h p t j"     � z     -"     Sv7pk� O�
����d��<�Sv7pk�       �               f i l t e r - m e t h o d - i s o l a t i o  . p h p t       k"     x f     -"     3;<pk� O�
��L^g��<�3;<pk�p      k               f i l t e r - m e t h o d . p h p t   l"     � n     -"     }�>pk� O�
��L^g��<�}�>pk�       �               f i l t e r - n o - r e s u l t s . p h p t   m"     � v     -"     }�>pk� O�
����i��<�}�>pk��      �               f o r w a r d - c o m p a t i b i l i t y . p h p t   n"     � j     -"     k Apk� O�
���#l��<�k Apk��      �               g r o u p - i s o l a t i o  . p h p t       o"     h V     -"     �#�pk� O�
���#l��<��#�pk��      �              
 g r o u p . p h p t   p"     h T     -"     �*�pk� O�
��X�n��<��*�pk�        ^              	 h e l p . p h p t     q"     h V     -"     j	-�pk�