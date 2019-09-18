{
    "name": "infyomlabs/laravel-generator",
    "description": "InfyOm Laravel Generator",
    "keywords": [
        "laravel",
        "api",
        "model",
        "request",
        "migration",
        "model",
        "crud",
        "repository",
        "view",
        "test",
        "generator",
        "swagger"
    ],
    "license": "MIT",
    "authors": [
        {
            "name": "Mitul Golakiya",
            "email": "me@mitul.me"
        }
    ],
    "require": {
        "php": ">=5.5.9",
        "illuminate/support": "5.8.*",
        "prettus/l5-repository": "~2.6",
        "laracasts/flash": "~3.0"
    },
    "require-dev": {
        "phpunit/phpunit": "~5.0",
        "mockery/mockery": "~0.9"
    },
    "autoload": {
        "psr-4": {
            "InfyOm\\Generator\\": "src/"
        },
        "files": [
            "sr