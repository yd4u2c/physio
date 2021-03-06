{
    "_readme": [
        "This file locks the dependencies of your project to a known state",
        "Read more about it at https://getcomposer.org/doc/01-basic-usage.md#installing-dependencies",
        "This file is @generated automatically"
    ],
    "content-hash": "d98ffe050f0ba4e81c2d1a98ca945200",
    "packages": [
        {
            "name": "amphp/amp",
            "version": "v2.0.7",
            "source": {
                "type": "git",
                "url": "https://github.com/amphp/amp.git",
                "reference": "d561cc9736bc18dd94a2fc9cdae98b616bd92c43"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/amphp/amp/zipball/d561cc9736bc18dd94a2fc9cdae98b616bd92c43",
                "reference": "d561cc9736bc18dd94a2fc9cdae98b616bd92c43",
                "shasum": ""
            },
            "require": {
                "php": ">=7"
            },
            "require-dev": {
                "amphp/phpunit-util": "^1",
                "friendsofphp/php-cs-fixer": "^2.3",
                "phpstan/phpstan": "^0.8.5",
                "phpunit/phpunit": "^6.0.9",
                "react/promise": "^2"
            },
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.0.x-dev"
                }
            },
            "autoload": {
                "psr-4": {
                    "Amp\\": "lib"
                },
                "files": [
                    "lib/functions.php",
                    "lib/Internal/functions.php"
                ]
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Bob Weinand",
                    "email": "bobwei9@hotmail.com"
                },
                {
                    "name": "Niklas Keller",
                    "email": "me@kelunik.com"
                },
                {
                    "name": "Daniel Lowrey",
                    "email": "rdlowrey@php.net"
                },
                {
                    "name": "Aaron Piotrowski",
                    "email": "aaron@trowski.com"
                }
            ],
            "description": "A non-blocking concurrency framework for PHP applications.",
            "homepage": "http://amphp.org/amp",
            "keywords": [
                "async",
                "asynchronous",
                "awaitable",
                "concurrency",
                "event",
                "event-loop",
                "future",
                "non-blocking",
                "promise"
            ],
            "time": "201