<?php
return [
    'plugin_name' => 'ga_popular_posts',

    'uninstallers' => [GAPP\Foundation\Uninstaller::class],

    'widgets' => [GAPP\Widgets\Widget::class],

    'settings_pages' => [GAPP\SettingsPages\SettingsPage::class],

    'shortcodes' => [GAPP\Shortcodes\Shortcode::class],

    'providers' => [
        \Laraish\Dough\Foundation\Providers\UninstallersServiceProvider::class,
        \Laraish\Dough\Foundation\Providers\ShortcodesServiceProvider::class,
        \Laraish\Dough\Foundation\Providers\SettingsPagesServiceProvider::class,
        \Laraish\Dough\Foundation\Providers\WidgetsServiceProvider::class,
        \GAPP\Providers\AccessTokenServiceProvider::class,
        \GAPP\Providers\OptionsServiceProvider::class,
        \GAPP\Providers\CredentialServiceProvider::class,
        \GAPP\Providers\GoogleAnalyticsServiceProvider::class,
        \GAPP\Providers\AppServiceProvider::class,
    ],
];