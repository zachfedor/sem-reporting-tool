<?php

class CompetitorLinkMetric extends SimpleComponent
{
	protected $name, $link, $metrics;
	
	function __construct( $name='', $link='', $metrics=array() )
	{
		$this->name = $name;
		$this->link = $link;
		$this->metrics = $metrics;
	}
}