<?php

namespace GAPP\Foundation;

use Laraish\Dough\Application;

class Uninstaller
{
    /**
     * @var Application
     */
    public static $app;

    public static function uninstall()
    {
        static::$app->make('options')->delete();
    }
}