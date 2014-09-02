<?php

class LinkMetrics extends SimpleComponent
{
	protected $link, $metrics;
	
	function __construct( $link='', $metrics=array() )
	{
		$this->link = $link;
		$this->metrics = $metrics;
	}

	public function get_link()
	{
	    return $this->link;
	}

	public function get_metrics()
	{
	    return $this->metrics;
	}
}