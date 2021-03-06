<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\ControllerMetadata;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class ArgumentMetadataTest extends TestCase
{
    public function testWithBcLayerWithDefault()
    {
        $argument = new ArgumentMetadata('foo', 'string', false, true, 'default value');

        $this->assertFalse($argument->isNullable());
    }

    public function testDefaultValueAvailable()
    {
        $argument = new ArgumentMetadata('foo', 'string', false, true, 'default value', true);

        $this->assertTrue($argument->isNullable());
        $this->assertTrue($argument->hasDefaultValue());
        $this->assertSame('default value', $argument->getDefaultValue());
    }

    /**
     * @expectedException \LogicException
     */
    public function testDefaultValueUnavailable()
    {
        $argument = new ArgumentMetadata('foo', 'string', false, false, null, false);

        $this->assertFalse($argument->isNullable());
        $this->assertFalse($argument->hasDefaultValue());
        $argument->getDefaultValue();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\DataCollector;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector;
use Symfony\Component\HttpKernel\Kernel;

class ConfigDataCollectorTest extends TestCase
{
    public function testCollect()
    {
        $kernel = new KernelForTest('test', true);
        $c = new ConfigDataCollector();
        $c->setKernel($kernel);
        $c->collect(new Request(), new Response());

        $this->assertSame('test', $c->getEnv());
        $this->assertTrue($c->isDebug());
        $this->assertSame('config', $c->getName());
        $this->assertRegExp('~^'.preg_quote($c->getPhpVersion(), '~').'~', PHP_VERSION);
        $this->assertRegExp('~'.preg_quote((string) $c->getPhpVersionExtra(), '~').'$~', PHP_VERSION);
        $this->assertSame(PHP_INT_SIZE * 8, $c->getPhpArchitecture());
        $this->assertSame(class_exists('Locale', false) && \Locale::getDefault() ? \Locale::getDefault() : 'n/a', $c->getPhpIntlLocale());
        $this->assertSame(date_default_timezone_get(), $c->getPhpTimezone());
        $this->assertSame(Kernel::VERSION, $c->getSymfonyVersion());
        $this->assertNull($c->getToken());
        $this->assertSame(\extension_loaded('xdebug'), $c->hasXDebug());
        $this->assertSame(\extension_loaded('Zend OPcache') && filter_var(ini_get('opcache.enable'), FILTER_VALIDATE_BOOLEAN), $c->hasZendOpcache());
        $this->assertSame(\extension_loaded('apcu') && filter_var(ini_get('apc.enabled'), FILTER_VALIDATE_BOOLEAN), $c->hasApcu());
    }

    /**
     * @group legacy
     * @expectedDeprecation The "$name" argument in method "Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector::__construct()" is deprecated since Symfony 4.2.
     * @expectedDeprecation The "$version" argument in method "Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector::__construct()" is deprecated since Symfony 4.2.
     * @expectedDeprecation The method "Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector::getApplicationName()" is deprecated since Symfony 4.2.
     * @expectedDeprecation The method "Symfony\Component\HttpKernel\DataCollector\ConfigDataCollector::getApplicationVersion()" is deprecated since Symfony 4.2.
     */
    public function testLegacy()
    {
        $c = new ConfigDataCollector('name', null);
        $c->collect(new Request(), new Response());

        $this->assertSame('name', $c->getApplicationName());
        $this->assertNull($c->getApplicationVersion());
    }
}

class KernelForTest extends Kernel
{
    public function registerBundles()
    {
    }

    public function getBundles()
    {
        return [];
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\DataCollector;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Tests\Fixtures\DataCollector\CloneVarDataCollector;
use Symfony\Component\VarDumper\Cloner\VarCloner;

class DataCollectorTest extends TestCase
{
    public function testCloneVarStringWithScheme()
    {
        $c = new CloneVarDataCollector('scheme://foo');
        $c->collect(new Request(), new Response());
        $cloner = new VarCloner();

        $this->assertEquals($cloner->cloneVar('scheme://foo'), $c->getData());
    }

    public function testCloneVarExistingFilePath()
    {
        $c = new CloneVarDataCollector([$filePath = tempnam(sys_get_temp_dir(), 'clone_var_data_collector_')]);
        $c->collect(new Request(), new Response());

        $this->assertSame($filePath, $c->getData()[0]);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\DataCollector;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DumpDataCollector;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Server\Connection;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DumpDataCollectorTest extends TestCase
{
    public function testDump()
    {
        $data = new Data([[123]]);

        $collector = new DumpDataCollector();

        $this->assertSame('dump', $collector->getName());

        $collector->dump($data);
        $line = __LINE__ - 1;
        $this->assertSame(1, $collector->getDumpsCount());

        $dump = $collector->getDumps('html');
        $this->assertArrayHasKey('data', $dump[0]);
        $dump[0]['data'] = preg_replace('/^.*?<pre/', '<pre', $dump[0]['data']);
        $dump[0]['data'] = preg_replace('/sf-dump-\d+/', 'sf-dump', $dump[0]['data']);

        $xDump = [
            [
                'data' => "<pre class=sf-dump id=sf-dump data-indent-pad=\"  \"><span class=sf-dump-num>123</span>\n</pre><script>Sfdump(\"sf-dump\")</script>\n",
                'name' => 'DumpDataCollectorTest.php',
           