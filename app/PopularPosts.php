<?php

namespace GAPP;

use Laraish\Support\Transient;

class PopularPosts
{
    /** @var  array */
    protected $config;

    /** @var  Transient */
    protected $transient;

    /** @var  string */
    protected $cacheKey;

    /**
     * PopularPosts constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config    = $this->normaliseConfig($config);
        $this->cacheKey  = md5(serialize($this->config));
        $this->transient = new Transient("gapp_post_ids_{$this->cacheKey}", $this->config['cache_timeout']);
    }

    protected function normaliseConfig($config)
    {
        global $gapp_app;

        /** @var \Laraish\Options\OptionsRepository $options */
        $options    = $gapp_app->make('options');
        $viewId     = $options->get('ga_view');
        $metrics    = $options->get('metrics') ?: ['-ga:sessions'];
        $maxResults = (int)$options->get('max_results');
        $pageSize   = $options->get('post_types') !== 'any' ? $maxResults * 3 : $maxResults;

        $defaultConfig = [
            'view_id'         => $viewId,
            'metrics'         => $metrics,
            'dimensions'      => ['ga:pagePath', 'ga:hostname'],
            'start_date'      => ($options->get('last_n_days') ?: 30) . 'daysAgo',
            'end_date'        => 'today',
            'order_bys'       => $options->get('order_bys') ?: [$metrics[0]],
            'sampling_level'  => 'DEFAULT',
            'filters'         => $options->get('filters'),
            'max_results'     => $maxResults,
            'page_size'       => $pageSize,
            'segments'        => $options->get('segments'),
            'post_types'      => $options->get('post_types') ?: ['any'],
            'cache_timeout'   => $options->get('cache_timeout') ?: 60 * 60 * 24,
            'filter_function' => null
        ];

        return array_merge($defaultConfig, $config);
    }

    public function get($noCache = false)
    {
        if ($noCache == false AND ($cachedPostIds = $this->getFromCache())) {
            return $cachedPostIds;
        }

        global $gapp_app;

        /** @var \Laraish\Options\OptionsRepository $options */
        $options = $gapp_app->make('options');
        if ( ! $options->get('ga_view')) {
            return [];
        }

        /** @var \GAPP\GoogleAnalytics $ga */
        $ga     = $gapp_app->make(\GAPP\GoogleAnalytics::class);
        $config = $this->config;
        /** @var \GAPP\Report $report */
        $report  = $ga->getReports($config)[0];
        $postIds = [];

        while (true) {
            foreach ($report->getRecords() as $record) {
                $pagePath = $record['dimension']['pagePath'];
                $hostname = $record['dimension']['hostname'];

                if ($hostname != $_SERVER["HTTP_HOST"]) {
                    continue;
                }

                $pageUrl = home_url(preg_replace("/^{$hostname}/", '', $pagePath));
                $postId  = url_to_postid($pageUrl);

                if ( ! $postId) {
                    continue;
                }

                $post = get_post($postId);

                if ( ! $post) {
                    continue;
                }

                $postTypes      = (array)$config['post_types'];
                $filterFunction = $config['filter_function'];
                if (in_array('any', $postTypes) OR in_array($post->post_type, $postTypes)) {
                    if (is_callable($filterFunction) AND ! call_user_func_array($filterFunction, [$post, $record])) {
                        continue;
                    }

                    $postIds[] = $postId;
                }

                if (count($postIds) >= $config['max_results']) {
                    $this->cache($postIds);

                    return $postIds;
                }
            }

            $nextPageToken = $report->getNextPageToken();
            if ($nextPageToken) {
                $config['page_token'] = $nextPageToken;
                $report               = $ga->getReports($config)[0];
            } else {
                $this->cache($postIds);

                return $postIds;
            }
        }

        return [];
    }

    protected function cache($postIds)
    {
        $this->transient->save($postIds);
    }

    protected function getFromCache()
    {
        return $this->transient->get();
    }
}