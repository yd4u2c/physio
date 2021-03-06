(['string', ''], $array[$i++]);
        $this->assertSame(['float', INF], $array[$i++]);

        // assertEquals() does not like NAN values.
        $this->assertEquals($array[$i][0], 'float');
        $this->assertTrue(is_nan($array[$i++][1]));
    }

    public function testRecursionInArguments()
    {
        $a = null;
        $a = ['foo', [2, &$a]];
        $exception = $this->createException($a);

        $flattened = FlattenException::create($exception);
        $trace = $flattened->getTrace();
        $this->assertContains('*DEEP NESTED ARRAY*', serialize($trace));
    }

    public function testTooBigArray()
    {
        $a = [];
        for ($i = 0; $i < 20; ++$i) {
            for ($j = 0; $j < 50; ++$j) {
                for ($k = 0; $k < 10; ++$k) {
                    $a[$i][$j][$k] = 'value';
                }
            }
        }
        $a[20] = 'value';
        $a[21] = 'value1';
        $exception = $this->createException($a);

        $flattened = FlattenException::create($exception);
        $trace = $flattened->getTrace();

        $this->assertSame($trace[1]['args'][0], ['array', ['array', '*SKIPPED over 10000 entries*']]);

        $serializeTrace = serialize($trace);

        $this->assertContains('*SKIPPED over 10000 entries*', $serializeTrace);
        $this->assertNotContains('*value1*', $serializeTrace);
    }

    public function testAnonymousClass()
    {
        $flattened = FlattenException::create(new class() extends \RuntimeException {
        });

        $this->assertSame('RuntimeException@anonymous', $flattened->getClass());

        $flattened = FlattenException::create(new \Exception(sprintf('Class "%s" blah.', \get_class(new class() extends \RuntimeException {
        }))));

        $this->assertSame('Class "RuntimeException@anonymous" blah.', $flattened->getMessage());
    }

    private function createException($foo)
    {
        return new \Exception();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Debug\Tests\FatalErrorHandler;

use Composer\Autoload\ClassLoader as ComposerClassLoader;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Debug\DebugClassLoader;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\Debug\FatalErrorHandler\ClassNotFoundFatalErrorHandler;

class ClassNotFoundFatalErrorHandlerTest extends TestCase
{
    public static function setUpBeforeClass()
    {
        foreach (spl_autoload_functions() as $function) {
            if (!\is_array($function)) {
                continue;
            }

            // get class loaders wrapped by DebugClassLoader
            if ($function[0] instanceof DebugClassLoader) {
                $function = $function[0]->getClassLoader();
            }

            if ($function[0] instanceof ComposerClassLoader) {
                $function[0]->add('Symfony_Component_Debug_Tests_Fixtures', \dirname(\dirname(\dirname(\dirname(\dirname(__DIR__))))));
                break;
            }
        }
    }

    /**
     * @dataProvider provideClassNotFoundData
     */
    public function testHandleClassNotFound($error, $translatedMessage, $autoloader = null)
    {
        if ($autoloader) {
            // Unregister all autoloaders to ensure the custom provided
            // autoloader is the only one to be used during the test run.
            $autoloaders = spl_autoload_functions();
            array_map('spl_autoload_unregister', $autoloaders);
          