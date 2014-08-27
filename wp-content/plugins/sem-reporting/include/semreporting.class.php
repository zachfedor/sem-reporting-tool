<?php
class SemReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'get_data' ) );
	}
	
	function report_tests()
	{
		set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/google-api-php-client/src');
		
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