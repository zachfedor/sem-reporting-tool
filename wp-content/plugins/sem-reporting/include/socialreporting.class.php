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

		foreach ( self::get_clients() as $client_name => $client_accounts )
		{
			if ( $client_name != 'tower' )
			{
				continue;
			}
			echo $client_name . ':<br />';
			$components = array();
			foreach ( $client_accounts as $client_account )
			{
				$component = call_user_func( $client_account . 'Component::get_by_client', $client_name );

				echo '<pre>';
				print_r($component->to_json());
				echo '</pre>' . '<br /><br /><br />';
			}
		}
	}
	
	private static function get_clients()
	{
		return array(
			'tower'	=>	array(
				'Facebook'
				, 'GoogleAnalytics'
				, 'LinkedIn'
				, 'Twitter'
				, 'Youtube'
			)
			, 'perkypet'	=>	array(
				'Facebook'
				, 'Twitter'
			)
			, 'lrrcu'	=>	array(
				'Facebook'
				, 'GoogleAnalytics'
				, 'LinkedIn'
				, 'Twitter'
				)
			, 'continental'	=>	array(
				'Facebook'
				, 'GoogleAnalytics'
			)
			, 'townlively'	=>	array(
				'Twitter'
			)
			, 'ninjaflex'	=>	array(
				'Twitter'
			)
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