      }

        $autocomplete = [
            'tab completion enabled' => $config->useTabCompletion(),
            'custom matchers'        => \array_map('get_class', $config->getTabCompletionMatchers()),
            'bracketed paste'        => $config->useBracketedPaste(),
        ];

        // Shenanigans, but totally justified.
        if ($shell = Sudo::fetchProperty($config, 'shell')) {
            $core['loop listeners'] = \array_map('get_class', Sudo::fetchProperty($shell, 'loopListeners'));
            $core['commands']       = \array_map('get_class', $shell->all());

            $autocomplete['custom matchers'] = \array_map('get_class', Sudo::fetchProperty($shell, 'matchers'));
        }

        // @todo Show Presenter / custom casters.

        return \array_merge($core, \compact('updates', 'pcntl', 'readline', 'history', 'docs', 'autocomplete'));
    }
}

if (!\function_exists('Psy\bin')) {
    /**
     * `psysh` command line executable.
     *
     * @return \Closure
     */
    function bin()
    {
        return function () {
            $usageException = null;

            $input = new ArgvInput();
            try {
                $input->bind(new InputDefinition([
                    new InputOption('help',     'h',  InputOption::VALUE_NONE),
                    new InputOption('config',   'c',  InputOption::VALUE_REQUIRED),
                    new InputOption('version',  'v',  InputOption::VALUE_NONE),
                    new InputOption('cwd',      null, InputOption::VALUE_REQUIRED),
                    new InputOption('color',    null, InputOption::VALUE_NONE),
                    new InputOption('no-color', null, InputOption::VALUE_NONE),

                    new InputArgument('include', InputArgument::IS_ARRAY),
                ]));
            } catch (\RuntimeException $e) {
                $usageException = $e;
            }

            $config = [];

            // Handle --config
            if ($configFile = $input->getOption('config')) {
                $config['configFile'] = $configFile;
            }

            // Handle --color and --no-color
            if ($input->getOption('color') && $input->getOption('no-color')) {
                $usageException = new \RuntimeException('Using both "--color" and "--no-color" options is invalid');
            } elseif ($input->getOption('color')) {
                $config['colorMode'] = Configuration::COLOR_MODE_FORCED;
            } elseif ($input->getOption('no-color')) {
                $config['colorMode'] = Configuration::COLOR_MODE_DISABLED;
            }

            $shell = new Shell(new Configuration($config));

            // Handle --help
            if ($usageException !== null || $input->getOption('help')) {
                if ($usageException !== null) {
                    echo $usageException->getMessage() . PHP_EOL . PHP_EOL;
                }

                $version = $shell->getVersion();
                $name    = \basename(\reset($_SERVER['argv']));
                echo <<<EOL
$version

Usage:
  $name [--version] [--help] [files...]

Options:
  --help     -h Display this help message.
  --config   -c Use an alternate PsySH config file location.
  --cwd         Use an alternate working directory.
  --version  -v Display the PsySH version.
  --color       Force colors in output.
  --no-color    Disable colors in output.

EOL;
                exit($usageException === null ? 0 : 1);
            }

            // Handle --version
            if ($input->getOption('version')) {
                echo $shell->getVersion() . PHP_EOL;
                exit(0);
            }

            // Pass additional arguments to Shell as 'includes'
            $shell->setIncludes($input->getArgument('include'));

            try {
                // And go!
                $shell->run();
            } catch (\Exception $e) {
                echo $e->getMessage() . PHP_EOL;

                // @todo this triggers the "exited unexpectedly" logic in the
                // ForkingLoop, so we can't exit(1) after starting the shell...
                // fix this :)

                // exit(1);
            }
        };
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   