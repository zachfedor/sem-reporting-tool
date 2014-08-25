<?php

class Keyword extends SimpleHelper
{
	protected $keyword, $from, $to;
	
	function __construct( $keyword='', $from=0, $to=0 )
	{
		$this->keyword = $keyword;
		$this->from = $from;
		$this->to = $to;
	}
}