<?php

class CompetitorMention extends SimpleComponent
{
	protected $page_url, $date;
	
	function __construct( $page_url='', $date='' )
	{
		$this->page_url = $page_url;
		$this->date = $date;
	}
}