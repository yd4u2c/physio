--TEST--
phpunit --order-by=defects MultiDependencyTest ./tests/_files/MultiDependencyTest.php
--FILE--
<?php
$tmpResultCache = tempnam(sys_get_temp_dir(), __FILE__);
file_put_contents($tmpResultCache, file_get_contents(__DIR__ . '/../_files/MultiDependencyTest_result_cache.txt'));

$_SERVER['argv'][1] = '--no-configuration';
$_SERVER['argv'][2] = '--debug';
$_SERVER['argv'][3] = '--order-by=defects';
$_SERVER['argv'][4] = '--cache-result';
$_SERVER['argv'][5] = '--cache-result-file=' . $tmpResultCache;
$_SERVER['argv'][6] = 'MultiDependencyTest';
$_SERVER['argv'][7] = __DIR__ . '/../_files/MultiDependencyTest.php';

require __DIR__ . '/../bootstrap.php';
PHPUnit\TextUI\Command::main();

unlink($tmpR