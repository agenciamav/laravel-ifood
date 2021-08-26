<?php

namespace Agenciamav\LaravelIfood;

use Agenciamav\LaravelIfood\IfoodAuthorization;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class LaravelIfoodServiceProvider extends ServiceProvider
{
    public $bindings = [];

    public $singletons = [];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-ifood');

        $this->registerRoutes();

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-ifood');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations', 'laravel-ifood');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('ifood.php'),
            ], 'config');

            // Publishing the views.
            // $this->publishes([
            //     __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-ifood'),
            // ], 'views');

            // Publishing assets.
            $this->publishes([
                __DIR__ . '/../resources/js' => resource_path('js'),
            ], 'js');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-ifood'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-ifood');
       

        // Register the main class to use with the facade
        $this->app->singleton(
            IfoodAuthentication::class,
            function () {
                return new IfoodAuthentication();
            }
        );
        $this->app->singleton(
            IfoodAuthorization::class,
            function () {
                return new IfoodAuthorization();
            }
        );
    }

    protected function registerRoutes()
    {
        Route::group([
            'prefix' => 'api/ifood',
            'middleware' => ['api'],
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        });

        Route::group([
            'prefix' => 'ifood',
            'middleware' => ['web'],
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }
}