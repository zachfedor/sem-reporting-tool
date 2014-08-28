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
			, 'nda'	=>	'ga:75274122'
		);
		
		$google_analytics_id = array_shift( $google_analytics_ids );
		
		$googleanalytics_component = Google::get_google_analytics_data( $google_analytics_id );

		$youtube_analytics_ids = array(
			'tower'	=>	'channel==RN49YEulHCg4pFbakZsVMQ'
			, 'lrrcu'	=>	'ga:61739784'
			, 'continental'	=>	'ga:6086169'
			, 'nda'	=>	'ga:75274122'
		);
		
		$youtube_analytics_id = array_shift( $youtube_analytics_ids );
		
		$youtube_analytics_component = Google::get_youtube_analytics_data( $youtube_analytics_id );
		
		//$twitter_component = $this->get_twitter_data();
		
		//$facebook_component = $this->get_facebook_data();
	}
	
	private function get_facebook_data()
	{
		return Facebook::get_data();
	}
	
	private function get_twitter_data()
	{
		return Twitter::get_data();
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