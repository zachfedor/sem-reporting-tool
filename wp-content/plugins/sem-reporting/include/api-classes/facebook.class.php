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
	
	public static function get_component( $client )
	{
		$data = self::get_data( $client );
		
		$top_ten_posts = array();
		foreach ( $data['top_ten_posts'] as $post )
		{
			$top_ten_posts[] = new FacebookPost( $content, $post['engagement_rate'], $post['reach'] );
		}
		
		return new FacebookComponent( $data['total_likes'], $data['total_reach'], $data['reach_breakdown'], $top_ten_posts );
	}
	
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

		$since = strtotime( '12:00am last day of last month' );
		
		//request for page likes
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/insights/page_fans?since=' . $since );
		$class_name = GraphUser::className();
		$likes_response = $request->execute()->getGraphObject( $class_name )->asArray();
		$total_likes = $likes_response['data'][0]->values[0]->value;

		//request for total page reach
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/insights/page_impressions/days_28?since=' . $since );
		$class_name = GraphUser::className();
		$total_reach_response = $request->execute()->getGraphObject( $class_name )->asArray();
		$total_reach = $total_reach_response['data'][0]->values[0]->value;

		//request for page reach
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/insights/page_impressions_frequency_distribution/days_28?since=' . $since );
		$class_name = GraphUser::className();
		$reach_breakdown_response = $request->execute()->getGraphObject( $class_name )->asArray();
		$reach_breakdown_obj = $reach_breakdown_response['data'][0]->values[0]->value;
		$reach_breakdown = array();
		$obj_vars = get_object_vars( $reach_breakdown_obj );
		foreach ( $obj_vars as $key => $val )
		{
			$reach_breakdown[$key] = $val;
		}
		
		//request for posts
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/posts' );
		$class_name = GraphUser::className();
		$post_list = $request->execute()->getGraphObject( $class_name )->asArray();
		$top_ten_posts = array();
		
		$data = array(
			'total_likes'	=>	$total_likes
			, 'total_reach'	=>	$total_reach
			, 'reach_breakdown'	=>	$reach_breakdown
			, 'top_ten_posts'	=>	$top_ten_posts
		);
	
		return $data;
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
			, 'continental'	=>	array(
				'page_id'	=>	'ContinentalPress'
				, 'access_token'	=>	'CAADkcMfuOKMBAB2lfj1nfRvJsqmjTVB2UTC1nkua281jir8KDOgXEJT83v6f4Sr3vIi5lzc2UctJ0nnZB51V8yTgLYaZAHAbtbZB7HhGUgfpUafeVCguBp3p1HtIB7UMh8iCJtQd9ZAcOKZAykVcmGE09htGIBTecgMjltvqdhWg6RveF24ND'
			)
		);
		
		return $clients[$client];
	}
}