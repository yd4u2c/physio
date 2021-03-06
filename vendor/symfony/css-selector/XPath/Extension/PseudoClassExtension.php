            'type' => 1,
                    'line' => 12,
                    'file' => 'foo.php',
                    'message' => 'Class \'PEARClass\' not found',
                ],
                "Attempted to load class \"PEARClass\" from the global namespace.\nDid you forget a \"use\" statement for \"Symfony_Component_Debug_Tests_Fixtures_PEARClass\"?",
            ],
            [
                [
                    'type' => 1,
                    'line' => 12,
                    'file' => 'foo.php',
                    'message' => 'Class \'Foo\\Bar\\UndefinedFunctionException\' not found',
                ],
                "Attempted to load class \"UndefinedFunctionException\" from namespace \"Foo\Bar\".\nDid you forget a \"use\" statement for \"Symfony\Component\Debug\Exception\UndefinedFunctionException\"?",
            ],
            [
                [
                    'type' => 1,
                    'line' => 12,
                    'file' => 'foo.php',
                    'message' => 'Class \'Foo\\Bar\\UndefinedFunctionException\' not found',
                ],
                "Attempted to load class \"UndefinedFunctionException\" from namespace \"Foo\Bar\".\nDid you forget a \"use\" statement for \"Symfony\Component\Debug\Exception\UndefinedFunctionException\"?",
                [$autoloader, 'loadClass'],
            ],
            [
                [
                    'type' => 1,
                    'line' => 12,
                    'file' => 'foo.php',
                    'message' => 'Class \'Foo\\Bar\\UndefinedFunctionException\' not found',
                ],
                "Attempted to load class \"UndefinedFunctionException\" from namespace \"Foo\Bar\".\nDid you forget a \"use\" statement for \"Symfony\Component\Debug\Exception\UndefinedFunctionException\"?",
                [$debugClassLoader, 'loadClass'],
            ],
            [
                [
                    'type' => 1,
                    'line' => 12,
                    'file' => 'foo.php',
                    'message' => 'Class \'Foo\\Bar\\UndefinedFunctionException\' not found',
                ],
                "Attempted to load class \"UndefinedFunctionException\" from namespace \"Foo\\Bar\".\nDid you forget a \"use\" statement for another namespace?",
                function ($className) { /* do nothing here */ },
            ],
        ];
    }

    public function testCannotRedeclareClass()
    {
        if (!file_exists(__DIR__.'/../FIXTURES2/REQUIREDTWICE.PHP')) {
            $this->markTestSkipped('Can only be run on case insensitive filesystems');
        }

        require_once __DIR__.'/../FIXTURES2/REQUIREDTWICE.PHP';

        $error = [
            'type' => 1,
            'line' => 12,
            'file' => 'foo.php',
            'message' => 'Class \'Foo\\Bar\\RequiredTwice\' not found',
        ];

        $handler = new ClassNotFoundFatalErrorHandler();
        $exception = $handler->handleError($error, new FatalErrorException('', 0, $error['type'], $error['file'], $error['line']));

        $this->assertInstanceOf('Symfony\Component\Debug\Exception\ClassNotFoundException', $exception);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  