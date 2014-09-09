<?php

class FacebookPost extends SimpleComponent
{
	protected $content, $engagement, $reach, $created_time;
	
	function __construct( $content='', $engagement=0, $reach=0, $created_time='' )
	{
		$this->content = $content;
		$this->engagement = $engagement;
		$this->reach = $reach;
		$this->created_time = $created_time;
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

	public function get_created_time()
	{
	    return $this->created_time;
	}
}