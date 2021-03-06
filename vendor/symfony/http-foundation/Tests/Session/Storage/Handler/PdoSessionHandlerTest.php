<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Controller;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Container;

/**
 * A controller resolver searching for a controller in a psr-11 container when using the "service:method" notation.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Maxime Steinhausser <maxime.steinhausser@gmail.com>
 */
class ContainerControllerResolver extends ControllerResolver
{
    protected $container;

    public function __construct(ContainerInterface $container, LoggerInterface $logger = null)
    {
        $this->container = $container;

        parent::__construct($logger);
    }

    protected function createController($controller)
    {
        if (1 === substr_count($controller, ':')) {
            $controller = str_replace(':', '::', $controller);
            // TODO deprecate this in 5.1
        }

        return parent::createController($controller);
    }

    /**
     * {@inheritdoc}
     */
    protected function instantiateController($class)
    {
        if ($this->container->has($class)) {
            return $this->container->get($class);
        }

        try {
            return parent::instantiateController($class);
        } catch (\Error $e) {
        }

        $this->throwExceptionIfControllerWasRemoved($class, $e);

        if ($e instanceof \ArgumentCountError) {
            throw new \InvalidArgumentException(sprintf('Controller "%s" has required constructor arguments and does not exist in the container. Did you forget to define such a service?', $class), 0, $e);
        }

        throw new \InvalidArgumentException(sprintf('Controller "%s" does neither exist as service nor as class', $class), 0, $e);
    }

    private function throwExceptionIfControllerWasRemoved(string $controller, \Throwable $previous)
    {
        if ($this->container instanceof Container && isset($this->container->getRemovedIds()[$controller])) {
            throw new \InvalidArgumentException(sprintf('Controller "%s" cannot be fetched from the container because it is private. Did you forget to tag the service with "controller.service_arguments"?', $controller), 0, $previous);
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             INDX( 	 �Ѩ             (   �  �       �                    �/     x b     �/     O[+�pk��dߴ %��-�pk�O[+�pk�                        A r g u m e n t R e s o l v e r . p h �/     � j     �/     :��pk� �V0e ���`��<�:��pk�       �               A r g u m e n t R e s o l v e r . p h p       �/     � |     �/     gH�pk� �V0e ���`��<�gH�pk�       �               A r g u m e n t R e s o l v e r I n t e r f a c e . p h p     �/     � �     �/     6��pk� �V0e �QSc��<�6��pk        j              " A r g u m e n t V a l u e R e s o l v e r I n t e r f a c e . p h p   �/     � �     �/     ��pk� �V0e �c�e��<���pk�       �	               C o n t a i n e r C o n t r o l l e r R e s o l v e r . p h p �/     � p     �/     �o�pk� �V0e ��h��<��o�pk�                      C o n t r o l l e r R e f e r e n c e . p h p �/     � n     �/     �4$�pk� �V0e ��h��<��4$�pk�        �               C o n t r o l l e r R e s o l v e r . p h p   �/     � �    �/     �&�pk� �V0e � {j��<��&�pk�       J               C o n t r o l l e r R e s o l v e r I n t e r f a c e . p h p �/     � |     �/     |�(�pk� �V0e ���l��<�|�(�pk�                      T r a c e a b l e A r g u m e n t R e s o l v e r . p h p     �/     � �     �/     O[+�pk� �V0e ��?o��<�O[+�pk�       �               T r a c e a b l e C o n t r o l l e r R e s o l v e r . p h p                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Controller;

use Symfony\Component\HttpKernel\Fragment\FragmentRendererInterface;

/**
 * Acts as a marker and a data holder for a Controller.
 *
 * Some methods in Symfony accept both a URI (as a string) or a controller as
 * an argument. In the latter case, instead of passing an array representing
 * the controller, you can use an instance of this class.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 *
 * @see FragmentRendererInterface
 */
class ControllerReference
{
    public $controller;
    public $attributes = [];
    public $query = [];

    /**
     * @param string $controller The controller name
     * @param array  $attributes An array of parameters to add to the Request attributes
     * @param array  $query      An array of parameters to add to the Request query string
     */
    public function __construct(string $controller, array $attributes = [], array $query = [])
    {
        $this->controller = $controller;
        $this->attributes = $attributes;
        $this->query = $query;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\HttpKernel\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * This implementation uses the '_controller' request attribute to determine
 * the controller to execute.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 * @author Tobias Schultze <http://tobion.de>
 */
class ControllerResolver implements ControllerResolverInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getController(Request $request)
    {
        if (!$controller = $request->attributes->get('_controller')) {
            if (null !== $this->logger) {
                $this->logger->warning('Unable to look for the controller as the "_controller" parameter is missing.');
            }

            return false;
        }

        if (\is_array($controller)) {
            if (isset($controller[0]) && \is_string($controller[0]) && isset($controller[1])) {
                try {
                    $controller[0] = $this->