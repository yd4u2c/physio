--TEST--
phpunit --log-teamcity php://stdout ../end-to-end/phpt-stderr.phpt
--FILE--
<?php
$_SERVER['argv'][1] = '--no-configuration';
$_SERVER['argv'][2] = '--log-teamcity';
$_SERVER['argv'][3] = 'php://stdout';
$_SERVER['argv'][4] = \realpath(__DIR__ . '/../end-to-end/phpt-stderr.phpt');

require __DIR__ . '/../bootstrap.php';
PHPUnit\TextUI\Command::main();
--EXPECTF--
PHPUnit %s by Sebastian Bergmann and contributors.


##teamcity[testCount count='1' flowId='%d']

##teamcity[testStarted name='%send-to-end%ephpt-stderr.phpt' flowId='%d']
.                                                                   1 / 1 (100%)
##teamcity[testFinished name='%send-to-end%ephpt-stderr.phpt' duration='%d' flowId='%d']


Time: %s, Memory: %s

OK (1 test, 1 assertion)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  --TEST--
phpunit --log-teamcity php://stdout BankAccountTest ../../_files/BankAccountTest.php
--FILE--
<?php
$_SERVER['argv'][1] = '--no-configuration';
$_SERVER['argv'][2] = '--log-teamcity';
$_SERVER['argv'][3] = 'php://stdout';
$_SERVER['argv'][4] = 'BankAccountTest';
$_SERVER['argv'][5] = __DIR__ . '/../_files/BankAccountTest.php';

require __DIR__ . '/../bootstrap.php';
PHPUnit\TextUI\Command::main();
--EXPECTF--
PHPUnit %s by Sebastian Bergmann and contributors.


##teamcity[testCount count='3' flowId='%d']

##teamcity[testSuiteStarted name='BankAccountTest' locationHint='php_qn://%s%etests%e_files%eBankAccountTest.php::\BankAccountTest' flowId='%d']

##teamcity[testStarted name='testBalanceIsInitiallyZero' locationHint='php_qn://%s%etests%e_files%eBankAccountTest.php::\BankAccountTest::testBalanceIsInitiallyZero' flowId='%d']
.
##teamcity[testFinished name='testBalanceIsInitiallyZero' duration='%s' flowId='%d']

##teamcity[testStarted name='testBalanceCannotBecomeNegative' locationHint='php_qn://%s%etests%e_files%eBankAccountTest.php::\BankAccountTest::testBalanceCannotBecomeNegative' flowId='%d']
.
##teamcity[testFinished name='testBalanceCannotBecomeNegative' duration='%s' flowId='%d']

##teamcity[testStarted name='testBalanceCannotBecomeNegative2' locationHint='php_qn://%s%etests%e_files%eBankAccountTest.php::\BankAccountTest::testBalanceCannotBecomeNegative2' flowId='%d']
.                                                                 3 / 3 (100%)
##teamcity[testFinished name='testBalanceCannotBecomeNegative2' duration='%s' flowId='%d']

##teamcity[testSuiteFinished name='BankAccountTest' flowId='%d']


Time: %s, Memory: %s

OK (3 tests, 3 assertions)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   INDX( 	 ��            (   h  �       g l     �f �        x"     x h     -"     �~B�pk� O�
��'қ��<��~B�pk�       �               l o g - j u n i t - p h p t . p h p t y"     p ^     -"     ��D�pk� O�
��g5���<���D�pk�       6               l o g - j u n i t . p h p t   z"     � n     -"     :CG�pk� O�
��g5���<�:CG�pk�       �               l o g - t e a m c i t y - p h p t . p h p t   {"     x d     -"     2�I�pk� O�
�������<�2�I�pk�       �               l o  - t e a m c i t y . p h p t     �"     p Z     -"     �<�pk��P��pk��P��pk��P��pk�                        m o c k - o b j e c t s p t   |"     p ^     -"     �L�pk� O�
��=����<��L�pk��      �               m y c o m m a n d . p h p t   }"     � z     -"     �jN�pk� O�
��w[���<��jN�pk�      
               o p t i o n s - a f t e r - a r g u m e n t s . p h p t       ~"     � �     -"     ��P�pk� O�
��w[���<���P�pk�8      1              % o r d e r - b y - d e f a u  t - i n v a l i d - v i a - c l i . p h p t     "     � l     -"     �/S�pk� O�
��¾���<��/S�pk��      �               o u t p u t - i s o l a t i o n . p h p t     �"     � ~     -"      �U�pk� O�
��* ���<� �U�pk��      �               p h a r - e x t e n s i o n - s u p p r e s s e d . p h p t   �"     x h     -"     ��W�pk� O�
��* ���<���W�pk�X      U               p h a r - e x t e n s i o n . p h p t �"     p ^     -"     �VZ�pk� O�
�������<��VZ�pk��       �               p h p t - a r g s . p h p t   �"     p \     -"     q�\�pk� O�
��宬�<�q�\�pk��       �                p h p t - e n v . p h p t     �"     x f     -"     o_�pk� O�
��6H���<�o_�pk��       �                p h p t - e x t e r n a l . p h p t   �"     x d     -"     �}a�pk� O�
��6H���<��}a�pk��      �               p h p t - p a r s i n g . p h p t     �"     x b     -"     &�h�pk� O�
�������<�&�h�pk��       �                p h p t - s t d e r r . p h p t      �"     p `     -"     �k�pk� O�
������<��k�pk��       �                p h p t - s t d i n . p h p t               -"     �.r�pk� O�
��Ln���<��.r�pk�@      ;               r e p e a t . p h p t �"      �     -"     (�v�pk� O�
���Ѻ��<�(�v�pk�       O              W r e p o r t - t e s t s - p e r f o r m i n g - a s s e r t i o n s - w h e n - a n n o t a t e d - w i t h - d o e s - n o t - p e r f o r m - a s s e r t i o n s . p h p t �"     � �     -"     	�{�pk� O�
� 73���<�	�{�pk�0      )              $ r e p o r t - u s e l e s s - t e s t s - i n c o m p l e t e . p h p t       �"     � �     -"     �~�pk� O�
��g����<��~�pk�       �              # r e p o r t - u s e l e s s - t e s t s - i s o l a t i o n . p h p t �"     � t     -"     �|��pk� O�
��g����<��|��pk��      ~               r e p o r t - u s e l e s s - t e s t s . p h p t     �"     � x     -"     Bނ�pk� O�
�������<�Bނ�pk�`      [               s t o p - o n - d e  e c t - v i a - c l i . p h p t �"     � ~     -"     N��pk� O�
��ZĬ�<�N��pk��      �               s t o p - o n - d e f e c t - v i a - c o n f i g . p h p t   �"     � v     -"     t-��pk� O�
��ZĬ�<�t-��pk��      �               s t o p - o n - e r r o r - v i a - c l i . p h p t   �"     � |     -"     %�pk� O�
��n�Ƭ�<�%�pk�       �               s t o p - o n - e r r o r - v i a - c o n f i g . p h p t     �"     � �     -"     1��pk� O�
���ɬ�<�1��pk 8      2               s t o p - o n - i n c o m p l e t e - v i a - c l i . p h p t �"     � �     -"     b{��pk� O�
��0�ˬ�<�b{��pk�p      i              " s t o p - o n - i n c o m p l e t e - v i a - c o n f i g . p h p t   �"     � z     -"     }���pk� O�
��0�ˬ�<�}���pk�`      \               s t o p - o n - w a r n i n g - v i a - c l i . p h p t   