<?php

class CompetitorLinkMetricsComponent extends SimpleComponent
{
	protected $competitor_link_metrics;
	
	function __construct( $competitor_link_metrics=array() )
	{
		$this->competitor_link_metrics = $competitor_link_metrics;
	}
}