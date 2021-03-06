<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Cloner;

/**
 * Represents the current state of a dumper while dumping.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Cursor
{
    const HASH_INDEXED = Stub::ARRAY_INDEXED;
    const HASH_ASSOC = Stub::ARRAY_ASSOC;
    const HASH_OBJECT = Stub::TYPE_OBJECT;
    const HASH_RESOURCE = Stub::TYPE_RESOURCE;

    public $depth = 0;
    public $refIndex = 0;
    public $softRefTo = 0;
    public $softRefCount = 0;
    public $softRefHandle = 0;
    public $hardRefTo = 0;
    public $hardRefCount = 0;
    public $hardRefHandle = 0;
    public $hashType;
    public $hashKey;
    public $hashKeyIsBinary;
    public $hashIndex = 0;
    public $hashLength = 0;
    public $hashCut = 0;
    public $stop = false;
    public $attr = [];
    public $skipChildren = false;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\VarDumper\Cloner;

use Symfony\Component\VarDumper\Caster\Caster;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
class Data implements \ArrayAccess, \Countable, \IteratorAggregate
{
    private $data;
    private $position = 0;
    private $key = 0;
    private $maxDepth = 20;
    private $maxItemsPerDepth = -1;
    private $useRefHandles = -1;

    /**
     * @param array $data An array as returned by ClonerInterface::cloneVar()
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return string The type of the value
     */
    public function getType()
    {
        $item = $this->data[$this->position][$this->key];

        if ($item instanceof Stub && Stub::TYPE_REF === $item->type && !$item->position) {
            $item = $item->value;
        }
        if (!$item instanceof Stub) {
            return \gettype($item);
        }
        if (Stub::TYPE_STRING === $item->type) {
            return 'string';
        }
        if (Stub::TYPE_ARRAY === $item->type) {
            return 'array';
        }
        if (Stub::TYPE_OBJECT === $item->type) {
            return $item->class;
        }
        if (Stub::TYPE_RESOURCE === $item->type) {
            return $item->class.' resource';
        }
    }

    /**
     * @param bool $recursive Whether values should be resolved recursively or not
     *
     * @return string|int|float|bool|array|Data[]|null A native representation of the original value
     */
    public function getValue($recursive = false)
    {
        $item = $this->data[$this->position][$this->key];

        if ($item instanceof Stub && Stub::TYPE_REF === $item->type && !$item->position) {
            $item = $item->value;
        }
        if (!($item = $this->getStub($item)) instanceof Stub) {
            return $item;
        }
        if (Stub::TYPE_STRING === $item->type) {
            return $item->value;
        }

        $children = $item->position ? $this->data[$item->position] : [];

        foreach ($children as $k => $v) {
            if ($recursive && !($v = $this->getStub($v)) instanceof Stub) {
                continue;
            }
            $children[$k] = clone $this;
            $children[$k]->key = $k;
            $children[$k]->position = $item->position;

            if ($recursive) {
                if (Stub::TYPE_REF === $v->type && ($v = $this->getStub($v->value)) instanceof Stub) {
                    $recursive = (array) $recursive;
                    if (isset($recursive[$v->position])) {
                        continue;
                    }
                    $recursive[$v->position] = true;
                }
                $children[$k] = $children[$k]->getValue($recursive);
            }
        }

        return $children;
    }

    public function count()
    {
        return \count($this->getValue());
    }

    public function getIterator()
    {
        if (!\is_array($value = $this->getValue())) {
            throw new \LogicException(sprintf('%s object holds non-iterable type "%s".', self::class, \gettype($value)));
        }

        yield from $value;
    }

    public function __get($key)
    {
        if (null !== $data = $this->seek($key)) {
            $item = $this->getStub($data->data[$data->position][$data->key]);

            return $item instanceof Stub || [] === $item ? $data : $item;
        }
    }

    public function __isset($key)
    {
        return null !== $this->seek($key);
    }

    public function offsetExists($key)
    {
        return $this->__isset($key);
    }

    public function offsetGet($key)
    {
        return $this->__get($key);
    }

    public function offsetSet($key, $value)
    {
        throw new \BadMethodCallException(self::class.' objects are immutable.');
    }

    public function offsetUnset($key)
    {
        throw new \BadMethodCallException(self::class.' objects are immutable.');
    }

    public function __toString()
    {
        $value = $this->getValue();

        if (!\is_array($value)) {
            return (string) $value;
        }

        return sprintf('%s (count=%d)', $this->getType(), \count($value));
    }

    /**
     * Returns a depth limited clone of $this.
     *
     * @param int $maxDepth The max dumped depth level
     *
     * @return self A clone of $this
     */
    public function withMaxDepth($maxDepth)
    {
        $data = clone $this;
        $data->maxDepth = (int) $maxDepth;

        return $data;
    }

    /**
     * Limits the number of elements per depth level.
     *
     * @param int $maxItemsPerDepth The max number of items dumped per depth level
     *
     * @return self A clone of $this
     */
    public function withMaxItemsPerDepth($maxItemsPerDepth)
    {
        $data = clone $this;
        $data->maxItemsPerDepth = (int) $maxItemsPerDepth;

        return $data;
    }

    /**
     * Enables/disables objects' identifiers tracking.
     *
     * @param bool $useRefHandles False to hide global ref. handles
     *
     * @return self A clone of $this
     */
    public function withRefHandles($useRefHandles)
    {
        $data = clone $this;
        $data->useRefHandles = $useRefHandles ? -1 : 0;

        return $data;
    }

    /**
     * Seeks to a specific key in nested data structures.
     *
     * @param string|int $key The key to seek to
     *
     * @return self|null A clone of $this or null if the key is not set
     */
    public function seek($key)
    {
        $item = $this->data[$this->position][$this->key];

        if ($item instanceof Stub && Stub::TYPE_REF === $item->type && !$item->position) {
            $item = $item->value;
        }
        if (!($item = $this->getStub($item)) instanceof Stub || !$item->position) {
            return;
        }
        $keys = [$key];

        switch ($item->type) {
            case Stub::TYPE_OBJECT:
                $keys[] = Caster::PREFIX_DYNAMIC.$key;
                $keys[] = Caster::PREFIX_PROTECTED.$key;
                $keys[] = Caster::PREFIX_VIRTUAL.$key;
                $keys[] = "\0$item->class\0$key";
                // no break
            case Stub::TYPE_ARRAY:
            case Stub::TYPE_RESOURCE:
                break;
            default:
                return;
        }

        $data = null;
        $children = $this->data[$item->position];

        foreach ($keys as $key) {
            if (isset($children[$key]) || \array_key_exists($key, $children)) {
                $data = clone $this;
                $data->key = $key;
                $data->position = $item->position;
                break;
            }
        }

        return $data;
    }

    /**
     * Dumps data with a DumperInterface dumper.
     */
    public function dump(DumperInterface $dumper)
    {
        $refs = [0];
        $this->dumpItem($dumper, new Cursor(), $refs, $this->data[$this->position][$this->key]);
    }

    /**
     * Depth-first dumping of items.
     *
     * @param DumperInterface $dumper The dumper being used for dumping
     * @param Cursor          $cursor A cursor used for tracking dumper state position
     * @param array           &$refs  A map of all references discovered while dumping
     * @param mixed           $item   A Stub object or the original value being dumped
     */
    private function dumpItem($dumper, $cursor, &$refs, $item)
    {
        $cursor->refIndex = 0;
        $cursor->softRefTo = $cursor->softRefHandle = $cursor->softRefCount = 0;
        $cursor->hardRefTo = $cursor->hardRefHandle = $cursor->hardRefCount = 0;
        $firstSeen = true;

        if (!$item instanceof Stub) {
            $cursor->attr = [];
            $type = \gettype($item);
            if ($item && 'array' === $type) {
                $item = $this->getStub($item);
            }
        } elseif (Stub::TYPE_REF === $item->type) {
            if ($item->handle) {
                if (!isset($refs[$r = $item->handle - (PHP_INT_MAX >> 1)])) {
                    $cursor->refIndex = $refs[$r] = $cursor->refIndex ?: ++$refs[0];
                } else {
                    $firstSeen = false;
                }
                $cursor->hardRefTo = $refs[$r];
                $cursor->hardRefHandle = $this->useRefHandles & $item->handle;
                $cursor->hardRefCount = $item->refCount;
            }
            $cursor->attr = $item->attr;
            $type = $item->class ?: \gettype($item->value);
            $item = $this->getStub($item->value);
        }
        if ($item instanceof Stub) {
            if ($item->refCount) {
                if (!isset($refs[$r = $item->handle])) {
                    $cursor->refIndex = $refs[$r] = $cursor->refIndex ?: ++$refs[0];
                } else {
                    $firstSeen = false;
                }
                $cursor->softRefTo = $refs[$r];
            }
            $cursor->softRefHandle = $this->useRefHandles & $item->handle;
            $cursor->softRefCount = $item->refCount;
            $cursor->attr = $item->attr;
            $cut = $item->cut;

            if ($item->position && $firstSeen) {
                $children = $this->data[$item->position];

                if ($cursor->stop) {
                    if ($cut >= 0) {
                        $cut += \count($children);
                    }
                    $children = [];
                }
            } else {
                $children = [];
            }
            switch ($item->type) {
                case Stub::TYPE_STRING:
                    $dumper->dumpString($cursor, $item->value, Stub::STRING_BINARY === $item->class, $cut);
                    break;

                case Stub::TYPE_ARRAY:
                    $item = clone $item;
                    $item->type = $item->class;
                    $item->class = $item->value;
                    // no break
                case Stub::TYPE_OBJECT:
                case Stub::TYPE_RESOURCE:
                    $withChildren = $children && $cursor->depth !== $this->maxDepth && $this->maxItemsPerDepth;
                    $dumper->enterHash($cursor, $item->type, $item->class, $withChildren);
                    if ($withChildren) {
                        if ($cursor->skipChildren) {
                            $withChildren = false;
                            $cut = 