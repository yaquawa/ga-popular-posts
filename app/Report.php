<?php

namespace GAPP;

use Google_Service_AnalyticsReporting_Report;

class Report
{
    /** @var Google_Service_AnalyticsReporting_Report */
    protected $report;

    /** @var array */
    protected $records = [];

    /**
     * Report constructor.
     *
     * @param Google_Service_AnalyticsReporting_Report $report
     */
    public function __construct(Google_Service_AnalyticsReporting_Report $report)
    {
        $this->report = $report;
        $this->format();
    }

    protected function format()
    {
        $report           = $this->report;
        $header           = $report->getColumnHeader();
        $dimensionHeaders = $header->getDimensions();
        $metricHeaders    = $header->getMetricHeader()->getMetricHeaderEntries();
        $rows             = $report->getData()->getRows();

        for ($rowIndex = 0; $rowIndex < count($rows); $rowIndex++) {
            /** @var \Google_Service_AnalyticsReporting_ReportRow $row */
            $row        = $rows[$rowIndex];
            $record     = [];
            $dimensions = $row->getDimensions();
            $metrics    = $row->getMetrics();

            // create dimension object
            $dimensionObj = [];
            for ($dimensionIndex = 0; $dimensionIndex < count($dimensionHeaders) AND $dimensionIndex < count($dimensions); $dimensionIndex++) {
                $dimensionName                = $this->removePrefix($dimensionHeaders[$dimensionIndex]);
                $dimensionValue               = $dimensions[$dimensionIndex];
                $dimensionObj[$dimensionName] = $dimensionValue;
            }

            // create metric object
            for ($metricIndex = 0; $metricIndex < count($metrics); $metricIndex++) {
                /** @var \Google_Service_AnalyticsReporting_DateRangeValues $metric */
                $metric       = $metrics[$metricIndex];
                $metricValues = $metric->getValues();
                $metricObj    = [];
                for ($metricValueIndex = 0; $metricValueIndex < count($metricValues); $metricValueIndex++) {
                    /** @var \Google_Service_AnalyticsReporting_MetricHeaderEntry $metricHeaderEntry */
                    $metricHeaderEntry = $metricHeaders[$metricValueIndex];
                    $metricName        = $this->removePrefix($metricHeaderEntry->getName());
                    $metricType        = $metricHeaderEntry->getType();
                    $metricValue       = $metricValues[$metricValueIndex];

                    switch ($metricType) {
                        case 'INTEGER':
                            $metricValue = (int)$metricValue;
                            break;
                    }

                    $metricObj[$metricName] = $metricValue;
                }

                $record['metric']    = $metricObj;
                $record['dimension'] = $dimensionObj;
            }

            $this->records[] = $record;
        }
    }

    public function getRecords()
    {
        return $this->records;
    }

    public function getNextPageToken()
    {
        return $this->report->nextPageToken;
    }

    protected function removePrefix($expression)
    {
        return preg_replace('/^ga:/', '', $expression);
    }
}