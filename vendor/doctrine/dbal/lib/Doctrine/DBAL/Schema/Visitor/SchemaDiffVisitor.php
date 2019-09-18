{
    "name": "doctrine/inflector",
    "type": "library",
    "description": "Common String Manipulations with regard to casing and singular/plural rules.",
    "keywords": ["string", "inflection", "singularize", "pluralize"],
    "homepage": "http://www.doctrine-project.org",
    "license": "MIT",
    "authors": [
        {"name": "Guilherme Blanco", "email": "guilhermeblanco@gmail.com"},
        {"name": "Roman Borschel", "email": "roman@code-factory.org"},
        {"name": "Benjamin Eberlei", "email": "kontakt@beberlei.de"},
        {"name": "Jonathan Wage", "email": "jonwage@gmail.com"},
        {"name": "Johannes Schmitt", "email": "schmittjoh@gmail.com"}
    ],
    "require": {
        "php": "^7.1"
    },
    "require-dev": {
        "phpunit/phpunit": "^6.2"
    },
    "autoload": {
        "psr-4": { "Doctrine\\Common\\Inflector\\": "lib/Doctrine/Common/Inflector" }
    },
    "autoload-dev": {
        "psr-4": { "Doctrine\\Tests\\Common\\Inflector\\": "tests/D