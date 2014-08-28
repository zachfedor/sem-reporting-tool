<?php
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../wrappers/google-api-php-client/src/' );

require_once 'Google/Client.php';
require_once 'Google/Service/Analytics.php';

class GoogleAnalytics
{
	public static function get_data()
	{	
		/************************************************
		 The following 3 values an befound in the setting
		for the application you created on  Google
		Developers console.
		The Key file should be placed in a location
		that is not accessable from the web. outside of
		web root.
		 
		In order to access your GA account you must
		Add the Email address as a user at the
		ACCOUNT Level in the GA admin.
		************************************************/
		$client_id = '908078370210-okbq3rrl5mefhs5o9cb1v48m34t3mbv6.apps.googleusercontent.com';
		$Email_address = '5723237213-2rh9smblhnof7d82ik5i3rb7g5uf383a@developer.gserviceaccount.com';
		$key_file_location = __DIR__ . '/SEMReporting-2bd114da8850.p12';
		//password - notasecret
		
		$client = new Google_Client();
		$client->setApplicationName("SEMReporting");
		
		$key = file_get_contents($key_file_location);
		
		// seproate additional scopes with a comma
		$scopes ="https://www.googleapis.com/auth/analytics.readonly";
		
		$cred = new Google_Auth_AssertionCredentials(
				$Email_address,
				array($scopes),
				$key
		);
		
		$client->setAssertionCredentials($cred);
		if($client->getAuth()->isAccessTokenExpired()) {
			$client->getAuth()->refreshTokenWithAssertion($cred);
		}
		
		$service = new Google_Service_Analytics($client);
		$accounts = $service->management_accountSummaries->listManagementAccountSummaries();

		$start_date = date( 'Y-m-d', strtotime( 'first day of last month' ) );
		$end_date = date( 'Y-m-d', strtotime( 'last day of last month' ) );

		$ids = array(
			'tower'	=>	'ga:32351305'
			, 'lrrcu'	=>	'ga:61739784'
			, 'continental'	=>	'ga:6086169'
			, 'nda'	=>	'ga:75274122'
		);
		
		$metrics = array(
			'ga:sessions'
			, 'ga:avgSessionDuration'
			, 'ga:bounceRate'
			, 'ga:pageviewsPerSession'
		);
		
		//Adding Dimensions
		$params = array('dimensions' => 'ga:medium');
		// requesting the data
		$id = array_shift( $ids );
		$data = $service->data_ga->get( $id, $start_date,  $end_date, implode( ',', $metrics ), $params );
		
		
		?><html>
		<?php echo $start_date . " - " . $end_date. "\n";?>
		<table>
		<tr>
		<?php
		//Printing column headers
		foreach($data->getColumnHeaders() as $header){	
			print "<td>".$header['name']."</td>";	
		}
		?>
		</tr>
		<?php
		//printing each row.
		foreach ($data->getRows() as $row) {	
			print "<tr>";
				foreach ( $row as $val )
				{
					echo "<td>".$val."</td>";
				}
			print "</tr>";
		}
		
		//printing the total number of rows
		?>
		<tr><td colspan="2">Rows Returned <?php print $data->getTotalResults();?> </td></tr>
		</table><?php 
		
		
		
	}
}