<?php

class FacebookPost extends SimpleComponent
{
	protected $content;
	
	function __construct( $content='' )
	{
		$this->content = $content;
	}
}