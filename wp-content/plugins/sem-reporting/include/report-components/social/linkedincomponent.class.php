<?php

class LinkedInComponent extends SimpleComponent
{
	protected $total_followers, $new_followers, $impressions_rate, $engagement, $post_stats;
	
	function __construct( $total_followers=0, $new_followers=0, $impressions_rate=0, $engagement=0, $post_stats=array() )
	{
		$this->total_followers = $total_followers;
		$this->new_followers = $new_followers;
		$this->impressions_rate = $impressions_rate;
		$this->engagement = $engagement;
		$this->post_stats = $post_stats;
	}
	
	public static function get_from_serialized_array( $serialized_array )
	{
		$unserialized_array = unserialize( $serialized_array );
		
		return self::get_from_array( $unserialized_array );
	}
	
	public static function get_from_array( $arr )
	{
		$post_stats = array();
		foreach( $arr['post_stats'] as $post_stat )
		{
			$post_stats[] = new LinkedInPostStats( $post_stat['content'], $post_stat['post_date'], $post_stat['audience']
				, $post_stat['sponsored'], $post_stat['impressions'], $post_stat['clicks'], $post_stat['interactions']
				, $post_stat['followers_acquired'], $post_stat['engagement'] );
		}
		
		return new self( $arr['total_followers'], $arr['new_followers'], $arr['impressions_rate'], $arr['engagement'], $post_stats );
	}

	public function get_total_followers()
	{
	    return $this->total_followers;
	}

	public function get_new_followers()
	{
	    return $this->new_followers;
	}

	public function get_impressions_rate()
	{
	    return $this->impressions_rate;
	}

	public function get_engagement()
	{
	    return $this->engagement;
	}

	public function get_post_stats()
	{
	    return $this->post_stats;
	}
}