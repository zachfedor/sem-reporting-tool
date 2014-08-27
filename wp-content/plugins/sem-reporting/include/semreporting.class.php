<?php
class SemReporting
{
	public function init()
	{	
		add_shortcode( 'report_tests', array( $this, 'report_tests' ) );
	}
	
	function report_tests()
	{
		
		
		echo '<pre>';
		print_r($google_component->to_array());
		echo '</pre>';
	}
	
	function get_data()
	{
		$data = '';

		set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/google-api-php-client/src');
		
		require_once 'Google/Client.php';
		require_once 'Google/Service/Analytics.php';
		
		$client = new Google_Client();
		$client->setApplicationName('Hello Analytics API Sample');
		
		// Visit https://console.developers.google.com/ to generate your
		// client id, client secret, and to register your redirect uri.
		$client->setClientId('5723237213-2rh9smblhnof7d82ik5i3rb7g5uf383a.apps.googleusercontent.com');
		$client->setClientSecret('insert_your_oauth2_client_secret');
		$client->setRedirectUri('insert_your_oauth2_redirect_uri');
		$client->setDeveloperKey('insert_your_developer_key');
		$client->setScopes(array('https://www.googleapis.com/auth/analytics.readonly'));
		
		// Magic. Returns objects from the Analytics Service instead of associative arrays.
		$client->setUseObjects(true);
		
		return $data;
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