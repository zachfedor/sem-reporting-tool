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
		if ( strpos( $this->link, 'www.') === 0 )
		{
			return substr( $this->link, 4 );
		}
	    return $this->link;
	}

	public function get_metrics()
	{
	    return $this->metrics;
	}
}