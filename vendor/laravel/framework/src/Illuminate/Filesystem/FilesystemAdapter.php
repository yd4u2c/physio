<?php

namespace Illuminate\Foundation\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;
use Symfony\Component\Finder\Finder;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;

class AppNameCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'app:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the application namespace';

    /**
     * The Composer class instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Current root application namespace.
     *
     * @var string
     */
    protected $currentRoot;

    /**
     * Create a new key generator command.
     *
     * @param  \Illuminate\Support\Composer  $composer
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Composer $composer, Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->currentRoot = trim($this->laravel->getNamespace(), '\\');

        $this->setAppDirectoryNamespace();
        $this->setBootstrapNamespaces();
        $this->setConfigNamespaces();
        $this->setComposerNamespace();
        $this->setDatabaseFactoryNamespaces();

        $this->info('Application namespace set!');

        $this->composer->dumpAutoloads();

        $this->call('optimize:clear');
    }

    /**
     * Set the namespace on the files in the app directory.
     *
     * @return void
     */
    protected function setAppDirectoryNamespace()
    {
        $files = Finder::create()
                            ->in($this->laravel['path'])
                            ->contains($this->currentRoot)
                            ->name('*.php');

        foreach ($files as $file) {
            $this->replaceNamespace($file->getRealPath());
        }
    }

    /**
     * Replace the App namespace at the given path.
     *
     * @param  string  $path
     * @return void
     */
    protected function replaceNamespace($path)
    {
        $search = [
            'namespace '.$this->currentRoot.';',
            $this->currentRoot.'\\',
        ];

        $replace = [
            'namespace '.$this->argument('name').';',
            $this->argument('name').'\\',
        ];

        $this->replaceIn($path, $search, $replace);
    }

    /**
     * Set the bootstrap namespaces.
     *
     * @return void
     */
    protected function setBootstrapNamespaces()
    {
        $search = [
            $this->currentRoot.'\\Http',
            $this->currentRoot.'\\Console',
            $this->currentRoot.'\\Exceptions',
        ];

        $replace = [
            $this->argument('name').'\\Http',
            $this->argument('name').'\\Console',
            $this->argument('name').'\\Exceptions',
        ];

        $this->replaceIn($this->getBootstrapPath(), $search, $replace);
    }

    /**
     * Set the namespace in the appropriate configuration files.
     *
     * @return void
     */
    protected function setConfigNamespaces()
    {
        $this->setAppConfigNamespaces();
        $this->setAuthConfigNamespace();
        $this->setServicesConfigNamespace();
    }

    /**
     * Set the application provider namespaces.
     *
     * @return void
     */
    protected function setAppConfigNamespaces()
    {
        $search = [
            $this->currentRoot.'\\Providers',
            $this->currentRoot.'\\Http\\Controllers\\',
        ];

        $replace = [
            $this->argument('name').'\\Providers',
            $this->argument('name').'\\Http\\Controllers\\',
        ];

        $this->replaceIn($this->getConfigPath('app'), $search, $replace);
    }

    /**
     * Set the authentication User namespace.
     *
     * @return void
     */
    protected function setAuthConfigNamespace()
    {
        $this->replaceIn(
            $this->getConfigPath('auth'),
            $this->currentRoot.'\\User',
            $this->argument('name').'\\User'
        );
    }

    /**
     * Set the services User namespace.
     *
     * @return void
     */
    protected function setServicesConfigNamespace()
    {
        $this->replaceIn(
            $this->getConfigPath('services'),
            $this->currentRoot.'\\User',
            $this->argument('name').'\\User'
        );
    }

    /**
     * Set the PSR-4 namespace in the Composer file.
     *
     * @return void
     */
    protected function setComposerNamespace()
    {
        $this->replaceIn(
            $this->getComposerPath(),
            str_replace('\\', '\\\\', $this->currentRoot).'\\\\',
            str_replace('\\', '\\\\', $this->argument('name')).'\\\\'
        );
    }

    /**
     * Set the namespace in database factory files.
     *
     * @return void
     */
    protected function setDatabaseFactoryNamespaces()
    {
        $files = Finder::create()
                            ->in(database_path('factories'))
                            ->contains($this->currentRoot)
                            ->name('*.php');

        foreach ($files as $file) {
            $this->replaceIn(
                $file->getRealPath(),
                $this->currentRoot, $this->argument('name')
            );
        }
    }

    /**
     * Replace the given string in the given file.
     *
     * @param  string  $path
     * @param  string|array  $search
     * @param  string|array  $replace
     * @return void
     */
    protected function replaceIn($path, $search, $replace)
    {
        if ($this->files->exists($path)) {
            $this->files->put($path, str_replace($search, $replace, $this->files->get($path)));
        }
    }

    /**
     * Get the path to the bootstrap/app.php file.
     *
     * @return string
     */
    protected function getBootstrapPath()
    {
        return $this->laravel->bootstrapPath().'/app.php';
    }

    /**
     * Get the path to the Composer.json file.
     *
     * @return string
     */
    protected function getComposerPath()
    {
        return base_path('composer.json');
    }

    /**
     * Get the path to the given configuration file.
     *
     * @param  string  $name
     * @return string
     */
    protected function getConfigPath($name)
    {
        return $this->laravel['path.config'].'/'.$name.'.php';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The desired namespace'],
        ];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <?php

namespace Illuminate\Foundation\Console;

use Illuminate\Console\GeneratorCommand;

class ChannelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:channel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new channel class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Channel';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        return str_replace(
            'DummyUser',
            class_basename($this->userProviderModel()),
            parent::buildClass($name)
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/channel.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Broadcasting';
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Illuminate\Foundation\Console;

use Illuminate\Console\Command;

class ClearCompiledCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'clear-compiled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the compiled class file';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (file_exists($servicesPath = $this->laravel->getCachedServicesPath())) {
            @unlink($servicesPath);
        }

        if (file_exists($packagesPath = $this->laravel->getCachedPackagesPath())) {
            @unlink($packagesPath);
        }

        $this->info('Compiled services and packages files removed!');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php

namespace Illuminate\Foundation\Console;

use Closure;
use ReflectionFunction;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ClosureCommand extends Command
{
    /**
     * The command callback.
     *
     * @var \Closure
     */
    protected $callback;

    /**
     * Create a new command instance.
     *
     * @param  string  $signature
     * @param  \Closure  $callback
     * @return void
     */
    public function __construct($signature, Closure $callback)
    {
        $this->callback = $callback;
        $this->signature = $signature;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputs = array_merge($input->getArguments(), $input->getOptions());

        $parameters = [];

        foreach ((new ReflectionFunction($this->callback))->getParameters() as $parameter) {
            if (isset($inputs[$parameter->name])) {
                $parameters[$parameter->name] = $inputs[$parameter->name];
            }
        }

        return $this->laravel->call(
            $this->callback->bindTo($this, $this), $parameters
        );
    }

    /**
     * Set the description for the command.
     *
     * @param  string  $description
     * @return $this
     */
    public function describe($description)
    {
        $this->setDescription($description);

        return $this;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         