{
    "name": "psy/psysh",
    "description": "An interactive shell for modern PHP.",
    "type": "library",
    "keywords": ["console", "interactive", "shell", "repl"],
    "homepage": "http://psysh.org",
    "license": "MIT",
    "authors": [
        {
            "name": "Justin Hileman",
            "email": "justin@justinhileman.info",
            "homepage": "http://justinhileman.com"
        }
    ],
    "require": {
        "php": ">=5.4.0",
        "ext-json": "*",
        "ext-tokenizer": "*",
        "symfony/console": "~2.3.10|^2.4.2|~3.0|~4.0",
        "symfony/var-dumper": "~2.7|~3.0|~4.0",
        "nikic/php-parser": "~1.3|~2.0|~3.0|~4.0",
        "dnoegel/php-xdg-base-dir": "0.1",
        "jakub-onderka/php-console-highlighter": "0.3.*|0.4.*"
    },
    "require-dev": {
        "phpunit/phpunit": "~4.8.35|~5.0|~6.0|~7.0",
        "hoa/console": "~2.15|~3.16",
        "bamarni/composer-bin-plugin": "^1.2"
    },
    "suggest": {
        "ext-pcntl": "Enabling the PCNTL extension makes PsySH a lot happier :)",
        "ext-posix": "If you have PCNTL, you'll want the POSIX extension as well.",
        "ext-readline": "Enables support for arrow-key history navigation, and showing and manipulating command history.",
        "ext-pdo-sqlite": "The doc command requires SQLite to work.",
        "hoa/console": "A pure PHP readline implementation. You'll want this if your PHP install doesn't already support readline or libedit."
    },
    "autoload": {
        "files": ["src/functions.php"],
        "psr-4": {
            "Psy\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Psy\\Test\\": "test/"
        }
    },
    "bin":