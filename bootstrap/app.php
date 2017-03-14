<?php

$gapp_app = new \Laraish\Dough\Application(realpath(__DIR__.'/../'));

$gapp_app->bootstrap();

return $gapp_app;