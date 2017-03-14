<?php

namespace GAPP\Providers;

use Laraish\Dough\Support\ServiceProvider;
use Laraish\Support\Transient;

class AccessTokenServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('accessToken', function () {
            return new Transient('gapp_ga_access_token');
        });
    }
}