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
			$top_ten_posts[] = new FacebookPost( $post['content'], $post['engagement_rate'], $post['reach'], $post['created_time'] );
		}
		
		return new FacebookComponent( $data['total_likes'], $data['total_reach'], $data['reach_breakdown'], $top_ten_posts );
	}
	
	private static function get_data( $client )
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

		date_default_timezone_set( 'America/New_York' );
		
		$since = strtotime( '12:00am last day of last month' );
		
		//request for page likes
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/insights/page_fans?since=' . $since );
		$class_name = GraphUser::className();
		$likes_response = $request->execute()->getGraphObject( $class_name )->asArray();
		$total_likes = $likes_response['data'][0]->values[0]->value;

		//request for total page reach
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/insights/page_impressions/days_28?since=' . $since );
		$total_reach_response = $request->execute()->getGraphObject( $class_name )->asArray();
		$total_reach = $total_reach_response['data'][0]->values[0]->value;

		//request for page reach
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/insights/page_impressions_frequency_distribution/days_28?since=' . $since );
		$reach_breakdown_response = $request->execute()->getGraphObject( $class_name )->asArray();
		$reach_breakdown_obj = $reach_breakdown_response['data'][0]->values[0]->value;
		$reach_breakdown = array();
		$obj_vars = get_object_vars( $reach_breakdown_obj );
		foreach ( $obj_vars as $key => $val )
		{
			$reach_breakdown[$key] = $val;
		}
		
		$posts = array();
		
		//request for posts
		$request = new FacebookRequest( $session, 'GET', '/' . $creds['page_id'] . '/posts?limit=60' );
		$post_list = $request->execute()->getGraphObject( $class_name )->asArray();
		foreach ( $post_list['data'] as $facebook_post )
		{
			if ( strtotime( $facebook_post->created_time ) > strtotime( 'first day of last month')
				&& strtotime( $facebook_post->created_time ) < strtotime( 'first day of this month') )
			{
				$request = new FacebookRequest( $session, 'GET', '/' . $facebook_post->id . '/insights/post_impressions_unique/lifetime' );
				$post_reach = $request->execute()->getGraphObject( $class_name )->asArray();
				$reach = $post_reach['data'][0]->values[0]->value;
	
				$request = new FacebookRequest( $session, 'GET', '/' . $facebook_post->id . '/insights/post_engaged_users/lifetime' );
				$post_engaged_users = $request->execute()->getGraphObject( $class_name )->asArray();
				$engaged_users = $post_engaged_users['data'][0]->values[0]->value;
				
				if ( $reach > 0 )
				{
					$engagement_rate = round( $engaged_users / $reach * 100 ) / 100;
				}
				else
				{
					$engagement_rate = 0;
				}
				
				$posts[] = array(
					'content'	=>	$facebook_post->message
					, 'engagement_rate'	=>	$engagement_rate
					, 'reach'	=>	$reach
					, 'created_time'	=>	$facebook_post->created_time
				);
			}

		}
		
		foreach ($posts as $key => $post) {
		    $contents[$key]  = $post['content'];
		    $engagement_rates[$key] = $post['engagement_rate'];
		    $reaches[$key] = $post['reach'];
		    $created_times[$key] = $post['created_time'];
		}
		
		array_multisort( $engagement_rates, SORT_DESC, $contents, $created_times );
		
		foreach ( $engagement_rates as $key => $engagement_rate )
		{
			$top_ten_posts[] = array(
				'content'	=>	$contents[$key]
				, 'engagement_rate'	=>	$engagement_rates[$key]
				, 'reach'	=>	$reaches[$key]
				, 'created_time'	=>	$created_times[$key]
			);
		}
		
		$top_ten_posts = array_slice( $top_ten_posts, 0, 10 );
		
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