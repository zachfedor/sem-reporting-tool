<?php

class CompetitorMention extends SimpleComponent
{
	protected $page_url, $date;
	
	function __construct( $page_url='', $date='' )
	{
		$this->page_url = $page_url;
		$this->date = $date;
	}

	public function get_page_url()
	{
	    return $this->page_url;
	}

	public function get_date()
	{
	    return $this->date;
	}
}