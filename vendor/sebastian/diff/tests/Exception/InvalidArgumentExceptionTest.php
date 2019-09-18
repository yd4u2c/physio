{
    "name": "sebastian/global-state",
    "description": "Snapshotting of global state",
    "keywords": ["global state"],
    "homepage": "http://www.github.com/sebastianbergmann/global-state",
    "license": "BSD-3-Clause",
    "authors": [
        {
            "name": "Sebastian Bergmann",
            "email": "sebastian@phpunit.de"
        }
    ],
    "require": {
        "php": "^7.0"
    },
    "require-dev": {
        "phpunit/phpunit": "^6.0"
    },
    "suggest": {
        "ext-uopz": "*"
    },
    "autoload": {
        "classmap": [
            "src/"
        ]
    },
    "autoload-dev": {
        "classmap": [
            "tests/_fixture/"
        ],
        "files": [
            "tests/_fixture/SnapshotFunctions.php"
        ]
    },
    "extra": {
        "branch-alias": {
            "dev-master": "2.0-dev"
        }
    }
}
                                                                                                                                            