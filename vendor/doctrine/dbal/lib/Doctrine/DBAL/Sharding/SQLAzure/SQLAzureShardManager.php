<?xml version="1.0"?>
<ruleset>
    <arg name="basepath" value="."/>
    <arg name="extensions" value="php"/>
    <arg name="parallel" value="80"/>
    <arg name="cache" value=".phpcs-cache"/>
    <arg name="colors"/>

    <!-- Ignore warnings, show progress of the run and show sniff names -->
    <arg value="nps"/>

    <file>src</file>
    <file>tests</file>

    <rule ref="Doctrine">
        <exclude name="SlevomatCodingStandard.TypeHints.DeclareStrictTypes"/>
        <exclude name="SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint"/>
        <exclude name="SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingReturnTypeHint"/>
        <exclude name="SlevomatCodingStandard.Exceptions.ReferenceThrowableOnly.ReferencedGeneralException"/>
    </rule>

    <rule ref="SlevomatCodingStandard.Classes.SuperfluousAbstractClassNaming">
        <exclude-pattern>tests/DoctrineTest/InstantiatorTestAsset/AbstractClassAsset.php</exclude-pattern>
    </rule>

    <rule ref="SlevomatCodingStandard.Classes.SuperfluousExceptionNaming">
        <exclude-pattern>src/Doctrine/Instantiator/Exception/UnexpectedValueException.php</exclude-pattern>
        <exclude-pattern>src/Doctrine/Instantiator/Exception/InvalidArgumentException.php</exclude-pattern>
    </rule>

    <rule ref="SlevomatCodingStandard.Classes.SuperfluousInterfaceNaming">
        <exclude-pattern>src/Doctrine/Instantiator/Exception/ExceptionInterface.php</exclude-pattern>
        <exclude-pattern>src/Doctrine/Instantiator/InstantiatorInterface.php</exclude-pattern>
    </rule>
</ruleset>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      # Instantiator

This library provides a way of avoiding usage of constructors when instantiating PHP classes.

[![Build Status](https://travis-ci.org/doctrine/instantiator.svg?branch=master)](https://travis-ci.org/doctrine/instantiator)
[![Code Coverage](https://scrutinizer-ci.com/g/doctrine/instantiator/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/doctrine/instantiator/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/doctrine/instantiator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/doctrine/instantiator/?branch=master)
[![Dependency Status](https://www.versioneye.com/package/php--doctrine--instantiator/badge.svg)](https://www.versioneye.com/package/php--doctrine--instantiator)

[![Latest Stable Version](https://poser.pugx.org/doctrine/instantiator/v/stable.png)](https://packagist.org/packages/doctrine/instantiator)
[![Latest Unstable Version](https://poser.pugx.org/doctrine/instantiator/v/unstable.png)](https://packagist.org/packages/doctrine/instantiator)

## Installation

The suggested installation method is via [composer](https://getcomposer.org/):

```sh
php composer.phar require "doctrine/instantiator:~1.0.3"
```

## Usage

The instantiator is able to create new instances of any class without using the constructor or any API of the class
itself:

```php
$instantiator = new \Doctrine\Instantiator\Instantiator();

$instance = $instantiator->instantiate(\My\ClassName\Here::class);
```

## Contributing

Please read the [CONTRIBUTING.md](CONTRIBUTING.md) contents if you wish to help out!

## Credits

This library was migrated from [ocramius/instantiator](http