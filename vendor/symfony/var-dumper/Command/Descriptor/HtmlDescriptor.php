<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Tests\Command\Descriptor;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\VarDumper\Cloner\Data;
use Symfony\Component\VarDumper\Command\Descriptor\HtmlDescriptor;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;

class HtmlDescriptorTest extends TestCase
{
    private static $timezone;

    public static function setUpBeforeClass()
    {
        self::$timezone = date_default_timezone_get();
        date_default_timezone_set('UTC');
    }

    public static function tearDownAfterClass()
    {
        date_default_timezone_set(self::$timezone);
    }

    public function testItOutputsStylesAndScriptsOnFirstDescribeCall()
    {
        $output = new BufferedOutput();
        $dumper = $this->createMock(HtmlDumper::class);
        $dumper->method('dump')->willReturn('[DUMPED]');
        $descriptor = new HtmlDescriptor($dumper);

        $descriptor->describe($output, new Data([[123]]), ['timestamp' => 1544804268.3668], 1);

        $this->assertStringMatchesFormat('<style>%A</style><script>%A</script>%A', $output->fetch(), 'styles & scripts are output');

        $descriptor->describe($output, new Data([[123]]), ['timestamp' => 1544804268.3668], 1);

        $this->assertStringNotMatchesFormat('<style>%A</style><script>%A</script>%A', $output->fetch(), 'styles & scripts are output only once');
    }

    /**
     * @dataProvider provideContext
     */
    public function testDescribe(array $context, string $expectedOutput)
    {
        $output = new BufferedOutput();
        $dumper = $this->createMock(HtmlDumper::class);
        $dumper->method('dump')->willReturn('[DUMPED]');
        $descriptor = new HtmlDescriptor($dumper);

        $descriptor->describe($output, new Data([[123]]), $context + ['timestamp' => 1544804268.3668], 1);

        $this->assertStringMatchesFormat(trim($expectedOutput), trim(preg_replace('@<style>.*</style><script>.*</script>@s', '', $output->fetch())));
    }

    public function provideContext()
    {
        yield 'source' => [
            [
                'source' => [
                    'name' => 'CliDescriptorTest.php',
                    'line' => 30,
                    'file' => '/Users/ogi/symfony/src/Symfony/Component/VarDumper/Tests/Command/Descriptor/CliDescriptorTest.php',
                ],
            ],
            <<<TXT
<article data-dedup-id="%s">
    <header>
        <div class="row">
            <h2 class="col">-</h2>
            <time class="col text-small" title="2018-12-14T16:17:48+00:00" datetime="2018-12-14T16:17:48+00:00">
                Fri, 14 Dec 2018 16:17:48 +0000
            </time>
        </div>
        
    </header>
    <section class="body">
        <p class="text-small">
            CliDescriptorTest.php on line 30
        </p>
        [DUMPED]
    </section>
</article>
TXT
        ];

        yield 'source full' => [
            [
                'source' => [
                    'name' => 'CliDescriptorTest.php',
                    'project_dir' => 'src/Symfony/',
                    'line' => 30,
                    'file_relative' => 'src/Symfony/Component/VarDumper/Tests/Command/Descriptor/CliDescriptorTest.php',
                    'file' => '/Users/ogi/symfony/src/Symfony/Component/VarDumper/Tests/Command/Descriptor/CliDescriptorTest.php',
                    'file_link' => 'phpstorm://open?file=/Users/ogi/sy