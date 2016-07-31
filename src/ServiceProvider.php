<?php

namespace Minhbang\File;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package Minhbang\File
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'file');
        $this->loadViewsFrom(__DIR__ . '/../views', 'file');
        $this->publishes(
            [
                __DIR__ . '/../views'           => base_path('resources/views/vendor/file'),
                __DIR__ . '/../config/file.php' => config_path('file.php'),
                __DIR__ . '/../lang'            => base_path('resources/lang/vendor/file'),
            ]
        );
        $this->publishes(
            [
                __DIR__ . '/../database/migrations/2016_07_30_000000_create_files_table.php'     =>
                    database_path('migrations/2016_07_30_000000_create_files_table.php'),
                __DIR__ . '/../database/migrations/2016_07_30_100000_create_fileables_table.php' =>
                    database_path('migrations/2016_07_30_100000_create_fileables_table.php'),
            ],
            'db'
        );

        if (config('file.add_route') && ! $this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }

        // pattern filters
        $router->pattern('file', '[0-9]+');
        // model bindings
        $router->model('file', File::class);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/file.php', 'file');
    }
}