    if (isset(self::$compression[$v])) {
                    $v = new ConstStub(self::$compression[$v], $v);
                }
            }
        } elseif (isset(self::$compression[$compression])) {
            $compression = new ConstStub(self::$compression[$compression], $compression);
        }

        $retry = \defined('Redis::OPT_SCAN') ? $redis->getOption(\Redis::OPT_SCAN) : 0;
        if (\is_array($retry)) {
            foreach ($retry as &$v) {
                $v = new ConstStub($v ? 'RETRY' : 'NORETRY', $v);
            }
        } else {
            $retry = new ConstStub($retry ? 'RETRY' : 'NORETRY', $retry);
        }

        $options += [
            'TCP_KEEPALIVE' => \defined('Redis::OPT_TCP_KEEPALIVE') ? $redis->getOption(\Redis::OPT_TCP_KEEPALIVE) : 0,
            'READ_TIMEOUT' => $redis->getOption(\Redis::OPT_READ_TIMEOUT),
            'COMPRESSION' => $compression,
            'SERIALIZER' => $serializer,
            'PREFIX' => $redis->getOption(\Redis::OPT_PREFIX),
            'SCAN' => $retry,
        ];

        return new EnumStub($options);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Caster;

use Symfony\Component\VarDumper\Cloner\Stub;

/**
 * Casts Reflector related classes to array representation.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class ReflectionCaster
{
    private static $extraMap = [
        'docComment' => 'getDocComment',
        'extension' => 'getExtensionName',
        'isDisabled' => 'isDisabled',
        'isDeprecated' => 'isDeprecated',
        'isInternal' => 'isInternal',
        'isUserDefined' => 'isUserDefined',
        'isGenerator' => 'isGenerator',
        'isVariadic' => 'isVariadic',
    ];

    public static function castClosure(\Closure $c, array $a, Stub $stub, $isNested, $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;
        $c = new \ReflectionFunction($c);

        $a = static::castFunctionAbstract($c, $a, $stub, $isNested, $filter);

        if (false === strpos($c->name, '{closure}')) {
            $stub->class = isset($a[$prefix.'class']) ? $a[$prefix.'class']->value.'::'.$c->name : $c->name;
            unset($a[$prefix.'class']);
        }
        unset($a[$prefix.'extra']);

        $stub->class .= self::getSignature($a);

        if ($filter & Caster::EXCLUDE_VERBOSE) {
            $stub->cut += ($c->getFileName() ? 2 : 0) + \count($a);

            return [];
        }

        if (isset($a[$prefix.'parameters'])) {
            foreach ($a[$prefix.'parameters']->value as &$v) {
                $param = $v;
                $v = new EnumStub([]);
                foreach (static::castParameter($param, [], $stub, true) as $k => $param) {
                    if ("\0" === $k[0]) {
                        $v->value[substr($k, 3)] = $param;
                    }
                }
                unset($v->value['position'], $v->value['isVariadic'], $v->value['byReference'], $v);
            }
        }

        if ($f = $c->getFileName()) {
            $a[$prefix.'file'] = new LinkStub($f, $c->getStartLine());
            $a[$prefix.'line'] = $c->getStartLine().' to '.$c->getEndLine();
        }

        return $a;
    }

    public static function castGenerator(\Generator $c, array $a, Stub $stub, $isNested)
    {
        if (!class_exists('ReflectionGenerator', false)) {
            return $a;
        }

        // Cannot create ReflectionGenerator based on a terminated Generator
        try {
            $reflectionGenerator = new \ReflectionGenerator($c);
        } catch (\Exception $e) {
            $a[Caster::PREFIX_VIRTUAL.'closed'] = true;

            return $a;
        }

        return self::castReflectionGenerator($reflectionGenerator, $a, $stub, $isNested);
    }

    public static function castType(\ReflectionType $c, array $a, Stub $stub, $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        $a += [
            $prefix.'name' => $c->getName(),
            $prefix.'allowsNull' => $c->allowsNull(),
            $prefix.'isBuiltin' => $c->isBuiltin(),
        ];

        return $a;
    }

    public static function castReflectionGenerator(\ReflectionGenerator $c, array $a, Stub $stub, $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        if ($c->getThis()) {
            $a[$prefix.'this'] = new CutStub($c->getThis());
        }
        $function = $c->getFunction();
        $frame = [
            'class' => isset($function->class) ? $function->class : null,
            'type' => isset($function->class) ? ($function->isStatic() ? '::' : '->') : null,
            'function' => $function->name,
            'file' => $c->getExecutingFile(),
            'line' => $c->getExecutingLine(),
        ];
        if ($trace = $c->getTrace(DEBUG_BACKTRACE_IGNORE_ARGS)) {
            $function = new \ReflectionGenerator($c->getExecutingGenerator());
            array_unshift($trace, [
                'function' => 'yield',
                'file' => $function->getExecutingFile(),
                'line' => $function->getExecutingLine() - 1,
            ]);
            $trace[] = $frame;
            $a[$prefix.'trace'] = new TraceStub($trace, false, 0, -1, -1);
        } else {
            $function = new FrameStub($frame, false, true);
            $function = ExceptionCaster::castFrameStub($function, [], $function, true);
            $a[$prefix.'executing'] = new EnumStub([
                "\0~separator= \0".$frame['class'].$frame['type'].$frame['function'].'()' => $function[$prefix.'src'],
            ]);
        }

        $a[Caster::PREFIX_VIRTUAL.'closed'] = false;

        return $a;
    }

    public static function castClass(\ReflectionClass $c, array $a, Stub $stub, $isNested, $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        if ($n = \Reflection::getModifierNames($c->getModifiers())) {
            $a[$prefix.'modifiers'] = implode(' ', $n);
        }

        self::addMap($a, $c, [
            'extends' => 'getParentClass',
            'implements' => 'getInterfaceNames',
            'constants' => 'getConstants',
        ]);

        foreach ($c->getProperties() as $n) {
            $a[$prefix.'properties'][$n->name] = $n;
        }

        foreach ($c->getMethods() as $n) {
            $a[$prefix.'methods'][$n->name] = $n;
        }

        if (!($filter & Caster::EXCLUDE_VERBOSE) && !$isNested) {
            self::addExtra($a, $c);
        }

        return $a;
    }

    public static function castFunctionAbstract(\ReflectionFunctionAbstract $c, array $a, Stub $stub, $isNested, $filter = 0)
    {
        $prefix = Caster::PREFIX_VIRTUAL;

        self::addMap($a, $c, [
            'returnsReference' => 'returnsReference',
            'returnType' => 'getReturnType',
            'class' => 'getClosureScopeClass',
            'this' => 'getClosureThis',
        ]);

        if (isset($a[$prefix.'returnType'])) {
            $v = $a[$prefix.'returnType'];
            $v = $v->getName();
            $a[$prefix.'returnType'] = new ClassStub($a[$prefix.'returnType']->allowsNull() ? '?'.$v : $v, [class_exists($v,