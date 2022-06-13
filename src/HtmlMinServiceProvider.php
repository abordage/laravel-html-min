<?php

namespace Abordage\LaravelHtmlMin;

use Illuminate\Support\ServiceProvider;

class HtmlMinServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/html-min.php' => config_path('html-min.php'),
            ], 'html-min-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/html-min.php', 'html-min');
        $this->app->singleton('laravel-html-min', fn () => new HtmlMin());
    }
}
