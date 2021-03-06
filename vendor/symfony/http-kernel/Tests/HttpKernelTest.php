<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DependencyInjection\LazyLoadingFragmentHandler;

class LazyLoadingFragmentHandlerTest extends TestCase
{
    public function testRender()
    {
        $renderer = $this->getMockBuilder('Symfony\Component\HttpKernel\Fragment\FragmentRendererInterface')->getMock();
        $renderer->expects($this->once())->method('getName')->will($this->returnValue('foo'));
        $renderer->expects($this->any())->method('render')->will($this->returnValue(new Response()));

        $requestStack = $this->getMockBuilder('Symfony\Component\HttpFoundation\RequestStack')->getMock();
        $requestStack->expects($this->any())->method('getCurrentRequest')->will($this->returnValue(Request::create('/')));

        $container = $this->getMockBuilder('Psr\Container\ContainerInterface')->getMock();
        $container->expects($this->once())->method('has')->with('foo')->willReturn(true);
        $container->expects($this->once())->method('get')->will($this->returnValue($renderer));

        $handler = new LazyLoadingFragmentHandler($container, $requestStack, false);

        $handler->render('/foo', 'foo');

        // second call should not lazy-load anymore (see once() above on the get() method)
        $handler->render('/foo', 'foo');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         INDX( 	 �֩             (   �  �       s ��                `0     � �     _0     �qk� �V0e �u���<��qk�        7              & A d d A n n o t a t e d C l a s s e s T o C a c h e P a s s T e s t . p h p   a0     � �     _0     [T�qk� �V0e �m���<�[T�qk�        Z              + C o n t r o l l e r A r g u m e n t V a l u e R e s o l v e r P a s s T e s t . p h p b0     � z     _0     M{ qk� �V0e �"Т��<�M{ qk�       T
               F r a g m e n t R e n d e r e r P a  s T e s t . p h p       c0     � �     _0     �qk� �V0e ��1���<��qk�       �              " L a z y L o a d i n g F r a g m e n t H a n d l e r T e s t . p h p   d0     x f     _0     �
qk� �V0e ��1���<��
qk�       D               L o g g e r P a s s T e s t . p h p   e0     � �     _0     ��qk� �V0e ������<���qk�       �              ' M e r g e E x t e n s i o n C o n f i g u r a t i o n P a s s T e s t . p h p f0     � �     _0     ��qk� �V0e �3����<���qk  P      �C              . R e g i s t e r C o n t r o l l e r A r g u m e n t L o c a t o r s P a s s T e s t . p h p   g0     � �     _0     bRqk�k � %�k � %�bRqk�       _              ' R e g i s t e r L o c a l e A w a r e S e r v i c e s P a s s T e s t . p h p h0     � �     _0     ��!qk� �V0e �3����<���!qk�        I              1 R e m o v e E m p t y C o n t r o l l e r A r g u m e n t L o c a t o r s P a s s T e s t . p h p     i0     � |     _0     ��&qk� �V0e ��Y���< ��&qk�       L               R e s e t t a b l e S e r v i c e P a s s T e s t . p h p     j0     � r     _0     �)qk� �V0e ������<��)qk�       �               S e r v i c e s R e s e t t e r T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\LoggerPass;
use Symfony\Component\HttpKernel\Log\Logger;

/**
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class LoggerPassTest extends TestCase
{
    public function testAlwaysSetAutowiringAlias()
    {
        $container = new ContainerBuilder();
        $container->register('logger', 'Foo');

        (new LoggerPass())->process($container);

        $this->assertFalse($container->getAlias(LoggerInterface::class)->isPublic());
    }

    public function testDoNotOverrideExistingLogger()
    {
        $container = new ContainerBuilder();
        $container->register('logger', 'Foo');

        (new LoggerPass())->process($container);

        $this->assertSame('Foo', $container->getDefinition('logger')->getClass());
    }

    public function testRegisterLogger()
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.debug', false);

        (new LoggerPass())->process($container);

        $definition = $container->getDefinition('logger');
        $this->assertSame(Logger::class, $definition->getClass());
        $this->assertFalse($definition->isPublic());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\HttpKernel\DependencyInjection\MergeExtensionConfigurationPass;

class MergeExtensionConfigurationPassTest extends TestCase
{
    public function testAutoloadMainExtension()
    {
        $container = new ContainerBuilder();
        $container->registerExtension(new LoadedExtension());
        $container->registerExtension(new NotLoadedExtension());
        $container->loadFromExtension('loaded', []);

        $configPass = new MergeExtensionConfigurationPass(['loaded', 'not_loaded']);
        $configPass->process($container);

        $this->assertTrue($container->hasDefinition('loaded.foo'));
        $this->assertTrue($container->hasDefinition('not_loaded.bar'));
    }
}

class LoadedExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->register('loaded.foo');
    }
}

class NotLoadedExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->register('not_loaded.bar');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           