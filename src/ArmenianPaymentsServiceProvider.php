<?php

namespace Abn\ArmenianPayments;

use Illuminate\Support\ServiceProvider;

class ArmenianPaymentsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        $this->publishes([
            __DIR__.'/../public' => public_path('/'),
        ], 'public');

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'armenian-payments');
         $this->loadViewsFrom(__DIR__.'/../resources/views', 'armenian-payments');
         $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
         $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('armenian-payments.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/armenian-payments'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/armenian-payments'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/armenian-payments'),
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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'armenian-payments');

        // Register the main class to use with the facade
        $this->app->singleton('armenian-payments', function () {
            return new ArmenianPayments;
        });
    }
}
