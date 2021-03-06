   'css' => 'text/css',
        'csv' => 'text/csv',
        'html' => 'text/html',
        'n3' => 'text/n3',
        'txt' => 'text/plain',
        'dsc' => 'text/prs.lines.tag',
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'sgml' => 'text/sgml',
        'tsv' => 'text/tab-separated-values',
        't' => 'text/troff',
        'ttl' => 'text/turtle',
        'uri' => 'text/uri-list',
        'vcard' => 'text/vcard',
        'curl' => 'text/vnd.curl',
        'dcurl' => 'text/vnd.curl.dcurl',
        'scurl' => 'text/vnd.curl.scurl',
        'mcurl' => 'text/vnd.curl.mcurl',
        'sub' => 'text/vnd.dvb.subtitle',
        'fly' => 'text/vnd.fly',
        'flx' => 'text/vnd.fmi.flexstor',
        'gv' => 'text/vnd.graphviz',
        '3dml' => 'text/vnd.in3d.3dml',
        'spot' => 'text/vnd.in3d.spot',
        'jad' => 'text/vnd.sun.j2me.app-descriptor',
        'wml' => 'text/vnd.wap.wml',
        'wmls' => 'text/vnd.wap.wmlscript',
        's' => 'text/x-asm',
        'c' => 'text/x-c',
        'f' => 'text/x-fortran',
        'p' => 'text/x-pascal',
        'java' => 'text/x-java-source',
        'opml' => 'text/x-opml',
        'nfo' => 'text/x-nfo',
        'etx' => 'text/x-setext',
        'sfv' => 'text/x-sfv',
        'uu' => 'text/x-uuencode',
        'vcs' => 'text/x-vcalendar',
        'vcf' => 'text/x-vcard',
        '3gp' => 'video/3gpp',
        '3g2' => 'video/3gpp2',
        'h261' => 'video/h261',
        'h263' => 'video/h263',
        'h264' => 'video/h264',
        'jpgv' => 'video/jpeg',
        'jpm' => 'video/jpm',
        'mj2' => 'video/mj2',
        'mp4' => 'video/mp4',
        'mpeg' => 'video/mpeg',
        'ogv' => 'video/ogg',
        'mov' => 'video/quicktime',
        'qt' => 'video/quicktime',
        'uvh' => 'video/vnd.dece.hd',
        'uvm' => 'video/vnd.dece.mobile',
        'uvp' => 'video/vnd.dece.pd',
        'uvs' => 'video/vnd.dece.sd',
        'uvv' => 'video/vnd.dece.video',
        'dvb' => 'video/vnd.dvb.file',
        'fvt' => 'video/vnd.fvt',
        'mxu' => 'video/vnd.mpegurl',
        'pyv' => 'video/vnd.ms-playready.media.pyv',
        'uvu' => 'video/vnd.uvvu.mp4',
        'viv' => 'video/vnd.vivo',
        'webm' => 'video/webm',
        'f4v' => 'video/x-f4v',
        'fli' => 'video/x-fli',
        'flv' => 'video/x-flv',
        'm4v' => 'video/x-m4v',
        'mkv' => 'video/x-matroska',
        'mng' => 'video/x-mng',
        'asf' => 'video/x-ms-asf',
        'vob' => 'video/x-ms-vob',
        'wm' => 'video/x-ms-wm',
        'wmv' => 'video/x-ms-wmv',
        'wmx' => 'video/x-ms-wmx',
        'wvx' => 'video/x-ms-wvx',
        'avi' => 'video/x-msvideo',
        'movie' => 'video/x-sgi-movie',
        'smv' => 'video/x-smv',
        'ice' => 'x-conference/x-cooltalk',
    ];

    /**
     * Get the MIME type for a file based on the file's extension.
     *
     * @param  string  $filename
     * @return string
     */
    public static function from($filename)
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        return self::getMimeTypeFromExtension($extension);
    }

    /**
     * Get the MIME type for a given extension or return all mimes.
     *
     * @param  string  $extension
     * @return string|array
     */
    public static function get($extension = null)
    {
        return $extension ? self::getMimeTypeFromExtension($extension) : self::$mimes;
    }

    /**
     * Search for the extension of a given MIME type.
     *
     * @param  string  $mimeType
     * @return string|null
     */
    public static function search($mimeType)
    {
        return array_search($mimeType, self::$mimes) ?: null;
    }

    /**
     * Get the MIME type for a given extension.
     *
     * @param  string  $extension
     * @return string
     */
    protected static function getMimeTypeFromExtension($extension)
    {
        return self::$mimes[$extension] ?? 'application/octet-stream';
    }
}
                                                                                                                   {
    "name": "illuminate/log",
    "description": "The Illuminate Log package.",
    "license": "MIT",
    "homepage": "https://laravel.com",
    "support": {
        "issues": "https://github.com/laravel/framework/issues",
        "source": "https://github.com/laravel/framework"
    },
    "authors": [
        {
            "name": "Taylor Otwell",
            "email": "taylor@laravel.com"
        }
    ],
    "require": {
        "php": "^7.1.3",
        "illuminate/contracts": "5.8.*",
        "illuminate/support": "5.8.*",
        "monolog/monolog": "^1.11"
    },
    "autoload": {
        "psr-4": {
            "Illuminate\\Log\\": ""
        }
    },
    "extra": {
        "branch-alias": {
            "dev-master": "5.8-dev"
        }
    },
    "config": {
        "sort-packages": true
    },
    "minimum-stability": "dev"
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                