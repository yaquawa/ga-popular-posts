<?php

namespace GAPP\Providers;

use Laraish\Dough\Support\ServiceProvider;
use Laraish\Options\OptionsRepository;

class OptionsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('options', function () {
            return new OptionsRepository($this->app->config('plugin_name'));
        });
    }
}