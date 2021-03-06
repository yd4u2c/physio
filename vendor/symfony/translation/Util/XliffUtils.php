     foreach ($map as $key => $accessor) {
            try {
                $a[$prefix.$key] = $c->$accessor();
            } catch (\Exception $e) {
            }
        }

        if (isset($a[$prefix.'flags'])) {
            $flagsArray = [];
            foreach (self::$splFileObjectFlags as $value => $name) {
                if ($a[$prefix.'flags'] & $value) {
                    $flagsArray[] = $name;
                }
            }
            $a[$prefix.'flags'] = new ConstStub(implode('|', $flagsArray), $a[$prefix.'flags']);
        }

        if (isset($a[$prefix.'fstat'])) {
            $a[$prefix.'fstat'] = new CutArrayStub($a[$prefix.'fstat'], ['dev', 'ino', 'nlink', 'rdev', 'blksize', 'blocks']);
        }

        return $a;
    }

    public static function castFixedArray(\SplFixedArray $c, array $a, Stub $stub, $isNested)
    {
        $a += [
            Caster::PREFIX_VIRTUAL.'storage' => $c->toArray(),
        ];

        return $a;
    }

    public static function castObjectStorage(\SplObjectStorage $c, array $a, Stub $stub, $isNested)
    {
        $storage = [];
        unset($a[Caster::PREFIX_DYNAMIC."\0gcdata"]); // Don't hit https://bugs.php.net/65967

        $clone = clone $c;
        foreach ($clone as $obj) {
            $storage[] = [
                'object' => $obj,
                'info' => $clone->getInfo(),
             ];
        }

        $a += [
            Caster::PREFIX_VIRTUAL.'storage' => $storage,
        ];

        return $a;
    }

    public static function castOuterIterator(\OuterIterator $c, array $a, Stub $stub, $isNested)
    {
        $a[Caster::PREFIX_VIRTUAL.'innerIterator'] = $c->getInnerIterator();

        return $a;
    }

    private static function castSplArray($c, array $a, Stub $stub, $isNested)
    {
        $prefix = Caster::PREFIX_VIRTUAL;
        $class = $stub->class;
        $flags = $c->getFlags();

        if (!($flags & \ArrayObject::STD_PROP_LIST)) {
            $c->setFlags(\ArrayObject::STD_PROP_LIST);
            $a = Caster::castObject($c, $class);
            $c->setFlags($flags);
        }
        $a += [
            $prefix.'flag::STD_PROP_LIST' => (bool) ($flags & \ArrayObject::STD_PROP_LIST),
            $prefix.'flag::ARRAY_AS_PROPS' => (bool) ($flags & \ArrayObject::ARRAY_AS_PROPS),
        ];
        if ($c instanceof \ArrayObject) {
            $a[$prefix.'iteratorClass'] = new ClassStub($c->getIteratorClass());
        }
        $a[$prefix.'storage'] = $c->getArrayCopy();

        return $a;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           <?php

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
 * Casts a caster's Stub.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class StubCaster
{
    public static function castStub(Stub $c, array $a, Stub $stub, $isNested)
    {
        if ($isNested) {
            $stub->type = $c->type;
            $stub->class = $c->class;
            $stub->value = $c->value;
            $stub->handle = $c->handle;
            $stub->cut = $c->cut;
            $stub->attr = $c->attr;

            if (Stub::TYPE_REF === $c->type && !$c->class && \is_string($c->value) && !preg_match('//u', $c->value)) {
                $stub->type = Stub::TYPE_STRING;
                $stub->class = Stub::STRING_BINARY;
            }

            $a = [];
        }

        return $a;
    }

    public static function castCutArray(CutArrayStub $c, array $a, Stub $stub, $isNested)
    {
        return $isNested ? $c->preservedSubset : $a;
    }

    public static function cutInternals($obj, array $a, Stub $stub, $isNes