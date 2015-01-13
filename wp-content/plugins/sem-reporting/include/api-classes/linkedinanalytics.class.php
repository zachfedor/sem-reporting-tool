<?php
use LinkedIn\LinkedIn;

require_once __DIR__ . '/../wrappers/PHP-LinkedIn-SDK-master/LinkedIn/LinkedIn.php';

class LinkedInAnalytics
{
	public static function get_component( $client )
	{
		$data = self::get_data( $client );
		
		$post_stats = array();
		
		return new LinkedInComponent( $data['total_followers'], $data['new_followers'], $data['impressions']
			, $data['engagement_rate'], $post_stats );
	}
	
	private static function get_data( $client )
	{
		$creds = self::get_client_creds( $client );
		
		$config = array(
		    'api_key'	=>	$creds['api_key'] 
		    , 'api_secret'	=>	$creds['api_secret'] 
		    , 'callback_url'	=>	$creds['callback_url']
		);

		$linked_in = new LinkedIn( $config );
		$linked_in->setAccessToken( $creds['access_token'] );

		$company_stats = $linked_in->get( '/companies/' . $creds['company_id'] . '/company-statistics' );
		//$company_posts = $linked_in->get( '/companies/' . $creds['company_id'] . '/updates' );
		$post_stats = array();
		
		$data = array(
			'total_followers'	=>	$company_stats['followStatistics']['count']
			, 'new_followers'	=>	$company_stats['followStatistics']['countsByMonth']['values'][0]['newCount']
			, 'impressions'	=>	$company_stats['statusUpdateStatistics']['viewsByMonth']['values'][0]['impressions']
			, 'engagement_rate'	=>	round( $company_stats['statusUpdateStatistics']['viewsByMonth']['values'][0]['engagement'] * 100 ) / 100
			, 'post_stats'	=>	$post_stats
		);
	
		return $data;
	}

	private static function get_client_creds( $client )
	{
		$clients = array(
			'tower'	=>	array(
				'access_token'	=>	'AQW1bgpi6OcasXk5rc0jyzc5iK-oofN4N6SSN0UqkmHrVHD3xZ-oc1zqyEJTZaIFfSGj8McSgAIyKYxQ2riqppQv7iZeWa0ThDSykQKuavjXExKWUdwq6Xpka4HYVSdaoWGEShfIzT8EdFFQkUfT_etTAPoPcjMfjrjoaiJfS4KTcamYgLY'
				, 'company_id'	=>	'1452885'
				, 'api_key'	=>	'77kpc6r3hxbcad'
				, 'api_secret'	=>	'DPtDlFdcV1DGpq31'
				, 'callback_url'	=>	'http://localhost/linkedin/linkedin/redirect.php'
			)
			, 'lrrcu'	=>	array(
				'access_token'	=>	'AQVA2wUHnntxvbmlyT3549Oefb3uTHDCNmXK5W283ndFerrgJxfguqOKVotSLf1ea1XcS33M1dEb5Z_i2MEalWQIfzj8LAeOhE6WxNHWU_g0Ck4fqnW40w0lEds2_SvZWG6EHR5vZZPv1ScID4Jj4TsxQonxtHE2nBhDuyYuEcog1wIWa5A'
				, 'company_id'	=>	'321791'
				, 'api_key'	=>	'77xd1c1vewcffh'
				, 'api_secret'	=>	'E5jdAi8lz4qcuOjj'
				, 'callback_url'	=>	'http://localhost/linkedin/linkedin/redirect.php'
			)
		);
	
		return $clients[$client];
	}
}