<?php
require_once __DIR__ . '/../wrappers/twitter-api-php-master/TwitterAPIExchange.php';

class Twitter
{
	public static function get_component( $client )
	{
		$data = self::get_data( $client );

		return new TwitterComponent( $data['followers'], $data['following'] );
	}
	
	private static function get_data( $client )
	{
		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$creds = self::get_client_creds( $client );
		
		$settings = array(
			'oauth_access_token' => $creds['oauth_access_token']
			, 'oauth_access_token_secret' =>$creds['oauth_access_token_secret'] 
			, 'consumer_key' => $creds['consumer_key']
			, 'consumer_secret' => $creds['consumer_secret']
		);
		
		//set up the twitter api wrapper
		/** Perform a GET request and echo the response **/
		/** Note: Set the GET field BEFORE calling buildOauth(); **/
		$getfield = '?screen_name=' . $creds['screen_name'];
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange( $settings );
		
		//get the number of accounts following
		$url = 'https://api.twitter.com/1.1/followers/ids.json';
		$followers = $twitter->setGetfield( $getfield )
			->buildOauth( $url, $requestMethod )
			->performRequest();
		
		$followers = json_decode( $followers );
		$total_followers = count( $followers->ids );
		
		//get the number of accounts following
		$url = 'https://api.twitter.com/1.1/friends/ids.json';
		$friends = $twitter->setGetfield( $getfield )
			->buildOauth( $url, $requestMethod )
			->performRequest();
		
		$following = json_decode( $friends );
		$total_following = count( $following->ids );
		
		$data = array(
			'following'	=>	$total_following
			, 'followers'	=>	$total_followers
		);
		
		return $data;
	}
	
	//don't have separate credentials for each client
	private function get_client_creds( $client )
	{
		$creds = array(
			'oauth_access_token' => '455221932-oy8lTdWFWz9wVLf9HbDt5SgvQjRMpXzhsUjghaaB'
			, 'oauth_access_token_secret' => 'VFwPQaMuKiWA95Rby17sn0cNgHcLxVwWZOMZlzV8cffvq'
			, 'consumer_key' => 'Q49HD2RjoUJqbxgCiAShj9zKx'
			, 'consumer_secret' => 'ZJXIlqzkOGFOEudq5Ucsg3dZzkykok5bkGnNCO26tFMxDhRoy2'
		);
		
		$clients = array(
			'tower'	=>	array(
				'screen_name'	=>	'towermarketing'
			)
			, 'perkypet'	=>	array(
				'screen_name'	=>	'PerkyPetFeeders'
			)
			, 'lrrcu'	=>	array(
				'screen_name'	=>	'LANCREDROSE'
			)
			, 'ninjaflex'	=>	array(
				'screen_name'	=>	'NinjaFlex3D'
			)
		);
		
		$creds = array_merge( $creds, $clients[$client] );
		
		return $creds;
	}
}