.. index::
    single: Cookbook; Big Parent Class

Big Parent Class
================

In some application code, especially older legacy code, we can come across some
classes that extend a "big parent class" - a parent class that knows and does
too much:

.. code-block:: php

    class BigParentClass
    {
        public function doesEverything()
        {
            // sets up database connections
            // writes to log files
        }
    }

    class ChildClass extends BigParentClass
    {
        public function doesOneThing()
        {
            // but calls on BigParentClass methods
            $result = $this->doesEverything();
            // does something with $result
            return $result;
        }
    }

We want to test our ``ChildClass`` and its ``doesOneThing`` method, but the
problem is that it calls on ``BigParentClass::doesEverything()``. One way to
handle this would be to mock out **all** of the dependencies ``BigParentClass``
has and needs, and then finally actually test our ``doesOneThing`` method. It's
an awful lot of work to do that.

What we can do, is to do something... unconventional. We can create a runtime
partial test double of the ``ChildClass`` itself and mock only the parent's
``doesEverything()`` method:

.. code-block:: php

    $childClass = \Mockery::mock('ChildClass')->makePartial();
    $childClass->shouldReceive('doesEverything')
        ->andReturn('some result from parent');

    $childClass->doesOneThing(); // string("some result from parent");

With this approach we mock out only the ``doesEverything()`` method, and all the
unmocked methods are called on the actual ``ChildClass`` instance.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        .. index::
    single: Cookbook; Class Constants

Class Constants
===============

When creating a test double for a class, Mockery does not create stubs out of
any class constants defined in the class we are mocking. Sometimes though, the
non-existence of these class constants, setup of the test, and the application
code itself, it can lead to undesired behavior, and even a PHP error:
``PHP Fatal error:  Uncaught Error: Undefined class constant 'FOO' in ...```

While supporting class constants in Mockery would be possible, it does require
an awful lot of work, for a small number of use cases.

Named Mocks
-----------

We can, however, deal with these constants in a way supported by Mockery - by
using :ref:`creating-test-doubles-named-mocks`.

A named mock is a test double that has a name of the class we want to mock, but
under it is a stubbed out class that mimics the real class with canned responses.

Lets look at the following made up, but not impossible scenario:

.. code-block:: php

    class Fetcher
    {
        const SUCCESS = 0;
        const FAILURE = 1;

        public static function fetch()
        {
            // Fetcher gets something for us from somewhere...
            return self::SUCCESS;
        }
    }

    class MyClass
    {
        public function doFetching()
        {
            $response = Fetcher::fetch();

            if ($response == Fetcher::SUCCESS) {
                echo "Thanks!" . PHP_EOL;
            } else {
                echo "Try again!" . PHP_EOL;
            }
        }
    }

Our ``MyClass`` calls a ``Fetcher`` that fetches some resource from somewhere -
maybe it downloads a file from a remote web service. Our ``MyClass`` prints out
a response message depending on the response from the ``Fetcher::fetch()`` call.

When testing ``MyClass`` we don't really want ``Fetcher`` to go and download
random stuff from the internet every time we run our test suite. So we mock it
out:

.. code-block:: php

    // Using alias: because fetch is called statically!
    \Mockery::mock('alias:Fetcher')
        ->shouldReceive('fetch')
        ->andReturn(0);

    $myClass = new MyClass();
    $myClass->doFetching();

If we run this, our test will error out with a nasty
``PHP Fatal error:  Uncaught Error: Undefined class constant 'SUCCESS' in ..``.

Here's how a ``namedMock()`` can help us in a situation like this.

We create a stub for the ``Fetcher`` class, stubbing out the class constants,
and then use ``namedMock()`` to create a mock named ``Fetcher`` based on our
stub:

.. code-block:: php

    class FetcherStub
    {
        const SUCCESS = 0;
        const FAILURE = 1;
    }

    \Mockery::mock('Fetcher', 'FetcherStub')
        ->shouldReceive('fetch')
        ->andReturn(0);

    $myClass = new MyClass();
    $myClass->doFetching();

This works because under the hood, Mockery creates a class called ``Fetcher``
that extends ``FetcherStub``.

The same approach will work even if ``Fetcher::fetch()`` is not a static
dependency:

.. code-block:: php

    class Fetcher
    {
        const SUCCESS = 0;
        const FAILURE = 1;

        public function fetch()
        {
            // Fetcher gets something for us from somewhere...
            return self::SUCCESS;
        }
    }

    class MyClass
    {
        public function doFetching($fetcher)
        {
            $response = $fetcher->fetch();

            if ($response == Fetcher::SUCCESS) {
                echo "Thanks!" . PHP_EOL;
            } else {
                echo "Try again!" . PHP_EOL;
            }
        }
    }

And the test will have something like this:

.. code-block:: php

    class FetcherStub
    {
        const SUCCESS = 0;
        const FAILURE = 1;
    }

    $mock = \Mockery::mock('Fetcher', 'FetcherStub')
    $mock->shouldReceive('fetch')
        ->andReturn(0);

    $myClass = new MyClass();
    $myClass->doFetching($mock);


Constants Map
-------------

Another way of mocking class constants can be with the use of the constants map configuration.

Given a class with constants:

.. code-block:: php

    class Fetcher
    {
        const SUCCESS = 0;
        const FAILURE = 1;

        public function fetch()
        {
            // Fetcher gets something for us from somewhere...
            return self::SUCCESS;
        }
    }

It can be mocked with:

.. code-block:: php

    \Mockery::getConfiguration()->setConstantsMap([
        'Fetcher' => [
            'SUCCESS' => 'success',
            'FAILURE' => 'fail',
        ]
    ]);

    $mock = \Mockery::mock('Fetcher');
    var_dump($mock::SUCCESS); // (string) 'success'
    var_dump($mock::FAILURE); // (string) 'fail'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                .. index::
    single: Cookbook; Default Mock Expectations

Default Mock Expectations
=========================

Often in unit testing, we end up with sets of tests which use the same object
dependency over and over again. Rather than mocking this class/object within
every single unit test (requiring a mountain of duplicate code), we can
instead define reusable default mocks within the test case's ``setup()``
method. This even works where unit tests use varying expectations on the same
or similar mock object.

How this works, is that you can define mocks with default expectations. Then,
in a later unit test, you can add or fine-tune expectations for that specific
test. Any expectation can be set as a default using the ``byDefault()``
declaration.
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           INDX( 	 �7x             (   �  �         d                   �     � j     �     �!pk� D�����#��<��!pk�       �               b i g _ p a r e n t _ c l a s s . r s t       �     x h     �     ��!pk� D�����#��<���!pk�        @               c l a s s _ c o n s t a n t s . r s t �     � r     �     
��!pk� D��������<�
��!pk�       �               d e f a u l t _ e x p e c t a t i o n s . r s t       �     � v     �     n	�!pk� D����s����<�n	�!pk��     �               d e t e c t i n g _ m o c k _ o b j e c t s . r s t   �     h T     �     2k�!pk� D�����J���<�2k�!pk��       �               	 i n d e x . r s t     �     h X     �     ���!pk� D����0����<����!pk�                     m a p . r s t . i n c �     p ^     �     ���!pk� D����0����<����!pk�       �               m o c k e r y _ o n . r s t   �     � |     �     ��!pk� D��������<���!pk�       N               m o c k i n g _ h a r d _ d e p e n  e n c i e