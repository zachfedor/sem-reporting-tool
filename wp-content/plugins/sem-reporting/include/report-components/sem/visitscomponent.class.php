<?php

class VisitsComponent extends SimpleComponent
{
	protected $total_visits, $visits;
	
	function __construct( $total_visits=0, $visits=array() )
	{
		$this->total_visits = $total_visits;
		$this->visits = $visits;
	}

	public function get_total_visits()
	{
	    return $this->total_visits;
	}

	public function get_visits()
	{
	    return $this->visits;
	}
}