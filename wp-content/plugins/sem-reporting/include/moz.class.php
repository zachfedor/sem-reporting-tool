<?php
include 'moz_api_wrapper/bootstrap.php';

// Add your accessID here
$AccessID = 'member-53c0767d2c';

// Add your secretKey here
$SecretKey = 'b37eb0af871a2a3f53d28d72f04eb1d9';

// Set the rate limit
$rateLimit = 10;

$authenticator = new Authenticator();
$authenticator->setAccessID($AccessID);
$authenticator->setSecretKey($SecretKey);
$authenticator->setRateLimit($rateLimit);

// URL to query
$objectURL = "www.towermarketing.net";

// Metrics to retrieve (url_metrics_constants.php)
$cols = URLMETRICS_COL_DEFAULT;

$urlMetricsService = new URLMetricsService($authenticator);
$response = $urlMetricsService->getUrlMetrics($objectURL, $cols);

pc( $response );

function pc( $stuff )
{
	echo '<pre>';
	print_r( $stuff );
	echo '</pre>';
}