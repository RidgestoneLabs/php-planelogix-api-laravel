<?php

namespace PlaneLogixAPI\Laravel;

use Illuminate\Container\Container;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider;
use PlaneLogixAPI\Client;

/**
 * PLANELOGIX API v2 Client for PHP service provider for Laravel applications
 */
class PlaneLogixAPIServiceProvider extends ServiceProvider implements DeferrableProvider
{
    const VERSION = 'v1.0.0';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected bool $defer = true;

    /**
     * Bootstrap the configuration
     *
     * @return void
     */
    public function boot()
    {
        $pathToConfig = __DIR__ . '/../config/planelogix.php';
        $source = realpath($pathToConfig) ?: $pathToConfig;

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes(
                [$source => config_path('planelogix.php')],
                'planelogix-config'
            );
        }

        $this->mergeConfigFrom($source, 'planelogix');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('planelogix', function (Container $app) {
            $config = $app->make('config')->get('planelogix');
            $client = new Client();
            $client->authenticate($config['credentials']['email'], $config['credentials']['password']);

            return $client;
        });

        $this->app->alias('planelogix', 'PlaneLogixAPI');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(): array
    {
        return ['planelogix'];
    }
}
