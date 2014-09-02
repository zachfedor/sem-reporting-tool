<?php

class RankingHighlightsComponent extends SimpleComponent
{
	protected $keywords;
	
	function __construct( $keywords=array() )
	{
		$this->keywords = $keywords;
	}

	public function get_keywords()
	{
	    return $this->keywords;
	}
}