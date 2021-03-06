<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Reflection;

/**
 * A fake ReflectionParameter but for language construct parameters.
 *
 * It stubs out all the important bits and returns whatever was passed in $opts.
 */
class ReflectionLanguageConstructParameter extends \ReflectionParameter
{
    private $function;
    private $parameter;
    private $opts;

    public function __construct($function, $parameter, array $opts)
    {
        $this->function  = $function;
        $this->parameter = $parameter;
        $this->opts      = $opts;
    }

    /**
     * No class here.
     */
    public function getClass()
    {
        return;
    }

    /**
     * Is the param an array?
     *
     * @return bool
     */
    public function isArray()
    {
        return \array_key_exists('isArray', $this->opts) && $this->opts['isArray'];
    }

    /**
     * Get param default value.
     *
     * @return mixed
     */
    public function getDefaultValue()
    {
        if ($this->isDefaultValueAvailable()) {
            return $this->opts['defaultValue'];
        }
    }

    /**
     * Get param name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->parameter;
    }

    /**
     * Is the param optional?
     *
     * @return bool
     */
    public function isOptional()
    {
        return \array_key_exists('isOptional', $this->opts) && $this->opts['isOptional'];
    }

    /**
     * Does the param have a default value?
     *
     * @return bool
     */
    public function isDefaultValueAvailable()
    {
        return \array_key_exists('defaultValue', $this->opts);
    }

    /**
     * Is the param passed by reference?
     *
     * (I don't think this is true for anything we need to fake a param for)
     *
     * @return bool
     */
    public function isPassedByReference()
    {
        return \array_key_exists('isPassedByReference', $this->opts) && $this->opts['isPassedByReference'];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               <?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Sudo;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified as FullyQualifiedName;
use PhpParser\Node\Scalar\String_;
use PhpParser\NodeVisitorAbstract;

/**
 * A PHP Parser node visitor which rewrites property and method access to use
 * the Psy\Sudo visibility bypass methods.
 *
 * @todo handle assigning by reference
 */
class SudoVisitor extends NodeVisitorAbstract
{
    const SUDO_CLASS = 'Psy\Sudo';

    const PROPERTY_FETCH         = 'fetchProperty';
    const PROPERTY_ASSIGN        =