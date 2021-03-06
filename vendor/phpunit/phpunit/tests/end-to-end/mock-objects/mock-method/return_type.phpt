--TEST--
https://github.com/sebastianbergmann/phpunit/issues/3380
--FILE--
<?php
$tmpResultCache = tempnam(sys_get_temp_dir(), __FILE__);
file_put_contents($tmpResultCache, file_get_contents(__DIR__ . '/../../../../_files/DataproviderExecutionOrderTest_result_cache.txt'));

$_SERVER['argv'][1] = '--no-configuration';
$_SERVER['argv'][2] = '--order-by=defects';
$_SERVER['argv'][3] = '--testdox';
$_SERVER['argv'][4] = '--cache-result';
$_SERVER['argv'][5] = '--cache-result-file=' . $tmpResultCache;
$_SERVER['argv'][6] = \dirname(\dirname(\dirname(__DIR__))) . '/../_files/DataproviderExecutionOrderTest.php';

require __DIR__ . '/../../../../bootstrap.php';
PHPUnit\TextUI\Command::main();

unlink($tmpResultCache);
--EXPECTF--
PHPUnit %s by Sebastian Bergmann and contributors.

DataproviderExecutionOrder
 ✔ First test that always works
 ✔ Add numbers with a dataprovider with data set "1+2=3"
 ✔ Add numbers with a dataprovider with data set "2+1=3"
 ✘ Add numbers with a dataprovider with data set "1+1=3"
   │
   │ Failed asserting that 2 is identical to 