<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;

class InterfacePass implements Pass
{
    public function apply($code, MockConfiguration $config)
    {
        foreach ($config->getTargetInterfaces() as $i) {
            $name = ltrim($i->getName(), "\\");
            if (!interface_exists($name)) {
                \Mockery::declareInterface($name);
            }
        }

        $interfaces = array_reduce((array) $config->getTargetInterfaces(), function ($code, $i) {
            return $code . ", \\" . ltrim($i->getName(), "\\");
        }, "");

        $code = str_replace(
            "implements MockInterface",
            "implements MockInterface" . $interfaces,
            $code
        );

        return $code;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;
use Mockery\Generator\TargetClassInterface;
use Mockery\Generator\Method;

class MagicMethodTypeHintsPass implements Pass
{
    /**
     * @var array $mockMagicMethods
     */
    private $mockMagicMethods = array(
        '__construct',
        '__destruct',
        '__call',
        '__callStatic',
        '__get',
        '__set',
        '__isset',
        '__unset',
        '__sleep',
        '__wakeup',
        '__toString',
        '__invoke',
        '__set_state',
        '__clone',
        '__debugInfo'
    );

    /**
     * Apply implementation.
     *
     * @param string $code
     * @param MockConfiguration $config
     * @return string
     */
    public function apply($code, MockConfiguration $config)
    {
        $magicMethods = $this->getMagicMethods($config->getTargetClass());
        foreach ($config->getTargetInterfaces() as $interface) {
            $magicMethods = array_merge($magicMethods, $this->getMagicMethods($interface));
        }

        foreach ($magicMethods as $method) {
            $code = $this->applyMagicTypeHints($code, $method);
        }

        return $code;
    }

    /**
     * Returns the magic methods within the
     * passed DefinedTargetClass.
     *
     * @param TargetClassInterface $class
     * @return array
     */
    public function getMagicMethods(
        TargetClassInterface $class = null
    ) {
        if (is_null($class)) {
            return array();
        }
        return array_filter($class->getMethods(), function (Method $method) {
            return in_array($method->getName(), $this->mockMagicMethods);
        });
    }

    /**
     * Applies type hints of magic methods from
     * class to the passed code.
     *
     * @param int $code
     * @param Method $method
     * @return string
     */
    private function applyMagicTypeHints($code, Method $method)
    {
        if ($this->isMethodWithinCode($code, $method)) {
            $namedParameters = $this->getOriginalParameters(
                $code,
                $method
            );
            $code = preg_replace(
                $this->getDeclarationRegex($method->getName()),
                $this->getMethodDeclaration($method, $namedParameters),
                $code
            );
        }
        return $code;
    }

    /**
     * Checks if the method is declared withing code.
     *
     * @param int $code
     * @param Method $method
     * @return boolean
     */
    private function isMethodWithinCode($code, Method $method)
    {
        return preg_match(
            $this->getDeclarationRegex($method->getName()),
            $code
        ) == 1;
    }

    /**
     * Returns the method original parameters, as they're
     * described in the $code string.
     *
     * @param int $code
     * @param Method $method
     * @return array
     */
    private function getOriginalParameters($code, Method $method)
    {
        $matches = [];
        $parameterMatches = [];

        preg_match(
            $this->getDeclarationRegex($method->getName()),
            $code,
            $matches
        );

        if (count($matches) > 0) {
            preg_match_all(
                '/(?<=\$)(\w+)+/i',
                $matches[0],
                $parameterMatches
            );
        }

        $groupMatches = end($parameterMatches);
        $parameterNames = is_array($groupMatches) ?
            $groupMatches                         :
            array($groupMatches);

        return $parameterNames;
    }

    /**
     * Gets the declaration code, as a string, for the passed method.
     *
     * @param Method $method
     * @param array  $namedParameters
     * @return string
     */
    private function getMethodDeclaration(
        Method $method,
        array $namedParameters
    ) {
        $declaration = 'public';
        $declaration .= $method->isStatic() ? ' static' : '';
        $declaration .= ' function '.$method->getName().'(';

        foreach ($method->getParameters() as $index => $parameter) {
            $declaration .= $parameter->getTypeHintAsString().' ';
            $name = isset($namedParameters[$index]) ?
                $namedParameters[$index]            :
                $parameter->getName();
            $declaration .= '$'.$name;
            $declaration .= ',';
        }
        $declaration = rtrim($declaration, ',');
        $declaration .= ') ';

        $returnType = $method->getReturnType();
        if (!empty($returnType)) {
            $declaration .= ': '.$returnType;
        }

        return $declaration;
    }

    /**
     * Returns a regex string used to match the
     * declaration of some method.
     *
     * @param string $methodName
     * @return string
     */
    private function getDeclarationRegex($methodName)
    {
        return "/public\s+(?:static\s+)?function\s+$methodName\s*\(.*\)\s*(?=\{)/i";
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\Method;
use Mockery\Generator\Parameter;
use Mockery\Generator\MockConfiguration;

class MethodDefinitionPass implements Pass
{
    public function apply($code, MockConfiguration $config)
    {
        foreach ($config->getMethodsToMock() as $method) {
            if ($method->isPublic()) {
                $methodDef = 'public';
            } elseif ($method->isProtected()) {
                $methodDef = 'protected';
            } else {
                $methodDef = 'private';
            }

            if ($method->isStatic()) {
                $methodDef .= ' static';
            }

            $methodDef .= ' function ';
            $methodDef .= $method->returnsReference() ? ' & ' : '';
            $methodDef .= $method->getName();
            $methodDef .= $this->renderParams($method, $config);
            $methodDef .= $this->renderReturnType($method);
            $methodDef .= $this->renderMethodBody($method, $config);

            $code = $this->appendToClass($code, $methodDef);
        }

        return $code;
    }

    protected function renderParams(Method $method, $config)
    {
        $class = $method->getDeclaringClass();
        if ($class->isInternal()) {
            $overrides = $config->getParameterOverrides();

            if (isset($overrides[strtolower($class->getName())][$method->getName()])) {
                return '(' . implode(',', $overrides[strtolower($class->getName())][$method->getName()]) . ')';
            }
        }

        $methodParams = array();
        $params = $method->getParameters();
        foreach ($params as $param) {
            $paramDef = $this->renderTypeHint($param);
            $paramDef .= $param->isPassedByReference() ? '&' : '';
            $paramDef .= $param->isVariadic() ? '...' : '';
            $paramDef .= '$' . $param->getName();

            if (!$param->isVariadic()) {
                if (false !== $param->isDefaultValueAvailable()) {
                    $paramDef .= ' = ' . var_export($param->getDefaultValue(), true);
                } elseif ($param->isOptional()) {
                    $paramDef .= ' = null';
                }
            }

            $methodParams[] = $paramDef;
        }
        return '(' . implode(', ', $methodParams) . ')';
    }

    protected function renderReturnType(Method $method)
    {
        $type = $method->getReturnType();
        return $type ? sprintf(': %s', $type) : '';
    }

    protected function appendToClass($class, $code)
    {
        $lastBrace = strrpos($class, "}");
        $class = substr($class, 0, $lastBrace) . $code . "\n    }\n";
        return $class;
    }

    protected function renderTypeHint(Parameter $param)
    {
        $typeHint = trim($param->getTypeHintAsString());

        if (!empty($typeHint)) {
            if (!\Mockery::isBuiltInType($typeHint)) {
                $typeHint = '\\'.$typeHint;
            }

            if (version_compare(PHP_VERSION, '7.1.0-dev') >= 0 && $param->allowsNull()) {
                $typeHint = "?".$typeHint;
            }
        }

        return $typeHint .= ' ';
    }

    private function renderMethodBody($method, $config)
    {
        $invoke = $method->isStatic() ? 'static::_mockery_handleStaticMethodCall' : '$this->_mockery_handleMethodCall';
        $body = <<<BODY
{
\$argc = func_num_args();
\$argv = func_get_args();

BODY;

        // Fix up known parameters by reference - used func_get_args() above
        // in case more parameters are passed in than the function definition
        // says - eg varargs.
        $class = $method->getDeclaringClass();
        $class_name = strtolower($class->getName());
        $overrides = $config->getParameterOverrides();
        if (isset($overrides[$class_name][$method->getName()])) {
            $params = array_values($overrides[$class_name][$method->getName()]);
            $paramCount = count($params);
            for ($i = 0; $i < $paramCount; ++$i) {
                $param = $params[$i];
                if (strpos($param, '&') !== false) {
                    $body .= <<<BODY
if (\$argc > $i) {
    \$argv[$i] = {$param};
}

BODY;
                }
            }
        } else {
            $params = array_values($method->getParameters());
            $paramCount = count($params);
            for ($i = 0; $i < $paramCount; ++$i) {
                $param = $params[$i];
                if (!$param->isPassedByReference()) {
                    continue;
                }
                $body .= <<<BODY
if (\$argc > $i) {
    \$argv[$i] =& \${$param->getName()};
}

BODY;
            }
        }

        $body .= "\$ret = {$invoke}(__FUNCTION__, \$argv);\n";

        if ($method->getReturnType() !== "void") {
            $body .= "return \$ret;\n";
        }

        $body .= "}\n";
        return $body;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;

interface Pass
{
    public function apply($code, MockConfiguration $config);
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;

/**
 * The standard Mockery\Mock class includes some methods to ease mocking, such
 * as __wakeup, however if the target has a final __wakeup method, it can't be
 * mocked. This pass removes the builtin methods where they are final on the
 * target
 */
class RemoveBuiltinMethodsThatAreFinalPass
{
    protected $methods = array(
        '__wakeup' => '/public function __wakeup\(\)\s+\{.*?\}/sm',
    );

    public function apply($code, MockConfiguration $config)
    {
        $target = $config->getTargetClass();

        if (!$target) {
            return $code;
        }

        foreach ($target->getMethods() as $method) {
            if ($method->isFinal() && isset($this->methods[$method->getName()])) {
                $code = preg_replace($this->methods[$method->getName()], '', $code);
            }
        }

        return $code;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  