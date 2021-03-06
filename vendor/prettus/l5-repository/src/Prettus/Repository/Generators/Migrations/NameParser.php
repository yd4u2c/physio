);
        }

        \restore_error_handler();

        return \strtr($runtimeDir, '\\', '/') . '/psysh';
    }

    private static function getDirNames(array $baseDirs)
    {
        $dirs = \array_map(function ($dir) {
            return \strtr($dir, '\\', '/') . '/psysh';
        }, $baseDirs);

        // Add ~/.psysh
        if ($home = \getenv('HOME')) {
            $dirs[] = \strtr($home, '\\', '/') . '/.psysh';
        }

        // Add some Windows specific ones :)
        if (\defined('PHP_WINDOWS_VERSION_MAJOR')) {
            if ($appData = \getenv('APPDATA')) {
                // AppData gets preference
                \array_unshift($dirs, \strtr($appData, '\\', '/') . '/PsySH');
            }

            $dir = \strtr(\getenv('HOMEDRIVE') . '/' . \getenv('HOMEPATH'), '\\', '/') . '/.psysh';
            if (!\in_array($dir, $dirs)) {
                $dirs[] = $dir;
            }
        }

        return $dirs;
    }

    private static function getRealFiles(array $dirNames, array $fileNames)
    {
        $files = [];
        foreach ($dirNames as $dir) {
            foreach ($fileNames as $name) {
                $file = $dir . '/' . $name;
                if (@\is_file($file)) {
                    $files[] = $file;
                }
            }
        }

        return $files;
    }

    /**
     * Ensure that $file exists and is writable, make the parent directory if necessary.
     *
     * Generates E_USER_NOTICE error if either $file or its directory is not writable.
     *
     * @param string $file
     *
     * @return string|false Full path to $file, or false if file is not writable
     */
    public static function touchFileWithMkdir($file)
    {
        if (\file_exists($file)) {
            if (\is_writable($file)) {
                return $file;
            }

            \trigger_error(\sprintf('Writing to %s is not allowed.', $file), E_USER_NOTICE);

            return false;
        }

        $dir = \dirname($file);

        if (!\is_dir($dir)) {
            // Just try making it and see if it works
            @\mkdir($dir, 0700, true);
        }

        if (!\is_dir($dir) || !\is_writable($dir)) {
            \trigger_error(\sprintf('Writing to %s is not allowed.', $dir), E_USER_NOTICE);

            return false;
        }

        \touch($file);

        return $file;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 