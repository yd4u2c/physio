<?xml version="1.0" encoding="UTF-8"?>

<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/5.2/phpunit.xsd"
         backupGlobals="false"
         colors="true"
         bootstrap="vendor/autoload.php"
         failOnRisky="true"
         failOnWarning="true"
>
    <php>
        <ini name="error_reporting" value="-1" />
    </php>

    <testsuites>
        <testsuite name="Symfony Debug Component Test Suite">
            <directory>./Tests/</directory>
        </testsuite>
        <testsuite name="Symfony Debug Extension Test Suite">
            <directory suffix=".phpt">./Resources/ext/tests/</directory>
        </testsuite>
    </testsuites>

    <filter>
        <whitelist>
            <directory>./</directory>
            <exclude>
                <directory>./Tests</directory>
                <directory>./vendor</directory>
            </exclude>
        </whitelist>
    </filter>
</phpunit>
                                                                                                                                                                                                                                                                                                                                                                                                                