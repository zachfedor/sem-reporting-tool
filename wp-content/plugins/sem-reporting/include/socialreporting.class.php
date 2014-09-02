<?php
class SocialReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'generate_report' ) );
	}
	
	function generate_report()
	{
		$google_analytics_ids = array(
			'tower'	=>	'ga:32351305'
			, 'lrrcu'	=>	'ga:61739784'
			, 'continental'	=>	'ga:6086169'
		);
		
		$google_analytics_id = array_shift( $google_analytics_ids );
		
		$googleanalytics_component = Moz::get_competitor_link_metrics_component( 'tower' );
		
		echo '<pre>';
		print_r($googleanalytics_component->to_array());
		echo '</pre>';
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