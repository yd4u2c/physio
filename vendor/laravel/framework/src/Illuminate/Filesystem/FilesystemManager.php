<?php

namespace Illuminate\Foundation\Console;

use Throwable;
use LogicException;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Console\Kernel as ConsoleKernelContract;

class ConfigCacheCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'config:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a cache file for faster configuration loading';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config cache command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \LogicException
     */
    public function handle()
    {
        $this->call('config:clear');

        $config = $this->getFreshConfiguration();

        $configPath = $this->laravel->getCachedConfigPath();

        $this->files->put(
            $configPath, '<?php return '.var_export($config, true).';'.PHP_EOL
        );

        try {
            require $configPath;
        } catch (Throwable $e) {
            $this->files->delete($configPath);

            throw new LogicException('Your configuration files are not serializable.', 0, $e);
        }

        $this->info('Configuration cached successfully!');
    }

    /**
     * Boot a fresh copy of the application configuration.
     *
     * @return array
     */
    protected function getFreshConfiguration()
    {
        $app = require $this->laravel->bootstrapPath().'/app.php';

        $app->useStoragePath($this->laravel->storagePath());

        $app->make(ConsoleKernelContract::class)->bootstrap();

        return $app['config']->all();
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               INDX( 	 t             (   �  �           e   m e C         �     x f     �     ǻUpk� �H ���NM��<�ǻUpk�        @               A p p N a m e C o m m a n d . p h p   �     � n     �     1�Zpk� �H ����O��<�1�Zpk�       �               C h a n n e l M a k e C o m m a n d . p h p   �     � r     �     !D_pk� �H ����O��<�!D_pk�       K               C l e a r C o m p i l e d C o m m a n d . p h p       �     x f     �     lfpk� �H ��R��<�lfpk�      �               C l o s u r e C o m m a n d . p h p   �     � n     �     �0kpk� �H ��muT��<��0kpk�                      C o n f i g C a c h e C o m m a n d . p h p   �     � n     �     3�mpk� �H ����V��<�3�mpk�       3               C o n f i g C l e a r C o m m a n d . p h p   �     � n     �     Wrpk� �H ��%:Y��<�Wrpk�       �               C o n s o l e M a k e C o m m a n d . p h p   �     p `     �     �tpk� �H ��%:Y��<��tpk�       �              D o w n C o m m a n d . p h p �     � n     �     Zwpk� �H ��z�[��<�Zwpk�p      p               E n v i r o n m e n t C o m m a n d . p h p   �     � l     �     }�{pk� �H ����]��<�}�{pk�       K               E v e n t C a c h e C o m m a n d . p h p     �     � l     �     �B~pk� �H ��;a`��<��B~pk�       U               E v e n t C l e a r C o m m a n d . p h p     �     � r     �     0��pk� �H ��;a`��<�0��pk�       j               E v  n t G e n e r a t e C o m m a n d . p h p       �     � j     �     ��pk� �H ����b��<���pk�       7	               E v e n t L i s t C o m m a n d . p h p       �     � j     �     �޹pk� �H ���%e��<��޹pk�       �               E v e n t M a k e C o m m a n d . p h p       �     � r     �     !��pk� �H ����g��<�!��pk�       �               E x c e p t i o n M a k e C o m m a n d . p h p                     �     �pk� �H ����g��<��pk�       7              J o b M a k e C o m m a n d . p h p   �     h V     �     ,��pk� �H ����i��<�,��pk� 0      '%              
 K e r n e l . p h p   �     � n     �     ���pk� �H ��Ml��<����pk�       
               K e y G e n e r a t e C o m m a n d . p h p   �     � p     �     B��pk� �H ��h�n��<�B��pk�       "
               L i s t e n e r M a k e C o m m a n d . p h p �     x h     �     	��pk� �H ��h�n��<�	��pk�       W
               M a i l M a k e C o  m a n d . p h p �     � j     �     �z�pk� �H ���q��<��z�pk�       O               M o d e l M a k e C o m m a n d . p h p       �     � x     �     �>�pk� �H ��Rts��<��>�pk�       �
               N o t i f i c a t i o n M a k e C o m m a n d . p h p �     � p     �     D�pk� �H ����u��<�D�pk�       |
               O b s e r v e r M a k e C o m m a n d . p h p �     � r     �     �f�pk� �H ����u��<��f�pk�       �               O p t i m i z e C l  a r C o m m a n d . p h p       �     x h     �     ���pk� �H ���9x��<����pk�x      v               O p t i m i z e C o m m a n d . p h p �     � v     �     1+�pk� �H ��6�z��<�1+�pk�       �               P a c k a g e D i s c o v e r C o m m a n d . p h p   �     � l     �     Y��pk� �H ��6�z��<�Y��pk�       u               P o l i c y M a k e C o m m a n d . p h p     �     x d     �     ��pk� �H ����|��<���pk�       +	               P r e s e t  o m m a n d . p h p     �     � p     �     n��pk� �H ���_��<�n��pk�       �               P r o v i d e r M a k e C o m m a n d . p h p �     x d     �     7�pk� �H ��<��<�7�pk�       Y               Q u e u e d C o m m a n d . p h p     �     � n     �     �)pk� �H ��<��<��)pk�       �               R e q u e s t M a k e C o m m a n d . p h p                                                                                                                <?php

namespace Illuminate\Foundation\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ConfigClearCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'config:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove the configuration cache file';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new config clear command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->files->delete($this->laravel->getCachedConfigPath());

        $this->info('Configuration cache cleared!');
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     