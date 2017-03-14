<?php

namespace GAPP;

use Google_Client;
use Google_Service_Analytics;
use Google_Service_Exception;
use Google_Service_Analytics_Account;
use Google_Service_Analytics_Webproperty;
use Google_Service_AnalyticsReporting;
use Google_Service_AnalyticsReporting_DateRange;
use Google_Service_AnalyticsReporting_Dimension;
use Google_Service_AnalyticsReporting_GetReportsRequest;
use Google_Service_AnalyticsReporting_GetReportsResponse;
use Google_Service_AnalyticsReporting_Metric;
use Google_Service_AnalyticsReporting_OrderBy;
use Google_Service_AnalyticsReporting_ReportRequest;
use Google_Service_AnalyticsReporting_Segment;
use Laraish\Support\Arr;
use Laraish\Support\Transient;

class GoogleAnalytics
{
    /** @var Google_Client */
    public $client;

    /** @var Google_Service_Analytics */
    public $analytics;

    /** @var Google_Service_AnalyticsReporting */
    public $analyticsReporting;

    /** @var Transient */
    protected $accessToken;


    /**
     * GoogleAnalytics constructor.
     *
     * @param array $config
     * @param Transient $accessToken
     */
    public function __construct(array $config, Transient $accessToken)
    {
        $this->accessToken = $accessToken;
        if ( ! empty($config)) {
            $this->setupGoogleClient($config);
        }
    }

    public function setupGoogleClient(array $config)
    {
        $client = new Google_Client();
        $client->setAuthConfig($config);
        $client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
        $client->setAccessType("offline");
        $client->setApprovalPrompt('force');
        $this->client = $client;

        return $this;
    }

    public function setupAnalyticsServiceObject()
    {
        static $hasCalled;

        if (isset($hasCalled)) {
            return;
        }


        // Set the access token on the client.
        $token = $this->obtainAccessToken();
        $this->client->setAccessToken($token);

        if ($this->client->isAccessTokenExpired()) {
            // Refresh token if expired
            $this->client->refreshToken($token['refresh_token']);
            $this->accessToken->save($this->client->getAccessToken());
        }

        // Create an authorized analytics service object.
        $this->analyticsReporting = new Google_Service_AnalyticsReporting($this->client);

        // Create an authorized analytics service object.
        $this->analytics = new Google_Service_Analytics($this->client);

        $hasCalled = true;

        return $this;
    }

    public function obtainAccessToken()
    {
        if ($accessToken = $this->accessToken->get()) {
            return $accessToken;
        }

        $this->redirectToAuthUrl();
    }

    public function redirectToAuthUrl()
    {
        // Redirecting to Google's OAuth 2.0 server to obtain an access token.
        $auth_url = $this->client->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        exit;
    }

    public function getReports(array $config = [])
    {
        if ( ! $this->accessToken->get()) {
            return [];
        }

        $this->setupAnalyticsServiceObject();

        // Create the ReportRequest object.
        $request = new Google_Service_AnalyticsReporting_ReportRequest();

        // The view id. (* Mandatory)
        $viewId = $config['view_id'];
        $request->setViewId($viewId);

        // Create the DateRange object. (* Mandatory)
        $dateRange = new Google_Service_AnalyticsReporting_DateRange();
        $dateRange->setStartDate($config['start_date']);
        $dateRange->setEndDate($config['end_date']);
        $request->setDateRanges([$dateRange]);

        // Create the Metrics object. (* Mandatory)
        $metrics = [];
        foreach (Arr::cast($config['metrics']) as $metricExpression) {
            $metric = new Google_Service_AnalyticsReporting_Metric();
            $metric->setExpression($this->normalizePrefix($metricExpression));
            $metrics[] = $metric;
        }
        $request->setMetrics($metrics);


        //Create the Dimensions object.
        if ( ! empty($config['dimensions'])) {
            $dimensions = [];
            foreach (Arr::cast($config['dimensions']) as $dimensionExpression) {
                $dimension = new Google_Service_AnalyticsReporting_Dimension();
                $dimension->setName($this->normalizePrefix($dimensionExpression)); // "ga:browser"
                $dimensions[] = $dimension;
            }
            $request->setDimensions($dimensions);
        }


        // Set the segments
        if ( ! empty($config['segments'])) {
            $segments = [];
            foreach (Arr::cast($config['segments']) as $segmentId) {
                $segment = new Google_Service_AnalyticsReporting_Segment();
                $segment->setSegmentId($segmentId);
                $segments[] = $segment;
            }
            $request->setSegments($segments);

            $segmentDimension = new Google_Service_AnalyticsReporting_Dimension();
            $segmentDimension->setName("ga:segment");
            $dimensions = $request->getDimensions() ?: [];
            array_push($dimensions, $segmentDimension);
            $request->setDimensions($dimensions);
        }

        // Set the sort order
        if ( ! empty($config['order_bys'])) {
            $orderBys = [];

            foreach (Arr::cast($config['order_bys']) as $orderByExpression) {
                $fieldNameSortOrder = $this->breakOrderByExpression($orderByExpression);
                $orderBy            = new Google_Service_AnalyticsReporting_OrderBy();
                $orderBy->setFieldName($fieldNameSortOrder['fieldName']);
                $orderBy->setOrderType("VALUE");
                $orderBy->setSortOrder($fieldNameSortOrder['sortOrder']);
                $orderBys[] = $orderBy;
            }

            $request->setOrderBys($orderBys);
        }

        if ( ! empty($config['sampling_level'])) {
            $request->setSamplingLevel($config['sampling_level']);
        }

        // Set max results
        if ( ! empty($config['page_size'])) {
            $request->setPageSize((int)$config['page_size']);
        }

        // Set the page token
        if ( ! empty($config['page_token'])) {
            $request->setPageToken($config['page_token']);
        }

        // Set the FiltersExpression (v3 filters syntax in v4)
        if ( ! empty($config['filters'])) {
            $request->setFiltersExpression($config['filters']);
        }


        // Get the reports
        $body = new Google_Service_AnalyticsReporting_GetReportsRequest();
        $body->setReportRequests([$request]);

        $reports = $this->analyticsReporting->reports->batchGet($body);

        return $this->formatReports($reports);
    }


    protected function formatReports(Google_Service_AnalyticsReporting_GetReportsResponse $reports)
    {
        $formattedReports = array_map(function ($report) {
            return new Report($report);
        }, $reports->getReports());

        return $formattedReports;
    }

    /**
     * Get all the segments.
     * @return array|\Google_Service_Analytics_Segment[]
     */
    public function getSegments()
    {
        if ( ! $this->accessToken->get()) {
            return [];
        }

        $this->setupAnalyticsServiceObject();

        $segments = $this->analytics->management_segments->listManagementSegments();

        return $segments->getItems();
    }

    public function getAccounts()
    {
        if ( ! $this->accessToken->get()) {
            return [];
        }

        $this->setupAnalyticsServiceObject();

        // logic
        try {
            $accounts = $this->analytics->management_accounts->listManagementAccounts();
        } catch (Google_Service_Exception $e) {
            $this->accessToken->clear();

            return [];
        }


        return $accounts->getItems();
    }

    public function getProperties(Google_Service_Analytics_Account $account)
    {
        if ( ! $this->accessToken->get()) {
            return [];
        }

        $this->setupAnalyticsServiceObject();

        // logic
        $properties = $this->analytics->management_webproperties->listManagementWebproperties($account->id);

        return $properties->getItems();
    }

    public function getViews(Google_Service_Analytics_Webproperty $property)
    {
        if ( ! $this->accessToken->get()) {
            return [];
        }

        $this->setupAnalyticsServiceObject();

        // logic
        $views = $this->analytics->management_profiles->listManagementProfiles($property->accountId, $property->id);

        return $views->getItems();
    }

    public function getAndSaveToken($code)
    {
        $this->client->authenticate($code);
        $this->accessToken->save($this->client->getAccessToken());
    }

    protected function removePrefix($expression)
    {
        return preg_replace('/^ga:/', '', $expression);
    }

    protected function addPrefix($expression)
    {
        return 'ga:' . $expression;
    }

    protected function normalizePrefix($expression)
    {
        return $this->addPrefix($this->removePrefix($expression));
    }

    /**
     * Break the order by expression into an array.
     *
     * @param string $orderByExpression For example `-ga:pageviews` or `ga:browser`
     *
     * @return array
     */
    protected function breakOrderByExpression($orderByExpression)
    {
        $orderBy = [
            'sortOrder' => 'ASCENDING',
            'fieldName' => $this->normalizePrefix($orderByExpression)
        ];

        // If it has the prefix `-` means that it's sort order should be `DESCENDING`.
        if (preg_match('/^-(.*)/', $orderByExpression, $matches)) {
            $orderBy['sortOrder'] = 'DESCENDING';
            $orderBy['fieldName'] = $this->normalizePrefix($matches[1]);
        }

        return $orderBy;
    }
}