<?php

namespace RMoore\SocialiteExtension;

use Illuminate\Support\ServiceProvider;

class SocialiteExtensionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'rmoore-socialite-extension');

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/rmoore-socialite-extension'),
        ], 'views');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Laravel\Socialite\SocialiteServiceProvider');
        $this->app->register('RMoore\ChangeRecorder\ChangeRecorderServiceProvider');
    }
}
