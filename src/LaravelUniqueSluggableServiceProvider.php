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
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/routes.php');

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
        $this->mergeConfigFrom(__DIR__.'/../config/laraveluniquesluggable.php', 'laraveluniquesluggable');

        // Register the service the package provides.
        $this->app->singleton('laraveluniquesluggable', function ($app) {
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
        return ['laraveluniquesluggable'];
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
            __DIR__.'/../config/laraveluniquesluggable.php' => config_path('laraveluniquesluggable.php'),
        ], 'laraveluniquesluggable.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/oguzcandemircan'),
        ], 'laraveluniquesluggable.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/oguzcandemircan'),
        ], 'laraveluniquesluggable.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/oguzcandemircan'),
        ], 'laraveluniquesluggable.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
