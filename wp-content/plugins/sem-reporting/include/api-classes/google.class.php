<?php
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../wrappers/google-api-php-client/src/' );

require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';
require_once 'Google/Service/YouTubeAnalytics.php';

class Google
{
	//const CLIENT_ID = '908078370210-okbq3rrl5mefhs5o9cb1v48m34t3mbv6.apps.googleusercontent.com';
	const EMAIL_ADDRESS = '5723237213-2rh9smblhnof7d82ik5i3rb7g5uf383a@developer.gserviceaccount.com';
	const KEY_FILE_LOCATION = '/SEMReporting-2bd114da8850.p12';//password - notasecret
	
	public static function get_google_analytics_data( $id )
	{
		
		$client = new Google_Client();
		$client->setApplicationName( 'SEMReporting' );
		
		$key = file_get_contents( __DIR__ . self::KEY_FILE_LOCATION );
		
		$scopes = 'https://www.googleapis.com/auth/analytics.readonly';
		
		$cred = new Google_Auth_AssertionCredentials(
			self::EMAIL_ADDRESS
			, array( $scopes )
			, $key
		);
		
		$client->setAssertionCredentials( $cred );
		if($client->getAuth()->isAccessTokenExpired() )
		{
			$client->getAuth()->refreshTokenWithAssertion( $cred );
		}
		
		$service = new Google_Service_Analytics( $client );
		
		$start_date = date( 'Y-m-d', strtotime( 'first day of last month' ) );
		$end_date = date( 'Y-m-d', strtotime( 'last day of last month' ) );
		
		$metrics = array(
			'ga:sessions'
			, 'ga:avgSessionDuration'
			, 'ga:bounceRate'
			, 'ga:pageviewsPerSession'
		);

		$data = $service->data_ga->get( $id, $start_date,  $end_date, implode( ',', $metrics ) );
		
		$analytics = $data->getRows();
		$analytics = $analytics[0];
		
		$session_info = array(
			'total'	=>	$analytics[0]
			, 'average_duration'	=>	round( $analytics[1] )
			, 'bounce_rate'	=>	round( $analytics[2] * 100 ) / 100
			, 'page_views_per'	=>	round( $analytics[3] * 100 ) / 100
		);
		
		
		$metrics = array(
			'ga:sessions'
		);

		$dimensions = array(
			'ga:medium'
			, 'ga:hasSocialSourceReferral'
		);
		$params = array( 'dimensions' => implode( ',', $dimensions ) );
		
		$data = $service->data_ga->get( $id, $start_date,  $end_date, implode( ',', $metrics ), $params );
		
		$analytics = $data->getRows();
		
		$visit_info = array();
		foreach ( $analytics as $analytic )
		{
			switch ( $analytic[0] )
			{
				case '(none)' :
					$visit_info['direct'] = $analytic[2];
					break;
				case 'Email' :
					$visit_info['other'] = $analytic[2];
					break;
				case 'organic' :
					$visit_info['organic'] = $analytic[2];
					break;
				case 'referral' :
					if ( $analytic[1] == 'Yes')
					{
						$visit_info['social'] = $analytic[2];
					}
					
					if ( $analytic[1] == 'No')
					{
						$visit_info['referring'] = $analytic[2];
					}
					break;
			}
		}
	}
	
	public static function get_youtube_analytics_data( $id )
	{
		$client = new Google_Client();
		$client->setApplicationName( 'SEMReporting' );
	
		$key = file_get_contents( __DIR__ . self::KEY_FILE_LOCATION );
	
		$scopes = 'https://www.googleapis.com/auth/yt-analytics.readonly';
	
		$cred = new Google_Auth_AssertionCredentials(
			self::EMAIL_ADDRESS
			, array( $scopes )
			, $key
		);
	
		$client->setAssertionCredentials( $cred );
		//if($client->getAuth()->isAccessTokenExpired() )
		{
			$client->getAuth()->refreshTokenWithAssertion( $cred );
			echo $client->getAccessToken();
		}
	
		$service = new Google_Service_YouTubeAnalytics( $client );
		
		$start_date = date( 'Y-m-d', strtotime( 'first day of last month' ) );
		$end_date = date( 'Y-m-d', strtotime( 'last day of last month' ) );
		
		$metrics = array(
			'views'
		);
		
		$dimensions = array(
			'ga:medium'
			, 'ga:hasSocialSourceReferral'
		);
		$params = array( 'dimensions' => implode( ',', $dimensions ) );
		
		$data = $service->reports->query( $id, $start_date, $end_date, implode( ',', $metrics ));//, $params );
		
		print_r($data);
	}
}