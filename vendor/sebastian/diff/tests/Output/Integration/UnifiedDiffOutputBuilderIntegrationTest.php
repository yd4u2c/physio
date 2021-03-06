<?xml version="1.0" encoding="UTF-8"?>
<project name="object-enumerator" default="setup">
    <target name="setup" depends="clean,composer"/>

    <target name="clean" description="Cleanup build artifacts">
        <delete dir="${basedir}/vendor"/>
        <delete file="${basedir}/composer.lock"/>
    </target>

    <target name="composer" depends="clean" description="Install dependencies with Composer">
        <exec executable="composer" taskname="composer">
            <arg value="update"/>
            <arg value="--no-interaction"/>
            <arg value="--no-progress"/>
            <arg value="--no-ansi"/>
            <arg value="--no-suggest"/>
            <arg value="--optimize-autoloader"/>
            <arg value="--prefer-stable"/>
        </exec>
    </target>
</project>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     # Change Log

All notable changes to `sebastianbergmann/object-enumerator` are documented in this file using the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [3.0.3] - 2017-08-03

### Changed

* Bumped required version of `sebastian/object-reflector`

## [3.0.2] - 2017-03-12

### Changed

* `sebastian/object-reflector` is now a dependency

## [3.0.1] - 2017-03-12

### Fixed

* Objects aggregated in inherited attributes are not enumerated

## [3.0.0] - 2017-03-03

### Removed

* This component is no longer supported on PHP 5.6

## [2.0.1] - 2017-02-18

### Fixed

* Fixed [#2](https://github.com/sebastianbergmann/phpunit/pull/2): Exceptions in `ReflectionProperty: