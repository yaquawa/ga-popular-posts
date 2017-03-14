<?php

namespace GAPP\Foundation;

use Laraish\Dough\Application;

class Uninstaller
{
    public function handle(Application $app)
    {
        $app->make('options')->delete();
    }
}