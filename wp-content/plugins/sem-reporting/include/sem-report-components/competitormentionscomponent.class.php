<?php

class CompetitorMentionsComponent extends SimpleComponent
{
	protected $competitor_mentions;
	
	function __construct( $competitor_mentions=array() )
	{
		$this->competitor_mentions = $competitor_mentions;
	}
}