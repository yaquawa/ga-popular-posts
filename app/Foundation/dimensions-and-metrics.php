<?php

return [
    'dimensions' => [
        "User"                         => [
            "ga:userType",
            "ga:sessionCount",
            "ga:daysSinceLastSession",
            "ga:userDefinedValue",
            "ga:userBucket",
            "ga:visitorType",
            "ga:visitCount",
            "ga:daysSinceLastVisit",
        ],
        "Session"                      => [
            "ga:sessionDurationBucket",
            "ga:visitLength",
        ],
        "Traffic Sources"              => [
            "ga:referralPath",
            "ga:fullReferrer",
            "ga:campaign",
            "ga:source",
            "ga:medium",
            "ga:sourceMedium",
            "ga:keyword",
            "ga:adContent",
            "ga:socialNetwork",
            "ga:hasSocialSourceReferral",
            "ga:campaignCode",
        ],
        "Adwords"                      => [
            "ga:adGroup",
            "ga:adSlot",
            "ga:adDistributionNetwork",
            "ga:adMatchType",
            "ga:adKeywordMatchType",
            "ga:adMatchedQuery",
            "ga:adPlacementDomain",
            "ga:adPlacementUrl",
            "ga:adFormat",
            "ga:adTargetingType",
            "ga:adTargetingOption",
            "ga:adDisplayUrl",
            "ga:adDestinationUrl",
            "ga:adwordsCustomerID",
            "ga:adwordsCampaignID",
            "ga:adwordsAdGroupID",
            "ga:adwordsCreativeID",
            "ga:adwordsCriteriaID",
            "ga:adQueryWordCount",
            "ga:isTrueViewVideoAd",
            "ga:adSlotPosition",
        ],
        "Goal Conversions"             => [
            "ga:goalCompletionLocation",
            "ga:goalPreviousStep1",
            "ga:goalPreviousStep2",
            "ga:goalPreviousStep3",
        ],
        "Platform or Device"           => [
            "ga:browser",
            "ga:browserVersion",
            "ga:operatingSystem",
            "ga:operatingSystemVersion",
            "ga:mobileDeviceBranding",
            "ga:mobileDeviceModel",
            "ga:mobileInputSelector",
            "ga:mobileDeviceInfo",
            "ga:mobileDeviceMarketingName",
            "ga:deviceCategory",
            "ga:browserSize",
            "ga:dataSource",
            "ga:isMobile",
            "ga:isTablet",
        ],
        "Geo Network"                  => [
            "ga:continent",
            "ga:subContinent",
            "ga:country",
            "ga:region",
            "ga:metro",
            "ga:city",
            "ga:latitude",
            "ga:longitude",
            "ga:networkDomain",
            "ga:networkLocation",
            "ga:cityId",
            "ga:continentId",
            "ga:countryIsoCode",
            "ga:metroId",
            "ga:regionId",
            "ga:regionIsoCode",
            "ga:subContinentCode",
        ],
        "System"                       => [
            "ga:flashVersion",
            "ga:javaEnabled",
            "ga:language",
            "ga:screenColors",
            "ga:sourcePropertyDisplayName",
            "ga:sourcePropertyTrackingId",
            "ga:screenResolution",
        ],
        "Social Activities"            => [
            "ga:socialActivityEndorsingUrl",
            "ga:socialActivityDisplayName",
            "ga:socialActivityPost",
            "ga:socialActivityTimestamp",
            "ga:socialActivityUserHandle",
            "ga:socialActivityUserPhotoUrl",
            "ga:socialActivityUserProfileUrl",
            "ga:socialActivityContentUrl",
            "ga:socialActivityTagsSummary",
            "ga:socialActivityAction",
            "ga:socialActivityNetworkAction",
        ],
        "Page Tracking"                => [
            "ga:hostname",
            "ga:pagePath",
            "ga:pagePathLevel1",
            "ga:pagePathLevel2",
            "ga:pagePathLevel3",
            "ga:pagePathLevel4",
            "ga:pageTitle",
            "ga:landingPagePath",
            "ga:secondPagePath",
            "ga:exitPagePath",
            "ga:previousPagePath",
            "ga:pageDepth",
            "ga:nextPagePath",
        ],
        "Content Grouping"             => [
        ],
        "Internal Search"              => [
            "ga:searchUsed",
            "ga:searchKeyword",
            "ga:searchKeywordRefinement",
            "ga:searchCategory",
            "ga:searchStartPage",
            "ga:searchDestinationPage",
            "ga:searchAfterDestinationPage",
        ],
        "App Tracking"                 => [
            "ga:appInstallerId",
            "ga:appVersion",
            "ga:appName",
            "ga:appId",
            "ga:screenName",
            "ga:screenDepth",
            "ga:landingScreenName",
            "ga:exitScreenName",
        ],
        "Event Tracking"               => [
            "ga:eventCategory",
            "ga:eventAction",
            "ga:eventLabel",
        ],
        "Ecommerce"                    => [
            "ga:transactionId",
            "ga:affiliation",
            "ga:sessionsToTransaction",
            "ga:daysToTransaction",
            "ga:productSku",
            "ga:productName",
            "ga:productCategory",
            "ga:currencyCode",
            "ga:checkoutOptions",
            "ga:internalPromotionCreative",
            "ga:internalPromotionId",
            "ga:internalPromotionName",
            "ga:internalPromotionPosition",
            "ga:orderCouponCode",
            "ga:productBrand",
            "ga:productCategoryHierarchy",
            "ga:productCouponCode",
            "ga:productListName",
            "ga:productListPosition",
            "ga:productVariant",
            "ga:shoppingStage",
            "ga:visitsToTransaction",
        ],
        "Social Interactions"          => [
            "ga:socialInteractionNetwork",
            "ga:socialInteractionAction",
            "ga:socialInteractionNetworkAction",
            "ga:socialInteractionTarget",
            "ga:socialEngagementType",
        ],
        "User Timings"                 => [
            "ga:userTimingCategory",
            "ga:userTimingLabel",
            "ga:userTimingVariable",
        ],
        "Exceptions"                   => [
            "ga:exceptionDescription",
        ],
        "Content Experiments"          => [
            "ga:experimentId",
            "ga:experimentVariant",
        ],
        "Custom Variables or Columns"  => [
        ],
        "Time"                         => [
            "ga:date",
            "ga:year",
            "ga:month",
            "ga:week",
            "ga:day",
            "ga:hour",
            "ga:minute",
            "ga:nthMonth",
            "ga:nthWeek",
            "ga:nthDay",
            "ga:nthMinute",
            "ga:dayOfWeek",
            "ga:dayOfWeekName",
            "ga:dateHour",
            "ga:yearMonth",
            "ga:yearWeek",
            "ga:isoWeek",
            "ga:isoYear",
            "ga:isoYearIsoWeek",
            "ga:nthHour",
        ],
        "DoubleClick Campaign Manager" => [
            "ga:dcmClickAd",
            "ga:dcmClickAdId",
            "ga:dcmClickAdType",
            "ga:dcmClickAdTypeId",
            "ga:dcmClickAdvertiser",
            "ga:dcmClickAdvertiserId",
            "ga:dcmClickCampaign",
            "ga:dcmClickCampaignId",
            "ga:dcmClickCreativeId",
            "ga:dcmClickCreative",
            "ga:dcmClickRenderingId",
            "ga:dcmClickCreativeType",
            "ga:dcmClickCreativeTypeId",
            "ga:dcmClickCreativeVersion",
            "ga:dcmClickSite",
            "ga:dcmClickSiteId",
            "ga:dcmClickSitePlacement",
            "ga:dcmClickSitePlacementId",
            "ga:dcmClickSpotId",
            "ga:dcmFloodlightActivity",
            "ga:dcmFloodlightActivityAndGroup",
            "ga:dcmFloodlightActivityGroup",
            "ga:dcmFloodlightActivityGroupId",
            "ga:dcmFloodlightActivityId",
            "ga:dcmFloodlightAdvertiserId",
            "ga:dcmFloodlightSpotId",
            "ga:dcmLastEventAd",
            "ga:dcmLastEventAdId",
            "ga:dcmLastEventAdType",
            "ga:dcmLastEventAdTypeId",
            "ga:dcmLastEventAdvertiser",
            "ga:dcmLastEventAdvertiserId",
            "ga:dcmLastEventAttributionType",
            "ga:dcmLastEventCampaign",
            "ga:dcmLastEventCampaignId",
            "ga:dcmLastEventCreativeId",
            "ga:dcmLastEventCreative",
            "ga:dcmLastEventRenderingId",
            "ga:dcmLastEventCreativeType",
            "ga:dcmLastEventCreativeTypeId",
            "ga:dcmLastEventCreativeVersion",
            "ga:dcmLastEventSite",
            "ga:dcmLastEventSiteId",
            "ga:dcmLastEventSitePlacement",
            "ga:dcmLastEventSitePlacementId",
            "ga:dcmLastEventSpotId",
        ],
        "Audience"                     => [
            "ga:userAgeBracket",
            "ga:userGender",
            "ga:interestOtherCategory",
            "ga:interestAffinityCategory",
            "ga:interestInMarketCategory",
            "ga:visitorAgeBracket",
            "ga:visitorGender",
        ],
        "Lifetime Value and Cohorts"   => [
            "ga:acquisitionCampaign",
            "ga:acquisitionMedium",
            "ga:acquisitionSource",
            "ga:acquisitionSourceMedium",
            "ga:acquisitionTrafficChannel",
            "ga:cohort",
            "ga:cohortNthDay",
            "ga:cohortNthMonth",
            "ga:cohortNthWeek",
        ],
        "Channel Grouping"             => [
            "ga:channelGrouping",
        ],
        "Related Products"             => [
            "ga:correlationModelId",
            "ga:queryProductId",
            "ga:queryProductName",
            "ga:queryProductVariation",
            "ga:relatedProductId",
            "ga:relatedProductName",
            "ga:relatedProductVariation",
        ],
        "DoubleClick Bid Manager"      => [
            "ga:dbmClickAdvertiser",
            "ga:dbmClickAdvertiserId",
            "ga:dbmClickCreativeId",
            "ga:dbmClickExchange",
            "ga:dbmClickExchangeId",
            "ga:dbmClickInsertionOrder",
            "ga:dbmClickInsertionOrderId",
            "ga:dbmClickLineItem",
            "ga:dbmClickLineItemId",
            "ga:dbmClickSite",
            "ga:dbmClickSiteId",
            "ga:dbmLastEventAdvertiser",
            "ga:dbmLastEventAdvertiserId",
            "ga:dbmLastEventCreativeId",
            "ga:dbmLastEventExchange",
            "ga:dbmLastEventExchangeId",
            "ga:dbmLastEventInsertionOrder",
            "ga:dbmLastEventInsertionOrderId",
            "ga:dbmLastEventLineItem",
            "ga:dbmLastEventLineItemId",
            "ga:dbmLastEventSite",
            "ga:dbmLastEventSiteId",
        ],
        "DoubleClick Search"           => [
            "ga:dsAdGroup",
            "ga:dsAdGroupId",
            "ga:dsAdvertiser",
            "ga:dsAdvertiserId",
            "ga:dsAgency",
            "ga:dsAgencyId",
            "ga:dsCampaign",
            "ga:dsCampaignId",
            "ga:dsEngineAccount",
            "ga:dsEngineAccountId",
            "ga:dsKeyword",
            "ga:dsKeywordId",
        ]
    ],
    'metrics'    => [
        "User"                                => [
            "ga:users",
            "ga:newUsers",
            "ga:percentNewSessions",
            "ga:1dayUsers",
            "ga:7dayUsers",
            "ga:14dayUsers",
            "ga:30dayUsers",
            "ga:sessionsPerUser",
            "ga:visitors",
            "ga:newVisits",
            "ga:percentNewVisits",
        ],
        "Session"                             => [
            "ga:sessions",
            "ga:bounces",
            "ga:bounceRate",
            "ga:sessionDuration",
            "ga:avgSessionDuration",
            "ga:uniqueDimensionCombinations",
            "ga:hits",
            "ga:visits",
            "ga:entranceBounceRate",
            "ga:visitBounceRate",
            "ga:timeOnSite",
            "ga:avgTimeOnSite",
        ],
        "Traffic Sources"                     => [
            "ga:organicSearches",
        ],
        "Adwords"                             => [
            "ga:impressions",
            "ga:adClicks",
            "ga:adCost",
            "ga:CPM",
            "ga:CPC",
            "ga:CTR",
            "ga:costPerTransaction",
            "ga:costPerGoalConversion",
            "ga:costPerConversion",
            "ga:RPC",
            "ga:ROAS",
            "ga:ROI",
            "ga:margin",
        ],
        "Goal Conversions"                    => [
            "ga:goalStartsAll",
            "ga:goalCompletionsAll",
            "ga:goalValueAll",
            "ga:goalValuePerSession",
            "ga:goalConversionRateAll",
            "ga:goalAbandonsAll",
            "ga:goalAbandonRateAll",
            "ga:goalValuePerVisit",
        ],
        "Social Activities"                   => [
            "ga:socialActivities",
        ],
        "Page Tracking"                       => [
            "ga:pageValue",
            "ga:entrances",
            "ga:entranceRate",
            "ga:pageviews",
            "ga:pageviewsPerSession",
            "ga:uniquePageviews",
            "ga:timeOnPage",
            "ga:avgTimeOnPage",
            "ga:exits",
            "ga:exitRate",
            "ga:pageviewsPerVisit",
        ],
        "Content Grouping"                    => [
        ],
        "Internal Search"                     => [
            "ga:searchResultViews",
            "ga:searchUniques",
            "ga:avgSearchResultViews",
            "ga:searchSessions",
            "ga:percentSessionsWithSearch",
            "ga:searchDepth",
            "ga:avgSearchDepth",
            "ga:searchRefinements",
            "ga:percentSearchRefinements",
            "ga:searchDuration",
            "ga:avgSearchDuration",
            "ga:searchExits",
            "ga:searchExitRate",
            "ga:searchGoalConversionRateAll",
            "ga:goalValueAllPerSearch",
            "ga:searchVisits",
            "ga:percentVisitsWithSearch",
        ],
        "Site Speed"                          => [
            "ga:pageLoadTime",
            "ga:pageLoadSample",
            "ga:avgPageLoadTime",
            "ga:domainLookupTime",
            "ga:avgDomainLookupTime",
            "ga:pageDownloadTime",
            "ga:avgPageDownloadTime",
            "ga:redirectionTime",
            "ga:avgRedirectionTime",
            "ga:serverConnectionTime",
            "ga:avgServerConnectionTime",
            "ga:serverResponseTime",
            "ga:avgServerResponseTime",
            "ga:speedMetricsSample",
            "ga:domInteractiveTime",
            "ga:avgDomInteractiveTime",
            "ga:domContentLoadedTime",
            "ga:avgDomContentLoadedTime",
            "ga:domLatencyMetricsSample",
        ],
        "App Tracking"                        => [
            "ga:screenviews",
            "ga:uniqueScreenviews",
            "ga:screenviewsPerSession",
            "ga:timeOnScreen",
            "ga:avgScreenviewDuration",
            "ga:appviews",
            "ga:uniqueAppviews",
            "ga:appviewsPerVisit",
        ],
        "Event Tracking"                      => [
            "ga:totalEvents",
            "ga:uniqueEvents",
            "ga:eventValue",
            "ga:avgEventValue",
            "ga:sessionsWithEvent",
            "ga:eventsPerSessionWithEvent",
            "ga:visitsWithEvent",
            "ga:eventsPerVisitWithEvent",
        ],
        "Ecommerce"                           => [
            "ga:transactions",
            "ga:transactionsPerSession",
            "ga:transactionRevenue",
            "ga:revenuePerTransaction",
            "ga:transactionRevenuePerSession",
            "ga:transactionShipping",
            "ga:transactionTax",
            "ga:totalValue",
            "ga:itemQuantity",
            "ga:uniquePurchases",
            "ga:revenuePerItem",
            "ga:itemRevenue",
            "ga:itemsPerPurchase",
            "ga:localTransactionRevenue",
            "ga:localTransactionShipping",
            "ga:localTransactionTax",
            "ga:localItemRevenue",
            "ga:buyToDetailRate",
            "ga:cartToDetailRate",
            "ga:internalPromotionCTR",
            "ga:internalPromotionClicks",
            "ga:internalPromotionViews",
            "ga:localProductRefundAmount",
            "ga:localRefundAmount",
            "ga:productAddsToCart",
            "ga:productCheckouts",
            "ga:productDetailViews",
            "ga:productListCTR",
            "ga:productListClicks",
            "ga:productListViews",
            "ga:productRefundAmount",
            "ga:productRefunds",
            "ga:productRemovesFromCart",
            "ga:productRevenuePerPurchase",
            "ga:quantityAddedToCart",
            "ga:quantityCheckedOut",
            "ga:quantityRefunded",
            "ga:quantityRemovedFromCart",
            "ga:refundAmount",
            "ga:revenuePerUser",
            "ga:totalRefunds",
            "ga:transactionsPerUser",
            "ga:transactionsPerVisit",
            "ga:transactionRevenuePerVisit",
        ],
        "Social Interactions"                 => [
            "ga:socialInteractions",
            "ga:uniqueSocialInteractions",
            "ga:socialInteractionsPerSession",
            "ga:socialInteractionsPerVisit",
        ],
        "User Timings"                        => [
            "ga:userTimingValue",
            "ga:userTimingSample",
            "ga:avgUserTimingValue",
        ],
        "Exceptions"                          => [
            "ga:exceptions",
            "ga:exceptionsPerScreenview",
            "ga:fatalExceptions",
            "ga:fatalExceptionsPerScreenview",
        ],
        "DoubleClick Campaign Manager"        => [
            "ga:dcmFloodlightQuantity",
            "ga:dcmFloodlightRevenue",
            "ga:dcmCPC",
            "ga:dcmCTR",
            "ga:dcmClicks",
            "ga:dcmCost",
            "ga:dcmImpressions",
            "ga:dcmROAS",
            "ga:dcmRPC",
            "ga:dcmMargin",
            "ga:dcmROI",
        ],
        "Adsense"                             => [
            "ga:adsenseRevenue",
            "ga:adsenseAdUnitsViewed",
            "ga:adsenseAdsViewed",
            "ga:adsenseAdsClicks",
            "ga:adsensePageImpressions",
            "ga:adsenseCTR",
            "ga:adsenseECPM",
            "ga:adsenseExits",
            "ga:adsenseViewableImpressionPercent",
            "ga:adsenseCoverage",
        ],
        "Ad Exchange"                         => [
            "ga:adxImpressions",
            "ga:adxCoverage",
            "ga:adxMonetizedPageviews",
            "ga:adxImpressionsPerSession",
            "ga:adxViewableImpressionsPercent",
            "ga:adxClicks",
            "ga:adxCTR",
            "ga:adxRevenue",
            "ga:adxRevenuePer1000Sessions",
            "ga:adxECPM",
        ],
        "DoubleClick for Publishers"          => [
            "ga:dfpImpressions",
            "ga:dfpCoverage",
            "ga:dfpMonetizedPageviews",
            "ga:dfpImpressionsPerSession",
            "ga:dfpViewableImpressionsPercent",
            "ga:dfpClicks",
            "ga:dfpCTR",
            "ga:dfpRevenue",
            "ga:dfpRevenuePer1000Sessions",
            "ga:dfpECPM",
        ],
        "DoubleClick for Publishers Backfill" => [
            "ga:backfillImpressions",
            "ga:backfillCoverage",
            "ga:backfillMonetizedPageviews",
            "ga:backfillImpressionsPerSession",
            "ga:backfillViewableImpressionsPercent",
            "ga:backfillClicks",
            "ga:backfillCTR",
            "ga:backfillRevenue",
            "ga:backfillRevenuePer1000Sessions",
            "ga:backfillECPM",
        ],
        "Lifetime Value and Cohorts"          => [
            "ga:cohortActiveUsers",
            "ga:cohortAppviewsPerUser",
            "ga:cohortAppviewsPerUserWithLifetimeCriteria",
            "ga:cohortGoalCompletionsPerUser",
            "ga:cohortGoalCompletionsPerUserWithLifetimeCriteria",
            "ga:cohortPageviewsPerUser",
            "ga:cohortPageviewsPerUserWithLifetimeCriteria",
            "ga:cohortRetentionRate",
            "ga:cohortRevenuePerUser",
            "ga:cohortRevenuePerUserWithLifetimeCriteria",
            "ga:cohortSessionDurationPerUser",
            "ga:cohortSessionDurationPerUserWithLifetimeCriteria",
            "ga:cohortSessionsPerUser",
            "ga:cohortSessionsPerUserWithLifetimeCriteria",
            "ga:cohortTotalUsers",
            "ga:cohortTotalUsersWithLifetimeCriteria",
        ],
        "Related Products"                    => [
            "ga:correlationScore",
            "ga:queryProductQuantity",
            "ga:relatedProductQuantity",
        ],
        "DoubleClick Bid Manager"             => [
            "ga:dbmCPA",
            "ga:dbmCPC",
            "ga:dbmCPM",
            "ga:dbmCTR",
            "ga:dbmClicks",
            "ga:dbmConversions",
            "ga:dbmCost",
            "ga:dbmImpressions",
            "ga:dbmROAS",
        ],
        "DoubleClick Search"                  => [
            "ga:dsCPC",
            "ga:dsCTR",
            "ga:dsClicks",
            "ga:dsCost",
            "ga:dsImpressions",
            "ga:dsProfit",
            "ga:dsReturnOnAdSpend",
            "ga:dsRevenuePerClick",
        ]
    ]
];