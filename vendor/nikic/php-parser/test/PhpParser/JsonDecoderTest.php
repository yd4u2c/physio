{
    "name": "nunomaduro/collision",
    "description": "Cli error handling for console/command-line PHP applications.",
    "keywords": ["console", "command-line", "php", "cli", "error", "handling", "laravel-zero", "laravel", "artisan", "symfony"],
    "license": "MIT",
    "support": {
        "issues": "https://github.com/nunomaduro/collision/issues",
        "source": "https://github.com/nunomaduro/collision"
    },
    "authors": [
        {
            "name": "Nuno Maduro",
            "email": "enunomaduro@gmail.com"
        }
    ],
    "require": {
        "php": "^7.1",
        "filp/whoops": "^2.1.4",
        "symfony/console": "~2.8|~3.3|~4.0",
        "jakub-onderka/php-console-highlighter": "0.3.*|0.4.*"
    },
    "require-dev": {
        "laravel/framework": "5.7.*",
        "nunomaduro/larastan": "^0.3.0",
        "phpstan/phpstan": "^0.10",
        "phpunit/phpunit": "~7.3"
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true,
    "autoload": {
        "psr-4": {
            "NunoMaduro\\Collision\\": "src/"
        }
    },
    "config": {
        "preferred-install": "dist",
        "sort-packages": true
    },
    "extra": {
        "laravel": {
        