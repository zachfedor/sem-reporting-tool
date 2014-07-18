<?php
// Obtain your access id and secret key here: http://www.seomoz.org/api/keys
$accessID = "member-53c0767d2c";
$secretKey = "b37eb0af871a2a3f53d28d72f04eb1d9";

// Set your expires for five minutes into the future.
$expires = time() + 300;

// A new linefeed is necessary between your AccessID and Expires.
$stringToSign = $accessID."\n".$expires;

// Get the "raw" or binary output of the hmac hash.
$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);

// We need to base64-encode it and then url-encode that.
$urlSafeSignature = urlencode(base64_encode($binarySignature));

// This is the URL that we want link metrics for.
$objectURL = "www.towermarketing.net";

// Add up all the bit flags you want returned.
// Learn more here: http://apiwiki.seomoz.org/categories/api-reference
$cols = "103079215108";

// Now put your entire request together.
// This example uses the Mozscape URL Metrics API.
$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;

// We can easily use Curl to send off our request.
$options = array(
	CURLOPT_RETURNTRANSFER => true
	);

$ch = curl_init($requestUrl);
curl_setopt_array($ch, $options);
$content = curl_exec($ch);
curl_close($ch);

pc( $content );

function pc( $stuff )
{
	echo '<pre>';
	print_r( $stuff );
	echo '</pre>';
}