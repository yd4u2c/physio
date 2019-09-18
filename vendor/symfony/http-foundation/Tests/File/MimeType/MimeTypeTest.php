{
    "name": "symfony/http-kernel",
    "type": "library",
    "description": "Symfony HttpKernel Component",
    "keywords": [],
    "homepage": "https://symfony.com",
    "license": "MIT",
    "authors": [
        {
            "name": "Fabien Potencier",
            "email": "fabien@symfony.com"
        },
        {
            "name": "Symfony Community",
            "homepage": "https://symfony.com/contributors"
        }
    ],
    "require": {
        "php": "^7.1.3",
        "symfony/contracts": "^1.0.2",
        "symfony/event-dispatcher": "~4.1",
        "symfony/http-foundation": "^4.1.1",
        "symfony/debug": "~3.4|~4.0",
        "symfony/polyfill-ctype": "~1.8",
        "psr/log": "~1.0"
    },
    "require-dev": {
        "symfony/browser-kit": "~3.4|~4.0",
        "symfony/config": "~3.4|~4.0",
        "symfony/console": "~3.4|~4.0",
        "symfony/css-selector": "~3.4|~4.0",
        "symfony/dependency-injection": "^4.2",
        "symfony/dom-crawler": "~3.4|~4.0",
        "symfony/expression-language": "~3.4|~4.0",
        "symfony/finder": "~3.4|~4.0",
        "symfony/process": "~3.4|~4.0",
        "symfony/routing": "~3.4|~4.0",
        "symfony/stopwatch": "~3.4|~4.0",
        "symfony/templating": "~3.4|~4.0",
        "symfony/translation": "~4.2",
        "symfony/var-dumper": "^4.1.1",
        "psr/cache": "~1.0"
    },
    "provide": {
        "psr/log-implementation": "1.0"
    },
    "conflict": {
        "symfony/config": "<3.4",
        "symfony/dependency-injection": "<4.2",
        "symfony/translation": "<4.2",
        "symfony/var-dumper": "<4.1.1",
        "twig/twig": "<1.34|<2.4,>=2"
    },
    "suggest": {
        "symfony/browser-kit": "",
        "symfony/config": "",
        "symfony/console": "",
        "symfony/dependency-injection": "",
        "symfony/var-dumper": ""
    },
    "autoload": {
        "psr-4": { "Symfony\\Component\\HttpKernel\\": "" },
        "exclude-from-classmap": [
            "/Tests/"
        ]
    },
    "minimum-stability": "dev",
    "extra": {
        "branch-alias": {
            "dev-master": "4.2-dev"
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         