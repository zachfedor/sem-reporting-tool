<?php
class SEMReporting
{
	public function init()
	{	
		
	}
	
	function generate_report()
	{
		
	}
	
	private static function get_clients()
	{
		$clients = array(
			'tower'
			, 'fairmount'
			, 'lrrcu'
			, 'countrymeadows'
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