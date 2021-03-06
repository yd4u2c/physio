uments to the constructor.

.. _creating-test-doubles-behavior-modifiers:

Behavior Modifiers
------------------

When creating a mock object, we may wish to use some commonly preferred
behaviours that are not the default in Mockery.

The use of the ``shouldIgnoreMissing()`` behaviour modifier will label this
mock object as a Passive Mock:

.. code-block:: php

    \Mockery::mock('MyClass')->shouldIgnoreMissing();

In such a mock object, calls to methods which are not covered by expectations
will return ``null`` instead of the usual error about there being no expectation
matching the call.

On PHP >= 7.0.0, methods with missing expectations that have a return type
will return either a mock of the object (if return type is a class) or a
"falsy" primitive value, e.g. empty string, empty array, zero for ints and
floats, false for bools, or empty closures.

On PHP >= 7.1.0, methods with missing expectations and nullable return type
will return null.

We can optionally prefer to return an object of type ``\Mockery\Undefined``
(i.e.  a ``null`` object) (which was the 0.7.2 behaviour) by using an
additional modifier:

.. code-block:: php

    \Mockery::mock('MyClass')->shouldIgnoreMissing()->asUndefined();

The returned object is nothing more than a placeholder so if, by some act of
fate, it's erroneously used somewhere it shouldn't it will likely not pass a
logic check.

We have encountered the ``makePartial()`` method before, as it is the method we
use to create runtime partial test doubles:

.. code-block:: php

    \Mockery::mock('MyClass')->makePartial();

This form of mock object will defer all methods not subject to an expectation to
the parent class of the mock, i.e. ``MyClass``. Whereas the previous
``shouldIgnoreMissing()`` returned ``null``, this behaviour simply calls the
parent's matching method.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 