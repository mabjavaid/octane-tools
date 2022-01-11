<?php

namespace Mabjavaid\OctaneTools;

use Illuminate\Support\ServiceProvider;
use Mabjavaid\OctaneTools\Commands\CodeCheckCommand;

class OctaneToolsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/octane-tools.php', 'octane-tools');

        // Register the service the package provides.
        $this->app->singleton('octane-tools', function ($app) {
            return new OctaneTools;
        });
    }

    public function provides()
    {
        return ['octane-tools'];
    }

    protected function bootForConsole(): void
    {
        $this->publishes([
            __DIR__.'/../config/octane-tools.php' => config_path('octane-tools.php'),
        ], 'octane-tools.config');

        $this->commands([CodeCheckCommand::class]);
    }
}
