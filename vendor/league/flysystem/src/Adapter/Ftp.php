.. index::
    single: Mockery; Exceptions

Mockery Exceptions
==================

Mockery throws three types of exceptions when it cannot verify a mock object.

#. ``\Mockery\Exception\InvalidCountException``
#. ``\Mockery\Exception\InvalidOrderException``
#. ``\Mockery\Exception\NoMatchingExpectationException``

You can capture any of these exceptions in a try...catch block to query them
for specific information which is also passed along in the exception message
but is provided separately from getters should they be useful when logging or
reformatting output.

\Mockery\Exception\InvalidCountException
----------------------------------------

The exception class is used when a method is called too many (or too few)
times and offers the following methods:

* ``getMock()`` - return actual mock object
* ``getMockName()`` - return the name of the mock object
* ``getMethodName()`` - return the name of the method the failing expectation
  is attached to
* ``getExpectedCount()`` - return expected calls
* ``getExpectedCountComparative()`` - returns a string, e.g. ``<=`` used to
  compare to actual count
* ``getActualCount()`` - return actual calls made with given argument
  constraints

\Mockery\Exception\InvalidOrderException
----------------------------------------

The exception class is used when a method is called outside the expected order
set using the ``ordered()`` and ``globally()`` expectation modifiers. It
offers the following methods:

* ``getMock()`` - return actual mock object
* ``getMockName()`` - return the name of the mock object
* ``getMethodName()`` - return the name of the method the failing expectation
  is attached to
* ``getExpectedOrder()`` - returns an integer represented the expected index
  for which this call was expected
* ``getActualOrder()`` - return the actual index at which this method call
  occurred.

\Mockery\Exception\NoMatchingExpectationException
-------------------------------------------------

The exception class is used when a method call does not match any known
expectation.  All expectations are uniquely identified in a mock object by the
method name and the list of expected arguments. You can disable this exception
and opt for returning NULL from all unexpected method calls by using the
earlier mentioned shouldIgnoreMissing() behaviour modifier. This exception
class offers the following methods:

* ``getMock()`` - return actual mock object
* ``getMockName()`` - return the name of the mock object
* ``getMethodName()`` - return the name of the method the failing expectation
  is attached to
* ``getActualArguments()`` - return actual arguments used to search for a
  matching expectation
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 .. index::
    single: Mockery; Gotchas

Gotchas!
========

Mocking objects in PHP has its limitations and gotchas. Some functionality
can't be mocked or can't be mocked YET! If you locate such a circumstance,
please please (pretty please with sugar on top) create a new issue on GitHub
so it can be documented and resolved where possible. Here is a list to note:

1. Classes containing public ``__wakeup()`` methods can be mocked but the
   mocked ``__wakeup()`` method will perform no actions and cannot have
   expectations set for it. This is necessary since Mockery must serialize and
   unserialize objects to avoid some ``__construct()`` insanity and attempting
   to mock a ``__wakeup()`` method as normal leads to a
   ``BadMethodCallException`` being thrown.

2. Classes using non-real methods, i.e. where a method call triggers a
   ``__call()`` method, will throw an exception that the non-real method does
   not exist unless you first define at least one expectation (a simple
   ``shouldReceive()`` call would suffice). This is necessary since there is
   no other way for Mockery to be aware of the method name.

3. Mockery has two scenarios where real classes are replaced: Instance mocks
   and alias mocks. Both will generate PHP fatal errors if the real class is
   loaded, usually via a require or include statement. Only use these two mock
   types where autoloading is in place and where classes are not explicitly
   loaded on a per-file basis using ``require()``, ``require_once()``, etc.

4. Internal PHP classes are not entirely capable of being fully analysed using
   ``Reflection``. For example, ``Reflection`` cannot reveal details of
   expected parameters to the methods of such internal classes. As a result,
   there will be problems where a method parameter is defined to accept a
   value by reference (Mockery cannot detect this condition and will assume a
   pass by value on scalars and arrays). If references as internal class
   method parameters are needed, you should use the
   ``\Mockery\Configuration::setInternalClassMethodParamMap()`` method.

5. Creating a mock implementing a certain interface with incorrect case in the
   interface name, and then creating a second mock implementing the same
   interface, but this time with the correct case, will have undefined behavior
   due to PHP's ``class_exists`` and related functions being case insensitive.
   Using the ``::class`` keyword in PHP can help you avoid these mistakes.

The gotchas noted above are largely down to PHP's architecture and are assumed
to be unavoidable. But - if you figure out a solution (or a better one than
what may exist), let us know!
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       .. index::
    single: Reserved Method Names

Reserved Method Names
=====================

As you may have noticed, Mockery uses a number of methods called directly on
all mock objects, for example ``shouldReceive()``. Such methods are necessary
in order to setup expectations on the given mock, and so they cannot be
implemented on the classes or objects being mocked without creating a method
name collision (reported as a PHP fatal error). The methods reserved by
Mockery are:

* ``shouldReceive()``
* ``shouldBeStrict()``

In addition, all mocks utilise a set of added methods and protected properties
which cannot exist on the class or object being mocked. These are far less
likely to cause collisions. All properties are prefixed with ``_mockery`` and
all method names with ``mockery_``.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     .. index::
    single: Alternative shouldReceive Syntax

Alternative shouldReceive Syntax
================================

As of Mockery 1.0.0, we support calling methods as we would call any PHP method,
and not as string arguments to Mockery ``should*`` methods.

The two Mockery methods that enable this are ``allows()`` and ``expects()``.

Allows
------

We use ``allows()`` when we create stubs for methods that return a predefined
return value, but for these method stubs we don't care how many times, or if at
all, were they called.

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->allows([
        'name_of_method_1' => 'return value',
        'name_of_method_2' => 'return value',
    ]);

This is equivalent with the following ``shouldReceive`` syntax:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->shouldReceive([
        'name_of_method_1' => 'return value',
        'name_of_method_2' => 'return value',
    ]);

Note that with this format, we also tell Mockery that we don't care about the
arguments to the stubbed methods.

If we do care about the arguments, we would do it like so:

.. code-block:: php

    $mock = \Mockery::mock('MyClass');
    $mock->allows()
  