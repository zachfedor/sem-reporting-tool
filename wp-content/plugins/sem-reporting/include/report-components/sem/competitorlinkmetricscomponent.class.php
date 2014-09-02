<?php

class CompetitorLinkMetricsComponent extends SimpleComponent
{
	protected $link_metrics, $competitor_link_metrics;
	
	function __construct( $link_metrics=null, $competitor_link_metrics=array() )
	{
		if ( $link_metrics != null )
		{
			$this->link_metrics = $link_metrics;
		}
		else
		{
			$this->link_metrics = new LinkMetrics();
		}
		$this->competitor_link_metrics = $competitor_link_metrics;
	}
	
	public function get_link_metrics()
	{
		return $this->link_metrics;
	}

	public function get_competitor_link_metrics()
	{
	    return $this->competitor_link_metrics;
	}
}