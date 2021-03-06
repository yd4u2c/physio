'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'ab.dat',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C'.\DIRECTORY_SEPARATOR.'abc.dat',
                ],
            ],
            ['A/B/C', 'foobar',
                [
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C'.\DIRECTORY_SEPARATOR.'abc.dat',
                    'copy'.\DIRECTORY_SEPARATOR.'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C',
                    'copy'.\DIRECTORY_SEPARATOR.'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C'.\DIRECTORY_SEPARATOR.'abc.dat.copy',
                ],
            ],
            ['A/B', 'foobar',
                [
                    //dirs
                    'A'.\DIRECTORY_SEPARATOR.'B',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C',
                    'copy'.\DIRECTORY_SEPARATOR.'A'.\DIRECTORY_SEPARATOR.'B',
                    'copy'.\DIRECTORY_SEPARATOR.'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C',
                    //files
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'ab.dat',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C'.\DIRECTORY_SEPARATOR.'abc.dat',
                    'copy'.\DIRECTORY_SEPARATOR.'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'ab.dat.copy',
                    'copy'.\DIRECTORY_SEPARATOR.'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C'.\DIRECTORY_SEPARATOR.'abc.dat.copy',
                ],
            ],
            ['/^with space\//', 'foobar',
                [
                    'with space'.\DIRECTORY_SEPARATOR.'foo.txt',
                ],
            ],
            [
                '/^A/',
                ['a.dat', 'abc.dat'],
                [
                    'A',
                    'A'.\DIRECTORY_SEPARATOR.'B',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'ab.dat',
                ],
            ],
            [
                ['/^A/', 'one'],
                'foobar',
                [
                    'A',
                    'A'.\DIRECTORY_SEPARATOR.'B',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C',
                    'A'.\DIRECTORY_SEPARATOR.'a.dat',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'ab.dat',
                    'A'.\DIRECTORY_SEPARATOR.'B'.\DIRECTORY_SEPARATOR.'C'.\DIRECTORY_SEPARATOR.'abc.dat',
                    'one',
                    'one'.\DIRECTORY_SEPARATOR.'a',
                    'one'.\DIRECTORY_SEPARATOR.'b',
                    'one'.\DIRECTORY_SEPARATOR.'b'.\DIRECTORY_SEPARATOR.'c.neon',
                    'one'.\DIRECTORY_SEPARATOR.'b'.\DIRECTORY_SEPARATOR.'d.neon',
                ],
            ],
        ];
    }

    public function testAccessDeniedException()
    {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('chmod is not supported on Windows');
        }

        $finder = $this->buildFinder();
        $finder->files()->in(self::$tmpDir);

        // make 'foo' directory non-readable
        $testDir = self::$tmpDir.\DIRECTORY_SEPARATOR.'foo';
        chmod($testDir, 0333);

        if (false === $couldRead = is_readable($testDir)) {
            try {
                $this->assertIterator($this->toAbsolute(['foo bar', 'test.php', 'test.py']), $finder->getIterator());
                $this->fail('Finder should throw an exception when opening a non-readable directory.');
            } catch (\Exception $e) {
                $expectedExceptionClass = 'Symfony\\Component\\Finder\\Exception\\AccessDeniedException';
                if ($e instanceof \PHPUnit_Framework_ExpectationFailedException) {
                    $this->fail(sprintf("Expected exception:\n%s\nGot:\n%s\nWith comparison failure:\n%s", $expectedExceptionClass, 'PHPUnit_Framework_ExpectationFailedException', $e->getComparisonFailure()->getExpectedAsString()));
                }

                if ($e instanceof \PHPUnit\Framework\ExpectationFailedException) {
                    $this->fail(sprintf("Expected exception:\n%s\nGot:\n%s\nWith comparison failure:\n%s", $expectedExceptionClass, '\PHPUnit\Framework\ExpectationFailedException', $e->getComparisonFailure()->getExpectedAsString()));
                }

                $this->assertInstanceOf($expectedExceptionClass, $e);
            }
        }

        // restore original permissions
        chmod($testDir, 0777);
        clearstatcache(true, $testDir);

        if ($couldRead) {
            $this->markTestSkipped('could read test files while test requires unreadable');
        }
    }

    public function testIgnoredAccessDeniedException()
    {
        if ('\\' === \DIRECTORY_SEPARATOR) {
            $this->markTestSkipped('chmod is not supported on Windows');
        }

        $finder = $this->buildFinder();
        $finder->files()->ignoreUnreadableDirs()->in(self::$tmpDir);

        // make 'foo' directory non-readable
        $testDir = self::$tmpDir.\DIRECTORY_SEPARATOR.'foo';
        chmod($testDir, 0333);

        if (false === ($couldRead = is_readable($testDir))) {
            $this->assertIterator($this->toAbsolute([
                'foo bar',
                'test.php',
                'test.py',
                'qux/baz_100_1.py',
                'qux/baz_1_2.py',
                'qux_0_1.php',
                'qux_1000_1.php',
                'qux_1002_0.php',
                'qux_10_2.php',
                'qux_12_0.php',
                'qux_2_0.php',
                ]
            ), $finder->getIterator());
        }

        // restore original permissions
        chmod($testDir, 0777);
        clearstatcache(true, $testDir);

        if ($couldRead) {
            $this->markTestSkipped('could read test files while test requires unreadable');
        }
    }

    /**
     * @group legacy
     * @expectedDeprecation The "Symfony\Component\Finder\Finder::sortByName()" method will have a new "bool $useNaturalSort = false" argument in version 5.0, not defining it is deprecated since Symfony 4.2.
     */
    public function testInheritedClassCallSortByNameWithNoArguments()
    {
        $finderChild = new ClassThatInheritFinder();
        $finderChild->sortByName();
    }

    protected function buildFinder()
    {
        return Finder::create();
    }
}

class ClassThatInheritFinder extends Finder
{
    public function sortByName()
    {
        parent::sortByName();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Gitignore;

class GitignoreTest extends TestCase
{
    /**
     * @dataProvider provider
     *
     * @param string $patterns
     * @param array  $matchingCases
     * @param array  $nonMatchingCases
     */
    public function testCases(string $patterns, array $matchingCases, array $nonMatchingCases)
    {
        $regex = Gitignore::toRegex($patterns);

        foreach ($matchingCases as $matchingCase) {
            $this->assertRegExp($regex, $matchingCase, sprintf('Failed asserting path [%s] matches gitignore patterns [%s] using regex [%s]', $matchingCase, $patterns, $regex));
        }

        foreach ($nonMatchingCases as $nonMatchingCase) {
            $this->assertNotRegExp($regex, $nonMatchingCase, sprintf('Failed asserting path [%s] not matching gitignore patterns [%s] using regex [%s]', $nonMatchingCase, $patterns, $regex));
        }
    }

    /**
     * @return array return is array of
     *               [
     *               [
     *               '', // Git-ignore Pattern
     *               [], // array of file paths matching
     *               [], // array of file paths not matching
     *               ],
     *               ]
     */
    public function provider()
    {
        return [
            [
                '
                    *
                    !/bin/bash
                ',
                ['bin/cat', 'abc/bin/cat'],
                ['bin/bash'],
            ],
            [
                'fi#le.txt',
                [],
                ['#file.txt'],
            ],
            [
                '
                /bin/
                /usr/local/
                !/bin/bash
                !/usr/local/bin/bash
                ',
                ['bin/cat'],
                ['bin/bash'],
            ],
            [
                '*.py[co]',
                ['file.pyc', 'file.pyc'],
                ['filexpyc', 'file.pycx', 'file.py'],
            ],
            [
                'dir1/**/dir2/',
                ['dir1/dirA/dir2/', 'dir1/dirA/dirB/dir2/'],
                [],
            ],
            [
                'dir1/*/dir2/',
                ['dir1/dirA/dir2/'],
                ['dir1/dirA/dirB/dir2/'],
            ],
            [
                '/*.php',
                ['file.php'],
                ['app/file.php'],
            ],
            [
                '\#file.txt',
                ['#file.txt'],
                [],
            ],
            [
                '*.php',
                ['app/file.php', 'file.php'],
                ['file.phps', 'file.phps', 'filephps'],
            ],
            [
                'app/cache/',
                ['app/cache/file.txt', 'app/cache/dir1/dir2/file.txt', 'a/app/cache/file.txt'],
                [],
            ],
            [
                '
                #IamComment
                /app/cache/',
                ['app/cache/file.txt', 'app/cache/subdir/ile.txt'],
                ['a/app/cache/file.txt'],
            ],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Finder\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\Glob;

class GlobTest extends TestCase
{
    public function testGlobToRegexDelimiters()
    {
        $this->assertEquals('#^(?=[^\.])\#$#', Glob::toRegex('#'));
        $this->assertEquals('#^\.[^/]*$#', Glob::toRegex('.*'));
        $this->assertEquals('^\.[^/]*$', Glob::toRegex('.*', true, true, ''));
        $this->assertEquals('/^\.[^/]*$/', Glob::toRegex('.*', true, true, '/'));
    }

    public function testGlobToRegexDoubleStarStrictDots()
    {
        $finder = new Finder();
        $finder->ignoreDotFiles(false);
        $regex = Glob::toRegex('/**/*.neon');

        foreach ($finder->in(__DIR__) as $k => $v) {
            $k = str_replace(\DIRECTORY_SEPARATOR, '/', $k);
            if (preg_match($regex, substr($k, \strlen(__DIR__)))) {
                $match[] = substr($k, 10 + \strlen(__DIR__));
            }
        }
        sort($match);

        $this->assertSame(['one/b/c.neon', 'one/b/d.neon'], $match);
    }

    public function testGlobToRegexDoubleStarNonStrictDots()
    {
        $finder = new Finder();
        $finder->ignoreDotFiles(false);
        $regex = Glob::toRegex('/**/*.neon', false);

        foreach ($finder->in(__DIR__) as $k => $v) {
            $k = str_replace(\DIRECTORY_SEPARATOR, '/', $k);
            if (preg_match($regex, substr($k, \strlen(__DIR__)))) {
                $match[] = substr($k, 10 + \strlen(__DIR__));
            }
        }
        sort($match);

        $this->assertSame(['.dot/b/c.neon', '.dot/b/d.neon', 'one/b/c.neon', 'one/b/d.neon'], $match);
    }

    public function testGlobToRegexDoubleStarWithoutLeadingSlash()
    {
        $finder = new Finder();
        $finder->ignoreDotFiles(false);
        $regex = Glob::toRegex('/Fixtures/one/**');

        foreach ($finder->in(__DIR__) as $k => $v) {
            $k = str_replace(\DIRECTORY_SEPARATOR, '/', $k);
            if (preg_match($regex, substr($k, \strlen(__DIR__)))) {
                $match[] = substr($k, 10 + \strlen(__DIR__));
            }
        }
        sort($match);

        $this->assertSame(['one/a', 'one/b', 'one/b/c.neon', 'one/b/d.neon'], $match);
    }

    public function testGlobToRegexDoubleStarWithoutLeadingSlashNotStrictLeadingDot()
    {
        $finder = new Finder();
        $finder->ignoreDotFiles(false);
        $regex = Glob::toRegex('/Fixtures/one/**', false);

        foreach ($finder->in(__DIR__) as $k => $v) {
            $k = str_replace(\DIRECTORY_SEPARATOR, '/', $k);
            if (preg_match($regex, substr($k, \strlen(__DIR__)))) {
                $match[] = substr($k, 10 + \strlen(__DIR__));
            }
        }
        sort($match);

        $this->assertSame(['one/.dot', 'one/a', 'one/b', 'one/b/c.neon', 'one/b/d.neon'], $match);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               