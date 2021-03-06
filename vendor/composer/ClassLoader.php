parameters:
    autoload_files:
        - %currentWorkingDirectory%/tests/Doctrine/Tests/Common/Annotations/DocParserTest.php
    excludes_analyse:
        - %currentWorkingDirectory%/tests/*/Fixtures/*
        - %currentWorkingDirectory%/tests/Doctrine/Tests/Common/Annotations/ReservedKeywordsClasses.php
        - %currentWorkingDirectory%/tests/Doctrine/Tests/Common/Annotations/Ticket/DCOM58Entity.php
        - %currentWorkingDirectory%/tests/Doctrine/Tests/DoctrineTestCase.php
    polluteScopeWithLoopInitialAssignments: true
    ignoreErrors:
        - '#Class Doctrine_Tests_Common_Annotations_Fixtures_ClassNoNamespaceNoComment not found#'
        - '#Instantiated class Doctrine_Tests_Common_Annotations_Fixtures_ClassNoNamespaceNoComment not found#'
        - '#Property Doctrine\\Tests\\Common\\Annotations\\DummyClassNonAnnotationProblem::\$foo has unknown class#'
        - '#Class Doctrine\\Tests\\Common\\Annotations\\True not found#'
        - '#Class Doctrine\\Tests\\Common\\Annotations\\False not found#'
        - '#Class Doctrine\\Tests\\Common\\Annotations\\Null not found#'
        - '#Call to an undefined method ReflectionClass::getUseStatements\(\)#'
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    # Doctrine Annotations

[![Build Status](https://travis-ci.org/doctrine/annotations.svg?branch=master)](https://travis-ci.org/doctrine/annotations)
[![Dependency Status](https://www.versioneye.com/package/php--doctrine--annotations/badge.png)](https://www.versioneye.com/package/php--doctrine--annotations)
[![Reference Status](https://www.versioneye.com/php/doctrine:annotations/reference_badge.svg)](https://www.versioneye.com/php/doctrine:annotations/references)
[![Total Downloads](https://poser.pugx.org/doctrine/annotations/downloads.png)](https://packagist.org/packages/doctrine/annotations)
[![Latest Stable Version](https://poser.pugx.org/doctrine/annotations/v/stable.png)](https://packagist.org/packages/doctrine/annotations)

Docblock Annotations Parser library (extracted from [Doctrine Common](https://github.com/doctrine/common)).

## Documentation

See the [doctrine-project website](http://docs.doctrine-project.org/projects/doctrine-common/en/latest/reference/annotations.html).

## Changelog

See [CHANGELOG.md](CHANGELOG.md).
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          Handling Annotations
====================

There are several different approaches to handling annotations in PHP. Doctrine Annotations
maps docblock annotations to PHP classes. Because not all docblock annotations are used
for metadata purposes a filter is applied to ignore or skip classes that are not Doctrine annotations.

Take a look at the following code snippet:

.. code-block:: php

    namespace MyProject\Entities;

    use Doctrine\ORM\Mapping AS ORM;
    use Symfony\Component\Validation\Constraints AS Assert;

    /**
     * @author Benjamin Eberlei
     * @ORM\Entity
     * @MyProject\Annotations\Foobarable
     */
    class User
    {
        /**
         * @ORM\Id @ORM\Column @ORM\GeneratedValue
         * @dummy
         * @var int
         */
        private $id;

        /**
         * @ORM\Column(type="string")
         * @Assert\NotEmpty
         * @Assert\Email
         * @var string
         */
        private $email;
    }

In this snippet you can see a variety of different docblock annotations:

- Documentation annotations such as ``@var`` and ``@author``. These annotations are on a blacklist and never considered for throwing an exception due to wrongly used annotations.
- Annotations imported through use statements. The statement ``use Doctrine\ORM\Mapping AS ORM`` makes all classes under that namespace available as ``@ORM\ClassName``. Same goes for the import of ``@Assert``.
- The ``@dummy`` annotation. It is not a documentation annotation and not blacklisted. For Doctrine Annotations it is not entirely clear how to handle this annotation. Depending on the configuration an exception (unknown annotation) will be thrown when parsing this annotation.
- The fully qualified annotation ``@MyProject\Annotations\Foobarable``. This is transformed directly into the given class name.

How are these annotations loaded? From looking at the code you could guess that the ORM Mapping, Assert Validation and the fully qualified annotation can just be loaded using
the defined PHP autoloaders. This is not the case however: For error handling reasons every check for class existence inside the AnnotationReader sets the second parameter $autoload
of ``class_exists($name, $autoload)`` to false. To work flawlessly the AnnotationReader requires silent autoloaders which many autoloaders are not. Silent autoloading is NOT
part of the `PSR-0 specification <https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md>`_ for autoloading.

This is why Doctrine Annotations uses its own autoloading mechanism through a global registry. If you are wondering about the annotation registry being global,
there is no other way to solve the architectural problems of autoloading annotation classes in a straightforward fashion. Additionally if you think about PHP
autoloading then you recognize it is a global as well.

To anticipate the configuration section, making the above PHP class work with Doctrine Annotations requires this setup:

.. code-block:: php

    use Doctrine\Common\Annotations\AnnotationReader;
    use Doctrine\Common\Annotations\AnnotationRegistry;

    AnnotationRegistry::registerFile("/path/to/doctrine/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php");
    AnnotationRegistry::registerAutoloadNamespace("Symfony\Component\Validator\Constraint", "/path/to/symfony/src");
    AnnotationRegistry::registerAutoloadNamespace("MyProject\Annotations", "/path/to/myproject/src");

    $reader = new AnnotationReader();
    AnnotationReader::addGlobalIgnoredName('dummy');

The second block with the annotation registry calls registers all the three different annotation namespaces that are used.
Doctrine saves all its annotations in a single file, that is why ``AnnotationRegistry#registerFile`` is used in contrast to
``AnnotationRegistry#registerAutoloadNamespace`` which creates a PSR-0 compatible loading mechanism for class to file names.

In the third block, we create the actual AnnotationReader instance. Note that we also add "dummy" to the global list of annotations
for which we do not throw exceptions. Setting this is necessary in our example case, otherwise ``@dummy`` would trigger an exception to
be thrown during the parsing of the docblock of ``MyProject\Entities\User#id``.

Setup and Configuration
-----------------------

To use the annotations library is simple, you just need to create a new ``AnnotationReader`` instance:

.. code-block:: php

    $reader = new \Doctrine\Common\Annotations\AnnotationReader();

This creates a simple annotation reader with no caching other than in memory (in php arrays).
Since parsing docblocks can be expensive you should cache this process by using
a caching reader.

You can use a file caching reader:

.. code-block:: php

    use Doctrine\Common\Annotations\FileCacheReader;
    use Doctrine\Common\Annotations\AnnotationReader;

    $reader = new FileCacheReader(
        new AnnotationReader(),
        "/path/to/cache",
        $debug = true
    );

If you set the debug flag to true the cache reader will check for changes in the original files, which
is very important during development. If you don't set it to true you have to delete the directory to clear the cache.
This gives faster perf