# Change Log

All notable changes to this project will be documented in this file. This project adheres to [Semantic Versioning](http://semver.org/).

## [2.0.2] - 2018-09-13

### Fixed

* Fixed [#48](https://github.com/sebastianbergmann/php-file-iterator/issues/48): Excluding an array that contains false ends up excluding the current working directory

## [2.0.1] - 2018-06-11

### Fixed

* Fixed [#46](https://github.com/sebastianbergmann/php-file-iterator/issues/46): Regression with hidden parent directory

## [2.0.0] - 2018-05-28

### Fixed

* Fixed [#30](https://github.com/sebastianbergmann/php-file-iterator/issues/30): Exclude is not considered if it is a parent of the base path

### Changed

* This component now uses namespaces

### Removed

* This component is no longer supported on PHP 5.3, PHP 5.4, PHP 5.5, PHP 5.6, and PHP 7.0

## [1.4.5] - 2017-11-27

### Fixed

* Fixed [#37](https://github.com/sebastianbergmann/php-file-iterator/issues/37): Regression caused by fix for [#30](https://github.com/sebastianbergmann/php-file-iterator/issues/30)

## [1.4.4] - 2017-11-27

### Fixed

* Fixed [#30](https://github.com/sebastianbergmann/php-file-iterator/issues/30): Exclude is not considered if it is a parent of the base path

## [1.4.3] - 2017-11-25

### Fixed

* Fixed [#34](https://github.com/sebastianbergmann/php-file-iterator/issues/34): Factory should use canonical directory names

## [1.4.2] - 2016-11-26

No changes

## [1.4.1] - 2015-07-26

No changes

## 1.4.0 - 2015-04-02

### Added

* [Added support for wildcards (glob) in exclude](https://github.com/sebastianbergmann/php-file-iterator/pull/23)

[2.0.2]: https://github.com/sebastianbergmann/php-file-iterator/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/sebastianbergmann/php-file-iterator/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/sebastianbergmann/php-file-iterator/compare/1.4...master
[1.4.5]: https://github.com/sebastianbergmann/php-file-iterator/compare/1.4.4...1.4.5
[1.4.4]: https://github.com/sebastianbergmann/php-file-iterator/compare/1.4.3...1.4.4
[1.4.3]: https://github.com/sebastianbergmann/php-file-iterator/compare/1.4.2...1.4.3
[1.4.2]: https://github.com/sebastianbergmann/php-file-iterator/compare/1.4.1...1.4.2
[1.4.1]: https://github.com/sebastianbergmann/php-file-iterator/compare/1.4.0...1.4.1
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                {
    "name": "phpunit/php-file-iterator",
    "description": "FilterIterator implementation that filters files based on a list of suffixes.",
    "type": "library",
    "keywords": [
        "iterator",
        "filesystem"
    ],
    "homepage": "https://github.com/sebastianbergmann/php-file-iterator/",
    "license": "BSD-3-Clause",
    "authors": [
        {
            "name": "Sebastian Bergmann",
            "email": "sebastian@phpunit.de",
            "role": "lead"
        }
    ],
    "support": {
        "issues": "https://github.com/sebastianbergmann/php-file-iterator/issues"
    },
    "require": {
        "php": "^7.1"
    },
    "require-dev": {
        "phpunit/phpunit": "^7.1"
    },
    "autoload": {
        "classmap": [
            "src/"
        ]
    },
    "extra": {
        "branch-alias": {
            "dev-master": "2.0.x-dev"
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             INDX( 	  t�             (     �                           �      p ^     �      ��qpk� �}�K��V��<���qpk�                       . g i t a t t r i b u t e s   �      ` P     �      ���qpk��)^%����qpk����qpk�                       . g i t h u b �      h V     �      )J�qpk� �}�K�qXY��<�)J�qpk�8       7               
 . g i t i g n o r e   �      p Z     �      0��qpk� �}�K�к[��<�0��qpk�        �               . p h p _ c s . d i s t       �      h X     �      ��qpk� �}�K���`��<���qpk��      �               . t r a v i s . y m l �      p Z     �      mq�qpk� �}�K���`��<�mq�qpk�       	               C h a n g e L o g . m d       �      p \     �      -Գqpk� �}�K���b��<�-Գqpk�       s               c o m p o s e r . j s o n     �      ` P     �      �6�qpk� �}�K�@Ee��<��6�qpk�                      L I C E N S E �      h X     �      d��qpk� �}�K�@Ee��<�d��qpk�       �               p h p u n i t . x m l �      h T     �      ���qpk� �}�K���g��<����qpk�@      ;              	 R E A D M E . m d     �      X H     �      �\�qpk��H�qpk��H�qpk��\�qpk�                        s r c �      ` L     �      �H�qpk�ͫ�qpk�ͫ�qpk��H�qpk�                        t e s t s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     php-file-iterator

Copyright (c) 2009-2018, Sebastian Bergmann <sebastian@phpunit.de>.
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided t