st option which is non-empty will be returned. This is especially useful 
with lazy-evaluated options, see below.

Lazy-Evaluated Options
----------------------
The above example has the flaw that we would need to evaluate all options when
the method is called which creates unnecessary overhead if the first option is 
already non-empty.

Fortunately, we can easily solve this by using the ``LazyOption`` class:

```php
return $this->findSomeEntity()
            ->orElse(new LazyOption(array($this, 'findSomeOtherEntity')))
            ->orElse(new LazyOption(array($this, 'createEntity')));
```

This way, only the options that are necessary will actually be evaluated.


Performance Considerations
==========================
Of course, performance is important. Attached is a performance benchmark which
you can run on a machine of your choosing.

The overhead incurred by the Option type comes down to the time that it takes to
create one object, our wrapper. Also, we need to perform one additional method call
to retrieve the value from the wrapper.

* Overhead: Creation of 1 Object, and 1 Method Call
* Average Overhead per Invocation (some case/value returned): 0.000000761s (that is 761 nano seconds)
* Average Overhead per Invocation (none case/null returned): 0.000000368s (that is 368 nano seconds)

The benchmark was run under Ubuntu precise with PHP 5.4.6. As you can see the
overhead is surprisingly low, almost negligible.

So in conclusion, unless you plan to call a method thousands of times during a
request, there is no reason to stick to the ``object|null`` return value; better give
your code some options!
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 INDX( 	 ꜊             (   p  �       �                    �     h V     �     �tepk� ���;���^���<��tepk�(       "               
 . g i t i g n o r e   �     h X     �     ��vepk� ���;������<���vepk��       �                . t r a v i s . y m l �     p \     �     R�{epk� ���;��{"��<�R�{epk�P      J               c o m p o s e r . j s o n     �     ` P     �     )��epk� ���;������<�)��epk� 0      \,               L I C E N S E �     x b     �     ^�epk  ���;������<�^�epk��      �               p h p u n i t . x m l . d i s t       �     h T     �     �F�epk� ���;����!��<��F�epk�        _              	 R E A D M E . m d     �     X H     �      ��epk��Ўepk��Ўepk��Ўepk�                        s r c �     ` L     �     黚epk��epk��epk��epk�                        t e s t s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <?php

/*
 * Copyright 2012 Johannes M. Schmitt <schmittjoh@gmail.com>
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PhpOption;

final class LazyOption extends Option
{
    /** @var callable */
    private $callback;

    /** @var array */
    private $arguments;

    /** @var Option|null */
    private $option;

    /**
     * Helper Constructor.
     *
     * @param callable $callback
     * @param array $arguments
     *
     * @return LazyOption
     */
    public static function create($callback, array $arguments = array())
    {
        return new self($callback, $arguments);
    }

    /**
     * Constructor.
     *
     * @param callable $callback
     * @param array $arguments
     */
    public function __construct($callback, array $arguments = array())
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Invalid callback given');
        }

        $this->callback = $callback;
        $this->arguments = $arguments;
    }

    public function isDefined()
    {
        return $this->option()->isDefined();
    }

    public function isEmpty()
    {
        return $this->option()->isEmpty();
    }

    public function get()
    {
        return $this->option()->get();
    }

    public function getOrElse($default)
    {
        return $this->option()->getOrElse($default);
    }

    public function getOrCall($callable)
    {
        return $this->option()->getOrCall($callable);
    }

    public function getOrThrow(\Exception $ex)
    {
        return $this->option()->getOrThrow($ex);
    }

    public function orElse(Option $else)
    {
        return $this->option()->orElse($else);
    }

    /**
     * @deprecated Use forAll() instead.
     */
    public function ifDefined($callable)
    {
        $this->option()->ifDefined($callable);
    }

    public function forAll($callable)
    {
        return $this->option()->forAll($callable);
    }

    public function map($callable)
    {
        return $this->option()->map($callable);
    }

    public function flatMap($callable)
    {
        return $this->option()->flatMap($callable);
    }

    public function filter($callable)
    {
        return $this->option()->filter($callable);
    }

    public function filterNot($callable)
    {
        return $this->option()->filterNot($callable);
    }

    public function select($value)
    {
        return $this->option()->select($value);
    }

    public function reject($value)
    {
        return $this->option()->reject($value);
    }

    public function getIterator()
    {
        return $this->option()->getIterator();
    }

    public function foldLeft($initialValue, $callable)
    {
        return $this->option()->foldLeft($initialValue, $callable);
    }

    public function foldRight($initialValue, $callable)
    {
        return $this->option()->foldRight($initialValue, $callable);
    }

    /**
     * @return Option
     */
    private function option()
    {
        if (null === $this->option) {
            $this->option = call_user_func_array($this->callback, $this->arguments);
            if (!$this->option instanceof Option) 