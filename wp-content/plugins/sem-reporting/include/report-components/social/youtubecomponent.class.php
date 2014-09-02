<?php

class YouTubeComponent extends SimpleComponent
{
	protected $total_views, $total_subscribers, $demographics;
	
	function __construct( $total_views=0, $total_subscribers=0, $demographics=null )
	{
		$this->total_views = $total_views;
		$this->total_subscribers = $total_subscribers;
		
		if ( $demographics == null )
		{
			$demographics = new YouTubeDemographics();
		}
		
		$this->demographics = $demographics;
	}

	public function get_total_views()
	{
	    return $this->total_views;
	}

	public function get_total_subscribers()
	{
	    return $this->total_subscribers;
	}

	public function get_demographics()
	{
	    return $this->demographics;
	}
}