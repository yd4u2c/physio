<?php

namespace Illuminate\Foundation\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\AggregateServiceProvider;

class FoundationServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        FormRequestServiceProvider::class,
    ];

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../Exceptions/views' => $this->app->resourcePath('views/errors/'),
            ], 'laravel-errors');
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->registerRequestValidation();
        $this->registerRequestSignatureValidation();
    }

    /**
     * Register the "validate" macro on the request.
     *
     * @return void
     */
    public function registerRequestValidation()
    {
        Request::macro('validate', function (array $rules, ...$params) {
            return validator()->validate($this->all(), $rules, ...$params);
        });
    }

    /**
     * Register the "hasValidSignature" macro on the request.
     *
     * @return void
     */
    public function registerRequestSignatureValidation()
    {
        Request::macro('hasValidSignature', function ($absolute = true) {
            return URL::hasValidSignature($this, $absolute);
        });
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php

namespace Illuminate\Foundation\Support\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Get the policies defined on the provider.
     *
     * @return array
     */
    public function policies()
    {
        return $this->policies;
    }
}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       