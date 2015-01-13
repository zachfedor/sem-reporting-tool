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
	
	public static function get_by_client( $client )
	{
		return YouTubeDemographics::get_component( $client );
	}
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json );
		
		return self::get_from_array( $arr );
	}
	
	public static function get_from_array( $arr )
	{
		$demographics = array();
		foreach ( $arr['demographics'] as $demographic )
		{
			$demographics[] = new YouTubeDemographics( $demographic['views'], $demographic['estimated_minutes_watched']
				, $demographic['new_subscribers'], $demographic['likes'], $demographic['dislikes'], $demographic['comments']
				, $demographic['shares'], $demographic['favorites_added'], $demographic['favorites_removed']
				, $demographic['age_of_subscribers'] );
		}
		
		return new self( $arr['total_views'], $arr['total_subscribers'], $demographics );
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