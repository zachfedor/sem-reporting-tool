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

		$domain_authority_component = new DomainAuthorityComponent( $data['domain_authority'], $domain_authority_competitors );
		
		return $domain_authority_component;
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
		$authenticator->setAccessID($client_data['access_id']);
		$authenticator->setSecretKey($client_data['secret_key']);
		$authenticator->setRateLimit($rateLimit);
		
		// URL to query
		$objectURL = $client_data['url'];
		
		// Metrics to retrieve (url_metrics_constants.php)
		$cols = URLMETRICS_COL_DOMAIN_AUTHORITY
			+ URLMETRICS_COL_ROOTDMN_MOZRANK
			+ URLMETRICS_COL_ROOTDMN_LINKS
			+ URLMETRICS_COL_ROOTDMN_MOZTRUST
			+ 549755813888;//total external links
		
		//get the domain authority for the url
		$urlMetricsService = new URLMetricsService( $authenticator );
		$response = $urlMetricsService->getUrlMetrics( $objectURL, $cols );

		$domain_authority = ceil( $response['pda'] );
		$external_followed_links = '';
		$followed_linking_root_domains = '';
		$domain_mozrank = round( $response['pmrp'] * 100 ) / 100;
		$domain_moztrust = round( $response['ptrp'] * 100 ) / 100;
		$total_external_links = $response['ued'];
		$total_linking_root_domains = $response['uipl'];
		
		$domain_authority_competitors = array();
		foreach ( $client_data['competitors'] as $key => $competitor_url )
		{
			$response = $urlMetricsService->getUrlMetrics($competitor_url, $cols);
			
			$domain_authority_competitor = array(
				'url'	=>	$competitor_url
				, 'domain_authority'	=>	ceil( $response['pda'] )
				, 'external_followed_links'	=>	''
				, 'followed_linking_root_domains'	=>	''
				, 'domain_mozrank'	=>	round( $response['pmrp'] * 100 ) / 100
				, 'domain_moztrust'	=>	round( $response['ptrp'] * 100 ) / 100
				, 'total_external_links'	=>	''
				, 'total_linking_root_domains'	=>	$response['uipl']
			);
			$domain_authority_competitors[] = $domain_authority_competitor;
		}
		
		$ret_data = array(
			'url'	=>	$client_data['url']
			, 'domain_authority'	=>	$domain_authority
			, 'external_followed_links'	=>	$external_followed_links
			, 'followed_linking_root_domains'	=>	$followed_linking_root_domains
			, 'domain_mozrank'	=>	$domain_mozrank
			, 'domain_moztrust'	=>	$domain_moztrust
			, 'total_external_links'	=>	$total_external_links
			, 'total_linking_root_domains'	=>	$total_linking_root_domains
			, 'domain_authority_competitors'	=>	$domain_authority_competitors
		);
		
		return $ret_data;
	}
	
	private static function get_client_creds( $client )
	{
		$clients = array(
			'tower'	=>	array(
				'access_id'	=>	'member-53c0767d2c'
				, 'secret_key'	=>	'b37eb0af871a2a3f53d28d72f04eb1d9'
				, 'url'	=>	'www.towermarketing.net'
				, 'competitors'	=>	array(
					'www.ezsolution.com'
					, 'www.synapseresults.com'
					, 'www.webtekcc.com'
				)
			)
		);
		
		return $clients[$client];
	}
}