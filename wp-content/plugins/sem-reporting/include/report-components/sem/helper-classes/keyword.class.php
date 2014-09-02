<?php

class Keyword extends SimpleComponent
{
	protected $keyword, $from, $to;
	
	function __construct( $keyword='', $from=0, $to=0 )
	{
		$this->keyword = $keyword;
		$this->from = $from;
		$this->to = $to;
	}

	public function get_keyword()
	{
	    return $this->keyword;
	}

	public function get_from()
	{
	    return $this->from;
	}

	public function get_to()
	{
	    return $this->to;
	}
}