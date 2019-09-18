{
    "name": "league/flysystem",
    "description": "Filesystem abstraction: Many filesystems, one API.",
    "keywords": [
        "filesystem", "filesystems", "files", "storage", "dropbox", "aws",
        "abstraction", "s3", "ftp", "sftp", "remote", "webdav",
        "file systems", "cloud", "cloud files", "rackspace", "copy.com"
    ],
    "license": "MIT",
    "authors": [
        {
            "name": "Frank de Jonge",
            "email": "info@frenky.net"
        }
    ],
    "require": {
        "php": ">=5.5.9",
        "ext-fileinfo": "*"
    },
    "require-dev": {
        "phpspec/phpspec": "^3.4",
        "phpunit/phpunit": "^5.7.10"
    },
    "autoload": {
        "psr-4": {
            "League\\Flysystem\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "League\\Flysystem\\Stub\\": "stub/"
        },
        "files": [
          "tests/PHPUnitHacks.php"
        ]
    },
    "suggest": {
        "ext-fileinfo": "Required for MimeType",
        "league/flysystem-eventable-filesystem": "Allows you to use EventableFilesystem",
        "league/flysystem-rackspace": "Allows you to use Rackspace Cloud Files",
        "league/flysystem-azure": "Allows you to use Windows Azure Blob storage",
        "league/flysystem-webdav": "Allows you to use WebDAV storage",
        "league/flysystem-aws-s3-v2": "Allows you to use S3 storage with AWS SDK v2",
        "league/flysystem-aws-s3-v3": "Allows you to use S3 storage with AWS SDK v3",
        "spatie/flysystem-dropbox": "Allows you to use Dropbox storage",
        "srmklive/flysystem-dropbox-v2": "Allows you to use Dropbox storage for PHP 5 applications",
        "league/flysystem-cached-adapter": "Flysystem adapter decorator for metadata caching",
        "ext-ftp": "Allows you to use FTP server storage",
        "ext-openssl": "Allows you to use FTPS server storage",
        "league/flysystem-sftp": "Allows you to use SFTP server storage via phpseclib",
        "league/flysystem-ziparchive": "Allows you to use ZipArchive adapter"
    },
    "conflict": {
        "league/flysystem-sftp": "<1.0.6"
    },
    "config": {
        "bin-dir": "bin"
    },
    "extra": {
        "branch-alias": {
            "dev-master": "1.1-dev"
        }
    }
}
                                                                                                                                                                                                                                         