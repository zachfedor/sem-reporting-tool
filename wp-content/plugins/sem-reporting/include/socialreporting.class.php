<?php
class SocialReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'generate_report' ) );
	}
	
	function generate_report()
	{
		$client = 'tower';
		
		$test_component = YouTubeComponent::get_by_client($client);
		echo '<pre>';
		print_r($test_component->to_json());
		echo '</pre>';// . '<br /><br /><br />';
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