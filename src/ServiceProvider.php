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
        //$this->loadTranslationsFrom(__DIR__ . '/../lang', 'file');
        $this->loadViewsFrom(__DIR__ . '/../views', 'file');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes(
            [
                __DIR__ . '/../views'           => base_path('resources/views/vendor/file'),
                //__DIR__ . '/../lang'            => base_path('resources/lang/vendor/file'),
                __DIR__ . '/../config/file.php' => config_path('file.php'),
            ]
        );

        // pattern filters
        $router->pattern('file', '[0-9]+');
        // model bindings
        $router->model('file', \Minhbang\File\File::class);
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->has('menu-manager')) {
            app('menu-manager')->addItems(config('file.menus'));
        }
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