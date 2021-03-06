INDX( 	 4<�             (   0  �       d                     *2     � n     )2     ˤqk���� %���� %�ˤqk�       a               C o m p i l e d U r l M a t c h e r . p h p   12     ` N     )2     6q�qk�S��<��үqk�6q�qk�                        D u m p e r c +2     � v     )2     R-�qk� @��������<�R-�qk�       +               R e d i r e c t a b l e U r l M a t c h e r . p h p   ,2     � �     )2     &��qk� @����({���<�&��qk�       G              # R e  i r e c t a b l e U r l M a t c h e r I n t e r f a c e . p h p -2     � x     )2     �qk� @���������<��qk�                      R e q u e s t M a t c h e r I n t e r f a c e . p h p .2     � p     )2     ���qk� @���������<����qk�        �               T r a c e a b l e U r l M a t c h e r . p h p /2     p ^     )2     �z�qk� @����6?���<��z�qk� 0      �&               U r l M a t c h e r . p h p   02     � p     )2     �@�qk� @����6?���<��@�qk�       �              U r l M a t c h e r I n t e r f a c e . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Matcher;

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\NoConfigurationException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContextAwareInterface;

/**
 * UrlMatcherInterface is the interface that all URL matcher classes must implement.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface UrlMatcherInterface extends RequestContextAwareInterface
{
    /**
     * Tries to match a URL path with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
     * @param string $pathinfo The path info to be parsed (raw format, i.e. not urldecoded)
     *
     * @return array An array of parameters
     *
     * @throws NoConfigurationException  If no routing configuration could be found
     * @throws ResourceNotFoundException If the resource could not be found
     * @throws MethodNotAllowedException If the resource was found but the request method is not allowed
     */
    public function match($pathinfo);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Matcher\Dumper;

use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * CompiledUrlMatcherDumper creates PHP arrays to be used with CompiledUrlMatcher.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 * @author Arnaud Le Blanc <arnaud.lb@gmail.com>
 * @author Nicolas Grekas <p@tchwork.com>
 */
class CompiledUrlMatcherDumper extends MatcherDumper
{
    private $expressionLanguage;
    private $signalingException;

    /**
     * @var ExpressionFunctionProviderInterface[]
     */
    private $expressionLanguageProviders = [];

    /**
     * {@inheritdoc}
     */
    public function dump(array $options = [])
    {
        return <<<EOF
<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
{$this->generateCompiledRoutes()}];

EOF;
    }

    public function addExpressionLanguageProvider(ExpressionFunctionProviderInterface $provider)
    {
        $this->expressionLanguageProviders[] = $provider;
    }

    /**
     * Generates the arrays for CompiledUrlMatcher's constructor.
     */
    public function getCompiledRoutes(bool $forDump = false): array
    {
        // Group hosts by same-suffix, re-order when possible
        $matchHost = false;
        $routes = new StaticPrefixCollection();
        foreach ($this->getRoutes()->all() as $name => $route) {
            if ($host = $route->getHost()) {
                $matchHost = true;
                $host = '/'.strtr(strrev($host), '}.{', '(/)');
            }

            $routes->addRoute($host ?: '/(.*)', [$name, $route]);
        }

        if ($matchHost) {
            $compiledRoutes = [true];
            $routes = $routes->populateCollection(new RouteCollection());
        } else {
            $compiledRoutes = [false];
            $routes = $this->getRoutes();
        }

        list($staticRoutes, $dynamicRoutes) = $this->groupStaticRoutes($routes);

        $conditions = [null];
        $compiledRoutes[] = $this->compileStaticRoutes($staticRoutes, $conditions);
        $chunkLimit = \count($dynamicRoutes);

        while (true) {
            try {
                $this->signalingException = new \RuntimeException('preg_match(): Compilation failed: regular expression is too large');
                $compiledRoutes = array_merge($compiledRoutes, $this->compileDynamicRoutes($dynamicRoutes, $matchHost, $chunkLimit, $conditions));

                break;
            } catch (\Exception $e) {
                if (1 < $chunkLimit && $this->signalingException === $e) {
                    $chunkLimit = 1 + ($chunkLimit >> 1);
                    continue;
                }
                throw $e;
            }
        }

        if ($forDump) {
            $compiledRoutes[2] = $compiledRoutes[4];
        }
        unset($conditions[0]);

        if ($conditions) {
            foreach ($conditions as $expression => $condition) {
                $conditions[$expression] = "case {$condition}: return {$expression};";
            }

            $checkConditionCode = <<<EOF
    static function (\$condition, \$context, \$request) { // \$checkCondition
        switch (\$condition) {
{$this->indent(implode("\n", $conditions), 3)}
        }
    }
EOF;
            $compiledRoutes[4] = $forDump ? $checkConditionCode .= ",\n" : eval('return '.$checkConditionCode.';');
        } else {
            $compiledRoutes[4] = $forDump ? "    null, // \$checkCondition\n" : null;
        }

        return $compiledRoutes;
    }

    private function generateCompiledRoutes(): string
    {
        list($matchHost, $staticRoutes, $regexpCode, $dynamicRoutes, $checkConditionCode) = $this->getCompiledRoutes(true);

        $code = self::export($matchHost).', // $matchHost'."\n";

        $code .= '[ // $staticRoutes'."\n";
        foreach ($staticRoutes as $path => $routes) {
            $code .= sprintf("    %s => [\n", self::export($path));
            foreach ($routes as $route) {
                $code .= sprintf("        [%s, %s, %s, %s, %s, %s, %s],\n", ...array_map([__CLASS__, 'export'], $route));
            }
            $code .= "    ],\n";
        }
        $code .= "],\n";

        $code .= sprintf("[ // \$