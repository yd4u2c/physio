<?php

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherTrait;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    use PhpMatcherTrait;

    public function __construct(RequestContext $context)
    {
        $this->context = $context;
        $this->regexpList = [
            0 => '{^(?'
                    .'|/(a)(*:11)'
                .')/?$}sD',
            11 => '{^(?'
                    .'|/(.)(*:22)'
                .')/?$}sDu',
            22 => '{^(?'
                    .'|/(.)(*:33)'
                .')/?$}sD',
        ];
        $this->dynamicRoutes = [
            11 => [[['_route' => 'a'], ['a'], null, null, false, true, null]],
            22 => [[['_route' => 'b'], ['a'], null, null, false, true, null]],
            33 => [[['_route' => 'c'], ['a'], null, null, false, true, null]],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherTrait;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class ProjectUrlMatcher extends Symfony\Component\Routing\Matcher\UrlMatcher
{
    use PhpMatcherTrait;

    public function __construct(RequestContext $context)
    {
        $this->context = $context;
        $this->matchHost = true;
        $this->staticRoutes = [
            '/' => [
                [['_route' => 'a'], '#^(?P<d>[^\\.]++)\\.e\\.c\\.b\\.a$#sDi', null, null, false, false, null],
                [['_route' => 'c'], '#^(?P<e>[^\\.]++)\\.e\\.c\\.b\\.a$#sDi', null, null, false, false, null],
                [['_route' => 'b'], 'd.c.b.a', null, null, false, false, null],
            ],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        INDX( 	 	�             (   �  �         l                   �2     ` P     �2     ϔ|qk� @����{o��<�ϔ|qk�h      g               b a r . x m l �2     ` P     �2     �Y�qk� @��������<��Y�qk�P       P                b a r . y m l �2     ` P     �2     ߻�qk� @����Q3��<�߻�qk�h      g               b a z . x m l �2     ` P     �2     �qk� @����Q3��<��qk�P       P                b a z . y m l �2     x h     �2     ���qk� @����}���<����qk�@     @               i m p o r t _ m u l t i p l e . x m l �2     x h     �2     ��qk� @�������<���qk�                        i m p o r t _ m u l t i p l e . y m l �2     x d     �2     F�qk� @����?[��<�F�qk�@      @               i m p o r t _ s i n g l e . x m l     �2     x d     �2     ���qk� @����?[��<����qk�                        i m p o r t _ s i n g l e . y m l     �2     h X     �2     Zl�qk� @��������<�Zl�qk��       �                p h p _ d s  . p h p �2     p `     �2     1�qk� @����/��<�1�qk�                      p h p _ d s l _ b a r . p h p �2     p `     �2     ��qk� @����/��<���qk�                      p h p _ d s l _ b a z . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 INDX( 	 %#�             (   @  �       l e m ��l           �2     � �     �2     ��qk� @�����D��<���qk��      �              * i m p o r t e d - w i t h - l o c a l e - b u t - n o t - l o c a l i z e d . x m l   �2     � �     �2     �j�qk� @����b
G��<��j�qk�X       Q               * i m p o r t e d - w i t h - l o c a l e - b u t - n o t - l o c a l i z e d . y m l   �2     � r     �2     �/�qk� @�����lI��<��/�qk��      �               i m p o r t e d - w i t h -  o c a l e . x m l       �2     � r     �2     �u�qk� @�����lI��<��u�qk�x       s                i m p o r t e d - w i t h - l o c a l e . y m l       �2     � n     �2     Q9�qk��N&� %��N&� %�Q9�qk��       �                i m p o r t e d - w i t h - u t f 8 . p h p   �2     � n     �2     ���qk��(� %��(� %����qk�8      3               i m p o r t e d - w i t h - u t f 8 . x m l   �2     � n     �2     ra�qk��(� %��(� %�ra�qk�8       3                i m p o r t  d - w i t h - u t f 8 . y m l   �2     � �     �2     n��qk� @�����K��<�n��qk�x       t               $ i m p o r t e r - w i t h - c o n t r o l l e r - d e f a u l t . y m l       �2     � �     �2      L�qk� @�����0N��<� L�qk��      �              4 i m p o r t e r - w i t h - l o c a l e - i m p o r t s - n o n - l o c a l i z e d - r o u t e . x m l       �2     � �     �2     ���qk� @������P��<����qk�x       s               4 i m p o r t e r - w i t h - l o c a l e - i  p o r t s - n o n - l o c a l i z e d - r o u t e . y m l       �2     � r     �2     0s�qk� @������P��<�0s�qk��      �               i m p o r t e r - w i t h - l o c a l e . x m l       �2     � r     �2     �8�qk� @����/�R��<��8�qk�h       a                i m p o r t e r - w i t h - l o c a l e . y m l       �2     � n     �2     ���qk��u-� %��u-� %����qk��       �                i m p o r t e r - w i t h - u t f 8 . p h p   �2     � n     �2     g��qk�"�/� %�"�/� % g��qk�`      Z               i m p o r t e r - w i t h - u t f 8 . x m l   �2     � n     �2     ��qk�"�/� %�"�/� %���qk�H       A                i m p o r t e r - w i t h - u t f 8 . y m l   �2     � |     �2     m��qk� @�����WU��<�m��qk�0       0                i m p o r t i n g - l o c a l i z e d - r o u t e . y m l     �2     x h     �2     4��qk� @����
�W��<�4��qk��       �                l o c a l i z e d - r o u t e . y m l �2     � ~     �2     x�qk� @��� 
�W��<�x�qk�h       c                m i s s i n g - l o c a l e - i n - i m p o r t e r . y m l   �2     x d     �2     �r�qk� @����sZ��<��r�qk�@       :                n o t - l o c a l i z e d . y m l     �2     � �     �2     �6�qk� @�����~\��<��6�qk��       �                 o f f i c i a l l y _ f o r m a t t e d _ l o c a l e s . y m l       �2     � �     �2     ��qk� @�����^��<���qk�0       *               ! r o u t e - w i t h o u t - p a t h - o r - l o c a  e s . y m l     �2     h R     �2     F��qk��a9� %��a9� %�F��qk��       �                u t f 8 . p h p       �2     h R     �2     �]�qk� @�����^��<��]�qk��      �               u t f 8 . x m l       �2     h R     �2     ���qk�>&>� %�>&>� %����qk�P       I                u t f 8 . y m l                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Generator;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class UrlGeneratorTest extends TestCase
{
    public function testAbsoluteUrlWithPort80()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes)->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $this->assertEquals('http://localhost/app.php/testing', $url);
    }

    public function testAbsoluteSecureUrlWithPort443()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes, ['scheme' => 'https'])->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $this->assertEquals('https://localhost/app.php/testing', $url);
    }

    public function testAbsoluteUrlWithNonStandardPort()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes, ['httpPort' => 8080])->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $this->assertEquals('http://localhost:8080/app.php/testing', $url);
    }

    public function testAbsoluteSecureUrlWithNonStandardPort()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes, ['httpsPort' => 8080, 'scheme' => 'https'])->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $this->assertEquals('https://localhost:8080/app.php/testing', $url);
    }

    public function testRelativeUrlWithoutParameters()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes)->generate('test', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('/app.php/testing', $url);
    }

    public function testRelativeUrlWithParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}'));
        $url = $this->getGenerator($routes)->generate('test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('/app.php/testing/bar', $url);
    }

    public function testRelativeUrlWithNullParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing.{format}', ['format' => null]));
        $url = $this->getGenerator($routes)->generate('test', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('/app.php/testing', $url);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testRelativeUrlWithNullParameterButNotOptional()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}/bar', ['foo' => null]));
        // This must raise an exception because the default requirement for "foo" is "[^/]+" which is not met with these params.
        // Generating path "/testing//bar" would be wrong as matching this route would fail.
        $this->getGenerator($routes)->generate('test', [], UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    public function testRelativeUrlWithOptionalZeroParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{page}'));
        $url = $this->getGenerator($routes)->generate('test', ['page' => 0], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('/app.php/testing/0', $url);
    }

    public function testNotPassedOptionalParameterInBetween()
    {
        $routes = $this->getRoutes('test', new Route('/{slug}/{page}', ['slug' => 'index', 'page' => 0]));
        $this->assertSame('/app.php/index/1', $this->getGenerator($routes)->generate('test', ['page' => 1]));
        $this->assertSame('/app.php/', $this->getGenerator($routes)->generate('test'));
    }

    public function testRelativeUrlWithExtraParameters()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes)->generate('test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('/app.php/testing?foo=bar', $url);
    }

    public function testAbsoluteUrlWithExtraParameters()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes)->generate('test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL);

        $this->assertEquals('http://localhost/app.php/testing?foo=bar', $url);
    }

    public function testUrlWithNullExtraParameters()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes)->generate('test', ['foo' => null], UrlGeneratorInterface::ABSOLUTE_URL);

        $this->assertEquals('http://localhost/app.php/testing', $url);
    }

    public function testUrlWithExtraParametersFromGlobals()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $generator = $this->getGenerator($routes);
        $context = new RequestContext('/app.php');
        $context->setParameter('bar', 'bar');
        $generator->setContext($context);
        $url = $generator->generate('test', ['foo' => 'bar']);

        $this->assertEquals('/app.php/testing?foo=bar', $url);
    }

    public function testUrlWithGlobalParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}'));
        $generator = $this->getGenerator($routes);
        $context = new RequestContext('/app.php');
        $context->setParameter('foo', 'bar');
        $generator->setContext($context);
        $url = $generator->generate('test', []);

        $this->assertEquals('/app.php/testing/bar', $url);
    }

    public function testGlobalParameterHasHigherPriorityThanDefault()
    {
        $routes = $this->getRoutes('test', new Route('/{_locale}', ['_locale' => 'en']));
        $generator = $this->getGenerator($routes);
        $context = new RequestContext('/app.php');
        $context->setParameter('_locale', 'de');
        $generator->setContext($context);
        $url = $generator->generate('test', []);

        $this->assertSame('/app.php/de', $url);
    }

    public function testGenerateWithDefaultLocale()
    {
        $routes = new RouteCollection();

        $route = new Route('');

        $name = 'test';

        foreach (['hr' => '/foo', 'en' => '/bar'] as $locale => $path) {
            $localizedRoute = clone $route;
            $localizedRoute->setDefault('_locale', $locale);
            $localizedRoute->setDefault('_canonical_route', $name);
            $localizedRoute->setPath($path);
            $routes->add($name.'.'.$locale, $localizedRoute);
        }

        $generator = $this->getGenerator($routes, [], null, 'hr');

        $this->assertSame(
            'http://localhost/app.php/foo',
            $generator->generate($name, [], UrlGeneratorInterface::ABSOLUTE_URL)
        );
    }

    public function testGenerateWithOverriddenParameterLocale()
    {
        $routes = new RouteCollection();

        $route = new Route('');

        $name = 'test';

        foreach (['hr' => '/foo', 'en' => '/bar'] as $locale => $path) {
            $localizedRoute = clone $route;
            $localizedRoute->setDefault('_locale', $locale);
            $localizedRoute->setDefault('_canonical_route', $name);
            $localizedRoute->setPath($path);
            $routes->add($name.'.'.$locale, $localizedRoute);
        }

        $generator = $this->getGenerator($routes, [], null, 'hr');

        $this->assertSame(
            'http://localhost/app.php/bar',
            $generator->generate($name, ['_locale' => 'en'], UrlGeneratorInterface::ABSOLUTE_URL)
        );
    }

    public function testGenerateWithOverriddenParameterLocaleFromRequestContext()
    {
        $routes = new RouteCollection();

        $route = new Route('');

        $name = 'test';

        foreach (['hr' => '/foo', 'en' => '/bar'] as $locale => $path) {
            $localizedRoute = clone $route;
            $localizedRoute->setDefault('_locale', $locale);
            $localizedRoute->setDefault('_canonical_route', $name);
            $localizedRoute->setPath($path);
            $routes->add($name.'.'.$locale, $localizedRoute);
        }

        $generator = $this->getGenerator($routes, [], null, 'hr');

        $context = new RequestContext('/app.php');
        $context->setParameter('_locale', 'en');
        $generator->setContext($context);

        $this->assertSame(
            'http://localhost/app.php/bar',
            $generator->generate($name, [], UrlGeneratorInterface::ABSOLUTE_URL)
        );
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function testGenerateWithoutRoutes()
    {
        $routes = $this->getRoutes('foo', new Route('/testing/{foo}'));
        $this->getGenerator($routes)->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function testGenerateWithInvalidLocale()
    {
        $routes = new RouteCollection();

        $route = new Route('');

        $name = 'test';

        foreach (['hr' => '/foo', 'en' => '/bar'] as $locale => $path) {
            $localizedRoute = clone $route;
            $localizedRoute->setDefault('_locale', $locale);
            $localizedRoute->setDefault('_canonical_route', $name);
            $localizedRoute->setPath($path);
            $routes->add($name.'.'.$locale, $localizedRoute);
        }

        $generator = $this->getGenerator($routes, [], null, 'fr');
        $generator->generate($name);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     */
    public function testGenerateForRouteWithoutMandatoryParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}'));
        $this->getGenerator($routes)->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testGenerateForRouteWithInvalidOptionalParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}', ['foo' => '1'], ['foo' => 'd+']));
        $this->getGenerator($routes)->generate('test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testGenerateForRouteWithInvalidParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}', [], ['foo' => '1|2']));
        $this->getGenerator($routes)->generate('test', ['foo' => '0'], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function testGenerateForRouteWithInvalidOptionalParameterNonStrict()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}', ['foo' => '1'], ['foo' => 'd+']));
        $generator = $this->getGenerator($routes);
        $generator->setStrictRequirements(false);
        $this->assertNull($generator->generate('test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL));
    }

    public function testGenerateForRouteWithInvalidOptionalParameterNonStrictWithLogger()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}', ['foo' => '1'], ['foo' => 'd+']));
        $logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();
        $logger->expects($this->once())
            ->method('error');
        $generator = $this->getGenerator($routes, [], $logger);
        $generator->setStrictRequirements(false);
        $this->assertNull($generator->generate('test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL));
    }

    public function testGenerateForRouteWithInvalidParameterButDisabledRequirementsCheck()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}', ['foo' => '1'], ['foo' => 'd+']));
        $generator = $this->getGenerator($routes);
        $generator->setStrictRequirements(null);
        $this->assertSame('/app.php/testing/bar', $generator->generate('test', ['foo' => 'bar']));
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testGenerateForRouteWithInvalidMandatoryParameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}', [], ['foo' => 'd+']));
        $this->getGenerator($routes)->generate('test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testGenerateForRouteWithInvalidUtf8Parameter()
    {
        $routes = $this->getRoutes('test', new Route('/testing/{foo}', [], ['foo' => '\pL+'], ['utf8' => true]));
        $this->getGenerator($routes)->generate('test', ['foo' => 'abc123'], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testRequiredParamAndEmptyPassed()
    {
        $routes = $this->getRoutes('test', new Route('/{slug}', [], ['slug' => '.+']));
        $this->getGenerator($routes)->generate('test', ['slug' => '']);
    }

    public function testSchemeRequirementDoesNothingIfSameCurrentScheme()
    {
        $routes = $this->getRoutes('test', new Route('/', [], [], [], '', ['http']));
        $this->assertEquals('/app.php/', $this->getGenerator($routes)->generate('test'));

        $routes = $this->getRoutes('test', new Route('/', [], [], [], '', ['https']));
        $this->assertEquals('/app.php/', $this->getGenerator($routes, ['scheme' => 'https'])->generate('test'));
    }

    public function testSchemeRequirementForcesAbsoluteUrl()
    {
        $routes = $this->getRoutes('test', new Route('/', [], [], [], '', ['https']));
        $this->assertEquals('https://localhost/app.php/', $this->getGenerator($routes)->generate('test'));

        $routes = $this->getRoutes('test', new Route('/', [], [], [], '', ['http']));
        $this->assertEquals('http://localhost/app.php/', $this->getGenerator($routes, ['scheme' => 'https'])->generate('test'));
    }

    public function testSchemeRequirementCreatesUrlForFirstRequiredScheme()
    {
        $routes = $this->getRoutes('test', new Route('/', [], [], [], '', ['Ftp', 'https']));
        $this->assertEquals('ftp://localhost/app.php/', $this->getGenerator($routes)->generate('test'));
    }

    public function testPathWithTwoStartingSlashes()
    {
        $routes = $this->getRoutes('test', new Route('//path-and-not-domain'));

        // this must not generate '//path-and-not-domain' because that would be a network path
        $this->assertSame('/path-and-not-domain', $this->getGenerator($routes, ['BaseUrl' => ''])->generate('test'));
    }

    public function testNoTrailingSlashForMultipleOptionalParameters()
    {
        $routes = $this->getRoutes('test', new Route('/category/{slug1}/{slug2}/{slug3}', ['slug2' => null, 'slug3' => null]));

        $this->assertEquals('/app.php/category/foo', $this->getGenerator($routes)->generate('test', ['slug1' => 'foo']));
    }

    public function testWithAnIntegerAsADefaultValue()
    {
        $routes = $this->getRoutes('test', new Route('/{default}', ['default' => 0]));

        $this->assertEquals('/app.php/foo', $this->getGenerator($routes)->generate('test', ['default' => 'foo']));
    }

    public function testNullForOptionalParameterIsIgnored()
    {
        $routes = $this->getRoutes('test', new Route('/test/{default}', ['default' => 0]));

        $this->assertEquals('/app.php/test', $this->getGenerator($routes)->generate('test', ['default' => null]));
    }

    public function testQueryParamSameAsDefault()
    {
        $routes = $this->getRoutes('test', new Route('/test', ['page' => 1]));

        $this->assertSame('/app.php/test?page=2', $this->getGenerator($routes)->generate('test', ['page' => 2]));
        $this->assertSame('/app.php/test', $this->getGenerator($routes)->generate('test', ['page' => 1]));
        $this->assertSame('/app.php/test', $this->getGenerator($routes)->generate('test', ['page' => '1']));
        $this->assertSame('/app.php/test', $this->getGenerator($routes)->generate('test'));
    }

    public function testArrayQueryParamSameAsDefault()
    {
        $routes = $this->getRoutes('test', new Route('/test', ['array' => ['foo', 'bar']]));

        $this->assertSame('/app.php/test?array%5B0%5D=bar&array%5B1%5D=foo', $this->getGenerator($routes)->generate('test', ['array' => ['bar', 'foo']]));
        $this->assertSame('/app.php/test?array%5Ba%5D=foo&array%5Bb%5D=bar', $this->getGenerator($routes)->generate('test', ['array' => ['a' => 'foo', 'b' => 'bar']]));
        $this->assertSame('/app.php/test', $this->getGenerator($routes)->generate('test', ['array' => ['foo', 'bar']]));
        $this->assertSame('/app.php/test', $this->getGenerator($routes)->generate('test', ['array' => [1 => 'bar', 0 => 'foo']]));
        $this->assertSame('/app.php/test', $this->getGenerator($routes)->generate('test'));
    }

    public function testGenerateWithSpecialRouteName()
    {
        $routes = $this->getRoutes('$péß^a|', new Route('/bar'));

        $this->assertSame('/app.php/bar', $this->getGenerator($routes)->generate('$péß^a|'));
    }

    public function testUrlEncoding()
    {
        $expectedPath = '/app.php/@:%5B%5D/%28%29*%27%22%20+,;-._~%26%24%3C%3E|%7B%7D%25%5C%5E%60!%3Ffoo=bar%23id'
            .'/@:%5B%5D/%28%29*%27%22%20+,;-._~%26%24%3C%3E|%7B%7D%25%5C%5E%60!%3Ffoo=bar%23id'
            .'?query=%40%3A%5B%5D/%28%29%2A%27%22%20%2B%2C%3B-._~%26%24%3C%3E%7C%7B%7D%25%5C%5E%60%21%3Ffoo%3Dbar%23id';

        // This tests the encoding of reserved characters that are used for delimiting of URI components (defined in RFC 3986)
        // and other special ASCII chars. These chars are tested as static text path, variable path and query param.
        $chars = '@:[]/()*\'" +,;-._~&$<>|{}%\\^`!?foo=bar#id';
        $routes = $this->getRoutes('test', new Route("/$chars/{varpath}", [], ['varpath' => '.+']));
        $this->assertSame($expectedPath, $this->getGenerator($routes)->generate('test', [
            'varpath' => $chars,
            'query' => $chars,
        ]));
    }

    public function testEncodingOfRelativePathSegments()
    {
        $routes = $this->getRoutes('test', new Route('/dir/../dir/..'));
        $this->assertSame('/app.php/dir/%2E%2E/dir/%2E%2E', $this->getGenerator($routes)->generate('test'));
        $routes = $this->getRoutes('test', new Route('/dir/./dir/.'));
        $this->assertSame('/app.php/dir/%2E/dir/%2E', $this->getGenerator($routes)->generate('test'));
        $routes = $this->getRoutes('test', new Route('/a./.a/a../..a/...'));
        $this->assertSame('/app.php/a./.a/a../..a/...', $this->getGenerator($routes)->generate('test'));
    }

    public function testAdjacentVariables()
    {
        $routes = $this->getRoutes('test', new Route('/{x}{y}{z}.{_format}', ['z' => 'default-z', '_format' => 'html'], ['y' => '\d+']));
        $generator = $this->getGenerator($routes);
        $this->assertSame('/app.php/foo123', $generator->generate('test', ['x' => 'foo', 'y' => '123']));
        $this->assertSame('/app.php/foo123bar.xml', $generator->generate('test', ['x' => 'foo', 'y' => '123', 'z' => 'bar', '_format' => 'xml']));

        // The default requirement for 'x' should not allow the separator '.' in this case because it would otherwise match everything
        // and following optional variables like _format could never match.
        $this->{method_exists($this, $_ = 'expectException') ? $_ : 'setExpectedException'}('Symfony\Component\Routing\Exception\InvalidParameterException');
        $generator->generate('test', ['x' => 'do.t', 'y' => '123', 'z' => 'bar', '_format' => 'xml']);
    }

    public function testOptionalVariableWithNoRealSeparator()
    {
        $routes = $this->getRoutes('test', new Route('/get{what}', ['what' => 'All']));
        $generator = $this->getGenerator($routes);

        $this->assertSame('/app.php/get', $generator->generate('test'));
        $this->assertSame('/app.php/getSites', $generator->generate('test', ['what' => 'Sites']));
    }

    public function testRequiredVariableWithNoRealSeparator()
    {
        $routes = $this->getRoutes('test', new Route('/get{what}Suffix'));
        $generator = $this->getGenerator($routes);

        $this->assertSame('/app.php/getSitesSuffix', $generator->generate('test', ['what' => 'Sites']));
    }

    public function testDefaultRequirementOfVariable()
    {
        $routes = $this->getRoutes('test', new Route('/{page}.{_format}'));
        $generator = $this->getGenerator($routes);

        $this->assertSame('/app.php/index.mobile.html', $generator->generate('test', ['page' => 'index', '_format' => 'mobile.html']));
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testDefaultRequirementOfVariableDisallowsSlash()
    {
        $routes = $this->getRoutes('test', new Route('/{page}.{_format}'));
        $this->getGenerator($routes)->generate('test', ['page' => 'index', '_format' => 'sl/ash']);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testDefaultRequirementOfVariableDisallowsNextSeparator()
    {
        $routes = $this->getRoutes('test', new Route('/{page}.{_format}'));
        $this->getGenerator($routes)->generate('test', ['page' => 'do.t', '_format' => 'html']);
    }

    public function testWithHostDifferentFromContext()
    {
        $routes = $this->getRoutes('test', new Route('/{name}', [], [], [], '{locale}.example.com'));

        $this->assertEquals('//fr.example.com/app.php/Fabien', $this->getGenerator($routes)->generate('test', ['name' => 'Fabien', 'locale' => 'fr']));
    }

    public function testWithHostSameAsContext()
    {
        $routes = $this->getRoutes('test', new Route('/{name}', [], [], [], '{locale}.example.com'));

        $this->assertEquals('/app.php/Fabien', $this->getGenerator($routes, ['host' => 'fr.example.com'])->generate('test', ['name' => 'Fabien', 'locale' => 'fr']));
    }

    public function testWithHostSameAsContextAndAbsolute()
    {
        $routes = $this->getRoutes('test', new Route('/{name}', [], [], [], '{locale}.example.com'));

        $this->assertEquals('http://fr.example.com/app.php/Fabien', $this->getGenerator($routes, ['host' => 'fr.example.com'])->generate('test', ['name' => 'Fabien', 'locale' => 'fr'], UrlGeneratorInterface::ABSOLUTE_URL));
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testUrlWithInvalidParameterInHost()
    {
        $routes = $this->getRoutes('test', new Route('/', [], ['foo' => 'bar'], [], '{foo}.example.com'));
        $this->getGenerator($routes)->generate('test', ['foo' => 'baz'], UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testUrlWithInvalidParameterInHostWhenParamHasADefaultValue()
    {
        $routes = $this->getRoutes('test', new Route('/', ['foo' => 'bar'], ['foo' => 'bar'], [], '{foo}.example.com'));
        $this->getGenerator($routes)->generate('test', ['foo' => 'baz'], UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\InvalidParameterException
     */
    public function testUrlWithInvalidParameterEqualsDefaultValueInHost()
    {
        $routes = $this->getRoutes('test', new Route('/', ['foo' => 'baz'], ['foo' => 'bar'], [], '{foo}.example.com'));
        $this->getGenerator($routes)->generate('test', ['foo' => 'baz'], UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    public function testUrlWithInvalidParameterInHostInNonStrictMode()
    {
        $routes = $this->getRoutes('test', new Route('/', [], ['foo' => 'bar'], [], '{foo}.example.com'));
        $generator = $this->getGenerator($routes);
        $generator->setStrictRequirements(false);
        $this->assertNull($generator->generate('test', ['foo' => 'baz'], UrlGeneratorInterface::ABSOLUTE_PATH));
    }

    public function testHostIsCaseInsensitive()
    {
        $routes = $this->getRoutes('test', new Route('/', [], ['locale' => 'en|de|fr'], [], '{locale}.FooBar.com'));
        $generator = $this->getGenerator($routes);
        $this->assertSame('//EN.FooBar.com/app.php/', $generator->generate('test', ['locale' => 'EN'], UrlGeneratorInterface::NETWORK_PATH));
    }

    public function testDefaultHostIsUsedWhenContextHostIsEmpty()
    {
        $routes = $this->getRoutes('test', new Route('/route', ['domain' => 'my.fallback.host'], ['domain' => '.+'], [], '{domain}', ['http']));

        $generator = $this->getGenerator($routes);
        $generator->getContext()->setHost('');

        $this->assertSame('http://my.fallback.host/app.php/route', $generator->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL));
    }

    public function testDefaultHostIsUsedWhenContextHostIsEmptyAndSchemeIsNot()
    {
        $routes = $this->getRoutes('test', new Route('/route', ['domain' => 'my.fallback.host'], ['domain' => '.+'], [], '{domain}', ['http', 'https']));

        $generator = $this->getGenerator($routes);
        $generator->getContext()->setHost('');
        $generator->getContext()->setScheme('https');

        $this->assertSame('https://my.fallback.host/app.php/route', $generator->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL));
    }

    public function testAbsoluteUrlFallbackToRelativeIfHostIsEmptyAndSchemeIsNot()
    {
        $routes = $this->getRoutes('test', new Route('/route', [], [], [], '', ['http', 'https']));

        $generator = $this->getGenerator($routes);
        $generator->getContext()->setHost('');
        $generator->getContext()->setScheme('https');

        $this->assertSame('/app.php/route', $generator->generate('test', [], UrlGeneratorInterface::ABSOLUTE_URL));
    }

    public function testGenerateNetworkPath()
    {
        $routes = $this->getRoutes('test', new Route('/{name}', [], [], [], '{locale}.example.com', ['http']));

        $this->assertSame('//fr.example.com/app.php/Fabien', $this->getGenerator($routes)->generate('test',
            ['name' => 'Fabien', 'locale' => 'fr'], UrlGeneratorInterface::NETWORK_PATH), 'network path with different host'
        );
        $this->assertSame('//fr.example.com/app.php/Fabien?query=string', $this->getGenerator($routes, ['host' => 'fr.example.com'])->generate('test',
            ['name' => 'Fabien', 'locale' => 'fr', 'query' => 'string'], UrlGeneratorInterface::NETWORK_PATH), 'network path although host same as context'
        );
        $this->assertSame('http://fr.example.com/app.php/Fabien', $this->getGenerator($routes, ['scheme' => 'https'])->generate('test',
            ['name' => 'Fabien', 'locale' => 'fr'], UrlGeneratorInterface::NETWORK_PATH), 'absolute URL because scheme requirement does not match context'
        );
        $this->assertSame('http://fr.example.com/app.php/Fabien', $this->getGenerator($routes)->generate('test',
            ['name' => 'Fabien', 'locale' => 'fr'], UrlGeneratorInterface::ABSOLUTE_URL), 'absolute URL with same scheme because it is requested'
        );
    }

    public function testGenerateRelativePath()
    {
        $routes = new RouteCollection();
        $routes->add('article', new Route('/{author}/{article}/'));
        $routes->add('comments', new Route('/{author}/{article}/comments'));
        $routes->add('host', new Route('/{article}', [], [], [], '{author}.example.com'));
        $routes->add('scheme', new Route('/{author}/blog', [], [], [], '', ['https']));
        $routes->add('unrelated', new Route('/about'));

        $generator = $this->getGenerator($routes, ['host' => 'example.com', 'pathInfo' => '/fabien/symfony-is-great/']);

        $this->assertSame('comments', $generator->generate('comments',
            ['author' => 'fabien', 'article' => 'symfony-is-great'], UrlGeneratorInterface::RELATIVE_PATH)
        );
        $this->assertSame('comments?page=2', $generator->generate('comments',
            ['author' => 'fabien', 'article' => 'symfony-is-great', 'page' => 2], UrlGeneratorInterface::RELATIVE_PATH)
        );
        $this->assertSame('../twig-is-great/', $generator->generate('article',
            ['author' => 'fabien', 'article' => 'twig-is-great'], UrlGeneratorInterface::RELATIVE_PATH)
        );
        $this->assertSame('../../bernhard/forms-are-great/', $generator->generate('article',
            ['author' => 'bernhard', 'article' => 'forms-are-great'], UrlGeneratorInterface::RELATIVE_PATH)
        );
        $this->assertSame('//bernhard.example.com/app.php/forms-are-great', $generator->generate('host',
            ['author' => 'bernhard', 'article' => 'forms-are-great'], UrlGeneratorInterface::RELATIVE_PATH)
        );
        $this->assertSame('https://example.com/app.php/bernhard/blog', $generator->generate('scheme',
                ['author' => 'bernhard'], UrlGeneratorInterface::RELATIVE_PATH)
        );
        $this->assertSame('../../about', $generator->generate('unrelated',
            [], UrlGeneratorInterface::RELATIVE_PATH)
        );
    }

    /**
     * @dataProvider provideRelativePaths
     */
    public function testGetRelativePath($sourcePath, $targetPath, $expectedPath)
    {
        $this->assertSame($expectedPath, UrlGenerator::getRelativePath($sourcePath, $targetPath));
    }

    public function provideRelativePaths()
    {
        return [
            [
                '/same/dir/',
                '/same/dir/',
                '',
            ],
            [
                '/same/file',
                '/same/file',
                '',
            ],
            [
                '/',
                '/file',
                'file',
            ],
            [
                '/',
                '/dir/file',
                'dir/file',
            ],
            [
                '/dir/file.html',
                '/dir/different-file.html',
                'different-file.html',
            ],
            [
                '/same/dir/extra-file',
                '/same/dir/',
                './',
            ],
            [
                '/parent/dir/',
                '/parent/',
                '../',
            ],
            [
                '/parent/dir/extra-file',
                '/parent/',
                '../',
            ],
            [
                '/a/b/',
                '/x/y/z/',
                '../../x/y/z/',
            ],
            [
                '/a/b/c/d/e',
                '/a/c/d',
                '../../../c/d',
            ],
            [
                '/a/b/c//',
                '/a/b/c/',
                '../',
            ],
            [
                '/a/b/c/',
                '/a/b/c//',
                './/',
            ],
            [
                '/root/a/b/c/',
                '/root/x/b/c/',
                '../../../x/b/c/',
            ],
            [
                '/a/b/c/d/',
                '/a',
                '../../../../a',
            ],
            [
                '/special-chars/sp%20ce/1€/mäh/e=mc²',
                '/special-chars/sp%20ce/1€/<µ>/e=mc²',
                '../<µ>/e=mc²',
            ],
            [
                'not-rooted',
                'dir/file',
                'dir/file',
            ],
            [
                '//dir/',
                '',
                '../../',
            ],
            [
                '/dir/',
                '/dir/file:with-colon',
                './file:with-colon',
            ],
            [
                '/dir/',
                '/dir/subdir/file:with-colon',
                'subdir/file:with-colon',
            ],
            [
                '/dir/',
                '/dir/:subdir/',
                './:subdir/',
            ],
        ];
    }

    public function testFragmentsCanBeAppendedToUrls()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));

        $url = $this->getGenerator($routes)->generate('test', ['_fragment' => 'frag ment'], UrlGeneratorInterface::ABSOLUTE_PATH);
        $this->assertEquals('/app.php/testing#frag%20ment', $url);

        $url = $this->getGenerator($routes)->generate('test', ['_fragment' => '0'], UrlGeneratorInterface::ABSOLUTE_PATH);
        $this->assertEquals('/app.php/testing#0', $url);
    }

    public function testFragmentsDoNotEscapeValidCharacters()
    {
        $routes = $this->getRoutes('test', new Route('/testing'));
        $url = $this->getGenerator($routes)->generate('test', ['_fragment' => '?/'], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('/app.php/testing#?/', $url);
    }

    public function testFragmentsCanBeDefinedAsDefaults()
    {
        $routes = $this->getRoutes('test', new Route('/testing', ['_fragment' => 'fragment']));
        $url = $this->getGenerator($routes)->generate('test', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('/app.php/testing#fragment', $url);
    }

    /**
     * @dataProvider provideLookAroundRequirementsInPath
     */
    public function testLookRoundRequirementsInPath($expected, $path, $requirement)
    {
        $routes = $this->getRoutes('test', new Route($path, [], ['foo' => $requirement, 'baz' => '.+?']));
        $this->assertSame($expected, $this->getGenerator($routes)->generate('test', ['foo' => 'a/b', 'baz' => 'c/d/e']));
    }

    public function provideLookAroundRequirementsInPath()
    {
        yield ['/app.php/a/b/b%28ar/c/d/e', '/{foo}/b(ar/{baz}', '.+(?=/b\\(ar/)'];
        yield ['/app.php/a/b/bar/c/d/e', '/{foo}/bar/{baz}', '.+(?!$)'];
        yield ['/app.php/bar/a/b/bam/c/d/e', '/bar/{foo}/bam/{baz}', '(?<=/bar/).+'];
        yield ['/app.php/bar/a/b/bam/c/d/e', '/bar/{foo}/bam/{baz}', '(?<!^).+'];
    }

    protected function getGenerator(RouteCollection $routes, array $parameters = [], $logger = null, string $defaultLocale = null)
    {
        $context = new RequestContext('/app.php');
        foreach ($parameters as $key => $value) {
            $method = 'set'.$key;
            $context->$method($value);
        }

        return new UrlGenerator($routes, $context, $logger, $defaultLocale);
    }

    protected function getRoutes($name, Route $route)
    {
        $routes = new RouteCollection();
        $routes->add($name, $route);

        return $routes;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Generator\Dumper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\CompiledUrlGenerator;
use Symfony\Component\Routing\Generator\Dumper\CompiledUrlGeneratorDumper;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class CompiledUrlGeneratorDumperTest extends TestCase
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var CompiledUrlGeneratorDumper
     */
    private $generatorDumper;

    /**
     * @var string
     */
    private $testTmpFilepath;

    /**
     * @var string
     */
    private $largeTestTmpFilepath;

    protected function setUp()
    {
        parent::setUp();

        $this->routeCollection = new RouteCollection();
        $this->generatorDumper = new CompiledUrlGeneratorDumper($this->routeCollection);
        $this->testTmpFilepath = sys_get_temp_dir().'/php_generator.'.$this->getName().'.php';
        $this->largeTestTmpFilepath = sys_get_temp_dir().'/php_generator.'.$this->getName().'.large.php';
        @unlink($this->testTmpFilepath);
        @unlink($this->largeTestTmpFilepath);
    }

    protected function tearDown()
    {
        parent::tearDown();

        @unlink($this->testTmpFilepath);

        $this->routeCollection = null;
        $this->generatorDumper = null;
        $this->testTmpFilepath = null;
    }

    public function testDumpWithRoutes()
    {
        $this->routeCollection->add('Test', new Route('/testing/{foo}'));
        $this->routeCollection->add('Test2', new Route('/testing2'));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump());

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext('/app.php'));

        $absoluteUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL);
        $absoluteUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_PATH);
        $relativeUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('http://localhost/app.php/testing/bar', $absoluteUrlWithParameter);
        $this->assertEquals('http://localhost/app.php/testing2', $absoluteUrlWithoutParameter);
        $this->assertEquals('/app.php/testing/bar', $relativeUrlWithParameter);
        $this->assertEquals('/app.php/testing2', $relativeUrlWithoutParameter);
    }

    public function testDumpWithSimpleLocalizedRoutes()
    {
        $this->routeCollection->add('test', (new Route('/foo')));
        $this->routeCollection->add('test.en', (new Route('/testing/is/fun'))->setDefault('_locale', 'en')->setDefault('_canonical_route', 'test'));
        $this->routeCollection->add('test.nl', (new Route('/testen/is/leuk'))->setDefault('_locale', 'nl')->setDefault('_canonical_route', 'test'));

        $code = $this->generatorDumper->dump();
        file_put_contents($this->testTmpFilepath, $code);

        $context = new RequestContext('/app.php');
        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, $context, null, 'en');

        $urlWithDefaultLocale = $projectUrlGenerator->generate('test');
        $urlWithSpecifiedLocale = $projectUrlGenerator->generate('test', ['_locale' => 'nl']);
        $context->setParameter('_locale', 'en');
        $urlWithEnglishContext = $projectUrlGenerator->generate('test');
        $context->setParameter('_locale', 'nl');
        $urlWithDutchContext = $projectUrlGenerator->generate('test');

        $this->assertEquals('/app.php/testing/is/fun', $urlWithDefaultLocale);
        $this->assertEquals('/app.php/testen/is/leuk', $urlWithSpecifiedLocale);
        $this->assertEquals('/app.php/testing/is/fun', $urlWithEnglishContext);
        $this->assertEquals('/app.php/testen/is/leuk', $urlWithDutchContext);

        // test with full route name
        $this->assertEquals('/app.php/testing/is/fun', $projectUrlGenerator->generate('test.en'));

        $context->setParameter('_locale', 'de_DE');
        // test that it fall backs to another route when there is no matching localized route
        $this->assertEquals('/app.php/foo', $projectUrlGenerator->generate('test'));
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @expectedExceptionMessage Unable to generate a URL for the named route "test" as such route does not exist.
     */
    public function testDumpWithRouteNotFoundLocalizedRoutes()
    {
        $this->routeCollection->add('test.en', (new Route('/testing/is/fun'))->setDefault('_locale', 'en')->setDefault('_canonical_route', 'test'));

        $code = $this->generatorDumper->dump();
        file_put_contents($this->testTmpFilepath, $code);

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext('/app.php'), null, 'pl_PL');
        $projectUrlGenerator->generate('test');
    }

    public function testDumpWithFallbackLocaleLocalizedRoutes()
    {
        $this->routeCollection->add('test.en', (new Route('/testing/is/fun'))->setDefault('_canonical_route', 'test'));
        $this->routeCollection->add('test.nl', (new Route('/testen/is/leuk'))->setDefault('_canonical_route', 'test'));
        $this->routeCollection->add('test.fr', (new Route('/tester/est/amusant'))->setDefault('_canonical_route', 'test'));

        $code = $this->generatorDumper->dump();
        file_put_contents($this->testTmpFilepath, $code);

        $context = new RequestContext('/app.php');
        $context->setParameter('_locale', 'en_GB');
        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, $context, null, null);

        // test with context _locale
        $this->assertEquals('/app.php/testing/is/fun', $projectUrlGenerator->generate('test'));
        // test with parameters _locale
        $this->assertEquals('/app.php/testen/is/leuk', $projectUrlGenerator->generate('test', ['_locale' => 'nl_BE']));

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext('/app.php'), null, 'fr_CA');
        // test with default locale
        $this->assertEquals('/app.php/tester/est/amusant', $projectUrlGenerator->generate('test'));
    }

    public function testDumpWithTooManyRoutes()
    {
        $this->routeCollection->add('Test', new Route('/testing/{foo}'));
        for ($i = 0; $i < 32769; ++$i) {
            $this->routeCollection->add('route_'.$i, new Route('/route_'.$i));
        }
        $this->routeCollection->add('Test2', new Route('/testing2'));

        file_put_contents($this->largeTestTmpFilepath, $this->generatorDumper->dump());
        $this->routeCollection = $this->generatorDumper = null;

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->largeTestTmpFilepath, new RequestContext('/app.php'));

        $absoluteUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL);
        $absoluteUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_PATH);
        $relativeUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('http://localhost/app.php/testing/bar', $absoluteUrlWithParameter);
        $this->assertEquals('http://localhost/app.php/testing2', $absoluteUrlWithoutParameter);
        $this->assertEquals('/app.php/testing/bar', $relativeUrlWithParameter);
        $this->assertEquals('/app.php/testing2', $relativeUrlWithoutParameter);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDumpWithoutRoutes()
    {
        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump());

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext('/app.php'));

        $projectUrlGenerator->generate('Test', []);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function testGenerateNonExistingRoute()
    {
        $this->routeCollection->add('Test', new Route('/test'));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump());

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext());
        $url = $projectUrlGenerator->generate('NonExisting', []);
    }

    public function testDumpForRouteWithDefaults()
    {
        $this->routeCollection->add('Test', new Route('/testing/{foo}', ['foo' => 'bar']));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump());

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext());
        $url = $projectUrlGenerator->generate('Test', []);

        $this->assertEquals('/testing', $url);
    }

    public function testDumpWithSchemeRequirement()
    {
        $this->routeCollection->add('Test1', new Route('/testing', [], [], [], '', ['ftp', 'https']));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump());

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext('/app.php'));

        $absoluteUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('ftp://localhost/app.php/testing', $absoluteUrl);
        $this->assertEquals('ftp://localhost/app.php/testing', $relativeUrl);

        $projectUrlGenerator = new CompiledUrlGenerator(require $this->testTmpFilepath, new RequestContext('/app.php', 'GET', 'localhost', 'https'));

        $absoluteUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('https://localhost/app.php/testing', $absoluteUrl);
        $this->assertEquals('/app.php/testing', $relativeUrl);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Generator\Dumper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\Dumper\PhpGeneratorDumper;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class PhpGeneratorDumperTest extends TestCase
{
    /**
     * @var RouteCollection
     */
    private $routeCollection;

    /**
     * @var PhpGeneratorDumper
     */
    private $generatorDumper;

    /**
     * @var string
     */
    private $testTmpFilepath;

    /**
     * @var string
     */
    private $largeTestTmpFilepath;

    protected function setUp()
    {
        parent::setUp();

        $this->routeCollection = new RouteCollection();
        $this->generatorDumper = new PhpGeneratorDumper($this->routeCollection);
        $this->testTmpFilepath = sys_get_temp_dir().\DIRECTORY_SEPARATOR.'php_generator.'.$this->getName().'.php';
        $this->largeTestTmpFilepath = sys_get_temp_dir().\DIRECTORY_SEPARATOR.'php_generator.'.$this->getName().'.large.php';
        @unlink($this->testTmpFilepath);
        @unlink($this->largeTestTmpFilepath);
    }

    protected function tearDown()
    {
        parent::tearDown();

        @unlink($this->testTmpFilepath);

        $this->routeCollection = null;
        $this->generatorDumper = null;
        $this->testTmpFilepath = null;
    }

    public function testDumpWithRoutes()
    {
        $this->routeCollection->add('Test', new Route('/testing/{foo}'));
        $this->routeCollection->add('Test2', new Route('/testing2'));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump());
        include $this->testTmpFilepath;

        $projectUrlGenerator = new \ProjectUrlGenerator(new RequestContext('/app.php'));

        $absoluteUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL);
        $absoluteUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_PATH);
        $relativeUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('http://localhost/app.php/testing/bar', $absoluteUrlWithParameter);
        $this->assertEquals('http://localhost/app.php/testing2', $absoluteUrlWithoutParameter);
        $this->assertEquals('/app.php/testing/bar', $relativeUrlWithParameter);
        $this->assertEquals('/app.php/testing2', $relativeUrlWithoutParameter);
    }

    public function testDumpWithSimpleLocalizedRoutes()
    {
        $this->routeCollection->add('test', (new Route('/foo')));
        $this->routeCollection->add('test.en', (new Route('/testing/is/fun'))->setDefault('_locale', 'en')->setDefault('_canonical_route', 'test'));
        $this->routeCollection->add('test.nl', (new Route('/testen/is/leuk'))->setDefault('_locale', 'nl')->setDefault('_canonical_route', 'test'));

        $code = $this->generatorDumper->dump([
            'class' => 'SimpleLocalizedProjectUrlGenerator',
        ]);
        file_put_contents($this->testTmpFilepath, $code);
        include $this->testTmpFilepath;

        $context = new RequestContext('/app.php');
        $projectUrlGenerator = new \SimpleLocalizedProjectUrlGenerator($context, null, 'en');

        $urlWithDefaultLocale = $projectUrlGenerator->generate('test');
        $urlWithSpecifiedLocale = $projectUrlGenerator->generate('test', ['_locale' => 'nl']);
        $context->setParameter('_locale', 'en');
        $urlWithEnglishContext = $projectUrlGenerator->generate('test');
        $context->setParameter('_locale', 'nl');
        $urlWithDutchContext = $projectUrlGenerator->generate('test');

        $this->assertEquals('/app.php/testing/is/fun', $urlWithDefaultLocale);
        $this->assertEquals('/app.php/testen/is/leuk', $urlWithSpecifiedLocale);
        $this->assertEquals('/app.php/testing/is/fun', $urlWithEnglishContext);
        $this->assertEquals('/app.php/testen/is/leuk', $urlWithDutchContext);

        // test with full route name
        $this->assertEquals('/app.php/testing/is/fun', $projectUrlGenerator->generate('test.en'));

        $context->setParameter('_locale', 'de_DE');
        // test that it fall backs to another route when there is no matching localized route
        $this->assertEquals('/app.php/foo', $projectUrlGenerator->generate('test'));
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @expectedExceptionMessage Unable to generate a URL for the named route "test" as such route does not exist.
     */
    public function testDumpWithRouteNotFoundLocalizedRoutes()
    {
        $this->routeCollection->add('test.en', (new Route('/testing/is/fun'))->setDefault('_locale', 'en')->setDefault('_canonical_route', 'test'));

        $code = $this->generatorDumper->dump([
            'class' => 'RouteNotFoundLocalizedProjectUrlGenerator',
        ]);
        file_put_contents($this->testTmpFilepath, $code);
        include $this->testTmpFilepath;

        $projectUrlGenerator = new \RouteNotFoundLocalizedProjectUrlGenerator(new RequestContext('/app.php'), null, 'pl_PL');
        $projectUrlGenerator->generate('test');
    }

    public function testDumpWithFallbackLocaleLocalizedRoutes()
    {
        $this->routeCollection->add('test.en', (new Route('/testing/is/fun'))->setDefault('_canonical_route', 'test'));
        $this->routeCollection->add('test.nl', (new Route('/testen/is/leuk'))->setDefault('_canonical_route', 'test'));
        $this->routeCollection->add('test.fr', (new Route('/tester/est/amusant'))->setDefault('_canonical_route', 'test'));

        $code = $this->generatorDumper->dump([
            'class' => 'FallbackLocaleLocalizedProjectUrlGenerator',
        ]);
        file_put_contents($this->testTmpFilepath, $code);
        include $this->testTmpFilepath;

        $context = new RequestContext('/app.php');
        $context->setParameter('_locale', 'en_GB');
        $projectUrlGenerator = new \FallbackLocaleLocalizedProjectUrlGenerator($context, null, null);

        // test with context _locale
        $this->assertEquals('/app.php/testing/is/fun', $projectUrlGenerator->generate('test'));
        // test with parameters _locale
        $this->assertEquals('/app.php/testen/is/leuk', $projectUrlGenerator->generate('test', ['_locale' => 'nl_BE']));

        $projectUrlGenerator = new \FallbackLocaleLocalizedProjectUrlGenerator(new RequestContext('/app.php'), null, 'fr_CA');
        // test with default locale
        $this->assertEquals('/app.php/tester/est/amusant', $projectUrlGenerator->generate('test'));
    }

    public function testDumpWithTooManyRoutes()
    {
        $this->routeCollection->add('Test', new Route('/testing/{foo}'));
        for ($i = 0; $i < 32769; ++$i) {
            $this->routeCollection->add('route_'.$i, new Route('/route_'.$i));
        }
        $this->routeCollection->add('Test2', new Route('/testing2'));

        file_put_contents($this->largeTestTmpFilepath, $this->generatorDumper->dump([
            'class' => 'ProjectLargeUrlGenerator',
        ]));
        $this->routeCollection = $this->generatorDumper = null;
        include $this->largeTestTmpFilepath;

        $projectUrlGenerator = new \ProjectLargeUrlGenerator(new RequestContext('/app.php'));

        $absoluteUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_URL);
        $absoluteUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrlWithParameter = $projectUrlGenerator->generate('Test', ['foo' => 'bar'], UrlGeneratorInterface::ABSOLUTE_PATH);
        $relativeUrlWithoutParameter = $projectUrlGenerator->generate('Test2', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('http://localhost/app.php/testing/bar', $absoluteUrlWithParameter);
        $this->assertEquals('http://localhost/app.php/testing2', $absoluteUrlWithoutParameter);
        $this->assertEquals('/app.php/testing/bar', $relativeUrlWithParameter);
        $this->assertEquals('/app.php/testing2', $relativeUrlWithoutParameter);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testDumpWithoutRoutes()
    {
        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump(['class' => 'WithoutRoutesUrlGenerator']));
        include $this->testTmpFilepath;

        $projectUrlGenerator = new \WithoutRoutesUrlGenerator(new RequestContext('/app.php'));

        $projectUrlGenerator->generate('Test', []);
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function testGenerateNonExistingRoute()
    {
        $this->routeCollection->add('Test', new Route('/test'));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump(['class' => 'NonExistingRoutesUrlGenerator']));
        include $this->testTmpFilepath;

        $projectUrlGenerator = new \NonExistingRoutesUrlGenerator(new RequestContext());
        $url = $projectUrlGenerator->generate('NonExisting', []);
    }

    public function testDumpForRouteWithDefaults()
    {
        $this->routeCollection->add('Test', new Route('/testing/{foo}', ['foo' => 'bar']));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump(['class' => 'DefaultRoutesUrlGenerator']));
        include $this->testTmpFilepath;

        $projectUrlGenerator = new \DefaultRoutesUrlGenerator(new RequestContext());
        $url = $projectUrlGenerator->generate('Test', []);

        $this->assertEquals('/testing', $url);
    }

    public function testDumpWithSchemeRequirement()
    {
        $this->routeCollection->add('Test1', new Route('/testing', [], [], [], '', ['ftp', 'https']));

        file_put_contents($this->testTmpFilepath, $this->generatorDumper->dump(['class' => 'SchemeUrlGenerator']));
        include $this->testTmpFilepath;

        $projectUrlGenerator = new \SchemeUrlGenerator(new RequestContext('/app.php'));

        $absoluteUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('ftp://localhost/app.php/testing', $absoluteUrl);
        $this->assertEquals('ftp://localhost/app.php/testing', $relativeUrl);

        $projectUrlGenerator = new \SchemeUrlGenerator(new RequestContext('/app.php', 'GET', 'localhost', 'https'));

        $absoluteUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_URL);
        $relativeUrl = $projectUrlGenerator->generate('Test1', [], UrlGeneratorInterface::ABSOLUTE_PATH);

        $this->assertEquals('https://localhost/app.php/testing', $absoluteUrl);
        $this->assertEquals('/app.php/testing', $relativeUrl);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use PHPUnit\Framework\TestCase;

abstract class AbstractAnnotationLoaderTest extends TestCase
{
    public function getReader()
    {
        return $this->getMockBuilder('Doctrine\Common\Annotations\Reader')
            ->disableOriginalConstructor()
            ->getMock()
        ;
    }

    public function getClassLoader($reader)
    {
        return $this->getMockBuilder('Symfony\Component\Routing\Loader\AnnotationClassLoader')
            ->setConstructorArgs([$reader])
            ->getMockForAbstractClass()
        ;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Symfony\Component\Routing\Annotation\Route as RouteAnnotation;
use Symfony\Component\Routing\Loader\AnnotationClassLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\AbstractClassController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\ActionPathController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\DefaultValueController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\ExplicitLocalizedActionPathController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\InvokableController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\InvokableLocalizedController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\LocalizedActionPathController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\LocalizedMethodActionControllers;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\LocalizedPrefixLocalizedActionController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\LocalizedPrefixMissingLocaleActionController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\LocalizedPrefixMissingRouteLocaleActionController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\LocalizedPrefixWithRouteWithoutLocale;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\MethodActionControllers;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\MissingRouteNameController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\NothingButNameController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\PrefixedActionLocalizedRouteController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\PrefixedActionPathController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\RequirementsWithoutPlaceholderNameController;
use Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\RouteWithPrefixController;

class AnnotationClassLoaderTest extends AbstractAnnotationLoaderTest
{
    /**
     * @var AnnotationClassLoader
     */
    private $loader;

    protected function setUp()
    {
        $reader = new AnnotationReader();
        $this->loader = new class($reader) extends AnnotationClassLoader {
            protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, $annot)
            {
            }
        };
        AnnotationRegistry::registerLoader('class_exists');
    }

    /**
     * @dataProvider provideTestSupportsChecksResource
     */
    public function testSupportsChecksResource($resource, $expectedSupports)
    {
        $this->assertSame($expectedSupports, $this->loader->supports($resource), '->supports() returns true if the resource is loadable');
    }

    public function provideTestSupportsChecksResource()
    {
        return [
            ['class', true],
            ['\fully\qualified\class\name', true],
            ['namespaced\class\without\leading\slash', true],
            ['ÿClassWithLegalSpecialCharacters', true],
            ['5', false],
            ['foo.foo', false],
            [null, false],
        ];
    }

    public function testSupportsChecksTypeIfSpecified()
    {
        $this->assertTrue($this->loader->supports('class', 'annotation'), '->supports() checks the resource type if specified');
        $this->assertFalse($this->loader->supports('class', 'foo'), '->supports() checks the resource type if specified');
    }

    public function testSimplePathRoute()
    {
        $routes = $this->loader->load(ActionPathController::class);
        $this->assertCount(1, $routes);
        $this->assertEquals('/path', $routes->get('action')->getPath());
    }

    /**
     * @group legacy
     * @expectedDeprecation A placeholder name must be a string (0 given). Did you forget to specify the placeholder key for the requirement "foo" in "Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\RequirementsWithoutPlaceholderNameController"?
     * @expectedDeprecation A placeholder name must be a string (1 given). Did you forget to specify the placeholder key for the requirement "\d+" in "Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\RequirementsWithoutPlaceholderNameController"?
     * @expectedDeprecation A placeholder name must be a string (0 given). Did you forget to specify the placeholder key for the requirement "foo" of route "foo" in "Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\RequirementsWithoutPlaceholderNameController::foo()"?
     * @expectedDeprecation A placeholder name must be a string (1 given). Did you forget to specify the placeholder key for the requirement "\d+" of route "foo" in "Symfony\Component\Routing\Tests\Fixtures\AnnotationFixtures\RequirementsWithoutPlaceholderNameController::foo()"?
     */
    public function testRequirementsWithoutPlaceholderName()
    {
        $this->loader->load(RequirementsWithoutPlaceholderNameController::class);
    }

    public function testInvokableControllerLoader()
    {
        $routes = $this->loader->load(InvokableController::class);
        $this->assertCount(1, $routes);
        $this->assertEquals('/here', $routes->get('lol')->getPath());
        $this->assertEquals(['GET', 'POST'], $routes->get('lol')->getMethods());
        $this->assertEquals(['https'], $routes->get('lol')->getSchemes());
    }

    public function testInvokableLocalizedControllerLoading()
    {
        $routes = $this->loader->load(InvokableLocalizedController::class);
        $this->assertCount(2, $routes);
        $this->assertEquals('/here', $routes->get('action.en')->getPath());
        $this->assertEquals('/hier', $routes->get('action.nl')->getPath());
    }

    public function testLocalizedPathRoutes()
    {
        $routes = $this->loader->load(LocalizedActionPathController::class);
        $this->assertCount(2, $routes);
        $this->assertEquals('/path', $routes->get('action.en')->getPath());
        $this->assertEquals('/pad', $routes->get('action.nl')->getPath());
    }

    public function testLocalizedPathRoutesWithExplicitPathPropety()
    {
        $routes = $this->loader->load(ExplicitLocalizedActionPathController::class);
        $this->assertCount(2, $routes);
        $this->assertEquals('/path', $routes->get('action.en')->getPath());
        $this->assertEquals('/pad', $routes->get('action.nl')->getPath());
    }

    public function testDefaultValuesForMethods()
    {
        $routes = $this->loader->load(DefaultValueController::class);
        $this->assertCount(3, $routes);
        $this->assertEquals('/{default}/path', $routes->get('action')->getPath());
        $this->assertEquals('value', $routes->get('action')->getDefault('default'));
        $this->assertEquals('Symfony', $routes->get('hello_with_default')->getDefault('name'));
        $this->assertEquals('World', $routes->get('hello_without_default')->getDefault('name'));
    }

    public function testMethodActionControllers()
    {
        $routes = $this->loader->load(MethodActionControllers::class);
        $this->assertCount(2, $routes);
        $this->assertEquals('/the/path', $routes->get('put')->getPath());
        $this->assertEquals('/the/path', $routes->get('post')->getPath());
    }

    public function testInvokableClassRouteLoadWithMethodAnnotation()
    {
        $routes = $this->loader->load(LocalizedMethodActionControllers::class);
        $this->assertCount(4, $routes);
        $this->assertEquals('/the/path', $routes->get('put.en')->getPath());
        $this->assertEquals('/the/path', $routes->get('post.en')->getPath());
    }

    public function testRouteWithPathWithPrefix()
    {
        $routes = $this->loader->load(PrefixedActionPathController::class);
        $this->assertCount(1, $routes);
        $route = $routes->get('action');
        $this->assertEquals('/prefix/path', $route->getPath());
        $this->assertEquals('lol=fun', $route->getCondition());
        $this->assertEquals('frankdejonge.nl', $route->getHost());
    }

    public function testLocalizedRouteWithPathWithPrefix()
    {
        $routes = $this->loader->load(PrefixedActionLocalizedRouteController::class);
        $this->assertCount(2, $routes);
        $this->assertEquals('/prefix/path', $routes->get('action.en')->getPath());
        $this->assertEquals('/prefix/pad', $routes->get('action.nl')->getPath());
    }

    public function testLocalizedPrefixLocalizedRoute()
    {
        $routes = $this->loader->load(LocalizedPrefixLocalizedActionController::class);
        $this->assertCount(2, $routes);
        $this->assertEquals('/nl/actie', $routes->get('action.nl')->getPath());
        $this->assertEquals('/en/action', $routes->get('action.en')->getPath());
    }

    public function testInvokableClassMultipleRouteLoad()
    {
        $classRouteData1 = [
            'name' => 'route1',
            'path' => '/1',
            'schemes' => ['https'],
            'methods' => ['GET'],
        ];

        $classRouteData2 = [
            'name' => 'route2',
            'path' => '/2',
            'schemes' => ['https'],
            'methods' => ['GET'],
        ];

        $reader = $this->getReader();
        $reader
            ->expects($this->exactly(1))
            ->method('getClassAnnotations')
            ->will($this->returnValue([new RouteAnnotation($classRouteData1), new RouteAnnotation($classRouteData2)]))
        ;
        $reader
            ->expects($this->once())
            ->method('getMethodAnnotations')
            ->will($this->returnValue([]))
        ;
        $loader = new class($reader) extends AnnotationClassLoader {
            protected function configureRoute(Route $route, \ReflectionClass $class, \ReflectionMethod $method, $annot)
            {
            }
        };

        $routeCollection = $loader->load('Symfony\Component\Routing\Tests\Fixtures\AnnotatedClasses\BazClass');
        $route = $routeCollection->get($classRouteData1['name']);

        $this->assertSame($classRouteData1['path'], $route->getPath(), '->load preserves class route path');
        $this->assertEquals($classRouteData1['schemes'], $route->getSchemes(), '->load preserves class route schemes');
        $this->assertEquals($classRouteData1['methods'], $route->getMethods(), '->load preserves class route methods');

        $route = $routeCollection->get($classRouteData2['name']);

        $this->assertSame($classRouteData2['path'], $route->getPath(), '->load preserves class route path');
        $this->assertEquals($classRouteData2['schemes'], $route->getSchemes(), '->load preserves class route schemes');
        $this->assertEquals($classRouteData2['methods'], $route->getMethods(), '->load preserves class route methods');
    }

    public function testMissingPrefixLocale()
    {
        $this->expectException(\LogicException::class);
        $this->loader->load(LocalizedPrefixMissingLocaleActionController::class);
    }

    public function testMissingRouteLocale()
    {
        $this->expectException(\LogicException::class);
        $this->loader->load(LocalizedPrefixMissingRouteLocaleActionController::class);
    }

    public function testRouteWithoutName()
    {
        $routes = $this->loader->load(MissingRouteNameController::class)->all();
        $this->assertCount(1, $routes);
        $this->assertEquals('/path', reset($routes)->getPath());
    }

    public function testNothingButName()
    {
        $routes = $this->loader->load(NothingButNameController::class)->all();
        $this->assertCount(1, $routes);
        $this->assertEquals('/', reset($routes)->getPath());
    }

    public function testNonExistingClass()
    {
        $this->expectException(\LogicException::class);
        $this->loader->load('ClassThatDoesNotExist');
    }

    public function testLoadingAbstractClass()
    {
        $this->expectException(\LogicException::class);
        $this->loader->load(AbstractClassController::class);
    }

    public function testLocalizedPrefixWithoutRouteLocale()
    {
        $routes = $this->loader->load(LocalizedPrefixWithRouteWithoutLocale::class);
        $this->assertCount(2, $routes);
        $this->assertEquals('/en/suffix', $routes->get('action.en')->getPath());
        $this->assertEquals('/nl/suffix', $routes->get('action.nl')->getPath());
    }

    public function testLoadingRouteWithPrefix()
    {
        $routes = $this->loader->load(RouteWithPrefixController::class);
        $this->assertCount(1, $routes);
        $this->assertEquals('/prefix/path', $routes->get('action')->getPath());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\AnnotationDirectoryLoader;

class AnnotationDirectoryLoaderTest extends AbstractAnnotationLoaderTest
{
    protected $loader;
    protected $reader;

    protected function setUp()
    {
        parent::setUp();

        $this->reader = $this->getReader();
        $this->loader = new AnnotationDirectoryLoader(new FileLocator(), $this->getClassLoader($this->reader));
    }

    public function testLoad()
    {
        $this->reader->expects($this->exactly(3))->method('getClassAnnotation');

        $this->reader
            ->expects($this->any())
            ->method('getMethodAnnotations')
            ->will($this->returnValue([]))
        ;

        $this->reader
            ->expects($this->any())
            ->method('getClassAnnotations')
            ->will($this->returnValue([]))
        ;

        $this->loader->load(__DIR__.'/../Fixtures/AnnotatedClasses');
    }

    public function testLoadIgnoresHiddenDirectories()
    {
        $this->expectAnnotationsToBeReadFrom([
            'Symfony\Component\Routing\Tests\Fixtures\AnnotatedClasses\BarClass',
            'Symfony\Component\Routing\Tests\Fixtures\AnnotatedClasses\BazClass',
            'Symfony\Component\Routing\Tests\Fixtures\AnnotatedClasses\FooClass',
        ]);

        $this->reader
            ->expects($this->any())
            ->method('getMethodAnnotations')
            ->will($this->returnValue([]))
        ;

        $this->reader
            ->expects($this->any())
            ->method('getClassAnnotations')
            ->will($this->returnValue([]))
        ;

        $this->loader->load(__DIR__.'/../Fixtures/AnnotatedClasses');
    }

    public function testSupports()
    {
        $fixturesDir = __DIR__.'/../Fixtures';

        $this->assertTrue($this->loader->supports($fixturesDir), '->supports() returns true if the resource is loadable');
        $this->assertFalse($this->loader->supports('foo.foo'), '->supports() returns true if the resource is loadable');

        $this->assertTrue($this->loader->supports($fixturesDir, 'annotation'), '->supports() checks the resource type if specified');
        $this->assertFalse($this->loader->supports($fixturesDir, 'foo'), '->supports() checks the resource type if specified');
    }

    public function testItSupportsAnyAnnotation()
    {
        $this->assertTrue($this->loader->supports(__DIR__.'/../Fixtures/even-with-not-existing-folder', 'annotation'));
    }

    public function testLoadFileIfLocatedResourceIsFile()
    {
        $this->reader->expects($this->exactly(1))->method('getClassAnnotation');

        $this->reader
            ->expects($this->any())
            ->method('getMethodAnnotations')
            ->will($this->returnValue([]))
        ;

        $this->loader->load(__DIR__.'/../Fixtures/AnnotatedClasses/FooClass.php');
    }

    private function expectAnnotationsToBeReadFrom(array $classes)
    {
        $this->reader->expects($this->exactly(\count($classes)))
            ->method('getClassAnnotation')
            ->with($this->callback(function (\ReflectionClass $class) use ($classes) {
                return \in_array($class->getName(), $classes);
            }));
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Loader\AnnotationFileLoader;

class AnnotationFileLoaderTest extends AbstractAnnotationLoaderTest
{
    protected $loader;
    protected $reader;

    protected function setUp()
    {
        parent::setUp();

        $this->reader = $this->getReader();
        $this->loader = new AnnotationFileLoader(new FileLocator(), $this->getClassLoader($this->reader));
    }

    public function testLoad()
    {
        $this->reader->expects($this->once())->method('getClassAnnotation');

        $this->loader->load(__DIR__.'/../Fixtures/AnnotatedClasses/FooClass.php');
    }

    public function testLoadTraitWithClassConstant()
    {
        $this->reader->expects($this->never())->method('getClassAnnotation');

        $this->loader->load(__DIR__.'/../Fixtures/AnnotatedClasses/FooTrait.php');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Did you forgot to add the "<?php" start tag at the beginning of the file?
     */
    public function testLoadFileWithoutStartTag()
    {
        $this->loader->load(__DIR__.'/../Fixtures/OtherAnnotatedClasses/NoStartTagClass.php');
    }

    public function testLoadVariadic()
    {
        $route = new Route(['path' => '/path/to/{id}']);
        $this->reader->expects($this->once())->method('getClassAnnotation');
        $this->reader->expects($this->once())->method('getMethodAnnotations')
            ->will($this->returnValue([$route]));

        $this->loader->load(__DIR__.'/../Fixtures/OtherAnnotatedClasses/VariadicClass.php');
    }

    /**
     * @requires PHP 7.0
     */
    public function testLoadAnonymousClass()
    {
        $this->reader->expects($this->never())->method('getClassAnnotation');
        $this->reader->expects($this->never())->method('getMethodAnnotations');

        $this->loader->load(__DIR__.'/../Fixtures/OtherAnnotatedClasses/AnonymousClassInTrait.php');
    }

    public function testLoadAbstractClass()
    {
        $this->reader->expects($this->never())->method('getClassAnnotation');
        $this->reader->expects($this->never())->method('getMethodAnnotations');

        $this->loader->load(__DIR__.'/../Fixtures/AnnotatedClasses/AbstractClass.php');
    }

    public function testSupports()
    {
        $fixture = __DIR__.'/../Fixtures/annotated.php';

        $this->assertTrue($this->loader->supports($fixture), '->supports() returns true if the resource is loadable');
        $this->assertFalse($this->loader->supports('foo.foo'), '->supports() returns true if the resource is loadable');

        $this->assertTrue($this->loader->supports($fixture, 'annotation'), '->supports() checks the resource type if specified');
        $this->assertFalse($this->loader->supports($fixture, 'foo'), '->supports() checks the resource type if specified');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                INDX( 	 =?�             (   �  �         b e                 3     � �     3     �3 qk� @������j��<��3 qk�       =                A b s t r a c t A n n o t a t i o n L o a d e r T e s t . p h p       3     � |     3     �,qk� @������j��<��,qk� @      �2               A n n o t a t i o n C l a s s L o a d e r T e s t . p h p     3     � �     3     �5qk� @����0m��<��5qk�       �              ! A n n o t a t i o n D i r e c t o r y L o a d e r T e s t . p h p    3     � z     3     �m:qk� @������o��<��m:qk�       �               A n n o t a t i o n F i l e L o a d e r T e s t . p h p       3     � l     3     c3?qk� @������q��<�c3?qk�       �               C l o s u r e L o a d e r T e s t . p h p     3     � p     3     �YFqk� @����?Wt��<��YFqk�       G	               D i r e c t o r y L o a d e r T e s t . p h p 3     x h     3     ��Hqk� @����?Wt��<���Hqk��      }               F i l e L o c a t o r S t u  . p h p 	3     � n     3     ��- qk� @����Ƹv��<���- qk�       �               G l o b F i l e L o a d e r T e s t . p h p   
3     � t     3     `�4 qk� @�����y��<�`�4 qk�                       O b j e c t R o u t e L o a d e r T e s t . p h p     3     � l     3     �uE qk� @�����y��<��uE qk�        �               P h p F i l e L o a d e r T e s t . p h p     3     � l     3     ��N qk� @����K~{��<���N qk� P      7E               X m l F i l e L o a d e r T  s t . p h p     3     � n     3     ͈X qk� @������}��<�͈X qk� @      c4               Y a m l F i l e L o a d e r T e s t . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Loader\ClosureLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ClosureLoaderTest extends TestCase
{
    public function testSupports()
    {
        $loader = new ClosureLoader();

        $closure = function () {};

        $this->assertTrue($loader->supports($closure), '->supports() returns true if the resource is loadable');
        $this->assertFalse($loader->supports('foo.foo'), '->supports() returns true if the resource is loadable');

        $this->assertTrue($loader->supports($closure, 'closure'), '->supports() checks the resource type if specified');
        $this->assertFalse($loader->supports($closure, 'foo'), '->supports() checks the resource type if specified');
    }

    public function testLoad()
    {
        $loader = new ClosureLoader();

        $route = new Route('/');
        $routes = $loader->load(function () use ($route) {
            $routes = new RouteCollection();

            $routes->add('foo', $route);

            return $routes;
        });

        $this->assertEquals($route, $routes->get('foo'), '->load() loads a \Closure resource');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Routing\Loader\AnnotationFileLoader;
use Symfony\Component\Routing\Loader\DirectoryLoader;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

class DirectoryLoaderTest extends AbstractAnnotationLoaderTest
{
    private $loader;
    private $reader;

    protected function setUp()
    {
        parent::setUp();

        $locator = new FileLocator();
        $this->reader = $this->getReader();
        $this->loader = new DirectoryLoader($locator);
        $resolver = new LoaderResolver([
            new YamlFileLoader($locator),
            new AnnotationFileLoader($locator, $this->getClassLoader($this->reader)),
            $this->loader,
        ]);
        $this->loader->setResolver($resolver);
    }

    public function testLoadDirectory()
    {
        $collection = $this->loader->load(__DIR__.'/../Fixtures/directory', 'directory');
        $this->verifyCollection($collection);
    }

    public function testImportDirectory()
    {
        $collection = $this->loader->load(__DIR__.'/../Fixtures/directory_import', 'directory');
        $this->verifyCollection($collection);
    }

    private function verifyCollection(RouteCollection $collection)
    {
        $routes = $collection->all();

        $this->assertCount(3, $routes, 'Three routes are loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        for ($i = 1; $i <= 3; ++$i) {
            $this->assertSame('/route/'.$i, $routes['route'.$i]->getPath());
        }
    }

    public function testSupports()
    {
        $fixturesDir = __DIR__.'/../Fixtures';

        $this->assertFalse($this->loader->supports($fixturesDir), '->supports(*) returns false');

        $this->assertTrue($this->loader->supports($fixturesDir, 'directory'), '->supports(*, "directory") returns true');
        $this->assertFalse($this->loader->supports($fixturesDir, 'foo'), '->supports(*, "foo") returns false');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\GlobResource;
use Symfony\Component\Routing\Loader\GlobFileLoader;
use Symfony\Component\Routing\RouteCollection;

class GlobFileLoaderTest extends TestCase
{
    public function testSupports()
    {
        $loader = new GlobFileLoader(new FileLocator());

        $this->assertTrue($loader->supports('any-path', 'glob'), '->supports() returns true if the resource has the glob type');
        $this->assertFalse($loader->supports('any-path'), '->supports() returns false if the resource is not of glob type');
    }

    public function testLoadAddsTheGlobResourceToTheContainer()
    {
        $loader = new GlobFileLoaderWithoutImport(new FileLocator());
        $collection = $loader->load(__DIR__.'/../Fixtures/directory/*.yml');

        $this->assertEquals(new GlobResource(__DIR__.'/../Fixtures/directory', '/*.yml', false), $collection->getResources()[0]);
    }
}

class GlobFileLoaderWithoutImport extends GlobFileLoader
{
    public function import($resource, $type = null, $ignoreErrors = false, $sourceResource = null)
    {
        return new RouteCollection();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Loader\ObjectRouteLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class ObjectRouteLoaderTest extends TestCase
{
    /**
     * @group legacy
     * @expectedDeprecation Referencing service route loaders with a single colon is deprecated since Symfony 4.1. Use my_route_provider_service::loadRoutes instead.
     */
    public function testLoadCallsServiceAndReturnsCollectionWithLegacyNotation()
    {
        $loader = new ObjectRouteLoaderForTest();

        // create a basic collection that will be returned
        $collection = new RouteCollection();
        $collection->add('foo', new Route('/foo'));

        $loader->loaderMap = [
            'my_route_provider_service' => new RouteService($collection),
        ];

        $actualRoutes = $loader->load(
            'my_route_provider_service:loadRoutes',
            'service'
        );

        $this->assertSame($collection, $actualRoutes);
        // the service file should be listed as a resource
        $this->assertNotEmpty($actualRoutes->getResources());
    }

    public function testLoadCallsServiceAndReturnsCollection()
    {
        $loader = new ObjectRouteLoaderForTest();

        // create a basic collection that will be returned
        $collection = new RouteCollection();
        $collection->add('foo', new Route('/foo'));

        $loader->loaderMap = [
            'my_route_provider_service' => new RouteService($collection),
        ];

        $actualRoutes = $loader->load(
            'my_route_provider_service::loadRoutes',
            'service'
        );

        $this->assertSame($collection, $actualRoutes);
        // the service file should be listed as a resource
        $this->assertNotEmpty($actualRoutes->getResources());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider getBadResourceStrings
     */
    public function testExceptionWithoutSyntax($resourceString)
    {
        $loader = new ObjectRouteLoaderForTest();
        $loader->load($resourceString);
    }

    public function getBadResourceStrings()
    {
        return [
            ['Foo'],
            ['Foo:Bar:baz'],
        ];
    }

    /**
     * @expectedException \LogicException
     */
    public function testExceptionOnNoObjectReturned()
    {
        $loader = new ObjectRouteLoaderForTest();
        $loader->loaderMap = ['my_service' => 'NOT_AN_OBJECT'];
        $loader->load('my_service::method');
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testExceptionOnBadMethod()
    {
        $loader = new ObjectRouteLoaderForTest();
        $loader->loaderMap = ['my_service' => new \stdClass()];
        $loader->load('my_service::method');
    }

    /**
     * @expectedException \LogicException
     */
    public function testExceptionOnMethodNotReturningCollection()
    {
        $service = $this->getMockBuilder('stdClass')
            ->setMethods(['loadRoutes'])
            ->getMock();
        $service->expects($this->once())
            ->method('loadRoutes')
            ->will($this->returnValue('NOT_A_COLLECTION'));

        $loader = new ObjectRouteLoaderForTest();
        $loader->loaderMap = ['my_service' => $service];
        $loader->load('my_service::loadRoutes');
    }
}

class ObjectRouteLoaderForTest extends ObjectRouteLoader
{
    public $loaderMap = [];

    protected function getServiceObject($id)
    {
        return isset($this->loaderMap[$id]) ? $this->loaderMap[$id] : null;
    }
}

class RouteService
{
    private $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function loadRoutes()
    {
        return $this->collection;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class PhpFileLoaderTest extends TestCase
{
    public function testSupports()
    {
        $loader = new PhpFileLoader($this->getMockBuilder('Symfony\Component\Config\FileLocator')->getMock());

        $this->assertTrue($loader->supports('foo.php'), '->supports() returns true if the resource is loadable');
        $this->assertFalse($loader->supports('foo.foo'), '->supports() returns true if the resource is loadable');

        $this->assertTrue($loader->supports('foo.php', 'php'), '->supports() checks the resource type if specified');
        $this->assertFalse($loader->supports('foo.php', 'foo'), '->supports() checks the resource type if specified');
    }

    public function testLoadWithRoute()
    {
        $loader = new PhpFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('validpattern.php');
        $routes = $routeCollection->all();

        $this->assertCount(1, $routes, 'One route is loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        foreach ($routes as $route) {
            $this->assertSame('/blog/{slug}', $route->getPath());
            $this->assertSame('MyBlogBundle:Blog:show', $route->getDefault('_controller'));
            $this->assertSame('{locale}.example.com', $route->getHost());
            $this->assertSame('RouteCompiler', $route->getOption('compiler_class'));
            $this->assertEquals(['GET', 'POST', 'PUT', 'OPTIONS'], $route->getMethods());
            $this->assertEquals(['https'], $route->getSchemes());
        }
    }

    public function testLoadWithImport()
    {
        $loader = new PhpFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('validresource.php');
        $routes = $routeCollection->all();

        $this->assertCount(1, $routes, 'One route is loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        foreach ($routes as $route) {
            $this->assertSame('/prefix/blog/{slug}', $route->getPath());
            $this->assertSame('MyBlogBundle:Blog:show', $route->getDefault('_controller'));
            $this->assertSame('{locale}.example.com', $route->getHost());
            $this->assertSame('RouteCompiler', $route->getOption('compiler_class'));
            $this->assertEquals(['GET', 'POST', 'PUT', 'OPTIONS'], $route->getMethods());
            $this->assertEquals(['https'], $route->getSchemes());
        }
    }

    public function testThatDefiningVariableInConfigFileHasNoSideEffects()
    {
        $locator = new FileLocator([__DIR__.'/../Fixtures']);
        $loader = new PhpFileLoader($locator);
        $routeCollection = $loader->load('with_define_path_variable.php');
        $resources = $routeCollection->getResources();
        $this->assertCount(1, $resources);
        $this->assertContainsOnly('Symfony\Component\Config\Resource\ResourceInterface', $resources);
        $fileResource = reset($resources);
        $this->assertSame(
            realpath($locator->locate('with_define_path_variable.php')),
            (string) $fileResource
        );
    }

    public function testRoutingConfigurator()
    {
        $locator = new FileLocator([__DIR__.'/../Fixtures']);
        $loader = new PhpFileLoader($locator);
        $routeCollectionClosure = $loader->load('php_dsl.php');
        $routeCollectionObject = $loader->load('php_object_dsl.php');

        $expectedCollection = new RouteCollection();

        $expectedCollection->add('foo', (new Route('/foo'))
            ->setOptions(['utf8' => true])
            ->setCondition('abc')
        );
        $expectedCollection->add('buz', (new Route('/zub'))
            ->setDefaults(['_controller' => 'foo:act'])
        );
        $expectedCollection->add('c_root', (new Route('/sub/pub/'))
            ->setRequirements(['id' => '\d+'])
        );
        $expectedCollection->add('c_bar', (new Route('/sub/pub/bar'))
            ->setRequirements(['id' => '\d+'])
        );
        $expectedCollection->add('c_pub_buz', (new Route('/sub/pub/buz'))
            ->setHost('host')
            ->setRequirements(['id' => '\d+'])
        );
        $expectedCollection->add('z_c_root', new Route('/zub/pub/'));
        $expectedCollection->add('z_c_bar', new Route('/zub/pub/bar'));
        $expectedCollection->add('z_c_pub_buz', (new Route('/zub/pub/buz'))->setHost('host'));
        $expectedCollection->add('r_root', new Route('/bus'));
        $expectedCollection->add('r_bar', new Route('/bus/bar/'));
        $expectedCollection->add('ouf', (new Route('/ouf'))
            ->setSchemes(['https'])
            ->setMethods(['GET'])
            ->setDefaults(['id' => 0])
        );

        $expectedCollection->addResource(new FileResource(realpath(__DIR__.'/../Fixtures/php_dsl_sub.php')));
        $expectedCollection->addResource(new FileResource(realpath(__DIR__.'/../Fixtures/php_dsl_sub_root.php')));

        $expectedCollectionClosure = $expectedCollection;
        $expectedCollectionObject = clone $expectedCollection;

        $expectedCollectionClosure->addResource(new FileResource(realpath(__DIR__.'/../Fixtures/php_dsl.php')));
        $expectedCollectionObject->addResource(new FileResource(realpath(__DIR__.'/../Fixtures/php_object_dsl.php')));

        $this->assertEquals($expectedCollectionClosure, $routeCollectionClosure);
        $this->assertEquals($expectedCollectionObject, $routeCollectionObject);
    }

    public function testRoutingConfiguratorCanImportGlobPatterns()
    {
        $locator = new FileLocator([__DIR__.'/../Fixtures/glob']);
        $loader = new PhpFileLoader($locator);
        $routeCollection = $loader->load('php_dsl.php');

        $route = $routeCollection->get('bar_route');
        $this->assertSame('AppBundle:Bar:view', $route->getDefault('_controller'));

        $route = $routeCollection->get('baz_route');
        $this->assertSame('AppBundle:Baz:view', $route->getDefault('_controller'));
    }

    public function testRoutingI18nConfigurator()
    {
        $locator = new FileLocator([__DIR__.'/../Fixtures']);
        $loader = new PhpFileLoader($locator);
        $routeCollection = $loader->load('php_dsl_i18n.php');

        $expectedCollection = new RouteCollection();

        $expectedCollection->add('foo.en', (new Route('/glish/foo'))->setDefaults(['_locale' => 'en', '_canonical_route' => 'foo']));
        $expectedCollection->add('bar.en', (new Route('/glish/bar'))->setDefaults(['_locale' => 'en', '_canonical_route' => 'bar']));
        $expectedCollection->add('baz.en', (new Route('/baz'))->setDefaults(['_locale' => 'en', '_canonical_route' => 'baz']));
        $expectedCollection->add('c_foo.fr', (new Route('/ench/pub/foo'))->setDefaults(['_locale' => 'fr', '_canonical_route' => 'c_foo']));
        $expectedCollection->add('c_bar.fr', (new Route('/ench/pub/bar'))->setDefaults(['_locale' => 'fr', '_canonical_route' => 'c_bar']));

        $expectedCollection->addResource(new FileResource(realpath(__DIR__.'/../Fixtures/php_dsl_sub_i18n.php')));
        $expectedCollection->addResource(new FileResource(realpath(__DIR__.'/../Fixtures/php_dsl_i18n.php')));

        $this->assertEquals($expectedCollection, $routeCollection);
    }
}
                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\XmlFileLoader;
use Symfony\Component\Routing\Tests\Fixtures\CustomXmlFileLoader;

class XmlFileLoaderTest extends TestCase
{
    public function testSupports()
    {
        $loader = new XmlFileLoader($this->getMockBuilder('Symfony\Component\Config\FileLocator')->getMock());

        $this->assertTrue($loader->supports('foo.xml'), '->supports() returns true if the resource is loadable');
        $this->assertFalse($loader->supports('foo.foo'), '->supports() returns true if the resource is loadable');

        $this->assertTrue($loader->supports('foo.xml', 'xml'), '->supports() checks the resource type if specified');
        $this->assertFalse($loader->supports('foo.xml', 'foo'), '->supports() checks the resource type if specified');
    }

    public function testLoadWithRoute()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('validpattern.xml');
        $route = $routeCollection->get('blog_show');

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $route);
        $this->assertSame('/blog/{slug}', $route->getPath());
        $this->assertSame('{locale}.example.com', $route->getHost());
        $this->assertSame('MyBundle:Blog:show', $route->getDefault('_controller'));
        $this->assertSame('\w+', $route->getRequirement('locale'));
        $this->assertSame('RouteCompiler', $route->getOption('compiler_class'));
        $this->assertEquals(['GET', 'POST', 'PUT', 'OPTIONS'], $route->getMethods());
        $this->assertEquals(['https'], $route->getSchemes());
        $this->assertEquals('context.getMethod() == "GET"', $route->getCondition());
    }

    public function testLoadWithNamespacePrefix()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('namespaceprefix.xml');

        $this->assertCount(1, $routeCollection->all(), 'One route is loaded');

        $route = $routeCollection->get('blog_show');
        $this->assertSame('/blog/{slug}', $route->getPath());
        $this->assertSame('{_locale}.example.com', $route->getHost());
        $this->assertSame('MyBundle:Blog:show', $route->getDefault('_controller'));
        $this->assertSame('\w+', $route->getRequirement('slug'));
        $this->assertSame('en|fr|de', $route->getRequirement('_locale'));
        $this->assertNull($route->getDefault('slug'));
        $this->assertSame('RouteCompiler', $route->getOption('compiler_class'));
        $this->assertSame(1, $route->getDefault('page'));
    }

    public function testLoadWithImport()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('validresource.xml');
        $routes = $routeCollection->all();

        $this->assertCount(2, $routes, 'Two routes are loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        foreach ($routes as $route) {
            $this->assertSame('/{foo}/blog/{slug}', $route->getPath());
            $this->assertSame('123', $route->getDefault('foo'));
            $this->assertSame('\d+', $route->getRequirement('foo'));
            $this->assertSame('bar', $route->getOption('foo'));
            $this->assertSame('', $route->getHost());
            $this->assertSame('context.getMethod() == "POST"', $route->getCondition());
        }
    }

    public function testUtf8Route()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routeCollection = $loader->load('utf8.xml');
        $routes = $routeCollection->all();

        $this->assertCount(2, $routes, 'Two routes are loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        $utf8Route = $routeCollection->get('app_utf8');

        $this->assertSame('/utf8', $utf8Route->getPath());
        $this->assertTrue($utf8Route->getOption('utf8'), 'Must be utf8');

        $noUtf8Route = $routeCollection->get('app_no_utf8');

        $this->assertSame('/no-utf8', $noUtf8Route->getPath());
        $this->assertFalse($noUtf8Route->getOption('utf8'), 'Must not be utf8');
    }

    public function testLoadLocalized()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('localized.xml');
        $routes = $routeCollection->all();

        $this->assertCount(2, $routes, 'Two routes are loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        $this->assertEquals('/route', $routeCollection->get('localized.fr')->getPath());
        $this->assertEquals('/path', $routeCollection->get('localized.en')->getPath());
    }

    public function testLocalizedImports()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routeCollection = $loader->load('importer-with-locale.xml');
        $routes = $routeCollection->all();

        $this->assertCount(2, $routes, 'Two routes are loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        $this->assertEquals('/le-prefix/le-suffix', $routeCollection->get('imported.fr')->getPath());
        $this->assertEquals('/the-prefix/suffix', $routeCollection->get('imported.en')->getPath());
    }

    public function testLocalizedImportsOfNotLocalizedRoutes()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routeCollection = $loader->load('importer-with-locale-imports-non-localized-route.xml');
        $routes = $routeCollection->all();

        $this->assertCount(2, $routes, 'Two routes are loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        $this->assertEquals('/le-prefix/suffix', $routeCollection->get('imported.fr')->getPath());
        $this->assertEquals('/the-prefix/suffix', $routeCollection->get('imported.en')->getPath());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider getPathsToInvalidFiles
     */
    public function testLoadThrowsExceptionWithInvalidFile($filePath)
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $loader->load($filePath);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider getPathsToInvalidFiles
     */
    public function testLoadThrowsExceptionWithInvalidFileEvenWithoutSchemaValidation($filePath)
    {
        $loader = new CustomXmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $loader->load($filePath);
    }

    public function getPathsToInvalidFiles()
    {
        return [['nonvalidnode.xml'], ['nonvalidroute.xml'], ['nonvalid.xml'], ['missing_id.xml'], ['missing_path.xml']];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Document types are not allowed.
     */
    public function testDocTypeIsNotAllowed()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $loader->load('withdoctype.xml');
    }

    public function testNullValues()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('null_values.xml');
        $route = $routeCollection->get('blog_show');

        $this->assertTrue($route->hasDefault('foo'));
        $this->assertNull($route->getDefault('foo'));
        $this->assertTrue($route->hasDefault('bar'));
        $this->assertNull($route->getDefault('bar'));
        $this->assertEquals('foo', $route->getDefault('foobar'));
        $this->assertEquals('bar', $route->getDefault('baz'));
    }

    public function testScalarDataTypeDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('scalar_defaults.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                '_controller' => 'AcmeBlogBundle:Blog:index',
                'slug' => null,
                'published' => true,
                'page' => 1,
                'price' => 3.5,
                'archived' => false,
                'free' => true,
                'locked' => false,
                'foo' => null,
                'bar' => null,
            ],
            $route->getDefaults()
        );
    }

    public function testListDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('list_defaults.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                '_controller' => 'AcmeBlogBundle:Blog:index',
                'values' => [true, 1, 3.5, 'foo'],
            ],
            $route->getDefaults()
        );
    }

    public function testListInListDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('list_in_list_defaults.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                '_controller' => 'AcmeBlogBundle:Blog:index',
                'values' => [[true, 1, 3.5, 'foo']],
            ],
            $route->getDefaults()
        );
    }

    public function testListInMapDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('list_in_map_defaults.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                '_controller' => 'AcmeBlogBundle:Blog:index',
                'values' => ['list' => [true, 1, 3.5, 'foo']],
            ],
            $route->getDefaults()
        );
    }

    public function testMapDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('map_defaults.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                '_controller' => 'AcmeBlogBundle:Blog:index',
                'values' => [
                    'public' => true,
                    'page' => 1,
                    'price' => 3.5,
                    'title' => 'foo',
                ],
            ],
            $route->getDefaults()
        );
    }

    public function testMapInListDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('map_in_list_defaults.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                '_controller' => 'AcmeBlogBundle:Blog:index',
                'values' => [[
                    'public' => true,
                    'page' => 1,
                    'price' => 3.5,
                    'title' => 'foo',
                ]],
            ],
            $route->getDefaults()
        );
    }

    public function testMapInMapDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('map_in_map_defaults.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                '_controller' => 'AcmeBlogBundle:Blog:index',
                'values' => ['map' => [
                    'public' => true,
                    'page' => 1,
                    'price' => 3.5,
                    'title' => 'foo',
                ]],
            ],
            $route->getDefaults()
        );
    }

    public function testNullValuesInList()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('list_null_values.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame([null, null, null, null, null, null], $route->getDefault('list'));
    }

    public function testNullValuesInMap()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('map_null_values.xml');
        $route = $routeCollection->get('blog');

        $this->assertSame(
            [
                'boolean' => null,
                'integer' => null,
                'float' => null,
                'string' => null,
                'list' => null,
                'map' => null,
            ],
            $route->getDefault('map')
        );
    }

    public function testLoadRouteWithControllerAttribute()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load('routing.xml');

        $route = $routeCollection->get('app_homepage');

        $this->assertSame('AppBundle:Homepage:show', $route->getDefault('_controller'));
    }

    public function testLoadRouteWithoutControllerAttribute()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load('routing.xml');

        $route = $routeCollection->get('app_logout');

        $this->assertNull($route->getDefault('_controller'));
    }

    public function testLoadRouteWithControllerSetInDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load('routing.xml');

        $route = $routeCollection->get('app_blog');

        $this->assertSame('AppBundle:Blog:list', $route->getDefault('_controller'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /The routing file "[^"]*" must not specify both the "controller" attribute and the defaults key "_controller" for "app_blog"/
     */
    public function testOverrideControllerInDefaults()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $loader->load('override_defaults.xml');
    }

    /**
     * @dataProvider provideFilesImportingRoutesWithControllers
     */
    public function testImportRouteWithController($file)
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load($file);

        $route = $routeCollection->get('app_homepage');
        $this->assertSame('FrameworkBundle:Template:template', $route->getDefault('_controller'));

        $route = $routeCollection->get('app_blog');
        $this->assertSame('FrameworkBundle:Template:template', $route->getDefault('_controller'));

        $route = $routeCollection->get('app_logout');
        $this->assertSame('FrameworkBundle:Template:template', $route->getDefault('_controller'));
    }

    public function provideFilesImportingRoutesWithControllers()
    {
        yield ['import_controller.xml'];
        yield ['import__controller.xml'];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /The routing file "[^"]*" must not specify both the "controller" attribute and the defaults key "_controller" for the "import" tag/
     */
    public function testImportWithOverriddenController()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $loader->load('import_override_defaults.xml');
    }

    public function testImportRouteWithGlobMatchingSingleFile()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/glob']));
        $routeCollection = $loader->load('import_single.xml');

        $route = $routeCollection->get('bar_route');
        $this->assertSame('AppBundle:Bar:view', $route->getDefault('_controller'));
    }

    public function testImportRouteWithGlobMatchingMultipleFiles()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/glob']));
        $routeCollection = $loader->load('import_multiple.xml');

        $route = $routeCollection->get('bar_route');
        $this->assertSame('AppBundle:Bar:view', $route->getDefault('_controller'));

        $route = $routeCollection->get('baz_route');
        $this->assertSame('AppBundle:Baz:view', $route->getDefault('_controller'));
    }

    public function testImportRouteWithNamePrefix()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/import_with_name_prefix']));
        $routeCollection = $loader->load('routing.xml');

        $this->assertNotNull($routeCollection->get('app_blog'));
        $this->assertEquals('/blog', $routeCollection->get('app_blog')->getPath());
        $this->assertNotNull($routeCollection->get('api_app_blog'));
        $this->assertEquals('/api/blog', $routeCollection->get('api_app_blog')->getPath());
    }

    public function testImportRouteWithNoTrailingSlash()
    {
        $loader = new XmlFileLoader(new FileLocator([__DIR__.'/../Fixtures/import_with_no_trailing_slash']));
        $routeCollection = $loader->load('routing.xml');

        $this->assertEquals('/slash/', $routeCollection->get('a_app_homepage')->getPath());
        $this->assertEquals('/no-slash', $routeCollection->get('b_app_homepage')->getPath());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Loader;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\Routing\Loader\YamlFileLoader;

class YamlFileLoaderTest extends TestCase
{
    public function testSupports()
    {
        $loader = new YamlFileLoader($this->getMockBuilder('Symfony\Component\Config\FileLocator')->getMock());

        $this->assertTrue($loader->supports('foo.yml'), '->supports() returns true if the resource is loadable');
        $this->assertTrue($loader->supports('foo.yaml'), '->supports() returns true if the resource is loadable');
        $this->assertFalse($loader->supports('foo.foo'), '->supports() returns true if the resource is loadable');

        $this->assertTrue($loader->supports('foo.yml', 'yaml'), '->supports() checks the resource type if specified');
        $this->assertTrue($loader->supports('foo.yaml', 'yaml'), '->supports() checks the resource type if specified');
        $this->assertFalse($loader->supports('foo.yml', 'foo'), '->supports() checks the resource type if specified');
    }

    public function testLoadDoesNothingIfEmpty()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $collection = $loader->load('empty.yml');

        $this->assertEquals([], $collection->all());
        $this->assertEquals([new FileResource(realpath(__DIR__.'/../Fixtures/empty.yml'))], $collection->getResources());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @dataProvider getPathsToInvalidFiles
     */
    public function testLoadThrowsExceptionWithInvalidFile($filePath)
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $loader->load($filePath);
    }

    public function getPathsToInvalidFiles()
    {
        return [
            ['nonvalid.yml'],
            ['nonvalid2.yml'],
            ['incomplete.yml'],
            ['nonvalidkeys.yml'],
            ['nonesense_resource_plus_path.yml'],
            ['nonesense_type_without_resource.yml'],
            ['bad_format.yml'],
        ];
    }

    public function testLoadSpecialRouteName()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('special_route_name.yml');
        $route = $routeCollection->get('#$péß^a|');

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $route);
        $this->assertSame('/true', $route->getPath());
    }

    public function testLoadWithRoute()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('validpattern.yml');
        $route = $routeCollection->get('blog_show');

        $this->assertInstanceOf('Symfony\Component\Routing\Route', $route);
        $this->assertSame('/blog/{slug}', $route->getPath());
        $this->assertSame('{locale}.example.com', $route->getHost());
        $this->assertSame('MyBundle:Blog:show', $route->getDefault('_controller'));
        $this->assertSame('\w+', $route->getRequirement('locale'));
        $this->assertSame('RouteCompiler', $route->getOption('compiler_class'));
        $this->assertEquals(['GET', 'POST', 'PUT', 'OPTIONS'], $route->getMethods());
        $this->assertEquals(['https'], $route->getSchemes());
        $this->assertEquals('context.getMethod() == "GET"', $route->getCondition());
    }

    public function testLoadWithResource()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $routeCollection = $loader->load('validresource.yml');
        $routes = $routeCollection->all();

        $this->assertCount(2, $routes, 'Two routes are loaded');
        $this->assertContainsOnly('Symfony\Component\Routing\Route', $routes);

        foreach ($routes as $route) {
            $this->assertSame('/{foo}/blog/{slug}', $route->getPath());
            $this->assertSame('123', $route->getDefault('foo'));
            $this->assertSame('\d+', $route->getRequirement('foo'));
            $this->assertSame('bar', $route->getOption('foo'));
            $this->assertSame('', $route->getHost());
            $this->assertSame('context.getMethod() == "POST"', $route->getCondition());
        }
    }

    public function testLoadRouteWithControllerAttribute()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load('routing.yml');

        $route = $routeCollection->get('app_homepage');

        $this->assertSame('AppBundle:Homepage:show', $route->getDefault('_controller'));
    }

    public function testLoadRouteWithoutControllerAttribute()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load('routing.yml');

        $route = $routeCollection->get('app_logout');

        $this->assertNull($route->getDefault('_controller'));
    }

    public function testLoadRouteWithControllerSetInDefaults()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load('routing.yml');

        $route = $routeCollection->get('app_blog');

        $this->assertSame('AppBundle:Blog:list', $route->getDefault('_controller'));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /The routing file "[^"]*" must not specify both the "controller" key and the defaults key "_controller" for "app_blog"/
     */
    public function testOverrideControllerInDefaults()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $loader->load('override_defaults.yml');
    }

    /**
     * @dataProvider provideFilesImportingRoutesWithControllers
     */
    public function testImportRouteWithController($file)
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $routeCollection = $loader->load($file);

        $route = $routeCollection->get('app_homepage');
        $this->assertSame('FrameworkBundle:Template:template', $route->getDefault('_controller'));

        $route = $routeCollection->get('app_blog');
        $this->assertSame('FrameworkBundle:Template:template', $route->getDefault('_controller'));

        $route = $routeCollection->get('app_logout');
        $this->assertSame('FrameworkBundle:Template:template', $route->getDefault('_controller'));
    }

    public function provideFilesImportingRoutesWithControllers()
    {
        yield ['import_controller.yml'];
        yield ['import__controller.yml'];
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /The routing file "[^"]*" must not specify both the "controller" key and the defaults key "_controller" for "_static"/
     */
    public function testImportWithOverriddenController()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/controller']));
        $loader->load('import_override_defaults.yml');
    }

    public function testImportRouteWithGlobMatchingSingleFile()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/glob']));
        $routeCollection = $loader->load('import_single.yml');

        $route = $routeCollection->get('bar_route');
        $this->assertSame('AppBundle:Bar:view', $route->getDefault('_controller'));
    }

    public function testImportRouteWithGlobMatchingMultipleFiles()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/glob']));
        $routeCollection = $loader->load('import_multiple.yml');

        $route = $routeCollection->get('bar_route');
        $this->assertSame('AppBundle:Bar:view', $route->getDefault('_controller'));

        $route = $routeCollection->get('baz_route');
        $this->assertSame('AppBundle:Baz:view', $route->getDefault('_controller'));
    }

    public function testImportRouteWithNamePrefix()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/import_with_name_prefix']));
        $routeCollection = $loader->load('routing.yml');

        $this->assertNotNull($routeCollection->get('app_blog'));
        $this->assertEquals('/blog', $routeCollection->get('app_blog')->getPath());
        $this->assertNotNull($routeCollection->get('api_app_blog'));
        $this->assertEquals('/api/blog', $routeCollection->get('api_app_blog')->getPath());
    }

    public function testRemoteSourcesAreNotAccepted()
    {
        $loader = new YamlFileLoader(new FileLocatorStub());
        $this->expectException(\InvalidArgumentException::class);
        $loader->load('http://remote.com/here.yml');
    }

    public function testLoadingLocalizedRoute()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routes = $loader->load('localized-route.yml');

        $this->assertCount(3, $routes);
    }

    public function testImportingRoutesFromDefinition()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routes = $loader->load('importing-localized-route.yml');

        $this->assertCount(3, $routes);
        $this->assertEquals('/nl', $routes->get('home.nl')->getPath());
        $this->assertEquals('/en', $routes->get('home.en')->getPath());
        $this->assertEquals('/here', $routes->get('not_localized')->getPath());
    }

    public function testImportingRoutesWithLocales()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routes = $loader->load('importer-with-locale.yml');

        $this->assertCount(2, $routes);
        $this->assertEquals('/nl/voorbeeld', $routes->get('imported.nl')->getPath());
        $this->assertEquals('/en/example', $routes->get('imported.en')->getPath());
    }

    public function testImportingNonLocalizedRoutesWithLocales()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routes = $loader->load('importer-with-locale-imports-non-localized-route.yml');

        $this->assertCount(2, $routes);
        $this->assertEquals('/nl/imported', $routes->get('imported.nl')->getPath());
        $this->assertEquals('/en/imported', $routes->get('imported.en')->getPath());
    }

    public function testImportingRoutesWithOfficialLocales()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routes = $loader->load('officially_formatted_locales.yml');

        $this->assertCount(3, $routes);
        $this->assertEquals('/omelette-au-fromage', $routes->get('official.fr.UTF-8')->getPath());
        $this->assertEquals('/eu-não-sou-espanhol', $routes->get('official.pt-PT')->getPath());
        $this->assertEquals('/churrasco', $routes->get('official.pt_BR')->getPath());
    }

    public function testImportingRoutesFromDefinitionMissingLocalePrefix()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $this->expectException(\InvalidArgumentException::class);
        $loader->load('missing-locale-in-importer.yml');
    }

    public function testImportingRouteWithoutPathOrLocales()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $this->expectException(\InvalidArgumentException::class);
        $loader->load('route-without-path-or-locales.yml');
    }

    public function testImportingWithControllerDefault()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/localized']));
        $routes = $loader->load('importer-with-controller-default.yml');
        $this->assertCount(3, $routes);
        $this->assertEquals('DefaultController::defaultAction', $routes->get('home.en')->getDefault('_controller'));
        $this->assertEquals('DefaultController::defaultAction', $routes->get('home.nl')->getDefault('_controller'));
        $this->assertEquals('DefaultController::defaultAction', $routes->get('not_localized')->getDefault('_controller'));
    }

    public function testImportRouteWithNoTrailingSlash()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures/import_with_no_trailing_slash']));
        $routeCollection = $loader->load('routing.yml');

        $this->assertEquals('/slash/', $routeCollection->get('a_app_homepage')->getPath());
        $this->assertEquals('/no-slash', $routeCollection->get('b_app_homepage')->getPath());
    }

    /**
     * @group legacy
     * @expectedDeprecation A placeholder name must be a string (0 given). Did you forget to specify the placeholder key for the requirement "\d+" of route "foo" in "%srequirements_without_placeholder_name.yml"?
     */
    public function testRequirementsWithoutPlaceholderName()
    {
        $loader = new YamlFileLoader(new FileLocator([__DIR__.'/../Fixtures']));
        $loader->load('requirements_without_placeholder_name.yml');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Matcher;

use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcherInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class CompiledRedirectableUrlMatcherTest extends RedirectableUrlMatcherTest
{
    protected function getUrlMatcher(RouteCollection $routes, RequestContext $context = null)
    {
        $dumper = new CompiledUrlMatcherDumper($routes);
        $compiledRoutes = $dumper->getCompiledRoutes();

        return $this->getMockBuilder(TestCompiledRedirectableUrlMatcher::class)
            ->setConstructorArgs([$compiledRoutes, $context ?: new RequestContext()])
            ->setMethods(['redirect'])
            ->getMock();
    }
}

class TestCompiledRedirectableUrlMatcher extends CompiledUrlMatcher implements RedirectableUrlMatcherInterface
{
    public function redirect($path, $route, $scheme = null)
    {
        return [];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Matcher;

use Symfony\Component\Routing\Matcher\CompiledUrlMatcher;
use Symfony\Component\Routing\Matcher\Dumper\CompiledUrlMatcherDumper;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class CompiledUrlMatcherTest extends UrlMatcherTest
{
    protected function getUrlMatcher(RouteCollection $routes, RequestContext $context = null)
    {
        $dumper = new CompiledUrlMatcherDumper($routes);

        return new CompiledUrlMatcher($dumper->getCompiledRoutes(), $context ?: new RequestContext());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Matcher;

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class DumpedRedirectableUrlMatcherTest extends RedirectableUrlMatcherTest
{
    protected function getUrlMatcher(RouteCollection $routes, RequestContext $context = null)
    {
        static $i = 0;

        $class = 'DumpedRedirectableUrlMatcher'.++$i;
        $dumper = new PhpMatcherDumper($routes);
        eval('?>'.$dumper->dump(['class' => $class, 'base_class' => 'Symfony\Component\Routing\Tests\Matcher\TestDumpedRedirectableUrlMatcher']));

        return $this->getMockBuilder($class)
            ->setConstructorArgs([$context ?: new RequestContext()])
            ->setMethods(['redirect'])
            ->getMock();
    }
}

class TestDumpedRedirectableUrlMatcher extends UrlMatcher implements RedirectableUrlMatcherInterface
{
    public function redirect($path, $route, $scheme = null)
    {
        return [];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Matcher;

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class DumpedUrlMatcherTest extends UrlMatcherTest
{
    protected function getUrlMatcher(RouteCollection $routes, RequestContext $context = null)
    {
        static $i = 0;

        $class = 'DumpedUrlMatcher'.++$i;
        $dumper = new PhpMatcherDumper($routes);
        eval('?>'.$dumper->dump(['class' => $class]));

        return new $class($context ?: new RequestContext());
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Matcher;

use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RedirectableUrlMatcherTest extends UrlMatcherTest
{
    public function testMissingTrailingSlash()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo/'));

        $matcher = $this->getUrlMatcher($coll);
        $matcher->expects($this->once())->method('redirect')->will($this->returnValue([]));
        $matcher->match('/foo');
    }

    public function testExtraTrailingSlash()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo'));

        $matcher = $this->getUrlMatcher($coll);
        $matcher->expects($this->once())->method('redirect')->will($this->returnValue([]));
        $matcher->match('/foo/');
    }

    /**
     * @expectedException \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function testRedirectWhenNoSlashForNonSafeMethod()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo/'));

        $context = new RequestContext();
        $context->setMethod('POST');
        $matcher = $this->getUrlMatcher($coll, $context);
        $matcher->match('/foo');
    }

    public function testSchemeRedirectRedirectsToFirstScheme()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo', [], [], [], '', ['FTP', 'HTTPS']));

        $matcher = $this->getUrlMatcher($coll);
        $matcher
            ->expects($this->once())
            ->method('redirect')
            ->with('/foo', 'foo', 'ftp')
            ->will($this->returnValue(['_route' => 'foo']))
        ;
        $matcher->match('/foo');
    }

    public function testNoSchemaRedirectIfOneOfMultipleSchemesMatches()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo', [], [], [], '', ['https', 'http']));

        $matcher = $this->getUrlMatcher($coll);
        $matcher
            ->expects($this->never())
            ->method('redirect');
        $matcher->match('/foo');
    }

    public function testSchemeRedirectWithParams()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo/{bar}', [], [], [], '', ['https']));

        $matcher = $this->getUrlMatcher($coll);
        $matcher
            ->expects($this->once())
            ->method('redirect')
            ->with('/foo/baz', 'foo', 'https')
            ->will($this->returnValue(['redirect' => 'value']))
        ;
        $this->assertEquals(['_route' => 'foo', 'bar' => 'baz', 'redirect' => 'value'], $matcher->match('/foo/baz'));
    }

    public function testSchemeRedirectForRoot()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/', [], [], [], '', ['https']));

        $matcher = $this->getUrlMatcher($coll);
        $matcher
            ->expects($this->once())
            ->method('redirect')
            ->with('/', 'foo', 'https')
            ->will($this->returnValue(['redirect' => 'value']));
        $this->assertEquals(['_route' => 'foo', 'redirect' => 'value'], $matcher->match('/'));
    }

    public function testSlashRedirectWithParams()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo/{bar}/'));

        $matcher = $this->getUrlMatcher($coll);
        $matcher
            ->expects($this->once())
            ->method('redirect')
            ->with('/foo/baz/', 'foo', null)
            ->will($this->returnValue(['redirect' => 'value']))
        ;
        $this->assertEquals(['_route' => 'foo', 'bar' => 'baz', 'redirect' => 'value'], $matcher->match('/foo/baz'));
    }

    public function testRedirectPreservesUrlEncoding()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo:bar/'));

        $matcher = $this->getUrlMatcher($coll);
        $matcher->expects($this->once())->method('redirect')->with('/foo%3Abar/')->willReturn([]);
        $matcher->match('/foo%3Abar');
    }

    public function testSchemeRequirement()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo', [], [], [], '', ['https']));
        $matcher = $this->getUrlMatcher($coll, new RequestContext());
        $matcher->expects($this->once())->method('redirect')->with('/foo', 'foo', 'https')->willReturn([]);
        $this->assertSame(['_route' => 'foo'], $matcher->match('/foo'));
    }

    public function testFallbackPage()
    {
        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo/'));
        $coll->add('bar', new Route('/{name}'));

        $matcher = $this->getUrlMatcher($coll);
        $matcher->expects($this->once())->method('redirect')->with('/foo/', 'foo')->will($this->returnValue(['_route' => 'foo']));
        $this->assertSame(['_route' => 'foo'], $matcher->match('/foo'));

        $coll = new RouteCollection();
        $coll->add('foo', new Route('/foo'));
        $coll->add('bar', new Route('/{name}/'));

        $matcher = $this->getUrlMatcher($coll);
        $matcher->expects($this->once())->method('redirect')->with('/foo', 'foo')->will($this->returnValue(['_route' => 'foo']));
        $this->assertSame(['_route' => 'foo'], $matcher->match('/foo/'));
    }

    public function testMissingTrailingSlashAndScheme()
    {
        $coll = new RouteCollection();
        $coll->add('foo', (new Route('/foo/'))->setSchemes(['https']));

        $matcher = $this->getUrlMatcher($coll);
        $matcher->expects($this->once())->method('redirect')->with('/foo/', 'foo', 'https')->will($this->returnValue([]));
        $matcher->match('/foo');
    }

    public function testSlashAndVerbPrecedenceWithRedirection()
    {
        $coll = new RouteCollection();
        $coll->add('a', new Route('/api/customers/{customerId}/contactpersons', [], [], [], '', [], ['post']));
        $coll->add('b', new Route('/api/customers/{customerId}/contactpersons/', [], [], [], '', [], ['get']));