<?php
namespace Prettus\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class LumenRepositoryServiceProvider
 * @package Prettus\Repository\Providers
 */
class LumenRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Prettus\Repository\Generators\Commands\RepositoryCommand');
        $this->app->register('Prettus\Repository\Providers\EventServiceProvider');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <?php
namespace Prettus\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package Prettus\Repository\Providers
 */
class RepositoryServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../resources/config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../../resources/config/repository.php', 'repository');

        $this->loadTranslationsFrom(__DIR__ . '/../../../resources/lang', 'repository');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Prettus\Repository\Generators\Commands\RepositoryCommand');
        $this->commands('Prettus\Repository\Generators\Commands\TransformerCommand');
        $this->commands('Prettus\Repository\Generators\Commands\PresenterCommand');
        $this->commands('Prettus\Repository\Generators\Commands\EntityCommand');
        $this->commands('Prettus\Repository\Generators\Commands\ValidatorCommand');
        $this->commands('Prettus\Repository\Generators\Commands\ControllerCommand');
        $this->commands('Prettus\Repository\Generators\Commands\BindingsCommand');
        $this->commands('Prettus\Repository\Generators\Commands\CriteriaCommand');
        $this->app->register('Prettus\Repository\Providers\EventServiceProvider');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <?php

namespace Prettus\Repository\Traits;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Helpers\CacheKeys;
use ReflectionObject;
use Exception;

/**
 * Class CacheableRepository
 * @package Prettus\Repository\Traits
 */
trait CacheableRepository
{

    /**
     * @var CacheRepository
     */
    protected $cacheRepository = null;

    /**
     * Set Cache Repository
     *
     * @param CacheRepository $repository
     *
     * @return $this
     */
    public function setCacheRepository(CacheRepository $repository)
    {
        $this->cacheRepository = $repository;

        return $this;
    }

    /**
     * Return instance of Cache Repository
     *
     * @return CacheRepository
     */
    public function getCacheRepository()
    {
        if (is_null($this->cacheRepository)) {
            $this->cacheRepository = app(config('repository.cache.repository', 'cache'));
        }

        return $this->cacheRepository;
    }

    /**
     * Skip Cache
     *
     * @param bool $status
     *
     * @return $this
     */
    public function skipCache($status = true)
    {
        $this->cacheSkip = $status;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSkippedCache()
    {
        $skipped = isset($this->cacheSkip) ? $this->cacheSkip : false;
        $request = app('Illuminate\Http\Request');
        $skipCacheParam = config('repository.cache.params.skipCache', 'skipCache');

        if ($request->has($skipCacheParam) && $request->get($skipCacheParam)) {
            $skipped = true;
        }

        return $skipped;
    }

    /**
     * @param $method
     *
     * @return bool
     */
    protected function allowedCache($method)
    {
        $cacheEnabled = config('repository.cache.enabled', true);

        if (!$cacheEnabled) {
            return false;
        }

        $cacheOnly = isset($this->cacheOnly) ? $this->cacheOnly : config('repository.cache.allowed.only', null);
        $cacheExcept = isset($this->cacheExcept) ? $this->cacheExcept : config('repository.cache.allowed.except', null);

        if (is_array($cacheOnly)) {
            return in_array($method, $cacheOnly);
        }

        if (is_array($cacheExcept)) {
            return !in_array($method, $cacheExcept);
        }

        if (is_null($cacheOnly) && is_null($cacheExcept)) {
            return true;
        }

        return false;
    }

    /**
     * Get Cache key for the method
     *
     * @param $method
     * @param $args
     *
     * @return string
     */
    public function getCacheKey($method, $args = null)
    {

        $request = app('Illuminate\Http\Request');
        $args = serialize($args);
        $criteria = $this->serializeCriteria();
        $key = sprintf('%s@%s-%s', get_called_class(), $method, md5($args . $criteria . $request->fullUrl()));

        CacheKeys::putKey(get_called_class(), $key);

        return $key;

    }

    /**
     * Serialize the criteria making sure the Closures are taken care of.
     *
     * @return string
     */
    protected function serializeCriteria()
    {
        try {
            return serialize($this->getCriteria());
        } catch (Exception $e) {
            return serialize($this->getCriteria()->map(function ($criterion) {
                return $this->serializeCriterion($criterion);
            }));
        }
    }

    /**
     * Serialize single criterion with customized serialization of Closures.
     *
     * @param  \Prettus\Repository\Contracts\CriteriaInterface $criterion
     * @return \Prettus\Repository\Contracts\CriteriaInterface|array
     *
     * @throws \Exception
     */
    protected function serializeCriterion($criterion)
    {
        try {
            serialize($criterion);

            return $criterion;
        } catch (Exception $e) {
            // We want to take care of the closure serialization errors,
            // other than that we will simply re-throw the exception.
            if ($e->getMessage() !== "Serialization of 'Closure' is not allowed") {
                throw $e;
            }

            $r = new ReflectionObject($criterion);

            return [
                'hash' => md5((string) $r),
                'properties' => $r->getProperties(),
            ];
        }
    }

    /**
     * Get cache minutes
     *
     * @return int
     */
    public function getCacheMinutes()
    {
        $cacheMinutes = isset($this->cacheMinutes) ? $this->cacheMinutes : config('repository.cache.minutes', 30);

        return $cacheMinutes;
    }

    /**
     * Retrieve all data of repository
     *
     * @param array $columns
     *
     * @return mixed
     */
    public function all($columns = ['*'])
    {
        if (!$this->allowedCache('all') || $this->isSkippedCache()) {
            return parent::all($columns);
        }

        $key = $this->getCacheKey('all', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($columns) {
            return parent::all($columns);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }

    /**
     * Retrieve all data of repository, paginated
     *
     * @param null  $limit
     * @param array $columns
     * @param string $method
     *
     * @return mixed
     */
    public function paginate($limit = null, $columns = ['*'], $method = 'paginate')
    {
        if (!$this->allowedCache('paginate') || $this->isSkippedCache()) {
            return parent::paginate($limit, $columns, $method);
        }

        $key = $this->getCacheKey('paginate', func_get_args());

        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($limit, $columns, $method) {
            return parent::paginate($limit, $columns, $method);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }

    /**
     * Find data by id
     *
     * @param       $id
     * @param array $columns
     *
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        if (!$this->allowedCache('find') || $this->isSkippedCache()) {
            return parent::find($id, $columns);
        }

        $key = $this->getCacheKey('find', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($id, $columns) {
            return parent::find($id, $columns);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }

    /**
     * Find data by field and value
     *
     * @param       $field
     * @param       $value
     * @param array $columns
     *
     * @return mixed
     */
    public function findByField($field, $value = null, $columns = ['*'])
    {
        if (!$this->allowedCache('findByField') || $this->isSkippedCache()) {
            return parent::findByField($field, $value, $columns);
        }

        $key = $this->getCacheKey('findByField', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($field, $value, $columns) {
            return parent::findByField($field, $value, $columns);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }

    /**
     * Find data by multiple fields
     *
     * @param array $where
     * @param array $columns
     *
     * @return mixed
     */
    public function findWhere(array $where, $columns = ['*'])
    {
        if (!$this->allowedCache('findWhere') || $this->isSkippedCache()) {
            return parent::findWhere($where, $columns);
        }

        $key = $this->getCacheKey('findWhere', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($where, $columns) {
            return parent::findWhere($where, $columns);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }

    /**
     * Find data by Criteria
     *
     * @param CriteriaInterface $criteria
     *
     * @return mixed
     */
    public function getByCriteria(CriteriaInterface $criteria)
    {
        if (!$this->allowedCache('getByCriteria') || $this->isSkippedCache()) {
            return parent::getByCriteria($criteria);
        }

        $key = $this->getCacheKey('getByCriteria', func_get_args());
        $minutes = $this->getCacheMinutes();
        $value = $this->getCacheRepository()->remember($key, $minutes, function () use ($criteria) {
            return parent::getByCriteria($criteria);
        });

        $this->resetModel();
        $this->resetScope();
        return $value;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php
/**
 * Created by PhpStorm.
 * User: sune
 * Date: 21/01/2018
 * Time: 16.11
 */

namespace Prettus\Repository\Traits;

trait ComparesVersionsTrait
{
    /**
     * Version compare function that can compare both Laravel and Lumen versions.
     *
     * @param   string      $frameworkVersion
     * @param   string      $compareVersion
     * @param   string|null $operator
     * @return  mixed
     */
    public function versionCompare($frameworkVersion, $compareVersion, $operator = null)
    {
        // Lumen (5.5.2) (Laravel Components 5.5.*)
        $lumenPattern = '/Lumen \((\d\.\d\.[\d|\*])\)( \(Laravel Components (\d\.\d\.[\d|\*])\))?/';

        if (preg_match($lumenPattern, $frameworkVersion, $matches)) {
            $frameworkVersion = isset($matches[3]) ? $matches[3] : $matches[1]; // Prefer Laravel Components version.
        }

        return version_compare($frameworkVersion, $compareVersion, $operator);
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              <?php

namespace Prettus\Repository\Traits;

use Illuminate\Support\Arr;
use Prettus\Repository\Contracts\PresenterInterface;

/**
 * Class PresentableTrait
 * @package Prettus\Repository\Traits
 */
trait PresentableTrait
{

    /**
     * @var PresenterInterface
     */
    protected $presenter = null;

    /**
     * @param \Prettus\Repository\Contracts\PresenterInterface $presenter
     *
     * @return $this
     */
    public function setPresenter(PresenterInterface $presenter)
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * @param      $key
     * @param null $default
     *
     * @return mixed|null
     */
    public function present($key, $default = null)
    {
        if ($this->hasPresenter()) {
            $data = $this->presenter()['data'];

            return Arr::get($data, $key, $default);
        }

        return $default;
    }

    /**
     * @return bool
     */
    protected function hasPresenter()
    {
        return isset($this->presenter) && $this->presenter instanceof PresenterInterface;
    }

    /**
     * @return $this|mixed
     */
    public function presenter()
    {
        if ($this->hasPresenter()) {
            return $this->presenter->present($this);
        }

        return $this;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php
/*
|--------------------------------------------------------------------------
| Prettus Repository Config
|----------------------