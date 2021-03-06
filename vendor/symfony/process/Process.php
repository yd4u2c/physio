l;

        return $this;
    }

    /**
     * Get an option value.
     *
     * @param string $name An option name
     *
     * @return mixed The option value or null when not given
     */
    public function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * Checks if an option has been set.
     *
     * @param string $name An option name
     *
     * @return bool true if the option is set, false otherwise
     */
    public function hasOption($name)
    {
        return \array_key_exists($name, $this->options);
    }

    /**
     * Returns the defaults.
     *
     * @return array The defaults
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Sets the defaults.
     *
     * This method implements a fluent interface.
     *
     * @param array $defaults The defaults
     *
     * @return $this
     */
    public function setDefaults(array $defaults)
    {
        $this->defaults = [];

        return $this->addDefaults($defaults);
    }

    /**
     * Adds defaults.
     *
     * This method implements a fluent interface.
     *
     * @param array $defaults The defaults
     *
     * @return $this
     */
    public function addDefaults(array $defaults)
    {
        foreach ($defaults as $name => $default) {
            $this->defaults[$name] = $default;
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Gets a default value.
     *
     * @param string $name A variable name
     *
     * @return mixed The default value or null when not given
     */
    public function getDefault($name)
    {
        return isset($this->defaults[$name]) ? $this->defaults[$name] : null;
    }

    /**
     * Checks if a default value is set for the given variable.
     *
     * @param string $name A variable name
     *
     * @return bool true if the default value is set, false otherwise
     */
    public function hasDefault($name)
    {
        return \array_key_exists($name, $this->defaults);
    }

    /**
     * Sets a default value.
     *
     * @param string $name    A variable name
     * @param mixed  $default The default value
     *
     * @return $this
     */
    public function setDefault($name, $default)
    {
        $this->defaults[$name] = $default;
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the requirements.
     *
     * @return array The requirements
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Sets the requirements.
     *
     * This method implements a fluent interface.
     *
     * @param array $requirements The requirements
     *
     * @return $this
     */
    public function setRequirements(array $requirements)
    {
        $this->requirements = [];

        return $this->addRequirements($requirements);
    }

    /**
     * Adds requirements.
     *
     * This method implements a fluent interface.
     *
     * @param array $requirements The requirements
     *
     * @return $this
     */
    public function addRequirements(array $requirements)
    {
        foreach ($requirements as $key => $regex) {
            $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        }
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the requirement for the given key.
     *
     * @param string $key The key
     *
     * @return string|null The regex or null when not given
     */
    public function getRequirement($key)
    {
        return isset($this->requirements[$key]) ? $this->requirements[$key] : null;
    }

    /**
     * Checks if a requirement is set for the given key.
     *
     * @param string $key A variable name
     *
     * @return bool true if a requirement is specified, false otherwise
     */
    public function hasRequirement($key)
    {
        return \array_key_exists($key, $this->requirements);
    }

    /**
     * Sets a requirement for the given key.
     *
     * @param string $key   The key
     * @param string $regex The regex
     *
     * @return $this
     */
    public function setRequirement($key, $regex)
    {
        $this->requirements[$key] = $this->sanitizeRequirement($key, $regex);
        $this->compiled = null;

        return $this;
    }

    /**
     * Returns the condition.
     *
     * @return string The condition
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * Sets the condition.
     *
     * This method implements a fluent interface.
     *
     * @param string $condition The condition
     *
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->condition = (string) $condition;
        $this->compiled = null;

        return $this;
    }

    /**
     * Compiles the route.
     *
     * @return CompiledRoute A CompiledRoute instance
     *
     * @throws \LogicException If the Route cannot be compiled because the
     *                         path or host pattern is invalid
     *
     * @see RouteCompiler which is responsible for the compilation process
     */
    public function compile()
    {
        if (null !== $this->compiled) {
            return $this->compiled;
        }

        $class = $this->getOption('compiler_class');

        return $this->compiled = $class::compile($this);
    }

    private function sanitizeRequirement($key, $regex)
    {
        if (!\is_string($regex)) {
            throw new \InvalidArgumentException(sprintf('Routing requirement for "%s" must be a string.', $key));
        }

        if ('' !== $regex && '^' === $regex[0]) {
            $regex = (string) substr($regex, 1); // returns false for a single character
        }

        if ('$' === substr($regex, -1)) {
            $regex = substr($regex, 0, -1);
        }

        if ('' === $regex) {
            throw new \InvalidArgumentException(sprintf('Routing requirement for "%s" cannot be empty.', $key));
        }

        return $regex;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

use Symfony\Component\Config\Resource\ResourceInterface;

/**
 * A RouteCollection represents a set of Route instances.
 *
 * When adding a route at the end of the collection, an existing route
 * with the same name is removed first. So there can only be one route
 * with a given name.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class RouteCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @var array
     */
    private $resources = [];

    public function __clone()
    {
        foreach ($this->routes as $name => $route) {
            $this->routes[$name] = clone $route;
        }
    }

    /**
     * Gets the current RouteCollection as an Iterator that includes all routes.
     *
     * It implements \IteratorAggregate.
     *
     * @see all()
     *
     * @return \ArrayIterator|Route[] An \ArrayIterator object for iterating over routes
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->routes);
    }

    /**
     * Gets the number of Routes in this collection.
     *
     * @return int The number of routes
     */
    public function count()
    {
        return \count($this->routes);
    }

    /**
     * Adds a route.
     *
     * @param string $name  The route name
     * @param Route  $route A Route instance
     */
    public function add($name, Route $route)
    {
        unset($this->routes[$name]);

        $this->routes[$name] = $route;
    }

    /**
     * Returns all routes in this collection.
     *
     * @return Route[] An array of routes
     */
    public function all()
    {
        return $this->routes;
    }

    /**
     * Gets a route by name.
     *
     * @param string $name The route name
     *
     * @return Route|null A Route instance or null when not found
     */
    public function get($name)
    {
        return isset($this->routes[$name]) ? $this->routes[$name] : null;
    }

    /**
     * Removes a route or an array of routes by name from the collection.
     *
     * @param string|string[] $name The route name or an array of route names
     */
    public function remove($name)
    {
        foreach ((array) $name as $n) {
            unset($this->routes[$n]);
        }
    }

    /**
     * Adds a route collection at the end of the current set by appending all
     * routes of the added collection.
     */
    public function addCollection(self $collection)
    {
        // we need to remove all routes with the same names first because just replacing them
        // would not place the new route at the end of the merged array
        foreach ($collection->all() as $name => $route) {
            unset($this->routes[$name]);
            $this->routes[$name] = $route;
        }

        foreach ($collection->getResources() as $resource) {
            $this->addResource($resource);
        }
    }

    /**
     * Adds a prefix to the path of all child routes.
     *
     * @param string $prefix       An optional prefix to add before each pattern of the route collection
     * @param array  $defaults     An array of default values
     * @param array  $requirements An array of requirements
     */
    public function addPrefix($prefix, array $defaults = [], array $requirements = [])
    {
        $prefix = trim(trim($prefix), '/');

        if ('' === $prefix) {
            return;
        }

        foreach ($this->routes as $route) {
            $route->setPath('/'.$prefix.$route->getPath());
            $route->addDefaults($defaults);
            $route->addRequirements($requirements);
        }
    }

    /**
     * Adds a prefix to the name of all the routes within in the collection.
     */
    public function addNamePrefix(string $prefix)
    {
        $prefixedRoutes = [];

        foreach ($this->routes as $name => $route) {
            $prefixedRoutes[$prefix.$name] = $route;
            if (null !== $name = $route->getDefault('_canonical_route')) {
                $route->setDefault('_canonical_route', $prefix.$name);
            }
        }

        $this->routes = $prefixedRoutes;
    }

    /**
     * Sets the host pattern on all routes.
     *
     * @param string $pattern      The pattern
     * @param array  $defaults     An array of default values
     * @param array  $requirements An array of requirements
     */
    public function setHost($pattern, array $defaults = [], array $requirements = [])
    {
        foreach ($this->routes as $route) {
            $route->setHost($pattern);
            $route->addDefaults($defaults);
            $route->addRequirements($requirements);
        }
    }

    /**
     * Sets a condition on all routes.
     *
     * Existing conditions will be overridden.
     *
     * @param string $condition The condition
     */
    public function setCondition($condition)
    {
        foreach ($this->routes as $route) {
            $route->setCondition($condition);
        }
    }

    /**
     * Adds defaults to all routes.
     *
     * An existing default value under the same name in a route will be overridden.
     *
     * @param array $defaults An array of default values
     */
    public function addDefaults(array $defaults)
    {
        if ($defaults) {
            foreach ($this->routes as $route) {
                $route->addDefaults($defaults);
            }
        }
    }

    /**
     * Adds requirements to all routes.
     *
     * An existing requirement under the same name in a route will be overridden.
     *
     * @param array $requirements An array of requirements
     */
    public function addRequirements(array $requirements)
    {
        if ($requirements) {
            foreach ($this->routes as $route) {
                $route->addRequirements($requirements);
            }
        }
    }

    /**
     * Adds options to all routes.
     *
     * An existing option value under the same name in a route will be overridden.
     *
     * @param array $options An array of options
     */
    public function addOptions(array $options)
    {
        if ($options) {
            foreach ($this->routes as $route) {
                $route->addOptions($options);
            }
        }
    }

    /**
     * Sets the schemes (e.g. 'https') all child routes are restricted to.
     *
     * @param string|string[] $schemes The scheme or an array of schemes
     */
    public function setSchemes($schemes)
    {
        foreach ($this->routes as $route) {
            $route->setSchemes($schemes);
        }
    }

    /**
     * Sets the HTTP methods (e.g. 'POST') all child routes are restricted to.
     *
     * @param string|string[] $methods The method or an array of methods
     */
    public function setMethods($methods)
    {
        foreach ($this->routes as $route) {
            $route->setMethods($methods);
        }
    }

    /**
     * Returns an array of resources loaded to build this collection.
     *
     * @return ResourceInterface[] An array of resources
     */
    public function getResources()
    {
        return array_values($this->resources);
    }

    /**
     * Adds a resource for this collection. If the resource already exists
     * it is not added.
     */
    public function addResource(ResourceInterface $resource)
    {
        $key = (string) $resource;

        if (!isset($this->resources[$key])) {
            $this->resources[$key] = $resource;
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

use Symfony\Component\Config\Exception\LoaderLoadException;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Resource\ResourceInterface;

/**
 * Helps add and import routes into a RouteCollection.
 *
 * @author Ryan Weaver <ryan@knpuniversity.com>
 */
class RouteCollectionBuilder
{
    /**
     * @var Route[]|RouteCollectionBuilder[]
     */
    private $routes = [];

    private $loader;
    private $defaults = [];
    private $prefix;
    private $host;
    private $condition;
    private $requirements = [];
    private $options = [];
    private $schemes;
    private $methods;
    private $resources = [];

    public function __construct(LoaderInterface $loader = null)
    {
        $this->loader = $loader;
    }

    /**
     * Import an external routing resource and returns the RouteCollectionBuilder.
     *
     *     $routes->import('blog.yml', '/blog');
     *
     * @param mixed       $resource
     * @param string|null $prefix
     * @param string      $type
     *
     * @return self
     *
     * @throws LoaderLoadException
     */
    public function import($resource, $prefix = '/', $type = null)
    {
        /** @var RouteCollection[] $collections */
        $collections = $this->load($resource, $type);

        // create a builder from the RouteCollection
        $builder = $this->createBuilder();

        foreach ($collections as $collection) {
            if (null === $collection) {
                continue;
            }

            foreach ($collection->all() as $name => $route) {
                $builder->addRoute($route, $name);
            }

            foreach ($collection->getResources() as $resource) {
                $builder->addResource($resource);
            }
        }

        // mount into this builder
        $this->mount($prefix, $builder);

        return $builder;
    }

    /**
     * Adds a route and returns it for future modification.
     *
     * @param string      $path       The route path
     * @param string      $controller The route's controller
     * @param string|null $name       The name to give this route
     *
     * @return Route
     */
    public function add($path, $controller, $name = null)
    {
        $route = new Route($path);
        $route->setDefault('_controller', $controller);
        $this->addRoute($route, $name);

        return $route;
    }

    /**
     * Returns a RouteCollectionBuilder that can be configured and then added with mount().
     *
     * @return self
     */
    public function createBuilder()
    {
        return new self($this->loader);
    }

    /**
     * Add a RouteCollectionBuilder.
     *
     * @param string                 $prefix
     * @param RouteCollectionBuilder $builder
     */
    public function mount($prefix, self $builder)
    {
        $builder->prefix = trim(trim($prefix), '/');
        $this->routes[] = $builder;
    }

    /**
     * Adds a Route object to the builder.
     *
     * @param Route       $route
     * @param string|null $name
     *
     * @return $this
     */
    public function addRoute(Route $route, $name = null)
    {
        if (null === $name) {
            // used as a flag to know which routes will need a name later
            $name = '_unnamed_route_'.spl_object_hash($route);
        }

        $this->routes[$name] = $route;

        return $this;
    }

    /**
     * Sets the host on all embedded routes (unless already set).
     *
     * @param string $pattern
     *
     * @return $this
     */
    public function setHost($pattern)
    {
        $this->host = $pattern;

        return $this;
    }

    /**
     * Sets a condition on all embedded routes (unless already set).
     *
     * @param string $condition
     *
     * @return $this
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;

        return $this;
    }

    /**
     * Sets a default value that will be added to all embedded routes (unless that
     * default value is already set).
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setDefault($key, $value)
    {
        $this->defaults[$key] = $value;

        return $this;
    }

    /**
     * Sets a requirement that will be added to all embedded routes (unless that
     * requirement is already set).
     *
     * @param string $key
     * @param mixed  $regex
     *
     * @return $this
     */
    public function setRequirement($key, $regex)
    {
        $this->requirements[$key] = $regex;

        return $this;
    }

    /**
     * Sets an option that will be added to all embedded routes (unless that
     * option is already set).
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    /**
     * Sets the schemes on all embedded routes (unless already set).
     *
     * @param array|string $schemes
     *
     * @return $this
     */
    public function setSchemes($schemes)
    {
        $this->schemes = $schemes;

        return $this;
    }

    /**
     * Sets the methods on all embedded routes (unless already set).
     *
     * @param array|string $methods
     *
     * @return $this
     */
    public function setMethods($methods)
    {
        $this->methods = $methods;

        return $this;
    }

    /**
     * Adds a resource for this collection.
     *
     * @return $this
     */
    private function addResource(ResourceInterface $resource): self
    {
        $this->resources[] = $resource;

        return $this;
    }

    /**
     * Creates the final RouteCollection and returns it.
     *
     * @return RouteCollection
     */
    public function build()
    {
        $routeCollection = new RouteCollection();

        foreach ($this->routes as $name => $route) {
            if ($route instanceof Route) {
                $route->setDefaults(array_merge($this->defaults, $route->getDefaults()));
                $route->setOptions(array_merge($this->options, $route->getOptions()));

                foreach ($this->requirements as $key => $val) {
                    if (!$route->hasRequirement($key)) {
                        $route->setRequirement($key, $val);
                    }
                }

                if (null !== $this->prefix) {
                    $route->setPath('/'.$this->prefix.$route->getPath());
                }

                if (!$route->getHost()) {
                    $route->setHost($this->host);
                }

                if (!$route->getCondition()) {
                    $route->setCondition($this->condition);
                }

                if (!$route->getSchemes()) {
                    $route->setSchemes($this->schemes);
                }

                if (!$route->getMethods()) {
                    $route->setMethods($this->methods);
                }

                // auto-generate the route name if it's been marked
                if ('_unnamed_route_' === substr($name, 0, 15)) {
                    $name = $this->generateRouteName($route);
                }

                $routeCollection->add($name, $route);
            } else {
                /* @var self $route */
                $subCollection = $route->build();
                $subCollection->addPrefix($this->prefix);

                $routeCollection->addCollection($subCollection);
            }
        }

        foreach ($this->resources as $resource) {
            $routeCollection->addResource($resource);
        }

        return $routeCollection;
    }

    /**
     * Generates a route name based on details of this route.
     */
    private function generateRouteName(Route $route): string
    {
        $methods = implode('_', $route->getMethods()).'_';

        $routeName = $methods.$route->getPath();
        $routeName = str_replace(['/', ':', '|', '-'], '_', $routeName);
        $routeName = preg_replace('/[^a-z0-9A-Z_.]+/', '', $routeName);

        // Collapse consecutive underscores down into a single underscore.
        $routeName = preg_replace('/_+/', '_', $routeName);

        return $routeName;
    }

    /**
     * Finds a loader able to load an imported resource and loads it.
     *
     * @param mixed       $resource A resource
     * @param string|null $type     The resource type or null if unknown
     *
     * @return RouteCollection[]
     *
     * @throws LoaderLoadException If no loader is found
     */
    private function load($resource, string $type = null): array
    {
        if (null === $this->loader) {
            throw new \BadMethodCallException('Cannot import other routing resources: you must pass a LoaderInterface when constructing RouteCollectionBuilder.');
        }

        if ($this->loader->supports($resource, $type)) {
            $collections = $this->loader->load($resource, $type);

            return \is_array($collections) ? $collections : [$collections];
        }

        if (null === $resolver = $this->loader->getResolver()) {
            throw new LoaderLoadException($resource, null, null, null, $type);
        }

        if (false === $loader = $resolver->resolve($resource, $type)) {
            throw new LoaderLoadException($resource, null, null, null, $type);
        }

        $collections = $loader->load($resource, $type);

        return \is_array($collections) ? $collections : [$collections];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

/**
 * RouteCompiler compiles Route instances to CompiledRoute instances.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class RouteCompiler implements RouteCompilerInterface
{
    const REGEX_DELIMITER = '#';

    /**
     * This string defines the characters that are automatically considered separators in front of
     * optional placeholders (with default and no static text following). Such a single separator
     * can be left out together with the optional placeholder from matching and generating URLs.
     */
    const SEPARATORS = '/,;.:-_~+*=@|';

    /**
     * The maximum supported length of a PCRE subpattern name
     * http://pcre.org/current/doc/html/pcre2pattern.html#SEC16.
     *
     * @internal
     */
    const VARIABLE_MAXIMUM_LENGTH = 32;

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException if a path variable is named _fragment
     * @throws \LogicException           if a variable is referenced more than once
     * @throws \DomainException          if a variable name starts with a digit or if it is too long to be successfully used as
     *                                   a PCRE subpattern
     */
    public static function compile(Route $route)
    {
        $hostVariables = [];
        $variables = [];
        $hostRegex = null;
        $hostTokens = [];

        if ('' !== $host = $route->getHost()) {
            $result = self::compilePattern($route, $host, true);

            $hostVariables = $result['variables'];
            $variables = $hostVariables;

            $hostTokens = $result['tokens'];
            $hostRegex = $result['regex'];
        }

        $path = $route->getPath();

        $result = self::compilePattern($route, $path, false);

        $staticPrefix = $result['staticPrefix'];

        $pathVariables = $result['variables'];

        foreach ($pathVariables as $pathParam) {
            if ('_fragment' === $pathParam) {
                throw new \InvalidArgumentException(sprintf('Route pattern "%s" cannot contain "_fragment" as a path parameter.', $route->getPath()));
            }
        }

        $variables = array_merge($variables, $pathVariables);

        $tokens = $result['tokens'];
        $regex = $result['regex'];

        return new CompiledRoute(
            $staticPrefix,
            $regex,
            $tokens,
            $pathVariables,
            $hostRegex,
            $hostTokens,
            $hostVariables,
            array_unique($variables)
        );
    }

    private static function compilePattern(Route $route, $pattern, $isHost)
    {
        $tokens = [];
        $variables = [];
        $matches = [];
        $pos = 0;
        $defaultSeparator = $isHost ? '.' : '/';
        $useUtf8 = preg_match('//u', $pattern);
        $needsUtf8 = $route->getOption('utf8');

        if (!$needsUtf8 && $useUtf8 && preg_match('/[\x80-\xFF]/', $pattern)) {
            throw new \LogicException(sprintf('Cannot use UTF-8 route patterns without setting the "utf8" option for route "%s".', $route->getPath()));
        }
        if (!$useUtf8 && $needsUtf8) {
            throw new \LogicException(sprintf('Cannot mix UTF-8 requirements with non-UTF-8 pattern "%s".', $pattern));
        }

        // Match all variables enclosed in "{}" and iterate over them. But we only want to match the innermost variable
        // in case of nested "{}", e.g. {foo{bar}}. This in ensured because \w does not match "{" or "}" itself.
        preg_match_all('#\{\w+\}#', $pattern, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        foreach ($matches as $match) {
            $varName = substr($match[0][0], 1, -1);
            // get all static text preceding the current variable
            $precedingText = substr($pattern, $pos, $match[0][1] - $pos);
            $pos = $match[0][1] + \strlen($match[0][0]);

            if (!\strlen($precedingText)) {
                $precedingChar = '';
            } elseif ($useUtf8) {
                preg_match('/.$/u', $precedingText, $precedingChar);
                $precedingChar = $precedingChar[0];
            } else {
                $precedingChar = substr($precedingText, -1);
            }
            $isSeparator = '' !== $precedingChar && false !== strpos(static::SEPARATORS, $precedingChar);

            // A PCRE subpattern name must start with a non-digit. Also a PHP variable cannot start with a digit so the
            // variable would not be usable as a Controller action argument.
            if (preg_match('/^\d/', $varName)) {
                throw new \DomainException(sprintf('Variable name "%s" cannot start with a digit in route pattern "%s". Please use a different name.', $varName, $pattern));
            }
            if (\in_array($varName, $variables)) {
                throw new \LogicException(sprintf('Route pattern "%s" cannot reference variable name "%s" more than once.', $pattern, $varName));
            }

            if (\strlen($varName) > self::VARIABLE_MAXIMUM_LENGTH) {
                throw new \DomainException(sprintf('Variable name "%s" cannot be longer than %s characters in route pattern "%s". Please use a shorter name.', $varName, self::VARIABLE_MAXIMUM_LENGTH, $pattern));
            }

            if ($isSeparator && $precedingText !== $precedingChar) {
                $tokens[] = ['text', substr($precedingText, 0, -\strlen($precedingChar))];
            } elseif (!$isSeparator && \strlen($precedingText) > 0) {
                $tokens[] = ['text', $precedingText];
            }

            $regexp = $route->getRequirement($varName);
            if (null === $regexp) {
                $followingPattern = (string) substr($pattern, $pos);
                // Find the next static character after the variable that functions as a separator. By default, this separator and '/'
                // are disallowed for the variable. This default requirement makes sure that optional variables can be matched at all
                // and that the generating-matching-combination of URLs unambiguous, i.e. the params used for generating the URL are
                // the same that will be matched. Example: new Route('/{page}.{_format}', ['_format' => 'html'])
                // If {page} would also match the separating dot, {_format} would never match as {page} will eagerly consume everything.
                // Also even if {_format} was not optional the requirement prevents that {page} matches something that was originally
                // part of {_format} when generating the URL, e.g. _format = 'mobile.html'.
                $nextSeparator = self::findNextSeparator($followingPattern, $useUtf8);
                $regexp = sprintf(
                    '[^%s%s]+',
                    preg_quote($defaultSeparator, self::REGEX_DELIMITER),
                    $defaultSeparator !== $nextSeparator && '' !== $nextSeparator ? preg_quote($nextSeparator, self::REGEX_DELIMITER) : ''
                );
                if (('' !== $nextSeparator && !preg_match('#^\{\w+\}#', $followingPattern)) || '' === $followingPattern) {
                    // When we have a separator, which is disallowed for the variable, we can optimize the regex with a possessive
                    // quantifier. This prevents useless backtracking of PCRE and improves performance by 20% for matching those patterns.
                    // Given the above example, there is no point in backtracking into {page} (that forbids the dot) when a dot must follow
                    // after it. This optimization cannot be applied when the next char is no real separator or when the next variable is
                    // directly adjacent, e.g. '/{x}{y}'.
                    $regexp .= '+';
                }
            } else {
                if (!preg_match('//u', $regexp)) {
                    $useUtf8 = false;
                } elseif (!$needsUtf8 && preg_match('/[\x80-\xFF]|(?<!\\\\)\\\\(?:\\\\\\\\)*+(?-i:X|[pP][\{CLMNPSZ]|x\{[A-Fa-f0-9]{3})/', $regexp)) {
                    throw new \LogicException(sprintf('Cannot use UTF-8 route requirements without setting the "utf8" option for variable "%s" in pattern "%s".', $varName, $pattern));
                }
                if (!$useUtf8 && $needsUtf8) {
                    throw new \LogicException(sprintf('Cannot mix UTF-8 requirement with non-UTF-8 charset for variable "%s" in pattern "%s".', $varName, $pattern));
                }
                $regexp = self::transformCapturingGroupsToNonCapturings($regexp);
            }

            $tokens[] = ['variable', $isSeparator ? $precedingChar : '', $regexp, $varName];
            $variables[] = $varName;
        }

        if ($pos < \strlen($pattern)) {
            $tokens[] = ['text', substr($pattern, $pos)];
        }

        // find the first optional token
        $firstOptional = PHP_INT_MAX;
        if (!$isHost) {
            for ($i = \count($tokens) - 1; $i >= 0; --$i) {
                $token = $tokens[$i];
                if ('variable' === $token[0] && $route->hasDefault($token[3])) {
                    $firstOptional = $i;
                } else {
                    break;
                }
            }
        }

        // compute the matching regexp
        $regexp = '';
        for ($i = 0, $nbToken = \count($tokens); $i < $nbToken; ++$i) {
            $regexp .= self::computeRegexp($tokens, $i, $firstOptional);
        }
        $regexp = self::REGEX_DELIMITER.'^'.$regexp.'$'.self::REGEX_DELIMITER.'sD'.($isHost ? 'i' : '');

        // enable Utf8 matching if really required
        if ($needsUtf8) {
            $regexp .= 'u';
            for ($i = 0, $nbToken = \count($tokens); $i < $nbToken; ++$i) {
                if ('variable' === $tokens[$i][0]) {
                    $tokens[$i][] = true;
                }
            }
        }

        return [
            'staticPrefix' => self::determineStaticPrefix($route, $tokens),
            'regex' => $regexp,
            'tokens' => array_reverse($tokens),
            'variables' => $variables,
        ];
    }

    /**
     * Determines the longest static prefix possible for a route.
     */
    private static function determineStaticPrefix(Route $route, array $tokens): string
    {
        if ('text' !== $tokens[0][0]) {
            return ($route->hasDefault($tokens[0][3]) || '/' === $tokens[0][1]) ? '' : $tokens[0][1];
        }

        $prefix = $tokens[0][1];

        if (isset($tokens[1][1]) && '/' !== $tokens[1][1] && false === $route->hasDefault($tokens[1][3])) {
            $prefix .= $tokens[1][1];
        }

        return $prefix;
    }

    /**
     * Returns the next static character in the Route pattern that will serve as a separator (or the empty string when none available).
     */
    private static function findNextSeparator(string $pattern, bool $useUtf8): string
    {
        if ('' == $pattern) {
            // return empty string if pattern is empty or false (false which can be returned by substr)
            return '';
        }
        // first remove all placeholders from the pattern so we can find the next real static character
        if ('' === $pattern = preg_replace('#\{\w+\}#', '', $pattern)) {
            return '';
        }
        if ($useUtf8) {
            preg_match('/^./u', $pattern, $pattern);
        }

        return false !== strpos(static::SEPARATORS, $pattern[0]) ? $pattern[0] : '';
    }

    /**
     * Computes the regexp used to match a specific token. It can be static text or a subpattern.
     *
     * @param array $tokens        The route tokens
     * @param int   $index         The index of the current token
     * @param int   $firstOptional The index of the first optional token
     *
     * @return string The regexp pattern for a single token
     */
    private static function computeRegexp(array $tokens, int $index, int $firstOptional): string
    {
        $token = $tokens[$index];
        if ('text' === $token[0]) {
            // Text tokens
            return preg_quote($token[1], self::REGEX_DELIMITER);
        } else {
            // Variable tokens
            if (0 === $index && 0 === $firstOptional) {
                // When the only token is an optional variable token, the separator is required
                return sprintf('%s(?P<%s>%s)?', preg_quote($token[1], self::REGEX_DELIMITER), $token[3], $token[2]);
            } else {
                $regexp = sprintf('%s(?P<%s>%s)', preg_quote($token[1], self::REGEX_DELIMITER), $token[3], $token[2]);
                if ($index >= $firstOptional) {
                    // Enclose each optional token in a subpattern to make it optional.
                    // "?:" means it is non-capturing, i.e. the portion of the subject string that
                    // matched the optional subpattern is not passed back.
                    $regexp = "(?:$regexp";
                    $nbTokens = \count($tokens);
                    if ($nbTokens - 1 == $index) {
                        // Close the optional subpatterns
                        $regexp .= str_repeat(')?', $nbTokens - $firstOptional - (0 === $firstOptional ? 1 : 0));
                    }
                }

                return $regexp;
            }
        }
    }

    private static function transformCapturingGroupsToNonCapturings(string $regexp): string
    {
        for ($i = 0; $i < \strlen($regexp); ++$i) {
            if ('\\' === $regexp[$i]) {
                ++$i;
                continue;
            }
            if ('(' !== $regexp[$i] || !isset($regexp[$i + 2])) {
                continue;
            }
            if ('*' === $regexp[++$i] || '?' === $regexp[$i]) {
                ++$i;
                continue;
            }
            $regexp = substr_replace($regexp, '?:', $i, 0);
            ++$i;
        }

        return $regexp;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

/**
 * RouteCompilerInterface is the interface that all RouteCompiler classes must implement.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
interface RouteCompilerInterface
{
    /**
     * Compiles the current route instance.
     *
     * @return CompiledRoute A CompiledRoute instance
     *
     * @throws \LogicException If the Route cannot be compiled because the
     *                         path or host pattern is invalid
     */
    public static function compile(Route $route);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing;

use Psr\Log\LoggerInterface;
use Symfony\Component\Config\ConfigCacheFactory;
use Symfony\Component\Config\ConfigCacheFactoryInterface;
use Symfony\Component\Config\ConfigCacheInterface;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\ExpressionLanguage\ExpressionFunctionProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\ConfigurableRequirementsInterface;
use Symfony\Component\Routing\Generator\Dumper\GeneratorDumperInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\Dumper\MatcherDumperInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;

/**
 * The Router class is an example of the integration of all pieces of the
 * routing system for easier use.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class Router implements RouterInterface, RequestMatcherInterface
{
    /**
     * @var UrlMatcherInterface|null
     */
    protected $matcher;

    /**
     * @var UrlGeneratorInterface|null
     */
    protected $generator;

    /**
     * @var RequestContext
     */
    protected $context;

    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * @var RouteCollection|null
     */
    protected $collection;

    /**
     * @var mixed
     */
    protected $resource;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * @var string|null
     */
    protected $defaultLocale;

    /**
     * @var ConfigCacheFactoryInterface|null
     */
    private $configCacheFactory;

    /**
     * @var ExpressionFunctionProviderInterface[]
     */
    private $expressionLanguageProviders = [];

    /**
     * @param LoaderInterface $loader   A LoaderInterface instance
     * @param mixed           $resource The main resource to load
     * @param array           $options  An array of options
     * @param RequestContext  $context  The context
     * @param LoggerInterface $logger   A logger instance
     */
    public function __construct(LoaderInterface $loader, $resource, array $options = [], RequestContext $context = null, LoggerInterface $logger = null, string $defaultLocale = null)
    {
        $this->loader = $loader;
        $this->resource = $resource;
        $this->logger = $logger;
        $this->context = $context ?: new RequestContext();
        $this->setOptions($options);
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * Sets options.
     *
     * Available options:
     *
     *   * cache_dir:              The cache directory (or null to disable caching)
     *   * debug:                  Whether to enable debugging or not (false by default)
     *   * generator_class:        The name of a UrlGeneratorInterface impl