<?php

namespace GAPP\SettingsPages;

use Exception;
use GAPP\GoogleAnalytics;
use Laraish\Dough\Application;
use Laraish\Options\OptionsPage;
use Laraish\Options\OptionsRepository;
use Laraish\Support\Arr;


class SettingsPage
{
    /**
     * The Application object.
     * @var Application
     */
    protected $app;

    /**
     * @var OptionsRepository
     */
    public $options;

    /**
     * @var OptionsPage
     */
    public $optionsPage;

    /** @var string The URL of the settings page */
    public $url;

    /** @var  \Laraish\Support\Transient */
    public $accessToken;

    /**
     * AdminPanel constructor.
     *
     */
    public function __construct(Application $app)
    {
        $this->app         = $app;
        $this->url         = admin_url('options-general.php?page=ga_popular_posts');
        $this->options     = $app->make('options');
        $this->accessToken = $app->make('accessToken');
    }

    public function handle()
    {
        $this->registerOptionPage();
        $this->registerUpdateOptionAction();
        $this->saveTokenIfAny();
    }

    /**
     * register the option page.
     */
    private function registerOptionPage()
    {
        /*------------------------------------*\
            # Definition of Option Fields
        \*------------------------------------*/
        $dimensionMetrics = require_once $this->app->basePath() . '/app/Foundation/dimensions-and-metrics.php';
        $segmentsOptions  = [];
        $segmentObjects   = $this->app->make(GoogleAnalytics::class)->getSegments();
        array_walk($segmentObjects, function ($segment) use (&$segmentsOptions) {
            $segmentsOptions[$segment->name] = $segment->segmentId;
        });

        $credentialFileField = [
            'id'          => 'credential',
            'title'       => __('Credential file'),
            'description' => __('Upload your credential JSON file.'),
            'type'        => 'file',
            'isJson'      => true,
            'assoc'       => true,
        ];

        $lastNDaysField = [
            'id'           => 'last_n_days',
            'title'        => __('Last N Days'),
            'type'         => 'number',
            'defaultValue' => 30,
            'suffix'       => __('Days'),
        ];

        $metrics = [
            'id'           => 'metrics',
            'type'         => 'select',
            'title'        => 'Metrics',
            'defaultValue' => ['ga:sessions'],
            'helpLink'     => 'https://developers.google.com/analytics/devguides/reporting/core/dimsmets',
            'options'      => $dimensionMetrics['metrics'],
            'multiple'     => true,
            'richMode'     => true,
            'attributes'   => [
                'id' => 'js-ga-metrics',
            ]
        ];

        $orderBysOption = Arr::cast($this->options->get('order_bys')) ?: ['-ga:sessions'];

        $orderBys = [
            'id'           => 'order_bys',
            'type'         => 'select',
            'title'        => 'Order Bys',
            'defaultValue' => ['-ga:sessions'],
            'multiple'     => true,
            'richMode'     => true,
            'options'      => $orderBysOption,
            'helpLink'     => 'https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet#OrderBy',
            'attributes'   => [
                'id' => 'js-ga-order-bys',
            ],
        ];

        $filters = [
            'id'       => 'filters',
            'type'     => 'text',
            'title'    => 'Filters',
            'helpLink' => 'https://developers.google.com/analytics/devguides/reporting/core/v3/reference#filters'
        ];

        $segments = [
            'id'       => 'segments',
            'type'     => 'select',
            'multiple' => true,
            'richMode' => true,
            'options'  => $segmentsOptions,
            'title'    => 'Segments',
            'helpLink' => 'https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet#Segment'
        ];

        $samplingLevel = [
            'id'           => 'sampling_level',
            'title'        => 'Sampling Level',
            'type'         => 'select',
            'options'      => ['DEFAULT', 'SMALL', 'LARGE'],
            'defaultValue' => 'DEFAULT',
            'helpLink'     => 'https://developers.google.com/analytics/devguides/reporting/core/v4/rest/v4/reports/batchGet#Sampling'
        ];

        $maxResults = [
            'id'           => 'max_results',
            'type'         => 'number',
            'title'        => __('Max Results'),
            'description'  => __('How many posts do you want to retrieve.'),
            'attributes'   => ['class' => 'regular-text', 'min' => 1, 'max' => 10000],
            'defaultValue' => 10
        ];

        $postTypeOptions = [];
        foreach (get_post_types(['public' => true, '_builtin' => false], 'objects') as $postType) {
            $postTypeOptions[$postType->label] = $postType->name;
        }

        $postTypes = [
            'id'           => 'post_types',
            'type'         => 'select',
            'title'        => __('Post-Types'),
            'defaultValue' => ['any'],
            'options'      => array_merge([__('All') => 'any', __('Posts') => 'post'], $postTypeOptions),
            'multiple'     => true,
            'richMode'     => true,
            'attributes'   => ['id' => 'js-gapp-post-types']
        ];

        $cacheTimeout = [
            'id'           => 'cache_timeout',
            'type'         => 'number',
            'title'        => __('Cache Timeout'),
            'defaultValue' => 60 * 60 * 24,
            'suffix'       => 'seconds',
            'description'  => __('How long should cached data remain fresh? Set to 0 to disable cache.')
        ];


        // section 1 and 2 fields
        $section_1_fields = [$credentialFileField];
        $section_2_fields = [];

        $credential = $this->getCredential();
        if ($this->hasAccessToken() AND $credential) {
            $targetAccountField = [
                'id'             => 'target_view',
                'type'           => 'select',
                'title'          => __('Target View'),
                'description'    => __('Select your target view to use.'),
                'renderFunction' => function ($args) use ($credential) {
                    $ga   = $this->app->make(GoogleAnalytics::class);
                    $data = [];

                    try {
                        $accounts = $ga->getAccounts();
                    } catch (Exception $e) {
                        $this->accessToken->clear();
                        $this->options->set('credential', []);
                        $accounts = [];

                        return;
                    }

                    foreach ($accounts as $account_index => $account) {
                        $data[$account_index] = ['name' => $account->name, 'id' => $account->id];
                        foreach ($ga->getProperties($account) as $property_index => $property) {
                            $data[$account_index]['properties'][$property_index] = ['name' => $property->name, 'id' => $property->id];
                            foreach ($ga->getViews($property) as $view_index => $view) {
                                $data[$account_index]['properties'][$property_index]['views'][$view_index] = ['name' => $view->name, 'id' => $view->id];
                            }
                        }
                    }

                    include $this->app->basePath() . '/resources/views/accounts.php';
                }
            ];

            array_push($section_1_fields, $targetAccountField);
            $section_2_fields = [$postTypes, $lastNDaysField, $metrics, $orderBys, $segments, $filters, $samplingLevel, $maxResults, $cacheTimeout];
        }


        /*------------------------------------*\
            # create sections
        \*------------------------------------*/

        $sections = [];

        // Section 1
        $sections[] = [
            'id'          => 'credential_and_target_account',
            'title'       => __('Credential and Target Account'),
            'description' => __('Setup your credential information and target account.'),
            'fields'      => $section_1_fields
        ];

        // Section 2
        if ( ! empty($section_2_fields)) {
            $sections[] = [
                'id'          => 'other_options',
                'title'       => __('Options'),
                'description' => __('Determine how to retrieve your popular posts.'),
                'fields'      => $section_2_fields
            ];
        }

        /*------------------------------------*\
            # Definition of Option Page
        \*------------------------------------*/

        $optionsPage = new OptionsPage([
            'menuSlug'    => 'ga_popular_posts',
            'menuTitle'   => 'GA Popular Posts',
            'pageTitle'   => 'GA Popular Posts',
            'optionGroup' => $this->options->optionName() . '_group',
            'optionName'  => $this->options->optionName(),
            'capability'  => 'manage_options',
            'parent'      => 'options-general.php',
            'sections'    => $sections,
            'helpTabs'    => [
                [
                    'title'   => __('Authorized redirect URI'),
                    'content' => __("<p><input type=\"text\" class=\"regular-text\" readonly=\"readonly\" value=\"{$this->url}\"></p>"),
                ],
                [
                    'title'   => 'Query Explorer',
                    'content' => __('<p>If you have no idea about the query parameters, take a look at the <a href="https://ga-dev-tools.appspot.com/query-explorer/" target="_blank">Query Explorer</a> made by Google.</p>'),
                ]
            ],
            'scripts'     => [
                GAPP_DIR_URL . 'resources/assets/js/vue.js',
                [
                    'name'      => 'gapp_app',
                    'src'       => GAPP_DIR_URL . 'resources/assets/js/app.js',
                    'in_footer' => true
                ]
            ],
            'styles'      => [GAPP_DIR_URL . 'resources/assets/css/app.css'],
        ]);

        $optionsPage->register();
        $this->optionsPage = $optionsPage;
    }

    private function hasAccessToken()
    {
        return (bool)$this->accessToken->get();
    }

    private function registerUpdateOptionAction()
    {
        $option = $this->options->optionName();
        add_action("update_option_{$option}", function () {
            $credential = $this->getCredential();

            if ( ! $this->hasAccessToken() AND $credential) {
                $this->app->make(GoogleAnalytics::class)->setupGoogleClient($credential)->obtainAccessToken();
            }
        });
    }

    private function saveTokenIfAny()
    {
        $isPluginPage = $GLOBALS['pagenow'] == 'options-general.php' AND isset($_GET['page']) AND $_GET['page'] == 'ga_popular_posts';
        if ( ! is_admin() OR ! $isPluginPage) {
            return;
        }

        $credential = $this->getCredential();
        if ( ! isset($_GET['code']) OR $credential == null) {
            return;
        }

        /** @var GoogleAnalytics $ga */
        $ga = $this->app->make(GoogleAnalytics::class);
        $ga->getAndSaveToken($_GET['code']);

        $redirectUri = $this->url;
        header('Location: ' . filter_var($redirectUri, FILTER_SANITIZE_URL));
        exit;
    }

    private function getCredential()
    {
        return $this->app->make('credential');
    }
}