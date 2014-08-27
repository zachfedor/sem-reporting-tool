<?php

class TwitterComponent extends SimpleComponent
{
	protected $total_followers, $total_following;
	
	function __construct( $total_followers, $total_following )
	{
		$this->total_followers = $total_followers;
		$this->total_following = $total_following;
	}
}