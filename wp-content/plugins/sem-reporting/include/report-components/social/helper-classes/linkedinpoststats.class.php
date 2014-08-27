<?php

class LinkedInPostStats extends SimpleComponent
{
	protected $content, $post_date, $audience, $sponsored, $impressions
		, $clicks, $interactions, $followers_acquired, $engagement; 
	
	function __construct( $content='', $post_date='', $audience='', $sponsored='', $impressions=0
		, $clicks=0, $interactions=0, $followers_acquired=0, $engagement=0 )
	{
		$this->content = $content;
		$this->post_date = $post_date;
		$this->audience = $audience;
		$this->sponsored = $sponsored;
		$this->impressions = $impressions;
		$this->clicks = $clicks;
		$this->interactions = $interactions;
		$this->followers_acquired = $followers_acquired;
		$this->engagement = $engagement;
	}
}