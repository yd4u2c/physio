INDX( 	 TȎ            (   x  �       a l r -             \"     � �     -"     ��pk� O�
����J��<���pk�       �              0 f i l t e r - d a t a p r o v i d e r - b y - o n l y - r a n g e - i s o l a t i o n . p h p t       ]"     � �     -"     ��pk� O�
���$M��<���pk�`      ^              & f i l t e r - d a t a p r o v i d e r - b y - o n l y - r a n g e . p h p t   ^"     � �     -"     ��pk� O�
����O��<���pk�       �              1 f i l t e r - d a t  p r o v i d e r - b y - o n l y - r e g e x p - i s o l a t i o n . p h p t     _"     � �     -"     sQpk� O�
��$�Q��<�sQpk�h      e              ' f i l t e r - d a t a p r o v i d e r - b y - o n l y - r e g e x p . p h p t `"     � �     -"     4�pk� O�
��$�Q��<�4�pk�       �              1 f i l t e r - d a t a p r o v i d e r - b y - o n l y - s t r i n g - i s o l a t i o n . p h p t     a"     � �     -"     ��pk� O�
��:KT��<���pk�p      j              ' f i  t e r - d a t a p r o v i d e r - b y - o n l y - s t r i n g . p h p t b"     � �     -"     "pk� O�
��ѭV��<�"pk�       �              + f i l t e r - d a t a p r o v i d e r - b y - r a n g e - i s o l a t i o n . p h p t c"     � �     -"     �c$pk� O�
��Y��<��c$pk�p      m              ! f i l t e r - d a t a p r o v i d e r - b y - r a n g e . p h p t     d"     � �     -"     <()pk� O�
��Y��<�<()pk�       �              , f i l t e r - d a t a p r o v i d e  - b y - r e g e x p - i s o l a t i o n . p h p t       e"     � �     -"     g�+pk� O�
��Gs[��<�g�+pk�x      w              " f i l t e r - d a t a p r o v i d e r - b y - r e g e x p . p h p t   f"     � �     -"     ��-pk� O�
����]��<���-pk�       �              , f i l t e r - d a t a p r o v i d e r - b y - s t r i n g - i s o l a t i o n . p h p t                     -"     �O0pk� O�
����]��<��O0pk��      |              " f i l t e r - d a t a p r o v i d e r - b y  s t r i n g . p h p t   h"     � �     -"     E�2pk� O�
��7`��<�E�2pk�p      i              # f i l t e r - m e t h o d - c a s e - i n s e n s i t i v e . p h p t i"     � �     -"     �5pk� O�
����b��<��5pk�                    + f i l t e r - m e t h o d - c a s e - s e n s i t i v e - n o - r e s u l t . p h p t j"     � z     -"     Sv7pk� O�
����d��<�Sv7pk�       �               f i l t e r - m e t h o d - i s o l a t i o n . p h p t       k"     x f     -"     3;<pk� O�
��L^g��<�3;<pk�p      k               f i l t e r - m e t h o d . p h p t   l"     � n     -"     }�>pk� O�
��L^g��<�}�>pk�       �               f i l t e r - n o - r e s u l t s . p h p t   m"     � v     -"     }�>pk� O�
����i��<�}�>pk��      �               f o r w a r d - c o m p a t i b i l i t y . p h p t   n"     � j     -"     k Apk� O�
���#l��<�k Apk��      �               g r o u p - i s o l a t i o n . p h p t       o"     h V     -"     �#�pk� O�
���#l��<��#�pk��      �              
 g r o u p . p h p t   p"     h T     -"     �*�pk� O�
��X�n��<��*�pk�        ^              	 h e l p . p h p t     q"     h V     -"     j	-�pk� O�
����p��<�j	-�pk�        �              
 h e l p 2 . p h p t   r"     h V     -"     �1�pk� O�
��Ks��<��1�pk�       	              
 h o o k s . p h p t   s"     x f     -"     �8�pk� O�
��Ks��<��8�pk��      �               i n i - i s o l a t i o n . p h p t  t"     x b     -"     �8�pk� O�
��O�u��<��8�pk�                     l i s t - g r o u p s . p h p t       u"     x b     -"     �W;�pk� O�
���x��<��W;�pk��      �               l i s t - s u i t e s . p h p t       v"     � z     -"     �=�pk� O�
���x��<��=�pk�8      6               l i s t - t e s t s - d a t a p r o v i d e r . p h p t                                                                                                                                    --TEST--
phpunit --process-isolation --filter testBalanceIsInitiallyZero BankAccountTest ../../_files/BankAccountTest.php
--FILE--
<?php
$_SERVER['argv'][1] = '--no-configuration';
$_SERVER['argv'][2] = '--process-isolation';
$_SERVER['argv'][3] = '--filter';
$_SERVER['argv'][4] = 'testBalanceIsInitiallyZero';
$_SERVER['argv'][5] = 'BankAccountTest';
$_SERVER['argv'][6] = __DIR__ . '/../_files/BankAccountTest.php';

require __DIR__ . '/../bootstrap.php';
PHPUnit\TextUI\Command::main();
--EXPECTF--
PHPUnit %s by Sebastian Bergmann and contributors.

.                                                                   1 / 1 (100%)

Time: %s, Memory: %s

OK (1 test, 1 assertion)
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    --TEST--
phpunit
--FILE--
<?php
$_SERVER['argv'][1] = '--no-configuration';

require __DIR__ . '/../bootstrap.php';
PHPUnit\TextUI\Command::main();
--EXPECTF--
PHPUnit %s by Sebastian Bergmann and contributors.

Usage: phpunit [options] UnitTest [UnitTest.php]
       phpunit [options] <directory>

Code Coverage Options:

  --coverage-clover <file>    Generate code coverage report in Clover XML format
  --coverage-crap4j <file>    Generate code coverage report in Crap4J XML format
  --coverage-html <dir>       Generate code coverage report in HTML format
  --coverage-php <file>       Export PHP_CodeCoverage object to file
  --coverage-text=<file>      Generate code coverage report in text format
                              Default: Standard output
  --coverage-xml <dir>        Generate code coverage report in PHPUnit XML format
  --whitelist <dir>           Whitelist <dir> for code coverage analysis
  --disable-coverage-ignore   Disable annotations for ignoring code coverage
  --no-coverage               Ignore code coverage configuration
  --dump-xdebug-filter <file> Generate script to set Xdebug code coverage filter

Logging Options:

  --log-junit <file>          Log test execution in JUnit XML format to file
  --log-teamcity <file>       Log test execution in TeamCity format to file
  --testdox-html <file>       Write agile documentation in HTML format to file
  --testdox-text <file>       Write agile documentation in Text format to file
  --testdox-xml <file>        Write agile documentation in XML format to file
  --reverse-list              Print defects in reverse order

Test Selection Options:

  --filter <pattern>          Filter which tests to run
  --testsuite <name,...>      Filter which testsuite to run
  --group ...                 Only runs tests from the specified group(s)
  --exclude-group ...         Exclude tests from the specified group(s)
  --list-groups               List available test groups
  --list-suites               List available test suites
  --list-tests                List available tests
  --list-tests-xml <file>     List available tests in XML format
  --test-suffix ...           Only search for test in files with specified
                              suffix(es). Default: Test.php,.phpt

Test Execution Options:

  --dont-report-useless-tests Do not report tests that do not test anything
  --strict-coverage           Be strict about @covers annotation usage