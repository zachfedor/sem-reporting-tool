<?php
class SocialReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'generate_report' ) );
	}
	
	function generate_report()
	{
		//$test_component = Twitter::get_component( 'tower' );
		
		//echo '<pre>';
		//echo $test_component->to_serialize();
		$test_component = TwitterComponent::get_from_serialized_array( 'a:2:{s:15:"total_followers";i:1147;s:15:"total_following";i:1443;}' );
		//print_r( $test_component->to_array() );
		//echo '</pre>';
		
		echo $test_component->to_html();
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