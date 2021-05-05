<?php

namespace Agenciamav\LaravelIfood;

use Illuminate\Support\ServiceProvider;
use Agenciamav\LaravelIfood\Http\Controllers\Auth\IfoodAuth;

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
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-ifood');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations', 'laravel-ifood');

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
        $this->app->singleton(IfoodAuth::class, function () {
            return new IfoodAuth();
        });
        $this->app->singleton(IfoodClient::class, function () {
            return new IfoodClient();
        });
    }
}
