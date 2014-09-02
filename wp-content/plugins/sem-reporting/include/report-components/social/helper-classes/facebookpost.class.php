<?php

class FacebookPost extends SimpleComponent
{
	protected $content;
	
	function __construct( $content='' )
	{
		$this->content = $content;
	}

	public function get_content()
	{
	    return $this->content;
	}
}