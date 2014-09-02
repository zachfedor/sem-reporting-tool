<?php
require_once __DIR__ . '/../wrappers/facebook-php-sdk-v4-4.0-dev/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphUser;
use Facebook\FacebookRequestException;

class Facebook
{
	const APP_ID = '251173041748131';
	const APP_SECRET = 'bc5d3f8e4f7e131cef52e7da294da1e3';
	
	public static function get_data( $client )
	{
		$creds = self::get_client_creds( $client );
		
		FacebookSession::setDefaultApplication( self::APP_ID, self::APP_SECRET );
		
		// Use one of the helper classes to get a FacebookSession object.
		//   FacebookRedirectLoginHelper
		//   FacebookCanvasLoginHelper
		//   FacebookJavaScriptLoginHelper
		// or create a FacebookSession with a valid access token:
		
		//start a new session with the access token
		$session = new FacebookSession( $creds['access_token'] );
	
		//request for posts
		$request = new FacebookRequest($session, 'GET', '/' . $creds['page_id'] . '/posts');
		$class_name = GraphUser::className();
		$post_lists = $request->execute()->getGraphObject($class_name)->asArray();
	
		print_r($post_lists);
	}
	
	private static function get_client_creds( $client )
	{
		//array of the access tokens for each facebook client
		$clients = array(
			'tower'	=>	array(
				'page_id'	=>	'TowerMarketing'
				, 'access_token'	=>	'CAADkcMfuOKMBABJfZBi9GCrAdxUFGgztfbsOjy9q2F2OIn3yp2WrV3gbiZBLYJkNi8sE9xZAw1dYuVjUihUkzavSowR2SC8QaAZATqsnYkkZCqOAyAfA5i7THWPIBGof9DI68jI0arVQqM5OQktOnaZBLnRnHJETpxZBPnyMc8gY9yjtMjWUW39'
			)
			, 'lrrcu'	=>	array(
				'page_id'	=>	'LRRCU'
				, 'access_token'	=>	'CAADkcMfuOKMBAIBntkccfnKOm2EIZBHpqnvP4vmkx4kH7xFIXbY0B2LjUdzbkbbLZASHyQCWDWDFXgNv4Hp1bDILSIPidzPrny11wjBlFUA63MWk0zuXFt158zOYFKpqabWY7XIElluGoU1Gj7Lz8ziSeaIFsWJigPZBeqkHtA3X7MZCnS6ZB'
			)
			, 'perkypet'	=>	array(
				'page_id'	=>	'perkypetfeeders'
				, 'access_token'	=>	'CAADkcMfuOKMBAISI27e5f7ABQb4owOChJiSAh7zte3oD87SbrgdZCFrhN6mSe0E5ookxxie2B3aMZAYuepWRqSjjLZBlszgpBi5ZB3brIFR7J2C5olLAoyCeUPbs9DSrwTTGZC1NNnemrpOKMSSlu0HbccdCE4Hee1F78oS83TQZAZBSgxQnsXi'
			)
			, 'cpress'	=>	array(
				'page_id'	=>	'ContinentalPress'
				, 'access_token'	=>	'CAADkcMfuOKMBAB2lfj1nfRvJsqmjTVB2UTC1nkua281jir8KDOgXEJT83v6f4Sr3vIi5lzc2UctJ0nnZB51V8yTgLYaZAHAbtbZB7HhGUgfpUafeVCguBp3p1HtIB7UMh8iCJtQd9ZAcOKZAykVcmGE09htGIBTecgMjltvqdhWg6RveF24ND'
			)
			, 'nda'	=>	array(
				'page_id'	=>	'DemolitionAssoc'
				, 'access_token'	=>	'CAADkcMfuOKMBALpxJ3WUydZCxyECL8ERGldjgQ9mn30JSZBudP712YcjRNKlqJVm5cK8Irb6QQTlh6as0OvlY1lsGf5GPohyJ4rdXF29bnl7l7ExBQrMmv6Xps5m90WZCgoulZArdYGUIZCiFR8nZBIrwAcjv4lU1D96v91iNq3QKOJQyeTh0K'
			)
		);
		
		return $clients[$client];
	}
}