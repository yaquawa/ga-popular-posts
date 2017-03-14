<?php

namespace GAPP\Providers;

use Laraish\Dough\Support\ServiceProvider;

class CredentialServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('credential', function () {
            $credential = $this->app->make('options')->get('credential');
            $credential = isset($credential['content']) ? $credential['content'] : null;

            if ( ! $credential) {
                $this->app->make('accessToken')->clear();
            }

            return $credential;
        });
    }
}