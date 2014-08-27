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
}