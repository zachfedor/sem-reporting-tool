<?php
class SocialReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'generate_report' ) );
	}
	
	function generate_report()
	{
// 		$client = 'tower';
// 		$client = 'fairmount';
// 		$client = 'lrrcu';
		$client = 'countrymeadows';
		
		$test_component = CompetitorLinkMetricsComponent::get_by_client($client);
		echo 'CompetitorLinkMetricsComponent: ' . $test_component->to_serialize() . '<br /><br /><br />';
		
		$test_component = DomainAuthorityComponent::get_by_client($client);
		echo 'DomainAuthorityComponent: ' . $test_component->to_serialize() . '<br /><br /><br />';
		
		$test_component = OtherInfoComponent::get_by_client($client);
		echo 'OtherInfoComponent: ' . $test_component->to_serialize() . '<br /><br /><br />';
		
		$test_component = VisitsComponent::get_by_client($client);
		echo 'VisitsComponent: ' . $test_component->to_serialize() . '<br /><br /><br />';
	}
	
	private static function get_clients()
	{
		$clients = array(
			'tower'
			, 'perkypet'
			, 'lrrcu'
			, 'continental'
			, 'townlively'
			, 'ninjaflex'
		);
	}
	
	function elog( $stuff )
	{
	  ob_start();
	  if ( is_array( $stuff ) )
	  {
	  	print_r( $stuff );
	  }
	  else
	  {
	  	echo $stuff;
	  }
	  $contents = ob_get_contents();
	  ob_end_clean();
	 
	  error_log( $contents );
	}
}