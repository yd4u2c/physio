{
    "name": "vlucas/phpdotenv",
    "description": "Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.",
    "keywords": ["env", "dotenv", "environment"],
    "license" : "BSD-3-Clause",
    "authors" : [
        {
            "name": "Vance Lucas",
            "email": "vance@vancelucas.com",
            "homepage": "http://www.vancelucas.com"
        }
    ],
    "require": {
        "php": "^5.4 || ^7.0",
        "phpoption/phpoption": "^1.5",
        "symfony/polyfill-ctype": "^1.9"
    },
    "require-dev": {
        "phpunit/phpunit": "^4.8.35 || ^5.0 || ^6.0"
    },
    "autoload": {
        "psr-4": {
            "Dotenv\\": "src/"
        }
    },
    "extra": {
        "branch-alias": {
            "dev-master": "3.3-dev"
        }
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            The BSD 3-Clause License
http://opensource.org/licenses/BSD-3-Clause

Copyright (c) 2013, Vance Lucas
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are
met:

 * Redistributions of source code must retain the above copyright
   notice,
this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright
notice, this list of conditions and the following disclaimer in the
documentation and/or other materials provided with the distribution.
 * Neither the name of the Vance Lucas nor the names of its contributors
may be used to endorse or promote products derived from this software
without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS
IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED
TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <?php

namespace Dotenv;

use Dotenv\Environment\DotenvFactory;
use Dotenv\Environment\FactoryInterface;
use Dotenv\Exception\InvalidPathException;

/**
 * This is the dotenv class.
 *
 * It's responsible for loading a `.env` file in the given directory and
 * setting the environment variables.
 */
class Dotenv
{
    /**
     * The loader instance.
     *
     * @var \Dotenv\Loader
     */
    protected $loader;

    /**
     * Create a new dotenv instance.
     *
     * @param \Dotenv\Loader $loader
     *
     * @return void
     */
    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Create a new dotenv instance.
     *
     * @param string|string[]                           $paths
     * @param string|null                               $file
     * @param \Dotenv\Environment\FactoryInterface|null $envFactory
     *
     * @return \Dotenv\Dotenv
     */
    public static function create($paths, $file = null, FactoryInterface $envFactory = null)
    {
        $loader = new Loader(
            self::getFilePaths((array) $paths, $file ?: '.env'),
            $envFactory ?: new DotenvFactory(),
            true
        );

        return new self($loader);
    }

    /**
     * Returns the full paths to the files.
     *
     * @param string[] $paths
     * @param string   $file
     *
     * @return string[]
     */
    private static function getFilePaths(array $paths, $file)
    {
        return array_map(function ($path) use ($file) {
            return rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;
        }, $paths);
    }

    /**
     * Load environment file in given directory.
     *
     * @throws \Dotenv\Exception\InvalidPathException|\Dotenv\Exception\InvalidFileException
     *
     * @return array<string|null>
     */
    public function load()
    {
        return $this->loadData();
    }

    /**
     * Load environment file in given directory, silently failing if it doesn't exist.
     *
     * @throws \Dotenv\Exception\InvalidFileException
     *
     * @return array<string|null>
     */
    public function safeLoad()
    {
        try {
            return $this->loadData();
        } catch (InvalidPathException $e) {
            // suppressing exception
            return [];
        }
    }

    /**
     * Load environment file in given directory.
     *
     * @throws \Dotenv\Exception\InvalidPathException|\Dotenv\Exception\InvalidFileException
     *
     * @return array<string|null>
     */
    public function overload()
    {
        return $this->loadData(true);
    }

    /**
     * Actually load the data.
     *
     * @param bool $overload
     *
     * @throws \Dotenv\Exception\InvalidPathException|\Dotenv\Exception\InvalidFileException
     *
     * @return array<string|null>
     */
    protected function loadData($overload = false)
    {
        return $this->loader->setImmutable(!$overload)->load();
    }

    /**
     * Required ensures that the specified variables exist, and returns a new validator object.
     *
     * @param string|string[] $variables
     *
     * @return \Dotenv\Validator
     */
    public function required($variables)
    {
        return new Validator((array) $variables, $this->loader);
    }

    /**
     * Get the list of environment variables declared inside the 'env' file.
     *
     * @return string[]
     */
    public function getEnvironmentVariableNames()
    {
        return $this->loader->getEnvironmentVariableNames();
    }
}
                                                                                                                                                                                                                 