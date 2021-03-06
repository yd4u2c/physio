<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Loader\Configurator\Traits;

use Symfony\Component\Routing\Loader\Configurator\CollectionConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RouteConfigurator;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

trait AddTrait
{
    /**
     * @var RouteCollection
     */
    private $collection;

    private $name = '';

    private $prefixes;

    /**
     * Adds a route.
     *
     * @param string|array $path the path, or the localized paths of the route
     */
    final public function add(string $name, $path): RouteConfigurator
    {
        $paths = [];
        $parentConfigurator = $this instanceof CollectionConfigurator ? $this : ($this instanceof RouteConfigurator ? $this->parentConfigurator : null);

        if (\is_array($path)) {
            if (null === $this->prefixes) {
                $paths = $path;
            } elseif ($missing = array_diff_key($this->prefixes, $path)) {
                throw new \LogicException(sprintf('Route "%s" is missing routes for locale(s) "%s".', $name, implode('", "', array_keys($missing))));
            } else {
                foreach ($path as $locale => $localePath) {
                    if (!isset($this->prefixes[$locale])) {
                        throw new \LogicException(sprintf('Route "%s" with locale "%s" is missing a corresponding prefix in its parent collection.', $name, $locale));
                    }

                    $paths[$locale] = $this->prefixes[$locale].$localePath;
                }
            }
        } elseif (null !== $this->prefixes) {
            foreach ($this->prefixes as $locale => $prefix) {
                $paths[$locale] = $prefix.$path;
            }
        } else {
            $this->collection->add($this->name.$name, $route = $this->createRoute($path));

            return new RouteConfigurator($this->collection, $route, $this->name, $parentConfigurator, $this->prefixes);
        }

        $routes = new RouteCollection();

        foreach ($paths as $locale => $path) {
            $routes->add($name.'.'.$locale, $route = $this->createRoute($path));
            $this->collection->add($this->name.$name.'.'.$locale, $route);
            $route->setDefault('_locale', $locale);
            $route->setDefault('_canonical_route', $this->name.$name);
        }

        return new RouteConfigurator($this->collection, $routes, $this->name, $parentConfigurator, $this->prefixes);
    }

    /**
     * Adds a route.
     *
     * @param string|array $path the path, or the localized paths of the route
     */
    final public function __invoke(string $name, $path): RouteConfigurator
    {
        return $this->add($name, $path);
    }

    private function createRoute($path): Route
    {
        return new Route($path);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Loader\Configurator\Traits;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

trait RouteTrait
{
    /**
     * @var RouteCollection|Route
     */
    private $route;

    /**
     * Adds defaults.
     *
     * @return $this
     */
    final public function defaults(array $defaults)
    {
        $this->route->addDefaults($defaults);

        return $this;
    }

    /**
     * Adds requirements.
     *
     * @return $this
     */
    final public function requirements(array $requirements)
    {
        $this->route->addRequirements($requirements);

        return $this;
    }

    /**
     * Adds options.
     *
     * @return $this
     */
    final public function options(array $options)
    {
        $this->route->addOptions($options);

        return $this;
    }

    /**
     * Sets the condition.
     *
     * @return $this
     */
    final public function condition(string $condition)
    {
        $this->route->setCondition($condition);

        return $this;
    }

    /**
     * Sets the pattern for the host.
     *
     * @return $this
     */
    final public function host(string $pattern)
    {
        $this->route->setHost($pattern);

        return $this;
    }

    /**
     * Sets the schemes (e.g. 'https') this route is restricted to.
     * So an empty array means that any scheme is allowed.
     *
     * @param string[] $schemes
     *
     * @return $this
     */
    final public function schemes(array $schemes)
    {
        $this->route->setSchemes($schemes);

        return $this;
    }

    /**
     * Sets the HTTP methods (e.g. 'POST') this route is restricted to.
     * So an empty array means that any method is allowed.
     *
     * @param string[] $methods
     *
     * @return $this
     */
    final public function methods(array $methods)
    {
        $this->route->setMethods($methods);

        return $this;
    }

    /**
     * Adds the "_controller" entry to defaults.
     *
     * @param callable|string $controller a callable or parseable pseudo-callable
     *
     * @return $this
     */
    final public function controller($controller)
    {
        $this->route->addDefaults(['_controller' => $controller]);

        return $this;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Loader\DependencyInjection;

use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Loader\ObjectRouteLoader;

/**
 * A route loader that executes a service to load the routes.
 *
 * @author Ryan Weaver <ryan@knpuniversity.com>
 */
class ServiceRouterLoader extends ObjectRouteLoader
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getServiceObject($id)
    {
        return $this->container->get($id);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?xml version="1.0" encoding="UTF-8" ?>

<xsd:schema xmlns="http://symfony.com/schema/routing"
    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
    targetNamespace="http://symfony.com/schema/routing"
    elementFormDefault="qualified">

  <xsd:annotation>
    <xsd:documentation><![CDATA[
      Symfony XML Routing Schema, version 1.0
      Authors: Fabien Potencier, Tobias Schultze

      This scheme defines the elements and attributes that can be used to define
      routes. A route maps an HTTP request to a set of configuration variables.
    ]]></xsd:documentation>
  </xsd:annotation>

  <xsd:element name="routes" type="routes" />

  <xsd:complexType name="routes">
    <xsd:choice minOccurs="0" maxOccurs="unbounded">
      <xsd:element name="import" type="import" />
      <xsd:element name="route" type="route" />
    </xsd:choice>
  </xsd:complexType>

  <xsd:complexType name="localized-path">
    <xsd:simpleContent>
      <xsd:extension base="xsd:string">
        <xsd:attribute name="locale" type="xsd:string" use="required" />
      </xsd:extension>
    </xsd:simpleContent>
  </xsd:complexType>

  <xsd:group name="configs">
    <xsd:choice>
      <xsd:element name="default" nillable="true" type="default" />
      <xsd:element name="requirement" type="element" />
      <xsd:element name="option" type="element" />
      <xsd:element name="condition" type="xsd:string" />
    </xsd:choice>
  </xsd:group>

  <xsd:complexType name="route">
    <xsd:sequence>
      <xsd:group ref="configs" minOccurs="0" maxOccurs="unbounded" />
      <xsd:element name="path" type="localized-path" minOccurs="0" maxOccurs="unbounded" />
    </xsd:sequence>
    <xsd:attribute name="id" type="xsd:string" use="required" />
    <xsd:attribute name="path" type="xsd:string" />
    <xsd:attribute name="host" type="xsd:string" />
    <xsd:attribute name="schemes" type="xsd:string" />
    <xsd:attribute name="methods" type="xsd:string" />
    <xsd:attribute name="controller" type="xsd:string" />
  </xsd:complexType>

  <xsd:complexType 