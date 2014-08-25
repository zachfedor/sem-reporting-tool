<?php

class CompetitorLinkMetric extends SimpleHelper
{
	protected $name, $link, $metrics;
	
	function __construct( $name='', $link='', $metrics=array() )
	{
		$this->name = $name;
		$this->link = $link;
		$this->metrics = $metrics;
	}
}