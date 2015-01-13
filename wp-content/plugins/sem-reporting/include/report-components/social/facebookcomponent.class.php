<?php

class FacebookComponent extends SimpleComponent
{
	protected $total_likes, $total_reach, $reach_breakdown, $top_ten_posts;
	
	function __construct( $total_likes=0, $total_reach=0, $reach_breakdown=array(), $top_ten_posts=array() )
	{
		$this->total_likes = $total_likes;
		$this->total_reach = $total_reach;
		$this->reach_breakdown = $reach_breakdown;
		$this->top_ten_posts = $top_ten_posts;
	}
	
	public static function get_by_client( $client )
	{
		return Facebook::get_component( $client );
	}
	
	public static function get_from_json( $json )
	{
		$arr = json_decode( $json, true );
		
		return self::get_from_array( $arr );
	}
	
	public static function get_from_array( $arr )
	{
		$top_ten_posts = array();
		foreach( $arr['top_ten_posts'] as $post )
		{
			$top_ten_posts[] = new FacebookPost( $post['content'], $post['engagement'], $post['reach'], $post['created_time'] );
		}
		
		return new self( $arr['total_likes'], $arr['total_reach'], $arr['reach_breakdown'], $top_ten_posts );
	}

	public function get_total_likes()
	{
	    return $this->total_likes;
	}

	public function get_total_reach()
	{
	    return $this->total_reach;
	}

	public function get_reach_breakdown()
	{
	    return $this->reach_breakdown;
	}

	public function get_top_ten_posts()
	{
	    return $this->top_ten_posts;
	}
}