<?php
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../wrappers/google-api-php-client-master/src/' );

require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';
require_once 'Google/Service/YouTubeAnalytics.php';

class Google
{
	//const CLIENT_ID = '908078370210-okbq3rrl5mefhs5o9cb1v48m34t3mbv6.apps.googleusercontent.com';
	const EMAIL_ADDRESS = '5723237213-2rh9smblhnof7d82ik5i3rb7g5uf383a@developer.gserviceaccount.com';
	
	public static function get_social_component( $client )
	{
		$data = self::get_google_analytics_data( $client );
		
		$social_data = $data['social'];
		
		return new GoogleAnalyticsComponent( $social_data['total_sessions'], $social_data['sessions_via_social_referral'] );
	}
	
	public static function get_sem_other_info_component( $client )
	{
		$data = self::get_sem_data( $client );

		$visit_info = $data['visit_info'];
		$session_info = $data['session_info'];
		
		return new OtherInfoComponent( $session_info['total'], $session_info['page_views_per'], $session_info['average_duration'], $session_info['bounce_rate'] );
	}

	public static function get_sem_visits_component( $client )
	{
		$data = self::get_sem_data( $client );
		$total_visits = $data['session_info']['total'];
		$visit_info = $data['visit_info'];

		$visits = array();
		foreach ( $visit_info as $type => $num_visits )
		{
			$visits[] = new Visit( $type, $num_visits );
		}

		return new VisitsComponent( $total_visits, $visits );
	}

	public static function get_youtube_component( $client )
	{
		$data = self::get_youtube_analytics_data( $client );

		$demographics = new YouTubeDemographics(
			$data['views']
			, $data['estimatedMinutesWatched']
			, $data['subscribersGained']
			, $data['likes']
			, $data['dislikes']
			, $data['comments']
			, $data['favoritesAdded']
			, $data['favoritesRemoved']
		);

		return new YouTubeComponent( $data['views'], 0, $demographics );
	}
	
	private static function get_social_data( $id )
	{
		$data = self::get_google_analytics_data( $id );
		
		return $data['social'];
	}
	
	private static function get_sem_data( $client )
	{
		$data = self::get_google_analytics_data( $client );
		
		return $data['sem'];
	}
	
	private static function get_google_analytics_data( $client )
	{
		$client_data = self::get_client_creds( $client );
		$client_data = $client_data['analytics'];
		
		$id = $client_data['id'];
		
		$client = new Google_Client();
		$client->setApplicationName( 'SEMReporting' );
		
		$key = file_get_contents( $client_data['key_file_location'] );
		
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
		
		$sem_data = array(
			'visit_info'	=>	$visit_info
			, 'session_info'	=>	$session_info
		);
		
		$social_data = array(
			'total_sessions'	=>	$session_info['total']
			, 'sessions_via_social_referral'	=>	$visit_info['social']
		);
		
		$data = array(
			'sem'	=>	$sem_data
			, 'social'	=>	$social_data
		);
		
		return $data;
	}
	
	private static function get_youtube_analytics_data( $client )
	{
		$creds = self::get_client_creds( $client );

		$client = new Google_Client();
		$client->setApplicationName('SEMReporting');
		$client->setClientId('5723237213-j502vj21f72ht866770opdjot9heb36m.apps.googleusercontent.com');
		$client->setClientSecret('eOh27nxw5n0h4e7WSEl8-0gI');
		$client->setAccessType('offline_access');  // this may be unnecessary?
		$client->setScopes('https://www.googleapis.com/auth/yt-analytics.readonly');

		//if ( $client->isAccessTokenExpired() )
		{
			//$client->refreshToken('1/DIbhQSQKsXD8laxDrPKzSICJR1Py2RDwDYoAXXYqlMd90RDknAdJa_sgfheVM0XT');
		}

		$token = array(
			'access_token'	=>	'ya29.-wBcSY_JHDgPTcQGoQ1C9-EKvQaOpaver-MJbNw5ib7XyPphYY_Xep-y5Xbyg_u0OBj2kVZSoV4hLw'
			, 'refresh_token'	=>	'1/qrruuKtYbIk5l3oahPuPx2lpRKdEA6mvtojRlrKdeEMMEudVrK5jSpoR30zcRFq6'
			, 'token_type'	=>	'Bearer'
			, 'expires_in'	=>	'3600'
			, 'created'	=>	'1421259508'
		);
		$token = json_encode( $token );
		$client->setAccessToken( $token );

		$service = new Google_Service_YouTubeAnalytics( $client );

		$start_date = date( 'Y-m-d', strtotime( 'first day of last month' ) );
		$end_date = date( 'Y-m-d', strtotime( 'last day of last month' ) );

		$metrics = array(
			'views'
			, 'estimatedMinutesWatched'
			, 'subscribersGained'
			, 'likes'
			, 'dislikes'
			, 'comments'
			, 'shares'
			, 'favoritesAdded'
			, 'favoritesRemoved'
		);

		$dimensions = array(
			'ga:medium'
			, 'ga:hasSocialSourceReferral'
		);
		$params = array( 'dimensions' => implode( ',', $dimensions ) );

		$data = $service->reports->query( $creds['analytics']['channel_id'], $start_date, $end_date, implode( ',', $metrics ) );//, $params );

		$ret_data = array();
		foreach ( $metrics as $key => $metric )
		{
			$ret_data[$metric] = $data->rows[0][$key];
		}

		$metrics = array(
			'viewerPercentage'
		);

		$dimensions = array(
			'ageGroup'
		);
		$params = array( 'dimensions' => implode( ',', $dimensions ) );

		$data = $service->reports->query( $creds['analytics']['channel_id'], $start_date, $end_date, implode( ',', $metrics ), $params );

		return $ret_data;
	}
	
	private static function get_client_creds( $client )
	{
		$clients = array(
			'tower'	=>	array(
				'analytics'	=>	array(
					'id'	=>	'ga:32351305'
					, 'key_file_location'	=>	__DIR__ . '/SEMReporting-2bd114da8850.p12'//password - notasecret
					, 'channel_id'	=>	'channel==UCRN49YEulHCg4pFbakZsVMQ'
				)
			)
			, 'continental'	=>	array(
				'analytics'	=>	array(
					'id'	=>	'ga:6086169'
					, 'key_file_location'	=>	__DIR__ . '/SEMReporting-2bd114da8850.p12'//password - notasecret
				)
			)
			, 'fairmount'	=>	array(
				'analytics'	=>	array(
					'id'	=>	'ga:42762328'
					, 'key_file_location'	=>	__DIR__ . '/SEMReporting-2bd114da8850.p12'//password - notasecret
				)
			)
			, 'lrrcu'	=>	array(
				'analytics'	=>	array(
					'id'	=>	'ga:61739784'
					, 'key_file_location'	=>	__DIR__ . '/SEMReporting-2bd114da8850.p12'//password - notasecret
				)
			)
			, 'countrymeadows'	=>	array(
				'analytics'	=>	array(
					'id'	=>	'ga:16267479'
					, 'key_file_location'	=>	__DIR__ . '/SEMReporting-2bd114da8850.p12'//password - notasecret
				)
			)
		);
		
		return $clients[$client];
	}
}