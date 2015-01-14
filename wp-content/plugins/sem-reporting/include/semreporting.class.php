<?php
class SEMReporting
{
	public function init()
	{
		add_shortcode( 'report_tests', array( $this, 'generate_report' ) );
	}
	
	function generate_report()
	{
		foreach ( self::get_clients() as $client_name => $client_accounts )
		{
			if ( $client_name != 'tower' )
			{
				continue;
			}
			echo $client_name . ':<br />';
			$components = array();
			foreach ( $client_accounts as $component_type )
			{
				$component = call_user_func( $component_type . 'Component::get_by_client', $client_name );

				echo $component_type . '<pre>';
				print_r($component->to_json());
				echo '</pre>' . '<br /><br /><br />';
			}
		}
	}
	
	private static function get_clients()
	{
		return array(
			'tower'	=>	array(
				'CompetitorLinkMetrics'
				, 'DomainAuthority'
				, 'OtherInfo'
				, 'Visits'
			)
			, 'fairmount'	=>	array(
				'CompetitorLinkMetrics'
				, 'DomainAuthority'
				, 'OtherInfo'
				, 'Visits'
			)
			, 'lrrcu'	=>	array(
				'CompetitorLinkMetrics'
				, 'DomainAuthority'
				, 'OtherInfo'
				, 'Visits'
			)
			, 'countrymeadows'	=>	array(
				'CompetitorLinkMetrics'
				, 'DomainAuthority'
				, 'OtherInfo'
				, 'Visits'
			)
		);

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