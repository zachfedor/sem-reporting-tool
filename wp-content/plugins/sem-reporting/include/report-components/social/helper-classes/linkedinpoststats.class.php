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

	public function get_content()
	{
	    return $this->content;
	}

	public function get_post_date()
	{
	    return $this->post_date;
	}

	public function get_audience()
	{
	    return $this->audience;
	}

	public function get_sponsored()
	{
	    return $this->sponsored;
	}

	public function get_impressions()
	{
	    return $this->impressions;
	}

	public function get_clicks()
	{
	    return $this->clicks;
	}

	public function get_interactions()
	{
	    return $this->interactions;
	}

	public function get_followers_acquired()
	{
	    return $this->followers_acquired;
	}

	public function get_engagement()
	{
	    return $this->engagement;
	}
}