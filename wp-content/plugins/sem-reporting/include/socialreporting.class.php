<?php
class SocialReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'generate_report' ) );
	}
	
	function generate_report()
	{
		$test_component = LinkedInAnalytics::get_component( 'lrrcu' );
		
		echo '<pre>';
		//echo $test_component->to_serialize();
		//$test_component = FacebookComponent::get_from_serialized_array( 'a:4:{s:11:"total_likes";i:281;s:11:"total_reach";i:5913;s:15:"reach_breakdown";a:8:{i:1;i:969;i:2;i:473;i:3;i:209;i:4;i:103;s:4:"6-10";i:94;i:5;i:46;s:3:"21+";i:36;s:5:"11-20";i:35;}s:13:"top_ten_posts";a:0:{}}' );
		print_r( $test_component->to_array() );
		echo '</pre>';
		
		//echo $test_component->to_html();
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