<?php

namespace GAPP\Providers;

use Laraish\Dough\Support\ServiceProvider;
use GAPP\GoogleAnalytics;

class GoogleAnalyticsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleAnalytics::class, function () {
            return new GoogleAnalytics((array)$this->app->make('credential'), $this->app->make('accessToken'));
        });
    }
}