ble')`` or Hamcrest's ``callable()`` uses
``is_callable()``.

The ``type()`` matcher also accepts a class or interface name to be used in an
``instanceof`` evaluation of the actual argument. Hamcrest uses ``anInstanceOf()``.

A full list of the type checkers is available at
`php.net <http://www.php.net/manual/en/ref.var.php>`_ or browse Hamcrest's function
list in
`the Hamcrest code <https://github.com/hamcrest/hamcrest-php/blob/master/hamcrest/Hamcrest.php>`_.

.. _argument-validation-complex-argument-validation:

Complex Argument Validation
---------------------------

If we want to perform a complex argument validation, the ``on()`` matcher is
invaluable. It accepts a closure (anonymous function) to which the actual
argument will be passed.

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive("foo")
        ->with(\Mockery::on(closure));

If the closure evaluates to (i.e. returns) boolean ``true`` then the argument is
assumed to have matched the expectation.

.. code-block:: php

    $mock = \Mockery::mock('MyClass');

    $mock->shouldReceive('foo')
        ->with(\Mockery::on(function ($argument) {
            if ($argument % 2 == 0) {
                return true;
            }
            return false;
        }));

    $mock->foo(4); // matches the expectation
    $mock->foo(3); // throws a NoMatchingExpectationException

.. note::

    There is no Hamcrest version of the ``on()`` matcher.

We can also perform argument validation by passing a closure to ``withArgs()``
method. The closure will receive all arguments passed in the call to the expected
method and if it evaluates (i.e. returns) to boolean ``true``, then the list of
arguments is assumed to have matched the expectation:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive("foo")
        ->withArgs(closure);

The closure can also handle optional parameters, so if an optional parameter is
missing in the call to the expected method, it doesn't necessary means that the
list of arguments doesn't match the expectation.

.. code-block:: php

    $closure = function ($odd, $even, $sum = null) {
        $result = ($odd % 2 != 0) && ($even % 2 == 0);
        if (!is_null($sum)) {
            return $result && ($odd + $even == $sum);
        }
        return $result;
    };

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')->withArgs($closure);

    $mock->foo(1, 2); // It matches the expectation: the optional argument is not needed
    $mock->foo(1, 2, 3); // It also matches the expectation: the optional argument pass the validation
    $mock->foo(1, 2, 4); // It doesn't match the expectation: the optional doesn't pass the validation

.. note::

    In previous versions, Mockery's ``with()`` would attempt to do a pattern
    matching against the arguments, attempting to use the argument as a
    regular expression. Over time this proved to be not such a great idea, so
    we removed this functionality, and have introduced ``Mockery::pattern()``
    instead.

If we would like to match an argument against a regular expression, we can use
the ``\Mockery::pattern()``:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::pattern('/^foo/'));

    // Hamcrest equivalent
    $mock->shouldReceive('foo')
        with(matchesPattern('/^foo/'));

The ``ducktype()`` matcher is an alternative to matching by class type:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::ducktype('foo', 'bar'));

It matches any argument which is an object containing the provided list of
methods to call.

.. note::

    There is no Hamcrest version of the ``ducktype()`` matcher.

Additional Argument Matchers
----------------------------

The ``not()`` matcher matches any argument which is not equal or identical to
the matcher's parameter:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::not(2));

    // Hamcrest equivalent
    $mock->shouldReceive('foo')
        ->with(not(2));

``anyOf()`` matches any argument which equals any one of the given parameters:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::anyOf(1, 2));

    // Hamcrest equivalent
    $mock->shouldReceive('foo')
        ->with(anyOf(1,2));

``notAnyOf()`` matches any argument which is not equal or identical to any of
the given parameters:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::notAnyOf(1, 2));

.. note::

    There is no Hamcrest version of the ``notAnyOf()`` matcher.

``subset()`` matches any argument which is any array containing the given array
subset:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::subset(array(0 => 'foo')));

This enforces both key naming and values, i.e. both the key and value of each
actual element is compared.

.. note::

    There is no Hamcrest version of this functionality, though Hamcrest can check
    a single entry using ``hasEntry()`` or ``hasKeyValuePair()``.

``contains()`` matches any argument which is an array containing the listed
values:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::contains(value1, value2));

The naming of keys is ignored.

``hasKey()`` matches any argument which is an array containing the given key
name:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::hasKey(key));

``hasValue()`` matches any argument which is an array containing the given
value:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive('foo')
        ->with(\Mockery::hasValue(value));
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            .. index::
    single: Reference; Creating Test Doubles

Creating Test Doubles
=====================

Mockery's main goal is to help us create test doubles. It can create stubs,
mocks, and spies.

Stubs and mocks are created the same. The difference between the two is that a
stub only returns a preset result when called, while a mock needs to have
expectations set on the method calls it expects to receive.

Spies are a type of test doubles that keep track of the calls they received, and
allow us to inspect these calls after the fact.

When creating a test double object, we can pass in an identifier as a name for
our test double. If we pass it no identifier, the test double name will be
unknown. Furthermore, the identifier does not have to be a class name. It is a
good practice, and our recommendation, to always name the test doubles with the
same name as the underlying class we are creating test doubles for.

If the identifier we use for our test double is a name of an existing class,
the test double will inherit the type of the class (via inheritance), i.e. the
mock object will pass type hints or ``instanceof`` evaluations for the existing
class. This is useful when a test double must be of a specific type, to satisfy
the expectations our code has.

Stubs and mocks
---------------

Stubs and mocks are created by calling the ``\Mockery::mock()`` method. The
following example shows how to create a stub, or a mock, object named "foo":

.. code-block:: php

    $mock = \Mockery::mock('foo');

The mock object created like this is the loosest form of mocks possible, and is
an instance of ``\Mockery\MockInterface``.

.. note::

    All test doubles created with Mockery are an instance of
    ``\Mockery\MockInterface``, regardless are they a stub, mock or a spy.

To create a stub or a mock object with no name, we can call the ``mock()``
method with no parameters:

.. code-block:: php

    $mock = \Mockery::mock();

As we stated earlier, we don't recommend creating stub or mock objects without
a name.

Classes, abstracts, interfaces
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

The recommended way to create a stub or a mock object is by using a name of
an existing class we want to create a test double of:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');

This stub or mock object will have the type of ``MyClass``, through inheritance.

Stub or mock objects can be based on any concrete class, abstract class or even
an interface. The primary purpose is to ensure the mock object inherits a
specific type for type hinting.

.. code-block:: php

    $mock = \Mockery::mock('MyInterface');

This stub or mock object will implement the ``MyInterface`` interface.

.. note::

    Classes marked final, or classes that have methods marked final cannot be
    mocked fully. Mockery supports creating partial mocks for these cases.
    Partial mocks will be explained later in the documentation.

Mockery also supports creating stub or mock objects based on a single existing
class, which must implement one or more interfaces. We can do this by providing
a comma-separated list of the class and interfaces as the first argument to the
``\Mockery::mock()`` method:

.. code-block:: php

    $mock = \Mockery::mock('MyClass, MyInterface, OtherInterface');

This stub or mock object will now be of type ``MyClass`` and implement the
``MyInterface`` and ``OtherInterface`` interfaces.

.. note::

    The class name doesn't need to be the first member of the list but it's a
    friendly convention to use for readability.

We can tell a mock to implement the desired interfaces by passing the list of
interfaces as the second argument:

.. code-block:: php

    $mock = \Mockery::mock('MyClass', 'MyInterface, OtherInterface');

For all intents and purposes, this is the same as the previous example.

Spies
-----

The third type of test doubles Mockery supports are spies. The main difference
between spies and mock objects is that with spies we verify the calls made
against our test double after the calls were made. We would use a spy when we
don't necessarily care about all of the calls that are going to be made to an
object.

A spy will return ``null`` for all method calls it receives. It is not possible
to tell a spy what will be the return value of a method call. If we do that, then
we would deal wit