INDX( 	 b@�             (     �       e                     A2     h V     92     \aqk��/e� %�\aqk�\aqk�                       
 A n n o t a t i o n u :2     � l     92     /��qk� @�����f ��<�/��qk�       .               C o m p i l e d R o u t e T e s t . p h p     C2     x h     92     �	qk��Vl� %��	qk��	qk�                        D e p e n d e n c y I n j e c t i o n E2     h R     92     \Mqk��"�qk��"�qk��"�qk�                        F i x t u r  s o n t �2     h T     92     XI�qk�I5qk�I5qk�I5qk�                       	 G e n e r a t o r n t 3     ` N     92     �qk��G�� %��qk��qk�                        L o a d e r t 3     ` P     92     ��Z qk��q� qk��q� qk��q� qk�                        M a t c h e r ;2     � n     92     в�qk� @����O���<�в�qk�        �               R e q u e s t C o n t e x t T e s t . p h p   <2     � ~     92     D<�qk� @����O���<�D<�qk� @      �;              R o u t e C o l l e c t i o n B u i l d e r T e s t . p h p   =2     � p     92     Tc�qk� @�����+��<�Tc�qk� @      �;               R o u t e C o l l e c t i o n T e s t . p h p >2     � l     92     !(�qk� @�����+��<�!(�qk� @      9               R o u t e C o m p i l e r T e s t . p h p     ?2     p ^     92     O�qk� @�������<�O�qk�        �               R o u t e r T e s t . p h p   @2     p \     92     ��qk� @�������<���qk� @      X9              R o u t e T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Route;

class RouteTest extends TestCase
{
    public function testConstructor()
    {
        $route = new Route('/{foo}', ['foo' => 'bar'], ['foo' => '\d+'], ['foo' => 'bar'], '{locale}.example.com');
        $this->assertEquals('/{foo}', $route->getPath(), '__construct() takes a path as its first argument');
        $this->assertEquals(['foo' => 'bar'], $route->getDefaults(), '__construct() takes defaults as its second argument');
        $this->assertEquals(['foo' => '\d+'], $route->getRequirements(), '__construct() takes requirements as its third argument');
        $this->assertEquals('bar', $route->getOption('foo'), '__construct() takes options as its fourth argument');
        $this->assertEquals('{locale}.example.com', $route->getHost(), '__construct() takes a host pattern as its fifth argument');

        $route = new Route('/', [], [], [], '', ['Https'], ['POST', 'put'], 'context.getMethod() == "GET"');
        $this->assertEquals(['https'], $route->getSchemes(), '__construct() takes schemes as its sixth argument and lowercases it');
        $this->assertEquals(['POST', 'PUT'], $route->getMethods(), '__construct() takes methods as its seventh argument and uppercases it');
        $this->assertEquals('context.getMethod() == "GET"', $route->getCondition(), '__construct() takes a condition as its eight argument');

        $route = new Route('/', [], [], [], '', 'Https', 'Post');
        $this->assertEquals(['https'], $route->getSchemes(), '__construct() takes a single scheme as its sixth argument');
        $this->assertEquals(['POST'], $route->getMethods(), '__construct() takes a single method as its seventh argument');
    }

    public function testPath()
    {
        $route = new Route('/{foo}');
        $route->setPath('/{bar}');
        $this->assertEquals('/{bar}', $route->getPath(), '->setPath() sets the path');
        $route->setPath('');
        $this->assertEquals('/', $route->getPath(), '->setPath() adds a / at the beginning of the path if needed');
        $route->setPath('bar');
        $this->assertEquals('/bar', $route->getPath(), '->setPath() adds a / at the beginning of the path if needed');
        $this->assertEquals($route, $route->setPath(''), '->setPath() implements a fluent interface');
        $route->setPath('//path');
        $this->assertEquals('/path', $route->getPath(), '->setPath() does not allow two slashes "//" at the beginning of the path as it would be confused with a network path when generating the path from the route');
    }

    public function testOptions()
    {
        $route = new Route('/{foo}');
        $route->setOptions(['foo' => 'bar']);
        $this->assertEquals(array_merge([
        'compiler_class' => 'Symfony\\Component\\Routing\\RouteCompiler',
        ], ['foo' => 'bar']), $route->getOptions(), '->setOptions() sets the options');
        $this->assertEquals($route, $route->setOptions([]), '->setOptions() implements a fluent interface');

        $route->setOptions(['foo' => 'foo']);
        $route->addOptions(['bar' => 'bar']);
        $this->assertEquals($route, $route->addOptions([]), '->addOptions() implements a fluent interface');
        $this->assertEquals(['foo' => 'foo', 'bar' => 'bar', 'compiler_class' => 'Symfony\\Component\\Routing\\RouteCompiler'], $route->getOptions(), '->addDefaults() keep previous defaults');
    }

    public function testOption()
    {
        $route = new Route('/{foo}');
        $this->assertFalse($route->hasOption('foo'), '->hasOption() return false if option is not set');
        $this->assertEquals($route, $route->setOption('foo', 'bar'), '->setOption() implements a fluent interface');
        $this->assertEquals('bar', $route->getOption('foo'), '->setOption() sets the option');
        $this->assertTrue($route->hasOption('foo'), '->hasOption() return true if option is set');
    }

    public function testDefaults()
    {
        $route = new Route('/{foo}');
        $route->setDefaults(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $route->getDefaults(), '->setDefaults() sets the defaults');
        $this->assertEquals($route, $route->setDefaults([]), '->setDefaults() implements a fluent interface');

        $route->setDefault('foo', 'bar');
        $this->assertEquals('bar', $route->getDefault('foo'), '->setDefault() sets a default value');

        $route->setDefault('foo2', 'bar2');
        $this->assertEquals('bar2', $route->getDefault('foo2'), '->getDefault() return the default value');
        $this->assertNull($route->getDefault('not_defined'), '->getDefault() return null if default value is not set');

        $route->setDefault('_controller', $closure = function () { return 'Hello'; });
        $this->assertEquals($closure, $route->getDefault('_controller'), '->setDefault() sets a default value');

        $route->setDefaults(['foo' => 'foo']);
        $route->addDefaults(['bar' => 'bar']);
        $this->assertEquals($route, $route->addDefaults([]), '->addDefaults() implements a fluent interface');
        $this->assertEquals(['foo' => 'foo', 'bar' => 'bar'], $route->getDefaults(), '->addDefaults() keep previous defaults');
    }

    public function testRequirements()
    {
        $route = new Route('/{foo}');
        $route->setRequirements(['foo' => '\d+']);
        $this->assertEquals(['foo' => '\d+'], $route->getRequirements(), '->setRequirements() sets the requirements');
        $this->assertEquals('\d+', $route->getRequirement('foo'), '->getRequirement() returns a requirement');
        $this->assertNull($route->getRequirement('bar'), '->getRequirement() returns null if a requirement is not defined');
        $route->setRequirements(['foo' => '^\d+$']);
        $this->assertEquals('\d+', $route->getRequirement('foo'), '->getRequirement() removes ^ and $ from the path');
        $this->assertEquals($route, $route->setRequirements([]), '->setRequirements() implements a fluent interface');

        $route->setRequirements(['foo' => '\d+']);
        $route->addRequirements(['bar' => '\d+']);
        $this->assertEquals($route, $route->addRequirements([]), '->addRequirements() implements a fluent interface');
        $this->assertEquals(['foo' => '\d+', 'bar' => '\d+'], $route->getRequirements(), '->addRequirement() keep previous requirements');
    }

    public function testRequirement()
    {
        $route = new Route('/{foo}');
        $this->assertFalse($route->hasRequirement('foo'), '->hasRequirement() return false if requirement is not set');
        $route->setRequirement('foo', '^\d+$');
        $this->assertEquals('\d+', $route->getRequirement('foo'), '->setRequirement() removes ^ and $ from the path');
        $this->assertTrue($route->hasRequirement('foo'), '->hasRequirement() return true if requirement is set');
    }

    /**
     * @dataProvider getInvalidRequirements
     * @expectedException \InvalidArgumentException
     */
    public function testSetInvalidRequirement($req)
    {
        $route = new Route('/{foo}');
        $route->setRequirement('foo', $req);
    }

    public function getInvalidRequirements()
    {
        return [
           [''],
           [[]],
           ['^$'],
           ['^'],
           ['$'],
        ];
    }

    public function testHost()
    {
        $route = new Route('/');
  