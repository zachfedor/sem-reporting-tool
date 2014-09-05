<?php

class FacebookPost extends SimpleComponent
{
	protected $content, $engagement, $reach;
	
	function __construct( $content='', $engagement=0, $reach=0 )
	{
		$this->content = $content;
	}

	public function get_content()
	{
	    return $this->content;
	}

	public function get_engagement()
	{
	    return $this->engagement;
	}

	public function get_reach()
	{
	    return $this->reach;
	}
}