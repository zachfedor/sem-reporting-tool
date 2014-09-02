<?php

class FacebookComponent extends SimpleComponent
{
	protected $total_likes, $total_reach, $top_ten_posts;
	
	function __construct( $total_likes=0, $total_reach=0, $top_ten_posts=array() )
	{
		$this->total_likes = $total_likes;
		$this->total_reach = $total_reach;
		$this->top_ten_posts = $top_ten_posts;
	}

	public function get_total_likes()
	{
	    return $this->total_likes;
	}

	public function get_total_reach()
	{
	    return $this->total_reach;
	}

	public function get_top_ten_posts()
	{
	    return $this->top_ten_posts;
	}
}