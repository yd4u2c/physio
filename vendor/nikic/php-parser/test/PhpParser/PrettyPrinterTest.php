<?php

/**
 * This file is part of Collision.
 *
 * (c) Nuno Maduro <enunomaduro@gmail.com>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace NunoMaduro\Collision\Contracts;

use Whoops\Exception\Inspector;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This is the Collision Writer contract.
 *
 * @author Nuno Maduro <enunomaduro@gmail.com>
 */
interface Writer
{
    /**
     * Ignores traces where the file string matches one
     * of the provided regex expressions.
     *
     * @param  string[] $ignore The regex expressions.
     *
     * @return \NunoMaduro\Collision\Contracts\Writer
     */
    public function ignoreFilesIn(array $ignore): Writer;

    /**
     * Declares whether or not the Writer should show the trace.
     *
     * @param  bool $show
     *
     * @return \NunoMaduro\Collision\Contracts\Writer
     */
    public function showTrace(bool $show): Writer;

    /**
     * Declares whether or not the Writer should show the editor.
     *
     * @param  bool $show
     *
     * @return \NunoMaduro\Collision\Contracts\Writer
     */
    public function showEditor(bool $show): Writer;

    /**
     * Writes the details of the exception on the console.
     *
     * @param \Whoops\Exception\Inspector $inspector
     */
    public function write(Inspector $inspector): void;

    /**
     * Sets the output.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \NunoMaduro\Collision\Contracts\Writer
     */
    public function setOutput(OutputInterface $output): Writer;

    /**
     * Gets the output.
     *
     * @return \Symfony\Component\Console\Output\OutputInterface
     */
    public function getOutput(): OutputInterface;
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php
/* ===========================================================================
 * Copyright (c) 2018 Zindex Software
 *
 * Licensed under the MIT License
 * =========================================================================== */

require_once 'functions.php';

spl_autoload_register(function($class){
   
    $class = ltrim($class, '\\');
    $dir = __DIR__ . '/src';
    $namespace = 'Opis\Closure';
    
    if(strpos($class, $namespace) === 0)
    {
        $class = substr($class, strlen($namespace));
        $path = '';
        if(($pos = strripos($class, '\\')) !== FALSE)
        {
            $path = str_replace('\\', '/', substr($class, 0, $pos)) . '/';
            $class = substr($class, $pos + 1);
        }
        $path .= str_replace('_', '/', $class) . '.php';
        $dir .= '/' . $path;
        
        if(file_exists($dir))
        {
            include $dir;
            return true;
        }
        
        return false;
    }
    
    return false;

});
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            CHANGELOG
---------

### v3.1.6, 2019.02.22

- Fixed a bug that occurred when trying to set properties of classes that were not defined in user-land.
Those properties are now ignored.

### v3.1.5, 2019.01.14

- Improved parser

### v3.1.4, 2019.01.14

- Added support for static methods that are named using PHP keywords or magic constants.
Ex: `A::new()`, `A::use()`, `A::if()`, `A::function()`, `A::__DIR__()`, etc.
- Used `@internal` to mark classes & methods that are for internal use only and
backward compatibility might be broken at some point.

### v3.1.3, 2019.01.07

- Fixed a bug that prevented traits to be correctly resolved when used by an
anonymous class
- Fixed a bug that occurred when `$this` keyword was used inside an anonymous class

### v3.1.2, 2018.12.16

* Fixed a bug regarding comma trail in group-use statements. See [issue 23](https://github.com/opis/closure/issues/23)

### v3.1.1, 2018.10.02

* Fixed a bug where `parent` keyword was treated like a class-name and scope was not added to the
serialized closure
* Fixed a bug where return type was not properly handled for nested closures
* Support for anonymous classes was improved

### v3.1.0, 2018.09.20

* Added `transformUseVariables` and `resolveUseVariables` to
`Opis\Closure\SerializableClosure` class.
* Added `removeSecurityProvider` static method to 
`Opis\Closure\SerializableClosure` class. 
* Fixed some security related issues where a user was able to unserialize an unsigned
closure, even when a security provider was in use.

### v3.0.12, 2018.02.23

* Bugfix. See [issue 20](https://github.com/opis/closure/issues/20)

### v3.0.11, 2018.01.22

* Bugfix. See [issue 18](https://github.com/opis/closure/issues/18)

### v3.0.10, 2018.01.04

* Improved support for PHP 7.1 & 7.2

### v3.0.9, 2018.01.04

* Fixed a bug where the return type was not properly resolved. 
See [issue 17](https://github.com/opis/closure/issues/17)
* Added more tests

### v3.0.8, 2017.12.18

* Fixed a bug. See [issue 16](https://github.com/opis/closure/issues/16)

### v3.0.7, 2017.10.31

* Bugfix: static properties are ignored now, since they are not serializable

### v3.0.6, 2017.10.06

* Fixed a bug introduced by accident in 3.0.5

### v3.0.5, 2017.09.18

* Fixed a bug related to nested references

### v3.0.4, 2017.09.18

* \[*internal*\] Refactored `SerializableClosure::mapPointers` method
* \[*internal*\] Added a new optional argument to `SerializableClosure::unwrapClosures`
* \[*internal*\] Removed `SerializableClosure::getClosurePointer` method
* Fixed various bugs

### v3.0.3, 2017.09.06

* Fixed a bug related to nested object references 
* \[*internal*\] `Opis\Closure\ClosureScope` now extends `SplObjectStorage`
* \[*internal*\] The `storage` property was removed from `Opis\Closure\ClosureScope`
* \[*internal*\] The `instances` and `objects` properties were removed from `Opis\Closure\ClosureContext`

### v3.0.2, 2017.08.28

* Fixed a bug where `$this` object was not handled properly inside the 
`SerializableClosre::serialize` method. 

### v3.0.1, 2017.04.13

* Fixed a bug in 'ignore_next' state

### v3.0.0, 2017.04.07

* Dropped PHP 5.3 support
* Moved source files from `lib` to `src` folder
* Removed second parameter from `Opis\Closure\SerializableClosure::from` method and from constructor
* Removed `Opis\Closure\{SecurityProviderInterface, DefaultSecurityProvider, SecureClosure}` classes
* Refactored how signed closures were handled
* Added `wrapClosures` and `unwrapClosures` static methods to `Opis\Closure\SerializableClosure` class
* Added `Opis\Colosure\serialize` and `Opis\Closure\unserialize` functions
* Improved serialization. You can now serialize arbitrary objects and the library will automatically wrap all closures

### v2.4.0, 2016.12.16

* The parser was refactored and improved
* Refactored `Opis\Closure\SerializableClosure::__invoke` method
* `Opis\Closure\{ISecurityProvider, SecurityProvider}` were added
* `Opis\Closure\{SecurityProviderInterface, DefaultSecurityProvider, SecureClosure}` were deprecated
and they will be removed in the next major version
* `setSecretKey` and `addSecurityProvider` static methods were added to `Opis\Closure\Serializab