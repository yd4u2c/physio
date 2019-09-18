<?php
use PHPUnit\Framework\TestCase;
use SebastianBergmann\CodeCoverage\CodeCoverage;

if (!defined('STDOUT')) {
    // php://stdout does not obey output buffering. Any output would break
    // unserialization of child process results in the parent process.
    define('STDOUT', fopen('php://temp', 'w+b'));
    define('STDERR', fopen('php://stderr', 'wb'));
}

{iniSettings}
ini_set('display_errors', 'stderr');
set_include_path('{include_path}');

$composerAutoload = {composerAutoload};
$phar             = {phar};

ob_start();

if ($composerAutoload) {
    require_once $composerAutoload;
    define('PHPUNIT_COMPOSER_INSTALL', $composerAutoload);
} else if ($phar) {
    require $phar;
}

function __phpunit_run_isolated_test()
{
    if (!class_exists('{className}')) {
        require_once '{filename}';
    }

    $result = new PHPUnit\Framework\TestResult;

    if ({collectCodeCoverageInformation}) {
        $result->setCodeCoverage(
            new CodeCoverage(
                null,
                unserialize('{codeCoverageFilter}')
            )
        );
    }

    $result->beStrictAboutTestsThatDoNotTestAnything({isStrictAboutTestsThatDoNotTestAnything});
    $result->beStrictAboutOutputDuringTests({isStrictAboutOutputDuringTests});
    $result->enforceTimeLimit({enforcesTimeLimit});
    $result->beStrictAboutTodoAnnotatedTests({isStrictAboutTodoAnnotatedTests});
    $result->beStrictAboutResourceUsageDuringSmallTests({isStrictAboutResourceUsageDuringSmallTests});

    /** @var TestCase $test */
    $test = new {className}('{methodName}', unserialize('{data}'), '{dataName}');
    $test->setDependencyInput(unserialize('{dependencyInput}'));
    $test->setInIsolation(TRUE);

    ob_end_clean();
    $test->run($result);
    $output = '';
    if (!$test->hasExpectationOnOutput()) {
        $output = $test->getActualOutput();
    }

    ini_set('xdebug.scream', '0');
    @rewind(STDOUT); /* @ as not every STDOUT target stream is rewindable */
    if ($stdout = stream_get_contents(STDOUT)) {
        $output = $stdout . $output;
        $streamMetaData = stream_get_meta_data(STDOUT);
        if (!empty($streamMetaData['stream_type']) && 'STDIO' === $streamMetaData['stream_type']) {
            @ftruncate(STDOUT, 0);
            @rewind(STDOUT);
        }
    }

    print serialize(
      [
        'testResult'    => $test->getResult(),
        'numAssertions' => $test->getNumAssertions(),
        'result'        => $result,
        'output'        => $output
      ]
    );
}

$configurationFilePath = '{configurationFilePath}';

if ('' !== $configurationFilePath) {
    $configuration = PHPUnit\Util\Configuration::getInstance($configurationFilePath);
    $configuration->handlePHPConfiguration();
    unset($configuration);
}

function __phpunit_error_handler($errno, $errstr, $errfile, $errline, $errcontext)
{
   return true;
}

set_error_handler('__phpunit_error_handler');

{constants}
{included_files}
{globals}

restore_error_handler();

if (isset($GLOBALS['__PHPUNIT_BOOTSTRAP'])) {
    require_once $GLOBALS['__PHPUNIT_BOOTSTRAP'];
    unset($GLOBALS['__PHPUNIT_BOOTSTRAP']);
}

__phpunit_run_isolated_test();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Util\TestDox;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use PHPUnit\Runner\PhptTestCase;
use PHPUnit\Runner\TestSuiteSorter;
use PHPUnit\TextUI\ResultPrinter;
use SebastianBergmann\Timer\Timer;

/**
 * This printer is for CLI output only. For the classes that output to file, html and xml,
 * please refer to the PHPUnit\Util\TestDox namespace
 */
class CliTestDoxPrinter extends ResultPrinter
{
    /**
     * @var int[