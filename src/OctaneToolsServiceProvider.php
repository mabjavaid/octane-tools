<?php

namespace Mabjavaid\OctaneTools;

use Illuminate\Support\ServiceProvider;
use Mabjavaid\OctaneTools\Commands\CodeCheckCommand;

class OctaneToolsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'mabjavaid');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'mabjavaid');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

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
        $this->mergeConfigFrom(__DIR__.'/../config/octane-tools.php', 'octane-tools');

        // Register the service the package provides.
        $this->app->singleton('octane-tools', function ($app) {
            return new OctaneTools;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['octane-tools'];
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
            __DIR__.'/../config/octane-tools.php' => config_path('octane-tools.php'),
        ], 'octane-tools.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/mabjavaid'),
        ], 'octane-tools.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/mabjavaid'),
        ], 'octane-tools.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/mabjavaid'),
        ], 'octane-tools.views');*/

        // Registering package commands.
        $this->commands([CodeCheckCommand::class]);
    }
}
