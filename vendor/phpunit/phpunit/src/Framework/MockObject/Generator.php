<?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\MockObject\Stub;

use PHPUnit\Framework\MockObject\Invocation;
use PHPUnit\Framework\MockObject\Invocation\ObjectInvocation;
use PHPUnit\Framework\MockObject\RuntimeException;
use PHPUnit\Framework\MockObject\Stub;

/**
 * Stubs a method by returning the current object.
 */
class ReturnSelf implements Stub
{
    public function invoke(Invocation $invocation)
    {
        if (!$invocation instanceof ObjectInvocation) {
            throw new RuntimeException(
                'The current object can only be returned when mocking an ' .
                'object, not a static class.'
            );
        }

        return $invocation->getObject();
    }

    public function toString(): string
    {
        return 'return the current object';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\MockObject\Stub;

use PHPUnit\Framework\MockObject\Invocation;
use PHPUnit\Framework\MockObject\Stub;
use SebastianBergmann\Exporter\Exporter;

/**
 * Stubs a method by returning a user-defined value.
 */
class ReturnStub implements Stub
{
    /**
     * @var mixed
     */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function invoke(Invocation $invocation)
    {
        return $this->value;
    }

    public function toString(): string
    {
        $exporter = new Exporter;

        return \sprintf(
            'return user-specified value %s',
            $exporter->export($this->value)
        );
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Framework\MockObject\Stub;

use PHPUnit\Framework\MockObject\Invocation;
use PHPUnit\Framework\MockObject\Stub;

/**
 * Stubs a method by returning a value from a map.
 */
class ReturnValueMap implements Stub
{
    /**
     * @var array
     */
    private $valueMap;

    public function __construct(array $valueMap)
    {
        $this->valueMap = $valueMap;
    }

    public function invoke(Invocation $invocation)
    {
        $parameterCount = \count($invocation->getParameters());

        foreach ($this->valueMap as $map) {
            if (!\is_array($map) || $parameterCount !== (\count($map) - 1)) {
                continue;
            }

            $return = \array_pop($map);

            if ($invocation->getParameters() === $map) {
                return $return;
            }
        }
    }

    public function toString(): string
    {
        return 'return value from a map';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Runner;

use PHPUnit\Framework\Exception;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use ReflectionClass;
use ReflectionException;
use SebastianBergmann\FileIterator\Facade as FileIteratorFacade;

/**
 * Base class for all test runners.
 */
abstract class BaseTestRunner
{
    public const STATUS_UNKNOWN    = -1;

    public const STATUS_PASSED     = 0;

    public const STATUS_SKIPPED    = 1;

    public const STATUS_INCOMPLETE = 2;

    public const STATUS_FAILURE    = 3;

    public const STATUS_ERROR      = 4;

    public const STATUS_RISKY      = 5;

    public const STATUS_WARNING    = 6;

    public const SUITE_METHODNAME  = 'suite';

    /**
     * Returns the loader to be used.
     */
    public function getLoader(): TestSuiteLoader
    {
        return new StandardTestSuiteLoader;
    }

    /**
     * Returns the Test corresponding to the given suite.
     * This is a template method, subclasses override
     * the runFailed() and clearStatus() methods.
     *
     * @param array|string $suffixes
     *
     * @throws Exception
     */
    public function getTest(string $suiteClassName, string $suiteClassFile = '', $suffixes = ''): ?Test
    {
        if (\is_dir($suiteClassName) &&
            !\is_file($suiteClassName . '.php') && empty($suiteClassFile)) {
            $facade = new FileIteratorFacade;
            $files  = $facade->getFilesAsArray(
                $suiteClassName,
                $suffixes
            );

            $suite = new TestSuite($suiteClassName);
            $suite->addTestFiles($files);

            return $suite;
        }

        try {
            $testClass = $this->loadSuiteClass(
                $suiteClassName,
                $suiteClassFile
            );
        } catch (Exception $e) {
            $this->runFailed($e->getMessage());

            return null;
        }

        try {
            $suiteMethod = $testClass->getMethod(self::SUITE_METHODNAME);

            if (!$suiteMethod->isStatic()) {
                $this->runFailed(
                    'suite() method must be static.'
                );

                return null;
            }

            try {
                $test = $suiteMethod->invoke(null, $testClass->getName());
            } catch (ReflectionException $e) {
                $this->runFailed(
                    \sprintf(
                        "Failed to invoke suite() method.\n%s",
                        $e->getMessage()
                    )
                );

                return null;
            }
        } catch (ReflectionException $e) {
            try {
                $test = new TestSuite($testClass);
            } catch (Exception $e) {
                $test = new TestSuite;
                $test->setName($suiteClassName);
            }
        }

        $this->clearStatus();

        return $test;
    }

    /**
     * Returns the loaded ReflectionClass for a suite name.
     */
    protected function loadSuiteClass(string $suiteClassName, string $suiteClassFile = ''): ReflectionClass
    {
        $loader = $this->getLoader();

        return $loader->load($suiteClassName, $suiteClassFile);
    }

    /**
     * Clears the status message.
     */
    protected function clearStatus(): void
    {
    }

    /**
     * Override to define how to handle a failed loading of
     * a test suite.
     */
    abstract protected function runFailed(string $message);
}
                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PHPUnit\Runner;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\IncompleteTestError;
use PHPUnit\Framework\SelfDescribing;
use PHPUnit\Framework\SkippedTestError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestResult;
use PHPUnit\Util\PHP\AbstractPhpProcess;
use SebastianBergmann\Timer\Timer;
use Text_Template;
use Throwable;

/**
 * Runner for PHPT test cases.
 */
class PhptTestCase implements Test, SelfDescribing
{
    /**
     * @var string[]
     */
    private const SETTINGS = [
        'allow_url_fopen=1',
        'auto_append_file=',
        'auto_prepend_file=',
        'disable_functions=',
        'display_errors=1',
        'docref_root=',
        'docref_ext=.html',
        'error_append_string=',
        'error_prepend_string=',
        'error_reporting=-1',
        'html_errors=0',
        'log_errors=0',
        'magic_quotes_runtime=0',
        'output_handler=',
        'open_basedir=',
        'output_buffering=Off',
        'report_memleaks=0',
        'report_zend_debug=0',
        'safe_mode=0',
        'xdebug.default_enable=0',
    ];

    /**
     * @var string
     */
    private $filename;

    /**
     * @var AbstractPhpProcess
     */
    private $phpUtil;

    /**
     * @var string
     */
    private $output = '';

    /**
     * Constructs a test case with the given filename.
     *
     * @throws Exception
     */
    public function __construct(string $filename, AbstractPhpProcess $phpUtil = null)
    {
        if (!\is_file($filename)) {
            throw new Exception(
                \sprintf(
                    'File "%s" does not exist.',
                    $filename
                )
            );
        }

        $this->filename = $filename;
        $this->phpUtil  = $phpUtil ?: AbstractPhpProcess::factory();
    }

    /**
     * Counts the number of test cases executed by run(TestResult result).
     */
    public function count(): int
    {
        return 1;
    }

    /**
     * Runs a test and collects its result in a TestResult instance.
     *
     * @throws Exception
     * @throws \ReflectionException
     * @throws \SebastianBergmann\CodeCoverage\CoveredCodeNotExecutedException
     * @throws \SebastianBergmann\CodeCoverage\InvalidArgumentException
     * @throws \SebastianBergmann\CodeCoverage\MissingCoversAnnotationException
     * @throws \SebastianBergmann\CodeCoverage\RuntimeException
     * @throws \SebastianBergmann\CodeCoverage\UnintentionallyCoveredCodeException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function run(TestResult $result = null): TestResult
    {
        if ($result === null) {
            $result = new TestResult;
        }

        try {
            $sections = $this->parse();
        } catch (Exception $e) {
            $result->startTest($this);
            $result->addFailure($this, new SkippedTestError($e->getMessage()), 0);
            $result->endTest($this, 0);

            return $result;
        }

        $code     = $this->render($sections['FILE']);
        $xfail    = false;
        $settings = $this->parseIniSection(self::SETTINGS);

        $result->startTest($this);

        if (isset($sections['INI'])) {
            $settings = $this->parseIniSection($sections['INI'], $settings);
        }

        if (isset($sections['ENV'])) {
            $env = $this->parseEnvSection($sections['ENV']);
            $this->phpUtil->setEnv($env);
        }

        $this->phpUtil->setUseStderrRedirection(true);

        if ($result->enforcesTimeLimit()) {
            $this->phpUtil->setTimeout($result->getTimeoutForLargeTests());
        }

        $skip = $this->runSkip($sections, $result, $settings);

        if ($skip) {
            return $result;
        }

        if (isset($sections['XFAIL'])) {
            $xfail = \trim($sections['XFAIL']);
        }

        if (isset($sections['STDIN'])) {
            $this->phpUtil->setStdin($sections['STDIN']);
        }

        if (isset($sections['ARGS'])) {
            $this->phpUtil->setArgs($sections['ARGS']);
        }

        if ($result->getCollectCodeCoverageInformation()) {
            $this->renderForCoverage($code);
        }

        Timer::start();

        $jobResult    = $this->phpUtil->runJob($code, $this->stringifyIni($settings));
        $time         = Timer::stop();
        $this->output = $jobResult['stdout'] ?? '';

        if ($result->getCollectCodeCoverageInformation() && ($coverage = $this->cleanupForCoverage())) {
            $result->getCodeCoverage()->append($coverage, $this, true, [], [], true);
        }

        try {
            $this->assertPhptExpectation($sections, $jobResult['stdout']);
        } catch (AssertionFailedError $e) {
            $failure = $e;

            if ($xfail !== false) {
                $failure = new IncompleteTestError($xfail, 0, $e);
            }
            $result->addFailure($this, $failure, $time);
        } catch (Throwable $t) {
            $result->addError($this, $t, $time);
        }

        if ($result->allCompletelyImplemented() && $xfail !== false) {
            $result->addFailure($this, new IncompleteTestError('XFAIL section but test passes'), $time);
        }

        $this->runClean($sections);

        $result->endTest($this, $time);

        return $result;
    }

    /**
     * Returns the name of the test case.
     */
    public function getName(): string
    {
        return $this->toString();
    }

    /**
     * Returns a string representation of the test case.
     */
    public function toString(): string
    {
        return $this->filename;
    }

    public function usesDataProvider(): bool
    {
        return false;
    }

    public function getNumAssertions(): int
    {
        return 1;
    }

    public function getActualOutput(): string
    {
        return $this->output;
    }

    public function hasOutput(): bool
    {
        return !empty($this->output);
    }

    /**
     * Parse --INI-- section key value pairs and return as array.
     *
     * @param array|string
     */
    private function parseIniSection($content, $ini = []): array
    {
        if (\is_string($content)) {
            $content = \explode("\n", \trim($content));
        }

        foreach ($content as $setting) {
            if (\strpos($setting, '=') === false) {
                continue;
            }

            $setting = \explode('=', $setting, 2);
            $name    = \trim($setting[0]);
            $value   = \trim($setting[1]);

            if ($name === 'extension' || $name === 'zend_extension') {
                if (!isset($ini[$name])) {
                    $ini[$name] = [];
                }

                $ini[$name][] = $value;

                continue;
            }

            $ini[$name] = $value;
        }

        return $ini;
    }

    private function parseEnvSection(string $content): array
    {
        $env = [];

        foreach (\explode("\n", \trim($content)) as $e) {
            $e = \explode('=', \trim($e), 2);

            if (!empty($e[0]) && isset($e[1])) {
                $env[$e[0]] = $e[1];
            }
        }

        return $env;
    }

    /**
     * @throws Exception
     */
    private function assertPhptExpectation(array $sections, string $output): void
    {
        $assertions = [
            'EXPECT'      => 'assertEquals',
            'EXPECTF'     => 'assertStringMatchesFormat',
            'EXPECTREGEX' => 'assertRegExp',
        ];

        $actual = \preg_replace('/\r\n/', "\n", \trim($output));

        foreach ($assertions as $sectionName => $sectionAssertion) {
            if (isset($sections[$sectionName])) {
                $sectionContent = \preg_replace('/\r\n/', "\n", \trim($sections[$sectionName]));
                $expected       = $sectionName === 'EXPECTREGEX' ? "/{$sectionContent}/" : $sectionContent;

                if ($expected === null) {
                    throw new Exception('No PHPT expectation found');
                }
                Assert::$sectionAssertion($expected, $actual);

                return;
            }
        }

        throw new Exception('No PHPT assertion found');
    }

    /**
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    private function runSkip(array &$sections, TestResult $result, array $settings): bool
    {
        if (!isset($sections['SKIPIF'])) {
            return false;
        }

        $skipif    = $this->render($sections['SKIPIF']);
        $jobResult = $this->phpUtil->runJob($skipif, $this->stringifyIni($settings));

        if (!\strncasecmp('skip', \ltrim($jobResult['stdout']), 4)) {
            $message = '';

            if (\preg_match('/^\s*skip\s*(.+)\s*/i', $jobResult['stdout'], $skipMatch)) {
                $message = \substr($skipMatch[1], 2);
            }

            $result->addFailure($this, new SkippedTestError($message), 0);
            $result->endTest($this, 0);

            return true;
        }

        return false;
    }

    private function runClean(array &$sections): void
    {
        $this->phpUtil->setStdin('');
        $this->phpUtil->setArgs('');

        if (isset($sections['CLEAN'])) {
            $cleanCode = $this->render($sections['CLEAN']);

            $this->phpUtil->runJob($cleanCode, self::SETTINGS);
        }
    }

    /**
     * @throws Exception
     */
    private function parse(): array
    {
        $sections = [];
        $section  = '';

        $unsupportedSections = [
            'REDIRECTTEST',
            'REQUEST',
            'POST',
            'PUT',
            'POST_RAW',
            'GZIP_POST',
            'DEFLATE_POST',
            'GET',
            'COOKIE',
            'HEADERS',
            'CGI',
            'EXPECTHEADERS',
            'EXTENSIONS',
            'PHPDBG',
        ];

        foreach (\file($this->filename) as $line) {
            if (\preg_match('/^--([_A-Z]+)--/', $line, $result)) {
                $section            = $result[1];
                $sections[$section] = '';

                continue;
            }

            if (empty($section)) {
                throw new Exception('Invalid PHPT file: empty section header');
            }

            $sections[$section] .= $line;
        }

        if (isset($sections['FILEEOF'])) {
            $sections['FILE'] = \rtrim($sections['FILEEOF'], "\r\n");
            unset($sections['FILEEOF']);
        }

        $this->parseExternal($sections);

        if (!$this->validate($sections)) {
            throw new Exception('Invalid PHPT file');
        }

        foreach ($unsupportedSections as $section) {
            if (isset($sections[$section])) {
                throw new Exception(
                    "PHPUnit does not support PHPT $section sections"
                );
            }
        }

        return $sections;
    }

    /**
     * @throws Exception
     */
    private function parseExternal(array &$sections): void
    {
        $allowSections = [
            'FILE',
            'EXPECT',
            'EXPECTF',
            'EXPECTREGEX',
        ];
        $testDirectory = \dirname($this->filename) . \DIRECTORY_SEPARATOR;

        foreach ($allowSections as $section) {
            if (isset($sections[$section . '_EXTERNAL'])) {
                $externalFilename = \trim($sections[$section . '_EXTERNAL']);

                if (!\is_file($testDirectory . $externalFilename) ||
                    !\is_readable($testDirectory . $externalFilename)) {
                    throw new Exception(
                        \sprintf(
                            'Could not load --%s-- %s for PHPT file',
                            $section . '_EXTERNAL',
                            $testDirectory . $externalFilename
                        )
                    );
                }

                $sections[$section] = \file_get_contents($testDirectory . $externalFilename);

                unset($sections[$section . '_EXTERNAL']);
            }
        }
    }

    private function validate(array &$sections): bool
    {
        $requiredSections = [
            'FILE',
            [
                'EXPECT',
                'EXPECTF',
                'EXPECTREGEX',
            ],
        ];

        foreach ($requiredSections as $section) {
            if (\is_array($section)) {
                $foundSection = false;

                foreach ($section as $anySection) {
                    if (isset($sections[$anySection])) {
                        $foundSection = true;

                        break;
                    }
                }

                if (!$foundSection) {
                    return false;
                }

                continue;
            }

            if (!isset($sections[$section])) {
                return false;
            }
        }

        return true;
    }

    private function render(string $code): string
    {
        return \str_replace(
            [
                '__DIR__',
                '__FILE__',
            ],
            [
                "'" . \dirname($this->filename) . "'",
                "'" . $this->filename . "'",
            ],
            $code
        );
    }

    private function getCoverageFiles(): array
    {
        $baseDir  = \dirname(\realpath($this->filename)) . \DIRECTORY_SEPARATOR;
        $basename = \basename($this->filename, 'phpt');

        return [
            'coverage' => $baseDir . $basename . 'coverage',
            'job'      => $baseDir . $basename . 'php',
        ];
    }

    private function renderForCoverage(string &$job): void
    {
        $files = $this->getCoverageFiles();

        $template = new Text_Template(
            __DIR__ . '/../Util/PHP/Template/PhptTestCase.tpl'
        );

        $composerAutoload = '\'\'';

        if (\defined('PHPUNIT_COMPOSER_INSTALL') && !\defined('PHPUNIT_TESTSUITE')) {
            $composerAutoload = \var_export(PHPUNIT_COMPOSER_INSTALL, true);
        }

        $phar = '\'\'';

        if (\defined('__PHPUNIT_PHAR__')) {
            $phar = \var_export(__PHPUNIT_PHAR__, true);
        }

        $globals = '';

        if (!empty($GLOBALS['__PHPUNIT_BOOTSTRAP'])) {
            $globals = '$GLOBALS[\'__PHPUNIT_BOOTSTRAP\'] = ' . \var_export(
                $GLOBALS['__PHPUNIT_BOOTSTRAP'],
                true
            ) . ";\n";
        }

        $template->setVar(
            [
                'composerAutoload' => $composerAutoload,
                'phar'             => $phar,
                'globals'          => $globals,
                'job'              => $files['job'],
                'coverageFile'     => $files['coverage'],
            ]
        );

        \file_put_contents($files['job'], $job);
        $job = $template->render();
    }

    private function cleanupForCoverage(): array
    {
        $files    = $this->getCover