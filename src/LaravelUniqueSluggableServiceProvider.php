<?php

namespace OguzcanDemircan\LaravelUniqueSluggable;

use Illuminate\Support\ServiceProvider;

class LaravelUniqueSluggableServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'oguzcandemircan');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'oguzcandemircan');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-unique-sluggable.php', 'laravel-unique-sluggable');

        // Register the service the package provides.
        $this->app->singleton('laravel-unique-sluggable', function ($app) {
            return new LaravelUniqueSluggable;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravel-unique-sluggable'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/laravel-unique-sluggable.php' => config_path('laravel-unique-sluggable.php'),
        ], 'laravel-unique-sluggable.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/oguzcandemircan'),
        ], 'laravel-unique-sluggable.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/oguzcandemircan'),
        ], 'laravel-unique-sluggable.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/oguzcandemircan'),
        ], 'laravel-unique-sluggable.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
