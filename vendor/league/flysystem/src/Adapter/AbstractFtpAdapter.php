.. index::
    single: Getting Started; Simple Example

Simple Example
==============

Imagine we have a ``Temperature`` class which samples the temperature of a
locale before reporting an average temperature. The data could come from a web
service or any other data source, but we do not have such a class at present.
We can, however, assume some basic interactions with such a class based on its
interaction with the ``Temperature`` class:

.. code-block:: php

    class Temperature
    {
        private $service;

        public function __construct($service)
        {
            $this->service = $service;
        }

        public function average()
        {
            $total = 0;
            for ($i=0; $i<3; $i++) {
                $total += $this->service->readTemp();
            }
            return $total/3;
        }
    }

Even without an actual service class, we can see how we expect it to operate.
When writing a test for the ``Temperature`` class, we can now substitute a
mock object for the real service which allows us to test the behaviour of the
``Temperature`` class without actually needing a concrete service instance.

.. code-block:: php

    use \Mockery;

    class TemperatureTest extends \PHPUnit\Framework\TestCase
    {
        public function tearDown()
        {
            Mockery::close();
        }

        public function testGetsAverageTemperatureFromThreeServiceReadings()
        {
            $service = Mockery::mock('service');
            $service->shouldReceive('readTemp')
                ->times(3)
                ->andReturn(10, 12, 14);

            $temperature = new Temperature($service);

            $this->assertEquals(12, $temperature->average());
        }
    }

We create a mock object which our ``Temperature`` class will use and set some
expectations for that mock — that it should receive three calls to the ``readTemp``
method, and these calls will return 10, 12, and 14 as results.

.. note::

    PHPUnit integration can remove the need for a ``tearDown()`` method. See
    ":doc:`/reference/phpunit_integration`" for more information.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             INDX( 	 �Bx             (   �  �       t                     �     h T     �     �B�!pk� D�����q ��<��B�!pk��       �               	 i n d e x . r s t     �     x b     �     �B�!pk� D������!��<��B�!pk�                      i n s t a l l a t i o n . r s t       �     h X     �     ���!pk� D����B6$��<����!pk��       �                m a p . r s t . i n c �     x h     �     ���!pk� D������&��<����!pk�                       q u i c k _ r e f e r e n c e . r s  �     x f     �     ��!pk� D����
�(��<���!pk�       C               s i m p l e _ e x a m p l e . r s t   �     p \     �     ��!pk� D����
�(��<���!pk�       �               u p g r a d i n g . r s t                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    .. index::
    single: Upgrading

Upgrading
=========

Upgrading to 1.0.0
------------------

Minimum PHP version
+++++++++++++++++++

As of Mockery 1.0.0 the minimum PHP version required is 5.6.

Using Mockery with PHPUnit
++++++++++++++++++++++++++

In the "old days", 0.9.x and older, the way Mockery was integrated with PHPUnit was
through a PHPUnit listener. That listener would in turn call the ``\Mockery::close()``
method for us.

As of 1.0.0, PHPUnit test cases where we want to use Mockery, should either use the
``\Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration`` trait, or extend the
``\Mockery\Adapter\Phpunit\MockeryTestCase`` test case. This will in turn call the
``\Mockery::close()`` method for us.

Read the documentation for a detailed overview of ":doc:`/reference/phpunit_integration`".

``\Mockery\Matcher\MustBe`` is deprecated
+++++++++++++++++++++++++++++++++++++++++

As of 1.0.0 the ``\Mockery\Matcher\MustBe`` matcher is deprecated and will be removed in
Mockery 2.0.0. We recommend instead to use the PHPUnit or Hamcrest equivalents of the
MustBe matcher.

``allows`` and ``expects``
++++++++++++++++++++++++++

As of 1.0.0, Mockery has two new methods to set up expectations: ``allows`` and ``expects``.
This means that these methods names are now "reserved" for Mockery, or in other words
classes you want to mock with Mockery, can't have methods called ``allows`` or ``expects``.

Read more in the documentation about this ":doc:`/reference/alternative_should_receive_syntax`".

No more implicit regex matching for string arguments
++++++++++++++++++++++++++++++++++++++++++++++++++++

When setting up string arguments in method expectations, Mockery 0.9.x and older, would try
to match arguments using a regular expression in a "last attempt" scenario.

As of 1.0.0, Mockery will no longer attempt to do this regex matching, but will only try
first the identical operator ``===``, and failing that, the equals operator ``==``.

If you want to match an argument using regular expressions, please use the new
``\Mockery\Matcher\Pattern`` matcher. Read more in the documentation about this
pattern matcher in the ":doc:`/reference/argument_validation`" section.

``andThrow`` ``\Throwable``
+++++++++++++++++++++++++++

As of 1.0.0, the ``andThrow`` can now throw any ``\Throwable``.

Upgrading to 0.9
----------------

The generator was completely rewritten, so any code with a deep integration to
mockery will need evaluating.

Upgrading to 0.8
----------------

Since the release of 0.8.0 the following behaviours were altered:

1. The ``shouldIgnoreMissing()`` behaviour optionally applied to mock objects
   returned an instance of ``\Mockery\Undefined`` when methods called did not
   match a known expectation. Since 0.8.0, this behaviour was switched to
   returning ``null`` instead. You can restore the 0.7.2 behaviour by using the
   following:

   .. code-block:: php

       $mock = \Mockery::mock('stdClass')->shouldIgnoreMissing()->asUndefined();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             .. index::
    single: Mockery; Configuration

Mockery Global Configuration
============================

To allow for a degree of fine-tuning, Mockery utilises a singleton
configuration object to store a small subset of core behaviours. The two
currently present include:

* Option to allow/disallow the mocking of methods which do not actually exist
  fulfilled (i.e. unused)
* Setter/Getter for added a parameter map for internal PHP class methods
  (``Reflection`` cannot detect these automatically)

By default, the first behaviour is enabled. Of course, there are
situations where this can lead to unintended consequences. The mocking of
non-existent methods may allow mocks based on real classes/objects to fall out
of sync with the actual implementations, especially when some degree of
integration testing (testing of object wiring) is not being performed.

You may allow or disallow this behaviour (whether for whole test suites or
just select tests) by using the following call:

.. code-block:: php

    \Mockery::getConfiguration()->allowMockingNonExistentMethods(bool);

Passing a true allows the behaviour, false disallows it. It takes effect
immediately until switched back. If the behaviour is detected when not allowed,
it will result in an Exception being thrown at that point. Note that disallowing
this behaviour should be carefully considered since it necessarily removes at
least some of Mockery's flexibility.

The other two methods are:

.. code-block:: php

    \Mockery::getConfiguration()->setInternalClassMethodParamMap($class, $method, array $paramMap)
    \Mockery::getConfiguration()->getInternalClassMethodParamMap($class, $method)

These are used to define parameters (i.e. the signature string of each) for the
methods of internal PHP classes (e.g. SPL, or PECL extension classes like
ext/mongo's MongoCollection. Reflection cannot analyse the parameters of internal
classes. Most of the time, you never need to do this. It's mainly needed where an
internal class method uses pass-by-reference for a parameter - you MUST in such
cases ensure the parameter signature includes the ``&`` symbol correctly as Mockery
won't correctly add it automatically for internal classes.

Disabling reflection caching
----------------------------

Mockery heavily uses `"reflection" <https://secure.php.net/manual/en/book.reflection.php>`_
to do it's job. To speed up things, Mockery caches internally the information it
gathers via reflection. In some cases, this caching can cause problems.

The **only** known situation when this occurs is when PHPUnit's ``--static-backup`` option
is used. If you use ``--static-backup`` and you get an error that looks like the
following:

.. code