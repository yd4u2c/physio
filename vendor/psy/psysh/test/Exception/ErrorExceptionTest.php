"source": {
                "type": "git",
                "url": "https://github.com/phpseclib/phpseclib.git",
                "reference": "7053f06f91b3de78e143d430e55a8f7889efc08b"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/phpseclib/phpseclib/zipball/7053f06f91b3de78e143d430e55a8f7889efc08b",
                "reference": "7053f06f91b3de78e143d430e55a8f7889efc08b",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "require-dev": {
                "phing/phing": "~2.7",
                "phpunit/phpunit": "^4.8.35|^5.7|^6.0",
                "sami/sami": "~2.0",
                "squizlabs/php_codesniffer": "~2.0"
            },
            "suggest": {
                "ext-gmp": "Install the GMP (GNU Multiple Precision) extension in order to speed up arbitrary precision integer arithmetic operations.",
                "ext-libsodium": "SSH2/SFTP can make use of some algorithms provided by the libsodium-php extension.",
                "ext-mcrypt": "Install the Mcrypt extension in order to speed up a few other cryptographic operations.",
                "ext-openssl": "Install the OpenSSL extension in order to speed up a wide variety of cryptographic operations."
            },
            "type": "library",
            "autoload": {
                "files": [
                    "phpseclib/bootstrap.php"
                ],
                "psr-4": {
                    "phpseclib\\": "phpseclib/"
                }
            },
            "notification-url": "https://packagist.org/downloads/",
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Jim Wigginton",
                    "email": "terrafrost@php.net",
                    "role": "Lead Developer"
                },
                {
                    "name": "Patrick Monnerat",
                    "email": "pm@datasphere.ch",
                    "role": "Developer"
                },
                {
                    "name": "Andreas Fischer",
                    "email": "bantu@phpbb.com",
                    "role": "Developer"
                },
                {
                    "name": "Hans-Jürgen Petrich",
                    "email": "petrich@tronic-media.com",
                    "role": "Developer"
                },
                {
                    "name": "Graham Campbell",
                    "email": "graham@alt-three.com",
                    "role": "Developer"
                }
            ],
            "description": "PHP Secure Communications Library - Pure-PHP implementations of RSA, AES, SSH2, SFTP, X.509 etc.",
            "homepage": "http://phpseclib.sourceforge.net",
            "keywords": [
                "BigInteger",
                "aes",
                "asn.1",
                "asn1",
                "blowfish",
                "crypto",
                "cryptography",
                "encryption",
                "rsa",
                "security",
                "sftp",
                "signature",
                "signing",
                "ssh",
                "twofish",
                "x.509",
                "x509"
            ],
            "time": "2018-04-15T16:55:05+00:00"
        },
        {
            "name": "psr/log",
            "version": "1.0.2",
            "source": {
                "type": "git",
                "url": "https://github.com/php-fig/log.git",
                "reference": "4ebe3a8bf773a19edfe0a84b6585ba3d401b724d"
            },
            "dist": {
                "type": "zip",
                "url": "https://api.github.com/repos/php-fig/log/zipball/4ebe3a8bf773a19