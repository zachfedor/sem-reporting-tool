<?php
require_once __DIR__ . '/../wrappers/twitter-api-php-master/TwitterAPIExchange.php';

class Twitter
{
	public static function get_data()
	{
		/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
		$settings = array(
			'oauth_access_token' => "455221932-oy8lTdWFWz9wVLf9HbDt5SgvQjRMpXzhsUjghaaB",
			'oauth_access_token_secret' => "VFwPQaMuKiWA95Rby17sn0cNgHcLxVwWZOMZlzV8cffvq",
			'consumer_key' => "Q49HD2RjoUJqbxgCiAShj9zKx",
			'consumer_secret' => "ZJXIlqzkOGFOEudq5Ucsg3dZzkykok5bkGnNCO26tFMxDhRoy2"
		);
		
		//set up the twitter api wrapper
		/** Perform a GET request and echo the response **/
		/** Note: Set the GET field BEFORE calling buildOauth(); **/
		$getfield = '?screen_name=towermarketing';
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
		
		//make the twitter report component and return it
		$twitter_component = new TwitterComponent( $total_followers, $total_following );
		
		return $twitter_component;
	}
}