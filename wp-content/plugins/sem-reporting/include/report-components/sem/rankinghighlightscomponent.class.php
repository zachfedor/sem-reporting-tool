<?php

class RankingHighlightsComponent extends SimpleComponent
{
	protected $keywords;
	
	function __construct( $keywords=array() )
	{
		$this->keywords = $keywords;
	}
}