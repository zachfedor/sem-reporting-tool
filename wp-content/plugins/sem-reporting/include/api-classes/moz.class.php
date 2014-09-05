<?php
require_once __DIR__ . '/../wrappers/moz_api_wrapper/bootstrap.php';

class Moz
{
	public static function get_domain_authority_component( $client )
	{
		$data = self::get_data( $client );
		
		$domain_authority_competitors = array();
		foreach ( $data['domain_authority_competitors'] as $key => $competitor )
		{
			$domain_authority_competitors[] = new DomainAuthorityCompetitor( $competitor['url'], $competitor['domain_authority'] );
		}

		return new DomainAuthorityComponent( $data['domain_authority'], $domain_authority_competitors );
	}
	
	public static function get_competitor_link_metrics_component( $client )
	{
		$data = self::get_data( $client );
		
		$metrics = array(
			'domain_authority'
			, 'external_followed_links'
			, 'followed_linking_root_domains'
			, 'domain_mozrank'
			, 'domain_moztrust'
			, 'total_external_links'
			, 'total_linking_root_domains'
		);
		
		$link_metrics_arr = array();
		foreach ( $metrics as $metric )
		{
			$name = ucwords( str_replace( '_', ' ', $metric ) );
			$link_metrics_arr[] = new LinkMetric( $name, $data[$metric] );
		}
		
		$link_metrics = new LinkMetrics( $data['url'], $link_metrics_arr );
		
		$domain_authority_competitors = array();
		foreach ( $data['domain_authority_competitors'] as $key => $competitor )
		{
			$competitor_link_metrics_arr = array();
			foreach ( $metrics as $metric )
			{
				$name = ucwords( str_replace( '_', ' ', $metric ) );
				$competitor_link_metrics_arr[] = new LinkMetric( $name, $competitor[$metric] );
			}
			
			$competitor_link_metrics[] = new LinkMetrics( $competitor['url'], $competitor_link_metrics_arr );
		}

		return new CompetitorLinkMetricsComponent( $link_metrics, $competitor_link_metrics );
	}
	
	private static function get_data( $client )
	{
		//get the credentials for the client
		$client_data = self::get_client_creds( $client );
		
		// Set the rate limit
		$rateLimit = 10;
		
		//set the authentication parameters
		$authenticator = new Authenticator();
		$authenticator->setAccessID( $client_data['access_id'] );
		$authenticator->setSecretKey( $client_data['secret_key'] );
		$authenticator->setRateLimit( $rateLimit );
		
		// URL to query
		$objectURL = $client_data['url'];
		
		// Metrics to retrieve (url_metrics_constants.php)
		$cols = URLMETRICS_COL_DOMAIN_AUTHORITY
			+ URLMETRICS_COL_EXTERNAL_LINKS
			+ URLMETRICS_COL_ROOTDMN_EXTERNAL_LINKS
			+ URLMETRICS_COL_ROOTDMN_MOZRANK
			+ URLMETRICS_COL_ROOTDMN_MOZTRUST
			+ 549755813888//total external links
			+ URLMETRICS_COL_ROOTDMN_LINKS;
		
		//get the domain authority for the url
		$urlMetricsService = new URLMetricsService( $authenticator );
		$response = $urlMetricsService->getUrlMetrics( $objectURL, $cols );


		$ret_data = self::get_metrics_from_response( $client_data['url'], $response );
		
		$domain_authority_competitors = array();
		foreach ( $client_data['competitors'] as $key => $competitor_url )
		{
			$response = $urlMetricsService->getUrlMetrics( $competitor_url, $cols );
			
			$domain_authority_competitors[] = self::get_metrics_from_response( $competitor_url, $response );
		}
		
		$ret_data['domain_authority_competitors'] = $domain_authority_competitors;
		
		return $ret_data;
	}
	
	private static function get_metrics_from_response( $url, $response )
	{
		return array(
			'url'	=>	$url
			, 'domain_authority'	=>	ceil( $response['pda'] )
			, 'external_followed_links'	=>	$response['ueid']
			, 'followed_linking_root_domains'	=>	$response['peid']
			, 'domain_mozrank'	=>	round( $response['pmrp'] * 100 ) / 100
			, 'domain_moztrust'	=>	round( $response['ptrp'] * 100 ) / 100
			, 'total_external_links'	=>	$response['ued']
			, 'total_linking_root_domains'	=>	$response['uipl']
		);
	}
	
	private static function get_client_creds( $client )
	{
		$clients = array(
			'tower'	=>	array(
				'url'	=>	'www.towermarketing.net'
				, 'competitors'	=>	array(
					'www.ezsolution.com'
					, 'www.synapseresults.com'
					, 'www.webtekcc.com'
				)
			)
			,'fairmount'	=>	array(
				'url'	=>	'fairmountbhs.com'
				, 'competitors'	=>	array()
			)
			,'lrrcu'	=>	array(
				'url'	=>	'lrrcu.org'
				, 'competitors'	=>	array(
					'www.lancofcu.com'
					, 'www.members1st.org'
					, 'www.psecu.com'
				)
			)
			,'countrymeadows'	=>	array(
				'url'	=>	'countrymeadows.com'
				, 'competitors'	=>	array(
					'www.emeritus.com'
					, 'www.diakon.org'
					, 'phoebe.org'
				)
			)
		);
		
		$creds = $clients[$client];
		$creds['access_id'] = 'member-53c0767d2c';
		$creds['secret_key'] = 'b37eb0af871a2a3f53d28d72f04eb1d9';
		
		return $creds;
	}
}