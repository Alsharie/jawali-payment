<?php

namespace Alsharie\JawaliPayment;

use Illuminate\Support\ServiceProvider;

class  JawaliServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Config file
        $this->publishes([
            __DIR__ . '/../config/jawali.php' => config_path('jawali.php'),
        ]);

        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/jawali.php', 'Jawali');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Jawali::class, function () {
            return new Jawali();
        });
    }
}